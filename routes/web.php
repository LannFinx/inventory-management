<?php

use App\Http\Controllers\BarangController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SupplierController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/barangs', function () {
    return view('barangs');
})->middleware(['auth', 'verified'])->name('barangs.index');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

Route::middleware(['auth'])->group(function () {

    // Kategori
    Route::get('/kategoris', [KategoriController::class, 'index'])->name('kategoris.index');
    Route::get('/kategoris/create', [KategoriController::class, 'create'])->name('kategoris.create');
    Route::post('/kategoris/store', [KategoriController::class, 'store'])->name('kategoris.store');
    Route::get('/kategoris/{id}/edit', [KategoriController::class, 'edit'])->name('kategoris.edit');
    Route::put('/kategoris/update/{id}', [KategoriController::class, 'update'])->name('kategoris.update');
    Route::delete('/kategoris/{id}', [KategoriController::class, 'destroy'])->name('kategoris.destroy');

    // Supplier
    Route::get('/suppliers', [SupplierController::class, 'index'])->name('suppliers.index');
    Route::get('/suppliers/create', [SupplierController::class, 'create'])->name('suppliers.create');
    Route::post('/suppliers', [SupplierController::class, 'store'])->name('suppliers.store');
    Route::get('/suppliers/{id}/edit', [SupplierController::class, 'edit'])->name('suppliers.edit');
    Route::put('/suppliers/{id}', [SupplierController::class, 'update'])->name('suppliers.update');
    Route::delete('/suppliers/{id}', [SupplierController::class, 'destroy'])->name('suppliers.destroy');

    Route::get('/suppliers/trashed', [SupplierController::class, 'trashed'])->name('suppliers.trashed');
    Route::put('/suppliers/{id}/restore', [SupplierController::class, 'restore'])->name('suppliers.restore');
    Route::delete('/suppliers/{id}/force', [SupplierController::class, 'forceDelete'])->name('suppliers.forceDelete');

    // Barang
    Route::get('/barangs', [BarangController::class, 'index'])->name('barangs.index');
    Route::get('/barangs/create', [BarangController::class, 'create'])->name('barangs.create');
    Route::post('/barangs/store', [BarangController::class, 'store'])->name('barangs.store');
    Route::get('/barangs/{id}/edit', [BarangController::class, 'edit'])->name('barangs.edit');
    Route::put('/barangs/update/{id}', [BarangController::class, 'update'])->name('barangs.update');
    Route::delete('/barangs/{id}', [BarangController::class, 'destroy'])->name('barangs.destroy');

    Route::get('/barangs/trashed', [BarangController::class, 'trashed'])->name('barangs.trashed');
    Route::put('/barangs/{id}/restore', [BarangController::class, 'restore'])->name('barangs.restore');
    Route::delete('/barangs/{id}/force', [BarangController::class, 'forceDelete'])->name('barangs.forceDelete');
});


require __DIR__ . '/auth.php';
