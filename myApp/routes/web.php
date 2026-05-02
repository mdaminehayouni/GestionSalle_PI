<?php

use App\Http\Controllers\chef\DashboardController;
use App\Http\Controllers\GestionEnseignantController;
use App\Http\Controllers\GestionSalleController;
use App\Http\Controllers\GestionSeanceController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');
// les chemins des dashboards
/*Route::get('/chef/dashboard', function () {
    return view('chef.dashboard');
})->name('chef.dashboard')->middleware('auth');*/
Route::get('/chef/dashboard', [DashboardController::class, 'index'])
    ->name('chef.dashboard')->middleware('auth');

Route::get('/enseignant/dashboard', function () {
    return view('enseignant.dashboard');
})->name('enseignant.dashboard')->middleware('auth');

Route::get('/etudiant/dashboard', function () {
    return view('etudiant.dashboard');
})->name('etudiant.dashboard')->middleware('auth');


//enseignant
Route::get('/chef/gestionEnseignant', [GestionEnseignantController::class, 'index'])
    ->name('chef.gestionEnseignant')->middleware('auth');

Route::post('/chef/gestionEnseignant', [GestionEnseignantController::class, 'store'])
    ->name('chef.enseignant.store')->middleware('auth');

Route::delete('/chef/enseignant/{id}', [GestionEnseignantController::class, 'destroy'])
    ->name('chef.enseignant.destroy')->middleware('auth');
//edit routes 
Route::get('/chef/enseignant/{id}/edit', [GestionEnseignantController::class, 'edit'])
    ->name('chef.enseignant.edit');

Route::put('/chef/enseignant/{id}', [GestionEnseignantController::class, 'update'])
    ->name('chef.enseignant.update');
//salle
Route::get('/chef/salle', [GestionSalleController::class, 'index'])
    ->name('chef.gestionSalle');

Route::post('/chef/salle', [GestionSalleController::class, 'store'])->name('chef.salle.store');

Route::put('/chef/salle/{id}', [GestionSalleController::class, 'update'])->name('chef.salle.update');

Route::delete('/chef/salle/{id}', [GestionSalleController::class, 'destroy'])->name('chef.salle.destroy');
//seance
Route::get('/chef/seance', [GestionSeanceController::class, 'index'])
    ->name('chef.gestionSeance');

Route::post('/chef/seance', [GestionSeanceController::class, 'store'])
    ->name('chef.seance.store');

Route::put('/chef/seance/{id}', [GestionSeanceController::class, 'update'])
    ->name('chef.seance.update');

Route::delete('/chef/seance/{id}', [GestionSeanceController::class, 'destroy'])
    ->name('chef.seance.destroy');
Route::get('/salles-disponibles', [GestionSeanceController::class, 'disponibles']);

Route::get('/enseignants-disponibles', [GestionSeanceController::class, 'enseignantsDisponibles']);
//--------------------------------------------------
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
