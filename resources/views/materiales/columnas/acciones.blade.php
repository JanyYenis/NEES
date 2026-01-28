<div class="d-flex gap-2 justify-content-center">
    <button class="btn-action btn-view btnVer" data-id="{{ $model?->id }}" title="Ver">
        <i class="bi bi-eye"></i>
    </button>
    <button class="btn-action btn-edit btnEditar" data-id="{{ $model?->id }}" title="Editar">
        <i class="bi bi-pencil"></i>
    </button>
    <button class="btn-action btn-delete btnEliminar" data-id="{{ $model?->id }}" title="Eliminar">
        <i class="bi bi-trash"></i>
    </button>
</div>
