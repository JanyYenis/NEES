<?php

namespace App\Http\Controllers;

use App\Exceptions\ErrorException;
use App\Models\Categoria;
use App\Models\Imagen;
use App\Models\Producto;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CategoriaController extends Controller
{
    public function index(Request $request)
    {
        return view('categorias.index');
    }

    public function banner(Request $request)
    {
        $info['cantidad_total'] = Categoria::count();
        $info['cantidad_activas'] = Categoria::where('estado', Categoria::ACTIVO)
            ->count();
        $info['cantidad_inactivos'] = Categoria::where('estado', Categoria::INACTIVO)
            ->count();
        $info['cantidad_productos'] = Producto::where('estado', Producto::INACTIVO)
            ->count();

        return [
            'estado' => 'success',
            'mensaje' => 'Se cargo la información correctamente.',
            'info' => $info
        ];
    }

    public function listado(Request $request)
    {
        $categorias = Categoria::with(
            'infoEstado',
            'imagenActiva',
            'productosActivos',
        )->where('estado', '!=', Categoria::ELIMINADO)
        ->orderByDesc('created_at');

        return DataTables::eloquent($categorias)
            ->addColumn("productos", 'categorias.columnas.productos')
            ->addColumn("estado", function ($model) {
                $info['concepto'] = $model?->infoEstado;
                return view("sistema.estado", $info);
            })
            ->addColumn("imagen", function ($model) {
                $info['imagen'] = $model?->imagenActiva?->url ?? '#';
                $info['nombre'] = $model?->nombre;
                return view("sistema.imagen", $info);
            })
            ->addColumn("action", "categorias.columnas.acciones")
            ->rawColumns(["action", "productos"])
            ->make(true);
    }

    public function store(Request $request)
    {
        $datos = $request->all();
        $categoria = Categoria::create($datos);

        if (!$categoria) {
            throw new ErrorException('Error al intentar crear la nueva categoria.');
        }

        if ($request->hasFile('imagen')) {
            $path = $request->file('imagen')->store('categorias', 'public');

            $categoria->crearImagen([
                'url' => $path,
                'tipo' => Imagen::CATEGORIAS,
            ]);
        }

        return [
            'estado' => 'success',
            'mensaje' => 'Se creo correctamente la categoria.',
        ];
    }

    public function show(Request $request, Categoria $categoria)
    {
        $categoria->load(
            'infoEstado',
            'imagenActiva',
            'productosActivos',
        );

        $info["categoria"] = $categoria;

        $respuesta["estado"] = "success";
        $respuesta["mensaje"] = "Datos cargados correctamente";
        $respuesta['html'] = view("categorias.modals.secciones.ver", $info)->render();

        return response()->json($respuesta);
    }

    public function edit(Request $request, Categoria $categoria)
    {
        $categoria->load(
            'infoEstado',
            'imagenActiva',
            'productosActivos',
        );

        $info["categoria"] = $categoria;

        $respuesta["estado"] = "success";
        $respuesta["mensaje"] = "Datos cargados correctamente";
        $respuesta['html'] = view("categorias.modals.secciones.editar", $info)->render();

        return response()->json($respuesta);
    }

    public function update(Request $request, Categoria $categoria)
    {
        $datos = $request->all();
        $actualizar = $categoria->update($datos);

        if (!$actualizar) {
            throw new ErrorException('Error al intentar actualizar la categoria.');
        }

        if ($request->hasFile('imagen')) {

            $categoria->inactivarImagenes();

            $path = $request->file('imagen')->store('categorias', 'public');

            $categoria->crearImagen([
                'url' => $path,
                'tipo' => Imagen::CATEGORIAS,
            ]);
        }

        return [
            'estado' => 'success',
            'mensaje' => 'Se actualizo correctamente la categoria.',
        ];
    }

    public function data(Request $request, Categoria $categoria)
    {
        $categoria->load(
            'infoEstado',
            'imagenActiva',
            'productosActivos',
        );

        return [
            'estado' => 'success',
            'mesnaje' => 'Datos cargados correctamente.',
            'categoria' => $categoria
        ];
    }

    public function delete(Request $request, Categoria $categoria)
    {
        $eliminar = $categoria->eliminar();

        if (!$eliminar) {
            throw new ErrorException('A ocurrido un error al intentar eliminar la categoria.');
        }

        return [
            'estado' => 'success',
            'mensaje' => 'Se eliminado correctamente la categoria.',
        ];
    }
}
