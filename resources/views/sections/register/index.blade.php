<x-html>
    <x-simple-header class="flex justify-between items-center">
        <a href="{{route('login')}}" class="boton-base verde-blanco">Inicio de sesión</a>
    </x-simple-header>

    <main class="h-screen pt-16 grid place-items-center px-4 w-full">
        <x-form ruta-siguiente="register.attempt" class="auth-form bg-gris-claro">
            <h2 class="text-center texto-verde text-3xl mb-6">Registro</h2>

            <div class="mb-10">
                <x-input-all type="text" name="name" label-text="Nombre completo:" value="{{old('name')}}" autofocus />
            </div>

            <div class="mb-10">
                <x-input-all type="email" name="email" label-text="Correo electrónico:" value="{{old('email')}}" />
            </div>

            <div class="mb-10">
                <x-input-all type="password" name="password" label-text="Contraseña:"/>
            </div>

            <div>
                <x-input-all type="password" name="password_confirmation" label-text="Confirmar contraseña:"/>
            </div>

            <div class="flex flex-col mt-10">
                <button class="boton-base verde-blanco mb-4" type="submit">Registrarse</button>
                <a href="{{route('auth.google')}}"
                    class="boton-base blanco-gris w-full flex justify-center items-center shadow-sm">
                    <img class="size-7" src="{{ asset('appicons/icon-google.svg') }}" alt="">
                    <p class="text-base ml-2">Registrarse con Google</p>
                </a>
            </div>
        </x-form>
    </main>
</x-html>