<!-- Modal Eliminar -->
<div class="modal fade" id="modalEliminar" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-white">
                    <i class="bi bi-exclamation-triangle text-danger"></i> Confirmar Eliminación
                </h5>
                <button type="button" class="btn-close btnCerrarModal" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>¿Está seguro que desea eliminar el material <strong id="eliminarNombre"></strong>?</p>
                <div class="alert alert-warning" id="alertProductos" style="display: none">
                    <i class="bi bi-exclamation-triangle"></i>
                    Este material está asociado a productos. Elimínelo con precaución.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-danger" id="btnConfirmarEliminar">
                    <i class="bi bi-trash"></i> Eliminar
                </button>
            </div>
        </div>
    </div>
</div>
