"use strict";

const formProducto = '#formProducto';
const modalCrearProducto = '#modalCrearProducto';

let selectedMateriales = [];
let uploadedImages = []

const colorPresets = {
    "#000000": "Negro",
    "#FFFFFF": "Blanco",
    "#808080": "Gris",
    "#C0C0C0": "Acero Natural",
}

$(function () {
    iniciarComponentes(formProducto);
    generalidades.validarFormulario(formProducto, enviarDatos);
});

const iniciarComponentes = (form = "") => {
    // Dimension Preview
    document.getElementById("ancho")?.addEventListener("input", updateDimensionPreview)
    document.getElementById("alto")?.addEventListener("input", updateDimensionPreview)

    function updateDimensionPreview() {
        const ancho = Number.parseFloat(document.getElementById("ancho").value) || 0
        const alto = Number.parseFloat(document.getElementById("alto").value) || 0

        document.getElementById("previewAncho").textContent = ancho
        document.getElementById("previewAlto").textContent = alto

        const rect = document.querySelector(".dimension-rect")
        if (ancho > 0 && alto > 0) {
            const ratio = ancho / alto
            if (ratio > 1) {
                rect.style.width = "200px"
                rect.style.height = `${200 / ratio}px`
            } else {
                rect.style.height = "200px"
                rect.style.width = `${200 * ratio}px`
            }
        }
    }

    // Character Count
    document.getElementById("descripcion")?.addEventListener("input", function () {
        const count = this.value.length
        document.getElementById("charCount").textContent = count
    })

    // Estado Switch Label
    document.getElementById("estado")?.addEventListener("change", function () {
        const label = document.getElementById("estadoLabel")
        if (this.checked) {
            label.textContent = "Activo"
            label.className = "badge-status badge-status-active"
        } else {
            label.textContent = "Inactivo"
            label.className = "badge-status badge-status-inactive"
        }
    });

    loadMaterialesDropdown();
    initColorSelector();
    initImageUpload();
}

function loadMaterialesDropdown() {
    const dropdownItems = document.getElementById("dropdownItems")
    const multiSelectInput = document.getElementById("multiSelectInput")
    const materialSearch = document.getElementById("materialSearch")
    const dropdown = document.getElementById("materialDropdown")
    const dropdownSearch = document.getElementById("dropdownSearch")

    // Render materiales
    function renderMateriales(filter = "") {
        dropdownItems.innerHTML = ""

        const config = {
            'method': 'GET',
            'headers': {
                'Accept': generalidades.CONTENT_TYPE_JSON,
            },
        }

        const success = (response) => {
            if (response.estado == 'success') {
                const filtered = response?.materiales.filter((m) => m.nombre.toLowerCase().includes(filter.toLowerCase()))
                filtered.forEach((material) => {

                    const isSelected = selectedMateriales.find((sm) => sm.id === material.id)
                    const item = document.createElement("div")
                    item.className = `dropdown-item-custom ${isSelected ? "selected" : ""}`
                    item.innerHTML = `
                        <div class="material-info">
                        <span class="material-name">${material.nombre}</span>
                        <span class="material-unit">Unidad: ${material?.info_tipo?.nombre ?? 'N/A'}</span>
                        </div>
                        ${isSelected ? '<i class="bi bi-check2"></i>' : ""}
                    `
                    item.addEventListener("click", () => toggleMaterial(material))
                    dropdownItems.appendChild(item)
                })
            }
            generalidades.toastrGenerico(response?.estado, response?.mensaje);
        }

        const error = (response) => {
            generalidades.toastrGenerico(response?.estado, response?.mensaje);
        }

        generalidades.get(route('materiales.buscar'), config, success, error);
    }

    // Toggle material selection
    function toggleMaterial(material) {
        const index = selectedMateriales.findIndex((m) => m.id === material.id)

        if (index > -1) {
            selectedMateriales.splice(index, 1)
        } else {
            selectedMateriales.push(material)
        }

        renderSelectedMateriales()
        renderMateriales(dropdownSearch.value)
    }

    // Render selected materiales
    function renderSelectedMateriales() {
        const selectedItemsContainer = document.getElementById("selectedItems")
        selectedItemsContainer.innerHTML = ""

        selectedMateriales.forEach((material) => {
            const item = document.createElement("div")
            item.className = "selected-item"
            item.innerHTML = `
        <span>${material.nombre}</span>
        <span class="unidad-badge">${material?.info_tipo?.nombre ?? 'N/A'}</span>
        <button type="button" class="btn-remove">
          <i class="bi bi-x-lg"></i>
        </button>
      `

            item.querySelector(".btn-remove").addEventListener("click", (e) => {
                e.stopPropagation()
                toggleMaterial(material)
            })

            selectedItemsContainer.appendChild(item)
        })
    }

    // Show/hide dropdown
    multiSelectInput.addEventListener("click", () => {
        dropdown.style.display = dropdown.style.display === "none" ? "block" : "none"
        if (dropdown.style.display === "block") {
            materialSearch.focus()
            renderMateriales()
        }
    })

    // Search in dropdown
    dropdownSearch.addEventListener("input", (e) => {
        renderMateriales(e.target.value)
    })

    // Close dropdown when clicking outside
    document.addEventListener("click", (e) => {
        if (!multiSelectInput.contains(e.target) && !dropdown.contains(e.target)) {
            dropdown.style.display = "none"
        }
    })

    renderMateriales()
}

