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
        Schema::table('mains', function (Blueprint $table) {
            $table->string('STATUS')->nullable();
            $table->date('FECHA_PROGRAMACION')->format('d/m/Y')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mains', function (Blueprint $table) {
            //
        });
    }
};
