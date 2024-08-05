<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ProfileController extends Controller
{
    public function show($username)
    {
        $response = Http::backapi()->get('/users/' . $username, ['included' => 'profile']);
        if ($response->failed()) {
            return to_route('home');
        }

        $user = $response->json();

        $profile = Http::backapi()->get('/profiles/' . $user['profile']['id'], [
            'included' => 'image,socialMedia.image,contactInformation'
        ])->json();

        $posts = Http::backapi()->get('/posts', [
            'included' => 'images,location,category',
            'only' => $user['id'],
            'sort' => '-created_at'
        ])->json();

        $favorites = session()->has('auth_token') ?
            Http::backapi()->get('/users/' . session('auth_user')['username'], ['included' => 'favorites'])->json()['favorites'] : null;

        $profileImageUrl = $profile['image']
            ? env('back_public_storage') . '/' . $profile['image']['url']
            : $profile['google_avatar'];

        return view('sections.profile.show', compact('user', 'profile', 'posts', 'profileImageUrl' ,'favorites'));
    }
}
