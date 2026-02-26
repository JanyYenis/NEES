<div class="products-grid">
    @foreach ($productos as $producto)
        <div class="product-card">
            <div class="product-image-wrapper">
                <img src="{{ asset('storage/'.$producto?->imagenesActivas?->get(0)?->url ?? '#') }}" alt="{{ $producto->nombre ?? 'imagen' }}" class="product-image">

                <div class="product-badges">
                    <span class="badge-3d"><i class="bi bi-box"></i> 3D</span>
                </div>

                <span class="badge-color" style="background-color: {{ $producto->color }};" title="{{ $producto->color }}"></span>

                <div class="product-overlay">
                    <a href="{{ route('detalle', ['producto' => $producto?->id]) }}" class="btn-view-details">
                        <i class="bi bi-eye me-2"></i>Ver Detalles
                    </a>
                </div>
            </div>
            <div class="product-card-body">
                <h5 class="product-title">{{ $producto?->nombre ?? 'N/A' }}</h5>
                <p class="product-description">{{ $producto?->descripcion ?? 'N/A' }}</p>
                <div class="product-meta">
                    <span class="product-category-badge">{{ $categoria?->nombre ?? 'N/A' }}</span>
                    <a href="https://wa.me/573165212425" class="btn-card-action">
                        <i class="bi bi-file-text me-1"></i>Cotizar
                    </a>
                </div>
            </div>
        </div>
    @endforeach
</div>

<div class="">
    @component("paginado")
        @slot("catidadDatos", $productos)
        @slot("ultimaPagina", $ultimaPagina)
        @slot("paginaActual", $paginaActual)
    @endcomponent
</div>
