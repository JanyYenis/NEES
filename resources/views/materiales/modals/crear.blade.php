<!-- Modal Crear Material -->
<div class="modal fade" id="modalCrearMaterial" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-white" id="modalTitle">
                    <i class="bi bi-plus-circle text-white fs-3"></i> Nuevo Material
                </h5>
                <button type="button" class="btn-close btnCerrarModal" data-bs-dismiss="modal"></button>
            </div>
            <form id="formMaterial" novalidate>
                <div class="modal-body">
                    <!-- Nombre -->
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre del Material <span
                                class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="nombre" name="nombre" required
                            placeholder="Ej: Pintura anticorrosiva" />
                        <div class="invalid-feedback">El nombre es obligatorio</div>
                    </div>

                    <!-- Descripción -->
                    <div class="mb-3">
                        <label for="descripcion" class="form-label">Descripción</label>
                        <textarea class="form-control" id="descripcion" name="descripcion" rows="3" maxlength="500"
                            placeholder="Descripción detallada del material..."></textarea>
                        <small class="text-muted"><span id="charCount">0</span>/500 caracteres</small>
                    </div>

                    <!-- Imágenes (máx. 2) -->
                    <div class="mb-3">
                        <label class="form-label">Fotos del Material (máx. 2)</label>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="upload-area" id="uploadArea1">
                                    <div class="upload-placeholder" id="uploadPlaceholder1">
                                        <i class="bi bi-cloud-upload"></i>
                                        <p>Imagen 1</p>
                                        <small>JPG, PNG, WEBP (máx. 2MB)</small>
                                    </div>
                                    <div class="image-preview" id="imagePreview1" style="display: none">
                                        <img src="/placeholder.svg" alt="Preview" id="previewImg1" />
                                        <button type="button" class="btn-remove-image" id="removeImage1">
                                            <i class="bi bi-x"></i>
                                        </button>
                                    </div>
                                </div>
                                <input type="file" id="imagen1" name="imagenes[]" accept="image/*"
                                    style="display: none" />
                            </div>
                            <div class="col-md-6">
                                <div class="upload-area" id="uploadArea2">
                                    <div class="upload-placeholder" id="uploadPlaceholder2">
                                        <i class="bi bi-cloud-upload"></i>
                                        <p>Imagen 2</p>
                                        <small>JPG, PNG, WEBP (máx. 2MB)</small>
                                    </div>
                                    <div class="image-preview" id="imagePreview2" style="display: none">
                                        <img src="/placeholder.svg" alt="Preview" id="previewImg2" />
                                        <button type="button" class="btn-remove-image" id="removeImage2">
                                            <i class="bi bi-x"></i>
                                        </button>
                                    </div>
                                </div>
                                <input type="file" id="imagen2" name="imagenes[]" accept="image/*"
                                    style="display: none" />
                            </div>
                        </div>
                    </div>

                    <!-- Cantidad / Unidad -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="cantidad" class="form-label">Cantidad</label>
                                <input type="number" class="form-control" id="cantidad" name="cantidad" step="0.01"
                                    placeholder="1.0" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="unidad" class="form-label">Unidad de Medida <span
                                        class="text-danger">*</span></label>
                                <select class="form-select" id="unidad" name="unidad_medida" data-control="select2" data-placeholder="Seleccione la unidad de medida" data-allow-clear="true" required data-dropdown-parent="body">
                                    <option value=""></option>
                                    @foreach ($tipos as $item)
                                        <option value="{{ $item?->codigo }}">{{ $item?->nombre }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">Seleccione una unidad</div>
                            </div>
                        </div>
                    </div>

                    <!-- Campo personalizado -->
                    <div class="mb-3" id="unidadPersonalizadaContainer" style="display: none">
                        <label for="unidadPersonalizada" class="form-label">Unidad Personalizada</label>
                        <input type="text" class="form-control" id="unidadPersonalizada"
                            name="unidad_personalizada" placeholder="Ej: Cajas, Paquetes, etc." />
                    </div>

                    <!-- Estado -->
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
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i> Guardar Material
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
