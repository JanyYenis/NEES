<input type="hidden" name="id" value="{{ $categoria->id }}">
<div class="row">
    <div class="col-md-8">
        <div class="mb-3">
            <label for="nombre" class="form-label">
                Nombre de la Categoría <span class="text-danger">*</span>
            </label>
            <input type="text" class="form-control" id="nombre" name="nombre"
                value="{{ $categoria?->nombre ?? '' }}" required>
            <div class="invalid-feedback">Por favor ingrese el nombre de la categoría.</div>
        </div>

        <div class="mb-3">
            <label for="descripcion" class="form-label">
                Descripción <span class="text-danger">*</span>
            </label>
            <textarea class="form-control" id="descripcion" name="descripcion" rows="4" required>{{ $categoria?->descripcion ?? '' }}</textarea>
            <div class="invalid-feedback">Por favor ingrese una descripción.</div>
            <small class="text-muted">
                <span id="charCount">0</span>/200 caracteres
            </small>
        </div>

        <div class="mb-3">
            <label class="form-label">Estado</label>
            <div class="d-flex align-items-center gap-3">
                <div class="form-check form-switch form-switch-lg">
                    <input class="form-check-input" type="checkbox" id="estadoEdit" name="estado"
                        {{ $categoria?->estado == 1 ? 'checked' : '' }} />
                </div>
                <span
                    class="badge-status {{ $categoria?->estado == 1 ? 'badge-status-active' : 'badge-status-inactive' }}"
                    id="estadoLabelEdit">{{ $categoria?->estado == 1 ? 'Activo' : 'Inactivo' }}</span>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="mb-3">
            <label class="form-label">
                Imagen de la Categoría <span class="text-danger">*</span>
            </label>
            <div class="upload-area" id="uploadAreaEdit">
                <input type="file" id="imagenEdit" name="imagen" accept="image/*" hidden>
                <div class="upload-placeholder" id="uploadPlaceholderEdit"
                    style="display: {{ $categoria?->imagenActiva ? 'none' : 'block' }};">
                    <i class="bi bi-cloud-upload"></i>
                    <p>Haz clic o arrastra una imagen</p>
                    <small>JPG, PNG o WEBP (máx. 2MB)</small>
                </div>
                <div class="image-preview" id="imagePreviewEdit">
                    <img src="{{ asset('storage/' . $categoria?->imagenActiva?->url ?? '#') }}" alt="Preview"
                        id="previewImgEdit">
                    <button type="button" class="btn-remove-image" id="removeImageEdit">
                        <i class="bi bi-x"></i>
                    </button>
                </div>
            </div>
            <div class="invalid-feedback" id="imagenError"></div>
        </div>
    </div>
</div>
