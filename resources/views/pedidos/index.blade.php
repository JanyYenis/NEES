@extends('layouts.index')

@section('title', 'Pedidos')
@section('sub_title', 'Dashboard / Pedidos')

@section('imports')
    @vite(['resources/js/admin-pedidos.js', 'resources/css/admin-pedidos.css'])
@endsection

@section('content')
    <!-- Filters and Actions -->
    <div class="filters-section">
        <div class="row align-items-center">
            <div class="col-md-3">
                <div class="search-box">
                    <i class="bi bi-search"></i>
                    <input type="text" id="searchInput" class="form-control"
                        placeholder="Buscar por cliente, pedido o cotización...">
                </div>
            </div>
            <div class="col-md-2">
                <select class="form-select" id="filterEstado">
                    <option value="">Todos los estados</option>
                    <option value="pendiente">Pendiente</option>
                    <option value="produccion">En producción</option>
                    <option value="listo">Listo para entrega</option>
                    <option value="entregado">Entregado</option>
                    <option value="cancelado">Cancelado</option>
                </select>
            </div>
            <div class="col-md-2">
                <input type="date" class="form-control" id="filterFecha" placeholder="Fecha de entrega">
            </div>
            <div class="col-md-2">
                <select class="form-select" id="sortBy">
                    <option value="fecha_desc">Más recientes</option>
                    <option value="fecha_asc">Más antiguos</option>
                    <option value="entrega_asc">Entrega próxima</option>
                    <option value="total_desc">Mayor total</option>
                </select>
            </div>
            <div class="col-md-3 text-end">
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCrearPedido">
                    <i class="bi bi-plus-lg"></i> Nuevo Pedido
                </button>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-icon bg-primary">
                    <i class="bi bi-cart-check"></i>
                </div>
                <div class="stat-info">
                    <h3 id="totalPedidos">45</h3>
                    <p>Total Pedidos</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-icon bg-warning">
                    <i class="bi bi-clock-history"></i>
                </div>
                <div class="stat-info">
                    <h3 id="pedidosPendientes">12</h3>
                    <p>Pendientes</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-icon bg-info">
                    <i class="bi bi-gear"></i>
                </div>
                <div class="stat-info">
                    <h3 id="pedidosProduccion">8</h3>
                    <p>En Producción</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-icon bg-success">
                    <i class="bi bi-check-circle"></i>
                </div>
                <div class="stat-info">
                    <h3 id="pedidosEntregados">25</h3>
                    <p>Entregados</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="table-card">
        <div class="table-responsive">
            <table class="table table-hover" id="tablaPedidos">
                <thead>
                    <tr>
                        <th width="100">Pedido</th>
                        <th width="120">Cotización</th>
                        <th>Cliente</th>
                        <th>Producto</th>
                        <th width="130">Fecha Entrega</th>
                        <th width="140">Estado</th>
                        <th width="110">Total</th>
                        <th width="180" class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody id="tableBody">
                    <!-- Data will be loaded here -->
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="pagination-wrapper">
            <div class="pagination-info">
                Mostrando <strong id="showingFrom">1</strong> a <strong id="showingTo">10</strong> de <strong
                    id="totalRecords">45</strong> registros
            </div>
            <nav>
                <ul class="pagination" id="pagination">
                    <li class="page-item disabled">
                        <a class="page-link" href="#"><i class="bi bi-chevron-left"></i></a>
                    </li>
                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item">
                        <a class="page-link" href="#"><i class="bi bi-chevron-right"></i></a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
@endsection

