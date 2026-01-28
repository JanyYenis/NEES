// Mock data para demostración
const mockCotizaciones = [
  {
    id: 1,
    numero: "COT-2024-001",
    cliente: "Juan Pérez García",
    cliente_email: "juan.perez@email.com",
    cliente_telefono: "+52 555-1234",
    direccion: "Av. Principal #123, Col. Centro, Ciudad",
    producto: "Puerta de Acero Industrial 2.10m x 90cm",
    producto_img: "https://images.unsplash.com/photo-1540518614846-7eded433c457?w=200",
    total: 8500.0,
    estado: "aprobada",
    materiales: [
      { nombre: "Acero A36", cantidad: 50, unidad: "kg", precio: 35.0, subtotal: 1750.0 },
      { nombre: "Pintura Industrial", cantidad: 2, unidad: "litros", precio: 250.0, subtotal: 500.0 },
    ],
    mano_obra: { descripcion: "Fabricación e instalación", costo: 3000.0 },
    subtotal: 5250.0,
    iva: 840.0,
  },
  {
    id: 2,
    numero: "COT-2024-002",
    cliente: "María González López",
    cliente_email: "maria.gonzalez@email.com",
    cliente_telefono: "+52 555-5678",
    direccion: "Calle Secundaria #456, Col. Norte, Ciudad",
    producto: "Escalera Caracol Acero Inoxidable 3m altura",
    producto_img: "https://images.unsplash.com/photo-1600210491892-03d54c0aaf87?w=200",
    total: 15600.0,
    estado: "aprobada",
    materiales: [
      { nombre: "Acero Inoxidable 304", cantidad: 80, unidad: "kg", precio: 85.0, subtotal: 6800.0 },
      { nombre: "Tornillos Inoxidables", cantidad: 100, unidad: "piezas", precio: 5.0, subtotal: 500.0 },
    ],
    mano_obra: { descripcion: "Fabricación e instalación personalizada", costo: 5000.0 },
    subtotal: 12300.0,
    iva: 1968.0,
  },
]

const mockPedidos = [
  {
    id: 1,
    numero: "PED-2024-001",
    cotizacion_id: 1,
    fecha_pedido: "2024-01-15",
    fecha_entrega: "2024-02-15",
    estado: "produccion",
    observaciones: "Cliente requiere acabado mate",
  },
  {
    id: 2,
    numero: "PED-2024-002",
    cotizacion_id: 2,
    fecha_pedido: "2024-01-20",
    fecha_entrega: "2024-02-28",
    estado: "pendiente",
    observaciones: "",
  },
]

// DOM Elements
const tableBody = document.getElementById("tableBody")
const searchInput = document.getElementById("searchInput")
const filterEstado = document.getElementById("filterEstado")
const filterFecha = document.getElementById("filterFecha")
const sortBy = document.getElementById("sortBy")
const formPedido = document.getElementById("formPedido")
const cotizacionSelect = document.getElementById("cotizacion_id")
const estadoSelect = document.getElementById("estado")
const fechaEntregaInput = document.getElementById("fecha_entrega")
const observacionesTextarea = document.getElementById("observaciones")

// Bootstrap instance
const bootstrap = window.bootstrap

// Initialize
document.addEventListener("DOMContentLoaded", () => {
  // Sidebar toggle
  const toggleBtn = document.getElementById("toggleSidebar")
  const sidebar = document.getElementById("sidebar")

  if (toggleBtn) {
    toggleBtn.addEventListener("click", () => {
      sidebar.classList.toggle("show")
    })
  }

  // Load cotizaciones
  loadCotizaciones()

  // Load pedidos
  loadPedidos()

  // Form submission
  formPedido.addEventListener("submit", handleSubmit)

  // Cotización selection change
  cotizacionSelect.addEventListener("change", handleCotizacionChange)

  // Estado selection change
  estadoSelect.addEventListener("change", updateEstadoPreview)

  // Set min date for fecha_entrega (tomorrow)
  const tomorrow = new Date()
  tomorrow.setDate(tomorrow.getDate() + 1)
  fechaEntregaInput.min = tomorrow.toISOString().split("T")[0]

  // Observaciones character counter
  observacionesTextarea.addEventListener("input", function () {
    const count = this.value.length
    document.getElementById("obsCharCount").textContent = count
    if (count > 500) {
      this.value = this.value.substring(0, 500)
      document.getElementById("obsCharCount").textContent = 500
    }
  })

  // Filters
  searchInput.addEventListener("input", applyFilters)
  filterEstado.addEventListener("change", applyFilters)
  filterFecha.addEventListener("change", applyFilters)
  sortBy.addEventListener("change", applyFilters)

  // Modal events
  document.getElementById("modalCrearPedido").addEventListener("hidden.bs.modal", resetForm)
})

