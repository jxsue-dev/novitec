<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Llamada extends Model
{
    protected $fillable = [
        'user_id', 'nro_orden', 'cliente', 'numero', 'tipo',
        'estado', 'duracion_segundos', 'notas',
        'webhook_token', 'iniciada_at', 'completada_at',
    ];

    protected $casts = [
        'iniciada_at'   => 'datetime',
        'completada_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getDuracionFormateadaAttribute(): string
    {
        if (!$this->duracion_segundos) return '—';
        $m = intdiv($this->duracion_segundos, 60);
        $s = $this->duracion_segundos % 60;
        return $m > 0 ? "{$m}m {$s}s" : "{$s}s";
    }
}
