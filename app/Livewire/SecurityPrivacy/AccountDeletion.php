<?php

namespace App\Livewire\SecurityPrivacy;

use App\MyOwn\classes\Utility;
use Illuminate\Support\Facades\Http;
use Livewire\Component;

class AccountDeletion extends Component
{
    public $current_password;
    public $password;
    public $password_confirmation;
    public $inputChanged;
    public $dialogDisplayed;

    public function mount()
    {
        $this->current_password = '';
        $this->password = '';
        $this->password_confirmation = '';
        $this->inputChanged = false;
        $this->dialogDisplayed = false;
    }

    public function onChanged()
    {
        $this->inputChanged = $this->password && $this->password_confirmation;
        $this->resetValidation();
    }

    public function verify()
    {
        $this->validate([
            'password' => 'required|confirmed'
        ]);

        $response = Http::authtoken()->post('/check-password', $this->only('password'));

        if ($response->failed()) {
            $this->addError('password', $response->object()->message);
            $this->password = '';
            $this->password_confirmation = '';
            return;
        }

        $this->dialogDisplayed = true;
    }

    public function destroy()
    {
        $response = Http::authtoken()->delete('/user', $this->only('current_password','password','password_confirmation'));
        // dd($response->json());
        session()->invalidate();
        Utility::viewAlert('warning',$response->object()->message);
        return to_route('home');
    }

    public function render()
    {
        return view('livewire.security-privacy.account-deletion');
    }
}