@section('modals')
    <!-- Modal Crear/Editar Pedido -->
    <div class="modal fade" id="modalCrearPedido" tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">
                        <i class="bi bi-plus-circle"></i> Nuevo Pedido
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="formPedido">
                    <div class="modal-body">
                        <input type="hidden" id="pedidoId" name="id">

                        <div class="row">
                            <!-- Columna Izquierda -->
                            <div class="col-md-6">
                                <!-- Selección de Cotización -->
                                <div class="mb-4">
                                    <label for="cotizacion_id" class="form-label">
                                        Seleccionar Cotización <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-select" id="cotizacion_id" name="cotizacion_id" required>
                                        <option value="">-- Seleccione una cotización --</option>
                                    </select>
                                    <div class="invalid-feedback">Por favor seleccione una cotización.</div>
                                </div>

                                <!-- Cotización Preview Card -->
                                <div class="cotizacion-preview-card" id="cotizacionPreview" style="display: none;">
                                    <div class="preview-header">
                                        <h6><i class="bi bi-file-text"></i> Información de la Cotización</h6>
                                    </div>
                                    <div class="preview-body">
                                        <div class="preview-row">
                                            <span class="preview-label">Cliente:</span>
                                            <span class="preview-value" id="previewCliente">-</span>
                                        </div>
                                        <div class="preview-row">
                                            <span class="preview-label">Dirección:</span>
                                            <span class="preview-value" id="previewDireccion">-</span>
                                        </div>
                                        <div class="preview-row">
                                            <span class="preview-label">Producto:</span>
                                            <span class="preview-value" id="previewProducto">-</span>
                                        </div>
                                        <div class="preview-row">
                                            <span class="preview-label">Total:</span>
                                            <span class="preview-value text-primary fw-bold" id="previewTotal">-</span>
                                        </div>
                                        <div class="preview-row">
                                            <span class="preview-label">Estado:</span>
                                            <span id="previewEstadoCotizacion">-</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Fecha de Entrega -->
                                <div class="mb-3">
                                    <label for="fecha_entrega" class="form-label">
                                        Fecha de Entrega <span class="text-danger">*</span>
                                    </label>
                                    <input type="date" class="form-control" id="fecha_entrega" name="fecha_entrega"
                                        required>
                                    <div class="invalid-feedback">Por favor ingrese una fecha de entrega válida.</div>
                                    <small class="text-muted">La fecha debe ser posterior a hoy.</small>
                                </div>
                            </div>

                            <!-- Columna Derecha -->
                            <div class="col-md-6">
                                <!-- Estado del Pedido -->
                                <div class="mb-3">
                                    <label for="estado" class="form-label">
                                        Estado del Pedido <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-select" id="estado" name="estado" required>
                                        <option value="pendiente">Pendiente</option>
                                        <option value="produccion">En producción</option>
                                        <option value="listo">Listo para entrega</option>
                                        <option value="entregado">Entregado</option>
                                        <option value="cancelado">Cancelado</option>
                                    </select>
                                    <div class="estado-preview" id="estadoPreview">
                                        <span class="badge-pedido badge-pendiente">
                                            <i class="bi bi-clock-history"></i> Pendiente
                                        </span>
                                    </div>
                                </div>

                                <!-- Observaciones -->
                                <div class="mb-3">
                                    <label for="observaciones" class="form-label">
                                        Observaciones / Notas Internas
                                    </label>
                                    <textarea class="form-control" id="observaciones" name="observaciones" rows="6"
                                        placeholder="Ingrese notas adicionales sobre el pedido..."></textarea>
                                    <small class="text-muted">
                                        <span id="obsCharCount">0</span>/500 caracteres
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="bi bi-x-circle"></i> Cancelar
                        </button>
                        <button type="submit" class="btn btn-primary" id="btnGuardar">
                            <i class="bi bi-check-circle"></i> Guardar Pedido
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Ver Pedido -->
    <div class="modal fade" id="modalVerPedido" tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="bi bi-eye"></i> Detalles del Pedido
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="pedido-detail-view">
                        <!-- Header -->
                        <div class="detail-header">
                            <div class="row align-items-center">
                                <div class="col-md-8">
                                    <h3 class="mb-2">Pedido <span id="verNumeroPedido" class="text-primary"></span>
                                    </h3>
                                    <p class="text-muted mb-0">Cotización: <span id="verCotizacionRef"></span></p>
                                </div>
                                <div class="col-md-4 text-end">
                                    <div id="verEstadoPedido"></div>
                                    <div class="mt-2" id="verTiempoRestante"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Info Grid -->
                        <div class="row mt-4">
                            <div class="col-md-6">
                                <div class="info-card">
                                    <h6><i class="bi bi-person"></i> Información del Cliente</h6>
                                    <div class="info-row">
                                        <span class="info-label">Nombre:</span>
                                        <span class="info-value" id="verCliente"></span>
                                    </div>
                                    <div class="info-row">
                                        <span class="info-label">Email:</span>
                                        <span class="info-value" id="verClienteEmail"></span>
                                    </div>
                                    <div class="info-row">
                                        <span class="info-label">Teléfono:</span>
                                        <span class="info-value" id="verClienteTelefono"></span>
                                    </div>
                                    <div class="info-row">
                                        <span class="info-label">Dirección:</span>
                                        <span class="info-value" id="verDireccion"></span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="info-card">
                                    <h6><i class="bi bi-calendar-check"></i> Información de Entrega</h6>
                                    <div class="info-row">
                                        <span class="info-label">Fecha de Pedido:</span>
                                        <span class="info-value" id="verFechaPedido"></span>
                                    </div>
                                    <div class="info-row">
                                        <span class="info-label">Fecha de Entrega:</span>
                                        <span class="info-value fw-bold" id="verFechaEntrega"></span>
                                    </div>
                                    <div class="info-row">
                                        <span class="info-label">Días Restantes:</span>
                                        <span class="info-value" id="verDiasRestantes"></span>
                                    </div>
                                    <div class="info-row">
                                        <span class="info-label">Estado:</span>
                                        <span id="verEstado"></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Producto -->
                        <div class="info-card mt-3">
                            <h6><i class="bi bi-box"></i> Producto</h6>
                            <div class="producto-preview" id="verProductoInfo">
                                <!-- Producto info -->
                            </div>
                        </div>

                        <!-- Materiales -->
                        <div class="info-card mt-3">
                            <h6><i class="bi bi-box-seam"></i> Materiales</h6>
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>Material</th>
                                            <th>Cantidad</th>
                                            <th>Unidad</th>
                                            <th>Precio Unit.</th>
                                            <th class="text-end">Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody id="verMateriales">
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Mano de Obra y Total -->
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <div class="info-card">
                                    <h6><i class="bi bi-tools"></i> Mano de Obra</h6>
                                    <div class="info-row">
                                        <span class="info-label">Descripción:</span>
                                        <span class="info-value" id="verManoObraDesc"></span>
                                    </div>
                                    <div class="info-row">
                                        <span class="info-label">Costo:</span>
                                        <span class="info-value text-primary fw-bold" id="verManoObraCosto"></span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="info-card total-card">
                                    <div class="total-row">
                                        <span>Subtotal:</span>
                                        <span id="verSubtotal"></span>
                                    </div>
                                    <div class="total-row">
                                        <span>IVA (16%):</span>
                                        <span id="verIva"></span>
                                    </div>
                                    <div class="total-row total-final">
                                        <span>Total:</span>
                                        <span id="verTotalFinal"></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Observaciones -->
                        <div class="info-card mt-3" id="verObservacionesCard" style="display: none;">
                            <h6><i class="bi bi-chat-left-text"></i> Observaciones</h6>
                            <p class="mb-0" id="verObservaciones"></p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" id="btnEditarDesdeVer">
                        <i class="bi bi-pencil"></i> Editar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Cambiar Estado -->
    <div class="modal fade" id="modalCambiarEstado" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="bi bi-arrow-left-right"></i> Cambiar Estado del Pedido
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Pedido: <strong id="cambiarEstadoPedido"></strong></p>
                    <p class="mb-3">Estado actual: <span id="cambiarEstadoActual"></span></p>

                    <label for="nuevoEstado" class="form-label">Nuevo Estado</label>
                    <select class="form-select" id="nuevoEstado">
                        <option value="pendiente">Pendiente</option>
                        <option value="produccion">En producción</option>
                        <option value="listo">Listo para entrega</option>
                        <option value="entregado">Entregado</option>
                        <option value="cancelado">Cancelado</option>
                    </select>

                    <div class="mt-3" id="previewNuevoEstado"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" id="btnConfirmarCambioEstado">
                        <i class="bi bi-check-circle"></i> Cambiar Estado
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Confirmar Eliminar -->
    <div class="modal fade" id="modalEliminar" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h5 class="modal-title text-danger">
                        <i class="bi bi-exclamation-triangle"></i> Confirmar Eliminación
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>¿Está seguro que desea eliminar el pedido <strong id="eliminarPedido"></strong>?</p>
                    <div class="alert alert-warning">
                        <i class="bi bi-exclamation-circle"></i>
                        Esta acción no se puede deshacer.
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-danger" id="btnConfirmarEliminar">
                        <i class="bi bi-trash"></i> Eliminar
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection
