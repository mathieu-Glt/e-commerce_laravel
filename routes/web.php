<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('web')->group(function () {
    require __DIR__ . '/auth.php';

    // Ajouter ces routes dans le groupe middleware web
    Route::prefix('cart')->group(function () {
        Route::get('/', [CartController::class, 'index'])->name('cart.index');
        Route::post('/add/{product}', [CartController::class, 'add'])->name('cart.add');
        Route::delete('/remove/{product}', [CartController::class, 'remove'])->name('cart.remove');
        Route::post('/clear', [CartController::class, 'clear'])->name('cart.clear');
        Route::patch('/update/{product}', [CartController::class, 'update'])->name('cart.update');
    });
});

Route::middleware(['auth', 'verified', 'admin'])->group(function () {
    // Dashboard admin redirige vers la liste des produits
    Route::get('/dashboard', function () {
        return redirect()->route('products.index');
    })->name('dashboard');

    // Routes pour les catégories
    Route::resource('categories', CategoryController::class);
    Route::patch('/categories/{category}/toggle-mega', [CategoryController::class, 'toggleMega'])
        ->name('categories.toggle-mega');

    // Routes pour les produits
    Route::resource('products', ProductController::class);
    Route::patch('/products/{product}/toggle-availability', [ProductController::class, 'toggleAvailability'])
        ->name('products.toggle-availability');
});

// Routes publiques pour les produits (accessibles sans authentification)
Route::get('/products/on-sale', [ProductController::class, 'onSale'])->name('products.on-sale');
Route::get('/products/new-arrivals', [ProductController::class, 'newArrivals'])->name('products.new-arrivals');
Route::get('/products/best-sellers', [ProductController::class, 'bestSellers'])->name('products.best-sellers');

Route::middleware(['auth'])->group(function () {
    Route::get('/checkout', [CheckoutController::class, 'create'])->name('checkout.create');
    Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');
    Route::get('/checkout/cancel', [CheckoutController::class, 'cancel'])->name('checkout.cancel');
});
