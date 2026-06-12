<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\Concerns\InteractsWithNovitecdb;
use Tests\TestCase;

class ClientOrderAccessTest extends TestCase
{
    use RefreshDatabase;
    use InteractsWithNovitecdb;

    protected function setUp(): void
    {
        parent::setUp();

        $this->fakeNovitecdb();
        $this->createVistaOrdenesTable();
    }

    public function test_client_sees_orders_for_cedula_and_natural_person_ruc_only(): void
    {
        $user = User::factory()->create([
            'cedula' => '0912345678',
            'identificacion' => '0912345678',
            'identificacion_canonica' => '0912345678',
        ]);

        DB::connection('novitecdb')->table('vista_ordenes')->insert([
            [
                'orden_id' => 1,
                'nro_orden' => 'ORD-001',
                'identificacion' => '0912345678',
                'estado_orden' => 'Recibido',
                'fecha_de_ingreso' => now(),
                'fecha_de_ingreso_fmt' => '12/06/2026 09:00',
                'fecha_entrega_fmt' => null,
                'tipo' => 'Laptop',
                'marca' => 'Dell',
                'modelo' => 'Inspiron',
                'serie' => 'ABC123',
                'falla' => 'No enciende',
                'observacion' => 'Pendiente',
                'tecnico' => 'Juan',
                'sucursal' => 'Guayaquil',
            ],
            [
                'orden_id' => 2,
                'nro_orden' => 'ORD-002',
                'identificacion' => '0912345678001',
                'estado_orden' => 'En diagnostico',
                'fecha_de_ingreso' => now(),
                'fecha_de_ingreso_fmt' => '12/06/2026 10:00',
                'fecha_entrega_fmt' => null,
                'tipo' => 'Laptop',
                'marca' => 'HP',
                'modelo' => 'Pavilion',
                'serie' => 'DEF456',
                'falla' => 'Pantalla negra',
                'observacion' => 'Revision',
                'tecnico' => 'Maria',
                'sucursal' => 'Guayaquil',
            ],
            [
                'orden_id' => 3,
                'nro_orden' => 'ORD-003',
                'identificacion' => '0999999999',
                'estado_orden' => 'Recibido',
                'fecha_de_ingreso' => now(),
                'fecha_de_ingreso_fmt' => '12/06/2026 11:00',
                'fecha_entrega_fmt' => null,
                'tipo' => 'Laptop',
                'marca' => 'Lenovo',
                'modelo' => 'ThinkPad',
                'serie' => 'XYZ789',
                'falla' => 'Teclado',
                'observacion' => 'Externo',
                'tecnico' => 'Pedro',
                'sucursal' => 'Quito',
            ],
        ]);

        $response = $this->actingAs($user)->get(route('client.orders'));

        $response
            ->assertOk()
            ->assertSee('ORD-001')
            ->assertSee('ORD-002')
            ->assertDontSee('ORD-003');
    }

    public function test_client_cannot_open_an_order_that_does_not_belong_to_its_identity_group(): void
    {
        $user = User::factory()->create([
            'cedula' => '0912345678',
            'identificacion' => '0912345678',
            'identificacion_canonica' => '0912345678',
        ]);

        DB::connection('novitecdb')->table('vista_ordenes')->insert([
            'orden_id' => 10,
            'nro_orden' => 'ORD-010',
            'identificacion' => '0999999999',
            'estado_orden' => 'Recibido',
            'fecha_de_ingreso' => now(),
            'fecha_de_ingreso_fmt' => '12/06/2026 12:00',
            'fecha_entrega_fmt' => null,
            'tipo' => 'Laptop',
            'marca' => 'Acer',
            'modelo' => 'Swift',
            'serie' => 'A1',
            'falla' => 'Falla',
            'observacion' => 'Obs',
            'tecnico' => 'Luis',
            'sucursal' => 'Cuenca',
        ]);

        $this->actingAs($user)
            ->get(route('client.order.show', 'ORD-010'))
            ->assertNotFound();
    }
}
