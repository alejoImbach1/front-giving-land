<div class="pb-4">
    {{-- Pop up cambiar imagen --}}
    <x-popup-livewire max-width="sm" wire:model='editDisplayed'>
        <form class="rounded py-8 px-2 flex flex-col items-center" wire:submit='update'>
            @if ($photo)
                <img class="size-48 redondo mb-6 mx-auto" src="{{ $photo->temporaryUrl() }}">
            @else
                <img class="size-48 redondo mb-6 mx-auto" src="{{ $initImageUrl }}">
            @endif
            <div>
                <input wire:input='photoLoaded' type="file" accept="image/*" id="inputImg" wire:model='photo' hidden>
                <label class="boton-base bg-yellow-200" for="inputImg">Seleccionar imagen</label>
            </div>

            <div class="mt-4 min-w-16 flex flex-between">
                <button class="boton-base verde-blanco disabled:opacity-75 mr-6" type="submit"
                    @disabled($submitDisabled)>Guardar</button>
                <button class="boton-base bg-gray-500 text-white" type="reset" x-on:click="show = false"
                    wire:click='cancel'>Cancelar</button>
            </div>
        </form>
    </x-popup-livewire>

    {{-- Popup eliminar foto de perfil --}}
    <x-popup-livewire max-width="sm" wire:model='deleteDisplayed'>
        <form class="bg-gris-claro rounded-lg p-8" wire:submit="delete">
            <p class="mb-3 text-lg">¿Estás segura/o de eliminar tu foto de perfil?</p>
            <button type="submit" class="boton-base bg-red-500 mr-3">Eliminar</button>
            <button type="button" class="boton-base bg-gris text-white" x-on:click="show = false">Cancelar</button>
        </form>
    </x-popup-livewire>

    {{-- ver imagen y acciones --}}
    <h2 class="texto-verde mb-2 text-2xl">Imagen de perfil:</h2>
    <div>
        <div class="flex w-full items-center">
            <img class="size-16 redondo mr-4" src="{{ $initImageUrl }}">
            <div>
                <i class="p-2 rounded cursor-pointer bg-yellow-300 mr-4 fa-solid fa-pen" wire:click='edit'></i>

                @if ($profile['google_avatar'] || basename($profile['image']['url']) != 'default.svg')
                    <i class="p-2 rounded cursor-pointer bg-red-500 fa-solid fa-trash" wire:click='dialogDelete'></i>
                @endif
            </div>
        </div>
    </div>
</div>
