<!-- Modal Crear Categoría -->
<div class="modal fade" id="modalCrearCategoria" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">
                    <i class="bi bi-plus-circle text-white fs-3"></i> Nueva Categoría
                </h5>
                <button type="button" class="btn-close btnCerrarModal" data-bs-dismiss="modal"></button>
            </div>
            <form id="formCategoria" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label for="nombre" class="form-label">
                                    Nombre de la Categoría <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control" id="nombre" name="nombre" required>
                                <div class="invalid-feedback">Por favor ingrese el nombre de la categoría.</div>
                            </div>

                            <div class="mb-3">
                                <label for="descripcion" class="form-label">
                                    Descripción <span class="text-danger">*</span>
                                </label>
                                <textarea class="form-control" id="descripcion" name="descripcion" rows="4" required></textarea>
                                <div class="invalid-feedback">Por favor ingrese una descripción.</div>
                                <small class="text-muted">
                                    <span id="charCount">0</span>/200 caracteres
                                </small>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Estado</label>
                                <div class="form-check form-switch form-switch-lg">
                                    <input class="form-check-input" type="checkbox" id="estado" name="estado" value="1"
                                        checked>
                                    <label class="form-check-label" for="estado">
                                        <span class="badge-status-active" id="estadoLabel">Activo</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">
                                    Imagen de la Categoría <span class="text-danger">*</span>
                                </label>
                                <div class="upload-area" id="uploadArea">
                                    <input type="file" id="imagen" name="imagen" accept="image/*" hidden>
                                    <div class="upload-placeholder" id="uploadPlaceholder">
                                        <i class="bi bi-cloud-upload"></i>
                                        <p>Haz clic o arrastra una imagen</p>
                                        <small>JPG, PNG o WEBP (máx. 2MB)</small>
                                    </div>
                                    <div class="image-preview" id="imagePreview" style="display: none;">
                                        <img src="/placeholder.svg" alt="Preview" id="previewImg">
                                        <button type="button" class="btn-remove-image" id="removeImage">
                                            <i class="bi bi-x"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="invalid-feedback" id="imagenError"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle"></i> Cancelar
                    </button>
                    <button type="submit" class="btn btn-primary" id="btnGuardar">
                        <i class="bi bi-check-circle"></i> Guardar Categoría
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
