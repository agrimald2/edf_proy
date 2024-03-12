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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('name');
            $table->string('address');
            $table->string('segment');
            $table->string('subchannel_code');
            $table->string('subchannel_name');
            $table->enum('size', ['EG', 'GR', 'ME','PE','MI']);
            $table->string('room')->default('I9');
            $table->decimal('average_cu_3m', 8, 2);
            $table->integer('total_edf');
            $table->integer('total_doors');
            $table->enum('execution_segment', ['Ninguno','Base', 'Desarrollar', 'Ganar','Proteger'])->default('Ninguno');
            $table->enum('potential', ['Ninguno','Alto', 'Bajo', 'Medio', 'Sin Potencial'])->default('Ninguno');
            $table->enum('condition', ['Nuevo o Repotenciado', 'Repotenciado']);
            $table->enum('status', ['Negociado', 'Pendiente']);
            $table->integer('doors_to_negotiate')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
