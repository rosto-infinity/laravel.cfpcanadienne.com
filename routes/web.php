<?php

use App\Enums\Role;
use App\Models\Partenaire;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PartenaireController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PartenaireAdminController;

// Page d'accueil avec partenaires approuvés
Route::get('/', function () {
    $partenaires = Partenaire::with('user')
        ->approuves()
        ->latest()
        ->paginate(15);
    return view('welcome', compact('partenaires'));
})->name('welcome');






// Dashboard
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Routes authentifiées pour les utilisateurs (déplacé en haut)
Route::middleware('auth')->group(function () {
    // Gestion des partenaires par les utilisateurs - ROUTES CRUD EN PREMIER
    Route::get('/partenaires/create', [PartenaireController::class, 'create'])->name('partenaires.create');
    Route::post('/partenaires', [PartenaireController::class, 'store'])->name('partenaires.store');
    Route::get('/partenaires/{partenaire}/edit', [PartenaireController::class, 'edit'])->name('partenaires.edit');
    Route::put('/partenaires/{partenaire}', [PartenaireController::class, 'update'])->name('partenaires.update');
    Route::delete('/partenaires/{partenaire}', [PartenaireController::class, 'destroy'])->name('partenaires.destroy');
    
    Route::get('/mes-partenaires', [PartenaireController::class, 'mesPartenaires'])->name('partenaires.mes-partenaires');
    
    // Profil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Routes publiques des partenaires - ROUTE SHOW APRÈS LES CRUD
Route::get('/partenaires', [PartenaireController::class, 'index'])->name('partenaires.index');
Route::get('/partenaires/{partenaire}', [PartenaireController::class, 'show'])->name('partenaires.show');

// Routes SuperAdmin pour la gestion des partenaires
// Route::middleware(['auth', 'verified', 'role:' . Role::superadmin()->value])
Route::middleware(['auth', 'role:superadmin'])
    ->prefix('superadmin')
    ->name('superadmin.')
    ->group(function () {
        // Dashboard superadmin
        Route::get('/dashboard', [DashboardController::class, 'superadmin'])->name('dashboard');
        
        // Gestion des partenaires
        Route::get('/partenaires', [PartenaireAdminController::class, 'index'])->name('partenaires.index');
        Route::get('/partenaires/{partenaire}', [PartenaireAdminController::class, 'show'])->name('partenaires.show');
        Route::patch('/partenaires/{partenaire}/approuver', [PartenaireAdminController::class, 'approuver'])->name('partenaires.approuver');
        Route::patch('/partenaires/{partenaire}/rejeter', [PartenaireAdminController::class, 'rejeter'])->name('partenaires.rejeter');
        Route::delete('/partenaires/{partenaire}', [PartenaireAdminController::class, 'destroy'])->name('partenaires.destroy');
    });

require __DIR__.'/auth.php';