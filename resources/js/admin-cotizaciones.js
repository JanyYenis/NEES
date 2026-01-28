// Datos de ejemplo
let cotizaciones = [
  {
    id: 1,
    numero: "COT-2024-001",
    cliente: { id: 1, nombre: "Juan Pérez", email: "juan@email.com", telefono: "555-0101" },
    producto: { id: 1, nombre: "Puerta Principal Modelo A", precio: 1200 },
    direccion: "Calle 123 #45-67, Bogotá",
    materiales: [
      { id: 1, nombre: "Acero Inoxidable", unidad: "kg", cantidad: 50, valor_unitario: 15, subtotal: 750 },
      { id: 2, nombre: "Pintura Anticorrosiva", unidad: "litro", cantidad: 5, valor_unitario: 25, subtotal: 125 },
    ],
    mano_obra: 300,
    descripcion_mano_obra: "Instalación completa",
    subtotal: 875,
    impuestos: 166.25,
    total: 1341.25,
    estado: "enviada",
    fecha: "2024-01-15",
    notas: "Cliente prefiere instalación en la mañana",
  },
  {
    id: 2,
    numero: "COT-2024-002",
    cliente: { id: 2, nombre: "María García", email: "maria@email.com", telefono: "555-0102" },
    producto: null,
    direccion: "Carrera 50 #20-30, Medellín",
    materiales: [{ id: 3, nombre: "Hierro Forjado", unidad: "metro", cantidad: 20, valor_unitario: 45, subtotal: 900 }],
    mano_obra: 500,
    descripcion_mano_obra: "Diseño personalizado",
    subtotal: 900,
    impuestos: 171,
    total: 1571,
    estado: "aprobada",
    fecha: "2024-01-18",
    notas: "",
  },
]

const clientes = [
  {
    id: 1,
    nombre: "Juan Pérez",
    email: "juan@email.com",
    telefono: "555-0101",
    direcciones: [
      { id: 1, direccion: "Calle 123 #45-67", ciudad: "Bogotá", codigo_postal: "110111" },
      { id: 2, direccion: "Carrera 7 #32-16", ciudad: "Bogotá", codigo_postal: "110231" },
    ],
  },
  {
    id: 2,
    nombre: "María García",
    email: "maria@email.com",
    telefono: "555-0102",
    direcciones: [{ id: 3, direccion: "Carrera 50 #20-30", ciudad: "Medellín", codigo_postal: "050012" }],
  },
  {
    id: 3,
    nombre: "Carlos López",
    email: "carlos@email.com",
    telefono: "555-0103",
    direcciones: [{ id: 4, direccion: "Calle 85 #12-34", ciudad: "Cali", codigo_postal: "760001" }],
  },
]

const productos = [
  { id: 1, nombre: "Puerta Principal Modelo A", precio: 1200, medidas: "2.10m x 0.90m", categoria: "Puertas" },
  { id: 2, nombre: "Ventana Corrediza Modelo B", precio: 450, medidas: "1.50m x 1.20m", categoria: "Ventanas" },
  { id: 3, nombre: "Reja de Seguridad Modelo C", precio: 800, medidas: "3.00m x 2.50m", categoria: "Rejas" },
  { id: 4, nombre: "Escalera Recta Modelo D", precio: 2500, medidas: "3.50m altura", categoria: "Escaleras" },
]

const materiales = [
  { id: 1, nombre: "Acero Inoxidable", unidad: "kg" },
  { id: 2, nombre: "Pintura Anticorrosiva", unidad: "litro" },
  { id: 3, nombre: "Hierro Forjado", unidad: "metro" },
  { id: 4, nombre: "Aluminio", unidad: "kg" },
  { id: 5, nombre: "Vidrio Templado", unidad: "metro cuadrado" },
  { id: 6, nombre: "Tornillería", unidad: "unidad" },
  { id: 7, nombre: "Soldadura", unidad: "kg" },
  { id: 8, nombre: "Cemento", unidad: "bulto" },
]

