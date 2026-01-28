<?php

use App\Http\Controllers\CategoriaController;
use Illuminate\Support\Facades\Route;

Route::get('/', [CategoriaController::class, 'index'])->name('index');
Route::get('/banner', [CategoriaController::class, 'banner'])->name('banner');
Route::get('/listado', [CategoriaController::class, 'listado'])->name('listado');
Route::post('/crear', [CategoriaController::class, 'store'])->name('store');
Route::get('/ver/{categoria}', [CategoriaController::class, 'show'])->name('show');
Route::get('/editar/{categoria}', [CategoriaController::class, 'edit'])->name('edit');
Route::post('/actualizar/{categoria}', [CategoriaController::class, 'update'])->name('update');
Route::get('/data/{categoria}', [CategoriaController::class, 'data'])->name('data');
Route::delete('/eliminar/{categoria}', [CategoriaController::class, 'delete'])->name('delete');
