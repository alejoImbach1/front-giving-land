<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Blade::if('backauth',function(){
            return session()->has('auth_token');
        });

        Blade::if('backguest',function(){
            return !session()->has('auth_token');
        });

        Blade::if('owner', function ($username) {
            return session()->has('auth_token') && session('auth_user')['username'] === $username;
        });

        Blade::if('notOwner', function ($username) {
            return session()->has('auth_token') && session('auth_user')['username'] !== $username;
        });

        Http::macro('authtoken', function () {
            // return Http::withHeaders([
            //     'Authorization' => 'Bearer ' . session('auth_token'),
            //     'Accept' => 'application/json',
            // ])->baseUrl(env('api_url'));
            return Http::withToken(session('auth_token'))->acceptJson()->baseUrl(env('api_url'));
        });

        Http::macro('backapi', function () {
            return Http::acceptJson()->baseUrl(env('api_url'));
        });

        
    }
}
