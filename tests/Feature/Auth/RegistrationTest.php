<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Concerns\InteractsWithNovitecdb;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;
    use InteractsWithNovitecdb;

    protected function setUp(): void
    {
        parent::setUp();

        $this->fakeNovitecdb();
        $this->createSgnClientesTable();
    }

    public function test_registration_screen_can_be_rendered(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    public function test_new_users_can_register_manually(): void
    {
        $response = $this->post('/register', [
            'identificacion' => '0912345678',
            'nombres' => 'Test',
            'apellidos' => 'User',
            'phone' => '0999999999',
            'email' => 'test@example.com',
            'direccion' => 'Guayaquil',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('client.orders', absolute: false));
        $this->assertDatabaseHas('users', [
            'identificacion' => '0912345678',
            'identificacion_canonica' => '0912345678',
            'nombres' => 'Test',
            'apellidos' => 'User',
            'email' => 'test@example.com',
        ]);
    }

    public function test_registration_normalizes_formatted_identificacion_before_saving(): void
    {
        $response = $this->post('/register', [
            'identificacion' => '0912345678-001',
            'nombres' => 'Test',
            'apellidos' => 'Formato',
            'phone' => '0999999999',
            'email' => 'formato@example.com',
            'direccion' => 'Guayaquil',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('client.orders', absolute: false));
        $this->assertDatabaseHas('users', [
            'identificacion' => '0912345678001',
            'identificacion_canonica' => '0912345678',
            'email' => 'formato@example.com',
        ]);
    }

    public function test_registration_redirects_to_login_when_canonical_identity_already_exists(): void
    {
        User::factory()->create([
            'cedula' => '0912345678',
            'identificacion' => '0912345678',
            'identificacion_canonica' => '0912345678',
            'email' => 'existing@example.com',
        ]);

        $response = $this->post('/register', [
            'identificacion' => '0912345678001',
            'nombres' => 'Test',
            'apellidos' => 'Duplicado',
            'phone' => '0999999999',
            'email' => 'nuevo@example.com',
            'direccion' => 'Quito',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response
            ->assertRedirect(route('login', absolute: false))
            ->assertSessionHas('status');

        $this->assertDatabaseCount('users', 1);
        $this->assertGuest();
    }
}
