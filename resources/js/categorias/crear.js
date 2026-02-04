"use strict";

const formCategoria = '#formCategoria';
const modalCrearCategoria = '#modalCrearCategoria';

$(function () {
    iniciarComponentes(formCategoria);
    generalidades.validarFormulario(formCategoria, enviarDatos);
});

const iniciarComponentes = (form = "") => {
    // Image upload
    const uploadArea = document.getElementById("uploadArea")
    const imageInput = document.getElementById("imagen")

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

    document.getElementById("removeImage").addEventListener("click", (e) => {
        e.stopPropagation()
        clearImage()
    });

    // Status toggle
    document.getElementById("estado").addEventListener("change", function () {
        const label = document.getElementById("estadoLabel")
        if (this.checked) {
            label.textContent = "Activo"
            label.className = "badge-status badge-status-active"
        } else {
            label.textContent = "Inactivo"
            label.className = "badge-status badge-status-inactive"
        }
    });
}

// Handle image upload
function handleImageUpload() {
    const input = document.getElementById("imagen")
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
            document.getElementById("uploadPlaceholder").style.display = "none"
            document.getElementById("imagePreview").style.display = "block"
            document.getElementById("previewImg").src = e.target.result
        }
        reader.readAsDataURL(file)
    }
}

// Clear image
function clearImage() {
    document.getElementById("imagen").value = ""
    document.getElementById("uploadPlaceholder").style.display = "block"
    document.getElementById("imagePreview").style.display = "none"
    document.getElementById("previewImg").src = ""
}

const enviarDatos = (form) => {
    let formData = new FormData(document.getElementById("formCategoria"));
    formData.append('estado', $('#formCategoria #estado').is(':checked') ? 1 : 2);
    if ($("#previewImg").attr('src')) {
        formData.append('imagen', $("#previewImg").attr('src'));
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
            generalidades.ocultarValidaciones(formCategoria);
            $('.btnCerrarModal').trigger('click');
            window.listadoCategoria();
            clearImage();
        }
        generalidades.ocultarCargando(formCategoria);
        generalidades.toastrGenerico(response?.estado, response?.mensaje);
        window.generalCategorias();
    }

    const error = (response) => {
        generalidades.ocultarCargando(formCategoria);
        generalidades.toastrGenerico(response?.estado, response?.mensaje);
        generalidades.mostrarValidaciones(formCategoria, response.validaciones);
        window.generalCategorias();
    }
    const ruta = route("categorias.store");
    generalidades.create(ruta, config, success, error);
    generalidades.mostrarCargando(formCategoria);
}


$(document).on('hidden.bs.modal', modalCrearCategoria, function (e) {
    generalidades.resetValidate(formCategoria);
});
