<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\Concerns\InteractsWithNovitecdb;
use Tests\TestCase;

class RegistrationLookupTest extends TestCase
{
    use RefreshDatabase;
    use InteractsWithNovitecdb;

    protected function setUp(): void
    {
        parent::setUp();

        $this->fakeNovitecdb();
        $this->createSgnClientesTable();
    }

    public function test_lookup_returns_existing_client_data_from_sgn(): void
    {
        DB::connection('novitecdb')->table('clientes')->insert([
            'id' => 15,
            'nombres' => 'Ana',
            'apellidos' => 'Perez',
            'identificacion' => '0912345678001',
            'numero_contacto' => '0988888888',
            'correo' => 'ana@novitec.test',
            'direccion_clientes' => 'Urdesa',
        ]);

        $response = $this->getJson('/register/lookup-identificacion?identificacion=0912345678');

        $response
            ->assertOk()
            ->assertJson([
                'found' => true,
                'source' => 'sgn_clientes',
                'cliente' => [
                    'sgn_cliente_id' => 15,
                    'identificacion' => '0912345678001',
                    'identificacion_canonica' => '0912345678',
                    'nombres' => 'Ana',
                    'apellidos' => 'Perez',
                    'telefono' => '0988888888',
                    'correo' => 'ana@novitec.test',
                    'direccion' => 'Urdesa',
                ],
            ]);
    }

    public function test_lookup_returns_found_false_when_client_does_not_exist(): void
    {
        $response = $this->getJson('/register/lookup-identificacion?identificacion=0912345678');

        $response
            ->assertOk()
            ->assertJson([
                'found' => false,
                'cliente' => null,
                'source' => null,
            ]);
    }

    public function test_lookup_does_not_expose_sgn_data_when_identity_is_already_registered_in_web(): void
    {
        User::factory()->create([
            'cedula' => '0912345678',
            'identificacion' => '0912345678',
            'identificacion_canonica' => '0912345678',
            'email' => 'cliente@novitec.test',
        ]);

        DB::connection('novitecdb')->table('clientes')->insert([
            'id' => 18,
            'nombres' => 'Cliente',
            'apellidos' => 'Registrado',
            'identificacion' => '0912345678001',
            'numero_contacto' => '0991111111',
            'correo' => 'otro@novitec.test',
            'direccion_clientes' => 'Centro',
        ]);

        $response = $this->getJson('/register/lookup-identificacion?identificacion=0912345678');

        $response
            ->assertOk()
            ->assertJson([
                'found' => false,
                'already_registered' => true,
                'cliente' => null,
                'source' => 'web_users',
            ]);
    }
}
