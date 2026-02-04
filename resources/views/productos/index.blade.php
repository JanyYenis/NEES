@extends('layouts.index')

@section('title', 'Productos')
@section('sub_title', 'Dashboard / Productos')

@section('imports')
    @vite(['resources/js/productos/principal.js', 'resources/css/admin-productos.css'])
@endsection

@section('content')
    <!-- Filters and Actions -->
    <div class="filters-section">
        <div class="d-flex flex-column flex-md-row justify-content-end align-items-md-center">
            <div>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCrearProducto">
                    <i class="bi bi-plus-lg"></i> Nuevo Producto
                </button>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-icon bg-primary">
                    <i class="bi bi-archive text-white fs-1"></i>
                </div>
                <div class="stat-info">
                    <h3 id="totalProductos">0</h3>
                    <p>Total Productos</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-icon bg-success">
                    <i class="bi bi-check-circle text-white fs-1"></i>
                </div>
                <div class="stat-info">
                    <h3 id="productosActivos">0</h3>
                    <p>Activos</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-icon bg-warning">
                    <i class="bi bi-pause-circle text-white fs-1"></i>
                </div>
                <div class="stat-info">
                    <h3 id="productosInactivos">0</h3>
                    <p>Inactivos</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-icon bg-info">
                    <i class="bi bi-grid text-white fs-1"></i>
                </div>
                <div class="stat-info">
                    <h3 id="categoriasConProductos">0</h3>
                    <p>Categorías</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="table-card">
        <div class="table-responsive">
            <table class="table table-hover" id="tablaProductos">
                <thead>
                    <tr>
                        <th class="text-center all" width="5%">#</th>
                        <th class="text-center all" width="10%">Fotos</th>
                        <th class="text-center all" width="10%">Nombre</th>
                        <th class="text-center none">Descripción</th>
                        <th class="text-center all" width="20%">Categoría</th>
                        <th class="text-center all" width="10%">Medidas</th>
                        <th class="text-center all" width="5%">Estado</th>
                        <th class="text-center all" width="20%">Acciones</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
@endsection

@section('modals')
    @component('productos.modals.crear')
        @slot('categorias', $categorias)
    @endcomponent
    @component('productos.modals.ver')
    @endcomponent
    @component('productos.modals.editar')
    @endcomponent
    @component('productos.modals.eliminar')
    @endcomponent
@endsection
