<?php

namespace App\Livewire;

use App\MyOwn\classes\Utility;
use Illuminate\Support\Facades\Http;
use Livewire\Component;

class HomePosts extends Component
{
    public $posts;

    public function mount()
    {
        $this->posts = Http::backapi()->get('/posts')->collect()->sortDesc();
    }

    public function render()
    {
        return view('livewire.home-posts');
    }
}