// Load cotizaciones into select
function loadCotizaciones() {
  cotizacionSelect.innerHTML = '<option value="">-- Seleccione una cotización --</option>'

  mockCotizaciones.forEach((cotizacion) => {
    const option = document.createElement("option")
    option.value = cotizacion.id
    option.textContent = `${cotizacion.numero} - ${cotizacion.cliente} - $${cotizacion.total.toFixed(2)}`
    option.dataset.cotizacion = JSON.stringify(cotizacion)
    cotizacionSelect.appendChild(option)
  })
}

// Handle cotización change
function handleCotizacionChange() {
  const selectedOption = cotizacionSelect.options[cotizacionSelect.selectedIndex]
  const preview = document.getElementById("cotizacionPreview")

  if (selectedOption.value) {
    const cotizacion = JSON.parse(selectedOption.dataset.cotizacion)

    document.getElementById("previewCliente").textContent = cotizacion.cliente
    document.getElementById("previewDireccion").textContent = cotizacion.direccion
    document.getElementById("previewProducto").textContent = cotizacion.producto
    document.getElementById("previewTotal").textContent = `$${cotizacion.total.toFixed(2)}`

    const estadoBadge = getEstadoCotizacionBadge(cotizacion.estado)
    document.getElementById("previewEstadoCotizacion").innerHTML = estadoBadge

    preview.style.display = "block"
  } else {
    preview.style.display = "none"
  }
}

// Get estado cotización badge
function getEstadoCotizacionBadge(estado) {
  const badges = {
    borrador:
      '<span class="badge-status" style="background: rgba(156, 163, 175, 0.15); color: #9ca3af; border: 1px solid rgba(156, 163, 175, 0.3);"><i class="bi bi-file-earmark"></i> Borrador</span>',
    enviada:
      '<span class="badge-status" style="background: rgba(6, 182, 212, 0.15); color: #06b6d4; border: 1px solid rgba(6, 182, 212, 0.3);"><i class="bi bi-send"></i> Enviada</span>',
    aprobada: '<span class="badge-status-active"><i class="bi bi-check-circle"></i> Aprobada</span>',
    rechazada:
      '<span class="badge-status" style="background: rgba(239, 68, 68, 0.15); color: #ef4444; border: 1px solid rgba(239, 68, 68, 0.3);"><i class="bi bi-x-circle"></i> Rechazada</span>',
  }
  return badges[estado] || badges.borrador
}

// Update estado preview
function updateEstadoPreview() {
  const estado = estadoSelect.value
  const preview = document.getElementById("estadoPreview")
  preview.innerHTML = getEstadoBadge(estado)
}

// Get estado badge
function getEstadoBadge(estado) {
  const badges = {
    pendiente: '<span class="badge-pedido badge-pendiente"><i class="bi bi-clock-history"></i> Pendiente</span>',
    produccion: '<span class="badge-pedido badge-produccion"><i class="bi bi-gear"></i> En producción</span>',
    listo: '<span class="badge-pedido badge-listo"><i class="bi bi-check-circle"></i> Listo para entrega</span>',
    entregado: '<span class="badge-pedido badge-entregado"><i class="bi bi-box-seam"></i> Entregado</span>',
    cancelado: '<span class="badge-pedido badge-cancelado"><i class="bi bi-x-circle"></i> Cancelado</span>',
  }
  return badges[estado] || badges.pendiente
}

// Load pedidos
function loadPedidos() {
  tableBody.innerHTML = ""

  mockPedidos.forEach((pedido) => {
    const cotizacion = mockCotizaciones.find((c) => c.id === pedido.cotizacion_id)
    if (!cotizacion) return

    const row = document.createElement("tr")

    // Calculate tiempo restante
    const tiempoInfo = calcularTiempoRestante(pedido.fecha_entrega)

    row.innerHTML = `
      <td><strong class="text-primary">${pedido.numero}</strong></td>
      <td>${cotizacion.numero}</td>
      <td>
        <div>${cotizacion.cliente}</div>
        <small class="text-muted">${cotizacion.cliente_email}</small>
      </td>
      <td>
        <div class="d-flex align-items-center gap-2">
          <img src="${cotizacion.producto_img}" class="table-img" alt="${cotizacion.producto}" style="width: 40px; height: 40px;">
          <div>
            <div style="font-size: 0.875rem;">${cotizacion.producto}</div>
          </div>
        </div>
      </td>
      <td>
        <div>${formatDate(pedido.fecha_entrega)}</div>
        <small class="${tiempoInfo.class}">${tiempoInfo.text}</small>
      </td>
      <td>${getEstadoBadge(pedido.estado)}</td>
      <td><strong class="text-primary">$${cotizacion.total.toFixed(2)}</strong></td>
      <td class="text-center">
        <div class="d-flex gap-1 justify-content-center">
          <button class="btn-action btn-view" onclick="verPedido(${pedido.id})" title="Ver detalles">
            <i class="bi bi-eye"></i>
          </button>
          <button class="btn-action btn-edit" onclick="editarPedido(${pedido.id})" title="Editar">
            <i class="bi bi-pencil"></i>
          </button>
          <button class="btn-action" style="background: var(--info); border-color: var(--info); color: white;" onclick="cambiarEstado(${pedido.id})" title="Cambiar estado">
            <i class="bi bi-arrow-left-right"></i>
          </button>
          <button class="btn-action btn-delete" onclick="eliminarPedido(${pedido.id})" title="Eliminar">
            <i class="bi bi-trash"></i>
          </button>
        </div>
      </td>
    `

    tableBody.appendChild(row)
  })
}

