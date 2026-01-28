<div class="sidebar" id="sidebar">
    <a href="{{ url('/') }}">
        <div class="sidebar-header">
            <div class="logo-admin">
                <img src="{{ asset('build/img/logo.png') }}" width="100%">
            </div>
            <h4>NEES</h4>
        </div>
    </a>

    <ul class="sidebar-menu">
        <li class="active">
            <a href="{{ route('home') }}">
                <i class="bi bi-speedometer2"></i>
                <span>Dashboard</span>
            </a>
        </li>
        <li>
            <a disabled href="{{ route('usuarios.index') }}">
                <i class="bi bi-people"></i>
                <span>Usuarios / Clientes</span>
            </a>
        </li>
        <li>
            <a href="{{ route('categorias.index') }}">
                <i class="bi bi-grid"></i>
                <span>Categorías</span>
            </a>
        </li>
        <li>
            <a href="{{ route('materiales.index') }}">
                <i class="bi bi-box-seam"></i>
                <span>Materiales</span>
            </a>
        </li>
        <li>
            <a href="{{ route('productos.index') }}">
                <i class="bi bi-archive"></i>
                <span>Productos</span>
            </a>
        </li>
        <li>
            <a href="{{ route('cotizaciones.index') }}">
                <i class="bi bi-file-text"></i>
                <span>Cotizaciones</span>
            </a>
        </li>
        <li>
            <a href="{{ route('pedidos.index') }}">
                <i class="bi bi-box"></i>
                <span>Pedidos</span>
            </a>
        </li>
    </ul>
</div>
