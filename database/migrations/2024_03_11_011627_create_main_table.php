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
            $table->string('COD_CLIENTE', 512)->default('-');
            $table->string('RUTA', 512)->default('-');
            $table->string('FREC_VISITA', 512)->default('-');
            $table->string('CLIENTE', 512)->default('-');
            $table->string('DIRECCIÓN', 512)->default('-');
            $table->string('SV', 512)->default('-');
            $table->string('GV', 512)->default('-');
            $table->string('SEGMENTO', 512)->default('-');
            $table->string('COD_SUBCANAL', 512)->default('-');
            $table->string('NOMBRE_SUBCANAL', 512)->default('-');
            $table->string('TAMAÑO', 512)->default('-');
            $table->string('SALA', 512)->default('-');
            $table->string('PROMEDIO_CU_3M', 512)->default('-');
            $table->string('N_EDF', 512)->default('-');
            $table->string('N_PUERTAS', 512)->default('-');
            $table->string('SEGMENTO_EJECUCIÓN', 512)->default('-');
            $table->string('POTENCIAL', 512)->default('-');
            $table->string('CONDICION', 512)->default('-');
            $table->string('PUERTAS_A_NEGOCIAR', 512)->default('-');
            $table->string('NEGOCIADO', 512)->default('NEGOCIADO');
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
