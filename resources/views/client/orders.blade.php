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
                        <div class="w-10 h-10 bg-blue-50 border border-blue-100 rounded-xl flex items-center justify-center text-lg flex-shrink-0 text-blue-600">
                            @if(str_contains(strtolower($order->tipo ?? ''), 'celular') || str_contains(strtolower($order->tipo ?? ''), 'smartphone'))
                                <i class="fa-solid fa-mobile-screen"></i>
                            @elseif(str_contains(strtolower($order->tipo ?? ''), 'impresora'))
                                <i class="fa-solid fa-print"></i>
                            @else
                                <i class="fa-solid fa-laptop"></i>
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
                    <span><i class="fa-solid fa-calendar-days"></i> {{ $order->fecha_de_ingreso_fmt }}</span>
                    @if($order->estado_orden !== 'Entregada' && $order->fecha_entrega_fmt)
                    <span><i class="fa-solid fa-clock"></i> Entrega: {{ $order->fecha_entrega_fmt }}</span>
                    @endif
                    @if($order->sucursal)
                    <span><i class="fa-solid fa-location-dot"></i> {{ $order->sucursal }}</span>
                    @endif
                </div>

            </a>
            @empty
            <div class="bg-white border border-slate-100 rounded-2xl p-12 text-center">
                <div class="text-5xl mb-4 text-slate-300"><i class="fa-solid fa-box-open"></i></div>
                <p class="text-slate-900 font-semibold mb-2">No tienes órdenes aún</p>
                <p class="text-slate-400 text-sm font-light mb-6">Cuando traigas tu equipo al servicio técnico podrás ver el estado aquí.</p>
                <a href="/#contacto" class="inline-block bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-8 py-3 rounded-xl transition-colors">
                    Contáctenos
                </a>
            </div>
            @endforelse
        </div>

        {{-- SUGGESTIONS BOX --}}
        <div class="mt-8 bg-white border border-slate-100 rounded-2xl p-6 shadow-sm">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-8 h-8 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center text-blue-600">
                    <i class="fa-solid fa-lightbulb text-sm"></i>
                </div>
                <div>
                    <h2 class="text-sm font-semibold text-slate-900">Buzón de sugerencias</h2>
                    <p class="text-xs text-slate-400 font-light">Ayúdanos a mejorar nuestro servicio técnico</p>
                </div>
            </div>
            
            <form id="sugerenciaForm" method="POST" action="{{ route('client.sugerencia.send') }}">
                @csrf
                <div class="mb-4">
                    <label for="texto_sugerencia" class="block text-xs text-slate-500 mb-1.5">Escribe tu sugerencia, reclamo o comentario:</label>
                    <textarea id="texto_sugerencia" name="texto" rows="4" required minlength="10"
                              placeholder="Escribe aquí tu sugerencia..."
                              class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-blue-400 focus:ring-1 focus:ring-blue-400 transition-colors resize-none"></textarea>
                </div>
                <div class="flex items-center justify-between gap-4">
                    <span class="text-[11px] text-slate-400 font-light">Se enviará al administrador máster del sistema.</span>
                    <button type="submit" id="btnSubmitSugerencia"
                            class="bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold px-5 py-2.5 rounded-xl transition-all shadow-sm flex items-center gap-2">
                        <i class="fa-solid fa-paper-plane"></i> Enviar sugerencia
                    </button>
                </div>
            </form>
            <div id="sugerenciaSuccess" class="hidden mt-4 bg-emerald-50 border border-emerald-100 text-emerald-700 text-xs px-4 py-3 rounded-xl flex items-center gap-2">
                <i class="fa-solid fa-circle-check"></i>
                <span>¡Gracias! Tu sugerencia ha sido enviada con éxito.</span>
            </div>
            <div id="sugerenciaError" class="hidden mt-4 bg-red-50 border border-red-100 text-red-700 text-xs px-4 py-3 rounded-xl flex items-center gap-2">
                <i class="fa-solid fa-circle-exclamation"></i>
                <span id="sugerenciaErrorText">Ocurrió un error al enviar la sugerencia. Intenta nuevamente.</span>
            </div>
        </div>

    </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('sugerenciaForm');
    const successDiv = document.getElementById('sugerenciaSuccess');
    const errorDiv = document.getElementById('sugerenciaError');
    const errorText = document.getElementById('sugerenciaErrorText');
    const btn = document.getElementById('btnSubmitSugerencia');

    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            btn.disabled = true;
            const originalBtnHtml = btn.innerHTML;
            btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Enviando...';
            
            successDiv.classList.add('hidden');
            errorDiv.classList.add('hidden');

            const formData = new FormData(form);

            fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(response => response.json().then(data => ({ status: response.status, body: data })))
            .then(res => {
                btn.disabled = false;
                btn.innerHTML = originalBtnHtml;
                
                if (res.status === 200 && res.body.ok) {
                    successDiv.classList.remove('hidden');
                    form.reset();
                } else {
                    errorText.textContent = res.body.error || 'Ocurrió un error al enviar la sugerencia.';
                    errorDiv.classList.remove('hidden');
                }
            })
            .catch(err => {
                btn.disabled = false;
                btn.innerHTML = originalBtnHtml;
                errorText.textContent = 'Error de conexión. Por favor intenta nuevamente.';
                errorDiv.classList.remove('hidden');
            });
        });
    }
});
</script>
@endpush
