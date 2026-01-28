"use strict";

const formMaterial = '#formMaterial';
const modalCrearMaterial = '#modalCrearMaterial';

$(function () {
    iniciarComponentes(formMaterial);
    generalidades.validarFormulario(formMaterial, enviarDatos);
});

const iniciarComponentes = (form = "") => {
    // Character count
    document.getElementById("descripcion").addEventListener("input", function () {
        document.getElementById("charCount").textContent = this.value.length
    })

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

    // Image uploads
  setupImageUpload(1);
  setupImageUpload(2);
}

// Setup image upload for specific image number
function setupImageUpload(num) {
  const uploadArea = document.getElementById(`uploadArea${num}`)
  const imageInput = document.getElementById(`imagen${num}`)
  const removeBtn = document.getElementById(`removeImage${num}`)

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
  const input = document.getElementById(`imagen${num}`)
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
      document.getElementById(`uploadPlaceholder${num}`).style.display = "none"
      document.getElementById(`imagePreview${num}`).style.display = "block"
      document.getElementById(`previewImg${num}`).src = e.target.result
    }
    reader.readAsDataURL(file)
  }
}

// Clear image
function clearImage(num) {
  document.getElementById(`imagen${num}`).value = ""
  document.getElementById(`uploadPlaceholder${num}`).style.display = "block"
  document.getElementById(`imagePreview${num}`).style.display = "none"
  document.getElementById(`previewImg${num}`).src = ""
}

$(document).on('change', '#unidad', function(){
    handleUnidadChange();
});

// Handle unidad change
function handleUnidadChange() {
  const unidad = document.getElementById("unidad").value
  const container = document.getElementById("unidadPersonalizadaContainer")

  if (unidad == 8) {
    container.style.display = "block"
  } else {
    container.style.display = "none"
  }
}

const enviarDatos = (form) => {
    let formData = new FormData(document.getElementById("formMaterial"));
    formData.append('estado', $('#formMaterial #estado').is(':checked') ? 1 : 2);

    const config = {
        'method': 'POST',
        'headers': {
            'Accept': generalidades.CONTENT_TYPE_JSON,
        },
        'body': formData
    }

    const success = (response) => {
        if (response.estado == 'success') {
            generalidades.ocultarValidaciones(formMaterial);
            $('.btnCerrarModal').trigger('click');
            window.listadoMateriales();
            clearImage(1);
            clearImage(2);
        }
        generalidades.ocultarCargando(formMaterial);
        generalidades.toastrGenerico(response?.estado, response?.mensaje);
        window.generalMateriales();
    }

    const error = (response) => {
        generalidades.ocultarCargando(formMaterial);
        generalidades.toastrGenerico(response?.estado, response?.mensaje);
        generalidades.mostrarValidaciones(formMaterial, response.validaciones);
        window.generalMateriales();
    }
    const ruta = route("materiales.store");
    generalidades.create(ruta, config, success, error);
    generalidades.mostrarCargando(formMaterial);
}


$(document).on('hidden.bs.modal', modalCrearMaterial, function (e) {
    generalidades.resetValidate(formMaterial);
});
