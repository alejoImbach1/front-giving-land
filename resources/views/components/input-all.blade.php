@props([
    'labelText' => '',
    'isRequired' => false,
])
<label>
    <span>
        <span @class(['text-red-600 inline-block', 'hidden' => !$isRequired])>*</span>
        <p class="texto-verde text-lg">{{ $labelText }}</p>
    </span>
    <x-input {{$attributes}}/>
</label>
@if($attributes->has('name'))
    @error($attributes->get('name'))
        <span @class(['text-red-500'])>* {{ $message }}</span>
    @enderror
@endif