<?php

namespace App\Http\Controllers;

use App\Http\Middleware\BackGuest;
use App\Http\Requests\RegisterRequest;
use App\MyOwn\classes\Utility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class RegisterController extends Controller
{
    public static function middleware(): array
    {
        return [
            BackGuest::class
        ];
    }

    public function index()
    {
        return view('sections.register.index');
    }

    public function attempt(RegisterRequest $request)
    {
        // dd($request->validated());
        $response = Http::backapi()->post('/register', $request->validated());

        if ($response->unprocessableEntity()) {
            return back()->withErrors(['email' => 'El correo electrónico ya existe'])->onlyInput('email');
        }

        if($response->failed()){
            return to_route('register');
        }

        // Auth::login(User::find($response->json()['user']['id']));
        session(['auth_token' => $response->json()['auth_token']]);
        Utility::viewAlert('success', 'Se registró y se inició sesión.');
        return to_route('home');
    }
}
