<x-profile.index :$profileImageUrl>
    <div class="flex items-start w-full">
        <div class="max-w-lg w-full mx-auto bg-gris-claro p-8 rounded-md">
            <livewire:security-privacy.name />
            {{-- <hr class="my-2"> --}}
            <livewire:security-privacy.username />
            {{-- <hr class="my-2"> --}}
            <livewire:security-privacy.email />
            {{-- <hr class="my-2"> --}}
            <livewire:security-privacy.password />
            <a
                href="{{ route('security-privacy.account-deletion') }}" class="text-xl font-semibold block p-4 w-full text-start rounded cursor-pointer hover:bg-gray-200">
                Eliminar cuenta
            </a>
            {{-- <h1 class="text-3xl text-center ">Seguridad y privacidad</h1> --}}
        </div>
    </div>

</x-profile.index>
