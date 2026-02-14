@extends('layouts.app')

@section('imports')
    <link href="{{ asset('assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css"/>
    <script src="{{ asset('assets/js/scripts.bundle.js') }}"></script>
    <script>window.categoria = {!! json_encode($categoria) !!};</script>
    @vite(['resources/css/main.css', 'resources/css/categoria.css', 'resources/js/categoria.js'])
@endsection

@section('content')
    <!-- Category Hero Header -->
    <section class="category-hero">
        <div class="hero-bg-image" id="heroBgImage"></div>
        <div class="hero-overlay"></div>
        <div class="blueprint-grid"></div>
        <div class="container position-relative z-2">
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="#">Categorias</a></li>
                    <li class="breadcrumb-item active" id="breadcrumbCategory">{{ $categoria?->nombre ?? 'N/A' }}</li>
                </ol>
            </nav>

            <h1 class="display-3 fw-bold text-white mb-3" id="categoryTitle">{{ $categoria?->nombre ?? 'N/A' }}</h1>
            <p class="lead text-white-50 mb-0" id="categoryDescription">
                {{ $categoria?->descripcion ?? 'N/A' }}
            </p>

            <!-- Category Stats -->
            <div class="category-stats mt-4">
                <div class="stat-item">
                    <i class="bi bi-box-seam"></i>
                    <span id="productCount">{{ count($categoria->productosActivos) }} Productos</span>
                </div>
                <div class="stat-item">
                    <i class="bi bi-star-fill"></i>
                    <span>Alta Calidad</span>
                </div>
                <div class="stat-item">
                    <i class="bi bi-truck"></i>
                    <span>Envio Incluido</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Filters & Search Section -->
    <section class="filters-section py-4">
        <div class="container">
            <div class="filters-wrapper">
                <div class="row g-3 align-items-center">
                    <!-- Search -->
                    <div class="col-lg-4">
                        <div class="search-box">
                            <i class="bi bi-search search-icon"></i>
                            <input type="text" class="form-control" id="searchInput" placeholder="Buscar productos...">
                            <button class="btn-clear-search" id="clearSearch" style="display: none;">
                                <i class="bi bi-x-lg"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Filters -->
                    <div class="col-lg-8">
                        <div class="d-flex flex-wrap gap-3 justify-content-lg-end">
                            <!-- Color Filter -->
                            <div class="filter-dropdown">
                                <button class="btn btn-filter dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                    <i class="bi bi-palette me-2"></i>Color
                                </button>
                                <ul class="dropdown-menu dropdown-menu-dark">
                                    <li>
                                        <a class="dropdown-item filter-option" data-filter="color" data-value="all">
                                            <span class="color-dot"
                                                style="background: linear-gradient(135deg, #1a1a1a, #c0c0c0);"></span>
                                            Todos los colores
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item filter-option" data-filter="color" data-value="negro">
                                            <span class="color-dot" style="background: #1a1a1a;"></span>
                                            Negro
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item filter-option" data-filter="color" data-value="gris">
                                            <span class="color-dot" style="background: #4a4a4a;"></span>
                                            Gris Oscuro
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item filter-option" data-filter="color" data-value="plateado">
                                            <span class="color-dot" style="background: #c0c0c0;"></span>
                                            Plateado
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item filter-option" data-filter="color" data-value="blanco">
                                            <span class="color-dot" style="background: #f5f5f5;"></span>
                                            Blanco
                                        </a>
                                    </li>
                                </ul>
                            </div>

                            <!-- Sort -->
                            <div class="filter-dropdown">
                                <button class="btn btn-filter dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                    <i class="bi bi-sort-down me-2"></i>Ordenar
                                </button>
                                <ul class="dropdown-menu dropdown-menu-dark">
                                    <li><a class="dropdown-item sort-option active" data-sort="recent">Mas recientes</a>
                                    </li>
                                    <li><a class="dropdown-item sort-option" data-sort="name-asc">Nombre A-Z</a></li>
                                    <li><a class="dropdown-item sort-option" data-sort="name-desc">Nombre Z-A</a></li>
                                </ul>
                            </div>

                            <!-- View Toggle -->
                            <div class="view-toggle">
                                <button class="btn btn-view active" data-view="grid" title="Vista en cuadricula">
                                    <i class="bi bi-grid-3x3-gap-fill"></i>
                                </button>
                                <button class="btn btn-view" data-view="list" title="Vista en lista">
                                    <i class="bi bi-list-ul"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Active Filters -->
                <div class="active-filters mt-3" id="activeFilters" style="display: none;">
                    <span class="active-filters-label">Filtros activos:</span>
                    <div class="active-filters-tags" id="activeFiltersTags"></div>
                    <button class="btn btn-clear-all" id="clearAllFilters">Limpiar todos</button>
                </div>
            </div>
        </div>
    </section>

    <!-- Products Grid Section -->
    <section class="products-section py-5">
        <div class="container">
            <!-- Products Grid -->
            <div class="products-grid seccionListadoProductos">
                <!-- Products will be loaded by JS -->
            </div>
        </div>
    </section>
@endsection
