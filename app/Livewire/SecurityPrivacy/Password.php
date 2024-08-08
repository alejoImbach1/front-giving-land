<?php

namespace App\Livewire\SecurityPrivacy;

use App\MyOwn\classes\Utility;
use Illuminate\Support\Facades\Http;
use Livewire\Component;

class Password extends Component
{
    public $current_password;
    public $password;
    public $password_confirmation;
    // public $initValue;
    public $inputChanged;
    public $displayed;

    public function mount()
    {
        // $this->password = Http:;
        $this->current_password = '';
        $this->password = '';
        $this->password_confirmation = '';
        $this->inputChanged = false;
        $this->displayed = false;
    }

    public function onChanged()
    {
        $this->inputChanged = $this->password && $this->password_confirmation;
        $this->resetValidation();
    }

    public function update()
    {
        $this->validate([
            'current_password' => 'required',
            'password' => 'required|confirmed|regex:/^(?=.*\d).{6,14}$/'
        ]);

        $response = Http::authtoken()->put('/user', $this->only('current_password', 'password'));

        if ($response->failed()) {
            $this->addError('current_password', $response->object()->message);
            $this->password = '';
            $this->password_confirmation = '';
            return;
        }

        // Utility::refreshAuthUser();

        // dd($response->json());
        // $this->dispatch('email-changed');
        $this->dispatch('alert-sent', type: 'success', message: $response->object()->message);

        $this->mount();
    }
    public function render()
    {
        return view('livewire.security-privacy.password');
    }
}
