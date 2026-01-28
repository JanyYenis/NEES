<?php

use App\Http\Controllers\MaterialController;
use Illuminate\Support\Facades\Route;

Route::get('/', [MaterialController::class, 'index'])->name('index');
Route::get('/banner', [MaterialController::class, 'banner'])->name('banner');
Route::get('/listado', [MaterialController::class, 'listado'])->name('listado');
Route::post('/crear', [MaterialController::class, 'store'])->name('store');
Route::get('/ver/{material}', [MaterialController::class, 'show'])->name('show');
Route::get('/editar/{material}', [MaterialController::class, 'edit'])->name('edit');
Route::post('/actualizar/{material}', [MaterialController::class, 'update'])->name('update');
Route::get('/data/{material}', [MaterialController::class, 'data'])->name('data');
Route::delete('/eliminar/{material}', [MaterialController::class, 'delete'])->name('delete');
