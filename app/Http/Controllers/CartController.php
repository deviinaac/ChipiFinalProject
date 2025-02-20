<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    // Show Cart Page
    public function index()
    {
        $userId = Auth::id(); // Get the logged-in user's ID
        $cart = Session::get("cart_{$userId}", []);
        $cartItems = [];

        foreach ($cart as $itemId => $quantity) {
            $item = Item::find($itemId);
            if ($item) {
                $cartItems[] = [
                    'id' => $item->id,
                    'name' => $item->name,
                    'price' => $item->price,
                    'quantity' => $quantity,
                    'photo' => $item->photo,
                ];
            }
        }

        return view('cart.index', compact('cartItems'));
    }

    // Add Item to Cart
    public function addToCart($id)
    {
        $userId = Auth::id();
        $item = Item::findOrFail($id);
        $cart = Session::get("cart_{$userId}", []);

        // Increment quantity if exists, otherwise add
        if (isset($cart[$id])) {
            $cart[$id]++;
        } else {
            $cart[$id] = 1;
        }

        Session::put("cart_{$userId}", $cart);

        return redirect()->back()->with('success', 'Barang berhasil ditambahkan ke keranjang!');
    }

    // Update Cart Quantity
    public function updateCart(Request $request, $id)
    {
        $userId = Auth::id();
        $cart = Session::get("cart_{$userId}", []);

        if (isset($cart[$id])) {
            $cart[$id] = $request->quantity;
            Session::put("cart_{$userId}", $cart);
        }

        return redirect()->back()->with('success', 'Jumlah barang berhasil diperbarui.');
    }

    // Remove Item from Cart
    public function removeFromCart($id)
    {
        $userId = Auth::id();
        $cart = Session::get("cart_{$userId}", []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            Session::put("cart_{$userId}", $cart);
        }

        return redirect()->back()->with('success', 'Barang berhasil dihapus dari keranjang.');
    }

    // Clear Cart
    public function clearCart()
    {
        $userId = Auth::id();
        Session::forget("cart_{$userId}");

        return redirect()->back()->with('success', 'Keranjang belanja berhasil dikosongkan.');
    }

    // Generate Invoice and Show Print View
    public function generateInvoice(Request $request)
    {
        $request->validate([
            'shipping_address' => 'required|string|max:255',
            'postal_code' => 'required|string|min:5|max:10',
        ]);

        $userId = Auth::id();
        $cart = Session::get("cart_{$userId}", []);
        $cartItems = [];
        $totalPrice = 0;

        foreach ($cart as $itemId => $quantity) {
            $item = Item::find($itemId);
            if ($item) {
                $subtotal = $item->price * $quantity;
                $totalPrice += $subtotal;

                $cartItems[] = [
                    'name' => $item->name,
                    'price' => $item->price,
                    'quantity' => $quantity,
                    'subtotal' => $subtotal,
                ];
            }
        }

        $invoiceNumber = 'INV-' . now()->format('YmdHis') . '-' . strtoupper(substr(Auth::user()->name, 0, 3));

        // Clear cart after generating the invoice
        Session::forget("cart_{$userId}");

        // Pass invoice data to the view
        return view('cart.invoice', [
            'invoiceNumber' => $invoiceNumber,
            'cartItems' => $cartItems,
            'totalPrice' => $totalPrice,
            'shippingAddress' => $request->input('shipping_address'),
            'postalCode' => $request->input('postal_code'),
            'userName' => Auth::user()->name,
        ]);
    }
}
