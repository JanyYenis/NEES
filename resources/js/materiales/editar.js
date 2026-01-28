"use strict";

// rutas
const rutaEditar = "materiales.edit";

// id y clases
const formEditarMaterial = "#formEditarMaterial";
const seccionEditar = ".seccionEditar";
const modalEditar = "#modalEditarMaterial";

$(function () {
    generalidades.validarFormulario(formEditarMaterial, enviarDatos);
});

$(document).on("click", ".btnEditar", function () {
    let id = $(this).attr("data-id");
    if (id) {
        // id = JSON.parse(id);
        cargarDatos(id);
    }
});

const cargarDatos = (id) => {
    const ruta = route(rutaEditar, { "material": id });
    generalidades.mostrarCargando('body');
    generalidades.ejecutar('GET', ruta, 'body', modalEditar, seccionEditar, function(){
        iniciarComponentes(formEditarMaterial);
    });
}

const iniciarComponentes = (form = "") => {
// Character count
    document.getElementById("descripcionEdit").addEventListener("input", function () {
        document.getElementById("charCountEdit").textContent = this.value.length
    })

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
    });

    // Image uploads
  setupImageUpload(1);
  setupImageUpload(2);
}

// Setup image upload for specific image number
function setupImageUpload(num) {
  const uploadArea = document.getElementById(`uploadArea${num}Edit`)
  const imageInput = document.getElementById(`imagen${num}Edit`)
  const removeBtn = document.getElementById(`removeImage${num}Edit`)

  uploadArea.addEventListener("click", (e) => {
    if (!e.target.closest(".btn-remove-image")) {
      imageInput.click()
    }
  })

  imageInput.addEventListener("change", () => handleImageUpload(num))

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
      handleImageUpload(num)
    }
  })

  removeBtn.addEventListener("click", (e) => {
    e.stopPropagation()
    clearImage(num)
  })
}

// Handle image upload
function handleImageUpload(num) {
  const input = document.getElementById(`imagen${num}Edit`)
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
      document.getElementById(`uploadPlaceholder${num}Edit`).style.display = "none"
      document.getElementById(`imagePreview${num}Edit`).style.display = "block"
      document.getElementById(`previewImg${num}Edit`).src = e.target.result
    }
    reader.readAsDataURL(file)
  }
}

// Clear image
function clearImage(num) {
  document.getElementById(`imagen${num}Edit`).value = ""
  document.getElementById(`uploadPlaceholder${num}Edit`).style.display = "block"
  document.getElementById(`imagePreview${num}Edit`).style.display = "none"
  document.getElementById(`previewImg${num}Edit`).src = ""
}

$(document).on('change', '#unidadEdit', function(){
    handleUnidadChange();
});

// Handle unidad change
function handleUnidadChange() {
  const unidad = document.getElementById("unidadEdit").value
  const container = document.getElementById("unidadPersonalizadaContainerEdit")

  if (unidad == 8) {
    container.style.display = "block"
  } else {
    container.style.display = "none"
  }
}

const enviarDatos = (form) => {
    let formData = new FormData(document.getElementById("formEditarMaterial"));
    formData.append('estado', $('#formEditarMaterial #estadoEdit').is(':checked') ? 1 : 2);
    // Get images
    const imagenes = []
    for (let i = 1; i <= 2; i++) {
        const previewImg = document.getElementById(`previewImg${i}Edit`).src
        if (previewImg) {
        imagenes.push(previewImg)
        }
    }

    if (imagenes.length === 0) {
        alert("Por favor agregue al menos una imagen")
        return
    }

    formData.append('imagenes', imagenes);

    const config = {
        'method': 'POST',
        'headers': {
            'Accept': generalidades.CONTENT_TYPE_JSON,
        },
        'body': formData
    }

    const success = (response) => {
        if (response.estado == 'success') {
            generalidades.ocultarValidaciones(formEditarMaterial);
            $('.btnCerrarModal').trigger('click');
            window.listadoMateriales();
        }
        generalidades.ocultarCargando(formEditarMaterial);
        generalidades.toastrGenerico(response?.estado, response?.mensaje);
        window.generalMateriales();
    }

    const error = (response) => {
        generalidades.ocultarCargando(formEditarMaterial);
        generalidades.toastrGenerico(response?.estado, response?.mensaje);
        generalidades.mostrarValidaciones(formEditarMaterial, response.validaciones);
        window.generalMateriales();
    }
    const rutaActualizar = route("materiales.update", { "material": formData.get("id") });
    generalidades.create(rutaActualizar, config, success, error);
    generalidades.mostrarCargando(formEditarMaterial);
}
