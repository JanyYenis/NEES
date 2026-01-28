@extends('layouts.index')

@section('title', 'Materiales')
@section('sub_title', 'Dashboard / Materiales')

@section('imports')
    @vite(['resources/js/materiales/principal.js'])
@endsection

@section('content')
    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6">
            <div class="stat-card">
                <div class="stat-icon bg-primary">
                    <i class="bi bi-box-seam text-white fs-1"></i>
                </div>
                <div class="stat-info">
                    <h3 id="totalMateriales">0</h3>
                    <p>Total Materiales</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="stat-card">
                <div class="stat-icon bg-success">
                    <i class="bi bi-check-circle text-white fs-1"></i>
                </div>
                <div class="stat-info">
                    <h3 id="materialesActivos">0</h3>
                    <p>Activos</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="stat-card">
                <div class="stat-icon bg-warning">
                    <i class="bi bi-dash-circle text-white fs-1"></i>
                </div>
                <div class="stat-info">
                    <h3 id="materialesInactivos">0</h3>
                    <p>Inactivos</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="stat-card">
                <div class="stat-icon bg-info">
                    <i class="bi bi-diagram-3 text-white fs-1"></i>
                </div>
                <div class="stat-info">
                    <h3 id="tiposUnidad">0</h3>
                    <p>Tipos de Unidad</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters Section -->
    <div class="filters-section">
        <div class="d-flex flex-column flex-md-row justify-content-end align-items-md-center">
            <div>
                <button class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#modalCrearMaterial">
                    <i class="bi bi-plus-circle"></i> Nuevo Material
                </button>
            </div>
        </div>
    </div>

    <!-- Table Card -->
    <div class="table-card">
        <div class="table-responsive">
            <table class="table" id="tablaMateriales">
                <thead>
                    <tr>
                        <th class="text-center all">#</th>
                        <th class="text-center all">Fotos</th>
                        <th class="text-center all">Nombre</th>
                        <th class="text-center all">Descripción</th>
                        <th class="text-center all">Cantidad / Unidad</th>
                        <th class="text-center all">Estado</th>
                        <th class="text-center all">Acciones</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
@endsection

@section('modals')
    @component('materiales.modals.crear')
        @slot('tipos', $tipos)
    @endcomponent
    @component('materiales.modals.ver')
    @endcomponent
    @component('materiales.modals.editar')
    @endcomponent
    @component('materiales.modals.eliminar')
    @endcomponent
@endsection
