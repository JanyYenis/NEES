<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Producto;
use Illuminate\Http\Request;

class PrincipalController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function listadoProductos(Request $request, Categoria $categoria)
    {
        $pagina = $request->pagina ?? 1;
        $cantidad = $request->cantidad_pagina ?? 6;
        $buscar = $request->buscar ?? '';
        $orden = $request->orden ?? 1;

        $productosQuery = Producto::where('cod_categoria', $categoria->id)
            ->where('estado', Producto::ACTIVO);

        if ($buscar) {
            $productosQuery = $productosQuery->whereRaw("nombre LIKE ?", ["%{$buscar}%"])
                ->orWhereRaw("descripcion LIKE ?", ["%{$buscar}%"]);
        }

        if ((int) $orden == 1) {
            $productosQuery = $productosQuery->orderByDesc('created_at');
        } else if ((int) $orden == 2) {
            $productosQuery = $productosQuery->orderBy('nombre');
        } else if ((int) $orden == 3) {
            $productosQuery = $productosQuery->orderByDesc('nombre');
        }

        $productos = $productosQuery->paginate($cantidad, ["*"], "productos", $pagina);
        $info['ultimaPagina'] = $productos->lastPage();
        $info["productos"] = $productos;
        $info["categoria"] = $categoria;
        $info['paginaActual'] = $pagina;

        return [
            "estado" => "success",
            "html" => view("listado", $info)->render()
        ];
    }
}
