<x-html>
    
    <div>hello</div>
    <form action="{{env('api_url') . '/profile'}}" enctype="multipart/form-data" method="POST">
        @csrf
        <input type="file" name="image" id="">
        <button type="submit">enviar</button>
    </form>
</x-html>