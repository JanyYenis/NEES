// Product data
const products = {
    "puerta-industrial-001": {
        title: "Puerta Industrial Moderna",
        subtitle: "Diseño industrial con máxima seguridad y acabados premium",
        category: "Puertas Metálicas",
        code: "PM-001",
        height: "2.10 m",
        width: "0.90 m",
        depth: "0.05 m",
        description:
            "Puerta metálica de diseño industrial moderno, fabricada con acero estructural de alta calidad. Perfecta para espacios comerciales e industriales que buscan combinar seguridad con estética contemporánea. Incluye sistema de cerradura multipunto y acabado resistente a la intemperie.",
        materials: [
            "Acero estructural calibre 14",
            "Acabado en pintura electrostática",
            "Herrajes de alta resistencia",
            "Sistema de cerradura multipunto",
        ],
        images: [
            "public/modern-industrial-metal-door-in-architectural-sett.jpg",
            "public/modern-metal-door-industrial-design.jpg",
            "public/modern-sliding-metal-door.jpg",
            "public/modern-sliding-metal-door-close-up.jpg",
        ],
        relatedProducts: ["ventana-industrial-001", "porton-automatico-001", "escalera-flotante-001"],
    },
    "ventana-industrial-001": {
        title: "Ventana Industrial de Acero",
        subtitle: "Elegancia industrial con acabados de alta calidad",
        category: "Ventanas",
        code: "VI-001",
        height: "1.50 m",
        width: "1.20 m",
        depth: "0.08 m",
        description:
            "Ventana de acero con diseño industrial moderno. Perfil robusto con acabado en pintura de alta resistencia. Ideal para proyectos arquitectónicos que buscan un estilo contemporáneo con referencias industriales.",
        materials: [
            "Perfiles de acero estructural",
            "Vidrio templado de 6mm",
            "Acabado en pintura horneable",
            "Herrajes de acero inoxidable",
        ],
        images: [
            "public/industrial-steel-window.jpg",
            "public/modern-steel-windows-industrial.jpg",
            "public/industrial-steel-window-detail.jpg",
            "public/modern-steel-windows-industrial-style-architecture.jpg",
        ],
        relatedProducts: ["puerta-industrial-001", "porton-automatico-001", "barandal-vidrio-001"],
    },
    "porton-automatico-001": {
        title: "Portón Automático Moderno",
        subtitle: "Tecnología avanzada para acceso seguro y conveniente",
        category: "Portones",
        code: "PA-001",
        height: "2.50 m",
        width: "3.00 m",
        depth: "0.10 m",
        description:
            "Portón automático de diseño moderno con sistema de apertura motorizado. Fabricado con materiales de alta calidad y equipado con control remoto. Incluye sistema de seguridad con sensores de obstáculos.",
        materials: [
            "Estructura de acero galvanizado",
            "Motor automático de 1HP",
            "Control remoto de largo alcance",
            "Sensores de seguridad",
        ],
        images: [
            "public/automatic-metal-gate.jpg",
            "public/automatic-metal-gate-modern.jpg",
            "public/automatic-metal-gate-open.jpg",
            "public/automatic-metal-gate-opening-mechanism.jpg",
        ],
        relatedProducts: ["puerta-industrial-001", "ventana-industrial-001", "reja-seguridad-001"],
    },
    "escalera-flotante-001": {
        title: "Escalera Flotante Minimalista",
        subtitle: "Estructuras modernas con diseño arquitectónico único",
        category: "Escaleras y Barandales",
        code: "EF-001",
        height: "3.00 m",
        width: "1.00 m",
        depth: "0.30 m",
        description:
            "Escalera flotante de diseño minimalista con estructura de acero. Peldaños empotrados en muro para crear efecto flotante. Acabado en pintura electrostática y opciones de barandal de vidrio o cable de acero.",
        materials: [
            "Estructura de acero de alta resistencia",
            "Peldaños de acero o madera",
            "Sistema de anclaje empotrado",
            "Acabado en pintura electrostática",
        ],
        images: [
            "public/floating-metal-staircase-modern.jpg",
            "public/modern-metal-staircase-and-railings-industrial-des.jpg",
            "public/floating-metal-staircase-side.jpg",
            "public/modern-metal-stairs-railings-industrial.jpg",
        ],
        relatedProducts: ["barandal-vidrio-001", "puerta-industrial-001", "ventana-industrial-001"],
    },
}

// Get product ID from URL
const urlParams = new URLSearchParams(window.location.search)
const productId = urlParams.get("id") || "puerta-industrial-001"

// Load product data
function loadProductData() {
    const product = products[productId]

    if (!product) {
        console.log("[v0] Product not found, loading default")
        window.location.href = "producto.html?id=puerta-industrial-001"
        return
    }

    // Update header
    document.getElementById("product-title").textContent = product.title
    document.getElementById("product-subtitle").textContent = product.subtitle
    document.getElementById("breadcrumb-category").textContent = product.category

    // Update product info
    document.getElementById("category").textContent = product.category
    document.getElementById("productCode").textContent = product.code
    document.getElementById("height").textContent = product.height
    document.getElementById("width").textContent = product.width
    document.getElementById("depth").textContent = product.depth
    document.getElementById("description").textContent = product.description

    // Update dimensions display
    document.getElementById("heightDisplay").textContent = product.height
    document.getElementById("widthDisplay").textContent = product.width

    // Update materials
    const materialsContainer = document.getElementById("materialsContainer")
    materialsContainer.innerHTML = product.materials
        .map(
            (material) => `
        <div class="material-item">
            <i class="bi bi-check-circle-fill text-primary"></i>
            <span>${material}</span>
        </div>
    `,
        )
        .join("")

    // Load gallery
    loadGallery(product.images)

    // Update modal product name
    document.getElementById("quoteProduct").value = product.title

    // Update after image for before/after slider
    document.getElementById("afterImage").src = product.images[0]

    // Load related products
    loadRelatedProducts(product.relatedProducts)

    console.log("[v0] Product data loaded:", product.title)
}