let materialesAgregados = []
let cotizacionActual = null
let contadorMateriales = 0

// Declaración de variables necesarias
const bootstrap = window.bootstrap
const html2canvas = window.html2canvas
const jspdf = window.jspdf

// Inicialización
document.addEventListener("DOMContentLoaded", () => {
  cargarClientes()
  cargarProductos()
  cargarMateriales()
  cargarTablaCotizaciones()

  // Toggle sidebar
  document.getElementById("toggleSidebar")?.addEventListener("click", () => {
    document.getElementById("sidebar").classList.toggle("show")
  })

  // Formulario cotización
  document.getElementById("formCotizacion")?.addEventListener("submit", guardarCotizacion)

  // Cliente change
  document.getElementById("cliente_id")?.addEventListener("change", onClienteChange)

  // Producto change
  document.getElementById("producto_id")?.addEventListener("change", onProductoChange)

  // Botón agregar dirección
  document.getElementById("btnAgregarDireccion")?.addEventListener("click", () => {
    const modalAgregar = new bootstrap.Modal(document.getElementById("modalAgregarDireccion"))
    modalAgregar.show()
  })

  // Formulario agregar dirección
  document.getElementById("formAgregarDireccion")?.addEventListener("submit", guardarNuevaDireccion)

  // Filtros
  document.getElementById("searchInput")?.addEventListener("input", filtrarCotizaciones)
  document.getElementById("filterCliente")?.addEventListener("change", filtrarCotizaciones)
  document.getElementById("filterEstado")?.addEventListener("change", filtrarCotizaciones)
  document.getElementById("sortBy")?.addEventListener("change", filtrarCotizaciones)
})

// Cargar clientes en select
function cargarClientes() {
  const selectCliente = document.getElementById("cliente_id")
  const filterCliente = document.getElementById("filterCliente")

  if (selectCliente) {
    selectCliente.innerHTML = '<option value="">Seleccione un cliente...</option>'
    clientes.forEach((cliente) => {
      selectCliente.innerHTML += `<option value="${cliente.id}" data-email="${cliente.email}" data-telefono="${cliente.telefono}">${cliente.nombre}</option>`
    })
  }

  if (filterCliente) {
    filterCliente.innerHTML = '<option value="">Todos los clientes</option>'
    clientes.forEach((cliente) => {
      filterCliente.innerHTML += `<option value="${cliente.id}">${cliente.nombre}</option>`
    })
  }
}

// Cargar productos en select
function cargarProductos() {
  const selectProducto = document.getElementById("producto_id")
  if (selectProducto) {
    selectProducto.innerHTML = '<option value="">Cotización personalizada sin producto</option>'
    productos.forEach((producto) => {
      selectProducto.innerHTML += `<option value="${producto.id}" data-precio="${producto.precio}" data-medidas="${producto.medidas}">${producto.nombre} - ${producto.categoria}</option>`
    })
  }
}

// Cargar materiales en select
function cargarMateriales() {
  const selectMaterial = document.getElementById("selectMaterial")
  if (selectMaterial) {
    selectMaterial.innerHTML = '<option value="">Seleccione un material...</option>'
    materiales.forEach((material) => {
      selectMaterial.innerHTML += `<option value="${material.id}" data-unidad="${material.unidad}">${material.nombre} (${material.unidad})</option>`
    })
  }
}

