<x-html>
    <x-simple-header class="flex justify-between items-center">
        <a href="{{ route('login') }}">Volver al inicio de sesión</a>
    </x-simple-header>

    <div class="h-screen pt-16 grid place-items-center px-4">
        <x-form ruta-siguiente="forgot_password.send_email" class="auth-form shadow shadow-gray-400 bg-gris-claro">
            <h1 class="text-center text-3xl texto-verde mb-6">Recuperación de contraseña</h1>

            <div class="mb-10">
                <x-input-all autofocus type="email" name="email" label-text="Correo electrónico:"/>
                <p class="texto-gris mt-2">Se enviará un código de verificación</p>
            </div>

                
            {{-- <input type="hidden" name="token" value="{{ $token }}"> --}}

            <button class="w-full boton-base verde-blanco mb-4" type="submit">Enviar código</button>
        </x-form>
    </div>
</x-html>
