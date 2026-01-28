<!-- Galería de imágenes -->
<div class="row mb-4" id="galeriaImagenes">
    @foreach ($material->imagenesActivas as $index => $imagen)
        <div class="col-md-6 mb-3">
            <img src="{{ asset('storage/'.$imagen?->url ?? '#') }}" alt="Material" class="w-100 rounded" style="height: 250px; object-fit: cover"
                id="verImagen{{ $index+1 }}" />
        </div>
    @endforeach
</div>

<div class="detail-row">
    <strong>Nombre:</strong>
    <span>{{ $material?->nombre ?? 'N/A' }}</span>
</div>
<div class="detail-row">
    <strong>Descripción:</strong>
    <span class="text-muted">{{ $material?->descripcion ?? 'N/A' }}</span>
</div>
<div class="detail-row">
    <strong>Cantidad / Unidad:</strong>
    <span>
        @component('materiales.columnas.cantidad-unidad')
            @slot('concepto', $material?->infoTipo)
            @slot('cantidad', $material?->cantidad ?? 0)
            @slot('unidad_personalizada', $material?->unidad_personalizada ?? null)
        @endcomponent
    </span>
</div>
<div class="detail-row">
    <strong>Estado:</strong>
    <span>
        @component('sistema.estado')
            @slot('concepto', $material?->infoEstado)
        @endcomponent
    </span>
</div>
<div class="detail-row">
    <strong>Fecha de creación:</strong>
    <span class="text-muted">{{ $material?->created_at ?? 'N/A' }}</span>
</div>
