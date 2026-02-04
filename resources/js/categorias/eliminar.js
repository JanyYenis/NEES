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
            $('#eliminarNombre').text(response?.categoria?.nombre ?? '');
            if (response?.categoria?.productos_activos?.length) {
                document.getElementById("alertProductos").style.display = "block";
                $('#eliminarProductos').text(response?.categoria?.productos_activos?.length ?? 0);
            } else {
                document.getElementById("alertProductos").style.display = "none"
                $('#eliminarProductos').text(0);
            }
        }
        generalidades.toastrGenerico(response?.estado, response?.mensaje);
    }

    const error = (response) => {
        generalidades.toastrGenerico(response?.estado, response?.mensaje);
    }

    generalidades.get(route('categorias.data', { categoria: id_eliminar }), config, success, error);
});

$(document).on('click', '#btnConfirmarEliminar', function(){
    eliminar(id_eliminar);
});

const eliminar = (id) => {
    let ruta = route('categorias.delete', { 'categoria': id } );
    let config = {
        "headers": {
            "Accept": generalidades.CONTENT_TYPE_JSON,
            "Content-Type": generalidades.CONTENT_TYPE_JSON
        },
        "method": "DELETE",
        "body": {
            'categoria': id
        }
    }

    const success = (response) => {
        if (response.estado == 'success') {
            $('.btnCerrarModal').trigger('click');
            window.listadoCategoria();
        }
        generalidades.ocultarCargando('body');
        generalidades.toastrGenerico(response?.estado, response?.mensaje);
        window.generalCategorias();
    }
    const error = (response) => {
        generalidades.ocultarCargando('body');
        generalidades.toastrGenerico(response?.estado, response?.mensaje);
        window.generalCategorias();
    }
    generalidades.delete(ruta, config, success, error);
    generalidades.mostrarCargando('body');
}
