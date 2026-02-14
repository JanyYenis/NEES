const seccionListadoProductos = ".seccionListadoProductos";
const btnPagina = ".btnPagina";
const rutaCargarListadoProductos = "listado-productos";
var paginaActual = 1;

// Category Page JavaScript

document.addEventListener('DOMContentLoaded', function() {
    // Initialize page
    // initCategoryPage();
    cargarListado();
});

$(document).on("click", btnPagina, function () {
    let pagina = $(this).attr("data-pagina");
    if (pagina) {
        cargarListado(pagina);
    }
});

window.cargarListado = (pagina = 1) => {
    generalidades.mostrarCargando(seccionListadoProductos);
    let datos = new FormData();
    datos = generalidades.formToJson(datos);
    datos.pagina = pagina;
    datos.categoria = window.categoria.id;
    const ruta = route(rutaCargarListadoProductos, datos);
    generalidades.refrescarSeccion(null, ruta, seccionListadoProductos, function (response) {
        generalidades.ocultarCargando(seccionListadoProductos);
        paginaActual = pagina;
        KTMenu.createInstances();
    });
}

// Categories Data (simulated - would come from Laravel)
const categoriesData = {
    'puertas': {
        title: 'Puertas Metalicas',
        description: 'Disenos industriales con maxima seguridad y acabados premium. Fabricacion a medida para todo tipo de proyectos residenciales y comerciales.',
        image: 'public/modern-industrial-metal-door-in-architectural-sett.jpg'
    },
    'ventanas': {
        title: 'Ventanas',
        description: 'Ventanas de acero con diseno industrial moderno. Alta durabilidad y acabados elegantes para cualquier espacio.',
        image: 'public/industrial-steel-window.jpg'
    },
    'portones': {
        title: 'Portones Automaticos',
        description: 'Sistemas automatizados de alta tecnologia. Seguridad y comodidad para residencias y comercios.',
        image: 'public/automatic-metal-gate.jpg'
    },
    'escaleras': {
        title: 'Escaleras y Barandales',
        description: 'Estructuras flotantes y disenos arquitectonicos unicos. Elegancia y resistencia en cada pieza.',
        image: 'public/floating-metal-staircase-modern.jpg'
    },
    'rejas': {
        title: 'Rejas de Seguridad',
        description: 'Proteccion maxima con disenos modernos que complementan la estetica de tu propiedad.',
        image: 'public/modern-security-metal-grill-geometric-pattern.jpg'
    }
};

