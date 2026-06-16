<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    protected $fillable = [
    'name',
    'address',
    'phone',
    'whatsapp',
    'email',
    'schedule',
    'maps_url',
    'active',
    'order'
    ];

    public function getNameAttribute($value): string
    {
        return preg_replace('/nonitec/i', 'Novitec', (string) $value) ?? (string) $value;
    }
}
