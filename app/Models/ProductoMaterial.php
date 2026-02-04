<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ProductoMaterial extends Model
{
    protected $table = 'productos_materiales';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;

    const TC_ESTADO = 'TC_ESTADO_GENERAL';
    const ACTIVO    = 1;
    const INACTIVO  = 2;
    const ELIMINADO = 0;

    protected $fillable = [
        'cod_producto',
        'cod_material',
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

    public function material()
    {
        return $this->belongsTo(Material::class, 'cod_material', 'id');
    }
}