// Load gallery
function loadGallery(images) {
    const mainImage = document.getElementById("mainImage")
    mainImage.src = images[0]

    const thumbnailContainer = document.getElementById("thumbnailContainer")
    thumbnailContainer.innerHTML = images
        .map(
            (img, index) => `
        <div class="col-3">
            <img src="${img}"
                 class="img-fluid ${index === 0 ? "active" : ""}"
                 alt="Vista ${index + 1}"
                 onclick="changeMainImage('${img}', this)">
        </div>
    `,
        )
        .join("")
}

// Change main image
function changeMainImage(imageSrc, thumbnail) {
    document.getElementById("mainImage").src = imageSrc
    document.querySelectorAll(".thumbnails img").forEach((img) => {
        img.classList.remove("active")
    })
    thumbnail.classList.add("active")
}

// Open fullscreen image
function openFullscreen() {
    const mainImage = document.getElementById("mainImage")
    const fullscreenImage = document.getElementById("fullscreenImage")
    fullscreenImage.src = mainImage.src
    const modal = window.bootstrap.Modal.getOrCreateInstance(document.getElementById("fullscreenModal"))
    modal.show()
}

// Open 3D fullscreen
function open3DFullscreen() {
    alert("Funcionalidad de visor 3D en pantalla completa. Aquí se abriría el modelo 3D.")
}

// Before/After Slider
const beforeAfterSlider = document.getElementById("beforeAfterSlider")
if (beforeAfterSlider) {
    beforeAfterSlider.addEventListener("input", function () {
        const value = this.value
        const afterImage = document.querySelector(".after-image")
        const sliderButton = document.querySelector(".slider-button")

        afterImage.style.clipPath = `polygon(0 0, ${value}% 0, ${value}% 100%, 0 100%)`
        sliderButton.style.left = `${value}%`
    })
}

// Color swatches
document.querySelectorAll(".color-swatch").forEach((swatch) => {
    swatch.addEventListener("click", function () {
        document.querySelectorAll(".color-swatch").forEach((s) => s.classList.remove("active"))
        this.classList.add("active")
        document.getElementById("selectedColor").textContent = this.getAttribute("data-color")
    })
})

// 3D Viewer lighting toggle
const lightingToggle = document.getElementById("lightingToggle")
if (lightingToggle) {
    lightingToggle.addEventListener("click", function () {
        this.classList.toggle("btn-outline-light")
        this.classList.toggle("btn-light")
        console.log("[v0] 3D lighting toggled")
    })
}

// Load related products
function loadRelatedProducts(relatedIds) {
    const container = document.getElementById("relatedProductsContainer")

    container.innerHTML = relatedIds
        .slice(0, 4)
        .map((id) => {
            const product = products[id]
            return `
            <div class="col-md-6 col-lg-3">
                <div class="product-card" onclick="window.location.href='producto.html?id=${id}'">
                    <div class="product-image-wrapper">
                        <img src="${product.images[0]}" class="product-image-main" alt="${product.title}">
                        <img src="${product.images[1]}" class="product-image-hover" alt="${product.title}">
                        <span class="badge-3d">
                            <i class="bi bi-box"></i> Vista 3D
                        </span>
                    </div>
                    <div class="product-card-body">
                        <h5 class="product-title">${product.title}</h5>
                        <p class="product-category">${product.category}</p>
                    </div>
                </div>
            </div>
        `
        })
        .join("")
}

// Submit quote
function submitQuote() {
    const name = document.getElementById("quoteName").value
    const phone = document.getElementById("quotePhone").value
    const city = document.getElementById("quoteCity").value
    const product = document.getElementById("quoteProduct").value

    if (!name || !phone || !city) {
        alert("Por favor complete todos los campos requeridos.")
        return
    }

    console.log("[v0] Quote submitted:", { name, phone, city, product })

    // Here you would normally send the data to a server
    alert(
        `¡Gracias ${name}! Hemos recibido tu solicitud de cotización para ${product}. Te contactaremos pronto al ${phone}.`,
    )

    // Close modal
    const modal = window.bootstrap.Modal.getOrCreateInstance(document.getElementById("quoteModal"))
    modal.hide()

    // Reset form
    document.getElementById("quoteForm").reset()
    document.getElementById("quoteProduct").value = product
}

// Initialize page
document.addEventListener("DOMContentLoaded", () => {
    // loadProductData()
    console.log("[v0] Product page initialized")
})

// Navbar scroll effect (same as main.js)
window.addEventListener("scroll", () => {
    const navbar = document.querySelector(".navbar")
    if (window.scrollY > 50) {
        navbar.style.background = "rgba(10, 10, 10, 0.98)"
        navbar.style.boxShadow = "0 2px 10px rgba(0, 0, 0, 0.5)"
    } else {
        navbar.style.background = "rgba(10, 10, 10, 0.95)"
        navbar.style.boxShadow = "none"
    }
})

$(document).on('click', '.openFullscreen', function(){
    openFullscreen();
});

$(document).on('click', '.open3DFullscreen', function(){
    open3DFullscreen();
});

$(document).on('click', '.changeMainImage', function(){
    changeMainImage($(this).attr('src'), this);
});
