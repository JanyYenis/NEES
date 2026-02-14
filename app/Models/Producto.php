<?php

namespace App\Models;

use App\Classes\Models\Model;
use App\Traits\Imagenable;
use Illuminate\Support\Str;

class Producto extends Model
{
    use Imagenable;

    protected $table = 'productos';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;

    const TC_ESTADO = 'TC_ESTADO_GENERAL';
    const ACTIVO    = 1;
    const INACTIVO  = 2;
    const ELIMINADO = 0;

    protected $fillable = [
        'nombre',
        'descripcion',
        'cod_categoria',
        'ancho',
        'alto',
        'grosor',
        'color',
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

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'cod_categoria', 'id');
    }

    public function materiales()
    {
        return $this->hasMany(ProductoMaterial::class, 'cod_producto', 'id');
    }

    public function materialesActivos()
    {
        return $this->materiales()->where('estado', Material::ACTIVO);
    }

    public function imagenesProductos()
    {
        return $this->hasMany(ImagenProducto::class, 'cod_producto', 'id');
    }

    public function imagenProducto()
    {
        return $this->hasOne(ImagenProducto::class, 'cod_producto', 'id');
    }

    public function imagenesProductosActivos()
    {
        return $this->imagenesProductos()->where('estado', ImagenProducto::ACTIVO);
    }

    public function imagenProductoActivo()
    {
        return $this->imagenProducto()->where('estado', ImagenProducto::ACTIVO);
    }

    public function imagenAntes()
    {
        return $this->imagenProductoActivo()->where('orden', ImagenProducto::ANTES);
    }

    public function imagenDespues()
    {
        return $this->imagenProductoActivo()->where('orden', ImagenProducto::DESPUES);
    }
}
