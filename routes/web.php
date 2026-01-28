<?php

use App\Models\Categoria;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $info['categorias'] = Categoria::where('estado', Categoria::ACTIVO)->get();

    return view('welcome', $info);
});

Route::get('/detalle', function () {
    return view('detalle');
})->name('detalle');

Route::get('/ver-productos', function () {
    return view('productos');
})->name('ver-productos');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('paises')
    ->as("paises.")
    ->middleware(['web'])
    ->group(base_path('routes/web/paises/principal.php'));

Route::prefix('ciudades')
    ->as("ciudades.")
    ->middleware(['web'])
    ->group(base_path('routes/web/ciudades/principal.php'));

Route::prefix('usuarios')
    ->as("usuarios.")
    ->middleware(['web', 'auth'])
    ->group(base_path('routes/web/usuarios/principal.php'));

Route::prefix('categorias')
    ->as("categorias.")
    ->middleware(['web', 'auth'])
    ->group(base_path('routes/web/categorias/principal.php'));

Route::prefix('materiales')
    ->as("materiales.")
    ->middleware(['web', 'auth'])
    ->group(base_path('routes/web/materiales/principal.php'));

Route::prefix('productos')
    ->as("productos.")
    ->middleware(['web', 'auth'])
    ->group(base_path('routes/web/productos/principal.php'));

Route::prefix('cotizaciones')
    ->as("cotizaciones.")
    ->middleware(['web', 'auth'])
    ->group(base_path('routes/web/cotizaciones/principal.php'));

Route::prefix('pedidos')
    ->as("pedidos.")
    ->middleware(['web', 'auth'])
    ->group(base_path('routes/web/pedidos/principal.php'));