// Cliente change
function onClienteChange() {
  const clienteId = Number.parseInt(document.getElementById("cliente_id").value)
  const selectDireccion = document.getElementById("direccion_id")
  const btnAgregarDireccion = document.getElementById("btnAgregarDireccion")
  const clienteInfo = document.getElementById("clienteInfo")

  if (clienteId) {
    const cliente = clientes.find((c) => c.id === clienteId)

    // Mostrar info del cliente
    if (cliente && clienteInfo) {
      clienteInfo.innerHTML = `<i class="bi bi-envelope"></i> ${cliente.email} | <i class="bi bi-telephone"></i> ${cliente.telefono}`
    }

    // Cargar direcciones
    if (cliente && selectDireccion) {
      selectDireccion.disabled = false
      selectDireccion.innerHTML = '<option value="">Seleccione una dirección...</option>'

      cliente.direcciones.forEach((dir) => {
        selectDireccion.innerHTML += `<option value="${dir.id}">${dir.direccion}, ${dir.ciudad}</option>`
      })

      if (cliente.direcciones.length < 4) {
        btnAgregarDireccion.disabled = false
      }
    }

    // Guardar cliente id para agregar dirección
    document.getElementById("direccion_cliente_id").value = clienteId
  } else {
    selectDireccion.disabled = true
    selectDireccion.innerHTML = '<option value="">Seleccione primero un cliente...</option>'
    btnAgregarDireccion.disabled = true
    clienteInfo.innerHTML = ""
  }
}

// Producto change
function onProductoChange() {
  const productoId = Number.parseInt(document.getElementById("producto_id").value)
  const productoPreview = document.getElementById("productoPreview")
  const productoPreviewContent = document.getElementById("productoPreviewContent")

  if (productoId) {
    const producto = productos.find((p) => p.id === productoId)

    if (producto && productoPreview && productoPreviewContent) {
      productoPreview.style.display = "block"
      productoPreviewContent.innerHTML = `
                <div class="preview-item">
                    <span>Nombre:</span>
                    <strong>${producto.nombre}</strong>
                </div>
                <div class="preview-item">
                    <span>Categoría:</span>
                    <strong>${producto.categoria}</strong>
                </div>
                <div class="preview-item">
                    <span>Medidas:</span>
                    <strong>${producto.medidas}</strong>
                </div>
                <div class="preview-item">
                    <span>Precio base:</span>
                    <strong>$${producto.precio.toFixed(2)}</strong>
                </div>
            `
    }
  } else {
    if (productoPreview) {
      productoPreview.style.display = "none"
    }
  }
}

// Agregar material
function agregarMaterial() {
  const selectMaterial = document.getElementById("selectMaterial")
  const materialId = Number.parseInt(selectMaterial.value)

  if (!materialId) {
    alert("Por favor seleccione un material")
    return
  }

  const material = materiales.find((m) => m.id === materialId)
  const materialYaAgregado = materialesAgregados.find((m) => m.id === materialId)

  if (materialYaAgregado) {
    alert("Este material ya ha sido agregado")
    return
  }

  contadorMateriales++
  const materialRow = {
    tempId: contadorMateriales,
    id: materialId,
    nombre: material.nombre,
    unidad: material.unidad,
    cantidad: 1,
    valor_unitario: 0,
    subtotal: 0,
  }

  materialesAgregados.push(materialRow)
  actualizarTablaMateriales()
  selectMaterial.value = ""
}

// Actualizar tabla de materiales
function actualizarTablaMateriales() {
  const tbody = document.getElementById("materialesBody")

  if (materialesAgregados.length === 0) {
    tbody.innerHTML = `
            <tr class="empty-state">
                <td colspan="6" class="text-center text-muted">
                    <i class="bi bi-inbox"></i><br>
                    No hay materiales agregados
                </td>
            </tr>
        `
    return
  }

  tbody.innerHTML = ""
  materialesAgregados.forEach((material) => {
    const row = document.createElement("tr")
    row.className = "material-row"
    row.innerHTML = `
            <td>${material.nombre}</td>
            <td>${material.unidad}</td>
            <td>
                <input type="number" class="form-control form-control-sm" value="${material.cantidad}" min="1" step="0.01" 
                    onchange="actualizarMaterialCantidad(${material.tempId}, this.value)">
            </td>
            <td>
                <div class="input-group input-group-sm">
                    <span class="input-group-text">$</span>
                    <input type="number" class="form-control" value="${material.valor_unitario}" min="0" step="0.01"
                        onchange="actualizarMaterialValor(${material.tempId}, this.value)">
                </div>
            </td>
            <td><strong>$${material.subtotal.toFixed(2)}</strong></td>
            <td>
                <button type="button" class="btn-remove-material" onclick="eliminarMaterial(${material.tempId})">
                    <i class="bi bi-trash"></i>
                </button>
            </td>
        `
    tbody.appendChild(row)
  })

  calcularTotales()
}

