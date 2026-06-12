<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_screen_can_be_rendered(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    public function test_users_can_authenticate_using_identificacion_on_the_login_screen(): void
    {
        $user = User::factory()->create([
            'cedula' => '0912345678',
            'identificacion' => '0912345678',
            'identificacion_canonica' => '0912345678',
        ]);

        $response = $this->post('/login', [
            'identificacion' => '0912345678001',
            'password' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('client.orders', absolute: false));
    }

    public function test_users_can_not_authenticate_with_invalid_password(): void
    {
        $user = User::factory()->create([
            'cedula' => '0912345678',
            'identificacion' => '0912345678',
            'identificacion_canonica' => '0912345678',
        ]);

        $this->post('/login', [
            'identificacion' => $user->identificacion,
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
    }

    public function test_users_can_logout(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/logout');

        $this->assertGuest();
        $response->assertRedirect('/');
    }
}
