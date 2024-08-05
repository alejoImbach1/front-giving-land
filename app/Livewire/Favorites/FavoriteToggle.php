<?php

namespace App\Livewire\Favorites;

use Illuminate\Support\Facades\Http;
use Livewire\Attributes\Locked;
use Livewire\Component;

class FavoriteToggle extends Component
{
    #[Locked]
    public $postId;

    #[Locked]
    public $favorites;

    public $isFavorite;


    public function mount()
    {
        $this->isFavorite = false;
        foreach ($this->favorites as $favorite) {
            if($favorite['pivot']['post_id'] == $this->postId){
                $this->isFavorite = true;
            }
        }
    }

    public function toggleFavorite()
    {
        Http::authtoken()->post('/toggle-favorite',['post_id' => $this->postId]);
    }
    public function render()
    {
        return view('livewire.favorites.favorite-toggle');
    }
}
