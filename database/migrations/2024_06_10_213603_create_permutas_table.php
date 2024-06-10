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
        Schema::create('permutas', function (Blueprint $table) {
            $table->id();
            $table->string('cod_cliente');
            $table->string('volume');
            $table->string('location');
            $table->string('route');
            $table->string('subcanal');
            $table->boolean('have_edf');
            $table->string('condition');
            $table->integer('doors_to_negotiate');
            $table->text('reason');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permutas');
    }
};
