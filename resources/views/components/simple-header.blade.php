<div class="z-10 fixed top-0 py-2 bg-gris-claro w-full">
    <div {{ $attributes->merge(['class' => 'screen-size px-6']) }}>
        <a class="flex items-center" href="/">
            <img class="size-12" src="{{asset('appicons/logo-verde.svg')}}" alt="">
            <p class="texto-verde font-bold text-xl ml-3 inline-block">Giving-Land</p>
        </a>
        @if ($slot->hasActualContent())
            {{$slot}}
        @endif
    </div>
</div>