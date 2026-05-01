<?php

use App\Http\Controllers\Auth\Login;
use App\Http\Controllers\Auth\Logout;
use App\Http\Controllers\Auth\Register;
use App\Http\Controllers\ChirpController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ChirpController::class,'index']);

// Protect all these routes to allow only authenticated users:
// There is a /login route which is the default redirection
Route::middleware('auth')->group(function () {
    Route::post('/chirps', [ChirpController::class, 'store']);
    Route::get('/chirps/{chirp}/edit', [ChirpController::class, 'edit']);
    Route::put('/chirps/{chirp}', [ChirpController::class, 'update']);
    Route::delete('/chirps/{chirp}', [ChirpController::class, 'destroy']);
});

// Same as above
// Route::resource('/chirps', ChirpController::class)
//     -> only(['store','edit','update','destroy']);

// REGISTER ROUTES
Route::view('/register', 'auth.register') // GET
    ->middleware('guest')
    ->name('register');

Route::post('/register', Register::class)
    ->middleware('guest');

// LOGOUT - only someone who is authenticated can hit this endpoint
Route::post('/logout', Logout::class)
    ->middleware('auth')
    ->name('logout');

// LOGIN
Route::view('/login', 'auth.login')
    ->middleware('guest')
    ->name('login');

Route::post('login', Login::class)
    ->middleware('guest');
