<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FavoriteController;

// Welcome route to display all products
Route::get('/', [ProductController::class, 'index'])->name('welcome');

Route::middleware(['auth'])->group(function () {
    // User profile, history, and admin history routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.update-password');
    Route::get('/history', [HistoryController::class, 'index'])->name('history');
    Route::get('/admin/history', [HistoryController::class, 'adminIndex'])->name('admin.history');
    Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites.index');
    Route::post('/favorites/toggle', [FavoriteController::class, 'toggle'])->name('favorites.toggle');

    // Admin routes for product management
    Route::middleware(['admin'])->group(function () {
        Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
        Route::resource('products', ProductController::class)->except(['show', 'index']);
    });

    // Payment routes for processing orders
    Route::post('/payment', [PaymentController::class, 'store'])->name('payment.store');
});

require __DIR__ . '/auth.php';
