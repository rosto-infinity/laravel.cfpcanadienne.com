<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PartenaireController;

Route::get('/', function () {
    return view('welcome');
});
// Routes publiques
Route::get('/partenaires', [PartenaireController::class, 'index'])->name('partenaires.index');
Route::get('/partenaires/{partenaire}', [PartenaireController::class, 'show'])->name('partenaires.show');

// Routes protégées (nécessite authentification)
Route::middleware(['auth'])->group(function () {
    Route::get('/mes-partenaires', [PartenaireController::class, 'mesPartenaires'])->name('partenaires.mes-partenaires');
    Route::get('/partenaires/create', [PartenaireController::class, 'create'])->name('partenaires.create');
    Route::post('/partenaires', [PartenaireController::class, 'store'])->name('partenaires.store');
    Route::get('/partenaires/{partenaire}/edit', [PartenaireController::class, 'edit'])->name('partenaires.edit');
    Route::put('/partenaires/{partenaire}', [PartenaireController::class, 'update'])->name('partenaires.update');
    Route::delete('/partenaires/{partenaire}', [PartenaireController::class, 'destroy'])->name('partenaires.destroy');
});