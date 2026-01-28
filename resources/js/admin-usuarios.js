// Admin Usuarios - JavaScript

// Data simulada
let usuarios = [
  {
    id: 1,
    nombre: "Juan",
    apellido: "Pérez",
    email: "juan.perez@email.com",
    telefonos: ["3001234567", "3109876543"],
    rol: "administrador",
    estado: "activo",
    cod_ciudad: "BGA",
    barrio: "Cabecera",
    direccion_1: "Calle 45 #23-15",
    direccion_2: "Carrera 27 #34-12",
    direccion_3: "",
    direccion_4: "",
    permisos: ["usuarios.ver", "usuarios.crear", "usuarios.editar", "categorias.ver"],
    fecha_registro: "2024-01-15",
    ultimo_acceso: "2024-03-20",
  },
  {
    id: 2,
    nombre: "María",
    apellido: "González",
    email: "maria.gonzalez@email.com",
    telefonos: ["3157894561"],
    rol: "cliente",
    estado: "activo",
    cod_ciudad: "FLO",
    barrio: "La Cumbre",
    direccion_1: "Carrera 15 #45-23",
    direccion_2: "",
    direccion_3: "",
    direccion_4: "",
    permisos: ["productos.ver", "cotizaciones.crear"],
    fecha_registro: "2024-02-10",
    ultimo_acceso: "2024-03-19",
  },
  {
    id: 3,
    nombre: "Carlos",
    apellido: "Ramírez",
    email: "carlos.ramirez@email.com",
    telefonos: ["3201234567", "3112345678", "3173456789"],
    rol: "vendedor",
    estado: "activo",
    cod_ciudad: "BGA",
    barrio: "Provenza",
    direccion_1: "Calle 33 #12-45",
    direccion_2: "",
    direccion_3: "",
    direccion_4: "",
    permisos: ["productos.ver", "productos.editar", "cotizaciones.ver", "cotizaciones.crear"],
    fecha_registro: "2024-01-20",
    ultimo_acceso: "2024-03-20",
  },
  {
    id: 4,
    nombre: "Ana",
    apellido: "Martínez",
    email: "ana.martinez@email.com",
    telefonos: ["3145678901"],
    rol: "tecnico",
    estado: "inactivo",
    cod_ciudad: "GIR",
    barrio: "El Poblado",
    direccion_1: "Calle 10 #5-20",
    direccion_2: "",
    direccion_3: "",
    direccion_4: "",
    permisos: ["materiales.ver", "productos.ver"],
    fecha_registro: "2024-03-01",
    ultimo_acceso: "2024-03-15",
  },
  {
    id: 5,
    nombre: "Luis",
    apellido: "Fernández",
    email: "luis.fernandez@email.com",
    telefonos: ["3186543210"],
    rol: "cliente",
    estado: "suspendido",
    cod_ciudad: "PIE",
    barrio: "Centro",
    direccion_1: "Carrera 8 #12-34",
    direccion_2: "",
    direccion_3: "",
    direccion_4: "",
    permisos: [],
    fecha_registro: "2024-02-25",
    ultimo_acceso: "2024-03-10",
  },
]

const currentPage = 1
const itemsPerPage = 10
let usuarioEditando = null
let usuarioRolesPermisos = null

// Bootstrap instance declaration
const bootstrap = window.bootstrap

// Inicialización
document.addEventListener("DOMContentLoaded", () => {
  initializeSidebar()
  renderTable()
  updateStats()
  initializeFilters()
  initializeForms()
  initializeTelefonos()
  initializePasswordToggles()
  initializeRolesPermisos()
})

// Sidebar Toggle
function initializeSidebar() {
  const toggleBtn = document.getElementById("toggleSidebar")
  const sidebar = document.getElementById("sidebar")

  if (toggleBtn) {
    toggleBtn.addEventListener("click", () => {
      sidebar.classList.toggle("show")
    })
  }
}

