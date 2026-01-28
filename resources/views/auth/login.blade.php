{{-- @extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Login') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

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
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
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
    @vite(['resources/css/login.css', 'resources/js/login.js'])
@endsection

@section('content')
    <!-- Login Container -->
    <div class="login-container">
        <div class="blueprint-grid-bg"></div>

        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-5 col-lg-4">
                    <div class="login-card" style="margin-top: 2.5rem;">
                        <!-- Card Header -->
                        <div class="login-header text-center">
                            <div class="login-icon">
                                <i class="bi bi-person-circle"></i>
                            </div>
                            <h2 class="fw-bold mt-3 mb-2">Iniciar Sesión</h2>
                            <p class="text-white-50">Accede a tu cuenta de MetalWorks</p>
                        </div>

                        <!-- Login Form -->
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <!-- Email Input -->
                            <div class="form-group mb-4">
                                <label for="email" class="form-label">Correo Electrónico</label>
                                <div class="input-wrapper">
                                    <span class="input-icon">
                                        <i class="bi bi-envelope"></i>
                                    </span>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        name="email" value="{{ old('email') }}" required
                                        autocomplete="email" autofocus id="email"
                                        placeholder="correo@ejemplo.com">

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror

                                    <div class="input-line"></div>
                                </div>
                                <div class="error-message" id="emailError"></div>
                            </div>

                            <!-- Password Input -->
                            <div class="form-group mb-4">
                                <label for="password" class="form-label">Contraseña</label>
                                <div class="input-wrapper">
                                    <span class="input-icon">
                                        <i class="bi bi-lock"></i>
                                    </span>
                                    <input
                                        type="password"
                                        class="form-control @error('password') is-invalid @enderror"
                                        name="password" autocomplete="current-password"
                                        id="password"
                                        placeholder="Ingresa tu contraseña"
                                        required
                                    >
                                    <button
                                        type="button"
                                        class="password-toggle"
                                        id="togglePassword"
                                        aria-label="Mostrar contraseña"
                                    >
                                        <i class="bi bi-eye"></i>
                                    </button>
                                    <div class="input-line"></div>
                                </div>

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                                <div class="error-message" id="passwordError"></div>
                            </div>

                            <!-- Remember Me & Forgot Password -->
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <div class="form-check">
                                    <input
                                        class="form-check-input"
                                        type="checkbox"
                                        id="rememberMe"
                                        name="remember" {{ old('remember') ? 'checked' : '' }}
                                    >
                                    <label class="form-check-label" for="rememberMe">
                                        Recordarme
                                    </label>
                                </div>
                                <a href="{{ route('password.request') }}" class="forgot-link">
                                    ¿Olvidaste tu contraseña?
                                </a>
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" class="btn btn-login w-100">
                                <span class="btn-text">Iniciar Sesión</span>
                                <span class="btn-loader d-none">
                                    <span class="spinner-border spinner-border-sm me-2"></span>
                                    Ingresando...
                                </span>
                            </button>
                        </form>

                        <!-- Divider -->
                        <div class="login-divider">
                            <span>o</span>
                        </div>

                        <!-- Social Login -->
                        <div class="social-login">
                            <button type="button" class="btn btn-social">
                                <i class="bi bi-google me-2"></i>
                                Continuar con Google
                            </button>
                        </div>

                        <!-- Register Link -->
                        <div class="text-center mt-4">
                            <p class="mb-0 text-white-50">
                                ¿No tienes cuenta?
                                <a href="{{ route('register') }}" class="register-link">Regístrate</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
