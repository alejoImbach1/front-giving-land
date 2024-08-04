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
            new Middleware(BackAuth::class, only: ['create','destroy']),
        ];
    }
    public function create()
    {
        return view('sections.posts.create');
    }

    public function edit(string $postId)
    {
        return view('sections.posts.edit');
    }

    public function destroy(string $postId)
    {
        $response = Http::authtoken()->delete('/posts/' . $postId);
        if($response->failed()){
            return back();
        }
        Utility::viewAlert('success',$response->object()->message);
        return back();
    }
}