// Actualizar cantidad de material
function actualizarMaterialCantidad(tempId, cantidad) {
  const material = materialesAgregados.find((m) => m.tempId === tempId)
  if (material) {
    material.cantidad = Number.parseFloat(cantidad) || 0
    material.subtotal = material.cantidad * material.valor_unitario
    actualizarTablaMateriales()
  }
}

// Actualizar valor de material
function actualizarMaterialValor(tempId, valor) {
  const material = materialesAgregados.find((m) => m.tempId === tempId)
  if (material) {
    material.valor_unitario = Number.parseFloat(valor) || 0
    material.subtotal = material.cantidad * material.valor_unitario
    actualizarTablaMateriales()
  }
}

// Eliminar material
function eliminarMaterial(tempId) {
  materialesAgregados = materialesAgregados.filter((m) => m.tempId !== tempId)
  actualizarTablaMateriales()
}

// Calcular totales
function calcularTotales() {
  const subtotalMateriales = materialesAgregados.reduce((sum, m) => sum + m.subtotal, 0)
  const manoObra = Number.parseFloat(document.getElementById("mano_obra")?.value) || 0
  const subtotal = subtotalMateriales + manoObra
  const impuestos = subtotal * 0.19 // IVA 19%
  const total = subtotal + impuestos

  // Actualizar UI
  document.getElementById("subtotalMateriales").textContent = `$${subtotalMateriales.toFixed(2)}`
  document.getElementById("totalManoObra").textContent = `$${manoObra.toFixed(2)}`
  document.getElementById("totalImpuestos").textContent = `$${impuestos.toFixed(2)}`
  document.getElementById("totalGeneral").textContent = `$${total.toFixed(2)}`
  document.getElementById("total").value = total.toFixed(2)
}

// Guardar nueva dirección
function guardarNuevaDireccion(e) {
  e.preventDefault()

  const clienteId = Number.parseInt(document.getElementById("direccion_cliente_id").value)
  const direccion = document.getElementById("nueva_direccion").value
  const ciudad = document.getElementById("nueva_ciudad").value
  const codigoPostal = document.getElementById("nueva_codigo_postal").value

  const cliente = clientes.find((c) => c.id === clienteId)
  if (cliente && cliente.direcciones.length < 4) {
    const nuevaDir = {
      id: Date.now(),
      direccion: direccion,
      ciudad: ciudad,
      codigo_postal: codigoPostal,
    }

    cliente.direcciones.push(nuevaDir)

    // Actualizar select de direcciones
    onClienteChange()

    // Cerrar modal
    const modal = bootstrap.Modal.getInstance(document.getElementById("modalAgregarDireccion"))
    modal.hide()

    // Reset form
    document.getElementById("formAgregarDireccion").reset()

    alert("Dirección agregada exitosamente")
  }
}

// Abrir modal crear
function abrirModalCrear() {
  cotizacionActual = null
  materialesAgregados = []
  contadorMateriales = 0

  document.getElementById("formCotizacion").reset()
  document.getElementById("modalTitle").innerHTML = '<i class="bi bi-plus-circle"></i> Nueva Cotización'
  document.getElementById("cotizacionId").value = ""
  document.getElementById("cliente_id").disabled = false
  document.getElementById("direccion_id").disabled = true
  document.getElementById("btnAgregarDireccion").disabled = true
  document.getElementById("productoPreview").style.display = "none"
  document.getElementById("clienteInfo").innerHTML = ""

  actualizarTablaMateriales()
  calcularTotales()

  const modal = new bootstrap.Modal(document.getElementById("modalCrearCotizacion"))
  modal.show()
}

