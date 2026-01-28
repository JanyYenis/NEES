@extends('layouts.index')

@section('title', 'Productos')
@section('sub_title', 'Dashboard / Productos')

@section('imports')
    @vite(['resources/js/admin-productos.js', 'resources/css/admin-productos.css'])
@endsection

@section('content')
    <!-- Filters and Actions -->
    <div class="filters-section">
        <div class="row align-items-center">
            <div class="col-md-3">
                <div class="search-box">
                    <i class="bi bi-search"></i>
                    <input type="text" id="searchInput" class="form-control" placeholder="Buscar producto...">
                </div>
            </div>
            <div class="col-md-2">
                <select class="form-select" id="filterCategoria">
                    <option value="">Todas las categorías</option>
                    <option value="1">Puertas</option>
                    <option value="2">Ventanas</option>
                    <option value="3">Portones</option>
                    <option value="4">Escaleras</option>
                    <option value="5">Barandas</option>
                    <option value="6">Rejas</option>
                </select>
            </div>
            <div class="col-md-2">
                <select class="form-select" id="filterEstado">
                    <option value="">Todos los estados</option>
                    <option value="activo">Activo</option>
                    <option value="inactivo">Inactivo</option>
                </select>
            </div>
            <div class="col-md-2">
                <select class="form-select" id="sortBy">
                    <option value="nombre">Ordenar por Nombre</option>
                    <option value="categoria">Por Categoría</option>
                    <option value="estado">Por Estado</option>
                    <option value="fecha">Por Fecha</option>
                </select>
            </div>
            <div class="col-md-3 text-end">
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
                    <i class="bi bi-archive"></i>
                </div>
                <div class="stat-info">
                    <h3 id="totalProductos">124</h3>
                    <p>Total Productos</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-icon bg-success">
                    <i class="bi bi-check-circle"></i>
                </div>
                <div class="stat-info">
                    <h3 id="productosActivos">98</h3>
                    <p>Activos</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-icon bg-warning">
                    <i class="bi bi-pause-circle"></i>
                </div>
                <div class="stat-info">
                    <h3 id="productosInactivos">26</h3>
                    <p>Inactivos</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-icon bg-info">
                    <i class="bi bi-grid"></i>
                </div>
                <div class="stat-info">
                    <h3 id="categoriasConProductos">6</h3>
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
                        <th width="150">Fotos</th>
                        <th>Nombre</th>
                        <th width="150">Categoría</th>
                        <th width="180">Medidas</th>
                        <th width="120">Estado</th>
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
                    id="totalRecords">124</strong> registros
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
    <!-- Modal Crear/Editar Producto -->
    <div class="modal fade" id="modalCrearProducto" tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">
                        <i class="bi bi-plus-circle"></i> Nuevo Producto
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="formProducto">
                    <div class="modal-body">
                        <input type="hidden" id="productoId" name="id">

                        <div class="row">
                            <!-- Columna Izquierda -->
                            <div class="col-md-8">
                                <!-- Datos Básicos -->
                                <div class="form-section">
                                    <h6 class="form-section-title">
                                        <i class="bi bi-info-circle"></i> Datos Básicos
                                    </h6>

                                    <div class="mb-3">
                                        <label for="nombre" class="form-label">
                                            Nombre del Producto <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" class="form-control" id="nombre" name="nombre"
                                            required>
                                        <div class="invalid-feedback">Por favor ingrese el nombre del producto.</div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="descripcion" class="form-label">
                                            Descripción <span class="text-danger">*</span>
                                        </label>
                                        <textarea class="form-control" id="descripcion" name="descripcion" rows="4" required></textarea>
                                        <div class="invalid-feedback">Por favor ingrese una descripción.</div>
                                        <small class="text-muted">
                                            <span id="charCount">0</span>/500 caracteres
                                        </small>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Estado</label>
                                        <div class="form-check form-switch form-switch-lg">
                                            <input class="form-check-input" type="checkbox" id="estado"
                                                name="estado" checked>
                                            <label class="form-check-label" for="estado">
                                                <span class="badge-status-active" id="estadoLabel">Activo</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <!-- Categoría -->
                                <div class="form-section">
                                    <h6 class="form-section-title">
                                        <i class="bi bi-grid"></i> Categoría
                                    </h6>

                                    <div class="mb-3">
                                        <label for="categoria_id" class="form-label">
                                            Seleccione una categoría <span class="text-danger">*</span>
                                        </label>
                                        <select class="form-select" id="categoria_id" name="categoria_id" required>
                                            <option value="">-- Seleccione --</option>
                                        </select>
                                        <div class="invalid-feedback">Por favor seleccione una categoría.</div>
                                        <div id="categoriaPreview" class="categoria-preview mt-2" style="display: none;">
                                        </div>
                                    </div>
                                </div>

                                <!-- Materiales -->
                                <div class="form-section">
                                    <h6 class="form-section-title">
                                        <i class="bi bi-box-seam"></i> Materiales (Relación Múltiple)
                                    </h6>

                                    <div class="mb-3">
                                        <label for="materiales" class="form-label">
                                            Seleccione materiales <span class="text-danger">*</span>
                                        </label>
                                        <div class="multi-select-wrapper">
                                            <div class="multi-select-input" id="multiSelectInput">
                                                <div class="selected-items" id="selectedItems"></div>
                                                <input type="text" class="multi-select-search" id="materialSearch"
                                                    placeholder="Buscar materiales...">
                                            </div>
                                            <div class="multi-select-dropdown" id="materialDropdown"
                                                style="display: none;">
                                                <div class="dropdown-search">
                                                    <i class="bi bi-search"></i>
                                                    <input type="text" id="dropdownSearch" placeholder="Buscar...">
                                                </div>
                                                <div class="dropdown-items" id="dropdownItems"></div>
                                            </div>
                                        </div>
                                        <div class="invalid-feedback" id="materialesError">Debe seleccionar al menos un
                                            material.</div>
                                    </div>
                                </div>

                                <!-- Medidas -->
                                <div class="form-section">
                                    <h6 class="form-section-title">
                                        <i class="bi bi-rulers"></i> Medidas
                                    </h6>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="ancho" class="form-label">
                                                    Ancho (cm) <span class="text-danger">*</span>
                                                </label>
                                                <input type="number" class="form-control" id="ancho" name="ancho"
                                                    min="0" step="0.1" required>
                                                <div class="invalid-feedback">Ingrese el ancho.</div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="alto" class="form-label">
                                                    Alto (cm) <span class="text-danger">*</span>
                                                </label>
                                                <input type="number" class="form-control" id="alto" name="alto"
                                                    min="0" step="0.1" required>
                                                <div class="invalid-feedback">Ingrese el alto.</div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="grosor" class="form-label">
                                                    Grosor (mm)
                                                </label>
                                                <input type="number" class="form-control" id="grosor" name="grosor"
                                                    min="0" step="0.1">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="dimension-preview" id="dimensionPreview">
                                        <div class="dimension-box">
                                            <div class="dimension-label dimension-width">
                                                <span>Ancho: <strong id="previewAncho">0</strong> cm</span>
                                            </div>
                                            <div class="dimension-label dimension-height">
                                                <span>Alto: <strong id="previewAlto">0</strong> cm</span>
                                            </div>
                                            <div class="dimension-rect"></div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Color -->
                                <div class="form-section">
                                    <h6 class="form-section-title">
                                        <i class="bi bi-palette"></i> Selección de Color
                                    </h6>

                                    <div class="mb-3">
                                        <label class="form-label">
                                            Color del producto <span class="text-danger">*</span>
                                        </label>
                                        <div class="color-selector">
                                            <div class="color-option" data-color="#000000">
                                                <div class="color-circle" style="background: #000000;"></div>
                                                <span>Negro</span>
                                            </div>
                                            <div class="color-option" data-color="#FFFFFF">
                                                <div class="color-circle"
                                                    style="background: #FFFFFF; border: 2px solid #2a2e38;"></div>
                                                <span>Blanco</span>
                                            </div>
                                            <div class="color-option" data-color="#808080">
                                                <div class="color-circle" style="background: #808080;"></div>
                                                <span>Gris</span>
                                            </div>
                                            <div class="color-option" data-color="#C0C0C0">
                                                <div class="color-circle" style="background: #C0C0C0;"></div>
                                                <span>Acero</span>
                                            </div>
                                            <div class="color-option" data-color="custom">
                                                <div class="color-circle color-custom">
                                                    <i class="bi bi-palette"></i>
                                                </div>
                                                <span>Personalizado</span>
                                            </div>
                                        </div>
                                        <input type="hidden" id="color" name="color" value="#000000">
                                        <div class="color-picker-wrapper mt-3" id="colorPickerWrapper"
                                            style="display: none;">
                                            <label for="customColor" class="form-label">Seleccione un color
                                                personalizado</label>
                                            <div class="d-flex align-items-center gap-3">
                                                <input type="color" id="customColor"
                                                    class="form-control form-control-color" value="#000000">
                                                <input type="text" id="colorHex" class="form-control"
                                                    placeholder="#000000" maxlength="7">
                                            </div>
                                        </div>
                                        <div class="color-preview mt-3">
                                            <label class="form-label">Vista previa del color:</label>
                                            <div class="selected-color-preview">
                                                <div class="preview-box" id="colorPreviewBox"
                                                    style="background: #000000;"></div>
                                                <span id="colorPreviewText">#000000 - Negro</span>
                                            </div>
                                        </div>
                                        <div class="invalid-feedback" id="colorError">Debe seleccionar un color.</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Columna Derecha - Fotos -->
                            <div class="col-md-4">
                                <div class="form-section">
                                    <h6 class="form-section-title">
                                        <i class="bi bi-images"></i> Fotos del Producto (Máx. 4)
                                    </h6>

                                    <div class="upload-images-area" id="uploadImagesArea">
                                        <input type="file" id="imagenes" name="imagenes[]" accept="image/*" multiple
                                            hidden>
                                        <div class="upload-placeholder" id="uploadPlaceholder">
                                            <i class="bi bi-cloud-upload"></i>
                                            <p>Haz clic o arrastra hasta 4 imágenes</p>
                                            <small>JPG, PNG o WEBP (máx. 2MB c/u)</small>
                                        </div>
                                    </div>

                                    <div class="images-preview-container" id="imagesPreviewContainer"></div>

                                    <div class="alert alert-info mt-3">
                                        <i class="bi bi-info-circle"></i>
                                        <small>Arrastra las imágenes para cambiar el orden. La primera será la imagen
                                            principal.</small>
                                    </div>
                                    <div class="invalid-feedback d-block" id="imagenesError"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="bi bi-x-circle"></i> Cancelar
                        </button>
                        <button type="submit" class="btn btn-primary" id="btnGuardar">
                            <i class="bi bi-check-circle"></i> Guardar Producto
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Ver Producto -->
    <div class="modal fade" id="modalVerProducto" tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="bi bi-eye"></i> Detalles del Producto
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="product-gallery">
                                <div class="main-image mb-3">
                                    <img src="/placeholder.svg" alt="" id="verImagenPrincipal"
                                        class="img-fluid rounded">
                                </div>
                                <div class="thumbnail-gallery" id="verThumbnails"></div>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <h3 id="verNombre"></h3>
                            <div class="mb-3">
                                <span id="verEstado"></span>
                                <span id="verCategoria" class="ms-2"></span>
                            </div>
                            <p class="text-muted mb-4" id="verDescripcion"></p>

                            <div class="detail-grid">
                                <div class="detail-item">
                                    <strong><i class="bi bi-rulers"></i> Medidas:</strong>
                                    <span id="verMedidas"></span>
                                </div>
                                <div class="detail-item">
                                    <strong><i class="bi bi-palette"></i> Color:</strong>
                                    <span id="verColor"></span>
                                </div>
                                <div class="detail-item">
                                    <strong><i class="bi bi-box-seam"></i> Materiales:</strong>
                                    <div id="verMateriales"></div>
                                </div>
                                <div class="detail-item">
                                    <strong><i class="bi bi-calendar"></i> Fecha de creación:</strong>
                                    <span id="verFecha"></span>
                                </div>
                            </div>
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
                    <p>¿Está seguro que desea eliminar el producto <strong id="eliminarNombre"></strong>?</p>
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
