<div class="py-4 overflow-x-auto">

    <h1 class="text-2xl texto-verde mb-4">Información de contacto:</h1>

    <!-- Tabla de información de contacto -->
    @if (count($profile['contact_information']))
        <table class="min-w-full">
            <thead class="">
                <tr>
                    <th class="py-2 pr-2 text-left">Nombre</th>
                    <th class="py-2 pr-2 text-left">Información</th>
                    <th class="py-2 pr-2 text-left">Enlace</th>
                    <th class="py-2 text-center">Acciones</th>
                </tr>
            </thead>
            <tbody class="">
                {{-- <!-- Aquí se llenarían dinámicamente los datos de la tabla con datos del servidor --> --}}
                @foreach ($profile['contact_information'] as $profileItem)
                    <tr>
                        <td class="py-3">{{ $profileItem['name'] }}</td>
                        <td class="py-3 max-w-52 truncate">{{ $profileItem['info'] }}</td>
                        <td class="py-3 text-center">
                            @if ($profileItem['is_link'])
                                Sí
                            @else
                                No
                            @endif
                        </td>
                        <td class="py-3 text-center">
                            <i class="p-2 rounded cursor-pointer bg-yellow-300 mr-4 fa-solid fa-pen"
                                wire:click="editOrCreate({{ $profileItem['id'] }})"></i>
                            <i class="p-2 rounded cursor-pointer bg-red-500 fa-solid fa-trash"
                                wire:click='dialogDestroy({{ $profileItem['id'] }})'></i>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p class="my-4">No tienes información de contacto aún</p>
    @endif

    {{-- botón para agregar info --}}
    @if (!$editOrCreateDisplayed && count($profile['contact_information']) < 5)
        <buton class="bg-blue-700 boton-base text-white mb-4 rounded" wire:click='editOrCreate()'>
            Agregar
        </buton>
    @endif

    {{-- Crear o editar una información de contacto --}}
    @if ($editOrCreateDisplayed)
        <form class="bg-gris-claro rounded-lg border-2 p-2" wire:submit='updateOrStore()'>
            <div class="grid mb-4" style="grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));">
                <div class="div-form-input mr-4">
                    <x-input-all label-text='Nombre' class="w-full text-gray-900 placeholder:text-base" type="text"
                        wire:model="name" name='name' wire:input='onChange' maxlength="20"
                        placeholder="página web, dirección, etc" id="contact_information_input_name" />
                </div>
                <div class="div-form-input">
                    <div class="flex justify-between">
                        <label class="texto-verde text-lg"
                            for="contact_information_input_information">Información</label>
                        <label class="cursor-pointer text-lg" title="Se podrá navegar con un click">
                            <i class="fa-solid fa-circle-question fa-xs"></i>
                            Es enlace
                            <input class="text-gray-900 cursor-pointer" type="checkbox" wire:model='is_link' tabindex="-1"
                                @checked($is_link)>
                        </label>
                    </div>
                    <x-input-all class="w-full" maxlength="255" wire:model="info" name='info' wire:input='onChange'
                        type="text" id="contact_information_input_information" />
                </div>
            </div>
            <div>
                <button type="submit" class="boton-base verde-blanco mr-3 disabled:opacity-75">Agregar</button>
                <button type="button" class="boton-base gris-blanco" wire:click='cancel'>Cancelar</button>
            </div>
        </form>
    @endif

    {{-- Pop up diálogo de confirmación de eliminación --}}
    @if ($item && $deleteDisplayed)
        <x-popup-livewire max-width="md" wire:model='deleteDisplayed'>
            <form class="bg-gris-claro rounded-lg p-8" wire:submit='destroy()'>
                <div class="flex flex-wrap mb-3 text-lg">
                    ¿Estás segura/o de eliminar&nbsp;<b>{{ $item['name'] . ' : ' . $item['info'] }}</b>?
                </div>
                <button type="submit" class="boton-base bg-red-500 mr-3">Eliminar</button>
                <button type="button" class="boton-base bg-gris text-white" x-on:click="show = false">Cancelar</button>
            </form>
        </x-popup-livewire>
    @endif

</div>
