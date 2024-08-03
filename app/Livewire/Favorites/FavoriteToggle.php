<?php

namespace App\Livewire\Favorites;

use Illuminate\Support\Facades\Http;
use Livewire\Attributes\Locked;
use Livewire\Component;

class FavoriteToggle extends Component
{
    #[Locked]
    public $postId;

    public $isFavorite;


    public function mount()
    {
        $this->isFavorite = false;
        $favorites = Http::authtoken()->get('/user', ['included' => 'favorites'])->json()['favorites'];
        foreach ($favorites as $favorite) {
            if($favorite['pivot']['post_id'] == $this->postId){
                $this->isFavorite = true;
            }
        }
        // $this->isFavorite = $favorites->where('pivot')->where('post_id');
        // dd($this->isFavorite);
        // $this->isFavorite = auth()->user()->favorites()->where('post_id', $this->postId)->exists();
    }

    public function toggleFavorite()
    {
        // auth()->user()->favorites()->toggle($this->postId);
        Http::authtoken()->post('/toggle-favorite',['post_id' => $this->postId]);
    }
    public function render()
    {
        return view('livewire.favorites.favorite-toggle');
    }
}
