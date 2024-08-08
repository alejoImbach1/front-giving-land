<div class="mt-10 rounded bg-gris-claro shadow-md">
    <div class="relative w-full h-60 md:h-72 overflow-y-hidden" data-carousel="static">

        <!-- Carousel wrapper -->
        <div class="relative overflow-hidden rounded-lg h-96">
            @foreach ($post['images'] as $image)
                <div class="hidden duration-700 ease-in-out" data-carousel-item>
                    <img src="{{ env('back_public_storage') . '/' . $image['url'] }}"
                        class="absolute block w-full md:top-1/2 md:-translate-y-1/2 -translate-x-1/2  left-1/2"
                        alt="...">
                </div>
            @endforeach
        </div>
        @notOwner($username)
            <div class="absolute top-0 left-0 z-30 m-2">
                <livewire:favorites.favorite-toggle :post-id="$post['id']" :$favorites />
            </div>
        @endnotOwner
        @if (count($post['images']) > 1)
            <!-- Slider controls -->
            <button type="button"
                class="absolute top-1/2 start-0 z-30 flex items-center justify-center p-4 cursor-pointer group focus:outline-none"
                data-carousel-prev>
                <span
                    class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                    <svg class="w-4 h-4 text-white dark:text-gray-800 rtl:rotate-180" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M5 1 1 5l4 4" />
                    </svg>
                    <span class="sr-only">Previous</span>
                </span>
            </button>
            <button type="button"
                class="absolute top-1/2 z-30 end-0 flex items-center justify-center p-4 cursor-pointer group focus:outline-none"
                data-carousel-next>
                <span
                    class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                    <svg class="w-4 h-4 text-white dark:text-gray-800 rtl:rotate-180" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 9 4-4-4-4" />
                    </svg>
                    <span class="sr-only">Next</span>
                </span>
            </button>
        @endif
    </div>
    @backauth
        <div class="dropdown relative z-30">
            <i
                class="fa-solid fa-ellipsis absolute right-0 top-1 text-lg leading-none bg-gray-300 rounded-md px-2 cursor-pointer dropdown-button"></i>
            <div class="dropdown-menu absolute right-0 my-2 w-24 top-full z-30 rounded-md bg-white shadow-lg hidden">
                <div class="py-1">
                    @owner($username)
                        <a href="{{ route('posts.edit', $post['id']) }}"
                            class="text-gray-700 block px-4 py-2 text-sm hover:bg-gray-100">Editar</a>
                        <hr>
                        <button data-show-popup="#popup_post_{{ $post['id'] }}"
                            class="text-gray-700 w-full text-start px-4 py-2 text-sm hover:bg-gray-100">Eliminar</button>
                    @endowner
                    @notOwner($username)
                        <a href="#" class="text-gray-700 block px-4 py-2 text-sm hover:bg-gray-100">Reportar</a>
                        <hr>
                    @endnotOwner
                </div>
            </div>
        </div>
    @endbackauth
    <div class="px-2 md:px-6 py-4 relative z-20">
        <h2 class="text-gray-800 text-2xl md:text-3xl font-bold mb-2">{{ $post['name'] }}</h2>
        <p class="py-1 text-ellipsis overflow-hidden max-h-32 md:max-h-20 mb-2">
            {{ $post['description'] }}</p>
        <span class="texto-verde font-bold text-xl capitalize">{{ $post['purpose'] }}</span>
        @isset($post['expected_item'])
            <div class="mb-4">
                <h6 class="text-green-900">Producto de interés a recibir</h6>
                <span>{{ $post['expected_item'] }}</span>
            </div>
        @endisset
        <p class="my-3"><i class="fa-solid fa-location-dot text-gray-700 mr-1"></i>
            {{ $post['location']['municipio'] . ' (' . $post['location']['departamento'] . ')' }}</p>

        @owner($username)
            <p class="font-bold">{{ $post['category']['name'] }}</p>
        @endowner
    </div>
    <x-popup id="popup_post_{{ $post['id'] }}" max-width='md'>
        <form class="bg-gris-claro rounded-lg p-8" wire:submit='destroy()'>
            <div class="flex flex-wrap mb-3 text-lg">
                ¿Estás segura/o de eliminar&nbsp;<b>{{ $post['name'] }}</b>?
            </div>
            <button type="submit" class="boton-base bg-red-500 mr-3">Eliminar</button>
            <button type="button" class="boton-base bg-gris text-white popup-closer">Cancelar</button>
        </form>
    </x-popup>
</div>
