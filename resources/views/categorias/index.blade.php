@extends('layouts.index')

@section('title', 'Categirias')
@section('sub_title', 'Dashboard / Categirias')

@section('imports')
    @vite(['resources/js/categorias/principal.js'])
@endsection

@section('content')
    <!-- Filters and Actions -->
    <div class="filters-section">
        <div class="d-flex flex-column flex-md-row justify-content-end align-items-md-center">
            <div>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCrearCategoria">
                    <i class="bi bi-plus-lg"></i> Nueva Categoría
                </button>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-icon bg-primary">
                    <i class="bi bi-grid text-white fs-1"></i>
                </div>
                <div class="stat-info">
                    <h3 id="totalCategorias">0</h3>
                    <p>Total Categorías</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-icon bg-success">
                    <i class="bi bi-check-circle text-white fs-1"></i>
                </div>
                <div class="stat-info">
                    <h3 id="categoriasActivas">0</h3>
                    <p>Activas</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-icon bg-warning">
                    <i class="bi bi-pause-circle text-white fs-1"></i>
                </div>
                <div class="stat-info">
                    <h3 id="categoriasInactivas">0</h3>
                    <p>Inactivas</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-icon bg-info">
                    <i class="bi bi-archive text-white fs-1"></i>
                </div>
                <div class="stat-info">
                    <h3 id="productosAsociados">0</h3>
                    <p>Productos Asociados</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="table-card">
        <div class="table-responsive">
            <table class="table table-hover" id="tablaCategoria">
                <thead>
                    <tr>
                        <th class="text-center all" width="5%">#</th>
                        <th class="text-center all" width="100">Imagen</th>
                        <th class="text-center all">Nombre</th>
                        <th class="text-center all">Descripción</th>
                        <th class="text-center all" width="120">Estado</th>
                        <th class="text-center all" width="100">Productos</th>
                        <th class="text-center all" width="180">Acciones</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
@endsection

@section('modals')
    @component('categorias.modals.crear')
    @endcomponent
    @component('categorias.modals.ver')
    @endcomponent
    @component('categorias.modals.editar')
    @endcomponent
    @component('categorias.modals.eliminar')
    @endcomponent
@endsection
