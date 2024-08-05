<?php

namespace App\Livewire\Profile\Edit;

use Livewire\Attributes\Locked;
use Livewire\Component;

class SocialMedia extends Component
{
    #[Locked]
    public $item;

    #[Locked]
    public $idToDestroy;

    public $profile;
    public $allSocialMedia;
    public $createSocialMedia;
    public $createSelectedSocialMedia;
    public $inputUsername;
    public $inputNumber;
    public $createDisplayed;
    public $deleteDisplayed;

    public function mount()
    {
        // dd(collect($this->profile['social_media'])->pluck('id')->all());
        // dd($this->allSocialMedia);
        $this->createSocialMedia = [];
        $diffIds = array_diff(collect($this->allSocialMedia)->pluck('id')->all(),collect($this->profile['social_media'])->pluck('id')->all());
        foreach ($diffIds as $diffId) {
            $this->createSocialMedia[] = collect($this->allSocialMedia)->where('id',$diffId)->first();
        }
        // dd($this->createSocialMedia);
        $this->createSelectedSocialMedia = (!empty($this->createSocialMedia)) ? $this->createSocialMedia[0]['id'] : 0;
        $this->item = null;
        $this->inputUsername = '';
        $this->inputNumber = '';
        $this->createDisplayed = false;
        $this->deleteDisplayed = false;
        $this->resetValidation();
        // dd($this->profile['social_media'][0]['pivot']['username']);
    }

    public function create()
    {
        $this->mount();
        $this->createDisplayed = true;
    }

    public function onCreateChange()
    {
        $this->resetValidation();
    }

    public function cancelCreate(){
        $this->createDisplayed = false;
    }

    public function store()
    {
        if ($this->createSelectedSocialMedia == 1) {
            $this->validate(
                [
                    'inputNumber' => 'required|numeric|digits:10'
                ],
                [
                    'required' => 'El :attribute es requerido.',
                    'numeric' => 'Todo el campo debe ser numérico.',
                    'digits:10' => 'El :attribute debe contener :value dígitos.',
                ],
                [
                    'inputNumber' => 'número',
                ]
            );
        } else {
            $this->validate(
                [
                    'inputUsername' => 'required'
                ],
                [
                    'required' => 'El link es requerido.',
                ],
            );
        }
        $username = ($this->createSelectedSocialMedia == 1) ? $this->inputNumber : $this->inputUsername;
        $this->profile->socialMedia()->attach($this->createSelectedSocialMedia, compact('username'));
        $this->createDisplayed = false;
        $this->dispatch('alert-sent', type: 'success', message: "Se registró ".ModelsSocialMedia::find($this->createSelectedSocialMedia)->name);
        $this->mount();
    }

    public function dialogDestroy($itemId)
    {
        $this->deleteDisplayed = true;
        $this->item = collect($this->profile['social_media'])->where('id',$itemId)->first();
        // $this->profile['social_media'] = $item;
    }

    public function destroy ()
    {
        // $this->profile->socialMedia()->detach($this->item['id']);
        // $this->deleteDisplayed = false;
        // $this->createSocialMedia = ModelsSocialMedia::all()->diff($this->profile->socialMedia);
        // $this->dispatch('alert-sent', type: 'warning', message: 'Se eliminó '.$item['name']);
        // $this->item = null;
    }
    public function render()
    {
        return view('livewire.profile.edit.social-media');
    }
}