// Render Table
function renderTable() {
  const tableBody = document.getElementById("tableBody")
  const start = (currentPage - 1) * itemsPerPage
  const end = start + itemsPerPage
  const paginatedUsers = usuarios.slice(start, end)

  tableBody.innerHTML = paginatedUsers
    .map(
      (usuario) => `
    <tr>
      <td>
        <strong>${usuario.nombre} ${usuario.apellido}</strong>
      </td>
      <td>${usuario.email}</td>
      <td>
        <div class="telefonos-tooltip">
          <span class="telefonos-badge" title="Ver teléfonos">
            <i class="bi bi-telephone"></i>
            ${usuario.telefonos.length} número${usuario.telefonos.length > 1 ? "s" : ""}
          </span>
          <div class="telefonos-list">
            <ul>
              ${usuario.telefonos.map((tel) => `<li><i class="bi bi-phone"></i> ${tel}</li>`).join("")}
            </ul>
          </div>
        </div>
      </td>
      <td>
        <span class="badge-rol badge-rol-${usuario.rol}">
          ${getRolIcon(usuario.rol)} ${capitalizeFirst(usuario.rol)}
        </span>
      </td>
      <td>
        <span class="badge-status badge-status-${usuario.estado}">
          ${getEstadoIcon(usuario.estado)} ${capitalizeFirst(usuario.estado)}
        </span>
      </td>
      <td class="text-center">
        <div class="d-flex gap-2 justify-content-center">
          <button class="btn-action btn-view" onclick="verUsuario(${usuario.id})" title="Ver detalles">
            <i class="bi bi-eye"></i>
          </button>
          <button class="btn-action btn-edit" onclick="editarUsuario(${usuario.id})" title="Editar">
            <i class="bi bi-pencil"></i>
          </button>
          <button class="btn-action btn-roles" onclick="administrarRolesPermisos(${usuario.id})" title="Roles y Permisos">
            <i class="bi bi-shield-lock"></i>
          </button>
          <button class="btn-action btn-estado" onclick="cambiarEstado(${usuario.id})" title="Cambiar estado">
            <i class="bi bi-toggle-on"></i>
          </button>
          <button class="btn-action btn-delete" onclick="confirmarEliminar(${usuario.id})" title="Eliminar">
            <i class="bi bi-trash"></i>
          </button>
        </div>
      </td>
    </tr>
  `,
    )
    .join("")

  updatePagination()
}

// Get Rol Icon
function getRolIcon(rol) {
  const icons = {
    administrador: '<i class="bi bi-star-fill"></i>',
    cliente: '<i class="bi bi-person-fill"></i>',
    vendedor: '<i class="bi bi-cart-fill"></i>',
    tecnico: '<i class="bi bi-tools"></i>',
  }
  return icons[rol] || '<i class="bi bi-person"></i>'
}

// Get Estado Icon
function getEstadoIcon(estado) {
  const icons = {
    activo: '<i class="bi bi-check-circle"></i>',
    inactivo: '<i class="bi bi-pause-circle"></i>',
    suspendido: '<i class="bi bi-x-circle"></i>',
  }
  return icons[estado] || ""
}

// Capitalize First
function capitalizeFirst(str) {
  return str.charAt(0).toUpperCase() + str.slice(1)
}

// Update Stats
function updateStats() {
  document.getElementById("totalUsuarios").textContent = usuarios.length
  document.getElementById("usuariosActivos").textContent = usuarios.filter((u) => u.estado === "activo").length
  document.getElementById("usuariosInactivos").textContent = usuarios.filter((u) => u.estado === "inactivo").length
  document.getElementById("usuariosSuspendidos").textContent = usuarios.filter((u) => u.estado === "suspendido").length
}

// Update Pagination
function updatePagination() {
  const totalPages = Math.ceil(usuarios.length / itemsPerPage)
  document.getElementById("showingFrom").textContent = (currentPage - 1) * itemsPerPage + 1
  document.getElementById("showingTo").textContent = Math.min(currentPage * itemsPerPage, usuarios.length)
  document.getElementById("totalRecords").textContent = usuarios.length
}

// Initialize Filters
function initializeFilters() {
  const searchInput = document.getElementById("searchInput")
  const filterRol = document.getElementById("filterRol")
  const filterEstado = document.getElementById("filterEstado")
  const sortBy = document.getElementById("sortBy")
  ;[searchInput, filterRol, filterEstado, sortBy].forEach((element) => {
    if (element) {
      element.addEventListener("change", applyFilters)
      element.addEventListener("keyup", applyFilters)
    }
  })
}

// Apply Filters
function applyFilters() {
  // Aquí implementarías la lógica de filtrado
  renderTable()
}

