<?php

namespace App\Livewire\SecurityPrivacy;

use App\MyOwn\classes\Utility;
use Illuminate\Support\Facades\Http;
use Livewire\Component;

class Username extends Component
{
    public $username;
    public $initValue;
    public $inputChanged;
    public $displayed;
    public function mount()
    {
        $this->username = session('auth_user')['username'];
        $this->initValue = $this->username;
        $this->inputChanged = false;
        $this->displayed = false;
    }

    public function onChanged()
    {
        $this->inputChanged = $this->username !== $this->initValue;
        $this->resetValidation();
    }

    public function update()
    {
        $this->validate([
            'username' => 'required|regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/'
        ]);

        $response = Http::authtoken()->put('/user',$this->only('username'));

        if($response->failed()){
            $this->addError('username', $response->object()->message);
            return;
        }

        Utility::refreshAuthUser();

        // dd($response->json());
        $this->dispatch('username-changed');

        $this->dispatch('alert-sent', type: 'success', message: $response->object()->message);

        $this->mount();
    }

    public function render()
    {
        return view('livewire.security-privacy.username');
    }
}
