<?php

namespace App\Http\Controllers;

use App\MyOwn\classes\Utility;
use Illuminate\Support\Facades\Http;

class ProfileController extends Controller
{
    public function show($username)
    {
        $response = Http::backapi()->get('/users/' . $username, ['included' => 'profile']);
        if ($response->failed()) {
            Utility::viewAlert('warning', $response->object()->message);
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

        $favorites = Utility::checkAuth() ?
            Http::backapi()->get('/users/' . session('auth_user')['username'], ['included' => 'favorites'])->json()['favorites'] : null;

        $profileImageUrl = Utility::getAuthProfileImageUrl($profile);

        return view('sections.profile.show', compact('user', 'profile', 'posts', 'profileImageUrl', 'favorites'));
    }

    public function edit()
    {
        $profile = Http::backapi()->get('/profiles/' . session('auth_user')['profile']['id'], [
            'included' => 'image,socialMedia.image,contactInformation'
        ])->json();

        $allSocialMedia = Http::backapi()->get('/social-media', ['included' => 'image'])->json();
        // dd($profile);
        return view('sections.profile.edit', compact('profile', 'allSocialMedia'));
    }
}
