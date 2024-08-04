<?php

namespace App\Livewire\Posts;

use App\MyOwn\classes\Utility;
use Illuminate\Support\Facades\File;
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
    public $initPostImagesNames;

    #[Locked]
    public $deletedInitPostImagesNames;

    #[Locked]
    public $newImagesNames;

    public $inputImages;

    public $imagesUrls;
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
        $this->initPostImagesNames = [];
        $this->deletedInitPostImagesNames = [];
        $this->imagesUrls = [];
        $this->inputImages = [];
        $this->newImagesNames = [];
        $this->currentShownImageIndex = 0;
        if ($post !== null) {
            $this->fill($post);
            $images = $post->images;
            foreach ($images as $image) {
                $this->imagesUrls[] = 'posts_images/' . auth()->user()->username . '/' . $image->url;
                $this->initPostImagesNames[] = $image->url;
                // Storage::copy('public/posts_images/' . auth()->user()->username . '/' . $imageName, 'public/livewire-tmp/' . $imageName);
            }
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
    }

    public function showPreviousImage()
    {
        if (count($this->imagesUrls) > 1 && $this->currentShownImageIndex != array_key_first($this->imagesUrls)) {
            $this->currentShownImageIndex--;
        }
    }

    public function showNextImage()
    {
        if (count($this->imagesUrls) > 1 && $this->currentShownImageIndex != array_key_last($this->imagesUrls)) {
            $this->currentShownImageIndex++;
            // dd('next');
        }
    }

    public function removeImage($index)
    {
        // $temp = ['a','b','c','d','e'];
        if ($index > 0 && $index < count($this->imagesUrls)) {
            $this->currentShownImageIndex--;
        }
        // $this->deletedInitPostImagesNames = 
        if (in_array(basename($this->imagesUrls[$index]), $this->initPostImagesNames)) {
            $this->deletedInitPostImagesNames[] = basename($this->imagesUrls[$index]);
        } else {
            Storage::delete('public/livewire-tmp/' . basename($this->imagesUrls[$index]));
            array_splice($this->newImagesNames, array_search(basename($this->imagesUrls[$index]), $this->newImagesNames), 1);
        }
        array_splice($this->imagesUrls, $index, 1);
        // dd($temp);
    }

    public function see()
    {
        // dd(basename($this->imagesUrls[0]));
        dd(auth()->user()->posts->last());
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
        // $this->validate(
        //     StoreUpdatePostRequest::rules(),
        //     [
        //         'purpose.required' => 'El propósito es requerido',
        //         'expected_item.required' => 'El artículo de interés es requerido',
        //         'location_id.required' => 'La ubicación es requerida',
        //         'category_id.required' => 'La categoría es requerida',
        //     ],
        //     [
        //         'imagesUrls' => 'imágenes',
        //     ]
        // );
        // $user = auth()->user();
        // $post = $user->posts()->updateOrCreate($this->only('id'), $this->only(['name', 'purpose', 'expected_item', 'description', 'location_id', 'category_id']));
        // foreach ($this->newImagesNames as $imageName) {
        //     $post->images()->create(['url' => $imageName]);
        //     Storage::move('public/livewire-tmp/' . $imageName, 'public/posts_images/' . $user->username . '/' . $imageName);
        // }
        // if ($this->id !== null) {
        //     $currentPostImages = Post::find($this->id)->images;
        //     foreach ($this->deletedInitPostImagesNames as $imageName) {
        //         $currentPostImages->where('url', $imageName)->first()->delete();
        //         Storage::delete('public/posts_images/' . $user->username . '/' . $imageName);
        //     }
        // } else {
        //     $post->update(['user_post_index' => (count($user->posts) > 1) ? ($user->posts[count($user->posts) - 2]->user_post_index + 1) : 0]);
        // }
        // Storage::deleteDirectory('public/livewire-tmp');
        // Utility::sendAlert('success', ($this->id) ? 'Se editó correctamente' : 'Se publicó el artículo');
        // return to_route('profile.show', $user->username);
        $authUserResponse = Http::authtoken()->get('/user');
        if ($this->isCreate) {
            foreach ($this->imagesUrls as $imageUrl) {
                $multipart[] = [
                    'name' => 'images[]',
                    'contents' => Storage::get('public/' .$imageUrl),
                    'filename' => basename($imageUrl),
                ];
            }
            // dd('hello');
            $storeResponse = Http::authtoken()->attach($multipart)->post('posts',$this->only(['name', 'purpose', 'expected_item', 'description', 'location_id', 'category_id']));
            Utility::viewAlert($storeResponse->successful() ? 'success' : 'danger',$storeResponse->object()->message);
            return to_route('profiles.show',$authUserResponse->object()->username);
        }
    }

    public function updated($inputImages)
    {
        if ($inputImages === 'inputImages') {
            if (count($this->imagesUrls) + count($this->inputImages) < 6) {
                $this->currentShownImageIndex = count($this->imagesUrls);
                foreach ($this->inputImages as $uploadedImage) {
                    $imageName = $uploadedImage->getFilename();
                    Storage::copy('livewire-tmp/' . $imageName, 'public/livewire-tmp/' . $imageName);
                    $this->imagesUrls[] = 'livewire-tmp/' . $imageName;
                    $this->newImagesNames[] = $imageName;
                }
            } else {
                $this->js("alert('¡Solo puedes subir 5 imágenes como máximo!')");
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
