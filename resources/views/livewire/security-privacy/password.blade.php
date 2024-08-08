<div>
    <label class="text-xl font-semibold block p-4 w-full text-start rounded cursor-pointer hover:bg-gray-200">
        Cambiar contraseña
        <input type="checkbox" wire:model.live='displayed' class="hidden">
    </label>
    @if ($displayed)
        <form class="px-4 mb-8" wire:submit='update()'>
            <div class="mb-8">
                <x-input-all label-text="Contraseña actual:" wire:model='current_password' name="current_password"
                    type="password" class="w-full" wire:input='onChanged()' autofocus/>
            </div>
            <div class="mb-8">
                <x-input-all label-text="Nueva contraseña:" wire:model='password' name="password" type="password"
                    class="w-full" wire:input='onChanged()' />
            </div>
            <div class="mb-8">
                <x-input-all label-text="Confirmar nueva contraseña:" wire:model='password_confirmation'
                    name="password_confirmation" type="password" class="w-full" wire:input='onChanged()' />
            </div>
            <button type="submit" class="boton-base verde-blanco disabled:opacity-75 disabled:cursor-default"
                @disabled(!$inputChanged)>Guardar</button>
        </form>
    @endif
</div>