// Products Data (simulated - would come from Laravel)
const productsData = [
    {
        id: 'puerta-industrial-001',
        name: 'Puerta Industrial Moderna',
        description: 'Puerta metalica de diseno industrial con acabado en pintura electrostatica y sistema de cerradura multipunto.',
        image: 'public/modern-industrial-metal-door-in-architectural-sett.jpg',
        category: 'puertas',
        color: 'negro',
        has3D: true,
        isNew: true,
        colorHex: '#1a1a1a',
        date: '2025-01-15'
    },
    {
        id: 'puerta-corrediza-002',
        name: 'Puerta Corrediza Premium',
        description: 'Sistema corredizo de alta resistencia con rieles de acero inoxidable y acabado mate.',
        image: 'public/modern-sliding-metal-door.jpg',
        category: 'puertas',
        color: 'gris',
        has3D: true,
        isNew: false,
        colorHex: '#4a4a4a',
        date: '2025-01-10'
    },
    {
        id: 'puerta-pivotante-003',
        name: 'Puerta Pivotante Elegante',
        description: 'Diseno minimalista con sistema pivotante oculto. Ideal para entradas principales.',
        image: 'public/modern-metal-door-industrial-design.jpg',
        category: 'puertas',
        color: 'plateado',
        has3D: false,
        isNew: true,
        colorHex: '#c0c0c0',
        date: '2025-01-20'
    },
    {
        id: 'puerta-seguridad-004',
        name: 'Puerta de Alta Seguridad',
        description: 'Estructura reforzada con triple sistema de cierre y acabado resistente a impactos.',
        image: 'public/modern-sliding-metal-door-side-view.jpg',
        category: 'puertas',
        color: 'negro',
        has3D: true,
        isNew: false,
        colorHex: '#1a1a1a',
        date: '2025-01-05'
    },
    {
        id: 'ventana-industrial-001',
        name: 'Ventana Industrial de Acero',
        description: 'Ventana estilo industrial con perfiles de acero y vidrio templado de seguridad.',
        image: 'public/industrial-steel-window.jpg',
        category: 'ventanas',
        color: 'negro',
        has3D: true,
        isNew: false,
        colorHex: '#1a1a1a',
        date: '2025-01-12'
    },
    {
        id: 'ventana-panoramica-002',
        name: 'Ventana Panoramica',
        description: 'Diseno de grandes dimensiones para maxima iluminacion natural.',
        image: 'public/modern-steel-windows-industrial.jpg',
        category: 'ventanas',
        color: 'gris',
        has3D: false,
        isNew: true,
        colorHex: '#4a4a4a',
        date: '2025-01-18'
    },
    {
        id: 'porton-automatico-001',
        name: 'Porton Automatico Premium',
        description: 'Sistema automatizado con motor silencioso y control remoto integrado.',
        image: 'public/automatic-metal-gate.jpg',
        category: 'portones',
        color: 'negro',
        has3D: true,
        isNew: false,
        colorHex: '#1a1a1a',
        date: '2025-01-08'
    },
    {
        id: 'porton-corredizo-002',
        name: 'Porton Corredizo Industrial',
        description: 'Sistema corredizo de gran capacidad para accesos vehiculares amplios.',
        image: 'public/automatic-metal-gate-modern.jpg',
        category: 'portones',
        color: 'gris',
        has3D: true,
        isNew: true,
        colorHex: '#4a4a4a',
        date: '2025-01-22'
    },
    {
        id: 'escalera-flotante-001',
        name: 'Escalera Flotante Minimalista',
        description: 'Diseno contemporaneo con peldanos flotantes y estructura oculta.',
        image: 'public/floating-metal-staircase-modern.jpg',
        category: 'escaleras',
        color: 'negro',
        has3D: true,
        isNew: true,
        colorHex: '#1a1a1a',
        date: '2025-01-25'
    },
    {
        id: 'barandal-vidrio-002',
        name: 'Barandal con Vidrio Templado',
        description: 'Combinacion elegante de acero y vidrio para maxima visibilidad.',
        image: 'public/modern-glass-steel-railing.jpg',
        category: 'escaleras',
        color: 'plateado',
        has3D: false,
        isNew: false,
        colorHex: '#c0c0c0',
        date: '2025-01-03'
    },
    {
        id: 'reja-geometrica-001',
        name: 'Reja Geometrica Moderna',
        description: 'Patrones geometricos unicos que combinan seguridad con estetica contemporanea.',
        image: 'public/modern-security-metal-grill-geometric-pattern.jpg',
        category: 'rejas',
        color: 'negro',
        has3D: false,
        isNew: true,
        colorHex: '#1a1a1a',
        date: '2025-01-17'
    },
    {
        id: 'reja-clasica-002',
        name: 'Reja de Seguridad Clasica',
        description: 'Diseno tradicional con acabados modernos para proteccion confiable.',
        image: 'public/modern-security-metal-grill.jpg',
        category: 'rejas',
        color: 'blanco',
        has3D: false,
        isNew: false,
        colorHex: '#f5f5f5',
        date: '2025-01-02'
    }
];

// State
let currentCategory = 'puertas';
let currentFilters = {
    search: '',
    color: 'all',
    sort: 'recent'
};
let currentPage = 1;
const itemsPerPage = 8;
let currentView = 'grid';

// Initialize Category Page
function initCategoryPage() {
    // Get category from URL
    const urlParams = new URLSearchParams(window.location.search);
    const cat = urlParams.get('cat');
    if (cat && categoriesData[cat]) {
        currentCategory = cat;
    }

    // Update header
    updateCategoryHeader();

    // Load products
    loadProducts();

    // Setup event listeners
    setupEventListeners();

    // Setup navbar scroll behavior
    setupNavbarScroll();
}

