<?php

namespace App\Livewire\Profile\Nav;

use Livewire\Attributes\Locked;
use Livewire\Attributes\On;
use Livewire\Component;

class ProfileLink extends Component
{
    #[Locked]
    public $profileImageUrl;

    #[Locked]
    public $username;

    public function mount()
    {
        $this->username = session('auth_user')['username'];
    }

    #[On('username-changed')] 
    public function updateProfileLink()
    {
        $this->mount();
    }
    public function render()
    {
        return view('livewire.profile.nav.profile-link');
    }
}
