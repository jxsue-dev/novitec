<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ServiceOrder extends Model
{
    protected $table = 'orders';

    protected $fillable = [
        'user_id', 'code', 'device', 'brand', 'model',
        'issue', 'status', 'notes', 'price', 'estimated_at',
    ];

    protected $casts = [
        'estimated_at' => 'date',
        'price'        => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'recibido'    => 'Recibido',
            'diagnostico' => 'Diagnóstico',
            'reparacion'  => 'En reparación',
            'listo'       => 'Listo para retiro',
            'entregado'   => 'Entregado',
            default       => ucfirst($this->status ?? '—'),
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'recibido'    => 'bg-slate-100 text-slate-600',
            'diagnostico' => 'bg-amber-100 text-amber-700',
            'reparacion'  => 'bg-blue-100 text-blue-700',
            'listo'       => 'bg-green-100 text-green-700',
            'entregado'   => 'bg-emerald-100 text-emerald-700',
            default       => 'bg-slate-100 text-slate-600',
        };
    }
}
