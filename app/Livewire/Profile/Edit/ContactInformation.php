<?php

namespace App\Livewire\Profile\Edit;

use App\Rules\NotUrl;
use Illuminate\Support\Facades\Http;
use Livewire\Attributes\Locked;
use Livewire\Component;

class ContactInformation extends Component
{
    #[Locked]
    public $profile;

    // #[Locked]
    // public $id;

    #[Locked]
    public $item;

    public $is_link;
    public $name;
    public $info;
    public $editOrCreateDisplayed;
    public $editDisplayed;
    public $deleteDisplayed;

    public function mount()
    {
        $this->profile = Http::backapi()->get('/profiles/' . session('auth_user')['profile']['id'],['included' => 'contactInformation'])->json();
        // dd(collect($this->profile['contact_information'][0])->only('name','info','is_link')->all());
        $this->item = null;
        $this->is_link = 0;
        $this->name = '';
        $this->info = '';
        $this->editOrCreateDisplayed = false;
        $this->editDisplayed = false;
        $this->deleteDisplayed = false;
        $this->resetValidation();
    }

    public function editOrCreate($itemId = null)
    {
        if ($itemId) {
            $this->item = collect($this->profile['contact_information'])->where('id',$itemId)->first();
            $this->fill(collect($this->item)->only('name','info','is_link')->all());
        } else {
            $this->mount();
        }
        $this->editOrCreateDisplayed = true;
    }

    public function onChange()
    {
        $this->resetValidation();
    }

    public function cancel()
    {
        $this->editOrCreateDisplayed = false;
    }

    public function updateOrStore()
    {
        $this->validate(
            [
                'name' => 'required',
                'info' => ($this->is_link) ? 'required|url' : ['required',new NotUrl]
            ],
            [
                'info.required' => 'La :attribute es requerida.',
            ],
            [
                'info' => 'información',
            ]
        );
        $response = Http::authtoken()->put('/profile',[
            'contact_information' => [
                'delete' => false,
                'id' => $this->item ? $this->item['id'] : null,
                'data' => $this->only('name','info','is_link'),
            ]
        ]);
        $this->dispatch('alert-sent', type: 'success', message: $response->object()->message);
        $this->editOrCreateDisplayed = false;
        $this->mount();
    }

    public function dialogDestroy($itemId)
    {
        $this->deleteDisplayed = true;
        $this->item = collect($this->profile['contact_information'])->where('id',$itemId)->first();
    }

    public function destroy()
    {
        $response = Http::authtoken()->put('/profile',[
            'contact_information' => [
                'delete' => true,
                'id' => $this->item['id'],
            ]
        ]);
        $this->dispatch('alert-sent', type: 'warning', message: $response->object()->message);
        $this->mount();
    }
    public function render()
    {
        return view('livewire.profile.edit.contact-information');
    }
}
