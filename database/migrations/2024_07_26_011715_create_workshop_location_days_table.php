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
        Schema::create('workshop_location_days', function (Blueprint $table) {
            $table->id();
            $table->string('LOCACION');
            $table->string('TALLER');
            $table->string('CONDICION');
            $table->integer('TIEMPO');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('workshop_location_days');
    }
};