// Color Selector
function initColorSelector() {
    const colorOptions = document.querySelectorAll(".color-option")
    const colorInput = document.getElementById("color")
    const colorPickerWrapper = document.getElementById("colorPickerWrapper")
    const customColorPicker = document.getElementById("customColor")
    const colorHexInput = document.getElementById("colorHex")
    const previewBox = document.getElementById("colorPreviewBox")
    const previewText = document.getElementById("colorPreviewText")

    colorOptions.forEach((option) => {
        option.addEventListener("click", function () {
            colorOptions.forEach((opt) => opt.classList.remove("active"))
            this.classList.add("active")

            const color = this.dataset.color

            if (color === "custom") {
                colorPickerWrapper.style.display = "block"
                updateColorPreview(customColorPicker.value, "Personalizado")
                colorInput.value = customColorPicker.value
            } else {
                colorPickerWrapper.style.display = "none"
                colorInput.value = color
                updateColorPreview(color, colorPresets[color])
            }
        })
    })

    // Custom color picker
    customColorPicker.addEventListener("input", (e) => {
        const color = e.target.value
        colorHexInput.value = color.toUpperCase()
        colorInput.value = color
        updateColorPreview(color, "Personalizado")
    })

    colorHexInput.addEventListener("input", (e) => {
        const hex = e.target.value
        if (hex.startsWith("#") && /^#[0-9A-F]{6}$/i.test(hex)) {
            customColorPicker.value = hex
            colorInput.value = hex
            updateColorPreview(hex, "Personalizado")
        }
    })

    function updateColorPreview(color, name) {
        previewBox.style.background = color
        previewText.textContent = `${color.toUpperCase()} - ${name}`
    }
}

