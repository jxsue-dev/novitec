<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = [
        'name','email','phone','service','device',
        'description','preferred_date','preferred_time',
        'branch','status','notes',
    ];

    protected $casts = ['preferred_date' => 'date'];

    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'confirmada'  => 'Confirmada',
            'completada'  => 'Completada',
            'cancelada'   => 'Cancelada',
            default       => 'Pendiente',
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'confirmada'  => 'text-blue-700 bg-blue-50',
            'completada'  => 'text-green-700 bg-green-50',
            'cancelada'   => 'text-red-700 bg-red-50',
            default       => 'text-yellow-700 bg-yellow-50',
        };
    }
}
