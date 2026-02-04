<?php

use App\Http\Controllers\ProductoController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ProductoController::class, 'index'])->name('index');
Route::get('/banner', [ProductoController::class, 'banner'])->name('banner');
Route::get('/listado', [ProductoController::class, 'listado'])->name('listado');
Route::post('/crear', [ProductoController::class, 'store'])->name('store');
Route::get('/ver/{producto}', [ProductoController::class, 'show'])->name('show');
Route::get('/editar/{producto}', [ProductoController::class, 'edit'])->name('edit');
Route::post('/actualizar/{producto}', [ProductoController::class, 'update'])->name('update');
Route::get('/data/{producto}', [ProductoController::class, 'data'])->name('data');
Route::delete('/eliminar/{producto}', [ProductoController::class, 'delete'])->name('delete');
