<?php

namespace App\Livewire\SecurityPrivacy;

use App\MyOwn\classes\Utility;
use Illuminate\Support\Facades\Http;
use Livewire\Component;

class Email extends Component
{
    public $email;
    public $initValue;
    public $inputChanged;
    public $displayed;
    public function mount()
    {
        $this->email = session('auth_user')['email'];
        $this->initValue = $this->email;
        $this->inputChanged = false;
        $this->displayed = false;
    }

    public function onChanged()
    {
        $this->inputChanged = $this->email !== $this->initValue;
        $this->resetValidation();
    }

    public function update()
    {
        $this->validate([
            'email' => 'required|email'
        ]);

        $response = Http::authtoken()->put('/user',$this->only('email'));

        if($response->failed()){
            $this->addError('email', $response->object()->message);
            return;
        }

        Utility::refreshAuthUser();

        // dd($response->json());
        // $this->dispatch('email-changed');
        $this->dispatch('alert-sent', type: 'success', message: $response->object()->message);

        $this->mount();
    }
    public function render()
    {
        return view('livewire.security-privacy.email');
    }
}
