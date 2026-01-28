"use strict";

// rutas
const rutaVerCategoria = "categorias.show";

// id y clases
const seccionVerCategoria = ".seccionVerCategoria";
const modalVerCategoria = "#modalVerCategoria";

$(function () {
});

$(document).on("click", ".btnVer", function () {
    let id = $(this).attr("data-id");
    if (id) {
        // id = JSON.parse(id);
        cargarDatos(id);
    }
});

const cargarDatos = (id) => {
    const ruta = route(rutaVerCategoria, { "categoria": id });
    generalidades.mostrarCargando('body');
    generalidades.ejecutar('GET', ruta, 'body', modalVerCategoria, seccionVerCategoria, function(){
        iniciarComponentes();
    });
}

const iniciarComponentes = (form = "") => {
}
