<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\CartController;
use App\Http\Controllers\User;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('items', Admin\ItemController::class);
});

Route::middleware(['auth', 'role:user'])->prefix('user')->name('user.')->group(function () {
    Route::resource('items', User\ItemController::class);
});

// Cart Routes for User Role
Route::middleware(['auth'])->group(function () {
    Route::middleware(['role:user'])->group(function () {
        // Cart Routes
        Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
        Route::post('/cart/add/{id}', [CartController::class, 'addToCart'])->name('cart.add');
        Route::post('/cart/update/{id}', [CartController::class, 'updateCart'])->name('cart.update');
        Route::delete('/cart/remove/{id}', [CartController::class, 'removeFromCart'])->name('cart.remove');
        Route::delete('/cart/clear', [CartController::class, 'clearCart'])->name('cart.clear');

        // Route for Invoice Generation
        Route::post('/cart/invoice', [CartController::class, 'generateInvoice'])->name('cart.invoice');
    });
});

require __DIR__ . '/auth.php';
