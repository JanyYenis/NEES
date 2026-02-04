<?php

namespace App\Http\Controllers;

use App\Exceptions\ErrorException;
use App\Models\Categoria;
use App\Models\Imagen;
use App\Models\Producto;
use App\Models\ProductoMaterial;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ProductoController extends Controller
{
    public function index(Request $request)
    {
        $info['categorias'] = Categoria::where('estado', Categoria::ACTIVO)->get();

        return view('productos.index', $info);
    }

    public function banner(Request $request)
    {
        $info['cantidad_total'] = Producto::count();
        $info['cantidad_activas'] = Producto::where('estado', Producto::ACTIVO)
            ->count();
        $info['cantidad_inactivos'] = Producto::where('estado', Producto::INACTIVO)
            ->count();
        $info['cantidad_categorias'] = Categoria::where('estado', Categoria::ACTIVO)->count();

        return [
            'estado' => 'success',
            'mensaje' => 'Se cargo la información correctamente.',
            'info' => $info
        ];
    }

    public function listado(Request $request)
    {
        $productos = Producto::with(
            'infoEstado',
            'categoria',
            'imagenesActivas',
        )->where('estado', '!=', Producto::ELIMINADO)
        ->orderByDesc('created_at');

        return DataTables::eloquent($productos)
            ->addColumn("estado", function ($model) {
                $info['concepto'] = $model?->infoEstado;
                return view("sistema.estado", $info);
            })
            ->addColumn("categoria", "productos.columnas.categorias")
            ->addColumn("imagen", function ($model) {
                $info['imagenes'] = $model?->imagenesActivas ?? [];
                $info['nombre'] = $model?->nombre;
                return view("sistema.imagen", $info);
            })
            ->addColumn("medidas", "productos.columnas.medidas")
            ->addColumn("action", "productos.columnas.acciones")
            ->rawColumns(["action", "categoria", "medidas"])
            ->make(true);
    }

    public function store(Request $request)
    {
        $datos = $request->all();
        $producto = Producto::create($datos);

        if (!$producto) {
            throw new ErrorException('Error al intentar crear la nueva producto.');
        }

        $producto->refresh();

        // Verifica el ID
        if (empty($producto->id)) {
            throw new ErrorException("El producto no tiene un ID asignado.");
        }

        if (count($request->input('materiales'))) {
            foreach ($request->input('materiales') as $key => $value) {
                ProductoMaterial::updateOrCreate([
                    'cod_producto' => $producto->id,
                    'cod_material' => $value,
                ], [
                    'estado' => ProductoMaterial::ACTIVO,
                ]);
            }
        }

        if ($request->hasFile('imagenes')) {
            foreach ($request->imagenes as $index => $imagen) {
                // Inactivar imagen actual de esa posición
                $producto->imagenes()
                    ->where('orden', $index+1)
                    ->update(['estado' => Imagen::INACTIVO]);

                $ruta = $imagen->store('productos', 'public');

                $producto->crearImagen([
                    'url' => $ruta,
                    'tipo' => Imagen::PRODUCTOS,
                    'orden' => $index+1,
                    'estado' => Imagen::ACTIVO,
                ]);
            }
        }

        return [
            'estado' => 'success',
            'mensaje' => 'Se creo correctamente la producto.',
        ];
    }

    public function show(Request $request, Producto $producto)
    {
        $producto->load(
            'infoEstado',
            'infoTipo',
            'imagenesActivas',
        );

        $info["producto"] = $producto;

        $respuesta["estado"] = "success";
        $respuesta["mensaje"] = "Datos cargados correctamente";
        $respuesta['html'] = view("productos.modals.secciones.ver", $info)->render();

        return response()->json($respuesta);
    }

    public function edit(Request $request, Producto $producto)
    {
        $producto->load(
            'infoEstado',
            'imagenesActivas',
        );

        $info["producto"] = $producto;
        $info["tipos"] = Producto::darTipo();

        $respuesta["estado"] = "success";
        $respuesta["mensaje"] = "Datos cargados correctamente";
        $respuesta['html'] = view("productos.modals.secciones.editar", $info)->render();

        return response()->json($respuesta);
    }

    public function update(Request $request, Producto $producto)
    {
        $datos = $request->except(['imagen_1', 'imagen_2']);
        $actualizar = $producto->update($datos);

        if (!$actualizar) {
            throw new ErrorException('Error al intentar actualizar la producto.');
        }

        foreach ([1, 2] as $posicion) {
            $campo = "imagen_{$posicion}";

            if ($request->hasFile($campo)) {

                // Inactivar imagen actual de esa posición
                $producto->imagenes()
                    ->where('orden', $posicion)
                    ->update(['estado' => Imagen::INACTIVO]);

                $archivo = $request->file($campo);
                $ruta = $archivo->store('productos', 'public');

                $producto->crearImagen([
                    'url' => $ruta,
                    'tipo' => Imagen::PRODUCTOS,
                    'orden' => $posicion,
                    'estado' => Imagen::ACTIVO,
                ]);
            }
        }

        return [
            'estado' => 'success',
            'mensaje' => 'Se actualizo correctamente la producto.',
        ];
    }

    public function data(Request $request, producto $producto)
    {
        $producto->load(
            'infoEstado',
            'imagenActiva'
        );

        return [
            'estado' => 'success',
            'mesnaje' => 'Datos cargados correctamente.',
            'producto' => $producto
        ];
    }

    public function delete(Request $request, Producto $producto)
    {
        $eliminar = $producto->eliminar();

        if (!$eliminar) {
            throw new ErrorException('A ocurrido un error al intentar eliminar la producto.');
        }

        return [
            'estado' => 'success',
            'mensaje' => 'Se eliminado correctamente la producto.',
        ];
    }
}