// Update Category Header
function updateCategoryHeader() {
    const category = categoriesData[currentCategory];

    document.getElementById('categoryTitle').textContent = category.title;
    document.getElementById('categoryDescription').textContent = category.description;
    document.getElementById('breadcrumbCategory').textContent = category.title;
    document.getElementById('heroBgImage').style.backgroundImage = `url(${category.image})`;

    // Update page title
    document.title = `${category.title} | MetalWorks - Catalogo de Estructuras Metalicas`;

    // Update product count
    const filteredProducts = getFilteredProducts();
    document.getElementById('productCount').textContent = `${filteredProducts.length} Productos`;
}

// Get Filtered Products
function getFilteredProducts() {
    let products = productsData.filter(p => p.category === currentCategory);

    // Apply search filter
    if (currentFilters.search) {
        const searchTerm = currentFilters.search.toLowerCase();
        products = products.filter(p =>
            p.name.toLowerCase().includes(searchTerm) ||
            p.description.toLowerCase().includes(searchTerm)
        );
    }

    // Apply color filter
    if (currentFilters.color !== 'all') {
        products = products.filter(p => p.color === currentFilters.color);
    }

    // Apply sorting
    switch (currentFilters.sort) {
        case 'name-asc':
            products.sort((a, b) => a.name.localeCompare(b.name));
            break;
        case 'name-desc':
            products.sort((a, b) => b.name.localeCompare(a.name));
            break;
        case 'recent':
        default:
            products.sort((a, b) => new Date(b.date) - new Date(a.date));
            break;
    }

    return products;
}

// Load Products
function loadProducts() {
    const products = getFilteredProducts();
    const container = document.getElementById('productsContainer');
    const emptyState = document.getElementById('emptyState');
    const paginationWrapper = document.getElementById('paginationWrapper');

    // Update counts
    const totalProducts = products.length;
    const startIndex = (currentPage - 1) * itemsPerPage;
    const endIndex = Math.min(startIndex + itemsPerPage, totalProducts);
    const paginatedProducts = products.slice(startIndex, endIndex);

    document.getElementById('showingCount').textContent = paginatedProducts.length;
    document.getElementById('totalCount').textContent = totalProducts;
    document.getElementById('productCount').textContent = `${totalProducts} Productos`;

    // Show empty state if no products
    if (totalProducts === 0) {
        container.innerHTML = '';
        emptyState.style.display = 'block';
        paginationWrapper.style.display = 'none';
        return;
    }

    emptyState.style.display = 'none';
    paginationWrapper.style.display = 'block';

    // Update view class
    container.classList.toggle('list-view', currentView === 'list');

    // Generate product cards
    container.innerHTML = paginatedProducts.map(product => `
        <div class="product-card" onclick="goToProduct('${product.id}')">
            <div class="product-image-wrapper">
                <img src="${product.image}" alt="${product.name}" class="product-image"
                     onerror="this.parentElement.innerHTML='<div class=\\'placeholder-image\\'><i class=\\'bi bi-image\\'></i></div>'">

                <div class="product-badges">
                    ${product.has3D ? '<span class="badge-3d"><i class="bi bi-box"></i> 3D</span>' : ''}
                    ${product.isNew ? '<span class="badge-new">Nuevo</span>' : ''}
                </div>

                <span class="badge-color" style="background-color: ${product.colorHex};" title="${product.color}"></span>

                <div class="product-overlay">
                    <button class="btn-view-details">
                        <i class="bi bi-eye me-2"></i>Ver Detalles
                    </button>
                </div>
            </div>
            <div class="product-card-body">
                <h5 class="product-title">${product.name}</h5>
                <p class="product-description">${product.description}</p>
                <div class="product-meta">
                    <span class="product-category-badge">${categoriesData[product.category].title}</span>
                    <button class="btn-card-action" onclick="event.stopPropagation(); requestQuote('${product.id}')">
                        <i class="bi bi-file-text me-1"></i>Cotizar
                    </button>
                </div>
            </div>
        </div>
    `).join('');

    // Update pagination
    updatePagination(totalProducts);
}

