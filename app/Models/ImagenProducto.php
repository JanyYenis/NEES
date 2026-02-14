<?php

namespace App\Models;

use App\Classes\Models\Model;
use Illuminate\Support\Str;

class ImagenProducto extends Model
{
    protected $table = 'imagenes_productos';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;

    const TC_ESTADO = 'TC_ESTADO_GENERAL';
    const ACTIVO    = 1;
    const INACTIVO  = 2;
    const ELIMINADO = 0;

    const TC_ORDEN_IMAGEN_PRODUCTO = 'TC_ORDEN_IMAGEN_PRODUCTO';
    const ANTES   = 1;
    const DESPUES = 2;

    protected $fillable = [
        'cod_producto',
        'url',
        'orden',
        'estado',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'id' => 'string',
        ];
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id = Str::uuid();
        });
    }
}
