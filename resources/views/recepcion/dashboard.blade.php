@extends('layouts.recepcion')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard del día')
@section('page-subtitle', $branchName . ' · ' . now()->format('d/m/Y'))

@section('content')

{{-- ── STATS ─────────────────────────────────────────────────────────────── --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
    @foreach([
        ['Ingresadas hoy',       $stats['hoy'],       'bg-blue-50 text-blue-600 border-blue-100',    'fa-calendar-day',       'text-blue-900'],
        ['Listas p/ entregar',   $stats['listas'],    'bg-green-50 text-green-600 border-green-100', 'fa-circle-check',       'text-green-900'],
        ['En proceso',           $stats['proceso'],   'bg-amber-50 text-amber-600 border-amber-100', 'fa-screwdriver-wrench', 'text-amber-900'],
        ['Atrasadas',            $stats['atrasadas'], 'bg-red-50 text-red-600 border-red-100',       'fa-triangle-exclamation','text-red-900'],
    ] as [$label, $val, $cls, $icon, $txtCls])
    <div class="bg-white border border-slate-100 rounded-2xl p-5 shadow-sm hover:shadow-md transition-shadow">
        <div class="flex items-center justify-between mb-3">
            <p class="text-xs font-semibold text-slate-500 uppercase tracking-wide">{{ $label }}</p>
            <div class="w-9 h-9 rounded-xl border flex items-center justify-center text-sm {{ $cls }}">
                <i class="fa-solid {{ $icon }}"></i>
            </div>
        </div>
        <p class="text-3xl font-bold {{ $txtCls }}">{{ $val }}</p>
    </div>
    @endforeach
</div>

<div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

    {{-- ── LISTAS PARA ENTREGAR ────────────────────────────────────────────── --}}
    <div class="xl:col-span-2 bg-white border border-slate-100 rounded-2xl shadow-sm overflow-hidden">
        <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100 bg-green-50/40">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 bg-green-500 rounded-xl flex items-center justify-center">
                    <i class="fa-solid fa-circle-check text-white text-sm"></i>
                </div>
                <div>
                    <p class="text-slate-900 text-sm font-bold">Listas para entregar</p>
                    <p class="text-slate-400 text-xs">Estado: Finalizada — pueden retirarse</p>
                </div>
            </div>
            <span class="text-xs font-bold text-green-700 bg-green-100 border border-green-200 px-3 py-1 rounded-full">
                {{ $listas->count() }} órdenes
            </span>
        </div>

        @if($listas->isEmpty())
        <div class="px-6 py-10 text-center">
            <i class="fa-solid fa-inbox text-slate-200 text-4xl mb-3 block"></i>
            <p class="text-slate-400 text-sm">No hay órdenes listas para entregar</p>
        </div>
        @else
        <div class="divide-y divide-slate-50 max-h-96 overflow-y-auto">
            @foreach($listas as $o)
            @php $nombre = trim(($o->nombres ?? '').' '.($o->apellidos ?? '')) ?: ($o->cliente ?? '—'); @endphp
            <div class="flex items-center gap-4 px-6 py-3.5 hover:bg-slate-50/60 transition-colors">
                <div class="w-9 h-9 bg-green-50 border border-green-100 rounded-xl flex items-center justify-center flex-shrink-0">
                    <i class="fa-solid fa-laptop text-green-500 text-sm"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <div class="flex items-center gap-2 flex-wrap">
                        <span class="font-mono text-xs font-bold text-blue-600">{{ $o->nro_orden }}</span>
                        <span class="text-xs text-slate-500 truncate">{{ trim(implode(' ', array_filter([$o->tipo ?? '', $o->marca ?? '', $o->modelo ?? '']))) }}</span>
                    </div>
                    <p class="text-sm font-medium text-slate-800 truncate">{{ $nombre }}</p>
                </div>
                <div class="flex items-center gap-2 flex-shrink-0">
                    @if(!empty($o->numero_contacto) || !empty($o->telefono))
                    <a href="https://wa.me/593{{ ltrim($o->numero_contacto ?: $o->telefono, '0') }}?text={{ urlencode('Hola '.$nombre.', le informamos que su equipo ('.$o->nro_orden.') ya está listo para ser retirado en Novitec. Horario: Lun-Vie 9:00-17:00.') }}"
                       target="_blank"
                       class="w-8 h-8 bg-green-500 hover:bg-green-600 text-white rounded-lg flex items-center justify-center transition-colors"
                       title="Notificar por WhatsApp">
                        <i class="fa-brands fa-whatsapp text-sm"></i>
                    </a>
                    @endif
                    <a href="{{ route('recepcion.ordenes', ['q' => $o->nro_orden, 'tipo' => 'nro_orden']) }}"
                       class="w-8 h-8 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-lg flex items-center justify-center transition-colors"
                       title="Ver detalle">
                        <i class="fa-solid fa-arrow-right text-xs"></i>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>

    {{-- ── LADO DERECHO ─────────────────────────────────────────────────────── --}}
    <div class="flex flex-col gap-5">

        {{-- Órdenes atrasadas --}}
        <div class="bg-white border border-red-100 rounded-2xl shadow-sm overflow-hidden">
            <div class="flex items-center justify-between px-5 py-3.5 border-b border-red-50 bg-red-50/40">
                <div class="flex items-center gap-2">
                    <i class="fa-solid fa-triangle-exclamation text-red-500"></i>
                    <p class="text-sm font-bold text-slate-800">Atrasadas</p>
                </div>
                <span class="text-xs font-bold text-red-600 bg-red-100 border border-red-200 px-2.5 py-1 rounded-full">
                    {{ $atrasadas->count() }}
                </span>
            </div>
            @if($atrasadas->isEmpty())
            <div class="px-5 py-6 text-center">
                <i class="fa-solid fa-face-smile text-slate-200 text-2xl mb-2 block"></i>
                <p class="text-slate-400 text-xs">¡Sin atrasos por ahora!</p>
            </div>
            @else
            <div class="divide-y divide-slate-50 max-h-52 overflow-y-auto">
                @foreach($atrasadas as $o)
                @php $nombre = trim(($o->nombres ?? '').' '.($o->apellidos ?? '')) ?: ($o->cliente ?? '—'); @endphp
                <div class="flex items-start gap-3 px-5 py-3 hover:bg-red-50/30 transition-colors">
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-2 flex-wrap">
                            <span class="font-mono text-xs font-bold text-red-600">{{ $o->nro_orden }}</span>
                            <span class="text-xs px-2 py-0.5 bg-amber-100 text-amber-700 rounded-full">{{ $o->estado_orden }}</span>
                        </div>
                        <p class="text-xs text-slate-700 font-medium truncate">{{ $nombre }}</p>
                        <p class="text-xs text-slate-400 truncate">{{ trim(implode(' ', array_filter([$o->tipo ?? '', $o->marca ?? '', $o->modelo ?? '']))) }}</p>
                        @if(!empty($o->fecha_prometido_fmt))
                        <p class="text-xs text-red-500 mt-0.5"><i class="fa-solid fa-clock mr-1"></i>Prometida: {{ $o->fecha_prometido_fmt }}</p>
                        @endif
                    </div>
                    <a href="{{ route('recepcion.ordenes', ['q' => $o->nro_orden, 'tipo' => 'nro_orden']) }}"
                       class="w-7 h-7 bg-slate-100 hover:bg-slate-200 text-slate-500 rounded-lg flex items-center justify-center flex-shrink-0 transition-colors">
                        <i class="fa-solid fa-arrow-right text-xs"></i>
                    </a>
                </div>
                @endforeach
            </div>
            @endif
        </div>

        {{-- Ingresadas hoy --}}
        <div class="bg-white border border-slate-100 rounded-2xl shadow-sm overflow-hidden">
            <div class="flex items-center justify-between px-5 py-3.5 border-b border-slate-100 bg-blue-50/30">
                <div class="flex items-center gap-2">
                    <i class="fa-solid fa-calendar-day text-blue-500"></i>
                    <p class="text-sm font-bold text-slate-800">Ingresadas hoy</p>
                </div>
                <span class="text-xs font-bold text-blue-600 bg-blue-100 border border-blue-200 px-2.5 py-1 rounded-full">
                    {{ $hoy->count() }}
                </span>
            </div>
            @if($hoy->isEmpty())
            <div class="px-5 py-6 text-center">
                <p class="text-slate-400 text-xs">Ninguna orden ingresada hoy aún</p>
            </div>
            @else
            <div class="divide-y divide-slate-50 max-h-52 overflow-y-auto">
                @foreach($hoy as $o)
                @php $nombre = trim(($o->nombres ?? '').' '.($o->apellidos ?? '')) ?: ($o->cliente ?? '—'); @endphp
                <div class="flex items-center gap-3 px-5 py-3 hover:bg-slate-50/60 transition-colors">
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-2 flex-wrap">
                            <span class="font-mono text-xs font-bold text-blue-600">{{ $o->nro_orden }}</span>
                            @php
                            $sc2 = match($o->estado_orden) {
                                'En Revisión' => 'bg-amber-100 text-amber-700',
                                'En Reparacion' => 'bg-blue-100 text-blue-700',
                                'Finalizada' => 'bg-green-100 text-green-700',
                                default => 'bg-slate-100 text-slate-600',
                            };
                            @endphp
                            <span class="text-xs px-2 py-0.5 rounded-full {{ $sc2 }}">{{ $o->estado_orden }}</span>
                        </div>
                        <p class="text-xs text-slate-700 font-medium truncate">{{ $nombre }}</p>
                        <p class="text-xs text-slate-400 truncate">{{ trim(implode(' ', array_filter([$o->tipo ?? '', $o->marca ?? '', $o->modelo ?? '']))) }}</p>
                    </div>
                    <a href="{{ route('recepcion.ordenes', ['q' => $o->nro_orden, 'tipo' => 'nro_orden']) }}"
                       class="w-7 h-7 bg-slate-100 hover:bg-slate-200 text-slate-500 rounded-lg flex items-center justify-center flex-shrink-0 transition-colors">
                        <i class="fa-solid fa-arrow-right text-xs"></i>
                    </a>
                </div>
                @endforeach
            </div>
            @endif
        </div>

        {{-- Por estado --}}
        @if($porEstado->isNotEmpty())
        <div class="bg-white border border-slate-100 rounded-2xl shadow-sm overflow-hidden">
            <div class="px-5 py-3.5 border-b border-slate-100">
                <p class="text-sm font-bold text-slate-800 flex items-center gap-2">
                    <i class="fa-solid fa-chart-pie text-slate-400"></i> Resumen por estado
                </p>
            </div>
            <div class="px-5 py-3 space-y-2">
                @foreach($porEstado as $es)
                @php
                    $pct = $stats['listas'] + $stats['proceso'] > 0 ? round($es->total / ($porEstado->sum('total')) * 100) : 0;
                    $barColor = match($es->estado_orden) {
                        'Finalizada'  => 'bg-green-400',
                        'Entregada'   => 'bg-slate-300',
                        'En Revisión' => 'bg-amber-400',
                        'En Reparacion' => 'bg-blue-400',
                        'Esperando Repuesto' => 'bg-violet-400',
                        'Anulada'     => 'bg-red-300',
                        default       => 'bg-slate-200',
                    };
                @endphp
                <div>
                    <div class="flex items-center justify-between text-xs mb-1">
                        <span class="text-slate-600 font-medium">{{ $es->estado_orden }}</span>
                        <span class="font-bold text-slate-800">{{ $es->total }}</span>
                    </div>
                    <div class="w-full bg-slate-100 rounded-full h-1.5">
                        <div class="h-1.5 rounded-full {{ $barColor }}" style="width:{{ $pct }}%"></div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

    </div>
</div>

@endsection
