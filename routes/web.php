<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BurgerController;
use App\Http\Controllers\CommandeController;
use App\Http\Controllers\Clients\CommandeClientController;
use App\Http\Controllers\PaiementController;
use App\Http\Controllers\FactureController;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\UtilisateurController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Clients\PanierController;
use App\Http\Controllers\DashboardController;

Route::get('/', [RestaurantController::class, 'index'])->name('restaurant');

Route::get('/panier', [PanierController::class, 'index'])->name('panier.index');
Route::post('/panier/ajouter', [PanierController::class, 'ajouter'])->name('panier.ajouter');
Route::post('/panier/modifier', [PanierController::class, 'modifier'])->name('panier.modifier');
Route::delete('/panier/supprimer/{id}', [PanierController::class, 'supprimer'])->name('panier.supprimer');
Route::post('/panier/vider', [PanierController::class, 'vider'])->name('panier.vider');

Route::get('/login', function () {
    return view('auth.login');
});



Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'password'])->name('password.update');
    // Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
});

// Route::middleware('auth')->group(function () {
//     Route::get('/dashboarduser', [DashboardController::class, 'index'])->name('dashboard.index');  
// });

Route::middleware('auth')->group(function () {
    Route::get('/commande_client', [CommandeClientController::class, 'index'])->name('commande_client.index');  
    Route::get('/commande', [CommandeClientController::class, 'create'])->name('commande_client.create');
    Route::post('/commande', [CommandeClientController::class, 'store'])->name('commande_client.store'); 
});

Route::middleware('auth')->group(function () {
    Route::get('burgers', [BurgerController::class, 'index'])->name('burgers.index');
    Route::post('burgers', [BurgerController::class, 'store'])->name('burgers.store');
    Route::get('burgers/{id}/edit', [BurgerController::class, 'edit'])->name('burgers.edit');
    Route::put('burgers/{id}', [BurgerController::class, 'update'])->name('burgers.update');
    Route::delete('burgers/{id}', [BurgerController::class, 'destroy'])->name('burgers.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('commandes', [CommandeController::class, 'index'])->name('commandes.index');
    Route::post('commandes', [CommandeController::class, 'store'])->name('commandes.store');
    Route::put('/commandes/{commande}', [CommandeController::class, 'update'])->name('commandes.update');
});

Route::middleware('auth')->group(function () {
    
    Route::get('factures/{id}', [FactureController::class, 'show'])->name('factures.show');
});



Route::middleware('auth')->group(function () {
    Route::get('/restaurant/edit', [RestaurantController::class, 'edit'])->name('restaurant.edit');
    Route::put('/restaurant/update', [RestaurantController::class, 'update'])->name('restaurant.update');
});


Route::middleware('auth')->group(function () {
    Route::get('paiements', [PaiementController::class, 'index'])->name('paiements.index');
});

Route::middleware('auth')->group(function () {
    Route::get('/utilisateurs', [UtilisateurController::class, 'index'])->name('utilisateurs.index');
    Route::post('/utilisateurs', [UtilisateurController::class, 'store'])->name('utilisateurs.store');
    // Route::put('/utilisateurs/{user}/status', [UserStatusController::class, 'update'])->name('users.status.update');
});

require __DIR__.'/auth.php';
