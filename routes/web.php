<?php

use App\Models\Categoria;
use App\Models\Producto;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('/', function () {
    $info['categorias'] = Categoria::where('estado', Categoria::ACTIVO)->get();
    $info['productos'] = Producto::where('estado', Producto::ACTIVO)
        ->latest()
        ->take(4)
        ->get();

    return view('welcome', $info);
});

Route::get('/detalle/{producto}', function (Request $request, Producto $producto) {
    $info['producto'] = $producto;
    $info['productos_relacionados'] = Producto::where('estado', Producto::ACTIVO)
        ->where('cod_categoria', $producto->cod_categoria)
        ->whereNot('id', $producto->id)
        ->latest()
        ->take(4)
        ->get();
    return view('detalle', $info);
})->name('detalle');

Route::get('/ver-productos', function () {
    return view('productos');
})->name('ver-productos');

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