// Calculate tiempo restante
function calcularTiempoRestante(fechaEntrega) {
  const hoy = new Date()
  const entrega = new Date(fechaEntrega)
  const diff = Math.ceil((entrega - hoy) / (1000 * 60 * 60 * 24))

  if (diff < 0) {
    return { text: `Vencido (${Math.abs(diff)} días)`, class: "text-danger" }
  } else if (diff <= 3) {
    return { text: `${diff} días`, class: "text-warning" }
  } else {
    return { text: `${diff} días`, class: "text-success" }
  }
}

// Format date
function formatDate(dateString) {
  const date = new Date(dateString)
  const options = { year: "numeric", month: "long", day: "numeric" }
  return date.toLocaleDateString("es-MX", options)
}

// Handle form submit
function handleSubmit(e) {
  e.preventDefault()

  if (!formPedido.checkValidity()) {
    e.stopPropagation()
    formPedido.classList.add("was-validated")
    return
  }

  // Validate fecha_entrega
  const fechaEntrega = new Date(fechaEntregaInput.value)
  const hoy = new Date()
  hoy.setHours(0, 0, 0, 0)

  if (fechaEntrega <= hoy) {
    alert("La fecha de entrega debe ser posterior a hoy.")
    return
  }

  const formData = new FormData(formPedido)
  console.log("[v0] Pedido data:", Object.fromEntries(formData))

  // Simulate save
  alert("Pedido guardado exitosamente")

  // Close modal
  const modal = bootstrap.Modal.getInstance(document.getElementById("modalCrearPedido"))
  modal.hide()

  // Reload table
  loadPedidos()
}

// Reset form
function resetForm() {
  formPedido.reset()
  formPedido.classList.remove("was-validated")
  document.getElementById("pedidoId").value = ""
  document.getElementById("cotizacionPreview").style.display = "none"
  document.getElementById("obsCharCount").textContent = "0"
  document.getElementById("modalTitle").innerHTML = '<i class="bi bi-plus-circle"></i> Nuevo Pedido'
  updateEstadoPreview()
}

