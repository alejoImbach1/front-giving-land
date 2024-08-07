<?php

namespace App\Http\Controllers;

use App\Http\Middleware\BackAuth;
use App\Http\Requests\LoginRequest;
use App\MyOwn\classes\Utility;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Http;

class AuthController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware(BackAuth::class, only: ['logout']),
        ];
    }

    public function index()
    {
        return view('sections.login.index');
    }

    public function attempt(LoginRequest $request)
    {
        $response = Http::backapi()->post('/login', $request->validated());

        $message = $response->object()->message;
        
        if ($response->failed()) {
            return back()->withErrors(['email' => $message])->onlyInput('email');
        }
        // Auth::login(User::find($response->json()['user']['id']));
        session(['auth_token' => $response->json()['auth_token']]);

        $auth_user = Http::authtoken()->get('/user', [
            'included' => 'profile'
        ])->json();

        session(compact('auth_user'));

        Utility::viewAlert('success', $message);

        return to_route('home');
    }

    public function logout () {
        $response = Http::authtoken()->get('/logout');
        session()->invalidate();
        Utility::viewAlert('success', $response->object()->message);
        return to_route('home');
    }
}
