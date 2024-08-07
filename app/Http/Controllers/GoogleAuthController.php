<?php

namespace App\Http\Controllers;

use App\MyOwn\classes\Utility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }
    public function handleCallback()
    {
        $user_google = Socialite::driver('google')->stateless()->user();

        $response = Http::backapi()->post('google-login', [
            'name' => $user_google->name,
            'email' => $user_google->email,
            'avatar' => $user_google->avatar
        ]);

        $responseObject = $response->object();

        Utility::viewAlert($response->successful() ? 'success' : 'warning', $responseObject->message);

        if ($response->failed()) {
            return to_route('login');
        }

        session(['auth_token' => $responseObject->auth_token]);

        $auth_user = Http::authtoken()->get('/user', [
            'included' => 'profile'
        ])->json();

        session(compact('auth_user'));

        return to_route('home');
    }
}
