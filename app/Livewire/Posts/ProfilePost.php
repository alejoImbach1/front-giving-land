<?php

namespace App\Livewire\Posts;

use App\MyOwn\classes\Utility;
use Illuminate\Support\Facades\Http;
use Livewire\Attributes\Locked;
use Livewire\Component;

class ProfilePost extends Component
{
    #[Locked]
    public $post;

    #[Locked]
    public $favorites;

    public $username;
    public $deleteDisplayed;

    public function mount()
    {
        $this->username = request('username') ? request('username') : $this->post['user']['username'];
        $this->deleteDisplayed = false;
    }

    public function displayDialogDestroy()
    {
        $this->deleteDisplayed = true;
    }

    public function destroy()
    {
        $response = Http::authtoken()->delete('/posts/' . $this->post['id']);
        // dd($response);
        if($response->failed()){
            return to_route('profiles.show',$this->username);
        }
        Utility::viewAlert('success',$response->object()->message);
        return to_route('profiles.show',$this->username);
    }

    public function render()
    {
        return view('livewire.posts.profile-post');
    }
}
