@extends('layouts.index')

@section('title', 'Dashboard')
@section('sub_title', 'Dashboard')

@section('imports')
    @vite(['resources/js/dashboard.js', 'resources/css/dashboard.css'])
@endsection

@section('content')
    <!-- KPI Cards -->
    <div class="row mb-4">
        <div class="col-md-4 col-lg-2">
            <div class="kpi-card">
                <div class="kpi-icon bg-primary">
                    <i class="bi bi-people"></i>
                </div>
                <div class="kpi-content">
                    <h3 id="totalClientes">142</h3>
                    <p>Total Clientes</p>
                    <div class="kpi-trend trend-up">
                        <i class="bi bi-arrow-up"></i>
                        <span>12% vs mes anterior</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4 col-lg-2">
            <div class="kpi-card">
                <div class="kpi-icon bg-info">
                    <i class="bi bi-file-text"></i>
                </div>
                <div class="kpi-content">
                    <h3 id="cotizacionesMes">28</h3>
                    <p>Cotizaciones del Mes</p>
                    <div class="kpi-trend trend-up">
                        <i class="bi bi-arrow-up"></i>
                        <span>8% vs mes anterior</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4 col-lg-2">
            <div class="kpi-card">
                <div class="kpi-icon bg-warning">
                    <i class="bi bi-box"></i>
                </div>
                <div class="kpi-content">
                    <h3 id="pedidosActivos">15</h3>
                    <p>Pedidos Activos</p>
                    <div class="kpi-trend trend-neutral">
                        <i class="bi bi-dash"></i>
                        <span>Sin cambios</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4 col-lg-2">
            <div class="kpi-card">
                <div class="kpi-icon bg-success">
                    <i class="bi bi-currency-dollar"></i>
                </div>
                <div class="kpi-content">
                    <h3 id="ingresosEstimados">$48,500</h3>
                    <p>Ingresos Estimados</p>
                    <div class="kpi-trend trend-up">
                        <i class="bi bi-arrow-up"></i>
                        <span>24% vs mes anterior</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4 col-lg-2">
            <div class="kpi-card">
                <div class="kpi-icon bg-success-alt">
                    <i class="bi bi-check-circle"></i>
                </div>
                <div class="kpi-content">
                    <h3 id="pedidosEntregados">42</h3>
                    <p>Pedidos Entregados</p>
                    <div class="kpi-trend trend-up">
                        <i class="bi bi-arrow-up"></i>
                        <span>15% vs mes anterior</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4 col-lg-2">
            <div class="kpi-card">
                <div class="kpi-icon bg-production">
                    <i class="bi bi-gear"></i>
                </div>
                <div class="kpi-content">
                    <h3 id="pedidosProduccion">8</h3>
                    <p>En Producción</p>
                    <div class="kpi-trend trend-down">
                        <i class="bi bi-arrow-down"></i>
                        <span>5% vs mes anterior</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row mb-4">
        <!-- Cotizaciones vs Pedidos Chart -->
        <div class="col-lg-8">
            <div class="chart-card">
                <div class="chart-header">
                    <h5><i class="bi bi-bar-chart"></i> Cotizaciones vs Pedidos</h5>
                    <div class="chart-legend">
                        <span class="legend-item">
                            <span class="legend-dot bg-primary"></span> Cotizaciones
                        </span>
                        <span class="legend-item">
                            <span class="legend-dot bg-success"></span> Pedidos
                        </span>
                    </div>
                </div>
                <canvas id="cotizacionesPedidosChart"></canvas>
            </div>
        </div>

        <!-- Ingresos Chart -->
        <div class="col-lg-4">
            <div class="chart-card">
                <div class="chart-header">
                    <h5><i class="bi bi-graph-up"></i> Ingresos Estimados</h5>
                </div>
                <canvas id="ingresosChart"></canvas>
                <div class="chart-summary">
                    <div class="summary-item">
                        <span class="summary-label">Este mes</span>
                        <span class="summary-value text-success">$48,500</span>
                    </div>
                    <div class="summary-item">
                        <span class="summary-label">Mes anterior</span>
                        <span class="summary-value text-muted">$39,100</span>
                    </div>
                    <div class="summary-item">
                        <span class="summary-label">Crecimiento</span>
                        <span class="summary-value text-primary">+24%</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tables and Alerts Row -->
    <div class="row">
        <!-- Pedidos Recientes -->
        <div class="col-lg-8">
            <div class="table-card">
                <div class="table-header">
                    <h5><i class="bi bi-box"></i> Pedidos Recientes</h5>
                    <a href="pedidos.html" class="btn btn-sm btn-outline-primary">Ver todos</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Pedido #</th>
                                <th>Cliente</th>
                                <th>Estado</th>
                                <th>Fecha Entrega</th>
                                <th>Total</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="pedidosRecientesBody">
                            <!-- Data loaded by JS -->
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Cotizaciones Pendientes -->
            <div class="table-card mt-4">
                <div class="table-header">
                    <h5><i class="bi bi-file-text"></i> Cotizaciones Pendientes</h5>
                    <a href="cotizaciones.html" class="btn btn-sm btn-outline-primary">Ver todas</a>
                </div>
                <div class="cotizaciones-grid" id="cotizacionesGrid">
                    <!-- Data loaded by JS -->
                </div>
            </div>
        </div>

        <!-- Alerts and Quick Actions -->
        <div class="col-lg-4">
            <!-- Alertas -->
            <div class="alerts-card">
                <div class="alerts-header">
                    <h5><i class="bi bi-bell"></i> Alertas y Recordatorios</h5>
                    <span class="badge bg-danger" id="alertCount">4</span>
                </div>
                <div class="alerts-list" id="alertsList">
                    <!-- Alerts loaded by JS -->
                </div>
            </div>

            <!-- Accesos Rápidos -->
            <div class="quick-actions-card mt-4">
                <h5><i class="bi bi-lightning"></i> Accesos Rápidos</h5>
                <div class="quick-actions-grid">
                    <a href="cotizaciones.html" class="quick-action-btn">
                        <i class="bi bi-file-text"></i>
                        <span>Nueva Cotización</span>
                    </a>
                    <a href="pedidos.html" class="quick-action-btn">
                        <i class="bi bi-box"></i>
                        <span>Nuevo Pedido</span>
                    </a>
                    <a href="productos.html" class="quick-action-btn">
                        <i class="bi bi-archive"></i>
                        <span>Nuevo Producto</span>
                    </a>
                    <a href="usuarios.html" class="quick-action-btn">
                        <i class="bi bi-person-plus"></i>
                        <span>Nuevo Cliente</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
