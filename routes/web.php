<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegisterController;
use App\Http\Middleware\BackAuth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

Route::get('/all', function () {
    dd(session()->all());
});

Route::get('/p', function () {
    session()->flash('p','tonces');
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
    return to_route('home');
})->middleware(BackAuth::class)->name('logout');

Route::controller(RegisterController::class)->group(function(){
    Route::get('/register','index')->name('register');
    Route::post('/register','attempt')->name('register.attempt');
});

Route::resource('posts',PostController::class)->only('show','create','edit');

Route::get('{username}', [ProfileController::class, 'show'])->name('profile.show');
