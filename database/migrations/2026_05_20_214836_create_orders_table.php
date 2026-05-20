<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('code')->unique();
            $table->string('device');
            $table->string('brand')->nullable();
            $table->string('model')->nullable();
            $table->text('issue');
            $table->enum('status', ['recibido','diagnostico','reparacion','listo','entregado'])->default('recibido');
            $table->text('notes')->nullable();
            $table->decimal('price', 8, 2)->nullable();
            $table->timestamp('estimated_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
