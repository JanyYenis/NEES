<?php

use App\Http\Controllers\ProductoController;
use Illuminate\Support\Facades\Route;

Route::get('/', function()
{
    return view('cotizaciones.index');
})->name('index');
