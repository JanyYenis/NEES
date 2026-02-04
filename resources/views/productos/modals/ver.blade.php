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
