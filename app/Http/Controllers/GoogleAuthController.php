<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class GoogleAuthController extends Controller
{
    public function redirectToGoogle()
    {
        return redirect(env('api_url') . '/google-auth/redirect');
    }
    public function handleCallback()
    {
        $response = Http::backapi()->get('/google-auth/redirect');
        dd($response->json());
    }
}
