<?php

use App\Http\Controllers\ListController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\TvShowsController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/login', [LoginController::class, 'index'])->name('auth/login');
// Route::get('/forgot-password', [LoginController::class, 'forgot_password'])->name('forgot-password');
// Route::post('/forgot-password-act', [LoginController::class, 'forgot_password_act'])->name('forgot-password-act');

// Route::get('/vaidation-forgot-password/{token}', [LoginController::class, 'validation_forgot_password'])->name('validation-forgot-password');
// Route::post('/vaidation-forgot-password-act', [LoginController::class, 'validation_forgot_password_act'])->name('validation-forgot-password-act');

// Route::post('/login-proses', [LoginController::class, 'login_proses'])->name('login-proses');
// Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

// Route::get('/register', [LoginController::class, 'register'])->name('register');
// Route::post('/register-proses', [LoginController::class, 'register_proses'])->name('register-proses');




Route::get('/', [ListController::class, 'index'])->name('layouts/main');
Route::get('/movie', [ListController::class, 'movie'])->name('movie');
Route::get('/movie/{id}', [ListController::class, 'movieDetails'])->name('Movie-Details');
Route::get('/movie/{id}/similar', [ListController::class, 'movieSimilar'])->name('Movie-Similar');

Route::get('/tvshow', [ListController::class, 'tvshow'])->name('Tv-Show');
Route::get('/tvshow/{id}', [ListController::class, 'tvshowDetails'])->name('Tv-Show-Details');
// Route::get('/tvshow/{id}/similar', [ListController::class, 'tvshowSimilar'])->name('Tv-Show-Similar');

Route::get('/search', [ListController::class, 'search'])->name('search');
