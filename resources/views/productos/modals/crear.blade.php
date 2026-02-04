<!-- Modal Crear/Editar Producto -->
<div class="modal fade" id="modalCrearProducto" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-white" id="modalTitle">
                    <i class="bi bi-plus-circle"></i> Nuevo Producto
                </h5>
                <button type="button" class="btn-close btnCerrarModal" data-bs-dismiss="modal"></button>
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
                                    <input type="text" class="form-control" id="nombre" name="nombre" required>
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
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="form-check form-switch form-switch-lg">
                                            <input class="form-check-input" type="checkbox" id="estado" name="estado"
                                                checked />
                                        </div>
                                        <span class="badge-status badge-status-active" id="estadoLabel">Activo</span>
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
                                    <select class="form-select" id="categoria_id" name="cod_categoria" data-control="select2" data-placeholder="Seleccione la categoria" data-allow-clear="true" required data-dropdown-parent="body">
                                        <option value=""></option>
                                        @foreach ($categorias as $item)
                                            <option value="{{ $item->id }}">{{ $item?->nombre }}</option>
                                        @endforeach
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
                                        <div class="multi-select-dropdown" id="materialDropdown" style="display: none;">
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
