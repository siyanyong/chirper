<?php

use App\Http\Controllers\Auth\Register;
use App\Http\Controllers\ChirpController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ChirpController::class,'index']);
Route::post('/chirps', [ChirpController::class, 'store']);
Route::get('/chirps/{chirp}/edit', [ChirpController::class, 'edit']);
Route::put('/chirps/{chirp}', [ChirpController::class, 'update']);
Route::delete('/chirps/{chirp}', [ChirpController::class, 'destroy']);

// Same as above
// Route::resource('/chirps', ChirpController::class)
//     -> only(['store','edit','update','destroy']);

// REGISTER ROUTES
Route::view('/register', 'auth.register') // GET
    ->middleware('guest')
    ->name('register');

Route::post('/register', Register::class)
    ->middleware('guest');
