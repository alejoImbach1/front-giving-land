@props(['id','maxWitdh'])
@php
    $maxWidth = [
        'sm' => 'sm:max-w-sm',
        'md' => 'sm:max-w-md',
        'lg' => 'sm:max-w-lg',
        'xl' => 'sm:max-w-xl',
        '2xl' => 'sm:max-w-2xl',
        'screen-size' => 'sm:max-w-7xl',
    ][$maxWidth ?? 'lg'];
@endphp
<div id="{{$id}}" class="popup fixed inset-0 bg-gray-800 bg-opacity-50 hidden z-40 px-2">
    <div class="mx-auto mt-32 {{$maxWidth}}">
        {{$slot}}
    </div>
</div>