// Guardar cotización
function guardarCotizacion(e) {
  e.preventDefault()

  const clienteId = Number.parseInt(document.getElementById("cliente_id").value)
  const direccionId = Number.parseInt(document.getElementById("direccion_id").value)
  const productoId = Number.parseInt(document.getElementById("producto_id").value) || null
  const estado = document.getElementById("estado").value
  const notas = document.getElementById("notas").value
  const manoObra = Number.parseFloat(document.getElementById("mano_obra").value) || 0
  const descripcionManoObra = document.getElementById("descripcion_mano_obra").value
  const total = Number.parseFloat(document.getElementById("total").value)

  if (!clienteId || !direccionId) {
    alert("Por favor complete los campos obligatorios")
    return
  }

  if (materialesAgregados.length === 0) {
    alert("Debe agregar al menos un material")
    return
  }

  if (total <= 0) {
    alert("El total debe ser mayor a cero")
    return
  }

  const cliente = clientes.find((c) => c.id === clienteId)
  const direccion = cliente.direcciones.find((d) => d.id === direccionId)
  const producto = productoId ? productos.find((p) => p.id === productoId) : null

  const cotizacion = {
    id: cotizacionActual ? cotizacionActual.id : Date.now(),
    numero: cotizacionActual ? cotizacionActual.numero : `COT-2024-${String(cotizaciones.length + 1).padStart(3, "0")}`,
    cliente: cliente,
    producto: producto,
    direccion: `${direccion.direccion}, ${direccion.ciudad}`,
    materiales: JSON.parse(JSON.stringify(materialesAgregados)),
    mano_obra: manoObra,
    descripcion_mano_obra: descripcionManoObra,
    subtotal: materialesAgregados.reduce((sum, m) => sum + m.subtotal, 0),
    impuestos: (materialesAgregados.reduce((sum, m) => sum + m.subtotal, 0) + manoObra) * 0.19,
    total: total,
    estado: estado,
    fecha: new Date().toISOString().split("T")[0],
    notas: notas,
  }

  if (cotizacionActual) {
    const index = cotizaciones.findIndex((c) => c.id === cotizacionActual.id)
    cotizaciones[index] = cotizacion
  } else {
    cotizaciones.push(cotizacion)
  }

  cargarTablaCotizaciones()

  const modal = bootstrap.Modal.getInstance(document.getElementById("modalCrearCotizacion"))
  modal.hide()

  alert("Cotización guardada exitosamente")
}

