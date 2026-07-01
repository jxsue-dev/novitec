<?php

namespace App\Models;

use App\Notifications\ResetClientPasswordNotification;
use App\Support\IdentityDocument;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    // Mapa de código → nombre de sucursal
    const BRANCHES = [
        'UIO' => 'NOVITEC QUITO',
        'GYE' => 'NOVITEC GUAYAQUIL',
        'MTA' => 'NOVITEC MANTA',
    ];

    // Prefijo de nro_orden para cada sucursal
    const BRANCH_ORDER_PREFIX = [
        'UIO' => 'UIO-',
        'GYE' => 'GYE-',
        'MTA' => 'MTA-',
    ];

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
        'branch_code',
        'call_webhook_token',
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

    public function isReceptionist(): bool
    {
        return !$this->is_admin && $this->branch_code !== null;
    }

    public function getBranchNameAttribute(): string
    {
        return self::BRANCHES[$this->branch_code] ?? '—';
    }

    public function getOrderPrefixAttribute(): string
    {
        return self::BRANCH_ORDER_PREFIX[$this->branch_code] ?? '';
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function conversations()
    {
        return $this->hasMany(Conversation::class);
    }

    public function getFullNameAttribute(): string
    {
        return IdentityDocument::fullName($this->nombres, $this->apellidos) ?: (string) $this->name;
    }

    public function orderLookupIdentifications(): array
    {
        return IdentityDocument::equivalentIdentifiers($this->identificacion ?: $this->cedula);
    }

    public function sendPasswordResetNotification($token): void
    {
        $this->notify(new ResetClientPasswordNotification($token));
    }
}
