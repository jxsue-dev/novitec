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
        Schema::create('llamadas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete(); // recepcionista
            $table->string('nro_orden')->nullable();
            $table->string('cliente')->nullable();
            $table->string('numero')->index();
            $table->enum('estado', ['iniciada', 'contestada', 'no_contestada', 'error'])->default('iniciada');
            $table->unsignedSmallInteger('duracion_segundos')->nullable(); // duración real
            $table->text('notas')->nullable();
            $table->string('webhook_token', 64)->nullable()->index(); // token MacroDroid
            $table->timestamp('iniciada_at');
            $table->timestamp('completada_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('llamadas');
    }
};
