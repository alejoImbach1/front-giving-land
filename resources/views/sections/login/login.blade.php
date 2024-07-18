<x-html titulo-pagina="Giving Land - Login">
    <x-simple-header class="flex justify-between items-center">
        <a class="boton-base verde-blanco">Registro</a>
    </x-simple-header>

    <div class="h-screen pt-16 grid place-items-center px-4">
        <x-form ruta-siguiente="login.attempt" class="auth-form shadow shadow-gray-400 bg-gris-claro">
            <h2 class="text-center texto-verde text-3xl mb-6">Inicio de sesión</h2>

            <x-forms.input type="email" name="email" label-text="Correo electrónico:" class="mb-10" autofocus />

            <x-forms.input type="password" name="password" label-text="Contraseña:" class="mb-10">
                {{-- <div class="text-right mt-3">
                    <a href={{ route('resetPassword.index') }}
                        class="texto-gris hover-oscuro">
                        ¿Olvidaste la contraseña?
                    </a>
                </div> --}}
            </x-forms.input>

            <div class="flex flex-col">
                <button class="boton-base verde-blanco mb-4" type="submit">Iniciar sesión</button>
                <a href="/google-auth/redirect"
                    class="boton-base blanco-gris w-full flex justify-center items-center shadow-sm">
                    <img class="size-7" src="{{ asset('appicons/icon-google.svg') }}" alt="">
                    <p class="text-base ml-2">Iniciar con Google</p>
                </a>
            </div>
        </x-form>
    </div>
</x-html>
