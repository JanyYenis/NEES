"use strict";

// rutas
const rutaEditar = "categorias.edit";

// id y clases
const formEditarCategoria = "#formEditarCategoria";
const seccionEditar = ".seccionEditar";
const modalEditar = "#modalEditarCategoria";

$(function () {
    generalidades.validarFormulario(formEditarCategoria, enviarDatos);
});

$(document).on("click", ".btnEditar", function () {
    let id = $(this).attr("data-id");
    if (id) {
        // id = JSON.parse(id);
        cargarDatos(id);
    }
});

const cargarDatos = (id) => {
    const ruta = route(rutaEditar, { "categoria": id });
    generalidades.mostrarCargando('body');
    generalidades.ejecutar('GET', ruta, 'body', modalEditar, seccionEditar, function () {
        iniciarComponentes(formEditarCategoria);
    });
}

const iniciarComponentes = (form = "") => {
    // Image upload
    const uploadArea = document.getElementById("uploadAreaEdit")
    const imageInput = document.getElementById("imagenEdit")

    uploadArea.addEventListener("click", () => imageInput.click())

    imageInput.addEventListener("change", handleImageUpload)

    uploadArea.addEventListener("dragover", (e) => {
        e.preventDefault()
        uploadArea.classList.add("drag-over")
    })

    uploadArea.addEventListener("dragleave", () => {
        uploadArea.classList.remove("drag-over")
    })

    uploadArea.addEventListener("drop", (e) => {
        e.preventDefault()
        uploadArea.classList.remove("drag-over")
        const files = e.dataTransfer.files
        if (files.length > 0) {
            imageInput.files = files
            handleImageUpload()
        }
    })

    document.getElementById("removeImageEdit").addEventListener("click", (e) => {
        e.stopPropagation()
        clearImage()
    });

    // Status toggle
    document.getElementById("estadoEdit").addEventListener("change", function () {
        const label = document.getElementById("estadoLabelEdit")
        if (this.checked) {
            label.textContent = "Activo"
            label.className = "badge-status badge-status-active"
        } else {
            label.textContent = "Inactivo"
            label.className = "badge-status badge-status-inactive"
        }
    })
}

// Handle image upload
function handleImageUpload() {
    const input = document.getElementById("imagenEdit")
    const file = input.files[0]

    if (file) {
        // Validate file type
        const validTypes = ["image/jpeg", "image/png", "image/webp"]
        if (!validTypes.includes(file.type)) {
            alert("Por favor seleccione un archivo JPG, PNG o WEBP")
            return
        }

        // Validate file size (2MB)
        if (file.size > 2 * 1024 * 1024) {
            alert("El archivo no debe superar los 2MB")
            return
        }

        // Show preview
        const reader = new FileReader()
        reader.onload = (e) => {
            document.getElementById("uploadPlaceholderEdit").style.display = "none"
            document.getElementById("imagePreviewEdit").style.display = "block"
            document.getElementById("previewImgEdit").src = e.target.result
        }
        reader.readAsDataURL(file)
    }
}

// Clear image
function clearImage() {
    document.getElementById("imagenEdit").value = ""
    document.getElementById("uploadPlaceholderEdit").style.display = "block"
    document.getElementById("imagePreviewEdit").style.display = "none"
    document.getElementById("previewImgEdit").src = ""
}

const enviarDatos = (form) => {
    let formData = new FormData(document.getElementById("formEditarCategoria"));
    formData.append('estado', $('#formEditarCategoria #estadoEdit').is(':checked') ? 1 : 2);
    if ($("#previewImgEdit").attr('src')) {
        formData.append('imagen', $("#previewImgEdit").attr('src'));
    }

    const config = {
        'method': 'POST',
        'headers': {
            'Accept': generalidades.CONTENT_TYPE_JSON,
        },
        'body': formData
    }

    const success = (response) => {
        if (response.estado == 'success') {
            generalidades.ocultarValidaciones(formEditarCategoria);
            $('.btnCerrarModal').trigger('click');
            window.listadoCategoria();
        }
        generalidades.ocultarCargando(formEditarCategoria);
        generalidades.toastrGenerico(response?.estado, response?.mensaje);
        window.generalCategorias();
    }

    const error = (response) => {
        generalidades.ocultarCargando(formEditarCategoria);
        generalidades.toastrGenerico(response?.estado, response?.mensaje);
        generalidades.mostrarValidaciones(formEditarCategoria, response.validaciones);
        window.generalCategorias();
    }
    const rutaActualizar = route("categorias.update", { "categoria": formData.get("id") });
    generalidades.create(rutaActualizar, config, success, error);
    generalidades.mostrarCargando(formEditarCategoria);
}
