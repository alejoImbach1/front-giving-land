<?php

namespace App\Livewire\SecurityPrivacy;

use App\MyOwn\classes\Utility;
use Illuminate\Support\Facades\Http;
use Livewire\Component;

class Name extends Component
{
    public $name;
    public $initValue;
    public $inputChanged;
    public $displayed;
    public function mount()
    {
        $this->name = session('auth_user')['name'];
        $this->initValue = $this->name;
        $this->inputChanged = false;
        $this->displayed = false;
    }

    public function onChanged()
    {
        $this->inputChanged = $this->name !== $this->initValue;
        $this->resetValidation();
    }

    public function update()
    {
        $this->validate([
            'name' => 'required|max:100|regex:/^[\p{L}\p{N}\sñÑáéíóúÁÉÍÓÚüÜ]+$/u'
        ]);
        $response = Http::authtoken()->put('/user',$this->only('name'));
        
        Utility::refreshAuthUser();
        // dd($response->json());
        $this->dispatch('alert-sent', type: 'success', message: $response->object()->message);
        $this->mount();
    }

    public function render()
    {
        return view('livewire.security-privacy.name');
    }
}