// Initialize Forms
function initializeForms() {
  const formUsuario = document.getElementById("formUsuario")
  const formRolesPermisos = document.getElementById("formRolesPermisos")
  const formCambiarEstado = document.getElementById("formCambiarEstado")

  if (formUsuario) {
    formUsuario.addEventListener("submit", (e) => {
      e.preventDefault()
      guardarUsuario()
    })
  }

  if (formRolesPermisos) {
    formRolesPermisos.addEventListener("submit", (e) => {
      e.preventDefault()
      guardarRolesPermisos()
    })
  }

  if (formCambiarEstado) {
    formCambiarEstado.addEventListener("submit", (e) => {
      e.preventDefault()
      confirmarCambioEstado()
    })
  }

  // Modal events
  const modalCrearUsuario = document.getElementById("modalCrearUsuario")
  if (modalCrearUsuario) {
    modalCrearUsuario.addEventListener("hidden.bs.modal", () => {
      resetForm()
    })
  }
}

// Initialize Teléfonos
function initializeTelefonos() {
  const btnAgregar = document.getElementById("btnAgregarTelefono")

  if (btnAgregar) {
    btnAgregar.addEventListener("click", agregarTelefono)
  }

  // Delegación de eventos para botones de eliminar
  document.getElementById("telefonosContainer").addEventListener("click", (e) => {
    if (e.target.closest(".btn-remove-telefono")) {
      const item = e.target.closest(".telefono-item")
      if (item && document.querySelectorAll(".telefono-item").length > 1) {
        item.remove()
        actualizarBotonesEliminarTelefono()
      }
    }
  })
}

// Agregar Teléfono
function agregarTelefono() {
  const container = document.getElementById("telefonosContainer")
  const count = container.querySelectorAll(".telefono-item").length + 1

  const telefonoHTML = `
    <div class="telefono-item mb-3">
      <div class="row align-items-end">
        <div class="col-md-11">
          <label class="form-label">Teléfono ${count}</label>
          <input type="tel" class="form-control" name="telefonos[]" placeholder="Ej: 3001234567">
          <div class="invalid-feedback">Por favor ingrese un número de teléfono válido.</div>
        </div>
        <div class="col-md-1">
          <button type="button" class="btn btn-danger btn-sm w-100 btn-remove-telefono">
            <i class="bi bi-trash"></i>
          </button>
        </div>
      </div>
    </div>
  `

  container.insertAdjacentHTML("beforeend", telefonoHTML)
  actualizarBotonesEliminarTelefono()
}

// Actualizar Botones Eliminar Teléfono
function actualizarBotonesEliminarTelefono() {
  const items = document.querySelectorAll(".telefono-item")
  const btns = document.querySelectorAll(".btn-remove-telefono")

  btns.forEach((btn, index) => {
    btn.disabled = items.length === 1
  })
}

// Initialize Password Toggles
function initializePasswordToggles() {
  const togglePassword = document.getElementById("togglePassword")
  const toggleConfirmPassword = document.getElementById("toggleConfirmPassword")
  const password = document.getElementById("password")
  const passwordConfirm = document.getElementById("password_confirmation")

  if (togglePassword && password) {
    togglePassword.addEventListener("click", function () {
      const type = password.type === "password" ? "text" : "password"
      password.type = type
      this.querySelector("i").classList.toggle("bi-eye")
      this.querySelector("i").classList.toggle("bi-eye-slash")
    })
  }

  if (toggleConfirmPassword && passwordConfirm) {
    toggleConfirmPassword.addEventListener("click", function () {
      const type = passwordConfirm.type === "password" ? "text" : "password"
      passwordConfirm.type = type
      this.querySelector("i").classList.toggle("bi-eye")
      this.querySelector("i").classList.toggle("bi-eye-slash")
    })
  }
}

// Initialize Roles y Permisos
function initializeRolesPermisos() {
  const toggleTodos = document.getElementById("toggleTodosPermisos")

  if (toggleTodos) {
    toggleTodos.addEventListener("change", function () {
      const checkboxes = document.querySelectorAll(".permiso-checkbox")
      checkboxes.forEach((cb) => {
        cb.checked = this.checked
      })
    })
  }

  // Evento para los roles que preseleccionan permisos
  document.querySelectorAll('input[name="roles[]"]').forEach((radio) => {
    radio.addEventListener("change", function () {
      preseleccionarPermisosPorRol(this.value)
    })
  })
}

