<?php

namespace App\MyOwn\classes;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class Utility
{
    public static function viewAlert(string $type, string $message)
    {
        session()->flash('alert', [
            'type' => $type,
            'message' => $message
        ]);
    }

    public static function checkAuth(): bool
    {
        return session()->has('auth_token');
    }

    public static function getAuthProfileImageUrl(array $profile): string
    {
        return !$profile['google_avatar']
            ? env('back_public_storage') . '/' . $profile['image']['url']
            : $profile['image']['url'];
    }

    public static function refreshAuthUser(): bool
    {
        $response = Http::authtoken()->get('/user', ['included' => 'profile']);

        if ($response->successful()) {
            session(['auth_user' => $response->json()]);
        }

        return $response->successful();
    }
}
