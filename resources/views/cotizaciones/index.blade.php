@extends('layouts.index')

@section('title', 'Cotizaciones')
@section('sub_title', 'Dashboard / Cotizaciones')

@section('imports')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    @vite(['resources/js/admin-cotizaciones.js', 'resources/css/admin-cotizaciones.css'])
@endsection

@section('content')
    <!-- Filters and Actions -->
    <div class="filters-section">
        <div class="row align-items-center">
            <div class="col-md-3">
                <div class="search-box">
                    <i class="bi bi-search"></i>
                    <input type="text" id="searchInput" class="form-control" placeholder="Buscar cotización...">
                </div>
            </div>
            <div class="col-md-2">
                <select class="form-select" id="filterCliente">
                    <option value="">Todos los clientes</option>
                </select>
            </div>
            <div class="col-md-2">
                <select class="form-select" id="filterEstado">
                    <option value="">Todos los estados</option>
                    <option value="borrador">Borrador</option>
                    <option value="enviada">Enviada</option>
                    <option value="aprobada">Aprobada</option>
                    <option value="rechazada">Rechazada</option>
                </select>
            </div>
            <div class="col-md-2">
                <select class="form-select" id="sortBy">
                    <option value="fecha">Ordenar por Fecha</option>
                    <option value="total">Ordenar por Total</option>
                    <option value="cliente">Ordenar por Cliente</option>
                </select>
            </div>
            <div class="col-md-3 text-end">
                <button class="btn btn-primary" onclick="abrirModalCrear()">
                    <i class="bi bi-plus-lg"></i> Nueva Cotización
                </button>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-icon bg-primary">
                    <i class="bi bi-file-text"></i>
                </div>
                <div class="stat-info">
                    <h3 id="totalCotizaciones">24</h3>
                    <p>Total Cotizaciones</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-icon bg-success">
                    <i class="bi bi-check-circle"></i>
                </div>
                <div class="stat-info">
                    <h3 id="cotizacionesAprobadas">12</h3>
                    <p>Aprobadas</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-icon bg-warning">
                    <i class="bi bi-clock"></i>
                </div>
                <div class="stat-info">
                    <h3 id="cotizacionesPendientes">8</h3>
                    <p>Pendientes</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-icon bg-info">
                    <i class="bi bi-currency-dollar"></i>
                </div>
                <div class="stat-info">
                    <h3 id="montoTotal">$48,500</h3>
                    <p>Total Aprobadas</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="table-card">
        <div class="table-responsive">
            <table class="table table-hover" id="tablaCotizaciones">
                <thead>
                    <tr>
                        <th width="120">Cotización</th>
                        <th>Cliente</th>
                        <th>Producto</th>
                        <th width="120">Total</th>
                        <th width="120">Estado</th>
                        <th width="100">Fecha</th>
                        <th width="200" class="text-center">Acciones</th>
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
                    id="totalRecords">24</strong> registros
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
    <!-- Modal Crear/Editar Cotización -->
    <div class="modal fade" id="modalCrearCotizacion" tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">
                        <i class="bi bi-plus-circle"></i> Nueva Cotización
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="formCotizacion">
                    <div class="modal-body">
                        <input type="hidden" id="cotizacionId" name="id">

                        <div class="row">
                            <!-- Cliente y Dirección -->
                            <div class="col-md-6">
                                <div class="form-section">
                                    <h6 class="section-title">
                                        <i class="bi bi-person"></i> Información del Cliente
                                    </h6>

                                    <div class="mb-3">
                                        <label for="cliente_id" class="form-label">
                                            Cliente <span class="text-danger">*</span>
                                        </label>
                                        <select class="form-select" id="cliente_id" name="cliente_id" required>
                                            <option value="">Seleccione un cliente...</option>
                                        </select>
                                        <small class="text-muted" id="clienteInfo"></small>
                                    </div>

                                    <div class="mb-3">
                                        <label for="direccion_id" class="form-label">
                                            Dirección <span class="text-danger">*</span>
                                        </label>
                                        <div class="direccion-selector">
                                            <select class="form-select" id="direccion_id" name="direccion_id" required
                                                disabled>
                                                <option value="">Seleccione primero un cliente...</option>
                                            </select>
                                            <button type="button" class="btn btn-sm btn-outline-primary mt-2"
                                                id="btnAgregarDireccion" disabled>
                                                <i class="bi bi-plus-circle"></i> Agregar nueva dirección
                                            </button>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="producto_id" class="form-label">
                                            Producto (Opcional)
                                        </label>
                                        <select class="form-select" id="producto_id" name="producto_id">
                                            <option value="">Cotización personalizada sin producto</option>
                                        </select>
                                        <small class="text-muted">Al seleccionar un producto se autocompletarán medidas y
                                            materiales sugeridos</small>
                                    </div>
                                </div>
                            </div>

                            <!-- Información adicional -->
                            <div class="col-md-6">
                                <div class="form-section">
                                    <h6 class="section-title">
                                        <i class="bi bi-info-circle"></i> Información Adicional
                                    </h6>

                                    <div class="mb-3">
                                        <label for="estado" class="form-label">Estado</label>
                                        <select class="form-select" id="estado" name="estado">
                                            <option value="borrador">Borrador</option>
                                            <option value="enviada">Enviada</option>
                                            <option value="aprobada">Aprobada</option>
                                            <option value="rechazada">Rechazada</option>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label for="notas" class="form-label">Notas</label>
                                        <textarea class="form-control" id="notas" name="notas" rows="3"
                                            placeholder="Notas adicionales para la cotización..."></textarea>
                                    </div>

                                    <div class="producto-preview" id="productoPreview" style="display: none;">
                                        <h6>Vista previa del producto</h6>
                                        <div id="productoPreviewContent"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Materiales -->
                        <div class="form-section mt-4">
                            <h6 class="section-title">
                                <i class="bi bi-box-seam"></i> Materiales
                            </h6>

                            <div class="mb-3">
                                <label class="form-label">Agregar Material</label>
                                <div class="input-group">
                                    <select class="form-select" id="selectMaterial">
                                        <option value="">Seleccione un material...</option>
                                    </select>
                                    <button type="button" class="btn btn-primary" onclick="agregarMaterial()">
                                        <i class="bi bi-plus-lg"></i> Agregar
                                    </button>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-bordered" id="tablaMateriales">
                                    <thead>
                                        <tr>
                                            <th width="35%">Material</th>
                                            <th width="15%">Unidad</th>
                                            <th width="15%">Cantidad</th>
                                            <th width="20%">Valor Unitario</th>
                                            <th width="20%">Subtotal</th>
                                            <th width="5%"></th>
                                        </tr>
                                    </thead>
                                    <tbody id="materialesBody">
                                        <tr class="empty-state">
                                            <td colspan="6" class="text-center text-muted">
                                                <i class="bi bi-inbox"></i><br>
                                                No hay materiales agregados
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Mano de Obra -->
                        <div class="form-section mt-4">
                            <h6 class="section-title">
                                <i class="bi bi-tools"></i> Mano de Obra
                            </h6>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="mano_obra" class="form-label">Valor de la Mano de Obra</label>
                                        <div class="input-group">
                                            <span class="input-group-text">$</span>
                                            <input type="number" class="form-control" id="mano_obra" name="mano_obra"
                                                value="0" min="0" step="0.01"
                                                onchange="calcularTotales()">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="descripcion_mano_obra" class="form-label">Descripción</label>
                                        <input type="text" class="form-control" id="descripcion_mano_obra"
                                            name="descripcion_mano_obra"
                                            placeholder="Ej: Instalación completa, soldadura especializada...">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Resumen de Costos -->
                        <div class="form-section mt-4">
                            <h6 class="section-title">
                                <i class="bi bi-calculator"></i> Resumen de Costos
                            </h6>

                            <div class="cost-summary">
                                <div class="cost-row">
                                    <span>Subtotal Materiales:</span>
                                    <strong id="subtotalMateriales">$0.00</strong>
                                </div>
                                <div class="cost-row">
                                    <span>Mano de Obra:</span>
                                    <strong id="totalManoObra">$0.00</strong>
                                </div>
                                <div class="cost-row">
                                    <span>Impuestos (IVA 19%):</span>
                                    <strong id="totalImpuestos">$0.00</strong>
                                </div>
                                <div class="cost-row total">
                                    <span>TOTAL GENERAL:</span>
                                    <strong id="totalGeneral">$0.00</strong>
                                </div>
                            </div>
                            <input type="hidden" id="total" name="total" value="0">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="bi bi-x-circle"></i> Cancelar
                        </button>
                        <button type="submit" class="btn btn-primary" id="btnGuardar">
                            <i class="bi bi-check-circle"></i> Guardar Cotización
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Agregar Dirección -->
    <div class="modal fade" id="modalAgregarDireccion" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="bi bi-geo-alt"></i> Agregar Nueva Dirección
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="formAgregarDireccion">
                    <div class="modal-body">
                        <input type="hidden" id="direccion_cliente_id">

                        <div class="mb-3">
                            <label for="nueva_direccion" class="form-label">
                                Dirección Completa <span class="text-danger">*</span>
                            </label>
                            <textarea class="form-control" id="nueva_direccion" name="direccion" rows="3" required
                                placeholder="Calle, número, barrio..."></textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="nueva_ciudad" class="form-label">Ciudad</label>
                                    <input type="text" class="form-control" id="nueva_ciudad" name="ciudad">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="nueva_codigo_postal" class="form-label">Código Postal</label>
                                    <input type="text" class="form-control" id="nueva_codigo_postal"
                                        name="codigo_postal">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle"></i> Guardar Dirección
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Ver Cotización -->
    <div class="modal fade" id="modalVerCotizacion" tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="bi bi-eye"></i> Detalles de Cotización
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div id="cotizacionView" class="cotizacion-document">
                        <!-- Contenido se cargará dinámicamente -->
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-warning" onclick="editarDesdeVer()">
                        <i class="bi bi-pencil"></i> Editar
                    </button>
                    <button type="button" class="btn btn-primary" onclick="exportarPDF()">
                        <i class="bi bi-file-pdf"></i> Exportar PDF
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Eliminar -->
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
                    <p>¿Está seguro que desea eliminar la cotización <strong id="eliminarNumero"></strong>?</p>
                    <p class="text-muted small">Esta acción no se puede deshacer.</p>
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
