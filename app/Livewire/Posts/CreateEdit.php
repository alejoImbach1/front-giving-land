<?php

namespace App\Livewire\Posts;

use App\Http\Requests\StoreUpdatePostRequest;
use App\MyOwn\classes\Utility;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Locked;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreateEdit extends Component
{
    use WithFileUploads;
    #[Locked]
    public $id;

    #[Locked]
    public $isCreate;

    #[Locked]
    public $initImages;

    #[Locked]
    public $deletedInitImagesIds;

    #[Locked]
    public $newImagesNames;

    public $inputImages;

    public $images;
    public $name;
    public $purpose;
    public $expected_item;
    public $description;
    public $location_id;
    public $category_id;
    public $locations;
    public $categories;

    public $currentShownImageIndex;

    public function mount($post = null)
    {
        $this->initImages = [];
        $this->deletedInitImagesIds = [];
        $this->images = [];
        $this->inputImages = [];
        $this->newImagesNames = [];
        $this->currentShownImageIndex = 0;
        if ($post !== null) {
            $this->fill($post);
            // dd($this->all());
            $images = $post['images'];
            foreach ($images as $image) {
                $this->initImages[] = ['id' => $image['id'], 'url' => env('back_public_storage') . '/' . $image['url']];
                // Storage::copy('public/posts_images/' . auth()->user()->username . '/' . $imageName, 'public/livewire-tmp/' . $imageName);
            }
            $this->images = $this->initImages;
            $this->isCreate = false;
        } else {
            $this->id = null;
            $this->name = '';
            $this->purpose = '';
            $this->expected_item = null;
            $this->description = '';
            $this->location_id = '';
            $this->category_id = '';
            $this->isCreate = true;
        }
        $this->locations = Http::backapi()->get('/locations')->json();
        $this->categories = Http::backapi()->get('/categories')->json();
        Storage::deleteDirectory('public/livewire-tmp');
        // dd($this->all());
    }

    public function showPreviousImage()
    {
        if (count($this->images) > 1 && $this->currentShownImageIndex != array_key_first($this->images)) {
            $this->currentShownImageIndex--;
        }
    }

    public function showNextImage()
    {
        if (count($this->images) > 1 && $this->currentShownImageIndex != array_key_last($this->images)) {
            $this->currentShownImageIndex++;
            // dd('next');
        }
    }

    public function removeImage($index)
    {
        if ($index > 0 && $index < count($this->images)) {
            $this->currentShownImageIndex--;
        }
        if (in_array($this->images[$index]['url'], collect($this->initImages)->pluck('url')->all())) {
            $this->deletedInitImagesIds[] = $this->images[$index]['id'];
        } else {
            Storage::delete('public/livewire-tmp/' . basename($this->images[$index]['url']));
            array_splice($this->newImagesNames, array_search(basename($this->images[$index]['url']), $this->newImagesNames), 1);
        }
        array_splice($this->images, $index, 1);
        // dd($this->images);
        // dd($temp);
    }

    public function see()
    {
        // dd(basename($this->images[0]));
        dd($this->all());
    }

    public function onPurposeSelected()
    {
        if ($this->purpose == 'donación') {
            $this->expected_item = null;
        }
        $this->resetValidation();
    }

    public function onInput()
    {
        $this->resetValidation();
    }

    public function storeOrUpdate()
    {
        $this->validate(
            StoreUpdatePostRequest::rules(),
            [
                'purpose.required' => 'El propósito es requerido',
                'expected_item.required' => 'El artículo de interés es requerido',
                'location_id.required' => 'La ubicación es requerida',
                'category_id.required' => 'La categoría es requerida',
            ],
            [
                'images' => 'imágenes',
            ]
        );

        $authUser = session('auth_user');
        $requestData = $this->only(['name', 'purpose', 'expected_item', 'description', 'location_id', 'category_id']);
        $multipart = [];
        foreach ($this->newImagesNames as $imageName) {
            $multipart[] = [
                'name' => 'images[]',
                'contents' => Storage::get('public/livewire-tmp/' . $imageName),
                'filename' => $imageName,
            ];
        }

        // dd($multipart);
        if ($this->isCreate) {
            $storeResponse = Http::authtoken()->attach($multipart)->post('/posts', $requestData);
            Utility::viewAlert($storeResponse->successful() ? 'success' : 'danger', $storeResponse->object()->message);
            return to_route('profiles.show', $authUser['username']);
        }
        $requestData['deleted_images_ids'] = $this->deletedInitImagesIds;
        // $updateResponse = Http::authtoken()->attach($multipart)->put('/posts/' . $this->id, $requestData);
        $updateResponse = Http::authtoken()->put('/posts/' . $this->id, $requestData);
        // if($this->)
        if(!empty($multipart)){
            Http::authtoken()->attach($multipart)->post('post/new-images', ['post_id' => $this->id]);
        }
        Utility::viewAlert($updateResponse->successful() ? 'success' : 'danger', $updateResponse->object()->message);
        Storage::deleteDirectory('public/livewire-tmp');
        return to_route('profiles.show', $authUser['username']);
    }

    public function updated($inputImages)
    {
        if ($inputImages === 'inputImages') {
            if (count($this->images) + count($this->inputImages) > 5) {
                $this->js("alert('¡Solo puedes subir 5 imágenes como máximo!')");
                return;
            }
            $this->currentShownImageIndex = count($this->images);
            foreach ($this->inputImages as $uploadedImage) {
                $imageName = $uploadedImage->getFilename();
                Storage::copy('livewire-tmp/' . $imageName, 'public/livewire-tmp/' . $imageName);
                $this->images[] = [
                    'id' => null,
                    'url' => asset('storage/livewire-tmp/' . $imageName)
                ];
                $this->newImagesNames[] = $imageName;
            }
            Storage::deleteDirectory('livewire-tmp');
        }
        $this->resetValidation();
    }

    public function render()
    {
        // dd($this->currentShownImageIndex);
        return view('livewire.posts.create-edit');
    }
}
