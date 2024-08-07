<x-html titulo-pagina="Giving Land - Login">
    <x-simple-header class="flex justify-between items-center">
        <a href="{{route('register')}}" class="boton-base verde-blanco">Registro</a>
    </x-simple-header>

    <div class="h-screen pt-16 grid place-items-center px-4 w-full">
        <x-form ruta-siguiente="login.attempt" class="auth-form bg-gris-claro">
            <h2 class="text-center texto-verde text-3xl mb-6">Inicio de sesión</h2>

            <div class="mb-10">
                <x-input-all type="email" name="email" label-text="Correo electrónico:" value="{{old('email')}}" autofocus />
            </div>

            <div class="mb-3">
                <x-input-all type="password" name="password" label-text="Contraseña:"/>
            </div>
            <div class="text-right mb-10">
                <a href="{{route('forgot_password')}}"
                    class="texto-gris hover-oscuro">
                    ¿Olvidaste la contraseña?
                </a>
            </div>

            <div class="flex flex-col">
                <button class="boton-base verde-blanco mb-4" type="submit">Iniciar sesión</button>
                <a href="{{route('auth.google')}}"
                    class="boton-base blanco-gris w-full flex justify-center items-center shadow-sm">
                    <img class="size-7" src="{{ asset('appicons/icon-google.svg') }}" alt="">
                    <p class="text-base ml-2">Iniciar con Google</p>
                </a>
            </div>
        </x-form>
    </div>
</x-html>
