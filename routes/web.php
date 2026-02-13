<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProduitsController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\InventaireController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\PublicReservationController;
use Illuminate\Support\Facades\Route;

// Routes publiques
Route::get('/', [PublicController::class, 'accueil'])->name('accueil');
Route::get('/produits', [PublicController::class, 'produits'])->name('produits');
Route::get('/produit/{id}', [PublicController::class, 'produitDetail'])->name('produit.detail');
Route::get('/services', [PublicController::class, 'services'])->name('services');
Route::get('/contact', [PublicController::class, 'contact'])->name('contact');
Route::post('/contact', [MessageController::class, 'store'])->name('contact.store');

// Routes pour la reservation publique avec paiement Stripe
Route::get('/reserver', [PublicReservationController::class, 'index'])->name('booking.index');
Route::get('/reserver/dates', [PublicReservationController::class, 'getReservedDates'])->name('booking.dates');
Route::get('/reserver/check-date', [PublicReservationController::class, 'checkDate'])->name('booking.check');
Route::post('/reserver/checkout', [PublicReservationController::class, 'createCheckout'])->name('booking.checkout');
Route::get('/reserver/success', [PublicReservationController::class, 'success'])->name('booking.success');
Route::get('/reserver/cancel', [PublicReservationController::class, 'cancel'])->name('booking.cancel');
Route::post('/stripe/webhook', [PublicReservationController::class, 'webhook'])->name('stripe.webhook');

// Route admin secrète pour les produits
Route::get('/30032006', [ProduitsController::class, 'index'])->name('admin.produits');
Route::post('/30032006/create', [ProduitsController::class, 'create'])->name('admin.produits.create');
Route::get('/30032006/produit/{id}/edit', [ProduitsController::class, 'edit'])->name('admin.produits.edit');
Route::put('/30032006/produit/{id}', [ProduitsController::class, 'update'])->name('admin.produits.update');
Route::delete('/30032006/produit/{id}', [ProduitsController::class, 'destroy'])->name('admin.produits.destroy');
Route::delete('/30032006/image/{id}', [ProduitsController::class, 'deleteImage'])->name('admin.image.delete');
Route::post('/30032006/produits/ordre', [ProduitsController::class, 'updateOrdre'])->name('admin.produits.ordre');
Route::post('/30032006/produit/{id}/visibility', [ProduitsController::class, 'toggleVisibility'])->name('admin.produits.visibility');

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

// Routes admin pour les messages
Route::prefix('30032006/messagerie')->name('admin.messages.')->group(function () {
    Route::get('/', [MessageController::class, 'index'])->name('index');
    Route::get('/{id}', [MessageController::class, 'show'])->name('show');
    Route::delete('/{id}', [MessageController::class, 'destroy'])->name('destroy');
});
Route::get('/api/messages/unread-count', [MessageController::class, 'unreadCount'])->name('api.messages.unread');

// Routes admin pour l'inventaire
Route::prefix('30032006/inventaire')->name('admin.inventaire.')->group(function () {
    Route::get('/', [InventaireController::class, 'index'])->name('index');
    Route::post('/', [InventaireController::class, 'store'])->name('store');
    Route::put('/{id}', [InventaireController::class, 'update'])->name('update');
    Route::delete('/{id}', [InventaireController::class, 'destroy'])->name('destroy');
    Route::post('/{id}/ajouter', [InventaireController::class, 'ajouterStock'])->name('ajouter');
    Route::post('/{id}/retirer', [InventaireController::class, 'retirerStock'])->name('retirer');
    Route::get('/{id}/historique', [InventaireController::class, 'historique'])->name('historique');
    Route::post('/categories', [InventaireController::class, 'storeCategorie'])->name('categories.store');
    Route::delete('/categories/{id}', [InventaireController::class, 'destroyCategorie'])->name('categories.destroy');
});

// Routes admin pour les reservations
Route::get('/30032006/reservations/login', [ReservationController::class, 'showLogin'])->name('planning.login');
Route::post('/30032006/reservations/login', [ReservationController::class, 'login'])->name('planning.login.post');
Route::get('/30032006/reservations/logout', [ReservationController::class, 'logout'])->name('planning.logout');
Route::get('/30032006/reservations/check-auth', [ReservationController::class, 'checkAuth'])->name('planning.check-auth');
Route::get('/30032006/reservations', [ReservationController::class, 'index'])->name('planning.index');
Route::get('/30032006/reservations/calendar-events', [ReservationController::class, 'calendarEvents'])->name('planning.events');
Route::post('/30032006/reservations/store', [ReservationController::class, 'store'])->name('planning.reservations.store');
Route::get('/30032006/reservations/{id}', [ReservationController::class, 'getReservation'])->name('planning.reservations.get');
Route::put('/30032006/reservations/{id}', [ReservationController::class, 'update'])->name('planning.reservations.update');
Route::patch('/30032006/reservations/{id}/statut', [ReservationController::class, 'updateStatut'])->name('planning.reservations.statut');
Route::delete('/30032006/reservations/{id}', [ReservationController::class, 'destroy'])->name('planning.reservations.destroy');
Route::delete('/30032006/reservations/photos/{id}', [ReservationController::class, 'deletePhoto'])->name('planning.photos.destroy');
Route::post('/30032006/reservations/{id}/produits', [ReservationController::class, 'addProduit'])->name('planning.reservations.produits.store');
Route::delete('/30032006/reservations/{reservationId}/produits/{produitId}', [ReservationController::class, 'removeProduit'])->name('planning.reservations.produits.destroy');
Route::post('/30032006/reservations/services', [ReservationController::class, 'storeService'])->name('planning.services.store');
Route::put('/30032006/reservations/services/{id}', [ReservationController::class, 'updateService'])->name('planning.services.update');
Route::delete('/30032006/reservations/services/{id}', [ReservationController::class, 'destroyService'])->name('planning.services.destroy');
Route::post('/30032006/reservations/services/{id}/items', [ReservationController::class, 'addServiceItem'])->name('planning.services.items.store');
Route::delete('/30032006/reservations/services/items/{id}', [ReservationController::class, 'removeServiceItem'])->name('planning.services.items.destroy');

// Routes pour les dates bloquees
Route::get('/30032006/reservations/dates-bloquees', [ReservationController::class, 'getDatesBloquees'])->name('planning.dates-bloquees');
Route::post('/30032006/reservations/dates-bloquees', [ReservationController::class, 'bloquerDate'])->name('planning.dates-bloquees.store');
Route::delete('/30032006/reservations/dates-bloquees/{id}', [ReservationController::class, 'debloquerDate'])->name('planning.dates-bloquees.destroy');

// Vue publique pour les travailleurs (sans mot de passe)
Route::get('/reservations', [ReservationController::class, 'publicView'])->name('reservations.public');
Route::patch('/reservations/{id}/statut', [ReservationController::class, 'publicUpdateStatut'])->name('reservations.public.statut');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