// Ver pedido
function verPedido(id) {
  const pedido = mockPedidos.find((p) => p.id === id)
  const cotizacion = mockCotizaciones.find((c) => c.id === pedido.cotizacion_id)

  if (!pedido || !cotizacion) return

  document.getElementById("verNumeroPedido").textContent = pedido.numero
  document.getElementById("verCotizacionRef").textContent = cotizacion.numero
  document.getElementById("verEstadoPedido").innerHTML = getEstadoBadge(pedido.estado)

  const tiempoInfo = calcularTiempoRestante(pedido.fecha_entrega)
  document.getElementById("verTiempoRestante").innerHTML = `
    <div class="tiempo-indicator ${tiempoInfo.class === "text-danger" ? "tiempo-vencido" : tiempoInfo.class === "text-warning" ? "tiempo-proximo" : "tiempo-normal"}">
      <i class="bi bi-clock"></i> ${tiempoInfo.text}
    </div>
  `

  document.getElementById("verCliente").textContent = cotizacion.cliente
  document.getElementById("verClienteEmail").textContent = cotizacion.cliente_email
  document.getElementById("verClienteTelefono").textContent = cotizacion.cliente_telefono
  document.getElementById("verDireccion").textContent = cotizacion.direccion

  document.getElementById("verFechaPedido").textContent = formatDate(pedido.fecha_pedido)
  document.getElementById("verFechaEntrega").textContent = formatDate(pedido.fecha_entrega)
  document.getElementById("verDiasRestantes").textContent = tiempoInfo.text
  document.getElementById("verEstado").innerHTML = getEstadoBadge(pedido.estado)

  document.getElementById("verProductoInfo").innerHTML = `
    <img src="${cotizacion.producto_img}" alt="${cotizacion.producto}">
    <div class="producto-info">
      <h6>${cotizacion.producto}</h6>
      <p>Código: PROD-${cotizacion.id}</p>
    </div>
  `

  const materialesHTML = cotizacion.materiales
    .map(
      (m) => `
    <tr>
      <td>${m.nombre}</td>
      <td>${m.cantidad}</td>
      <td>${m.unidad}</td>
      <td>$${m.precio.toFixed(2)}</td>
      <td class="text-end">$${m.subtotal.toFixed(2)}</td>
    </tr>
  `,
    )
    .join("")
  document.getElementById("verMateriales").innerHTML = materialesHTML

  document.getElementById("verManoObraDesc").textContent = cotizacion.mano_obra.descripcion
  document.getElementById("verManoObraCosto").textContent = `$${cotizacion.mano_obra.costo.toFixed(2)}`

  document.getElementById("verSubtotal").textContent = `$${cotizacion.subtotal.toFixed(2)}`
  document.getElementById("verIva").textContent = `$${cotizacion.iva.toFixed(2)}`
  document.getElementById("verTotalFinal").textContent = `$${cotizacion.total.toFixed(2)}`

  if (pedido.observaciones) {
    document.getElementById("verObservacionesCard").style.display = "block"
    document.getElementById("verObservaciones").textContent = pedido.observaciones
  } else {
    document.getElementById("verObservacionesCard").style.display = "none"
  }

  document.getElementById("btnEditarDesdeVer").onclick = () => {
    const verModal = bootstrap.Modal.getInstance(document.getElementById("modalVerPedido"))
    verModal.hide()
    editarPedido(id)
  }

  const modal = new bootstrap.Modal(document.getElementById("modalVerPedido"))
  modal.show()
}

// Editar pedido
function editarPedido(id) {
  const pedido = mockPedidos.find((p) => p.id === id)
  if (!pedido) return

  document.getElementById("pedidoId").value = pedido.id
  document.getElementById("cotizacion_id").value = pedido.cotizacion_id
  document.getElementById("fecha_entrega").value = pedido.fecha_entrega
  document.getElementById("estado").value = pedido.estado
  document.getElementById("observaciones").value = pedido.observaciones || ""

  handleCotizacionChange()
  updateEstadoPreview()

  document.getElementById("obsCharCount").textContent = (pedido.observaciones || "").length
  document.getElementById("modalTitle").innerHTML = '<i class="bi bi-pencil"></i> Editar Pedido'

  const modal = new bootstrap.Modal(document.getElementById("modalCrearPedido"))
  modal.show()
}

// Cambiar estado
function cambiarEstado(id) {
  const pedido = mockPedidos.find((p) => p.id === id)
  if (!pedido) return

  document.getElementById("cambiarEstadoPedido").textContent = pedido.numero
  document.getElementById("cambiarEstadoActual").innerHTML = getEstadoBadge(pedido.estado)
  document.getElementById("nuevoEstado").value = pedido.estado

  const preview = document.getElementById("previewNuevoEstado")
  preview.innerHTML = getEstadoBadge(pedido.estado)

  document.getElementById("nuevoEstado").addEventListener("change", function () {
    preview.innerHTML = getEstadoBadge(this.value)
  })

  document.getElementById("btnConfirmarCambioEstado").onclick = () => {
    const nuevoEstado = document.getElementById("nuevoEstado").value
    pedido.estado = nuevoEstado
    loadPedidos()

    const modal = bootstrap.Modal.getInstance(document.getElementById("modalCambiarEstado"))
    modal.hide()

    alert(`Estado cambiado a: ${nuevoEstado}`)
  }

  const modal = new bootstrap.Modal(document.getElementById("modalCambiarEstado"))
  modal.show()
}

// Eliminar pedido
function eliminarPedido(id) {
  const pedido = mockPedidos.find((p) => p.id === id)
  if (!pedido) return

  document.getElementById("eliminarPedido").textContent = pedido.numero

  document.getElementById("btnConfirmarEliminar").onclick = () => {
    const index = mockPedidos.findIndex((p) => p.id === id)
    if (index > -1) {
      mockPedidos.splice(index, 1)
      loadPedidos()
    }

    const modal = bootstrap.Modal.getInstance(document.getElementById("modalEliminar"))
    modal.hide()

    alert("Pedido eliminado exitosamente")
  }

  const modal = new bootstrap.Modal(document.getElementById("modalEliminar"))
  modal.show()
}

// Apply filters
function applyFilters() {
  // Filter logic would go here
  console.log("[v0] Applying filters...")
}
