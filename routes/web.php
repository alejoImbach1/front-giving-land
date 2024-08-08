<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SecurityPrivacy;
use App\Http\Middleware\BackAuth;
use App\Http\Middleware\BackGuest;
use Illuminate\Support\Facades\Route;

Route::get('/all', function () {
    dd(session()->all());
});

Route::get('/invalidate', function () {
    dd(session()->invalidate());
});

Route::get('/p', function () {
    // session()->flash('p','tonces');
    return view('prueba');
});

Route::get('/', function () {
    return view('home');
})->name('home');


Route::controller(AuthController::class)->group(function () {
    Route::get('/login', 'index')->name('login');
    Route::post('/login', 'attempt')->name('login.attempt');
    Route::post('/logout','logout')->name('logout');
});

Route::controller(RegisterController::class)->group(function () {
    Route::get('/register', 'index')->name('register');
    Route::post('/register', 'attempt')->name('register.attempt');
});

Route::controller(GoogleAuthController::class)->group(function () {
    Route::get('/google-auth/redirect', 'redirectToGoogle')->name('auth.google');
    Route::get('/google-auth/callback', 'handleCallback');
});

Route::controller(ForgotPasswordController::class)->group(function () {
    Route::get('/forgot-password', 'index')->name('forgot_password');
    Route::post('/forgot-password', 'sendEmail')->name('forgot_password.send_email');
    Route::get('/reset-password/{token}','newPasswordForm');
    Route::post('/reset-password','updatePassword')->name('forgot_password.update_password');
})->middleware(BackGuest::class);

Route::resource('posts', PostController::class)->only('show', 'create', 'edit');

Route::singleton('profile', ProfileController::class)->only('edit')->middleware(BackAuth::class);

Route::resource('favorites', FavoriteController::class)->only('index')->middleware(BackAuth::class);

Route::resource('security-privacy', SecurityPrivacy::class)->only('index');


Route::get('{username}', [ProfileController::class, 'show'])->name('profiles.show');
