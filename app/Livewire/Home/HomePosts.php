<?php

namespace App\Livewire\Home;

use Illuminate\Support\Facades\Http;
use Livewire\Attributes\Locked;
use Livewire\Component;

class HomePosts extends Component
{
    #[Locked]
    public $favorites;

    public $posts;

    public function mount()
    {
        $queries = [
            'included' => 'images,location',
            'sort' => '-created_at',
        ];
        if (session()->has('auth_token')) {
            $queries['except'] = session('auth_user')['id'];
        }
        // dd($queries);
        $this->posts = Http::backapi()->get('/posts', $queries)->json();
        $this->favorites = session()->has('auth_token') ?
            Http::backapi()->get('/users/' . session('auth_user')['username'], ['included' => 'favorites'])->json()['favorites'] : null;
    }

    public function render()
    {
        return view('livewire.home.home-posts');
    }
}
