@props(['tituloPagina' => 'Giving-land'])
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $tituloPagina }}</title>
    {{-- <script src="https://cdn.tailwindcss.com"></script> --}}
    @vite('resources/css/app.css')
    {{-- @vite('resources/css/app.css') --}}
    <link href="{{ asset('fontawesome/css/fontawesome.css') }}" rel="stylesheet" />
    <link href="{{ asset('fontawesome/css/brands.css') }}" rel="stylesheet" />
    <link href="{{ asset('fontawesome/css/solid.css') }}" rel="stylesheet" />
    @livewireStyles
    <link rel="stylesheet" href={{ asset('css/global.css') }}>
    <link rel="icon" type="image/svg+xml" href="{{ asset('appicons/logo-sm.svg') }}">
    <script src={{ asset('js/global.js') }}></script>
    @stack('links')
</head>

<body>
    {{-- <livewire:alert />
    @session('alert')
        <x-alert :type="$value['type']" :message="$value['message']" id="divAlert" />
    @endsession --}}
    {{ $slot }}
    @stack('modals')

    @livewireScripts

    @stack('scripts')
</body>

</html>
