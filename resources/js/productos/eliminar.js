"use strict";

var id_eliminar = null;

$(function () {
    iniciarComponentes();
});

const iniciarComponentes = (form = "") => {
}

$(document).on('click', '.btnEliminar', function(){
    id_eliminar = $(this).attr('data-id');

    const config = {
        'method': 'GET',
        'headers': {
            'Accept': generalidades.CONTENT_TYPE_JSON,
        },
    }

    const success = (response) => {
        if (response.estado == 'success') {
            $('#modalEliminar').modal('show');
            $('#eliminarNombre').text(response?.material?.nombre ?? '');
            if (response?.material?.productos_activos?.length) {
                document.getElementById("alertProductos").style.display = "block";
            } else {
                document.getElementById("alertProductos").style.display = "none"
            }
        }
        generalidades.toastrGenerico(response?.estado, response?.mensaje);
    }

    const error = (response) => {
        generalidades.toastrGenerico(response?.estado, response?.mensaje);
    }

    generalidades.get(route('materiales.data', { material: id_eliminar }), config, success, error);
});

$(document).on('click', '#btnConfirmarEliminar', function(){
    eliminar(id_eliminar);
});

const eliminar = (id) => {
    let ruta = route('materiales.delete', { 'material': id } );
    let config = {
        "headers": {
            "Accept": generalidades.CONTENT_TYPE_JSON,
            "Content-Type": generalidades.CONTENT_TYPE_JSON
        },
        "method": "DELETE",
        "body": {
            'material': id
        }
    }

    const success = (response) => {
        if (response.estado == 'success') {
            $('.btnCerrarModal').trigger('click');
            window.listadoMateriales();
        }
        generalidades.ocultarCargando('body');
        generalidades.toastrGenerico(response?.estado, response?.mensaje);
        window.generalMateriales();
    }
    const error = (response) => {
        generalidades.ocultarCargando('body');
        generalidades.toastrGenerico(response?.estado, response?.mensaje);
        window.generalMateriales();
    }
    generalidades.delete(ruta, config, success, error);
    generalidades.mostrarCargando('body');
}