// Preseleccionar Permisos por Rol
function preseleccionarPermisosPorRol(rol) {
  // Limpiar todos los permisos
  document.querySelectorAll(".permiso-checkbox").forEach((cb) => {
    cb.checked = false
  })

  // Preseleccionar según el rol
  if (rol === "administrador") {
    document.querySelectorAll(".permiso-checkbox").forEach((cb) => {
      cb.checked = true
    })
  } else if (rol === "vendedor") {
    ;["productos.ver", "productos.editar", "cotizaciones.ver", "cotizaciones.crear", "cotizaciones.editar"].forEach(
      (perm) => {
        const checkbox = document.querySelector(`input[value="${perm}"]`)
        if (checkbox) checkbox.checked = true
      },
    )
  } else if (rol === "cliente") {
    ;["productos.ver", "cotizaciones.crear"].forEach((perm) => {
      const checkbox = document.querySelector(`input[value="${perm}"]`)
      if (checkbox) checkbox.checked = true
    })
  } else if (rol === "tecnico") {
    ;["materiales.ver", "productos.ver"].forEach((perm) => {
      const checkbox = document.querySelector(`input[value="${perm}"]`)
      if (checkbox) checkbox.checked = true
    })
  }
}

// Ver Usuario
function verUsuario(id) {
  const usuario = usuarios.find((u) => u.id === id)
  if (!usuario) return

  // Llenar datos
  document.getElementById("verNombreCompleto").textContent = `${usuario.nombre} ${usuario.apellido}`
  document.getElementById("verEmail").textContent = usuario.email
  document.getElementById("verAvatar").src =
    `https://ui-avatars.com/api/?name=${usuario.nombre}+${usuario.apellido}&background=0ea5e9&color=fff`

  // Rol
  document.getElementById("verRolBadge").innerHTML = `
    <span class="badge-rol badge-rol-${usuario.rol}">
      ${getRolIcon(usuario.rol)} ${capitalizeFirst(usuario.rol)}
    </span>
  `

  // Estado
  document.getElementById("verEstadoBadge").innerHTML = `
    <span class="badge-status badge-status-${usuario.estado}">
      ${getEstadoIcon(usuario.estado)} ${capitalizeFirst(usuario.estado)}
    </span>
  `

  // Ubicación
  document.getElementById("verCiudad").textContent = usuario.cod_ciudad
  document.getElementById("verBarrio").textContent = usuario.barrio
  document.getElementById("verDireccion1").textContent = usuario.direccion_1 || "No especificada"
  document.getElementById("verDireccion2").textContent = usuario.direccion_2 || "No especificada"
  document.getElementById("verDireccion3").textContent = usuario.direccion_3 || "No especificada"
  document.getElementById("verDireccion4").textContent = usuario.direccion_4 || "No especificada"

  // Teléfonos
  document.getElementById("verTelefonosList").innerHTML = usuario.telefonos
    .map(
      (tel) => `
    <div class="detail-row">
      <i class="bi bi-telephone text-primary"></i>
      <span>${tel}</span>
    </div>
  `,
    )
    .join("")

  // Permisos
  document.getElementById("verPermisosList").innerHTML =
    usuario.permisos.length > 0
      ? usuario.permisos
          .map(
            (perm) => `
        <span class="badge badge-activo mb-1 me-1">${perm}</span>
      `,
          )
          .join("")
      : '<span class="text-muted">Sin permisos asignados</span>'

  // Fechas
  document.getElementById("verFechaRegistro").textContent = usuario.fecha_registro
  document.getElementById("verUltimoAcceso").textContent = usuario.ultimo_acceso

  // Guardar ID para editar desde modal
  document.getElementById("btnEditarDesdeVer").onclick = () => {
    bootstrap.Modal.getInstance(document.getElementById("modalVerUsuario")).hide()
    editarUsuario(id)
  }

  // Guardar ID para roles y permisos
  document.getElementById("btnRolesPermisos").onclick = () => {
    bootstrap.Modal.getInstance(document.getElementById("modalVerUsuario")).hide()
    administrarRolesPermisos(id)
  }

  // Mostrar modal
  const modal = new bootstrap.Modal(document.getElementById("modalVerUsuario"))
  modal.show()
}

