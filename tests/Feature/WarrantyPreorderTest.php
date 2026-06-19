<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WarrantyPreorderTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_cannot_submit_warranty_preorder_without_serie(): void
    {
        $user = User::factory()->create([
            'identificacion' => '0912345678',
            'identificacion_canonica' => '0912345678',
            'cedula' => '0912345678',
        ]);

        $response = $this->actingAs($user)->post(route('warranties.guardar'), [
            'nro_factura' => '001-001-000000001',
            'suc_cliente_id' => 1,
            'novitec_suc_id' => 1,
            'secuencial' => 'UIO',
            'nombres' => 'Cliente',
            'apellidos' => 'Prueba',
            'identificacion' => '0912345678',
            'telefono' => '0999999999',
            'correo' => 'cliente@example.com',
            'ciudad_procedencia' => 'QUITO',
            'codigo_producto' => 'ABC123',
            'fecha_facturacion' => now()->toDateString(),
            'detalle_equipo' => 'No enciende',
        ]);

        $response->assertSessionHasErrors('serie');
    }
}
