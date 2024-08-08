<div class="posts w-full px-4">
    @foreach ($posts as $post)
        <x-posts.home-post :$post :$favorites/>
    @endforeach
</div>
