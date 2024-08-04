@php
    $response = Illuminate\Support\Facades\Http::authtoken()->get('/user',['included' => 'profile.image']);

    $authUser = $response->successful() ? $response->object() : null;
@endphp

@backauth
    @php
        $profile = $authUser->profile;
        // dd($profile);
        $imageUrl = $profile->image ? env('back_public_storage') . '/' . $profile->image->url : $profile->google_avatar;
        // dd($imageUrl);
    @endphp
@endbackauth
<div {{ $attributes->class(['z-40 fixed top-0 py-2 bg-gris-claro w-full']) }}>
    <div class="navigation-header screen-size">
        {{-- Logo --}}
        <a class="flex items-center" href="{{ route('home') }}">
            <img class="size-12" src="{{ asset('appicons/logo-verde.svg') }}" alt="">
            <p class="texto-verde font-bold text-xl ml-3 inline-block">Giving-Land</p>
        </a>

        {{-- Buscador --}}
        <div class="buscador flex items-center">
            <label for="txtbuscador">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="gray" class="bi bi-search"
                    viewBox="0 0 16 16">
                    <path
                        d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0" />
                </svg>
            </label>
            <input class="w-100" type="text" name="txtbuscador" placeholder="Buscar">
        </div>

        {{-- autenticado --}}
        <div class="navigation-header-options relative">
            @backauth
                <div class="dropdown relative">
                    <img class="size-10 redondo cursor-pointer dropdown-button" src="{{ $imageUrl }}" alt="">
                    <div class="dropdown-menu absolute right-0 mt-2 w-56 top-8 rounded-md bg-white shadow-lg hidden">
                        <div class="py-1">
                            <a href="{{ route('profiles.show', $authUser->username) }}"
                                class="text-gray-700 block px-4 py-2 text-sm hover:bg-gray-100">Perfil</a>
                            <hr>
                            <form method="POST" action={{ route('logout') }}>
                                @csrf
                                <a onclick="this.closest('form').submit()" type="submit"
                                    class="text-gray-700 block w-full px-4 py-2 text-left text-sm cursor-pointer hover:bg-gray-100">Cerrar
                                    sesión</a>
                            </form>
                        </div>
                    </div>
                </div>
            @endbackauth
            @backguest
                <a class="boton-base verde-blanco ps-3 pe-3 pt-1 pb-1 me-2" href={{ route('login') }}>Inicio
                    sesion</a>
                <a class="boton-base verde-blanco ps-3 pe-3 pt-1 pb-1" href={{ route('register') }}>Registro</a>
            @endbackguest
        </div>

    </div>
</div>
