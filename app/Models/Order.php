<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $connection = 'novitecdb';
    protected $table = 'vista_ordenes';
    protected $primaryKey = 'orden_id';
    public $timestamps = false;

    public function getStatusLabelAttribute(): string
    {
        return $this->estado_orden ?? 'Sin estado';
    }

    public function getStatusColorAttribute(): string
    {
        return match(strtolower($this->estado_orden ?? '')) {
            'recibido'              => 'bg-slate-100 text-slate-600',
            'en diagnóstico'        => 'bg-amber-100 text-amber-700',
            'en reparación'         => 'bg-blue-100 text-blue-700',
            'listo para retirar'    => 'bg-green-100 text-green-700',
            'entregado'             => 'bg-emerald-100 text-emerald-700',
            default                 => 'bg-slate-100 text-slate-600',
        };
    }
}
