<?php

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

Route::get('/',function (){
    return view('home');
});

Route::get('/p', function () {
    dd(Http::withHeaders([
        'Authorization' => 'Bearer ' . session('auth_token'),
        'Accept' => 'application/json',
    ])->get('http://127.0.0.1:8000/v1/user')->json());
});
