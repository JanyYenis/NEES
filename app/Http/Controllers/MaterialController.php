<?php

namespace App\Http\Controllers;

use App\Exceptions\ErrorException;
use App\Models\Imagen;
use App\Models\Material;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class MaterialController extends Controller
{
    public function index(Request $request)
    {
        $info['tipos'] = Material::darTipo();

        return view('materiales.index', $info);
    }

    public function banner(Request $request)
    {
        $info['cantidad_total'] = Material::count();
        $info['cantidad_activas'] = Material::where('estado', Material::ACTIVO)
            ->count();
        $info['cantidad_inactivos'] = Material::where('estado', Material::INACTIVO)
            ->count();
        $info['cantidad_unidad'] = count(Material::darTipo());

        return [
            'estado' => 'success',
            'mensaje' => 'Se cargo la información correctamente.',
            'info' => $info
        ];
    }

    public function listado(Request $request)
    {
        $materiales = Material::with(
            'infoEstado',
            'infoTipo',
            'imagenesActivas',
        )->where('estado', '!=', Material::ELIMINADO)
        ->orderByDesc('created_at');

        return DataTables::eloquent($materiales)
            ->addColumn("estado", function ($model) {
                $info['concepto'] = $model?->infoEstado;
                return view("sistema.estado", $info);
            })
            ->addColumn("cantidad_unidad", function ($model) {
                $info['concepto'] = $model?->infoTipo;
                $info['cantidad'] = $model?->cantidad ?? 0;
                $info['unidad_personalizada'] = $model?->unidad_personalizada ?? null;
                return view("materiales.columnas.cantidad-unidad", $info);
            })
            ->addColumn("imagen", function ($model) {
                $info['imagenes'] = $model?->imagenesActivas ?? [];
                $info['nombre'] = $model?->nombre;
                return view("sistema.imagen", $info);
            })
            ->addColumn("action", "materiales.columnas.acciones")
            ->rawColumns(["action"])
            ->make(true);
    }

    public function store(Request $request)
    {
        $datos = $request->except(['imagen_1', 'imagen_2']);
        $material = Material::create($datos);

        if (!$material) {
            throw new ErrorException('Error al intentar crear la nueva material.');
        }

        foreach ([1, 2] as $posicion) {
            $campo = "imagen_{$posicion}";

            if ($request->hasFile($campo)) {

                // Inactivar imagen actual de esa posición
                $material->imagenes()
                    ->where('orden', $posicion)
                    ->update(['estado' => Imagen::INACTIVO]);

                $archivo = $request->file($campo);
                $ruta = $archivo->store('materiales', 'public');

                $material->crearImagen([
                    'url' => $ruta,
                    'tipo' => Imagen::MATERIALES,
                    'orden' => $posicion,
                    'estado' => Imagen::ACTIVO,
                ]);
            }
        }

        return [
            'estado' => 'success',
            'mensaje' => 'Se creo correctamente la material.',
        ];
    }

    public function show(Request $request, Material $material)
    {
        $material->load(
            'infoEstado',
            'infoTipo',
            'imagenesActivas',
        );

        $info["material"] = $material;

        $respuesta["estado"] = "success";
        $respuesta["mensaje"] = "Datos cargados correctamente";
        $respuesta['html'] = view("materiales.modals.secciones.ver", $info)->render();

        return response()->json($respuesta);
    }

    public function edit(Request $request, Material $material)
    {
        $material->load(
            'infoEstado',
            'imagenesActivas',
        );

        $info["material"] = $material;
        $info["tipos"] = Material::darTipo();

        $respuesta["estado"] = "success";
        $respuesta["mensaje"] = "Datos cargados correctamente";
        $respuesta['html'] = view("materiales.modals.secciones.editar", $info)->render();

        return response()->json($respuesta);
    }

    public function update(Request $request, Material $material)
    {
        $datos = $request->except(['imagen_1', 'imagen_2']);
        $actualizar = $material->update($datos);

        if (!$actualizar) {
            throw new ErrorException('Error al intentar actualizar la material.');
        }

        foreach ([1, 2] as $posicion) {
            $campo = "imagen_{$posicion}";

            if ($request->hasFile($campo)) {

                // Inactivar imagen actual de esa posición
                $material->imagenes()
                    ->where('orden', $posicion)
                    ->update(['estado' => Imagen::INACTIVO]);

                $archivo = $request->file($campo);
                $ruta = $archivo->store('materiales', 'public');

                $material->crearImagen([
                    'url' => $ruta,
                    'tipo' => Imagen::MATERIALES,
                    'orden' => $posicion,
                    'estado' => Imagen::ACTIVO,
                ]);
            }
        }

        return [
            'estado' => 'success',
            'mensaje' => 'Se actualizo correctamente la material.',
        ];
    }

    public function data(Request $request, Material $material)
    {
        $material->load(
            'infoEstado',
            'imagenActiva',
            'productosActivos',
        );

        return [
            'estado' => 'success',
            'mesnaje' => 'Datos cargados correctamente.',
            'material' => $material
        ];
    }

    public function buscar(Request $request)
    {
        $materiales = Material::with('infoEstado', 'infoTipo')
            ->where('estado', Material::ACTIVO)
            ->get();

        return [
            'estado' => 'success',
            'mensaje' => 'Se cargo correctamente los materiales',
            'materiales' => $materiales,
        ];
    }

    public function delete(Request $request, Material $material)
    {
        $eliminar = $material->eliminar();

        if (!$eliminar) {
            throw new ErrorException('A ocurrido un error al intentar eliminar la material.');
        }

        return [
            'estado' => 'success',
            'mensaje' => 'Se eliminado correctamente la material.',
        ];
    }
}
