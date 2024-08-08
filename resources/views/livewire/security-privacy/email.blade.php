<div>
    <label class="text-xl font-semibold block p-4 w-full text-start rounded cursor-pointer hover:bg-gray-200">
        Cambiar correo electrónico
        <input type="checkbox" wire:model.live='displayed' class="hidden">
    </label>
    @if ($displayed)
        <form class="px-4 mb-8" wire:submit='update()'>
            <div class="mb-4">
                <x-input-all label-text="Nuevo correo electrónico:" wire:model='email' name="email" type="email"
                    class="w-full" wire:input='onChanged()' />
            </div>
            <button type="submit" class="boton-base verde-blanco disabled:opacity-75 disabled:cursor-default"
                @disabled(!$inputChanged)>Guardar</button>
        </form>
    @endif
</div>
