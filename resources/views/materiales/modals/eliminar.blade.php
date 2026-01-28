<!-- Modal Confirmar Eliminar -->
<div class="modal fade" id="modalEliminar" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title text-danger">
                    <i class="bi bi-exclamation-triangle text-white fs-3"></i> Confirmar Eliminación
                </h5>
                <button type="button" class="btn-close btnCerrarModal" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>¿Está seguro que desea eliminar la categoría <strong id="eliminarNombre"></strong>?</p>
                <div class="alert alert-warning" id="alertProductos" style="display: none;">
                    <i class="bi bi-exclamation-circle"></i>
                    Esta categoría tiene <strong id="eliminarProductos"></strong> productos asociados.
                </div>
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
