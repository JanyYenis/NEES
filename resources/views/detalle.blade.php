@extends('layouts.app')

@section('content')
    @vite(['resources/css/main.css', 'resources/css/producto.css', 'resources/js/producto.js'])

    <!-- Product Header -->
    <section class="product-header">
        <div class="blueprint-grid"></div>
        <div class="container" style="position: relative; z-index: 1;">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ url('/') }}">Inicio</a>
                    </li>
                    <li class="breadcrumb-item"><a href="{{ url('/') }}#productos">Productos</a></li>
                    <li class="breadcrumb-item active" id="breadcrumb-category">{{ $producto?->categoria?->nombre ?? 'N/A' }}
                    </li>
                </ol>
            </nav>
            <h1 class="display-4 fw-bold text-white mb-3" id="product-title">{{ $producto?->nombre ?? 'N/A' }}</h1>
            <p class="lead text-white-50" id="product-subtitle">{{ $producto?->descripcion ?? 'N/A' }}</p>
        </div>
    </section>

    <!-- Product Content -->
    <section class="product-content py-5">
        <div class="container">
            <div class="row g-4">
                <!-- Left Column: Gallery & 3D Viewer -->
                <div class="col-lg-8">
                    <!-- Gallery -->
                    <div class="product-gallery mb-4">
                        <div class="main-image-container position-relative">
                            <img id="mainImage"
                                src="{{ asset('storage/' . $producto?->imagenesActivas?->get(0)?->url ?? '#') }}"
                                alt="Imagen principal" class="img-fluid rounded">
                            <button class="btn-fullscreen openFullscreen">
                                <i class="bi bi-arrows-fullscreen"></i>
                            </button>
                        </div>
                        <div class="thumbnails mt-3">
                            <div class="row g-2" id="thumbnailContainer">
                                @foreach ($producto?->imagenesActivas as $index => $img)
                                    <div class="col-3">
                                        <img src="{{ asset('storage/'.$img?->url ?? '#') }}"
                                            class="img-fluid changeMainImage {{ $index === 0 ? "active" : ""}}"
                                            alt="Vista {{ $index + 1 }}">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- 3D Viewer -->
                    <div class="viewer-3d mb-4">
                        <div class="viewer-header d-flex justify-content-between align-items-center mb-3">
                            <h4 class="mb-0">Vista 3D Interactiva</h4>
                            <div class="viewer-controls">
                                <button class="btn btn-sm btn-outline-light me-2" id="lightingToggle">
                                    <i class="bi bi-lightbulb"></i> Iluminación
                                </button>
                                <button class="btn btn-sm btn-outline-light open3DFullscreen">
                                    <i class="bi bi-arrows-fullscreen"></i> Pantalla Completa
                                </button>
                            </div>
                        </div>
                        <div class="viewer-container">
                            <div class="viewer-placeholder">
                                <i class="bi bi-box-seam"></i>
                                <p class="mt-3">Visor 3D Interactivo</p>
                                <p class="text-muted small">Arrastra para rotar • Zoom con scroll</p>
                            </div>
                        </div>
                    </div>

                    <!-- Before/After Slider -->
                    <div class="before-after-section mb-4">
                        <h4 class="mb-3">Antes y Después de la Instalación</h4>
                        <div class="before-after-container">
                            <img src="{{ asset('build/img/modern-industrial-metal-door-in-architectural-sett.jpg') }}"
                                alt="Antes" class="before-image">
                            <img id="afterImage" src="{{ asset('build/img/empty-doorway-before.jpg') }}" alt="Después"
                                class="after-image">
                            <input type="range" min="0" max="100" value="50" class="slider"
                                id="beforeAfterSlider">
                            <div class="slider-button"></div>
                            <div class="before-label">ANTES</div>
                            <div class="after-label">DESPUÉS</div>
                        </div>
                    </div>

                    <!-- Size Comparator -->
                    <div class="size-comparator mb-4">
                        <h4 class="mb-3">Comparación de Tamaño</h4>
                        <div class="comparator-container">
                            <div class="product-silhouette">
                                <div class="door-outline" id="doorOutline"></div>
                            </div>
                            <div class="human-silhouette">
                                <i class="bi bi-person-standing"></i>
                                <span class="size-label">1.75m</span>
                            </div>
                            <div class="dimensions-display">
                                <div class="dimension-item">
                                    <i class="bi bi-arrows-vertical"></i>
                                    <span id="heightDisplay">{{ $producto?->alto }}m</span>
                                </div>
                                <div class="dimension-item">
                                    <i class="bi bi-arrows"></i>
                                    <span id="widthDisplay">{{ $producto?->ancho }}m</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Product Info -->
                <div class="col-lg-4">
                    <!-- Product Info Card -->
                    <div class="info-card mb-4">
                        <h5 class="fw-bold mb-3"><i class="bi bi-info-circle me-2"></i>Información General</h5>
                        <div class="info-item">
                            <span class="info-label">Categoría:</span>
                            <span class="info-value" id="category">{{ $producto?->categoria?->nombre ?? 'N/A' }}</span>
                        </div>
                        {{-- <div class="info-item">
                            <span class="info-label">Código:</span>
                            <span class="info-value" id="productCode">PM-001</span>
                        </div> --}}
                        <div class="info-item">
                            <span class="info-label">Disponibilidad:</span>
                            <span class="badge bg-success">Disponible</span>
                        </div>
                    </div>

                    <!-- Materials Card -->
                    <div class="info-card mb-4">
                        <h5 class="fw-bold mb-3"><i class="bi bi-layers me-2"></i>Materiales</h5>
                        <div id="materialsContainer">
                            @foreach ($producto->materialesActivos as $item)
                                <div class="material-item">
                                    <i class="bi bi-check-circle-fill text-primary"></i>
                                    <span>{{ $item?->material?->nombre ?? 'N/A' }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Dimensions Card -->
                    <div class="info-card mb-4">
                        <h5 class="fw-bold mb-3"><i class="bi bi-rulers me-2"></i>Dimensiones</h5>
                        <div class="dimension-grid">
                            <div class="dimension-box">
                                <div class="dimension-icon"><i class="bi bi-arrows-vertical"></i></div>
                                <div class="dimension-value" id="height">{{ $producto?->alto ?? 0 }} m</div>
                                <div class="dimension-label">Alto</div>
                            </div>
                            <div class="dimension-box">
                                <div class="dimension-icon"><i class="bi bi-arrows"></i></div>
                                <div class="dimension-value" id="width">{{ $producto?->ancho ?? 0 }} m</div>
                                <div class="dimension-label">Ancho</div>
                            </div>
                            <div class="dimension-box">
                                <div class="dimension-icon"><i class="bi bi-arrows-expand"></i></div>
                                <div class="dimension-value" id="depth">{{ $producto?->grosor ?? 0 }} m</div>
                                <div class="dimension-label">Grosor</div>
                            </div>
                        </div>
                    </div>

                    <!-- Colors Card -->
                    <div class="info-card mb-4">
                        <h5 class="fw-bold mb-3"><i class="bi bi-palette me-2"></i>Colores Disponibles</h5>
                        <div class="color-swatches" id="colorContainer">
                            <div class="color-swatch active" data-color="Negro" style="background-color: #1a1a1a;"
                                title="Negro"></div>
                            <div class="color-swatch" data-color="Gris" style="background-color: #4a4a4a;"
                                title="Gris"></div>
                            <div class="color-swatch" data-color="Acero" style="background-color: #c0c0c0;"
                                title="Acero"></div>
                            <div class="color-swatch" data-color="Blanco" style="background-color: #f5f5f5;"
                                title="Blanco"></div>
                        </div>
                        <p class="mt-2 small text-white">Color seleccionado: <span id="selectedColor">Negro</span></p>
                    </div>

                    <!-- Description Card -->
                    <div class="info-card mb-4">
                        <h5 class="fw-bold mb-3"><i class="bi bi-text-paragraph me-2"></i>Descripción</h5>
                        <p class="text-white" id="description">
                            {{ $producto?->descripcion ?? 'N/A' }}
                        </p>
                    </div>

                    {{-- <!-- Quote Button -->
                    <button class="btn btn-quote w-100 py-3 mb-3" data-bs-toggle="modal" data-bs-target="#quoteModal">
                        <i class="bi bi-file-earmark-text me-2"></i>
                        Solicitar Cotización
                    </button> --}}

                    <div class="text-center text-white small">
                        <i class="bi bi-shield-check me-1"></i>
                        Garantía de calidad • Instalación incluida
                    </div>
                </div>
            </div>

            <!-- Related Products -->
            <div class="related-products mt-5">
                <h3 class="fw-bold mb-4">Productos Relacionados</h3>
                <div class="row g-4" id="relatedProductsContainer">
                    @foreach ($productos_relacionados as $item)
                        <!-- Product 1 -->
                        <div class="col-md-6 col-lg-3">
                            <div onclick="window.location.href='{{ route('detalle', ['producto' => $item?->id]) }}'"
                                class="product-card">
                                <div class="product-image-wrapper">
                                    <img src="{{ asset('storage/' . $item?->imagenesActivas?->get(0)?->url ?? '#') }}"
                                        class="product-image-main" alt="Puerta Industrial Moderna">
                                    @if ($item?->imagenesActivas?->get(1))
                                        <img src="{{ asset('storage/' . $item?->imagenesActivas?->get(1)?->url ?? '#') }}"
                                            class="product-image-hover" alt="Puerta Industrial Vista 2">
                                    @endif
                                    <span class="badge-3d">
                                        <i class="bi bi-box"></i> Vista 3D
                                    </span>
                                </div>
                                <div class="product-card-body">
                                    <h5 class="product-title">{{ $item?->nombre }}</h5>
                                    <p class="product-category">{{ $item?->descripcion }}</p>
                                    <div class="product-features">
                                        <span class="feature-badge">
                                            <i class="bi bi-shield-check"></i> Alta Seguridad
                                        </span>
                                        <span class="feature-badge">
                                            <i class="bi bi-wrench"></i> Personalizable
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <!-- Quote Modal -->
    <div class="modal fade" id="quoteModal" tabindex="-1" aria-labelledby="quoteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="quoteModalLabel">
                        <i class="bi bi-file-earmark-text me-2"></i>
                        Solicitar Cotización
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="quoteForm">
                        <div class="mb-3">
                            <label for="quoteName" class="form-label">Nombre Completo *</label>
                            <input type="text" class="form-control" id="quoteName" required>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="quotePhone" class="form-label">Teléfono *</label>
                                <input type="tel" class="form-control" id="quotePhone" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="quoteEmail" class="form-label">Email</label>
                                <input type="email" class="form-control" id="quoteEmail">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="quoteCity" class="form-label">Ciudad *</label>
                            <input type="text" class="form-control" id="quoteCity" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Producto</label>
                            <input type="text" class="form-control" id="quoteProduct" readonly>
                        </div>
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="customFabrication">
                            <label class="form-check-label" for="customFabrication">
                                Requiero fabricación a medida con dimensiones personalizadas
                            </label>
                        </div>
                        <div class="mb-3">
                            <label for="quoteFile" class="form-label">Adjuntar archivo (planos, imágenes de
                                referencia)</label>
                            <input type="file" class="form-control" id="quoteFile" accept="image/*,.pdf,.dwg">
                        </div>
                        <div class="mb-3">
                            <label for="quoteDescription" class="form-label">Descripción del Proyecto</label>
                            <textarea class="form-control" id="quoteDescription" rows="4"
                                placeholder="Cuéntanos más sobre tu proyecto..."></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" onclick="submitQuote()">
                        <i class="bi bi-send me-2"></i>Enviar Solicitud
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Fullscreen Image Modal -->
    <div class="modal fade" id="fullscreenModal" tabindex="-1">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content bg-dark">
                <div class="modal-header border-0">
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body d-flex align-items-center justify-content-center">
                    <img id="fullscreenImage" src="/placeholder.svg" alt="Imagen en pantalla completa"
                        class="img-fluid">
                </div>
            </div>
        </div>
    </div>
@endsection