// Editar Usuario
function editarUsuario(id) {
  const usuario = usuarios.find((u) => u.id === id)
  if (!usuario) return

  usuarioEditando = usuario

  // Cambiar título
  document.getElementById("modalTitle").innerHTML = '<i class="bi bi-pencil"></i> Editar Usuario'

  // Llenar formulario
  document.getElementById("usuarioId").value = usuario.id
  document.getElementById("nombre").value = usuario.nombre
  document.getElementById("apellido").value = usuario.apellido
  document.getElementById("email").value = usuario.email
  document.getElementById("cod_ciudad").value = usuario.cod_ciudad
  document.getElementById("barrio").value = usuario.barrio
  document.getElementById("direccion_1").value = usuario.direccion_1
  document.getElementById("direccion_2").value = usuario.direccion_2
  document.getElementById("direccion_3").value = usuario.direccion_3
  document.getElementById("direccion_4").value = usuario.direccion_4

  // Teléfonos
  const container = document.getElementById("telefonosContainer")
  container.innerHTML = ""
  usuario.telefonos.forEach((tel, index) => {
    const telefonoHTML = `
      <div class="telefono-item mb-3">
        <div class="row align-items-end">
          <div class="col-md-11">
            <label class="form-label">Teléfono ${index + 1}</label>
            <input type="tel" class="form-control" name="telefonos[]" value="${tel}" placeholder="Ej: 3001234567">
            <div class="invalid-feedback">Por favor ingrese un número de teléfono válido.</div>
          </div>
          <div class="col-md-1">
            <button type="button" class="btn btn-danger btn-sm w-100 btn-remove-telefono">
              <i class="bi bi-trash"></i>
            </button>
          </div>
        </div>
      </div>
    `
    container.insertAdjacentHTML("beforeend", telefonoHTML)
  })
  actualizarBotonesEliminarTelefono()

  // Password no requerido en edición
  document.getElementById("password").removeAttribute("required")
  document.getElementById("password_confirmation").removeAttribute("required")
  document.getElementById("passwordRequired").style.display = "none"
  document.getElementById("confirmRequired").style.display = "none"

  // Estado
  document.getElementById(`estado${capitalizeFirst(usuario.estado)}`).checked = true

  // Mostrar modal
  const modal = new bootstrap.Modal(document.getElementById("modalCrearUsuario"))
  modal.show()
}

// Guardar Usuario
function guardarUsuario() {
  const formData = new FormData(document.getElementById("formUsuario"))
  const telefonos = formData.getAll("telefonos[]").filter((t) => t.trim() !== "")

  if (telefonos.length === 0) {
    alert("Debe agregar al menos un teléfono")
    return
  }

  const usuarioData = {
    id: formData.get("id") || Date.now(),
    nombre: formData.get("nombre"),
    apellido: formData.get("apellido"),
    email: formData.get("email"),
    telefonos: telefonos,
    rol: usuarioEditando ? usuarioEditando.rol : "cliente",
    estado: formData.get("estado"),
    cod_ciudad: formData.get("cod_ciudad"),
    barrio: formData.get("barrio"),
    direccion_1: formData.get("direccion_1"),
    direccion_2: formData.get("direccion_2") || "",
    direccion_3: formData.get("direccion_3") || "",
    direccion_4: formData.get("direccion_4") || "",
    permisos: usuarioEditando ? usuarioEditando.permisos : [],
    fecha_registro: usuarioEditando ? usuarioEditando.fecha_registro : new Date().toISOString().split("T")[0],
    ultimo_acceso: usuarioEditando ? usuarioEditando.ultimo_acceso : new Date().toISOString().split("T")[0],
  }

  if (usuarioEditando) {
    // Actualizar
    const index = usuarios.findIndex((u) => u.id == usuarioEditando.id)
    usuarios[index] = { ...usuarios[index], ...usuarioData }
  } else {
    // Crear nuevo
    usuarios.unshift(usuarioData)
  }

  // Cerrar modal
  bootstrap.Modal.getInstance(document.getElementById("modalCrearUsuario")).hide()

  // Actualizar tabla
  renderTable()
  updateStats()

  // Mostrar mensaje
  alert(usuarioEditando ? "Usuario actualizado correctamente" : "Usuario creado correctamente")
}

// Reset Form
function resetForm() {
  document.getElementById("formUsuario").reset()
  document.getElementById("modalTitle").innerHTML = '<i class="bi bi-person-plus"></i> Nuevo Usuario'
  usuarioEditando = null

  // Resetear teléfonos
  const container = document.getElementById("telefonosContainer")
  container.innerHTML = `
    <div class="telefono-item mb-3">
      <div class="row align-items-end">
        <div class="col-md-11">
          <label class="form-label">Teléfono 1 <span class="text-danger">*</span></label>
          <input type="tel" class="form-control" name="telefonos[]" placeholder="Ej: 3001234567" required>
          <div class="invalid-feedback">Por favor ingrese un número de teléfono válido.</div>
        </div>
        <div class="col-md-1">
          <button type="button" class="btn btn-danger btn-sm w-100 btn-remove-telefono" disabled>
            <i class="bi bi-trash"></i>
          </button>
        </div>
      </div>
    </div>
  `

  // Resetear password requerido
  document.getElementById("password").setAttribute("required", "required")
  document.getElementById("password_confirmation").setAttribute("required", "required")
  document.getElementById("passwordRequired").style.display = "inline"
  document.getElementById("confirmRequired").style.display = "inline"
}

