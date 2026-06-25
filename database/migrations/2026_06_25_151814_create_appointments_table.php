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
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->string('service'); // tipo de servicio
            $table->string('device')->nullable(); // equipo
            $table->text('description')->nullable();
            $table->date('preferred_date');
            $table->enum('preferred_time', ['09:00-11:00','11:00-13:00','14:00-16:00','16:00-17:00']);
            $table->string('branch')->default('Quito');
            $table->enum('status', ['pendiente','confirmada','completada','cancelada'])->default('pendiente');
            $table->text('notes')->nullable(); // notas internas admin
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
