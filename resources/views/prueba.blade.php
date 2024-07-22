<x-html>
    @session('p')
        <div>{{$value}}</div>
    @endsession
    <x-alert type='success' message="funciona"/>
    <div>hello</div>
</x-html>