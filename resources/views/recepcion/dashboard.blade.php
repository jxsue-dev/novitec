@extends('layouts.recepcion')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard del día')
@section('page-subtitle', $branchName . ' · ' . now()->format('d/m/Y'))

@section('content')

{{-- ── STATS ─────────────────────────────────────────────────────────────── --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    @foreach([
        ['listas',    'Listas para entregar', $stats['listas'],    'bg-green-50 text-green-600',  'fa-circle-check',         'border-green-200'],
        ['atrasadas', 'Atrasadas',            $stats['atrasadas'], 'bg-red-50 text-red-600',     'fa-triangle-exclamation', 'border-red-200'],
        ['hoy',       'Ingresadas hoy',       $stats['hoy'],       'bg-blue-50 text-blue-600',   'fa-calendar-day',         'border-blue-200'],
        ['resumen',   'En proceso',           $stats['proceso'],   'bg-amber-50 text-amber-600', 'fa-screwdriver-wrench',   'border-amber-200'],
    ] as [$t, $label, $val, $cls, $icon, $border])
    <a href="{{ route('recepcion.dashboard', array_merge(request()->query(), ['tab' => $t, 'page' => 1])) }}"
       class="bg-white border rounded-2xl p-5 shadow-sm hover:shadow-md transition-all {{ $tab === $t ? 'border-2 '.$border.' ring-2 ring-offset-1 ring-current/10' : 'border-slate-100' }}">
        <div class="flex items-center justify-between mb-3">
            <p class="text-xs font-semibold text-slate-500 uppercase tracking-wide">{{ $label }}</p>
            <div class="w-9 h-9 rounded-xl border flex items-center justify-center text-sm {{ $cls }} {{ $tab === $t ? 'opacity-100' : 'opacity-70' }}">
                <i class="fa-solid {{ $icon }}"></i>
            </div>
        </div>
        <p class="text-3xl font-bold {{ $tab === $t ? explode(' ', $cls)[1] : 'text-slate-800' }}">{{ $val }}</p>
    </a>
    @endforeach
</div>

{{-- ── PANEL PRINCIPAL ──────────────────────────────────────────────────── --}}
<div class="bg-white border border-slate-100 rounded-2xl shadow-sm overflow-hidden">

    {{-- TABS --}}
    <div class="flex border-b border-slate-100 overflow-x-auto">
        @foreach([
            ['listas',    'fa-circle-check',         'Listas para entregar', $stats['listas'],    'text-green-600 border-green-500'],
            ['atrasadas', 'fa-triangle-exclamation', 'Atrasadas',            $stats['atrasadas'], 'text-red-600 border-red-500'],
            ['hoy',       'fa-calendar-day',         'Ingresadas hoy',       $stats['hoy'],       'text-blue-600 border-blue-500'],
            ['resumen',   'fa-chart-pie',             'Resumen por estado',   null,                'text-slate-700 border-slate-400'],
        ] as [$t, $ico, $lbl, $cnt, $activeColor])
        <a href="{{ route('recepcion.dashboard', array_merge(request()->query(), ['tab' => $t, 'page' => 1])) }}"
           class="flex items-center gap-2 px-5 py-3.5 text-sm font-medium whitespace-nowrap border-b-2 transition-all
                  {{ $tab === $t ? $activeColor.' bg-slate-50/60' : 'border-transparent text-slate-500 hover:text-slate-700 hover:bg-slate-50' }}">
            <i class="fa-solid {{ $ico }} text-xs"></i>
            {{ $lbl }}
            @if($cnt !== null)
            <span class="text-xs px-1.5 py-0.5 rounded-full {{ $tab === $t ? 'bg-current/10' : 'bg-slate-100 text-slate-500' }}">{{ $cnt }}</span>
            @endif
        </a>
        @endforeach
    </div>

    {{-- FILTROS --}}
    @if($tab !== 'resumen')
    <div class="px-5 py-3.5 border-b border-slate-50 bg-slate-50/40">
        <form method="GET" action="{{ route('recepcion.dashboard') }}" class="flex items-center gap-3 flex-wrap">
            <input type="hidden" name="tab" value="{{ $tab }}">
            @if(auth()->user()->is_admin)
            <input type="hidden" name="branch" value="{{ $branchCode }}">
            @endif

            {{-- Búsqueda --}}
            <div class="relative flex-1 min-w-[180px]">
                <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                <input type="text" name="q" value="{{ $buscar }}"
                       placeholder="Buscar por orden, cliente o serie…"
                       class="w-full pl-8 pr-3 py-2 text-sm border border-slate-200 rounded-xl focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500/10 transition-all bg-white">
            </div>

            {{-- Filtro técnico --}}
            <div class="relative">
                <i class="fa-solid fa-user-gear absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                <input type="text" name="tecnico" value="{{ $tecnico }}"
                       placeholder="Filtrar técnico…"
                       class="pl-8 pr-3 py-2 text-sm border border-slate-200 rounded-xl focus:outline-none focus:border-blue-500 transition-all bg-white w-44">
            </div>

            {{-- Filtro fecha (solo tab hoy) --}}
            @if($tab === 'hoy')
            <div class="relative">
                <i class="fa-solid fa-calendar absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                <input type="date" name="fecha" value="{{ $fecha }}"
                       class="pl-8 pr-3 py-2 text-sm border border-slate-200 rounded-xl focus:outline-none focus:border-blue-500 transition-all bg-white">
            </div>
            @endif

            <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-4 py-2 rounded-xl transition-colors flex items-center gap-1.5">
                <i class="fa-solid fa-filter text-xs"></i> Filtrar
            </button>

            @if($buscar || $tecnico || ($tab === 'hoy' && $fecha !== now()->format('Y-m-d')))
            <a href="{{ route('recepcion.dashboard', ['tab' => $tab]) }}"
               class="text-sm text-slate-400 hover:text-slate-600 border border-slate-200 px-3 py-2 rounded-xl transition-colors">
                <i class="fa-solid fa-xmark"></i> Limpiar
            </a>
            @endif
        </form>
    </div>
    @endif

    {{-- CONTENIDO DEL TAB --}}
    <div>

        {{-- ── LISTAS PARA ENTREGAR ──────────────────────────────────── --}}
        @if($tab === 'listas')
        @if($listas->isEmpty())
        <div class="py-16 text-center">
            <i class="fa-solid fa-circle-check text-slate-200 text-5xl mb-4 block"></i>
            <p class="text-slate-500 font-medium">No hay órdenes listas para entregar</p>
            @if($buscar || $tecnico)<p class="text-slate-400 text-sm mt-1">Prueba con otros filtros</p>@endif
        </div>
        @else
        <div class="divide-y divide-slate-50">
            @foreach($listas as $o)
            @php $nombre = trim(($o->nombres ?? '').' '.($o->apellidos ?? '')) ?: ($o->cliente ?? '—'); @endphp
            <div class="flex items-center gap-4 px-5 py-4 hover:bg-slate-50/60 transition-colors">
                <div class="w-10 h-10 bg-green-50 border border-green-100 rounded-xl flex items-center justify-center flex-shrink-0">
                    <i class="fa-solid fa-laptop text-green-500 text-sm"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <div class="flex items-center gap-2 flex-wrap mb-0.5">
                        <span class="font-mono text-sm font-bold text-blue-600">{{ $o->nro_orden }}</span>
                        <span class="text-xs text-slate-400">{{ trim(implode(' ', array_filter([$o->tipo ?? '', $o->marca ?? '', $o->modelo ?? '']))) }}</span>
                        @if($o->tecnico)<span class="text-xs text-slate-300">· {{ $o->tecnico }}</span>@endif
                    </div>
                    <p class="text-sm font-semibold text-slate-800 truncate">{{ $nombre }}</p>
                    @if($o->serie)<p class="text-xs text-slate-400 font-mono">Serie: {{ $o->serie }}</p>@endif
                </div>
                <div class="flex items-center gap-2 flex-shrink-0">
                    <span class="text-xs text-slate-400 hidden sm:block">{{ $o->fecha_de_ingreso_fmt }}</span>
                    @if($o->numero_contacto)
                    <a href="https://wa.me/593{{ ltrim($o->numero_contacto, '0') }}?text={{ urlencode('Hola '.$nombre.', le informamos que su equipo ('.$o->nro_orden.') está listo para retirar en '.$branchName.'. Horario: Lun-Vie 9:00-17:00.') }}"
                       target="_blank"
                       class="w-8 h-8 bg-green-500 hover:bg-green-600 text-white rounded-lg flex items-center justify-center transition-colors" title="WhatsApp">
                        <i class="fa-brands fa-whatsapp text-sm"></i>
                    </a>
                    @endif
                    <a href="{{ route('recepcion.ordenes', ['q' => $o->nro_orden, 'tipo' => 'nro_orden']) }}"
                       class="w-8 h-8 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-lg flex items-center justify-center transition-colors" title="Ver detalle">
                        <i class="fa-solid fa-arrow-right text-xs"></i>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
        <div class="px-5 py-4 border-t border-slate-100 bg-slate-50/30">
            {{ $listas->links() }}
        </div>
        @endif

        {{-- ── ATRASADAS ─────────────────────────────────────────────── --}}
        @elseif($tab === 'atrasadas')
        @if($atrasadas->isEmpty())
        <div class="py-16 text-center">
            <i class="fa-solid fa-face-smile text-slate-200 text-5xl mb-4 block"></i>
            <p class="text-slate-500 font-medium">¡Sin atrasos! Todo al día</p>
            @if($buscar || $tecnico)<p class="text-slate-400 text-sm mt-1">Prueba con otros filtros</p>@endif
        </div>
        @else
        <div class="divide-y divide-slate-50">
            @foreach($atrasadas as $o)
            @php $nombre = trim(($o->nombres ?? '').' '.($o->apellidos ?? '')) ?: ($o->cliente ?? '—'); @endphp
            <div class="flex items-center gap-4 px-5 py-4 hover:bg-red-50/30 transition-colors">
                <div class="w-10 h-10 bg-red-50 border border-red-100 rounded-xl flex items-center justify-center flex-shrink-0">
                    <i class="fa-solid fa-triangle-exclamation text-red-400 text-sm"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <div class="flex items-center gap-2 flex-wrap mb-0.5">
                        <span class="font-mono text-sm font-bold text-red-600">{{ $o->nro_orden }}</span>
                        <span class="text-xs px-2 py-0.5 rounded-full bg-amber-100 text-amber-700">{{ $o->estado_orden }}</span>
                        @if($o->tecnico)<span class="text-xs text-slate-400">· {{ $o->tecnico }}</span>@endif
                    </div>
                    <p class="text-sm font-semibold text-slate-800 truncate">{{ $nombre }}</p>
                    <p class="text-xs text-slate-400">{{ trim(implode(' ', array_filter([$o->tipo ?? '', $o->marca ?? '', $o->modelo ?? '']))) }}</p>
                </div>
                <div class="flex items-center gap-3 flex-shrink-0 text-right">
                    @if($o->fecha_prometido_fmt)
                    <div>
                        <p class="text-xs text-red-500 font-medium"><i class="fa-solid fa-clock mr-1"></i>{{ $o->fecha_prometido_fmt }}</p>
                        <p class="text-xs text-slate-400">prometida</p>
                    </div>
                    @endif
                    <a href="{{ route('recepcion.ordenes', ['q' => $o->nro_orden, 'tipo' => 'nro_orden']) }}"
                       class="w-8 h-8 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-lg flex items-center justify-center transition-colors">
                        <i class="fa-solid fa-arrow-right text-xs"></i>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
        <div class="px-5 py-4 border-t border-slate-100 bg-slate-50/30">
            {{ $atrasadas->links() }}
        </div>
        @endif

        {{-- ── INGRESADAS (fecha) ────────────────────────────────────── --}}
        @elseif($tab === 'hoy')
        @if($ingresadas->isEmpty())
        <div class="py-16 text-center">
            <i class="fa-solid fa-calendar-day text-slate-200 text-5xl mb-4 block"></i>
            <p class="text-slate-500 font-medium">No hay órdenes para la fecha seleccionada</p>
            @if($buscar || $tecnico)<p class="text-slate-400 text-sm mt-1">Prueba con otros filtros</p>@endif
        </div>
        @else
        <div class="divide-y divide-slate-50">
            @foreach($ingresadas as $o)
            @php
                $nombre = trim(($o->nombres ?? '').' '.($o->apellidos ?? '')) ?: ($o->cliente ?? '—');
                $sc = match($o->estado_orden) {
                    'En Revisión'   => 'bg-amber-100 text-amber-700',
                    'En Reparacion' => 'bg-blue-100 text-blue-700',
                    'Finalizada'    => 'bg-green-100 text-green-700',
                    'Entregada'     => 'bg-slate-100 text-slate-600',
                    default         => 'bg-slate-100 text-slate-500',
                };
            @endphp
            <div class="flex items-center gap-4 px-5 py-4 hover:bg-slate-50/60 transition-colors">
                <div class="w-10 h-10 bg-blue-50 border border-blue-100 rounded-xl flex items-center justify-center flex-shrink-0">
                    <i class="fa-solid fa-laptop text-blue-400 text-sm"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <div class="flex items-center gap-2 flex-wrap mb-0.5">
                        <span class="font-mono text-sm font-bold text-blue-600">{{ $o->nro_orden }}</span>
                        <span class="text-xs px-2 py-0.5 rounded-full {{ $sc }}">{{ $o->estado_orden }}</span>
                        @if($o->tecnico)<span class="text-xs text-slate-400">· {{ $o->tecnico }}</span>@endif
                    </div>
                    <p class="text-sm font-semibold text-slate-800 truncate">{{ $nombre }}</p>
                    <p class="text-xs text-slate-400">{{ trim(implode(' ', array_filter([$o->tipo ?? '', $o->marca ?? '', $o->modelo ?? '']))) }}</p>
                </div>
                <div class="flex items-center gap-2 flex-shrink-0">
                    <span class="text-xs text-slate-400 hidden sm:block">{{ $o->fecha_de_ingreso_fmt }}</span>
                    <a href="{{ route('recepcion.ordenes', ['q' => $o->nro_orden, 'tipo' => 'nro_orden']) }}"
                       class="w-8 h-8 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-lg flex items-center justify-center transition-colors">
                        <i class="fa-solid fa-arrow-right text-xs"></i>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
        <div class="px-5 py-4 border-t border-slate-100 bg-slate-50/30">
            {{ $ingresadas->links() }}
        </div>
        @endif

        {{-- ── RESUMEN POR ESTADO ────────────────────────────────────── --}}
        @elseif($tab === 'resumen')
        @if(!$porEstado || $porEstado->isEmpty())
        <div class="py-16 text-center">
            <p class="text-slate-400 text-sm">Sin datos disponibles</p>
        </div>
        @else
        @php $total = $porEstado->sum('total'); @endphp
        <div class="divide-y divide-slate-50">
            @foreach($porEstado as $es)
            @php
                $pct = $total > 0 ? round($es->total / $total * 100) : 0;
                $barColor = match($es->estado_orden) {
                    'Finalizada'         => 'bg-green-400',
                    'Entregada'          => 'bg-slate-300',
                    'En Revisión'        => 'bg-amber-400',
                    'En Reparacion'      => 'bg-blue-400',
                    'Esperando Repuesto' => 'bg-violet-400',
                    'Anulada'            => 'bg-red-300',
                    default              => 'bg-slate-200',
                };
            @endphp
            <div class="flex items-center gap-4 px-6 py-4 hover:bg-slate-50/50 transition-colors">
                <div class="flex-1 min-w-0">
                    <div class="flex items-center justify-between mb-1.5">
                        <span class="text-sm font-medium text-slate-700">{{ $es->estado_orden }}</span>
                        <div class="flex items-center gap-3">
                            <span class="text-xs text-slate-400">{{ $pct }}%</span>
                            <span class="text-base font-bold text-slate-900">{{ $es->total }}</span>
                        </div>
                    </div>
                    <div class="w-full bg-slate-100 rounded-full h-2">
                        <div class="h-2 rounded-full {{ $barColor }} transition-all" style="width:{{ $pct }}%"></div>
                    </div>
                </div>
                <a href="{{ route('recepcion.ordenes', ['q' => '', 'tipo' => 'nro_orden']) }}"
                   class="w-8 h-8 bg-slate-100 hover:bg-slate-200 text-slate-500 rounded-lg flex items-center justify-center flex-shrink-0 transition-colors">
                    <i class="fa-solid fa-arrow-right text-xs"></i>
                </a>
            </div>
            @endforeach
        </div>
        <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/30 flex items-center justify-between">
            <p class="text-sm text-slate-500">Total: <strong class="text-slate-800">{{ $total }}</strong> órdenes en {{ $branchName }}</p>
        </div>
        @endif
        @endif

    </div>
</div>

@endsection
