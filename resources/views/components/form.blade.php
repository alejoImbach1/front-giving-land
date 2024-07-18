@props([
    'rutaSiguiente' => '/',
    'parametro' => null,
    'metodo' => null,
])
<form action={{ route($rutaSiguiente, $parametro) }} method="POST" {{$attributes}}>
    @csrf
    @isset($metodo)
        @method($metodo)
    @endisset
    {{ $slot }}
</form>