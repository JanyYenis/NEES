<div class="row">
    <div class="col-md-4">
        <img src="{{ asset('storage/'.$categoria?->imagenActiva?->url ?? '#') }}" alt="" class="img-fluid rounded">
    </div>
    <div class="col-md-8">
        <h3 class="text-white">{{ $categoria?->nombre ?? 'N/A' }}</h3>
        <p class="text-muted mb-3" id="verDescripcion">{{ $categoria?->descripcion ?? 'N/A' }}</p>
        <div class="detail-row">
            <strong>Estado:</strong>
            <span>
                @component('sistema.estado')
                    @slot('concepto', $categoria?->infoEstado)
                @endcomponent
            </span>
        </div>
        <div class="detail-row">
            <strong>Productos asociados:</strong>
            <span>{{ count($categoria->productosActivos) }} productos</span>
        </div>
        <div class="detail-row">
            <strong>Fecha de creación:</strong>
            <span>{{ $categoria?->created_at ?? 'N/A' }}</span>
        </div>
    </div>
</div>
