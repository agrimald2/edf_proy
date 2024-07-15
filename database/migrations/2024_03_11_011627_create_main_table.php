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
        Schema::create('mains', function (Blueprint $table) {
            $table->id();
            $table->string('COD_CLIENTE')->default('-');
            $table->string('RUTA')->default('-');
            $table->string('FREC_VISITA')->default('-');
            $table->string('CLIENTE')->default('-');
            $table->string('DIRECCION')->default('-');
            $table->string('SV')->default('-');
            $table->string('GV')->default('-');
            $table->string('NOMBRE_SV')->default('-');
            $table->string('TAMANO')->default('-');
            $table->string('PROMEDIO_CU_3M')->default('-');
            $table->string('N_EDF')->default('-');
            $table->string('N_PUERTAS')->default('-');
            $table->string('CONDICION')->default('-');
            $table->string('PUERTAS_A_NEGOCIAR')->default('-');
            $table->string('CONDICION_2')->nullable();
            $table->string('PUERTAS_A_NEGOCIAR_2')->nullable();
            $table->string('NEGOCIADO')->default('NEGOCIADO');
            $table->string('STATUS')->nullable();
            $table->string('CUOTA')->default('0');
            $table->string('SV_LIMIT')->default('0');
            $table->string('LOCACION')->nullable();
            $table->string('TALLER')->nullable();
            $table->date('FECHA_NEGOCIADO')->format('d/m/Y')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mains');
    }
};
