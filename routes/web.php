<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AnimeController;

Route::get('/', [AnimeController::class, 'index'])->name('animes.index');
Route::get('/index', [AnimeController::class, 'index']);

// Route dynamique pour afficher un animé spécifique
Route::get('/animes/{id}', [AnimeController::class, 'show'])->name('animes.show');
