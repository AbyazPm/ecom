<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

// ===============================
// 🧱 Semua route wajib login
// ===============================

Route::get('/', function () {return view('landing');})->name('landing');

Route::middleware(['auth'])->group(function () {

    // Halaman utama belanja & detail produk
    Route::get('/home', [ProductController::class, 'index'])->name('home');
    Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.show');

    // Keranjang
    Route::get('/cart', [ProductController::class, 'cart'])->name('cart.show');
    Route::post('/cart/add/{id}', [ProductController::class, 'addToCart'])->name('cart.add');
    Route::get('/cart/remove/{id}', [ProductController::class, 'removeFromCart'])->name('cart.remove');

    // Checkout
    Route::get('/checkout', [ProductController::class, 'checkoutForm'])->name('checkout.form');
    Route::post('/checkout', [ProductController::class, 'checkoutProcess'])->name('checkout.process');

    // Wishlist (tetap di ProductController)
    Route::get('/wishlist', [ProductController::class, 'wishlist'])->name('wishlist.show');
    Route::post('/wishlist/add/{id}', [ProductController::class, 'addToWishlist'])->name('wishlist.add');
    Route::get('/wishlist/remove/{id}', [ProductController::class, 'removeWishlist'])->name('wishlist.remove');

    // Riwayat pesanan user
    Route::get('/orders', [ProductController::class, 'orders'])->name('orders.list');

    Route::get('/orders/invoice/{id}', [ProductController::class, 'invoice'])->name('orders.invoice');

});


// ===============================
// 🛠 Route Admin
// ===============================
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products/store', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/edit/{id}', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/update/{id}', [ProductController::class, 'update'])->name('products.update');
    Route::get('/products/destroy/{id}', [ProductController::class, 'destroy'])->name('products.destroy');

    Route::get('/laporan/penjualan', [ProductController::class, 'laporanPenjualan'])->name('reports.products');
    Route::get('/dashboard-admin', [ProductController::class, 'dashboardAdmin'])->name('admin.dashboard');
    Route::get('/admin/orders', [ProductController::class, 'adminOrders'])->name('admin.orders');
    Route::post('/admin/orders/status/{id}', [ProductController::class, 'updateStatus'])->name('admin.orders.status');

});


// ===============================
// 🧭 Dashboard Breeze
// ===============================
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/auth.php';
