<?php

namespace App\Models;

use App\Support\IdentityDocument;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'cedula',
        'identificacion',
        'identificacion_canonica',
        'nombres',
        'apellidos',
        'phone',
        'direccion',
        'sgn_cliente_id',
        'email',
        'password',
        'is_admin',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function getFullNameAttribute(): string
    {
        return IdentityDocument::fullName($this->nombres, $this->apellidos) ?: (string) $this->name;
    }

    public function orderLookupIdentifications(): array
    {
        return IdentityDocument::equivalentIdentifiers($this->identificacion ?: $this->cedula);
    }
}
