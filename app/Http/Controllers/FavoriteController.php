<?php

namespace App\Http\Controllers;

use App\MyOwn\classes\Utility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class FavoriteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Http::authtoken()->get('/users/' . session('auth_user')['id'], [
            'included' => 'profile.image'
        ])->json();
        $profileImageUrl = Utility::getAuthProfileImageUrl($user['profile']);
        $favorites = Http::authtoken()->get('/favorites')->json();
        return view('sections.favorites.index', compact('profileImageUrl', 'favorites'));
    }
}
