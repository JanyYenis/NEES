{{-- @extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection --}}

@extends('layouts.app')

@section('imports')
    @vite(['resources/css/registro.css', 'resources/js/registro.js'])
@endsection

@section('content')
    <!-- Blueprint Grid Background -->
    <div class="blueprint-grid-bg"></div>

    <!-- Registration Container -->
    <div class="register-container" style="margin-top: 1rem;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10 col-xl-9">
                    <!-- Registration Card -->
                    <div class="register-card">
                        <!-- Header -->
                        <div class="register-header text-center">
                            <div class="register-icon">
                                <i class="fas fa-user-plus"></i>
                            </div>
                            <h2 class="mt-3 mb-2 fw-bold">Crear una Cuenta</h2>
                            <p class="text-white-50">Completa el formulario para registrarte</p>
                        </div>

                        <!-- Progress Indicator -->
                        <div class="progress-indicator mb-4">
                            <div class="progress-step active" data-step="1">
                                <div class="step-number">1</div>
                                <div class="step-label">Datos Personales</div>
                            </div>
                            <div class="progress-line"></div>
                            <div class="progress-step" data-step="2">
                                <div class="step-number">2</div>
                                <div class="step-label">Ubicación</div>
                            </div>
                            <div class="progress-line"></div>
                            <div class="progress-step" data-step="3">
                                <div class="step-number">3</div>
                                <div class="step-label">Teléfonos</div>
                            </div>
                            <div class="progress-line"></div>
                            <div class="progress-step" data-step="4">
                                <div class="step-number">4</div>
                                <div class="step-label">Seguridad</div>
                            </div>
                        </div>

                        <!-- Registration Form -->
                        <form id="registerForm" novalidate>
                            <!-- Step 1: Personal Data -->
                            <div class="form-section active" data-section="1">
                                <div class="section-header">
                                    <i class="fas fa-user section-icon"></i>
                                    <h4 class="mb-4">Datos Personales</h4>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="nombre" class="form-label">
                                            Nombre <span class="text-danger">*</span>
                                        </label>
                                        <div class="input-wrapper">
                                            <i class="fas fa-user input-icon"></i>
                                            <input type="text" class="form-control" id="nombre"
                                                placeholder="Ingresa tu nombre" name="nombre" required />
                                            <div class="input-line"></div>
                                        </div>
                                        <div class="error-message">Por favor ingresa tu nombre</div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="apellido" class="form-label">
                                            Apellido <span class="text-danger">*</span>
                                        </label>
                                        <div class="input-wrapper">
                                            <i class="fas fa-user input-icon"></i>
                                            <input type="text" class="form-control" id="apellido"
                                                placeholder="Ingresa tu apellido" name="apellido" required />
                                            <div class="input-line"></div>
                                        </div>
                                        <div class="error-message">Por favor ingresa tu apellido</div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">
                                        Correo Electrónico <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-wrapper">
                                        <i class="fas fa-envelope input-icon"></i>
                                        <input type="email" class="form-control" id="email"
                                            placeholder="correo@ejemplo.com" name="email" required />
                                        <div class="input-line"></div>
                                    </div>
                                    <div class="error-message">Por favor ingresa un correo válido</div>
                                </div>
                                <div class="d-flex justify-content-end">
                                    <button type="button" class="btn btn-next" data-next="2">
                                        Siguiente <i class="fas fa-arrow-right ms-2"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- Step 2: Location -->
                            <div class="form-section" data-section="2">
                                <div class="section-header">
                                    <i class="fas fa-map-marker-alt section-icon"></i>
                                    <h4 class="mb-4">Ubicación</h4>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="codCiudad" class="form-label">
                                            Ciudad
                                            <i class="fas fa-info-circle text-info ms-1" data-bs-toggle="tooltip"
                                                title="Código postal o identificador de tu ciudad"></i>
                                        </label>
                                        <div class="input-wrapper">
                                            <i class="fas fa-city input-icon"></i>
                                            <select name="cod_ciudad" class="form-control" id="selectCiudad">
                                                <option value=""></option>
                                            </select>
                                            <div class="input-line"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="barrio" class="form-label">Barrio</label>
                                        <div class="input-wrapper">
                                            <i class="fas fa-home input-icon"></i>
                                            <input type="text" class="form-control" id="barrio"
                                                placeholder="Nombre del barrio" name="barrio"/>
                                            <div class="input-line"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="direccion1" class="form-label">
                                        Dirección Principal <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-wrapper">
                                        <i class="fas fa-map-marked-alt input-icon"></i>
                                        <input type="text" class="form-control" id="direccion1"
                                            placeholder="Calle, Número, etc." name="direccion_1" required />
                                        <div class="input-line"></div>
                                    </div>
                                    <div class="error-message">Por favor ingresa una dirección</div>
                                </div>

                                <!-- Additional Addresses (Progressive) -->
                                <div id="additionalAddresses">
                                    <div class="mb-3 address-field" id="direccion2-field" style="display: none">
                                        <label for="direccion2" class="form-label">Dirección Adicional 2</label>
                                        <div class="input-wrapper">
                                            <i class="fas fa-map-marked-alt input-icon"></i>
                                            <input type="text" class="form-control" id="direccion2"
                                                placeholder="Otra dirección" />
                                            <div class="input-line"></div>
                                        </div>
                                    </div>
                                    <div class="mb-3 address-field" id="direccion3-field" style="display: none">
                                        <label for="direccion3" class="form-label">Dirección Adicional 3</label>
                                        <div class="input-wrapper">
                                            <i class="fas fa-map-marked-alt input-icon"></i>
                                            <input type="text" class="form-control" id="direccion3"
                                                placeholder="Otra dirección" />
                                            <div class="input-line"></div>
                                        </div>
                                    </div>
                                    <div class="mb-3 address-field" id="direccion4-field" style="display: none">
                                        <label for="direccion4" class="form-label">Dirección Adicional 4</label>
                                        <div class="input-wrapper">
                                            <i class="fas fa-map-marked-alt input-icon"></i>
                                            <input type="text" class="form-control" id="direccion4"
                                                placeholder="Otra dirección" />
                                            <div class="input-line"></div>
                                        </div>
                                    </div>
                                </div>

                                <button type="button" class="btn btn-outline-primary btn-sm mb-3 d-none" disabled
                                    id="addAddressBtn">
                                    <i class="fas fa-plus me-2"></i>Agregar otra dirección
                                </button>

                                <div class="d-flex justify-content-between">
                                    <button type="button" class="btn btn-prev" data-prev="1">
                                        <i class="fas fa-arrow-left me-2"></i> Anterior
                                    </button>
                                    <button type="button" class="btn btn-next" data-next="3">
                                        Siguiente <i class="fas fa-arrow-right ms-2"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- Step 3: Phones -->
                            <div class="form-section" data-section="3">
                                <div class="section-header">
                                    <i class="fas fa-phone section-icon"></i>
                                    <h4 class="mb-4">Números de Teléfono</h4>
                                </div>

                                <div id="phoneList">
                                    <div class="phone-row mb-3">
                                        <label class="form-label">
                                            Teléfono Principal <span class="text-danger">*</span>
                                        </label>
                                        <div class="input-wrapper phone-input-group">
                                            {{-- <i class="fas fa-phone input-icon"></i> --}}
                                            <input type="tel" class="form-control phone-input" id="tel"
                                                placeholder="300 123 4567" name="telefono" required />
                                            <div class="input-line"></div>
                                        </div>
                                        <div class="error-message">Por favor ingresa un teléfono válido</div>
                                    </div>
                                </div>

                                <button type="button" class="btn btn-outline-primary btn-sm mb-3 d-none" disabled
                                    id="addPhoneBtn">
                                    <i class="fas fa-plus me-2"></i>Agregar otro número
                                </button>

                                <div class="d-flex justify-content-between">
                                    <button type="button" class="btn btn-prev" data-prev="2">
                                        <i class="fas fa-arrow-left me-2"></i> Anterior
                                    </button>
                                    <button type="button" class="btn btn-next" data-next="4">
                                        Siguiente <i class="fas fa-arrow-right ms-2"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- Step 4: Security -->
                            <div class="form-section" data-section="4">
                                <div class="section-header">
                                    <i class="fas fa-lock section-icon"></i>
                                    <h4 class="mb-4">Seguridad</h4>
                                </div>

                                <div class="mb-3">
                                    <label for="password" class="form-label">
                                        Contraseña <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-wrapper">
                                        <i class="fas fa-lock input-icon"></i>
                                        <input type="password" class="form-control" id="password"
                                            placeholder="Ingresa tu contraseña" required name="password" />
                                        <button type="button" class="password-toggle" data-target="password">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <div class="input-line"></div>
                                    </div>

                                    <!-- Password Strength Indicator -->
                                    <div class="password-strength mt-2">
                                        <div class="strength-bar">
                                            <div class="strength-fill"></div>
                                        </div>
                                        <small class="strength-text">Fortaleza: <span>-</span></small>
                                    </div>

                                    <!-- Password Rules -->
                                    <div class="password-rules mt-2">
                                        <small class="rule" id="rule-length">
                                            <i class="fas fa-circle"></i> Mínimo 8 caracteres
                                        </small>
                                        <small class="rule" id="rule-uppercase">
                                            <i class="fas fa-circle"></i> Una letra mayúscula
                                        </small>
                                        <small class="rule" id="rule-lowercase">
                                            <i class="fas fa-circle"></i> Una letra minúscula
                                        </small>
                                        <small class="rule" id="rule-number">
                                            <i class="fas fa-circle"></i> Un número
                                        </small>
                                        <small class="rule" id="rule-special">
                                            <i class="fas fa-circle"></i> Un carácter especial
                                        </small>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label for="confirmPassword" class="form-label">
                                        Confirmar Contraseña <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-wrapper">
                                        <i class="fas fa-lock input-icon"></i>
                                        <input type="password" class="form-control" id="confirmPassword"
                                            placeholder="Confirma tu contraseña" required name="password_confirmation"/>
                                        <button type="button" class="password-toggle" data-target="confirmPassword">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <div class="input-line"></div>
                                    </div>
                                    <div class="error-message">Las contraseñas no coinciden</div>
                                </div>

                                <div class="form-check mb-4">
                                    <input class="form-check-input" type="checkbox" id="terms" required />
                                    <label class="form-check-label" for="terms">
                                        Acepto los
                                        <a href="#" class="text-primary">términos y condiciones</a> y la
                                        <a href="#" class="text-primary">política de privacidad</a>
                                    </label>
                                </div>

                                <div class="d-flex justify-content-between">
                                    <button type="button" class="btn btn-prev" data-prev="3">
                                        <i class="fas fa-arrow-left me-2"></i> Anterior
                                    </button>
                                    <button type="submit" class="btn btn-register">
                                        <i class="fas fa-check me-2"></i> Crear Cuenta
                                    </button>
                                </div>
                            </div>
                        </form>

                        <!-- Login Link -->
                        <div class="text-center mt-4">
                            <p class="text-white-50">
                                ¿Ya tienes una cuenta?
                                <a href="{{ route('login') }}" class="register-link">Inicia sesión aquí</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