// Cargar tabla de cotizaciones
function cargarTablaCotizaciones() {
  const tbody = document.getElementById("tableBody")
  tbody.innerHTML = ""

  cotizaciones.forEach((cotizacion) => {
    const row = document.createElement("tr")
    row.innerHTML = `
            <td>
                <strong>${cotizacion.numero}</strong>
            </td>
            <td>
                <div>${cotizacion.cliente.nombre}</div>
                <small class="text-muted">${cotizacion.cliente.email}</small>
            </td>
            <td>${cotizacion.producto ? cotizacion.producto.nombre : '<span class="text-muted">Personalizada</span>'}</td>
            <td><strong class="text-primary">$${cotizacion.total.toFixed(2)}</strong></td>
            <td>
                <span class="badge-estado ${cotizacion.estado}">
                    <i class="bi ${getBadgeIcon(cotizacion.estado)}"></i>
                    ${cotizacion.estado.charAt(0).toUpperCase() + cotizacion.estado.slice(1)}
                </span>
            </td>
            <td>${formatearFecha(cotizacion.fecha)}</td>
            <td class="text-center">
                <button class="btn-action btn-view" onclick="verCotizacion(${cotizacion.id})" title="Ver">
                    <i class="bi bi-eye"></i>
                </button>
                <button class="btn-action btn-edit" onclick="editarCotizacion(${cotizacion.id})" title="Editar">
                    <i class="bi bi-pencil"></i>
                </button>
                <button class="btn-action btn-delete" onclick="confirmarEliminar(${cotizacion.id})" title="Eliminar">
                    <i class="bi bi-trash"></i>
                </button>
                <button class="btn-action" style="background: var(--danger);" onclick="exportarPDFCotizacion(${cotizacion.id})" title="PDF">
                    <i class="bi bi-file-pdf" style="color: white;"></i>
                </button>
            </td>
        `
    tbody.appendChild(row)
  })

  // Actualizar stats
  document.getElementById("totalCotizaciones").textContent = cotizaciones.length
  document.getElementById("cotizacionesAprobadas").textContent = cotizaciones.filter(
    (c) => c.estado === "aprobada",
  ).length
  document.getElementById("cotizacionesPendientes").textContent = cotizaciones.filter(
    (c) => c.estado === "enviada" || c.estado === "borrador",
  ).length

  const totalAprobadas = cotizaciones.filter((c) => c.estado === "aprobada").reduce((sum, c) => sum + c.total, 0)
  document.getElementById("montoTotal").textContent = `$${totalAprobadas.toFixed(2)}`
}

