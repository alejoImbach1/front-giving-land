<a @class([
    'hover-gris-claro p-2 rounded flex items-center w-full',
    'border-l-4 border-green-700' =>
        request('username') == session('auth_user')['username'],
]) href="{{ route('profiles.show', $username) }}">
    <img class="size-8 redondo mr-2" src="{{ $profileImageUrl }}">
    <h4>{{ session('auth_user')['name'] }}</h4>
</a>
