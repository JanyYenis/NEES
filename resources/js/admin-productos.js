// Admin Productos - JavaScript

// Sample Data
let productos = [
  {
    id: 1,
    nombre: "Puerta Principal Moderna",
    descripcion: "Puerta de entrada en acero con diseño contemporáneo",
    categoria_id: 1,
    categoria: { nombre: "Puertas", imagen: "https://placehold.co/50x50?text=P" },
    materiales: [
      { id: 1, nombre: "Acero Inoxidable 304", unidad: "kg" },
      { id: 3, nombre: "Vidrio Templado", unidad: "m²" },
    ],
    ancho: 90,
    alto: 210,
    grosor: 8,
    color: "#000000",
    colorNombre: "Negro",
    imagenes: [
      "https://placehold.co/400x400/000/fff?text=Puerta+1",
      "https://placehold.co/400x400/111/fff?text=Puerta+2",
      "https://placehold.co/400x400/222/fff?text=Puerta+3",
    ],
    estado: "activo",
    fecha: "2024-01-15",
  },
  {
    id: 2,
    nombre: "Ventana Panorámica",
    descripcion: "Ventana de aluminio con doble vidrio hermético",
    categoria_id: 2,
    categoria: { nombre: "Ventanas", imagen: "https://placehold.co/50x50?text=V" },
    materiales: [
      { id: 2, nombre: "Aluminio 6063-T5", unidad: "kg" },
      { id: 3, nombre: "Vidrio Templado", unidad: "m²" },
    ],
    ancho: 150,
    alto: 120,
    grosor: 6,
    color: "#FFFFFF",
    colorNombre: "Blanco",
    imagenes: [
      "https://placehold.co/400x400/fff/000?text=Ventana+1",
      "https://placehold.co/400x400/eee/000?text=Ventana+2",
    ],
    estado: "activo",
    fecha: "2024-01-18",
  },
]

const categorias = [
  { id: 1, nombre: "Puertas", imagen: "https://placehold.co/50x50?text=P" },
  { id: 2, nombre: "Ventanas", imagen: "https://placehold.co/50x50?text=V" },
  { id: 3, nombre: "Portones", imagen: "https://placehold.co/50x50?text=PO" },
  { id: 4, nombre: "Escaleras", imagen: "https://placehold.co/50x50?text=E" },
  { id: 5, nombre: "Barandas", imagen: "https://placehold.co/50x50?text=B" },
  { id: 6, nombre: "Rejas", imagen: "https://placehold.co/50x50?text=R" },
]

const materiales = [
  { id: 1, nombre: "Acero Inoxidable 304", unidad: "kg" },
  { id: 2, nombre: "Aluminio 6063-T5", unidad: "kg" },
  { id: 3, nombre: "Vidrio Templado", unidad: "m²" },
  { id: 4, nombre: "Hierro Forjado", unidad: "kg" },
  { id: 5, nombre: "Acero Galvanizado", unidad: "kg" },
  { id: 6, nombre: "Madera de Roble", unidad: "m³" },
]

let selectedMateriales = []
let uploadedImages = []
let editingId = null

const colorPresets = {
  "#000000": "Negro",
  "#FFFFFF": "Blanco",
  "#808080": "Gris",
  "#C0C0C0": "Acero Natural",
}

// Initialize
document.addEventListener("DOMContentLoaded", () => {
  initSidebar()
  loadCategorias()
  loadMaterialesDropdown()
  loadProductos()
  initFormHandlers()
  initColorSelector()
  initImageUpload()
  updateStats()
})

// Sidebar Toggle
function initSidebar() {
  const toggleBtn = document.getElementById("toggleSidebar")
  const sidebar = document.getElementById("sidebar")

  if (toggleBtn) {
    toggleBtn.addEventListener("click", () => {
      sidebar.classList.toggle("show")
    })
  }
}

// Load Categorias in Select
function loadCategorias() {
  const select = document.getElementById("categoria_id")
  const filterSelect = document.getElementById("filterCategoria")

  categorias.forEach((cat) => {
    const option = document.createElement("option")
    option.value = cat.id
    option.textContent = cat.nombre
    select.appendChild(option)

    const filterOption = option.cloneNode(true)
    filterSelect.appendChild(filterOption)
  })

  // Preview on select
  select.addEventListener("change", function () {
    const catId = Number.parseInt(this.value)
    const categoria = categorias.find((c) => c.id === catId)
    const preview = document.getElementById("categoriaPreview")

    if (categoria) {
      preview.style.display = "flex"
      preview.innerHTML = `
        <img src="${categoria.imagen}" alt="${categoria.nombre}">
        <div class="categoria-preview-info">
          <h6>${categoria.nombre}</h6>
          <p>Categoría seleccionada</p>
        </div>
      `
    } else {
      preview.style.display = "none"
    }
  })
}

