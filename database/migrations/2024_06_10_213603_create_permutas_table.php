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
            $table->string('sv');
            $table->string('cod_cliente');
            $table->string('volume');
            $table->string('location');
            $table->string('route');
            $table->string('subcanal');
            $table->boolean('have_edf');
            $table->string('condition');
            $table->integer('doors_to_negotiate');
            $table->text('reason');
            
            $table->enum('instance_status', ['Supervisor', 'Gerente', 'Trade'])->default('Supervisor');
            
            $table->enum('supervisor_status', ['Pending', 'Rejected', 'Approved'])->default('Pending');
            $table->string('supervisor_approved_by')->nullable();
            $table->dateTime('supervisor_approved_at')->nullable();
            $table->string('supervisor_rejected_reason')->nullable();
            $table->string('supervsior_rejected_comments')->nullable();
            
            $table->enum('gerente_status', ['Pending', 'Rejected', 'Approved'])->default('Pending');
            $table->string('gerente_approved_by')->nullable();
            $table->dateTime('gerente_approved_at')->nullable();
            $table->string('gerente_rejected_reason')->nullable();
            $table->string('gerente_rejected_comments')->nullable();
            
            $table->enum('trade_status', ['Pending', 'Rejected', 'Approved'])->default('Pending');
            $table->string('trade_approved_by')->nullable();
            $table->dateTime('trade_approved_at')->nullable();
            $table->string('trade_rejected_reason')->nullable();
            $table->string('trade_rejected_comments')->nullable();
            
            
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
