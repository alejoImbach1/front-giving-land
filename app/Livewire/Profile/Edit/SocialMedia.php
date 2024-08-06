<?php

namespace App\Livewire\Profile\Edit;

use Illuminate\Support\Facades\Http;
use Livewire\Attributes\Locked;
use Livewire\Component;

class SocialMedia extends Component
{
    #[Locked]
    public $item;

    #[Locked]
    public $profile;

    #[Locked]
    public $allSocialMedia;

    #[Locked]
    public $createSocialMedia;

    public $createSelectedSocialMediaId;

    public $inputUsername;
    public $inputNumber;
    public $createDisplayed;
    public $deleteDisplayed;

    public function mount()
    {
        $this->profile = Http::backapi()->get('/profiles/' . session('auth_user')['profile']['id'],['included' => 'socialMedia.image'])->json();
        $this->createSocialMedia = [];
        $diffIds = array_diff(collect($this->allSocialMedia)->pluck('id')->all(),collect($this->profile['social_media'])->pluck('id')->all());
        foreach ($diffIds as $diffId) {
            $this->createSocialMedia[] = collect($this->allSocialMedia)->where('id',$diffId)->first();
        }
        $this->createSelectedSocialMediaId = (!empty($this->createSocialMedia)) ? $this->createSocialMedia[0]['id'] : 0;
        $this->item = null;
        $this->inputUsername = '';
        $this->inputNumber = '';
        $this->createDisplayed = false;
        $this->deleteDisplayed = false;
        $this->resetValidation();
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
        $this->validate(
            [
                'inputNumber' => 'required_if:createSelectedSocialMediaId,1|numeric|digits:10',
                'inputUsername' => 'exclude_if:createSelectedSocialMediaId,1|required'
            ],
            [
                'required_if' => 'El :attribute es requerido.',
                'required' => 'El :attribute es requerido.',
                'numeric' => 'Todo el campo debe ser numérico.',
                'digits:10' => 'El :attribute debe contener :value dígitos.',
            ],
            [
                'inputNumber' => 'número',
                'inputUsername' => 'nombre de usuario'
            ]
        );
        // if ($this->createSelectedSocialMediaId == 1) {
        //     $this->validate(
        //         [
        //             'inputNumber' => 'required|numeric|digits:10'
        //         ],
        //         [
        //             'required' => 'El :attribute es requerido.',
        //             'numeric' => 'Todo el campo debe ser numérico.',
        //             'digits:10' => 'El :attribute debe contener :value dígitos.',
        //         ],
        //         [
        //             'inputNumber' => 'número',
        //         ]
        //     );
        // } else {
        //     $this->validate(
        //         [
        //             'inputUsername' => 'required'
        //         ],
        //         [
        //             'required' => 'El link es requerido.',
        //         ],
        //     );
        // }
        $username = ($this->createSelectedSocialMediaId == 1) ? $this->inputNumber : $this->inputUsername;
        $this->createDisplayed = false;
        $response = Http::authtoken()->put('/profile',[
            'social_media' => [
                'delete' => false,
                'id' => $this->createSelectedSocialMediaId,
                'username' => $username,
            ]
        ]);
        $this->dispatch('alert-sent', type: 'success', message: $response->object()->message);
        $this->mount();
    }

    public function dialogDestroy($itemId)
    {
        $this->deleteDisplayed = true;
        $this->item = collect($this->profile['social_media'])->where('id',$itemId)->first();
    }

    public function destroy ()
    {
        $response = Http::authtoken()->put('/profile',[
            'social_media' => [
                'delete' => true,
                'id' => $this->item['id'],
            ]
        ]);
        $this->dispatch('alert-sent', type: 'warning', message: $response->object()->message);
        $this->mount();
    }
    public function render()
    {
        return view('livewire.profile.edit.social-media');
    }
}
