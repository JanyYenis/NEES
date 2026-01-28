@extends('layouts.index')

@section('title', 'Usuarios / Clientes')
@section('sub_title', 'Dashboard / Usuarios / Clientes')

@section('imports')
    @vite(['resources/js/admin-usuarios.js', 'resources/css/admin-usuarios.css'])
@endsection

@section('content')
    <!-- Filters and Actions -->
    <div class="filters-section">
        <div class="row align-items-center">
            <div class="col-md-3">
                <div class="search-box">
                    <i class="bi bi-search"></i>
                    <input type="text" id="searchInput" class="form-control" placeholder="Buscar por nombre o email...">
                </div>
            </div>
            <div class="col-md-2">
                <select class="form-select" id="filterRol">
                    <option value="">Todos los roles</option>
                    <option value="administrador">Administrador</option>
                    <option value="cliente">Cliente</option>
                    <option value="vendedor">Vendedor</option>
                    <option value="tecnico">Técnico</option>
                </select>
            </div>
            <div class="col-md-2">
                <select class="form-select" id="filterEstado">
                    <option value="">Todos los estados</option>
                    <option value="activo">Activo</option>
                    <option value="inactivo">Inactivo</option>
                    <option value="suspendido">Suspendido</option>
                </select>
            </div>
            <div class="col-md-2">
                <select class="form-select" id="sortBy">
                    <option value="nombre">Ordenar por Nombre</option>
                    <option value="email">Ordenar por Email</option>
                    <option value="rol">Ordenar por Rol</option>
                    <option value="fecha">Ordenar por Fecha</option>
                </select>
            </div>
            <div class="col-md-3 text-end">
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCrearUsuario">
                    <i class="bi bi-plus-lg"></i> Nuevo Usuario
                </button>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-icon bg-primary">
                    <i class="bi bi-people"></i>
                </div>
                <div class="stat-info">
                    <h3 id="totalUsuarios">48</h3>
                    <p>Total Usuarios</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-icon bg-success">
                    <i class="bi bi-check-circle"></i>
                </div>
                <div class="stat-info">
                    <h3 id="usuariosActivos">42</h3>
                    <p>Activos</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-icon bg-warning">
                    <i class="bi bi-pause-circle"></i>
                </div>
                <div class="stat-info">
                    <h3 id="usuariosInactivos">4</h3>
                    <p>Inactivos</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-icon bg-danger">
                    <i class="bi bi-x-circle"></i>
                </div>
                <div class="stat-info">
                    <h3 id="usuariosSuspendidos">2</h3>
                    <p>Suspendidos</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="table-card">
        <div class="table-responsive">
            <table class="table table-hover" id="tablaUsuarios">
                <thead>
                    <tr>
                        <th width="250">Nombre Completo</th>
                        <th>Email</th>
                        <th width="150">Teléfonos</th>
                        <th width="140">Rol</th>
                        <th width="140">Estado</th>
                        <th width="220" class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody id="tableBody">
                    <!-- Data will be loaded here -->
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="pagination-wrapper">
            <div class="pagination-info">
                Mostrando <strong id="showingFrom">1</strong> a <strong id="showingTo">10</strong> de <strong
                    id="totalRecords">48</strong> registros
            </div>
            <nav>
                <ul class="pagination" id="pagination">
                    <li class="page-item disabled">
                        <a class="page-link" href="#"><i class="bi bi-chevron-left"></i></a>
                    </li>
                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item">
                        <a class="page-link" href="#"><i class="bi bi-chevron-right"></i></a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
@endsection

