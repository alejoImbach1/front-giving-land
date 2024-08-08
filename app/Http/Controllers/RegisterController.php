<?php

namespace App\Http\Controllers;

use App\Http\Middleware\BackGuest;
use App\Http\Requests\RegisterRequest;
use App\MyOwn\classes\Utility;
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
        $response = Http::backapi()->post('/users', $request->validated());

        $responseObject = $response->object();

        if ($response->failed()) {
            return back()->withErrors(['email' => $responseObject->message])->onlyInput('name','email');
        }

        // dd($response->json());

        session(['auth_token' => $responseObject->auth_token]);

        session(['auth_user' => $response->json()['user']]);

        Utility::viewAlert('success', $responseObject->message);

        return to_route('home');
    }
}
