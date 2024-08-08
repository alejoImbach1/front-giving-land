<div>
    <form wire:submit='verify()' class="auth-form bg-gris-claro">
        <h2 class="text-center texto-verde text-3xl mb-6">Eliminación de cuenta</h2>

        <div class="mb-10">
            <x-input-all label-text="Contraseña actual:" wire:model='password' name="password" type="password" class="w-full"
                wire:input='onChanged()' />
        </div>
        <div class="mb-10">
            <x-input-all label-text="Confirmar contraseña actual:" wire:model='password_confirmation'
                name="password_confirmation" type="password" class="w-full" wire:input='onChanged()' />
        </div>

        <div>
            <button type="submit" class="boton-base bg-red-800 text-white mr-4 disabled:opacity-75 disabled:cursor-default"
                type="submit" @disabled(!$inputChanged)>Eliminar</button>

            <a href="{{ route('profiles.show', session('auth_user')['username']) }}"
                class="boton-base bg-gray-300 font-semibold" type="submit">Cancelar</a>
        </div>
    </form>

    @if ($dialogDisplayed)
        <x-popup-livewire max-width="md" wire:model='dialogDisplayed'>
            <div class="bg-gris-claro rounded-lg p-8">
                <div class="flex flex-wrap mb-3 text-lg">
                    <p>¿Estás segura/o de &nbsp;<b>eliminar tu cuenta</b>?</p>
                    <p class="mt-2">Todos tus datos se borrarán</p>
                </div>
                <button class="boton-base bg-red-500 mr-3" wire:click='destroy()'>Eliminar</button>
                <a href="{{ route('profiles.show', session('auth_user')['username']) }}"
                    class="boton-base bg-gris text-white">Cancelar</a>
            </div>
        </x-popup-livewire>
    @endif
</div>
