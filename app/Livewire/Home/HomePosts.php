<?php

namespace App\Livewire\Home;

use Illuminate\Support\Facades\Http;
use Livewire\Component;

class HomePosts extends Component
{

    public $posts;

    public function mount()
    {
        $this->posts = Http::backapi()->get('/posts', ['included' => 'images,location'])->collect();
        

        // $this->posts = $this->posts->map(function ($item) {
        //     return (object) $item;
        // });
    }

    public function render()
    {
        return view('livewire.home.home-posts');
    }
}
