@props(['tituloPagina' => 'Giving-land'])
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $tituloPagina }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="{{ asset('fontawesome/css/fontawesome.css') }}" rel="stylesheet" />
    <link href="{{ asset('fontawesome/css/brands.css') }}" rel="stylesheet" />
    <link href="{{ asset('fontawesome/css/solid.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href={{ asset('css/global.css') }}>
    <link rel="icon" type="image/svg+xml" href="{{ asset('appicons/logo-sm.svg') }}">
    @stack('links')
    @livewireStyles
    <script src={{ asset('js/global.js') }}></script>
</head>

<body>
    {{-- <livewire:alert /> --}}
    @session('alert')
        <div class="z-50 bg-red-500 w-10 h-10">Hello</div>
        {{-- <x-alert :type="$value['type']" :message="$value['message']" id="div_alert" /> --}}
    @endsession
    {{ $slot }}
    @stack('modals')
    @stack('scripts')
    @livewireScripts
</body>

</html>
