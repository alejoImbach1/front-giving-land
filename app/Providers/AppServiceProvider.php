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
        Blade::if('backauth', function () {
            return Http::withHeaders([
                'Authorization' => 'Bearer ' . session('auth_token'),
                'Accept' => 'application/json',
            ])->get('http://127.0.0.1:8000/v1/user')->successful();
        });

        Blade::if('backguest', function () {
            return !Http::withHeaders([
                'Authorization' => 'Bearer ' . session('auth_token'),
                'Accept' => 'application/json',
            ])->get('http://127.0.0.1:8000/v1/user')->successful();
        });

        Http::macro('authtoken', function () {
            return Http::withHeaders([
                'Authorization' => 'Bearer ' . session('auth_token'),
                'Accept' => 'application/json',
            ])->baseUrl(env('api_url'));
        });
        // Blade::if('owner', function ($username) {
        //     return auth()->check() && auth()->user()->username === $username;
        // });

        // Blade::if('notOwner', function ($username) {
        //     return auth()->check() && auth()->user()->username != $username;
        // });
    }
}