// Administrar Roles y Permisos
function administrarRolesPermisos(id) {
  const usuario = usuarios.find((u) => u.id === id)
  if (!usuario) return

  usuarioRolesPermisos = usuario

  // Llenar datos
  document.getElementById("rolUsuarioId").value = usuario.id
  document.getElementById("nombreUsuarioRol").textContent = `${usuario.nombre} ${usuario.apellido}`

  // Marcar rol actual
  document.querySelector(`input[value="${usuario.rol}"]`).checked = true

  // Marcar permisos actuales
  document.querySelectorAll(".permiso-checkbox").forEach((cb) => {
    cb.checked = usuario.permisos.includes(cb.value)
  })

  // Mostrar modal
  const modal = new bootstrap.Modal(document.getElementById("modalRolesPermisos"))
  modal.show()
}

// Guardar Roles y Permisos
function guardarRolesPermisos() {
  const formData = new FormData(document.getElementById("formRolesPermisos"))
  const rol = formData.get("roles[]")
  const permisos = formData.getAll("permisos[]")

  const index = usuarios.findIndex((u) => u.id == usuarioRolesPermisos.id)
  usuarios[index].rol = rol
  usuarios[index].permisos = permisos

  // Cerrar modal
  bootstrap.Modal.getInstance(document.getElementById("modalRolesPermisos")).hide()

  // Actualizar tabla
  renderTable()

  // Mostrar mensaje
  alert("Roles y permisos actualizados correctamente")
}

// Cambiar Estado
function cambiarEstado(id) {
  const usuario = usuarios.find((u) => u.id === id)
  if (!usuario) return

  document.getElementById("estadoUsuarioId").value = usuario.id
  document.getElementById("estadoNombreUsuario").textContent = `${usuario.nombre} ${usuario.apellido}`
  document.getElementById("estadoActualUsuario").innerHTML = `
    <span class="badge-status badge-status-${usuario.estado}">
      ${getEstadoIcon(usuario.estado)} ${capitalizeFirst(usuario.estado)}
    </span>
  `

  // Marcar estado actual (pero permitir cambiar a otro)
  document.querySelectorAll('input[name="nuevo_estado"]').forEach((radio) => {
    radio.checked = false
  })

  const modal = new bootstrap.Modal(document.getElementById("modalCambiarEstado"))
  modal.show()
}

// Confirmar Cambio Estado
function confirmarCambioEstado() {
  const usuarioId = document.getElementById("estadoUsuarioId").value
  const nuevoEstado = document.querySelector('input[name="nuevo_estado"]:checked')

  if (!nuevoEstado) {
    alert("Por favor seleccione un nuevo estado")
    return
  }

  const index = usuarios.findIndex((u) => u.id == usuarioId)
  usuarios[index].estado = nuevoEstado.value

  // Cerrar modal
  bootstrap.Modal.getInstance(document.getElementById("modalCambiarEstado")).hide()

  // Actualizar tabla
  renderTable()
  updateStats()

  // Mostrar mensaje
  alert("Estado actualizado correctamente")
}

// Confirmar Eliminar
function confirmarEliminar(id) {
  const usuario = usuarios.find((u) => u.id === id)
  if (!usuario) return

  document.getElementById("eliminarNombre").textContent = `${usuario.nombre} ${usuario.apellido}`

  document.getElementById("btnConfirmarEliminar").onclick = () => {
    eliminarUsuario(id)
  }

  const modal = new bootstrap.Modal(document.getElementById("modalEliminar"))
  modal.show()
}

// Eliminar Usuario
function eliminarUsuario(id) {
  usuarios = usuarios.filter((u) => u.id !== id)

  // Cerrar modal
  bootstrap.Modal.getInstance(document.getElementById("modalEliminar")).hide()

  // Actualizar tabla
  renderTable()
  updateStats()

  // Mostrar mensaje
  alert("Usuario eliminado correctamente")
}