// Image Upload with Drag & Drop and Sortable
function initImageUpload() {
    const uploadArea = document.getElementById("uploadImagesArea")
    const inputFile = document.getElementById("imagenes")
    const previewContainer = document.getElementById("imagesPreviewContainer")
    const placeholder = document.getElementById("uploadPlaceholder")

    // Click to upload
    uploadArea.addEventListener("click", () => inputFile.click())

    // File input change
    inputFile.addEventListener("change", (e) => handleFiles(e.target.files))

    // Drag & Drop
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
        handleFiles(e.dataTransfer.files)
    })

    function handleFiles(files) {
        const maxFiles = 4
        const errorDiv = document.getElementById("imagenesError")

        if (uploadedImages.length + files.length > maxFiles) {
            errorDiv.textContent = `Solo se permiten hasta ${maxFiles} imágenes.`
            return
        }

        errorDiv.textContent = ""

        Array.from(files).forEach((file) => {
            if (file.type.startsWith("image/")) {
                const reader = new FileReader()
                reader.onload = (e) => {
                    uploadedImages.push(e.target.result)
                    renderImagePreviews()
                }
                reader.readAsDataURL(file)
            }
        })
    }

    function renderImagePreviews() {
        previewContainer.innerHTML = ""

        if (uploadedImages.length > 0) {
            placeholder.style.display = "none"
        } else {
            placeholder.style.display = "block"
        }

        uploadedImages.forEach((src, index) => {
            const item = document.createElement("div")
            item.className = "image-preview-item"
            item.dataset.index = index
            item.innerHTML = `
        <img src="${src}" alt="Preview ${index + 1}">
        <span class="image-order-badge">${index + 1}</span>
        <button type="button" class="btn-remove-image" data-index="${index}">
          <i class="bi bi-x"></i>
        </button>
      `

            item.querySelector(".btn-remove-image").addEventListener("click", (e) => {
                e.stopPropagation()
                removeImage(index)
            })

            previewContainer.appendChild(item)
        })

        // Initialize Sortable
        const Sortable = window.Sortable // Declare Sortable variable
        if (Sortable && uploadedImages.length > 1) {
            new Sortable(previewContainer, {
                animation: 150,
                ghostClass: "sortable-ghost",
                onEnd: (evt) => {
                    const movedItem = uploadedImages.splice(evt.oldIndex, 1)[0]
                    uploadedImages.splice(evt.newIndex, 0, movedItem)
                    renderImagePreviews()
                },
            })
        }
    }

    function removeImage(index) {
        uploadedImages.splice(index, 1)
        renderImagePreviews()
    }
}

const enviarDatos = (form) => {
    let formData = new FormData(document.getElementById("formProducto"));
    formData.append('estado', $('#formProducto #estado').is(':checked') ? 1 : 2);
    const materialesIds = selectedMateriales.map(m => m.id);

    materialesIds.forEach(id => {
        formData.append('materiales[]', id);
    });

    const config = {
        'method': 'POST',
        'headers': {
            'Accept': generalidades.CONTENT_TYPE_JSON,
        },
        'body': formData
    }

    const success = (response) => {
        if (response.estado == 'success') {
            generalidades.ocultarValidaciones(formProducto);
            $('.btnCerrarModal, .btn-close').trigger('click');
            window.listadoProductos();
        }
        generalidades.ocultarCargando(formProducto);
        generalidades.toastrGenerico(response?.estado, response?.mensaje);
        window.generalProductos();
    }

    const error = (response) => {
        generalidades.ocultarCargando(formProducto);
        generalidades.toastrGenerico(response?.estado, response?.mensaje);
        generalidades.mostrarValidaciones(formProducto, response.validaciones);
        window.generalProductos();
    }
    const ruta = route("productos.store");
    generalidades.create(ruta, config, success, error);
    generalidades.mostrarCargando(formProducto);
}


$(document).on('hidden.bs.modal', modalCrearProducto, function (e) {
    generalidades.resetValidate(formProducto);
    document.getElementById("categoriaPreview").style.display = "none"
    document.getElementById("colorPickerWrapper").style.display = "none"
    document.getElementById("materialesError").style.display = "none"
    document.getElementById("imagenesError").textContent = ""

    selectedMateriales = []
    uploadedImages = []

    document.getElementById("selectedItems").innerHTML = ""
    document.getElementById("imagesPreviewContainer").innerHTML = ""
    document.getElementById("uploadPlaceholder").style.display = "block"
    document.getElementById("modalTitle").innerHTML = '<i class="bi bi-plus-circle"></i> Nuevo Producto'
    document.getElementById("estadoLabel").textContent = "Activo"
    document.getElementById("estadoLabel").className = "badge-status badge-status-active"

    document.querySelectorAll(".color-option").forEach((opt) => opt.classList.remove("active"))
    document.querySelector('.color-option[data-color="#000000"]').classList.add("active")
});
