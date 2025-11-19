<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PartenaireController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/partenaires', [PartenaireController::class, 'index'])->name('partenaires.index');

Route::middleware('auth')->group(function () {
    Route::get('/mes-partenaires', [PartenaireController::class, 'mesPartenaires'])->name('partenaires.mes-partenaires');
    Route::get('/partenaires/create', [PartenaireController::class, 'create'])->name('partenaires.create');
    Route::post('/partenaires', [PartenaireController::class, 'store'])->name('partenaires.store');
    Route::get('/partenaires/{partenaire}/edit', [PartenaireController::class, 'edit'])->name('partenaires.edit');
    Route::put('/partenaires/{partenaire}', [PartenaireController::class, 'update'])->name('partenaires.update');
    Route::delete('/partenaires/{partenaire}', [PartenaireController::class, 'destroy'])->name('partenaires.destroy');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Déplacez la route dynamique après les routes statiques pour éviter les conflits
Route::get('/partenaires/{partenaire}', [PartenaireController::class, 'show'])->name('partenaires.show');

require __DIR__.'/auth.php';
// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// Route::get('/partenaires', [PartenaireController::class, 'index'])->name('partenaires.index');
// Route::get('/partenaires/{partenaire}', [PartenaireController::class, 'show'])->name('partenaires.show');

// Route::middleware('auth')->group(function () {


//     Route::get('/mes-partenaires', [PartenaireController::class, 'mesPartenaires'])->name('partenaires.mes-partenaires');
//     Route::get('/partenaires/create', [PartenaireController::class, 'create'])->name('partenaires.create');
//     Route::post('/partenaires', [PartenaireController::class, 'store'])->name('partenaires.store');
//     Route::get('/partenaires/{partenaire}/edit', [PartenaireController::class, 'edit'])->name('partenaires.edit');
//     Route::put('/partenaires/{partenaire}', [PartenaireController::class, 'update'])->name('partenaires.update');
//     Route::delete('/partenaires/{partenaire}', [PartenaireController::class, 'destroy'])->name('partenaires.destroy');
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

