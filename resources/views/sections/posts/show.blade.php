<x-app-layout>
    <div class="contenido-main screen-size">
        <div class="max-w-3xl mx-auto">
            <livewire:posts.profile-post :$post :$favorites />
            <div class="bg-gris-claro border-t p-4">
                <h2 class="texto-verde font-bold text-lg mb-4">Dueña/o de la publicación</h2>
                <a href="{{ route('profiles.show', $post['user']['username']) }}"
                    class="inline-block py-1 px-2 rounded-md hover:bg-gray-200">
                    <img class="size-14 redondo inline-block"
                        src="{{ !$post['user']['profile']['google_avatar'] ? env('back_public_storage') . '/' . $post['user']['profile']['image']['url'] : $post['user']['profile']['image']['url'] }}"
                        alt="">
                    <span class="font-bold text-xl">{{ $post['user']['name'] }}</span>
                </a>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
</x-app-layout>
