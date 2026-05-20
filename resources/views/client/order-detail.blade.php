@extends('layouts.app')

@section('title', 'Detalle de orden')

@section('content')

<div class="min-h-screen pt-24 pb-16 px-6" style="background:linear-gradient(135deg,#f0f4ff 0%,#e8f0fe 25%,#fdf4ff 50%,#f0f9ff 75%,#ecfdf5 100%);">
    <div class="max-w-2xl mx-auto">

        <a href="{{ route('client.orders') }}" class="inline-flex items-center gap-2 text-sm text-slate-500 hover:text-slate-700 mb-6 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Volver a mis órdenes
        </a>

        <div class="bg-white border border-slate-100 rounded-2xl overflow-hidden">

            {{-- HEADER --}}
            <div class="p-6 border-b border-slate-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs text-slate-400 font-light mb-1">Número de orden</p>
                        <p class="font-bold text-slate-900 text-lg">{{ $order->nro_orden }}</p>
                    </div>
                    <span class="text-sm font-medium px-4 py-2 rounded-full {{ $order->status_color }}">
                        {{ $order->status_label }}
                    </span>
                </div>
            </div>

            {{-- DETALLES DEL EQUIPO --}}
            <div class="p-6 border-b border-slate-100">
                <p class="text-xs font-semibold tracking-widest uppercase text-slate-400 mb-4">Detalles del equipo</p>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-xs text-slate-400 font-light">Tipo</p>
                        <p class="text-slate-900 text-sm font-medium">{{ $order->tipo }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-400 font-light">Marca</p>
                        <p class="text-slate-900 text-sm font-medium">{{ $order->marca }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-400 font-light">Modelo</p>
                        <p class="text-slate-900 text-sm font-medium">{{ $order->modelo }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-400 font-light">Serie</p>
                        <p class="text-slate-900 text-sm font-medium">{{ $order->serie }}</p>
                    </div>
                    @if($order->falla)
                    <div class="col-span-2">
                        <p class="text-xs text-slate-400 font-light">Falla reportada</p>
                        <p class="text-slate-900 text-sm">{{ $order->falla }}</p>
                    </div>
                    @endif
                    @if($order->observacion)
                    <div class="col-span-2">
                        <p class="text-xs text-slate-400 font-light">Observaciones del técnico</p>
                        <p class="text-slate-900 text-sm">{{ $order->observacion }}</p>
                    </div>
                    @endif
                </div>
            </div>

            {{-- INFO DE SERVICIO --}}
            <div class="p-6 border-b border-slate-100">
                <p class="text-xs font-semibold tracking-widest uppercase text-slate-400 mb-4">Información del servicio</p>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-xs text-slate-400 font-light">Técnico asignado</p>
                        <p class="text-slate-900 text-sm font-medium">{{ $order->tecnico }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-400 font-light">Sucursal</p>
                        <p class="text-slate-900 text-sm font-medium">{{ $order->sucursal }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-400 font-light">Fecha de ingreso</p>
                        <p class="text-slate-900 text-sm font-medium">{{ $order->fecha_de_ingreso_fmt }}</p>
                    </div>
                    @if($order->fecha_entrega_fmt)
                    <div>
                        <p class="text-xs text-slate-400 font-light">Fecha de entrega</p>
                        <p class="text-slate-900 text-sm font-medium">{{ $order->fecha_entrega_fmt }}</p>
                    </div>
                    @endif
                    @if($order->estado_repuesto)
                    <div>
                        <p class="text-xs text-slate-400 font-light">Estado repuesto</p>
                        <p class="text-slate-900 text-sm font-medium">{{ $order->estado_repuesto }}</p>
                    </div>
                    @endif
                    @if($order->estado_garantia)
                    <div>
                        <p class="text-xs text-slate-400 font-light">Garantía</p>
                        <p class="text-slate-900 text-sm font-medium">{{ $order->estado_garantia }}</p>
                    </div>
                    @endif
                </div>
            </div>

            {{-- FOOTER --}}
            <div class="p-6 bg-slate-50">
                <p class="text-xs text-slate-400 font-light text-center">
                    Orden registrada el {{ $order->fecha_de_ingreso_fmt }}
                </p>
            </div>

        </div>
    </div>
</div>

@endsection
