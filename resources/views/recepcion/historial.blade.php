@extends('layouts.recepcion')

@section('title', 'Historial de cliente')
@section('page-title', 'Historial de cliente')
@section('page-subtitle', 'Todas las órdenes de un cliente')

@section('content')

{{-- BUSCADOR --}}
<div class="bg-white border border-slate-100 rounded-2xl shadow-sm overflow-hidden mb-6">
    <div class="px-6 py-5 border-b border-slate-100 bg-slate-50/40">
        <form method="GET" action="{{ route('recepcion.historial') }}" class="flex gap-3 flex-wrap items-end">
            <div class="flex-1 min-w-[200px]">
                <label class="block text-xs font-semibold text-slate-500 mb-1.5">Buscar por CI / RUC</label>
                <div class="relative">
                    <i class="fa-solid fa-id-card absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                    <input type="text" name="ci" value="{{ $ci }}" placeholder="Ej: 1712345678"
                           class="w-full pl-8 pr-3 py-2.5 text-sm border border-slate-200 rounded-xl focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500/10 transition-all font-mono">
                </div>
            </div>
            <div class="flex-1 min-w-[200px]">
                <label class="block text-xs font-semibold text-slate-500 mb-1.5">Buscar por nombre</label>
                <div class="relative">
                    <i class="fa-solid fa-user absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                    <input type="text" name="nombre" value="{{ $nombre }}" placeholder="Nombre o apellido del cliente"
                           class="w-full pl-8 pr-3 py-2.5 text-sm border border-slate-200 rounded-xl focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500/10 transition-all">
                </div>
            </div>
            <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-5 py-2.5 rounded-xl transition-colors flex items-center gap-2">
                <i class="fa-solid fa-search"></i> Buscar
            </button>
            @if($ci || $nombre)
            <a href="{{ route('recepcion.historial') }}"
               class="border border-slate-200 text-slate-500 hover:text-slate-700 px-4 py-2.5 rounded-xl text-sm transition-colors">
                <i class="fa-solid fa-xmark"></i>
            </a>
            @endif
        </form>
    </div>

    {{-- INFO CLIENTE --}}
    @if($clienteInfo)
    <div class="px-6 py-4 border-b border-slate-100 bg-blue-50/30">
        <div class="flex items-center gap-4 flex-wrap">
            <div class="w-12 h-12 rounded-2xl flex items-center justify-center text-white text-lg font-bold flex-shrink-0"
                 style="background:linear-gradient(135deg,#2563eb,#7c3aed)">
                {{ strtoupper(substr($clienteInfo['nombre'], 0, 1)) }}
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-slate-900 font-bold text-base">{{ $clienteInfo['nombre'] }}</p>
                <div class="flex items-center gap-4 flex-wrap mt-0.5">
                    @if($clienteInfo['identificacion'])
                    <span class="text-xs text-slate-500 font-mono"><i class="fa-solid fa-id-card mr-1 text-slate-400"></i>{{ $clienteInfo['identificacion'] }}</span>
                    @endif
                    @if($clienteInfo['contacto'])
                    <a href="tel:{{ $clienteInfo['contacto'] }}" class="text-xs text-blue-600 hover:text-blue-800">
                        <i class="fa-solid fa-phone mr-1"></i>{{ $clienteInfo['contacto'] }}
                    </a>
                    @endif
                    @if($clienteInfo['correo'])
                    <span class="text-xs text-slate-500"><i class="fa-solid fa-envelope mr-1 text-slate-400"></i>{{ $clienteInfo['correo'] }}</span>
                    @endif
                </div>
            </div>
            <div class="text-right flex-shrink-0">
                <p class="text-2xl font-bold text-blue-700">{{ $clienteInfo['total'] }}</p>
                <p class="text-xs text-slate-400">órdenes totales</p>
            </div>
        </div>
    </div>
    @endif

    {{-- LISTA DE ÓRDENES --}}
    @if($orders === null)
    <div class="py-16 text-center">
        <i class="fa-solid fa-clock-rotate-left text-slate-200 text-5xl mb-4 block"></i>
        <p class="text-slate-500 font-medium">Busca un cliente</p>
        <p class="text-slate-400 text-sm mt-1">Ingresa el CI/RUC o nombre para ver su historial de órdenes</p>
    </div>
    @elseif($orders->isEmpty())
    <div class="py-16 text-center">
        <i class="fa-solid fa-file-circle-xmark text-slate-200 text-5xl mb-4 block"></i>
        <p class="text-slate-500 font-medium">Sin resultados</p>
        <p class="text-slate-400 text-sm mt-1">No se encontraron órdenes para ese criterio en {{ $branchName }}</p>
    </div>
    @else
    <div class="divide-y divide-slate-50">
        @foreach($orders as $o)
        @php
            $nombre = trim(($o->nombres ?? '').' '.($o->apellidos ?? '')) ?: ($o->cliente ?? '—');
            $equipo = trim(implode(' ', array_filter([$o->tipo ?? '', $o->marca ?? '', $o->modelo ?? ''])));
            $sc = match($o->estado_orden ?? '') {
                'En Revisión'        => 'bg-amber-100 text-amber-700',
                'En Reparacion'      => 'bg-blue-100 text-blue-700',
                'Esperando Repuesto' => 'bg-violet-100 text-violet-700',
                'Finalizada'         => 'bg-green-100 text-green-700',
                'Entregada'          => 'bg-slate-100 text-slate-500',
                'Anulada'            => 'bg-red-100 text-red-600',
                default              => 'bg-slate-100 text-slate-500',
            };
            // Días en taller
            $diasTaller = null;
            if (!empty($o->fecha_de_ingreso)) {
                try { $diasTaller = now()->diffInDays(\Carbon\Carbon::parse($o->fecha_de_ingreso)); } catch (\Throwable) {}
            }
            $semaforo = match(true) {
                $diasTaller === null => '',
                $diasTaller <= 3  => 'bg-green-400',
                $diasTaller <= 7  => 'bg-amber-400',
                default           => 'bg-red-500',
            };
        @endphp
        <div class="flex items-center gap-4 px-6 py-4 hover:bg-slate-50/50 transition-colors">
            {{-- Semáforo --}}
            @if($diasTaller !== null && !in_array($o->estado_orden, ['Entregada','Anulada']))
            <div class="w-3 h-3 rounded-full flex-shrink-0 {{ $semaforo }}" title="{{ $diasTaller }} días en taller"></div>
            @else
            <div class="w-3 h-3 rounded-full flex-shrink-0 bg-slate-200"></div>
            @endif

            <div class="flex-1 min-w-0">
                <div class="flex items-center gap-2 flex-wrap mb-0.5">
                    <span class="font-mono text-sm font-bold text-blue-600">{{ $o->nro_orden }}</span>
                    <span class="text-xs px-2 py-0.5 rounded-full font-medium {{ $sc }}">{{ $o->estado_orden ?? '—' }}</span>
                    @if($diasTaller !== null && !in_array($o->estado_orden ?? '', ['Entregada','Anulada']))
                    <span class="text-xs text-slate-400">{{ $diasTaller }}d en taller</span>
                    @endif
                </div>
                <p class="text-sm text-slate-700 truncate">{{ $equipo ?: '—' }}</p>
                <p class="text-xs text-slate-400">{{ $o->fecha_de_ingreso_fmt ?? '—' }} · Téc: {{ $o->tecnico ?? '—' }}</p>
            </div>

            <div class="flex items-center gap-2 flex-shrink-0">
                <a href="{{ route('recepcion.ordenes', ['q' => $o->nro_orden, 'tipo' => 'nro_orden']) }}"
                   class="text-xs border border-blue-200 bg-blue-50 text-blue-600 hover:bg-blue-100 px-3 py-1.5 rounded-lg transition-colors">
                    Ver detalle →
                </a>
            </div>
        </div>
        @endforeach
    </div>
    <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/30">
        {{ $orders->links() }}
    </div>
    @endif
</div>

@endsection
