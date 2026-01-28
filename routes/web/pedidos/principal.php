<?php

use App\Http\Controllers\ProductoController;
use Illuminate\Support\Facades\Route;

Route::get('/', function()
{
    return view('pedidos.index');
})->name('index');
