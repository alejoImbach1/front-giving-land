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
        $profile = Http::backapi()->get('/profiles/' . $user['profile']['id'], ['included' => 'image,socialMedia.image,contactInformation'])->json();
        $posts = Http::backapi()->get('/posts', [
            'filter[user_id]' => $response->object()->id,
            'included' => 'images,location,category'
        ])->json();
        // $posts = $profile->user->posts;
        // dd($posts);
        return view('sections.profile.show', compact('profile', 'user', 'posts'));
    }
}
