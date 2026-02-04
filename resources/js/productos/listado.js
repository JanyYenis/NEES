"use strict";

const tablaProductos = "#tablaProductos";
const rutaCargarListadoProductos = route("productos.listado");

$(function () {
    listadoProductos();
});

/**
 * Función que permite cargar el listado.
 */
window.listadoProductos = () => {
    if ($.fn.DataTable.isDataTable('#tablaProductos')) {
        $('#tablaProductos').DataTable().destroy();
    }

    var table = $("#tablaProductos").DataTable({
        paging: true,
        responsive: true,
        serverSide: false,
        scrollX: true,
        searchDelay: 500,

        ajax: {
            "url": rutaCargarListadoProductos,
            "type": "GET",
            "headers": {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')
            },
            data: function (data) {
                generalidades.mostrarCargando(tablaProductos);
                data = Object.assign(data);
            },
            dataSrc: function (json) {
                generalidades.ocultarCargando(tablaProductos);
                return json.data
            },
        },
        buttons: [
            {
                extend: "excel",
                text: '<i class="fa fa-download"></i> Excel',
                className: "btn btn-light-success",
                title: "Listado productos.",
                exportOptions: {
                    columns: ":not(.excluir)"
                }
            },
            {
                text: '<i class="fa fa-sync-alt"></i> Actualizar',
                className: "btn btn-bg-secondary",
                action: function (e, dt, node, config) {
                    dt.ajax.reload(null, false);
                }
            }
        ],
        columnDefs: [
            {
                targets: "all",
                className: "text-center"
            },
            {
                targets: "none",
                className: "text-justify"
            }
        ],
        columns: [
            {
                render: function (data, type, full, meta) {
                    return meta.row + 1;
                }
            },
            {
                data: 'imagen',
                name: 'imagen'
            },
            {
                data: 'nombre',
                name: 'nombre'
            },
            {
                data: 'descripcion',
                name: 'descripcion',
                render: function (data, type, full, meta) {
                    return full?.descripcion ?? 'N/A';
                }
            },
            {
                data: 'categoria',
                name: 'categoria',
            },
            {
                data: 'medidas',
                name: 'medidas',
            },
            {
                data: 'estado',
                name: 'estado',
            },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            },
        ],
        order: [
            [0, "asc"]
        ],
        lengthMenu: [
            [15, 20, 50, 100, -1],
            [15, 20, 50, 100, "Todos"]
        ],
        pageLength: 15,
        dom: `<'row d-flex align-items-center justify-content-end'
                <'d-flex align-items-center justify-content-end'B>><'row d-flex align-items-center justify-content-between'<'col-sm-6 col-lg-6 col-md-6'l><'col-sm-6 col-lg-6 col-md-6'f>>
            <'table-responsive'tr>
            <'row'<'col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start'i><'col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end'p>>`,
        initComplete: function () {},
        drawCallback: function(settings) {
            KTMenu.createInstances();
        }
    });
}