@section('modal')
    <!-- Modal Crear/Editar Usuario -->
    <div class="modal fade" id="modalCrearUsuario" tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">
                        <i class="bi bi-person-plus"></i> Nuevo Usuario
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="formUsuario">
                    <div class="modal-body">
                        <input type="hidden" id="usuarioId" name="id">

                        <!-- Datos Personales -->
                        <div class="section-header">
                            <i class="bi bi-person"></i>
                            <h6>Datos Personales</h6>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="nombre" class="form-label">
                                    Nombre <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control" id="nombre" name="nombre" required>
                                <div class="invalid-feedback">Por favor ingrese el nombre.</div>
                            </div>
                            <div class="col-md-6">
                                <label for="apellido" class="form-label">
                                    Apellido <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control" id="apellido" name="apellido" required>
                                <div class="invalid-feedback">Por favor ingrese el apellido.</div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-12">
                                <label for="email" class="form-label">
                                    Email <span class="text-danger">*</span>
                                </label>
                                <input type="email" class="form-control" id="email" name="email" required>
                                <div class="invalid-feedback">Por favor ingrese un email válido.</div>
                            </div>
                        </div>

                        <!-- Ubicación -->
                        <div class="section-header">
                            <i class="bi bi-geo-alt"></i>
                            <h6>Ubicación</h6>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="cod_ciudad" class="form-label">
                                    Código de Ciudad <span class="text-danger">*</span>
                                </label>
                                <select class="form-select" id="cod_ciudad" name="cod_ciudad" required>
                                    <option value="">Seleccionar ciudad</option>
                                    <option value="BGA">Bucaramanga</option>
                                    <option value="FLO">Floridablanca</option>
                                    <option value="GIR">Girón</option>
                                    <option value="PIE">Piedecuesta</option>
                                    <option value="BOG">Bogotá</option>
                                    <option value="MED">Medellín</option>
                                    <option value="CAL">Cali</option>
                                </select>
                                <div class="invalid-feedback">Por favor seleccione una ciudad.</div>
                            </div>
                            <div class="col-md-6">
                                <label for="barrio" class="form-label">
                                    Barrio <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control" id="barrio" name="barrio" required>
                                <div class="invalid-feedback">Por favor ingrese el barrio.</div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="direccion_1" class="form-label">
                                    Dirección 1 (Principal) <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control" id="direccion_1" name="direccion_1"
                                    placeholder="Ej: Calle 45 #23-15" required>
                                <div class="invalid-feedback">Por favor ingrese la dirección principal.</div>
                            </div>
                            <div class="col-md-6">
                                <label for="direccion_2" class="form-label">
                                    Dirección 2 (Opcional)
                                </label>
                                <input type="text" class="form-control" id="direccion_2" name="direccion_2"
                                    placeholder="Dirección alternativa">
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="direccion_3" class="form-label">
                                    Dirección 3 (Opcional)
                                </label>
                                <input type="text" class="form-control" id="direccion_3" name="direccion_3">
                            </div>
                            <div class="col-md-6">
                                <label for="direccion_4" class="form-label">
                                    Dirección 4 (Opcional)
                                </label>
                                <input type="text" class="form-control" id="direccion_4" name="direccion_4">
                            </div>
                        </div>

                        <!-- Teléfonos -->
                        <div class="section-header">
                            <i class="bi bi-telephone"></i>
                            <h6>Teléfonos</h6>
                            <button type="button" class="btn btn-sm btn-outline-primary ms-auto"
                                id="btnAgregarTelefono">
                                <i class="bi bi-plus"></i> Agregar Número
                            </button>
                        </div>

                        <div id="telefonosContainer" class="mb-4">
                            <div class="telefono-item mb-3">
                                <div class="row align-items-end">
                                    <div class="col-md-11">
                                        <label class="form-label">Teléfono 1 <span class="text-danger">*</span></label>
                                        <input type="tel" class="form-control" name="telefonos[]"
                                            placeholder="Ej: 3001234567" required>
                                        <div class="invalid-feedback">Por favor ingrese un número de teléfono válido.</div>
                                    </div>
                                    <div class="col-md-1">
                                        <button type="button" class="btn btn-danger btn-sm w-100 btn-remove-telefono"
                                            disabled>
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Seguridad -->
                        <div class="section-header">
                            <i class="bi bi-shield-lock"></i>
                            <h6>Seguridad</h6>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="password" class="form-label">
                                    Contraseña <span class="text-danger" id="passwordRequired">*</span>
                                </label>
                                <div class="password-input-group">
                                    <input type="password" class="form-control" id="password" name="password">
                                    <button type="button" class="btn-toggle-password" id="togglePassword">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </div>
                                <div class="invalid-feedback">Por favor ingrese una contraseña.</div>
                                <small class="text-muted">Mínimo 8 caracteres</small>
                            </div>
                            <div class="col-md-6">
                                <label for="password_confirmation" class="form-label">
                                    Confirmar Contraseña <span class="text-danger" id="confirmRequired">*</span>
                                </label>
                                <div class="password-input-group">
                                    <input type="password" class="form-control" id="password_confirmation"
                                        name="password_confirmation">
                                    <button type="button" class="btn-toggle-password" id="toggleConfirmPassword">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </div>
                                <div class="invalid-feedback">Las contraseñas no coinciden.</div>
                            </div>
                        </div>

                        <!-- Estado -->
                        <div class="section-header">
                            <i class="bi bi-toggle-on"></i>
                            <h6>Estado del Usuario</h6>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <label class="form-label">Estado</label>
                                <div class="estado-options">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="estado" id="estadoActivo"
                                            value="activo" checked>
                                        <label class="form-check-label" for="estadoActivo">
                                            <span class="badge badge-estado badge-activo">
                                                <i class="bi bi-check-circle"></i> Activo
                                            </span>
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="estado"
                                            id="estadoInactivo" value="inactivo">
                                        <label class="form-check-label" for="estadoInactivo">
                                            <span class="badge badge-estado badge-inactivo">
                                                <i class="bi bi-pause-circle"></i> Inactivo
                                            </span>
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="estado"
                                            id="estadoSuspendido" value="suspendido">
                                        <label class="form-check-label" for="estadoSuspendido">
                                            <span class="badge badge-estado badge-suspendido">
                                                <i class="bi bi-x-circle"></i> Suspendido
                                            </span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="bi bi-x-circle"></i> Cancelar
                        </button>
                        <button type="submit" class="btn btn-primary" id="btnGuardar">
                            <i class="bi bi-check-circle"></i> Guardar Usuario
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Ver Usuario -->
    <div class="modal fade" id="modalVerUsuario" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="bi bi-eye"></i> Detalles del Usuario
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="user-header-info">
                                <div class="user-avatar">
                                    <img src="https://ui-avatars.com/api/?name=Usuario&background=0ea5e9&color=fff"
                                        alt="Usuario" id="verAvatar">
                                </div>
                                <div>
                                    <h3 id="verNombreCompleto"></h3>
                                    <p class="text-muted mb-2" id="verEmail"></p>
                                    <div id="verRolBadge"></div>
                                </div>
                                <div class="ms-auto">
                                    <span id="verEstadoBadge"></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="mb-3"><i class="bi bi-geo-alt text-primary"></i> Ubicación</h6>
                            <div class="detail-row">
                                <strong>Ciudad:</strong>
                                <span id="verCiudad"></span>
                            </div>
                            <div class="detail-row">
                                <strong>Barrio:</strong>
                                <span id="verBarrio"></span>
                            </div>
                            <div class="detail-row">
                                <strong>Dirección 1:</strong>
                                <span id="verDireccion1"></span>
                            </div>
                            <div class="detail-row">
                                <strong>Dirección 2:</strong>
                                <span id="verDireccion2"></span>
                            </div>
                            <div class="detail-row">
                                <strong>Dirección 3:</strong>
                                <span id="verDireccion3"></span>
                            </div>
                            <div class="detail-row">
                                <strong>Dirección 4:</strong>
                                <span id="verDireccion4"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h6 class="mb-3"><i class="bi bi-telephone text-primary"></i> Teléfonos</h6>
                            <div id="verTelefonosList"></div>

                            <h6 class="mt-4 mb-3"><i class="bi bi-shield-lock text-primary"></i> Permisos</h6>
                            <div id="verPermisosList"></div>

                            <h6 class="mt-4 mb-3"><i class="bi bi-clock text-primary"></i> Información del Sistema</h6>
                            <div class="detail-row">
                                <strong>Fecha de registro:</strong>
                                <span id="verFechaRegistro"></span>
                            </div>
                            <div class="detail-row">
                                <strong>Último acceso:</strong>
                                <span id="verUltimoAcceso"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-warning" id="btnRolesPermisos">
                        <i class="bi bi-shield-lock"></i> Roles y Permisos
                    </button>
                    <button type="button" class="btn btn-primary" id="btnEditarDesdeVer">
                        <i class="bi bi-pencil"></i> Editar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Roles y Permisos -->
    <div class="modal fade" id="modalRolesPermisos" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="bi bi-shield-lock"></i> Administración de Roles y Permisos
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="formRolesPermisos">
                    <div class="modal-body">
                        <input type="hidden" id="rolUsuarioId" name="usuario_id">

                        <div class="alert alert-info">
                            <i class="bi bi-info-circle"></i>
                            Usuario: <strong id="nombreUsuarioRol"></strong>
                        </div>

                        <!-- Roles -->
                        <div class="section-header">
                            <i class="bi bi-person-badge"></i>
                            <h6>Rol del Usuario</h6>
                        </div>

                        <div class="roles-grid mb-4">
                            <div class="role-card">
                                <input type="radio" class="form-check-input" name="roles[]" id="rolAdministrador"
                                    value="administrador">
                                <label for="rolAdministrador" class="role-label">
                                    <i class="bi bi-star-fill text-warning"></i>
                                    <strong>Administrador</strong>
                                    <small>Acceso total al sistema</small>
                                </label>
                            </div>
                            <div class="role-card">
                                <input type="radio" class="form-check-input" name="roles[]" id="rolCliente"
                                    value="cliente" checked>
                                <label for="rolCliente" class="role-label">
                                    <i class="bi bi-person-fill text-primary"></i>
                                    <strong>Cliente</strong>
                                    <small>Acceso de cliente</small>
                                </label>
                            </div>
                            <div class="role-card">
                                <input type="radio" class="form-check-input" name="roles[]" id="rolVendedor"
                                    value="vendedor">
                                <label for="rolVendedor" class="role-label">
                                    <i class="bi bi-cart-fill text-success"></i>
                                    <strong>Vendedor</strong>
                                    <small>Gestión de ventas</small>
                                </label>
                            </div>
                            <div class="role-card">
                                <input type="radio" class="form-check-input" name="roles[]" id="rolTecnico"
                                    value="tecnico">
                                <label for="rolTecnico" class="role-label">
                                    <i class="bi bi-tools text-info"></i>
                                    <strong>Técnico</strong>
                                    <small>Soporte técnico</small>
                                </label>
                            </div>
                        </div>

                        <!-- Permisos -->
                        <div class="section-header">
                            <i class="bi bi-key"></i>
                            <h6>Permisos Específicos</h6>
                            <div class="form-check form-switch ms-auto">
                                <input class="form-check-input" type="checkbox" id="toggleTodosPermisos">
                                <label class="form-check-label" for="toggleTodosPermisos">Seleccionar todos</label>
                            </div>
                        </div>

                        <div class="permisos-container">
                            <!-- Usuarios -->
                            <div class="permiso-module">
                                <h6><i class="bi bi-people"></i> Usuarios</h6>
                                <div class="permisos-grid">
                                    <div class="form-check">
                                        <input class="form-check-input permiso-checkbox" type="checkbox"
                                            name="permisos[]" value="usuarios.ver" id="permUsuariosVer">
                                        <label class="form-check-label" for="permUsuariosVer">
                                            <i class="bi bi-eye"></i> Ver
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input permiso-checkbox" type="checkbox"
                                            name="permisos[]" value="usuarios.crear" id="permUsuariosCrear">
                                        <label class="form-check-label" for="permUsuariosCrear">
                                            <i class="bi bi-plus-circle"></i> Crear
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input permiso-checkbox" type="checkbox"
                                            name="permisos[]" value="usuarios.editar" id="permUsuariosEditar">
                                        <label class="form-check-label" for="permUsuariosEditar">
                                            <i class="bi bi-pencil"></i> Editar
                                        </label>
                                    </div>
                                    <div class="form-check permiso-danger">
                                        <input class="form-check-input permiso-checkbox" type="checkbox"
                                            name="permisos[]" value="usuarios.eliminar" id="permUsuariosEliminar">
                                        <label class="form-check-label" for="permUsuariosEliminar">
                                            <i class="bi bi-trash"></i> Eliminar
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <!-- Categorías -->
                            <div class="permiso-module">
                                <h6><i class="bi bi-grid"></i> Categorías</h6>
                                <div class="permisos-grid">
                                    <div class="form-check">
                                        <input class="form-check-input permiso-checkbox" type="checkbox"
                                            name="permisos[]" value="categorias.ver" id="permCategoriasVer">
                                        <label class="form-check-label" for="permCategoriasVer">
                                            <i class="bi bi-eye"></i> Ver
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input permiso-checkbox" type="checkbox"
                                            name="permisos[]" value="categorias.crear" id="permCategoriasCrear">
                                        <label class="form-check-label" for="permCategoriasCrear">
                                            <i class="bi bi-plus-circle"></i> Crear
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input permiso-checkbox" type="checkbox"
                                            name="permisos[]" value="categorias.editar" id="permCategoriasEditar">
                                        <label class="form-check-label" for="permCategoriasEditar">
                                            <i class="bi bi-pencil"></i> Editar
                                        </label>
                                    </div>
                                    <div class="form-check permiso-danger">
                                        <input class="form-check-input permiso-checkbox" type="checkbox"
                                            name="permisos[]" value="categorias.eliminar" id="permCategoriasEliminar">
                                        <label class="form-check-label" for="permCategoriasEliminar">
                                            <i class="bi bi-trash"></i> Eliminar
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <!-- Materiales -->
                            <div class="permiso-module">
                                <h6><i class="bi bi-box-seam"></i> Materiales</h6>
                                <div class="permisos-grid">
                                    <div class="form-check">
                                        <input class="form-check-input permiso-checkbox" type="checkbox"
                                            name="permisos[]" value="materiales.ver" id="permMaterialesVer">
                                        <label class="form-check-label" for="permMaterialesVer">
                                            <i class="bi bi-eye"></i> Ver
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input permiso-checkbox" type="checkbox"
                                            name="permisos[]" value="materiales.crear" id="permMaterialesCrear">
                                        <label class="form-check-label" for="permMaterialesCrear">
                                            <i class="bi bi-plus-circle"></i> Crear
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input permiso-checkbox" type="checkbox"
                                            name="permisos[]" value="materiales.editar" id="permMaterialesEditar">
                                        <label class="form-check-label" for="permMaterialesEditar">
                                            <i class="bi bi-pencil"></i> Editar
                                        </label>
                                    </div>
                                    <div class="form-check permiso-danger">
                                        <input class="form-check-input permiso-checkbox" type="checkbox"
                                            name="permisos[]" value="materiales.eliminar" id="permMaterialesEliminar">
                                        <label class="form-check-label" for="permMaterialesEliminar">
                                            <i class="bi bi-trash"></i> Eliminar
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <!-- Productos -->
                            <div class="permiso-module">
                                <h6><i class="bi bi-archive"></i> Productos</h6>
                                <div class="permisos-grid">
                                    <div class="form-check">
                                        <input class="form-check-input permiso-checkbox" type="checkbox"
                                            name="permisos[]" value="productos.ver" id="permProductosVer">
                                        <label class="form-check-label" for="permProductosVer">
                                            <i class="bi bi-eye"></i> Ver
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input permiso-checkbox" type="checkbox"
                                            name="permisos[]" value="productos.crear" id="permProductosCrear">
                                        <label class="form-check-label" for="permProductosCrear">
                                            <i class="bi bi-plus-circle"></i> Crear
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input permiso-checkbox" type="checkbox"
                                            name="permisos[]" value="productos.editar" id="permProductosEditar">
                                        <label class="form-check-label" for="permProductosEditar">
                                            <i class="bi bi-pencil"></i> Editar
                                        </label>
                                    </div>
                                    <div class="form-check permiso-danger">
                                        <input class="form-check-input permiso-checkbox" type="checkbox"
                                            name="permisos[]" value="productos.eliminar" id="permProductosEliminar">
                                        <label class="form-check-label" for="permProductosEliminar">
                                            <i class="bi bi-trash"></i> Eliminar
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <!-- Cotizaciones -->
                            <div class="permiso-module">
                                <h6><i class="bi bi-file-text"></i> Cotizaciones</h6>
                                <div class="permisos-grid">
                                    <div class="form-check">
                                        <input class="form-check-input permiso-checkbox" type="checkbox"
                                            name="permisos[]" value="cotizaciones.ver" id="permCotizacionesVer">
                                        <label class="form-check-label" for="permCotizacionesVer">
                                            <i class="bi bi-eye"></i> Ver
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input permiso-checkbox" type="checkbox"
                                            name="permisos[]" value="cotizaciones.crear" id="permCotizacionesCrear">
                                        <label class="form-check-label" for="permCotizacionesCrear">
                                            <i class="bi bi-plus-circle"></i> Crear
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input permiso-checkbox" type="checkbox"
                                            name="permisos[]" value="cotizaciones.editar" id="permCotizacionesEditar">
                                        <label class="form-check-label" for="permCotizacionesEditar">
                                            <i class="bi bi-pencil"></i> Editar
                                        </label>
                                    </div>
                                    <div class="form-check permiso-danger">
                                        <input class="form-check-input permiso-checkbox" type="checkbox"
                                            name="permisos[]" value="cotizaciones.eliminar"
                                            id="permCotizacionesEliminar">
                                        <label class="form-check-label" for="permCotizacionesEliminar">
                                            <i class="bi bi-trash"></i> Eliminar
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="alert alert-warning mt-3">
                            <i class="bi bi-exclamation-triangle"></i>
                            <strong>Importante:</strong> Los permisos de eliminación son críticos. Asegúrese de otorgarlos
                            solo a usuarios de confianza.
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="bi bi-x-circle"></i> Cancelar
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle"></i> Guardar Cambios
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Confirmar Eliminar -->
    <div class="modal fade" id="modalEliminar" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h5 class="modal-title text-danger">
                        <i class="bi bi-exclamation-triangle"></i> Confirmar Eliminación
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>¿Está seguro que desea eliminar al usuario <strong id="eliminarNombre"></strong>?</p>
                    <p class="text-muted small">Esta acción no se puede deshacer y se eliminarán todos los datos asociados.
                    </p>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-danger" id="btnConfirmarEliminar">
                        <i class="bi bi-trash"></i> Eliminar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Cambiar Estado -->
    <div class="modal fade" id="modalCambiarEstado" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="bi bi-toggle-on"></i> Cambiar Estado del Usuario
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="formCambiarEstado">
                    <div class="modal-body">
                        <input type="hidden" id="estadoUsuarioId">

                        <p>Usuario: <strong id="estadoNombreUsuario"></strong></p>
                        <p>Estado actual: <span id="estadoActualUsuario"></span></p>

                        <label class="form-label mt-3">Nuevo Estado:</label>
                        <div class="estado-options">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="nuevo_estado"
                                    id="nuevoEstadoActivo" value="activo">
                                <label class="form-check-label" for="nuevoEstadoActivo">
                                    <span class="badge badge-estado badge-activo">
                                        <i class="bi bi-check-circle"></i> Activo
                                    </span>
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="nuevo_estado"
                                    id="nuevoEstadoInactivo" value="inactivo">
                                <label class="form-check-label" for="nuevoEstadoInactivo">
                                    <span class="badge badge-estado badge-inactivo">
                                        <i class="bi bi-pause-circle"></i> Inactivo
                                    </span>
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="nuevo_estado"
                                    id="nuevoEstadoSuspendido" value="suspendido">
                                <label class="form-check-label" for="nuevoEstadoSuspendido">
                                    <span class="badge badge-estado badge-suspendido">
                                        <i class="bi bi-x-circle"></i> Suspendido
                                    </span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle"></i> Cambiar Estado
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
