<div class="py-4 overflow-x-auto">
    <h1 class="text-2xl texto-verde">Redes sociales:</h1>

    <!-- Tabla de redes sociales -->
    @if (count($profile['social_media']))
        <table class="min-w-full">
            <thead class="">
                <tr>
                    <th class="py-2 pr-2 text-left">Red</th>
                    <th class="py-2 pr-2 text-left">Link</th>
                    <th class="py-2 text-center">Eliminar</th>
                </tr>
            </thead>
            <tbody class="">
                @foreach ($profile['social_media'] as $profileItem)
                    <tr>
                        <td class="py-3">
                            <img class="size-6" src="{{ asset('socialmediaicons/' . $profileItem['image']['url']) }}"
                                alt="">
                        </td>
                        <td class="py-3 max-w-52 truncate">
                            {{ $profileItem['url'] . $profileItem['pivot']['username'] }}
                        </td>
                        <td class="py-3 text-center">
                            <i class="p-2 rounded cursor-pointer bg-red-500 fa-solid fa-trash"
                                wire:click='dialogDestroy({{ $profileItem['id'] }})'></i>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p class="my-4">No tienes redes sociales agregadas aún</p>
    @endif

    <!-- Botón para agregar red social -->
    @if (count($createSocialMedia) && !$createDisplayed)
        <buton class="bg-blue-700 boton-base text-white mb-4 rounded" wire:click='create'>
            Agregar
        </buton>
    @endif

    {{-- Crear una red social --}}
    @if ($createDisplayed)
        <form class="bg-gris-claro rounded-lg border-2 p-2" wire:submit='store()'>
            <div class="grid gap-x-2 mb-4" style="grid-template-columns: 2fr 1fr">
                <div class="">
                    @if ($createSelectedSocialMediaId == 1)
                        <x-input-all class="w-full" wire:input='onCreateChange' wire:model="inputNumber"
                            name='inputNumber' inputmode="numeric" maxlength="10" type="text" placeholder="Número" />
                    @else
                        <x-input-all class="w-full" maxlength="255" wire:input='onCreateChange'
                            wire:model="inputUsername" name='inputUsername' type="text"
                            placeholder="Nombre de usuario" />
                    @endif
                </div>
                <select class="outline-none bg-transparent cursor-pointer capitalize"
                    wire:model='createSelectedSocialMediaId' wire:input='onCreateChange'>
                    <option value="0" disabled>Seleccione</option>
                    @foreach ($createSocialMedia as $element)
                        <option class="capitalize" value="{{ $element['id'] }}" @selected($createSelectedSocialMediaId == $element['id'])>
                            {{ $element['name'] }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <button type="submit" class="boton-base verde-blanco">
                    Agregar
                </button>
                <button type="button" class="boton-base bg-gris text-white" wire:click='cancelCreate'>Cancelar</button>
            </div>
        </form>
    @endif

    {{-- Diálogo para eliminar --}}
    @if ($item !== null && $deleteDisplayed)
        <x-popup-livewire max-width="md" wire:model='deleteDisplayed'>
            <form class="bg-gris-claro rounded-lg p-8" wire:submit='destroy()'>
                <div class="flex flex-wrap mb-3 text-lg">
                    ¿Estás segura/o de eliminar&nbsp;<b>{{ ucfirst($item['name']) }}</b>?
                </div>
                <button type="submit" class="boton-base bg-red-500 mr-3">Eliminar</button>
                <button type="button" class="boton-base bg-gris text-white" x-on:click="show = false">Cancelar</button>
            </form>
        </x-popup-livewire>
    @endif
</div>
