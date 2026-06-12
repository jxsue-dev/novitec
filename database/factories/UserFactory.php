<?php

namespace Database\Factories;

use App\Models\User;
use App\Support\IdentityDocument;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    protected static ?string $password;

    public function definition(): array
    {
        $nombres = fake()->firstName();
        $apellidos = fake()->lastName();
        $identificacion = fake()->unique()->numerify('09########');

        return [
            'name' => IdentityDocument::fullName($nombres, $apellidos),
            'cedula' => $identificacion,
            'identificacion' => $identificacion,
            'identificacion_canonica' => IdentityDocument::canonicalize($identificacion),
            'nombres' => $nombres,
            'apellidos' => $apellidos,
            'phone' => fake()->numerify('09########'),
            'direccion' => fake()->address(),
            'sgn_cliente_id' => null,
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            'is_admin' => false,
        ];
    }

    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