// Ver cotización
function verCotizacion(id) {
  const cotizacion = cotizaciones.find((c) => c.id === id)
  if (!cotizacion) return

  cotizacionActual = cotizacion

  const viewContent = document.getElementById("cotizacionView")

  const tablaMateriales = cotizacion.materiales
    .map(
      (m) => `
        <tr>
            <td>${m.nombre}</td>
            <td class="text-center">${m.unidad}</td>
            <td class="text-center">${m.cantidad}</td>
            <td class="text-right">$${m.valor_unitario.toFixed(2)}</td>
            <td class="text-right">$${m.subtotal.toFixed(2)}</td>
        </tr>
    `,
    )
    .join("")

  viewContent.innerHTML = `
        <div class="cotizacion-watermark">METALWORKS</div>
        
        <div class="cotizacion-header">
            <div>
                <div class="cotizacion-logo">
                    <i class="bi bi-grid-3x3-gap-fill"></i> MetalWorks
                </div>
                <p style="margin: 0.5rem 0 0 0; color: #666;">Estructuras Metálicas</p>
            </div>
            <div class="cotizacion-info">
                <h2 class="cotizacion-numero">${cotizacion.numero}</h2>
                <p class="cotizacion-fecha">Fecha: ${formatearFecha(cotizacion.fecha)}</p>
                <span class="badge-estado ${cotizacion.estado}">
                    <i class="bi ${getBadgeIcon(cotizacion.estado)}"></i>
                    ${cotizacion.estado.charAt(0).toUpperCase() + cotizacion.estado.slice(1)}
                </span>
            </div>
        </div>
        
        <div class="cotizacion-content">
            <div class="cotizacion-section">
                <h6><i class="bi bi-person"></i> Información del Cliente</h6>
                <div class="cotizacion-detail">
                    <strong>Cliente:</strong>
                    <span>${cotizacion.cliente.nombre}</span>
                </div>
                <div class="cotizacion-detail">
                    <strong>Email:</strong>
                    <span>${cotizacion.cliente.email}</span>
                </div>
                <div class="cotizacion-detail">
                    <strong>Teléfono:</strong>
                    <span>${cotizacion.cliente.telefono}</span>
                </div>
                <div class="cotizacion-detail">
                    <strong>Dirección:</strong>
                    <span>${cotizacion.direccion}</span>
                </div>
            </div>
            
            ${
              cotizacion.producto
                ? `
            <div class="cotizacion-section">
                <h6><i class="bi bi-archive"></i> Producto</h6>
                <div class="cotizacion-detail">
                    <strong>Nombre:</strong>
                    <span>${cotizacion.producto.nombre}</span>
                </div>
                <div class="cotizacion-detail">
                    <strong>Categoría:</strong>
                    <span>${cotizacion.producto.categoria}</span>
                </div>
                <div class="cotizacion-detail">
                    <strong>Medidas:</strong>
                    <span>${cotizacion.producto.medidas}</span>
                </div>
            </div>
            `
                : ""
            }
            
            <div class="cotizacion-section">
                <h6><i class="bi bi-box-seam"></i> Detalle de Materiales</h6>
                <table class="cotizacion-table">
                    <thead>
                        <tr>
                            <th>Material</th>
                            <th class="text-center">Unidad</th>
                            <th class="text-center">Cantidad</th>
                            <th class="text-right">Valor Unitario</th>
                            <th class="text-right">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${tablaMateriales}
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="4" class="text-right"><strong>Subtotal Materiales:</strong></td>
                            <td class="text-right"><strong>$${cotizacion.subtotal.toFixed(2)}</strong></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            
            <div class="cotizacion-section">
                <h6><i class="bi bi-tools"></i> Mano de Obra</h6>
                <div class="cotizacion-detail">
                    <strong>Descripción:</strong>
                    <span>${cotizacion.descripcion_mano_obra || "N/A"}</span>
                </div>
                <div class="cotizacion-detail">
                    <strong>Valor:</strong>
                    <span>$${cotizacion.mano_obra.toFixed(2)}</span>
                </div>
            </div>
            
            <div class="cotizacion-section">
                <h6><i class="bi bi-calculator"></i> Resumen Final</h6>
                <table class="cotizacion-table">
                    <tbody>
                        <tr>
                            <td class="text-right"><strong>Subtotal Materiales:</strong></td>
                            <td class="text-right" width="150">$${cotizacion.subtotal.toFixed(2)}</td>
                        </tr>
                        <tr>
                            <td class="text-right"><strong>Mano de Obra:</strong></td>
                            <td class="text-right">$${cotizacion.mano_obra.toFixed(2)}</td>
                        </tr>
                        <tr>
                            <td class="text-right"><strong>Impuestos (IVA 19%):</strong></td>
                            <td class="text-right">$${cotizacion.impuestos.toFixed(2)}</td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr class="total-row">
                            <td class="text-right"><strong>TOTAL GENERAL:</strong></td>
                            <td class="text-right"><strong>$${cotizacion.total.toFixed(2)}</strong></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            
            ${
              cotizacion.notas
                ? `
            <div class="cotizacion-section">
                <h6><i class="bi bi-chat-left-text"></i> Notas</h6>
                <p style="color: #666; margin: 0;">${cotizacion.notas}</p>
            </div>
            `
                : ""
            }
        </div>
        
        <div class="cotizacion-footer">
            <p><strong>MetalWorks - Estructuras Metálicas</strong></p>
            <p>Teléfono: (123) 456-7890 | Email: info@metalworks.com</p>
            <p>www.metalworks.com</p>
        </div>
    `

  const modal = new bootstrap.Modal(document.getElementById("modalVerCotizacion"))
  modal.show()
}

