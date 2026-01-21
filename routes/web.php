<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProduitsController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\ServiceController;
use Illuminate\Support\Facades\Route;

// Routes publiques
Route::get('/', [PublicController::class, 'accueil'])->name('accueil');
Route::get('/produits', [PublicController::class, 'produits'])->name('produits');
Route::get('/produit/{id}', [PublicController::class, 'produitDetail'])->name('produit.detail');
Route::get('/services', [PublicController::class, 'services'])->name('services');
Route::get('/contact', [PublicController::class, 'contact'])->name('contact');

// Route admin secrète pour les produits
Route::get('/30032006', [ProduitsController::class, 'index'])->name('admin.produits');
Route::post('/30032006/create', [ProduitsController::class, 'create'])->name('admin.produits.create');
Route::get('/30032006/produit/{id}/edit', [ProduitsController::class, 'edit'])->name('admin.produits.edit');
Route::put('/30032006/produit/{id}', [ProduitsController::class, 'update'])->name('admin.produits.update');
Route::delete('/30032006/produit/{id}', [ProduitsController::class, 'destroy'])->name('admin.produits.destroy');
Route::delete('/30032006/image/{id}', [ProduitsController::class, 'deleteImage'])->name('admin.image.delete');

// Routes admin pour les services
Route::prefix('30032006/services')->name('services.')->group(function () {
    Route::get('/', [ServiceController::class, 'index'])->name('index');
    Route::get('/create', [ServiceController::class, 'create'])->name('create');
    Route::post('/', [ServiceController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [ServiceController::class, 'edit'])->name('edit');
    Route::put('/{id}', [ServiceController::class, 'update'])->name('update');
    Route::delete('/{id}', [ServiceController::class, 'destroy'])->name('destroy');
    Route::post('/{id}/videos', [ServiceController::class, 'storeVideo'])->name('videos.store');
    Route::delete('/videos/{id}', [ServiceController::class, 'destroyVideo'])->name('videos.destroy');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