// Update Pagination
function updatePagination(totalItems) {
    const totalPages = Math.ceil(totalItems / itemsPerPage);
    const pagination = document.getElementById('pagination');

    if (totalPages <= 1) {
        pagination.innerHTML = '';
        return;
    }

    let html = '';

    // Previous button
    html += `
        <li class="page-item ${currentPage === 1 ? 'disabled' : ''}">
            <a class="page-link" href="#" onclick="changePage(${currentPage - 1}); return false;">
                <i class="bi bi-chevron-left"></i>
            </a>
        </li>
    `;

    // Page numbers
    const maxVisiblePages = 5;
    let startPage = Math.max(1, currentPage - Math.floor(maxVisiblePages / 2));
    let endPage = Math.min(totalPages, startPage + maxVisiblePages - 1);

    if (endPage - startPage + 1 < maxVisiblePages) {
        startPage = Math.max(1, endPage - maxVisiblePages + 1);
    }

    if (startPage > 1) {
        html += `<li class="page-item"><a class="page-link" href="#" onclick="changePage(1); return false;">1</a></li>`;
        if (startPage > 2) {
            html += `<li class="page-item disabled"><span class="page-link">...</span></li>`;
        }
    }

    for (let i = startPage; i <= endPage; i++) {
        html += `
            <li class="page-item ${i === currentPage ? 'active' : ''}">
                <a class="page-link" href="#" onclick="changePage(${i}); return false;">${i}</a>
            </li>
        `;
    }

    if (endPage < totalPages) {
        if (endPage < totalPages - 1) {
            html += `<li class="page-item disabled"><span class="page-link">...</span></li>`;
        }
        html += `<li class="page-item"><a class="page-link" href="#" onclick="changePage(${totalPages}); return false;">${totalPages}</a></li>`;
    }

    // Next button
    html += `
        <li class="page-item ${currentPage === totalPages ? 'disabled' : ''}">
            <a class="page-link" href="#" onclick="changePage(${currentPage + 1}); return false;">
                <i class="bi bi-chevron-right"></i>
            </a>
        </li>
    `;

    pagination.innerHTML = html;
}

// Change Page
function changePage(page) {
    const totalPages = Math.ceil(getFilteredProducts().length / itemsPerPage);
    if (page < 1 || page > totalPages) return;

    currentPage = page;
    loadProducts();

    // Smooth scroll to products section
    document.querySelector('.products-section').scrollIntoView({ behavior: 'smooth', block: 'start' });
}

// Setup Event Listeners
function setupEventListeners() {
    // Search input
    const searchInput = document.getElementById('searchInput');
    const clearSearch = document.getElementById('clearSearch');
    let searchTimeout;

    searchInput.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        const value = this.value.trim();

        clearSearch.style.display = value ? 'block' : 'none';

        searchTimeout = setTimeout(() => {
            currentFilters.search = value;
            currentPage = 1;
            loadProducts();
            updateActiveFilters();
        }, 300);
    });

    clearSearch.addEventListener('click', function() {
        searchInput.value = '';
        currentFilters.search = '';
        this.style.display = 'none';
        currentPage = 1;
        loadProducts();
        updateActiveFilters();
    });

    // Filter options
    document.querySelectorAll('.filter-option').forEach(option => {
        option.addEventListener('click', function(e) {
            e.preventDefault();
            const filter = this.dataset.filter;
            const value = this.dataset.value;

            currentFilters[filter] = value;
            currentPage = 1;

            // Update active state
            this.closest('.dropdown-menu').querySelectorAll('.filter-option').forEach(opt => {
                opt.classList.remove('active');
            });
            this.classList.add('active');

            loadProducts();
            updateActiveFilters();
        });
    });

    // Sort options
    document.querySelectorAll('.sort-option').forEach(option => {
        option.addEventListener('click', function(e) {
            e.preventDefault();
            currentFilters.sort = this.dataset.sort;
            currentPage = 1;

            // Update active state
            document.querySelectorAll('.sort-option').forEach(opt => {
                opt.classList.remove('active');
            });
            this.classList.add('active');

            loadProducts();
        });
    });

    // View toggle
    document.querySelectorAll('.btn-view').forEach(btn => {
        btn.addEventListener('click', function() {
            currentView = this.dataset.view;

            document.querySelectorAll('.btn-view').forEach(b => b.classList.remove('active'));
            this.classList.add('active');

            loadProducts();
        });
    });

    // Clear all filters
    document.getElementById('clearAllFilters').addEventListener('click', function() {
        currentFilters = {
            search: '',
            color: 'all',
            sort: 'recent'
        };
        currentPage = 1;

        // Reset UI
        searchInput.value = '';
        clearSearch.style.display = 'none';

        document.querySelectorAll('.filter-option').forEach(opt => {
            opt.classList.remove('active');
            if (opt.dataset.value === 'all') opt.classList.add('active');
        });

        document.querySelectorAll('.sort-option').forEach(opt => {
            opt.classList.remove('active');
            if (opt.dataset.sort === 'recent') opt.classList.add('active');
        });

        loadProducts();
        updateActiveFilters();
    });
}