// Load Materiales Dropdown (Multi-select)
function loadMaterialesDropdown() {
  const dropdownItems = document.getElementById("dropdownItems")
  const multiSelectInput = document.getElementById("multiSelectInput")
  const materialSearch = document.getElementById("materialSearch")
  const dropdown = document.getElementById("materialDropdown")
  const dropdownSearch = document.getElementById("dropdownSearch")

  // Render materiales
  function renderMateriales(filter = "") {
    dropdownItems.innerHTML = ""
    const filtered = materiales.filter((m) => m.nombre.toLowerCase().includes(filter.toLowerCase()))

    filtered.forEach((material) => {
      const isSelected = selectedMateriales.find((sm) => sm.id === material.id)
      const item = document.createElement("div")
      item.className = `dropdown-item-custom ${isSelected ? "selected" : ""}`
      item.innerHTML = `
        <div class="material-info">
          <span class="material-name">${material.nombre}</span>
          <span class="material-unit">Unidad: ${material.unidad}</span>
        </div>
        ${isSelected ? '<i class="bi bi-check2"></i>' : ""}
      `

      item.addEventListener("click", () => toggleMaterial(material))
      dropdownItems.appendChild(item)
    })
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
        <span class="unidad-badge">${material.unidad}</span>
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
    label.className = "badge-status-active"
  } else {
    label.textContent = "Inactivo"
    label.className = "badge-status-inactive"
  }
})

// Form Handlers
function initFormHandlers() {
  const form = document.getElementById("formProducto")
  const bootstrap = window.bootstrap // Declare bootstrap variable
  const Modal = bootstrap.Modal
  const modal = new Modal(document.getElementById("modalCrearProducto"))

  form.addEventListener("submit", (e) => {
    e.preventDefault()

    if (!form.checkValidity() || selectedMateriales.length === 0 || uploadedImages.length === 0) {
      e.stopPropagation()
      form.classList.add("was-validated")

      if (selectedMateriales.length === 0) {
        document.getElementById("materialesError").style.display = "block"
      }

      if (uploadedImages.length === 0) {
        document.getElementById("imagenesError").textContent = "Debe subir al menos una imagen."
      }

      return
    }

    const formData = {
      id: editingId || Date.now(),
      nombre: document.getElementById("nombre").value,
      descripcion: document.getElementById("descripcion").value,
      categoria_id: Number.parseInt(document.getElementById("categoria_id").value),
      categoria: categorias.find((c) => c.id === Number.parseInt(document.getElementById("categoria_id").value)),
      materiales: [...selectedMateriales],
      ancho: Number.parseFloat(document.getElementById("ancho").value),
      alto: Number.parseFloat(document.getElementById("alto").value),
      grosor: Number.parseFloat(document.getElementById("grosor").value) || null,
      color: document.getElementById("color").value,
      colorNombre: getColorName(document.getElementById("color").value),
      imagenes: [...uploadedImages],
      estado: document.getElementById("estado").checked ? "activo" : "inactivo",
      fecha: new Date().toISOString().split("T")[0],
    }

    if (editingId) {
      const index = productos.findIndex((p) => p.id === editingId)
      productos[index] = formData
    } else {
      productos.push(formData)
    }

    loadProductos()
    updateStats()
    modal.hide()
    resetForm()
  })

  // Reset form on modal close
  document.getElementById("modalCrearProducto").addEventListener("hidden.bs.modal", resetForm)
}

function getColorName(color) {
  return colorPresets[color] || "Personalizado"
}

function resetForm() {
  document.getElementById("formProducto").reset()
  document.getElementById("formProducto").classList.remove("was-validated")
  document.getElementById("categoriaPreview").style.display = "none"
  document.getElementById("colorPickerWrapper").style.display = "none"
  document.getElementById("materialesError").style.display = "none"
  document.getElementById("imagenesError").textContent = ""

  selectedMateriales = []
  uploadedImages = []
  editingId = null

  document.getElementById("selectedItems").innerHTML = ""
  document.getElementById("imagesPreviewContainer").innerHTML = ""
  document.getElementById("uploadPlaceholder").style.display = "block"
  document.getElementById("modalTitle").innerHTML = '<i class="bi bi-plus-circle"></i> Nuevo Producto'
  document.getElementById("estadoLabel").textContent = "Activo"
  document.getElementById("estadoLabel").className = "badge-status-active"

  document.querySelectorAll(".color-option").forEach((opt) => opt.classList.remove("active"))
  document.querySelector('.color-option[data-color="#000000"]').classList.add("active")
}

