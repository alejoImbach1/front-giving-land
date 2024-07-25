{{-- @php
    dd($posts)
@endphp --}}
<div class="flex flex-wrap gap-4">
    @foreach ($posts as $post)
        <div class="p-4 border border-red-900">
            {{$post['name']}}
            @foreach ($post['images'] as $image)
                <div class="border p-2">
                    {{$image['url']}}
                </div>
            @endforeach
        </div>
    @endforeach
</div>