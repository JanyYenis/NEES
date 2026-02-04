"use strict";

$(function () {
    iniciarComponentes();
});

const iniciarComponentes = (form = "") => {
    generalProductos();
}

window.generalProductos = () => {
    const config = {
        'method': 'GET',
        'headers': {
            'Accept': generalidades.CONTENT_TYPE_JSON,
        },
    }

    const success = (response) => {
        if (response.estado == 'success') {
            $('#totalProductos').text(response?.info?.cantidad_total ?? 0);
            $('#productosActivos').text(response?.info?.cantidad_activas ?? 0);
            $('#productosInactivos').text(response?.info?.cantidad_inactivos ?? 0);
            $('#categoriasConProductos').text(response?.info?.cantidad_categorias ?? 0);
        }
        generalidades.toastrGenerico(response?.estado, response?.mensaje);
    }

    const error = (response) => {
        generalidades.toastrGenerico(response?.estado, response?.mensaje);
    }

    generalidades.get(route('productos.banner'), config, success, error);
}

import './listado';
import './crear';
// import './ver';
// import './editar';
// import './eliminar';
