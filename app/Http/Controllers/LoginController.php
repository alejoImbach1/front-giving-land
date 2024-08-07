<?php

namespace App\Http\Controllers;

use App\Http\Middleware\BackAuth;
use App\Http\Middleware\BackGuest;
use App\Http\Requests\LoginRequest;
use App\MyOwn\classes\Utility;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\URL;

class LoginController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            BackGuest::class
        ];
    }

    public function index()
    {
        return view('sections.login.index');
    }

    public function attempt(LoginRequest $request)
    {
        $response = Http::backapi()->post('/login', $request->validated());

        if ($response->unauthorized()) {
            return back()->withErrors(['email' => 'El correo o la contraseña son incorrectos'])->onlyInput('email');
        }

        if ($response->failed()) {
            return to_route('login');
        }
        // Auth::login(User::find($response->json()['user']['id']));
        session(['auth_token' => $response->json()['auth_token']]);
        $auth_user = Http::authtoken()->get('/user', [
            'included' => 'profile'
        ])->json();
        session(compact('auth_user'));
        Utility::viewAlert('success', 'Se inició sesión.');
        return to_route('home');
    }
}
