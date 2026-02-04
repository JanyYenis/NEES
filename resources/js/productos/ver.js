"use strict";

// rutas
const rutaVerMaterial = "materiales.show";

// id y clases
const seccionVerMaterial = ".seccionVerMaterial";
const modalVerMaterial = "#modalVerMaterial";

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
    const ruta = route(rutaVerMaterial, { "material": id });
    generalidades.mostrarCargando('body');
    generalidades.ejecutar('GET', ruta, 'body', modalVerMaterial, seccionVerMaterial, function(){
        iniciarComponentes();
    });
}

const iniciarComponentes = (form = "") => {
}
