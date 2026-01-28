@if (isset($imagenes))
    @foreach ($imagenes as $imagen)
        <img src="{{ asset('storage/' . $imagen?->url ?? '#') }}" alt="{{ $nombre }}" class="table-img">
    @endforeach
@else
    <img src="{{ asset('storage/' . $imagen) }}" alt="{{ $nombre }}" class="table-img">
@endif
