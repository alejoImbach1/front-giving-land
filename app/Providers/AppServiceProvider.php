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
        // Blade::if('backauth', function () {
        //     return Http::withHeaders([
        //         'Authorization' => 'Bearer ' . session('auth_token'),
        //         'Accept' => 'application/json',
        //     ])->get(env('api_url') . '/user')->successful();
        // });

        // Blade::if('backguest', function () {
        //     return !Http::withHeaders([
        //         'Authorization' => 'Bearer ' . session('auth_token'),
        //         'Accept' => 'application/json',
        //     ])->get(env('api_url') . '/user')->successful();
        // });
        Blade::if('backauth',function(){
            return Http::authtoken()->get('/user')->successful();
        });

        Blade::if('backguest',function(){
            return Http::authtoken()->get('/user')->failed();
        });

        Http::macro('authtoken', function () {
            return Http::withHeaders([
                'Authorization' => 'Bearer ' . session('auth_token'),
                'Accept' => 'application/json',
            ])->baseUrl(env('api_url'));
        });

        Http::macro('backapi', function () {
            return Http::acceptJson()->baseUrl(env('api_url'));
        });
        // Blade::if('owner', function ($username) {
        //     return auth()->check() && auth()->user()->username === $username;
        // });

        // Blade::if('notOwner', function ($username) {
        //     return auth()->check() && auth()->user()->username != $username;
        // });
    }
}
