@props(['text' => ''])
<label {{$attributes}}>
    <p class="texto-verde text-lg">{{ $text }}</p>
    {{$slot}}
</label>