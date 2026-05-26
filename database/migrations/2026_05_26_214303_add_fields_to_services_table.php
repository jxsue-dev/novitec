<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('services', function (Blueprint $table) {
            $table->string('category')->default('servicios-it-presenciales');
            $table->string('price')->nullable(); // ej: "Desde $15"
            $table->string('image_url')->nullable(); // URL externa opcional
            $table->string('slug')->unique()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('services', function (Blueprint $table) {
            $table->dropColumn(['category', 'price', 'image_url', 'slug']);
        });
    }
};