// Load Productos in Table
function loadProductos() {
  const tbody = document.getElementById("tableBody")
  tbody.innerHTML = ""

  productos.forEach((producto) => {
    const tr = document.createElement("tr")
    tr.innerHTML = `
      <td>
        <div class="product-thumbnails">
          ${producto.imagenes
            .map(
              (img, i) => `
            <img src="${img}" alt="${producto.nombre}" class="product-thumbnail ${i === 0 ? "main" : ""}" title="Imagen ${i + 1}">
          `,
            )
            .join("")}
        </div>
      </td>
      <td>
        <strong>${producto.nombre}</strong>
      </td>
      <td>
        <span class="badge bg-info">${producto.categoria.nombre}</span>
      </td>
      <td>
        <small class="text-muted">
          ${producto.ancho} x ${producto.alto} cm
          ${producto.grosor ? `<br>Grosor: ${producto.grosor} mm` : ""}
        </small>
      </td>
      <td>
        <span class="badge-status badge-status-${producto.estado}">
          <i class="bi bi-${producto.estado === "activo" ? "check-circle" : "pause-circle"}"></i>
          ${producto.estado === "activo" ? "Activo" : "Inactivo"}
        </span>
      </td>
      <td class="text-center">
        <div class="d-flex gap-2 justify-content-center">
          <button class="btn-action btn-view" onclick="viewProducto(${producto.id})" title="Ver">
            <i class="bi bi-eye"></i>
          </button>
          <button class="btn-action btn-edit" onclick="editProducto(${producto.id})" title="Editar">
            <i class="bi bi-pencil"></i>
          </button>
          <label class="switch-status">
            <input type="checkbox" ${producto.estado === "activo" ? "checked" : ""} onchange="toggleEstado(${producto.id})">
            <span class="switch-slider"></span>
          </label>
          <button class="btn-action btn-delete" onclick="deleteProducto(${producto.id})" title="Eliminar">
            <i class="bi bi-trash"></i>
          </button>
        </div>
      </td>
    `
    tbody.appendChild(tr)
  })
}

// View Producto
function viewProducto(id) {
  const producto = productos.find((p) => p.id === id)
  if (!producto) return

  const bootstrap = window.bootstrap // Declare bootstrap variable
  const Modal = bootstrap.Modal
  const modal = new Modal(document.getElementById("modalVerProducto"))

  document.getElementById("verImagenPrincipal").src = producto.imagenes[0]
  document.getElementById("verNombre").textContent = producto.nombre
  document.getElementById("verDescripcion").textContent = producto.descripcion
  document.getElementById("verEstado").innerHTML = `
    <span class="badge-status badge-status-${producto.estado}">
      <i class="bi bi-${producto.estado === "activo" ? "check-circle" : "pause-circle"}"></i>
      ${producto.estado === "activo" ? "Activo" : "Inactivo"}
    </span>
  `
  document.getElementById("verCategoria").innerHTML = `
    <span class="badge bg-info">${producto.categoria.nombre}</span>
  `
  document.getElementById("verMedidas").textContent =
    `${producto.ancho} x ${producto.alto} cm${producto.grosor ? ` (Grosor: ${producto.grosor} mm)` : ""}`
  document.getElementById("verColor").innerHTML = `
    <div class="color-display">
      <div class="color-box" style="background: ${producto.color};"></div>
      <span>${producto.colorNombre} (${producto.color})</span>
    </div>
  `

  const materialesHtml = producto.materiales
    .map(
      (m) => `
    <span class="material-badge">${m.nombre} (${m.unidad})</span>
  `,
    )
    .join("")
  document.getElementById("verMateriales").innerHTML = `<div class="material-badges">${materialesHtml}</div>`
  document.getElementById("verFecha").textContent = new Date(producto.fecha).toLocaleDateString()

  // Thumbnails
  const thumbnails = document.getElementById("verThumbnails")
  thumbnails.innerHTML = producto.imagenes
    .map(
      (img, i) => `
    <img src="${img}" alt="Thumbnail ${i + 1}" class="${i === 0 ? "active" : ""}" onclick="changeMainImage('${img}')">
  `,
    )
    .join("")

  document.getElementById("btnEditarDesdeVer").onclick = () => {
    modal.hide()
    editProducto(id)
  }

  modal.show()
}

function changeMainImage(src) {
  document.getElementById("verImagenPrincipal").src = src
  document.querySelectorAll("#verThumbnails img").forEach((img) => img.classList.remove("active"))
  event.target.classList.add("active")
}

