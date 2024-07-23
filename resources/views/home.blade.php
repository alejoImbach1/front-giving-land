{{-- <x-app-layout>

</x-app-layout> --}}
<x-app-layout titulo-pagina="Giving Land">
    @pushOnce('links')
        <link rel="stylesheet" href={{ asset('css/home.css') }}>
    @endPushOnce
    {{-- <x-simple-header/> --}}

    {{-- main --}}
    <main class="contenido-main screen-size flex justify-center md:justify-between">
        {{-- Filtro lateral --}}
        <div class="menu-opciones-lateral">
            @backauth
                <a class="inline-block boton-base verde-blanco mb-4" href="{{ route('posts.create') }}">Publicar artículo</a>
            @endbackauth
            <div class="bg-gris-claro mt-3 ps-2 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                    class="bi bi-filter" viewBox="0 0 16 16">
                    <path
                        d="M6 10.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 0 1h-3a.5.5 0 0 1-.5-.5m-2-3a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5m-2-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5" />
                </svg>
                <span class="ps-2 pt-1 pb-1 fw-bold">Filtro</span>
            </div>
            <ul class="flex flex-col">
                <a href="{{ route('home') }}">Ver todo</a>
                {{-- @foreach ($categories as $category)
                    <a href="{{ route('categories.show', $category->name) }}">{{ $category->name }}</a>
                @endforeach --}}
            </ul>
        </div>
        {{-- posts --}}
        <livewire:home-posts />
        
        {{-- publicidad lateral --}}
        <x-publicidad-lateral />
    </main>

    {{-- footer --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>

</x-app-layout>
