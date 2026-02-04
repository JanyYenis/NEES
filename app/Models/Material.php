<?php

namespace App\Models;

use App\Classes\Models\Model;
use App\Traits\Imagenable;
use Illuminate\Support\Str;

class Material extends Model
{
    use Imagenable;

    protected $table = 'materiales';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;

    const TC_ESTADO = 'TC_ESTADO_GENERAL';
    const ACTIVO    = 1;
    const INACTIVO  = 2;
    const ELIMINADO = 0;

    const TC_TIPO_UNIDAD  = 'TC_TIPO_UNIDAD';
    const GALON           = 1;
    const LITRO           = 2;
    const MEDIO_Litro     = 3;
    const UUNIDAD         = 4;
    const METROS          = 5;
    const METROS_CUADRADO = 6;
    const KILOGRAMOS      = 7;
    const PERSONALIZADO   = 8;

    protected $fillable = [
        'nombre',
        'descripcion',
        'cantidad',
        'unidad_medida',
        'unidad_personalizada',
        'estado',
    ];

    protected $dates = [
        "created_at" => "date:d/m/Y ",
        "updated_at" => "date:d/m/Y ",
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
            "created_at" => "date:d/m/Y",
        ];
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id = Str::uuid();
        });
    }

    public function infoTipo()
    {
        return darInfoConcepto($this, self::TC_TIPO_UNIDAD, 'unidad_medida')->selectRaw('conceptos.*');
    }

    public static function darTipo($infoTipoConcepto = false)
    {
        return darConceptos(self::TC_TIPO_UNIDAD, $infoTipoConcepto);
    }

    public function productos()
    {
        return $this->hasMany(ProductoMaterial::class, 'cod_material', 'id');
    }

    public function productosActivos()
    {
        return $this->productos()->where('estado', ProductoMaterial::ACTIVO);
    }
}
