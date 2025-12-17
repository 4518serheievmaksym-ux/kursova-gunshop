<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\WeaponController;
use App\Http\Controllers\TradeController;
use App\Http\Controllers\StashController;
use App\Http\Controllers\DossierController;
use App\Http\Controllers\HQController;
use App\Http\Controllers\CategoryController;

Auth::routes();

// --- ГОЛОВНА ---
Route::get('/', [WeaponController::class, 'index'])->name('home');

// --- ГРУПА АДМІНІСТРАТОРА (Має бути ВИЩЕ, ніж публічні маршрути товарів) ---
Route::middleware(['auth', 'admin'])->group(function () {
    // Штаб
    Route::get('/admin', [HQController::class, 'index'])->name('admin.index');
    
    // Категорії
    Route::resource('categories', CategoryController::class);
    
    // Товари (Створення, Редагування, Видалення)
    // Важливо: це створює маршрут /products/create
    Route::resource('products', WeaponController::class)->except(['index', 'show']);
});

// --- ГРУПА КОРИСТУВАЧА (CART, WISHLIST) ---
Route::middleware(['auth'])->group(function () {
    Route::get('/cart', [TradeController::class, 'index'])->name('cart.index');
    Route::get('/cart/add/{id}', [TradeController::class, 'addToCart'])->name('cart.add');
    Route::delete('/cart/remove', [TradeController::class, 'remove'])->name('cart.remove');

    Route::get('/wishlist', [StashController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist/toggle/{id}', [StashController::class, 'toggle'])->name('wishlist.toggle');

    Route::get('/profile', [DossierController::class, 'index'])->name('profile.index');
});

// --- ПУБЛІЧНІ МАРШРУТИ ТОВАРІВ (Ставимо в самий низ!) ---
// Якщо поставити їх вище, вони перехоплять /products/create
Route::get('/products', [WeaponController::class, 'index'])->name('products.index');
Route::get('/products/{product}', [WeaponController::class, 'show'])->name('products.show');