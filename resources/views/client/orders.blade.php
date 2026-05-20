@extends('layouts.app')

@section('title', 'Mis órdenes')

@section('content')

<div class="min-h-screen pt-20 pb-16 px-4 md:px-6" style="background:linear-gradient(135deg,#f0f4ff 0%,#e8f0fe 25%,#fdf4ff 50%,#f0f9ff 75%,#ecfdf5 100%);">
    <div class="max-w-3xl mx-auto">

        {{-- HEADER --}}
        <div class="py-8 flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold tracking-widest uppercase text-blue-600 mb-1">Mi cuenta</p>
                <h1 class="text-2xl md:text-3xl font-bold text-slate-900" style="font-family:'Playfair Display',serif;">Mis órdenes</h1>
                <p class="text-slate-500 text-sm font-light mt-1">{{ auth()->user()->name }}</p>
            </div>
            <a href="{{ route('profile.edit') }}"
               class="flex items-center gap-2 text-xs border border-slate-200 hover:border-blue-300 text-slate-500 hover:text-blue-600 px-3 py-2 rounded-xl transition-all bg-white shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                Mi perfil
            </a>
        </div>

        {{-- ÓRDENES --}}
        <div class="space-y-3">
            @forelse($orders as $order)
            <a href="{{ route('client.order.show', $order->nro_orden) }}"
               class="block bg-white border border-slate-100 rounded-2xl p-5 hover:border-blue-200 hover:shadow-md transition-all">

                <div class="flex items-start justify-between gap-3">
                    <div class="flex items-center gap-3 min-w-0">
                        <div class="w-10 h-10 bg-blue-50 border border-blue-100 rounded-xl flex items-center justify-center text-lg flex-shrink-0">
                            @if(str_contains(strtolower($order->tipo ?? ''), 'celular') || str_contains(strtolower($order->tipo ?? ''), 'smartphone'))
                                📱
                            @elseif(str_contains(strtolower($order->tipo ?? ''), 'impresora'))
                                🖨️
                            @else
                                💻
                            @endif
                        </div>
                        <div class="min-w-0">
                            <p class="text-slate-900 font-semibold text-sm truncate">
                                {{ $order->marca }} {{ $order->modelo }}
                            </p>
                            <p class="text-slate-400 text-xs font-light">{{ $order->nro_orden }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 flex-shrink-0">
                        <span class="text-xs font-medium px-2.5 py-1 rounded-full {{ $order->status_color }}">
                            {{ $order->status_label }}
                        </span>
                        <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </div>
                </div>

                <div class="mt-3 pt-3 border-t border-slate-50 flex items-center gap-4 text-xs text-slate-400 font-light flex-wrap">
                    <span>📅 {{ $order->fecha_de_ingreso_fmt }}</span>
                    @if($order->estado_orden !== 'Entregada' && $order->fecha_entrega_fmt)
                    <span>🕐 Entrega: {{ $order->fecha_entrega_fmt }}</span>
                    @endif
                    @if($order->sucursal)
                    <span>📍 {{ $order->sucursal }}</span>
                    @endif
                </div>

            </a>
            @empty
            <div class="bg-white border border-slate-100 rounded-2xl p-12 text-center">
                <div class="text-5xl mb-4">📭</div>
                <p class="text-slate-900 font-semibold mb-2">No tienes órdenes aún</p>
                <p class="text-slate-400 text-sm font-light mb-6">Cuando traigas tu equipo al servicio técnico podrás ver el estado aquí.</p>
                <a href="/#contacto" class="inline-block bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-8 py-3 rounded-xl transition-colors">
                    Contáctenos
                </a>
            </div>
            @endforelse
        </div>

    </div>
</div>

@endsection
