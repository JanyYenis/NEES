<?php

namespace App\Models;

use App\Classes\Models\Model;
use Illuminate\Support\Str;

class Imagen extends Model
{
    protected $table = 'imagenes';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;

    const TC_ESTADO = 'TC_ESTADO_GENERAL';
    const ACTIVO    = 1;
    const INACTIVO  = 2;
    const ELIMINADO = 0;

    const TC_TIPO_IMAGEN = 'TC_TIPO_IMAGEN';
    const USUARIOS   = 1;
    const CATEGORIAS = 2;
    const MATERIALES = 3;
    const PRODUCTOS  = 4;

    protected $fillable = [
        'url',
        'tipo',
        'orden',
        'alt',
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

    public function imagenable()
    {
        return $this->morphTo();
    }
}
