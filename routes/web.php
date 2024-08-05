<?php

use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SecurityPrivacy;
use App\Http\Middleware\BackAuth;
use Illuminate\Support\Facades\Http;
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

Route::get('/',function (){
    return view('home');
})->name('home');


Route::controller(LoginController::class)->group(function(){
    Route::get('/login','index')->name('login');
    Route::post('/login','attempt')->name('login.attempt');
});

Route::post('/logout',function(){
    Http::authtoken()->get('/logout');
    session()->invalidate();
    return to_route('home');
})->middleware(BackAuth::class)->name('logout');

Route::controller(RegisterController::class)->group(function(){
    Route::get('/register','index')->name('register');
    Route::post('/register','attempt')->name('register.attempt');
});

Route::controller(GoogleAuthController::class)->group(function(){
    Route::get('/google-auth/redirect','redirectToGoogle')->name('auth.google');
    Route::get('/google-auth/callback','handleCallback');
});

Route::resource('posts',PostController::class)->except('store','update','index');

Route::singleton('profile',ProfileController::class)->only('edit')->middleware(BackAuth::class);

Route::resource('favorites',FavoriteController::class)->only('index');

Route::resource('security-privacy',SecurityPrivacy::class)->only('index');


Route::get('{username}', [ProfileController::class, 'show'])->name('profiles.show');
