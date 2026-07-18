<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\SellerProductController;
use App\Http\Controllers\AdminCatalogController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ── Home ──
Route::get('/', function () {
    return view('welcome');
});

// ── Auth (guests only for forms, logout for logged-in) ──
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ── Public Product Browsing ──
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');

// ── Reviews (public read, auth write) ──
Route::get('/products/{id}/reviews', [ReviewController::class, 'index'])->name('reviews.index');
Route::post('/products/{id}/reviews', [ReviewController::class, 'store'])->middleware(['auth.custom', 'role:customer'])->name('reviews.store');

// ── Customer Routes ──
Route::middleware(['auth.custom', 'role:customer'])->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::put('/cart/update', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');

    Route::post('/orders/checkout', [OrderController::class, 'checkout'])->name('orders.checkout');
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');
});

// ── Seller Routes ──
Route::middleware(['auth.custom', 'role:seller'])->prefix('seller')->group(function () {
    Route::get('/register-shop', [SellerController::class, 'showRegisterShopForm'])->name('seller.register-shop');
    Route::post('/register-shop', [SellerController::class, 'registerShop']);

    Route::get('/products', [SellerProductController::class, 'index'])->name('seller.products.index');
    Route::get('/products/create', [SellerProductController::class, 'create'])->name('seller.products.create');
    Route::post('/products', [SellerProductController::class, 'store'])->name('seller.products.store');
    Route::get('/products/{id}/edit', [SellerProductController::class, 'edit'])->name('seller.products.edit');
    Route::put('/products/{id}', [SellerProductController::class, 'update'])->name('seller.products.update');
    Route::delete('/products/{id}', [SellerProductController::class, 'destroy'])->name('seller.products.destroy');

    Route::get('/orders', [OrderController::class, 'sellerOrders'])->name('seller.orders.index');
    Route::put('/orders/{id}/status', [OrderController::class, 'updateStatus'])->name('seller.orders.updateStatus');
});

// ── Admin Routes ──
Route::middleware(['auth.custom', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/brands', [AdminCatalogController::class, 'brandsIndex'])->name('admin.brands.index');
    Route::get('/brands/create', [AdminCatalogController::class, 'brandsCreate'])->name('admin.brands.create');
    Route::post('/brands', [AdminCatalogController::class, 'brandsStore'])->name('admin.brands.store');
    Route::get('/brands/{id}/edit', [AdminCatalogController::class, 'brandsEdit'])->name('admin.brands.edit');
    Route::put('/brands/{id}', [AdminCatalogController::class, 'brandsUpdate'])->name('admin.brands.update');
    Route::delete('/brands/{id}', [AdminCatalogController::class, 'brandsDestroy'])->name('admin.brands.destroy');

    Route::get('/categories', [AdminCatalogController::class, 'categoriesIndex'])->name('admin.categories.index');
    Route::get('/categories/create', [AdminCatalogController::class, 'categoriesCreate'])->name('admin.categories.create');
    Route::post('/categories', [AdminCatalogController::class, 'categoriesStore'])->name('admin.categories.store');
    Route::get('/categories/{id}/edit', [AdminCatalogController::class, 'categoriesEdit'])->name('admin.categories.edit');
    Route::put('/categories/{id}', [AdminCatalogController::class, 'categoriesUpdate'])->name('admin.categories.update');
    Route::delete('/categories/{id}', [AdminCatalogController::class, 'categoriesDestroy'])->name('admin.categories.destroy');

    Route::get('/orders', [OrderController::class, 'adminOrders'])->name('admin.orders.index');
    Route::put('/orders/{id}/status', [OrderController::class, 'updateStatus'])->name('admin.orders.updateStatus');
});
