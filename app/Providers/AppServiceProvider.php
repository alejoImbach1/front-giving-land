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
            return Http::authtoken()->get('/user')->successful();
        });

        Blade::if('backguest',function(){
            return Http::authtoken()->get('/user')->failed();
        });

        Blade::if('owner', function ($username) {
            $response = Http::authtoken()->get('/user');
            return $response->successful() && $response->object()->username === $username;
        });

        Blade::if('notOwner', function ($username) {
            $response = Http::authtoken()->get('/user');
            return $response->successful() && $response->object()->username !== $username;
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

        
    }
}
