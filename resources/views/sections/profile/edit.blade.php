<x-app-layout>
    <div class="pt-24 pb-6">
        <div class="bg-gris-claro rounded p-10 max-w-2xl my-0 mx-auto">
            {{-- <livewire:profile.edit.image :$profile/> --}}
            <hr>
            <livewire:profile.edit.social-media :$profile :$allSocialMedia/>
            <hr>
            {{-- <livewire:profile.edit.contact-information /> --}}
            <hr class="mb-4">
            <a class="boton-base verde-blanco" href="{{route('profiles.show',session('auth_user')['username'])}}">Regresar al perfil</a>
        </div>
    </div>
</x-app-layout>