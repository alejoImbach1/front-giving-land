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
            new Middleware(BackAuth::class, only: ['create','edit','destroy']),
        ];
    }
    public function create()
    {
        return view('sections.posts.create');
    }

    public function edit(string $id)
    {
        $response = Http::backapi()->get('/posts/' , [
            'only' => session('auth_user')['id'],
            'included' => 'images,location,category'
        ]);
        if($response->failed() || empty($response->json()) || !$response->collect()->where('id',$id)->first()){
            return to_route('home');
        };
        $post = $response->collect()->where('id',$id)->first();
        return view('sections.posts.edit',compact('post'));
    }

    public function destroy(string $id)
    {
        $response = Http::authtoken()->delete('/posts/' . $id);
        if($response->failed()){
            return back();
        }
        Utility::viewAlert('success',$response->object()->message);
        return back();
    }
}
