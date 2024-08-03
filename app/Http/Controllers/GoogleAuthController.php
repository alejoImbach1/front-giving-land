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
        // dd($user_google->);
        $response = Http::backapi()->post('google-login',[
            'name' => $user_google->name,
            'email' => $user_google->email,
            'avatar' => $user_google->avatar
        ]);

        if($response->failed()){
            return to_route('login');
        }

        session(['auth_token' => $response->json()['auth_token']]);
        Utility::viewAlert('success', 'Se ingresó con google.');
        return to_route('home');
    }
}
