<?php

namespace Tests\Concerns;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

trait InteractsWithNovitecdb
{
    protected function fakeNovitecdb(): void
    {
        config()->set('database.connections.novitecdb', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
            'foreign_key_constraints' => true,
        ]);

        DB::purge('novitecdb');
    }

    protected function createSgnClientesTable(): void
    {
        Schema::connection('novitecdb')->create('clientes', function (Blueprint $table) {
            $table->id();
            $table->string('nombres')->nullable();
            $table->string('apellidos')->nullable();
            $table->string('identificacion', 13)->unique();
            $table->string('numero_contacto')->nullable();
            $table->string('correo')->nullable();
            $table->text('direccion_clientes')->nullable();
        });
    }

    protected function createVistaOrdenesTable(): void
    {
        Schema::connection('novitecdb')->create('vista_ordenes', function (Blueprint $table) {
            $table->integer('orden_id')->primary();
            $table->string('nro_orden');
            $table->string('identificacion', 13);
            $table->string('estado_orden')->nullable();
            $table->string('estado_repuesto')->nullable();
            $table->string('estado_garantia')->nullable();
            $table->dateTime('fecha_de_ingreso')->nullable();
            $table->string('fecha_de_ingreso_fmt')->nullable();
            $table->string('fecha_entrega_fmt')->nullable();
            $table->string('tipo')->nullable();
            $table->string('marca')->nullable();
            $table->string('modelo')->nullable();
            $table->string('serie')->nullable();
            $table->text('falla')->nullable();
            $table->text('observacion')->nullable();
            $table->string('tecnico')->nullable();
            $table->string('sucursal')->nullable();
        });
    }
}
