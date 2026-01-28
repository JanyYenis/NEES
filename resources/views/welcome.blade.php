@extends('layouts.app')

@section('content')
    <!-- Hero Carousel -->
    <section id="inicio" class="hero-section">
        <div id="heroCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="5000">
            <div class="carousel-indicators">
                @foreach ($categorias as $index => $item)
                    <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="{{ $index }}" class="{{ !$index ? 'active' : '' }}"></button>
                @endforeach
            </div>
            <div class="carousel-inner">
                @foreach ($categorias as $index => $item)
                    <div class="carousel-item {{ !$index ? 'active' : '' }}">
                        <img src="{{ asset('storage/'. $item?->imagenActiva?->url) }}" class="d-block w-100" alt="Puertas Metálicas">
                        <div class="carousel-overlay"></div>
                        <div class="blueprint-grid"></div>
                        <div class="carousel-caption">
                            <h1 class="display-3 fw-bold mb-3">{{ $item?->nombre ?? '' }}</h1>
                            <p class="lead mb-4">{{ $item?->descripcion ?? '' }}</p>
                            <a href="{{ route('ver-productos') }}" class="btn btn-primary btn-lg">Ver Catálogo</a>
                        </div>
                    </div>
                @endforeach
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon"></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon"></span>
            </button>
        </div>
    </section>

    <!-- Featured Products -->
    <section id="productos" class="py-5">
        <div class="container py-5">
            <div class="text-center mb-5">
                <h2 class="display-5 fw-bold mb-3">Productos Destacados</h2>
                <p class="lead text-white-50">Estructuras metálicas de alta calidad para todo tipo de proyectos</p>
            </div>

            <div class="row g-4">
                <!-- Product 1 -->
                <div class="col-md-6 col-lg-3">
                    <div class="product-card" onclick="window.location.href='producto.html?id=puerta-industrial-001'">
                        <div class="product-image-wrapper">
                            <img src="{{ asset('build/img/modern-industrial-metal-door-in-architectural-sett.jpg') }}" class="product-image-main" alt="Puerta Industrial Moderna">
                            <img src="{{ asset('build/img/modern-metal-door-industrial-design.jpg') }}" class="product-image-hover" alt="Puerta Industrial Vista 2">
                            <span class="badge-3d">
                                <i class="bi bi-box"></i> Vista 3D
                            </span>
                        </div>
                        <div class="product-card-body">
                            <h5 class="product-title">Puerta Industrial Moderna</h5>
                            <p class="product-category">Puertas Metálicas</p>
                            <div class="product-features">
                                <span class="feature-badge"><i class="bi bi-shield-check"></i> Alta Seguridad</span>
                                <span class="feature-badge"><i class="bi bi-wrench"></i> Personalizable</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Product 2 -->
                <div class="col-md-6 col-lg-3">
                    <div class="product-card" onclick="window.location.href='producto.html?id=ventana-industrial-001'">
                        <div class="product-image-wrapper">
                            <img src="{{ asset('build/img/industrial-steel-window.jpg') }}" class="product-image-main" alt="Ventana de Acero Industrial">
                            <img src="{{ asset('build/img/modern-steel-windows-industrial.jpg') }}" class="product-image-hover" alt="Ventana Industrial Vista 2">
                            <span class="badge-3d">
                                <i class="bi bi-box"></i> Vista 3D
                            </span>
                        </div>
                        <div class="product-card-body">
                            <h5 class="product-title">Ventana Industrial de Acero</h5>
                            <p class="product-category">Ventanas</p>
                            <div class="product-features">
                                <span class="feature-badge"><i class="bi bi-sun"></i> Alta Iluminación</span>
                                <span class="feature-badge"><i class="bi bi-gear"></i> Acabado Premium</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Product 3 -->
                <div class="col-md-6 col-lg-3">
                    <div class="product-card" onclick="window.location.href='producto.html?id=porton-automatico-001'">
                        <div class="product-image-wrapper">
                            <img src="{{ asset('build/img/automatic-metal-gate.jpg') }}" class="product-image-main" alt="Portón Automático">
                            <img src="{{ asset('build/img/automatic-metal-gate-modern.jpg') }}" class="product-image-hover" alt="Portón Automático Vista 2">
                            <span class="badge-3d">
                                <i class="bi bi-box"></i> Vista 3D
                            </span>
                        </div>
                        <div class="product-card-body">
                            <h5 class="product-title">Portón Automático Moderno</h5>
                            <p class="product-category">Portones</p>
                            <div class="product-features">
                                <span class="feature-badge"><i class="bi bi-cpu"></i> Automático</span>
                                <span class="feature-badge"><i class="bi bi-phone"></i> Control Remoto</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Product 4 -->
                <div class="col-md-6 col-lg-3">
                    <div class="product-card" onclick="window.location.href='producto.html?id=escalera-flotante-001'">
                        <div class="product-image-wrapper">
                            <img src="{{ asset('build/img/floating-metal-staircase-modern.jpg') }}" class="product-image-main" alt="Escalera Flotante">
                            <img src="{{ asset('build/img/modern-metal-staircase-and-railings-industrial-des.jpg') }}" class="product-image-hover" alt="Escalera Flotante Vista 2">
                            <span class="badge-3d">
                                <i class="bi bi-box"></i> Vista 3D
                            </span>
                        </div>
                        <div class="product-card-body">
                            <h5 class="product-title">Escalera Flotante Minimalista</h5>
                            <p class="product-category">Escaleras y Barandales</p>
                            <div class="product-features">
                                <span class="feature-badge"><i class="bi bi-rulers"></i> Diseño Único</span>
                                <span class="feature-badge"><i class="bi bi-check-circle"></i> Resistente</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Custom Fabrication -->
    <section id="fabricacion" class="fabrication-section py-5">
        <div class="container py-5">
            <div class="text-center mb-5">
                <h2 class="display-5 fw-bold mb-3 text-white">Fabricación a Medida</h2>
                <p class="lead text-white-50">Diseñamos y fabricamos estructuras metálicas personalizadas según tus necesidades</p>
            </div>

            <div class="row g-4">
                <div class="col-md-6 col-lg-3">
                    <div class="fabrication-card">
                        <div class="fabrication-icon">
                            <i class="bi bi-rulers"></i>
                        </div>
                        <h5 class="mt-3">Diseño Personalizado</h5>
                        <p class="text-white-50">Creamos diseños únicos adaptados a tu espacio y estilo</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="fabrication-card">
                        <div class="fabrication-icon">
                            <i class="bi bi-hammer"></i>
                        </div>
                        <h5 class="mt-3">Fabricación Experta</h5>
                        <p class="text-white-50">Más de 15 años de experiencia en estructuras metálicas</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="fabrication-card">
                        <div class="fabrication-icon">
                            <i class="bi bi-truck"></i>
                        </div>
                        <h5 class="mt-3">Instalación Profesional</h5>
                        <p class="text-white-50">Instalación garantizada por nuestro equipo técnico</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="fabrication-card">
                        <div class="fabrication-icon">
                            <i class="bi bi-shield-check"></i>
                        </div>
                        <h5 class="mt-3">Garantía de Calidad</h5>
                        <p class="text-white-50">Productos certificados con garantía extendida</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
