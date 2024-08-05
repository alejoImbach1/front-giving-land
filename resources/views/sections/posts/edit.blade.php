<x-app-layout>
    @pushOnce('links')
        <link rel="stylesheet" href="{{ asset('css/posts/create.css') }}">
        {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script> --}}
    @endPushOnce

    <main class="pt-24 pb-6 px-2 screen-size">
        <div class="bg-gris-claro rounded px-6 py-10 max-w-3xl my-0 mx-auto">
            <h1 class="texto-verde text-3xl text-center mb-8">
                Editar publicación
            </h1>
            <livewire:posts.create-edit :$post/>
        </div>
    </main>
</x-app-layout>