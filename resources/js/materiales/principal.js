"use strict";

$(function () {
    iniciarComponentes();
});

const iniciarComponentes = (form = "") => {
    generalMateriales();
}

window.generalMateriales = () => {
    const config = {
        'method': 'GET',
        'headers': {
            'Accept': generalidades.CONTENT_TYPE_JSON,
        },
    }

    const success = (response) => {
        if (response.estado == 'success') {
            $('#totalMateriales').text(response?.info?.cantidad_total ?? 0);
            $('#materialesActivos').text(response?.info?.cantidad_activas ?? 0);
            $('#materialesInactivos').text(response?.info?.cantidad_inactivos ?? 0);
            $('#tiposUnidad').text(response?.info?.cantidad_unidad ?? 0);
        }
        generalidades.toastrGenerico(response?.estado, response?.mensaje);
    }

    const error = (response) => {
        generalidades.toastrGenerico(response?.estado, response?.mensaje);
    }

    generalidades.get(route('materiales.banner'), config, success, error);
}

import './listado';
import './crear';
import './ver';
import './editar';
import './eliminar';