// Update Active Filters Display
function updateActiveFilters() {
    const container = document.getElementById('activeFilters');
    const tagsContainer = document.getElementById('activeFiltersTags');

    const hasFilters = currentFilters.search || currentFilters.color !== 'all';

    if (!hasFilters) {
        container.style.display = 'none';
        return;
    }

    container.style.display = 'flex';

    let tags = '';

    if (currentFilters.search) {
        tags += `
            <span class="filter-tag">
                <i class="bi bi-search"></i>
                "${currentFilters.search}"
                <button class="btn-remove-tag" onclick="removeFilter('search')">
                    <i class="bi bi-x"></i>
                </button>
            </span>
        `;
    }

    if (currentFilters.color !== 'all') {
        const colorNames = {
            'negro': 'Negro',
            'gris': 'Gris Oscuro',
            'plateado': 'Plateado',
            'blanco': 'Blanco'
        };
        tags += `
            <span class="filter-tag">
                <i class="bi bi-palette"></i>
                ${colorNames[currentFilters.color]}
                <button class="btn-remove-tag" onclick="removeFilter('color')">
                    <i class="bi bi-x"></i>
                </button>
            </span>
        `;
    }

    tagsContainer.innerHTML = tags;
}

// Remove Filter
function removeFilter(filter) {
    if (filter === 'search') {
        currentFilters.search = '';
        document.getElementById('searchInput').value = '';
        document.getElementById('clearSearch').style.display = 'none';
    } else if (filter === 'color') {
        currentFilters.color = 'all';
        document.querySelectorAll('.filter-option[data-filter="color"]').forEach(opt => {
            opt.classList.remove('active');
            if (opt.dataset.value === 'all') opt.classList.add('active');
        });
    }

    currentPage = 1;
    loadProducts();
    updateActiveFilters();
}

// Go to Product Detail
function goToProduct(productId) {
    window.location.href = `producto.html?id=${productId}`;
}

// Request Quote
function requestQuote(productId) {
    // Open quote modal or redirect to quote page
    window.location.href = `producto.html?id=${productId}#quote`;
}

// Setup Navbar Scroll Behavior
function setupNavbarScroll() {
    const navbar = document.querySelector('.navbar');

    window.addEventListener('scroll', function() {
        if (window.scrollY > 50) {
            navbar.style.background = 'rgba(10, 10, 10, 0.98)';
            navbar.style.boxShadow = '0 2px 20px rgba(0, 0, 0, 0.3)';
        } else {
            navbar.style.background = 'rgba(10, 10, 10, 0.95)';
            navbar.style.boxShadow = 'none';
        }
    });
}

// Make functions globally available
window.changePage = changePage;
window.goToProduct = goToProduct;
window.requestQuote = requestQuote;
window.removeFilter = removeFilter;