// Edit Producto
function editProducto(id) {
  const producto = productos.find((p) => p.id === id)
  if (!producto) return

  editingId = id

  document.getElementById("modalTitle").innerHTML = '<i class="bi bi-pencil"></i> Editar Producto'
  document.getElementById("productoId").value = producto.id
  document.getElementById("nombre").value = producto.nombre
  document.getElementById("descripcion").value = producto.descripcion
  document.getElementById("categoria_id").value = producto.categoria_id
  document.getElementById("ancho").value = producto.ancho
  document.getElementById("alto").value = producto.alto
  document.getElementById("grosor").value = producto.grosor || ""
  document.getElementById("color").value = producto.color
  document.getElementById("estado").checked = producto.estado === "activo"

  // Trigger events
  document.getElementById("categoria_id").dispatchEvent(new Event("change"))
  document.getElementById("descripcion").dispatchEvent(new Event("input"))
  updateDimensionPreview()

  // Set color
  document.querySelectorAll(".color-option").forEach((opt) => {
    if (opt.dataset.color === producto.color) {
      opt.click()
    }
  })

  // Set materiales
  selectedMateriales = [...producto.materiales]
  document.getElementById("selectedItems").innerHTML = ""
  selectedMateriales.forEach((material) => {
    const item = document.createElement("div")
    item.className = "selected-item"
    item.innerHTML = `
      <span>${material.nombre}</span>
      <span class="unidad-badge">${material.unidad}</span>
      <button type="button" class="btn-remove">
        <i class="bi bi-x-lg"></i>
      </button>
    `
    document.getElementById("selectedItems").appendChild(item)
  })

  // Set images
  uploadedImages = [...producto.imagenes]
  document.getElementById("imagesPreviewContainer").innerHTML = ""
  uploadedImages.forEach((src, index) => {
    const item = document.createElement("div")
    item.className = "image-preview-item"
    item.innerHTML = `
      <img src="${src}" alt="Preview ${index + 1}">
      <span class="image-order-badge">${index + 1}</span>
      <button type="button" class="btn-remove-image" data-index="${index}">
        <i class="bi bi-x"></i>
      </button>
    `
    document.getElementById("imagesPreviewContainer").appendChild(item)
  })
  document.getElementById("uploadPlaceholder").style.display = "none"

  const bootstrap = window.bootstrap // Declare bootstrap variable
  const Modal = bootstrap.Modal
  const modal = new Modal(document.getElementById("modalCrearProducto"))
  modal.show()
}

// Toggle Estado
function toggleEstado(id) {
  const producto = productos.find((p) => p.id === id)
  if (producto) {
    producto.estado = producto.estado === "activo" ? "inactivo" : "activo"
    loadProductos()
    updateStats()
  }
}

// Delete Producto
function deleteProducto(id) {
  const producto = productos.find((p) => p.id === id)
  if (!producto) return

  document.getElementById("eliminarNombre").textContent = producto.nombre
  editingId = id

  const bootstrap = window.bootstrap // Declare bootstrap variable
  const Modal = bootstrap.Modal
  const modal = new Modal(document.getElementById("modalEliminar"))
  modal.show()
}

document.getElementById("btnConfirmarEliminar")?.addEventListener("click", () => {
  productos = productos.filter((p) => p.id !== editingId)
  loadProductos()
  updateStats()
  const bootstrap = window.bootstrap // Declare bootstrap variable
  const Modal = bootstrap.Modal
  const modalInstance = Modal.getInstance(document.getElementById("modalEliminar"))
  modalInstance.hide()
  editingId = null
})

// Update Stats
function updateStats() {
  document.getElementById("totalProductos").textContent = productos.length
  document.getElementById("productosActivos").textContent = productos.filter((p) => p.estado === "activo").length
  document.getElementById("productosInactivos").textContent = productos.filter((p) => p.estado === "inactivo").length
}

// Search and Filters
document.getElementById("searchInput")?.addEventListener("input", filterProductos)
document.getElementById("filterCategoria")?.addEventListener("change", filterProductos)
document.getElementById("filterEstado")?.addEventListener("change", filterProductos)

function filterProductos() {
  const search = document.getElementById("searchInput").value.toLowerCase()
  const categoria = document.getElementById("filterCategoria").value
  const estado = document.getElementById("filterEstado").value

  const filtered = productos.filter((p) => {
    const matchSearch = p.nombre.toLowerCase().includes(search)
    const matchCategoria = !categoria || p.categoria_id === Number.parseInt(categoria)
    const matchEstado = !estado || p.estado === estado
    return matchSearch && matchCategoria && matchEstado
  })

  // Re-render with filtered data (simplified)
  console.log("[v0] Filtered productos:", filtered.length)
}