// Editar cotización
function editarCotizacion(id) {
  const cotizacion = cotizaciones.find((c) => c.id === id)
  if (!cotizacion) return

  cotizacionActual = cotizacion
  materialesAgregados = JSON.parse(JSON.stringify(cotizacion.materiales))
  contadorMateriales = materialesAgregados.length

  // Reassign temp IDs
  materialesAgregados.forEach((m, index) => {
    m.tempId = index + 1
  })

  document.getElementById("modalTitle").innerHTML = '<i class="bi bi-pencil"></i> Editar Cotización'
  document.getElementById("cotizacionId").value = cotizacion.id
  document.getElementById("cliente_id").value = cotizacion.cliente.id
  document.getElementById("cliente_id").disabled = true

  // Trigger cliente change to load addresses
  onClienteChange()

  setTimeout(() => {
    document.getElementById("direccion_id").value = cotizacion.direccion
    document.getElementById("producto_id").value = cotizacion.producto ? cotizacion.producto.id : ""
    document.getElementById("estado").value = cotizacion.estado
    document.getElementById("notas").value = cotizacion.notas || ""
    document.getElementById("mano_obra").value = cotizacion.mano_obra
    document.getElementById("descripcion_mano_obra").value = cotizacion.descripcion_mano_obra || ""

    onProductoChange()
    actualizarTablaMateriales()
  }, 100)

  const modal = new bootstrap.Modal(document.getElementById("modalCrearCotizacion"))
  modal.show()
}

// Editar desde ver
function editarDesdeVer() {
  if (cotizacionActual) {
    const modalVer = bootstrap.Modal.getInstance(document.getElementById("modalVerCotizacion"))
    modalVer.hide()

    setTimeout(() => {
      editarCotizacion(cotizacionActual.id)
    }, 300)
  }
}

// Confirmar eliminar
function confirmarEliminar(id) {
  const cotizacion = cotizaciones.find((c) => c.id === id)
  if (!cotizacion) return

  cotizacionActual = cotizacion
  document.getElementById("eliminarNumero").textContent = cotizacion.numero

  const modal = new bootstrap.Modal(document.getElementById("modalEliminar"))
  modal.show()

  document.getElementById("btnConfirmarEliminar").onclick = () => {
    cotizaciones = cotizaciones.filter((c) => c.id !== id)
    cargarTablaCotizaciones()
    modal.hide()
    alert("Cotización eliminada exitosamente")
  }
}

// Exportar PDF
function exportarPDF() {
  if (cotizacionActual) {
    exportarPDFCotizacion(cotizacionActual.id)
  }
}

// Exportar PDF específico
function exportarPDFCotizacion(id) {
  const cotizacion = cotizaciones.find((c) => c.id === id)
  if (!cotizacion) return

  // Mostrar la cotización
  cotizacionActual = cotizacion
  verCotizacion(id)

  setTimeout(() => {
    const element = document.getElementById("cotizacionView")

    html2canvas(element, {
      scale: 2,
      useCORS: true,
      logging: false,
    }).then((canvas) => {
      const imgData = canvas.toDataURL("image/png")
      const pdf = new jspdf.jsPDF("p", "mm", "a4")
      const imgWidth = 210
      const pageHeight = 297
      const imgHeight = (canvas.height * imgWidth) / canvas.width
      let heightLeft = imgHeight
      let position = 0

      pdf.addImage(imgData, "PNG", 0, position, imgWidth, imgHeight)
      heightLeft -= pageHeight

      while (heightLeft >= 0) {
        position = heightLeft - imgHeight
        pdf.addPage()
        pdf.addImage(imgData, "PNG", 0, position, imgWidth, imgHeight)
        heightLeft -= pageHeight
      }

      pdf.save(`${cotizacion.numero}.pdf`)
    })
  }, 500)
}

// Filtrar cotizaciones
function filtrarCotizaciones() {
  // Implementación básica de filtro
  cargarTablaCotizaciones()
}

// Utilidades
function getBadgeIcon(estado) {
  const icons = {
    borrador: "bi-file-earmark",
    enviada: "bi-send",
    aprobada: "bi-check-circle",
    rechazada: "bi-x-circle",
  }
  return icons[estado] || "bi-file-earmark"
}

function formatearFecha(fecha) {
  const date = new Date(fecha + "T00:00:00")
  const opciones = { year: "numeric", month: "short", day: "numeric" }
  return date.toLocaleDateString("es-ES", opciones)
}
