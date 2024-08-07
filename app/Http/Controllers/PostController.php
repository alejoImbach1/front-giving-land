<?php

namespace App\Http\Controllers;

use App\Http\Middleware\BackAuth;
use App\MyOwn\classes\Utility;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Http;

class PostController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware(BackAuth::class, except: ['show']),
        ];
    }

    public function show(string $id)
    {
        $response = Http::backapi()->get('/posts/' . $id, [
            'included' => 'images,location,category,user.profile.image'
        ]);

        if ($response->failed()) {
            Utility::viewAlert('warning', $response->object()->message);
            return to_route('home');
        }

        $post = $response->json();

        $favorites = Utility::checkAuth() ?
            Http::backapi()->get('/users/' . session('auth_user')['username'], ['included' => 'favorites'])->json()['favorites'] : null;

        return view('sections.posts.show', compact('post', 'favorites'));
    }

    public function create()
    {
        return view('sections.posts.create');
    }

    public function edit(string $id)
    {
        $response = Http::backapi()->get('/posts/', [
            'only' => session('auth_user')['id'],
            'included' => 'images,location,category'
        ]);
        if ($response->failed() || empty($response->json()) || !$response->collect()->where('id', $id)->first()) {
            Utility::viewAlert('warning', 'no encontrado');
            return to_route('home');
        };

        $post = $response->collect()->where('id', $id)->first();

        return view('sections.posts.edit', compact('post'));
    }

    public function destroy(string $id)
    {
        $response = Http::authtoken()->delete('/posts/' . $id);

        $message = $response->object()->message;
        
        if ($response->failed()) {
            Utility::viewAlert('warning', $message);
            return to_route('home');
        }

        Utility::viewAlert('success', $message);

        return to_route('profiles.show', session('auth_user')['username']);
    }
}
