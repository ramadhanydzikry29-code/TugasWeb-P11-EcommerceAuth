<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

/*
| Route tugas P11. Di-include dari routes/web.php (lihat README).
| Urutan penting: route /posts/create harus terdaftar SEBELUM /posts/{post}.
*/

Route::middleware('auth')->group(function () {
    // Katalog produk (semua user yang login)
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');

    // Posts: tulis/ubah/hapus hanya admin & editor (+ PostPolicy untuk kepemilikan)
    Route::middleware('role:admin,editor')->group(function () {
        Route::resource('posts', PostController::class)->except(['index', 'show']);
    });

    // Posts: baca boleh semua role
    Route::resource('posts', PostController::class)->only(['index', 'show']);
});

// Khusus admin
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('index');
    Route::get('/demo/eager', [ProductController::class, 'eagerDemo'])->name('demo.eager');
});
