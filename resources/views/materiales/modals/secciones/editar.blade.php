<input type="hidden" name="id" value="{{ $material?->id }}"/>

<!-- Nombre -->
<div class="mb-3">
    <label for="nombre" class="form-label">Nombre del Material <span class="text-danger">*</span></label>
    <input type="text" class="form-control" id="nombreEdit" name="nombre" value="{{ $material?->nombre ?? '' }}" required
        placeholder="Ej: Pintura anticorrosiva" />
    <div class="invalid-feedback">El nombre es obligatorio</div>
</div>

<!-- Descripción -->
<div class="mb-3">
    <label for="descripcion" class="form-label">Descripción</label>
    <textarea class="form-control" id="descripcionEdit" name="descripcion" rows="3" maxlength="500"
        placeholder="Descripción detallada del material...">{{ $material?->descripcion ?? '' }}</textarea>
    <small class="text-muted"><span id="charCountEdit">0</span>/500 caracteres</small>
</div>

<!-- Imágenes (máx. 2) -->
<div class="mb-3">
    <label class="form-label">Fotos del Material (máx. 2)</label>
    <div class="row g-3">
        <div class="col-md-6">
            <div class="upload-area" id="uploadArea1Edit">
                <div class="upload-placeholder" id="uploadPlaceholder1Edit" style="display: {{ $material?->imagenesActivas?->get(0) ? 'none' : 'block' }};">
                    <i class="bi bi-cloud-upload"></i>
                    <p>Imagen 1</p>
                    <small>JPG, PNG, WEBP (máx. 2MB)</small>
                </div>
                <div class="image-preview" id="imagePreview1Edit" style="display: {{ $material?->imagenesActivas?->get(0) ? 'block' : 'none' }}">
                    <img src="{{ asset('storage/'.$material?->imagenesActivas?->get(0)?->url ?? '#') }}" alt="Preview" id="previewImg1Edit" />
                    <button type="button" class="btn-remove-image" id="removeImage1Edit">
                        <i class="bi bi-x"></i>
                    </button>
                </div>
            </div>
            <input type="file" id="imagen1Edit" name="imagenes[]" accept="image/*" style="display: none" />
        </div>
        <div class="col-md-6">
            <div class="upload-area" id="uploadArea2Edit">
                <div class="upload-placeholder" id="uploadPlaceholder2Edit" style="display: {{ $material?->imagenesActivas?->get(1) ? 'none' : 'block' }};">
                    <i class="bi bi-cloud-upload"></i>
                    <p>Imagen 2</p>
                    <small>JPG, PNG, WEBP (máx. 2MB)</small>
                </div>
                <div class="image-preview" id="imagePreview2Edit" style="display: {{ $material?->imagenesActivas?->get(1) ? 'block' : 'none' }}">
                    <img src="{{ asset('storage/'.$material?->imagenesActivas?->get(1)?->url ?? '#') }}" alt="Preview" id="previewImg2Edit" />
                    <button type="button" class="btn-remove-image" id="removeImage2Edit">
                        <i class="bi bi-x"></i>
                    </button>
                </div>
            </div>
            <input type="file" id="imagen2Edit" name="imagenes[]" accept="image/*" style="display: none" />
        </div>
    </div>
</div>

<!-- Cantidad / Unidad -->
<div class="row">
    <div class="col-md-6">
        <div class="mb-3">
            <label for="cantidad" class="form-label">Cantidad</label>
            <input type="number" class="form-control" id="cantidadEdit" name="cantidad" value="{{ $material?->cantidad ?? 0 }}" step="0.01"
                placeholder="1.0" />
        </div>
    </div>
    <div class="col-md-6">
        <div class="mb-3">
            <label for="unidad" class="form-label">Unidad de Medida <span class="text-danger">*</span></label>
            <select class="form-select" id="unidadEdit" name="unidad_medida" data-control="select2"
                data-placeholder="Seleccione la unidad de medida" data-allow-clear="true" required
                data-dropdown-parent="body">
                <option value=""></option>
                @foreach ($tipos as $item)
                    <option value="{{ $item?->codigo }}" {{ $item?->codigo == $material?->unidad_medida ? 'selected' : '' }}>{{ $item?->nombre }}</option>
                @endforeach
            </select>
            <div class="invalid-feedback">Seleccione una unidad</div>
        </div>
    </div>
</div>

<!-- Campo personalizado -->
<div class="mb-3" id="unidadPersonalizadaContainerEdit" style="display: {{ $material?->unidad_medida != 8 ? 'none' : 'block' }}">
    <label for="unidadPersonalizada" class="form-label">Unidad Personalizada</label>
    <input type="text" class="form-control" id="unidadPersonalizadaEdit" name="unidad_personalizada" value="{{ $material?->unidad_personalizada ?? '' }}"
        placeholder="Ej: Cajas, Paquetes, etc." />
</div>

<!-- Estado -->
<div class="mb-3">
    <label class="form-label">Estado</label>
    <div class="d-flex align-items-center gap-3">
        <div class="form-check form-switch form-switch-lg">
            <input class="form-check-input" type="checkbox" id="estadoEdit" name="estado" {{ $material?->estado == 1 ? 'checked' : '' }} />
        </div>
        <span class="badge-status {{ $material?->estado == 1 ? 'badge-status-active' : 'badge-status-inactive' }}" id="estadoLabelEdit">{{ $material?->estado == 1 ? 'Activo' : 'Inactivo' }}</span>
    </div>
</div>
