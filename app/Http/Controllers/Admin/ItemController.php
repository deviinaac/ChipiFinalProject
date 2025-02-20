<?php

namespace App\Http\Controllers\Admin;

use App\Models\Item;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = Item::all();

        return view('admin.items.index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.items.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:5|max:80',
            'category' => 'required|string',
            'price' => 'required|integer|min:1',
            'quantity' => 'required|integer|min:1',
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle photo upload (required)
        $photoPath = $request->file('photo')->store('images', 'public');

        // Create the new item
        Item::create([
            'name' => $request->input('name'),
            'category' => $request->input('category'),
            'price' => $request->input('price'),
            'quantity' => $request->input('quantity'),
            'photo' => $photoPath,
        ]);

        return redirect()->route('admin.items.index')->with('success', 'Barang berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function show(Item $item)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function edit(Item $item)
    {
        return view('admin.items.edit', compact('item'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Item $item)
    {
        $request->validate([
            'name' => 'required|string|min:5|max:80',
            'category' => 'required|string',
            'price' => 'required|integer|min:1',
            'quantity' => 'required|integer|min:1',
            'photo' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Update item fields
        $item->update([
            'name' => $request->input('name'),
            'category' => $request->input('category'),
            'price' => $request->input('price'),
            'quantity' => $request->input('quantity'),
        ]);

        // Handle photo upload if a new one is provided
        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($item->photo && file_exists(public_path('storage/' . $item->photo))) {
                unlink(public_path('storage/' . $item->photo));
            }

            // Store new photo
            $photoPath = $request->file('photo')->store('images', 'public');
            $item->update(['photo' => $photoPath]);
        }

        return redirect()->route('admin.items.index')->with('success', 'Barang berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function destroy(Item $item)
    {
        // Delete the item from the database
        $item->delete();

        // Redirect back with a success message
        return redirect()->route('admin.items.index')->with('success', 'Barang berhasil dihapus.');
    }
}
