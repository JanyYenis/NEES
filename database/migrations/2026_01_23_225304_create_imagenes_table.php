<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('imagenes', function (Blueprint $table) {
            $table->uuid('id')->primary();

            // Ruta o URL de la imagen
            $table->string('url');

            // Relación polimórfica
            $table->uuidMorphs('imagenable');

            // Campos adicionales
            $table->integer('tipo')->nullable();          // portada, galeria, avatar, etc
            $table->integer('orden')->default(0);        // orden de visualización
            $table->string('alt')->nullable();           // texto alternativo

            // Estado (1 = activo, 0 = inactivo, otros si lo necesitas)
            $table->integer('estado')->default(1);
            $table->timestamps();

            // Índices
            $table->index(['imagenable_id', 'imagenable_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('imagenes');
    }
};
