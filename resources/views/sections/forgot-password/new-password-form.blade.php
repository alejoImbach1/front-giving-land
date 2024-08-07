<x-html>
    <x-simple-header />
    <div class="h-screen pt-16 grid place-items-center px-4">
        <x-form ruta-siguiente="forgot_password.update_password" class="auth-form shadow shadow-gray-400 bg-gris-claro">
            <h2 class="text-center texto-verde text-3xl mb-6">Restablecimiento de contraseña</h2>

            <div class="mb-8">
                <span>
                    <p class="texto-verde text-lg inline">Correo electrónico:</p>
                    <span class="font-semibold">{{$request->email}}</span>
                </span>
            </div>
            
            <input name="email" type="hidden" value={{ $request->email }} />

            <div class="mb-10">
                <x-input-all type="password" name="password" label-text="Nueva contraseña:" value="" autofocus />
            </div>

            <div class="mb-10">
                <x-input-all type="password" name="password_confirmation" label-text="Confirmación de contraseña:"
                    value="" />
            </div>

            <input name="token" type="hidden" value={{ $request->route('token') }} />

            <button class="w-full boton-base verde-blanco" type="submit">Guardar</button>
        </x-form>
    </div>
</x-html>
