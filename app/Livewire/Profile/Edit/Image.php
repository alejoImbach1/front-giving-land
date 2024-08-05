<?php

namespace App\Livewire\Profile\Edit;

use App\MyOwn\classes\Utility;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class Image extends Component
{
    use WithFileUploads;
    public $profile;
    public $photo;
    public $initImageUrl;
    public $editDisplayed;
    public $deleteDisplayed;
    public $submitDisabled;

    public function mount()
    {
        $this->photo = null;
        $this->initImageUrl = !$this->profile['google_avatar'] ? env('back_public_storage') . '/' . $this->profile['image']['url'] : $this->profile['image']['url'];
        $this->editDisplayed = false;
        $this->deleteDisplayed = false;
        $this->submitDisabled = true;
    }

    public function edit()
    {
        $this->editDisplayed = true;
    }

    public function photoLoaded()
    {
        $this->submitDisabled = false;
    }

    public function cancel()
    {
        $this->mount();
    }

    public function update()
    {
        $response = Http::authtoken()->attach(
            'image', file_get_contents($this->photo->getRealPath()), $this->photo->getFileName(), ['Content-Type' => $this->photo->getMimeType()]
        )->post('/profile');

        Utility::viewAlert('success', $response->object()->message);

        return to_route('profile.edit');
    }

    public function dialogDelete()
    {
        $this->deleteDisplayed = true;
    }

    public function delete()
    {
        $response = Http::authtoken()->post('/profile');

        Utility::viewAlert('warning', $response->object()->message);

        return to_route('profile.edit');
    }
    public function render()
    {
        return view('livewire.profile.edit.image');
    }
}
