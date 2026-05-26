@extends('layouts.app')

@section('title', $service->name . ' – Novitecnología Cia. Ltda.')

@section('content')

<style>
@import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;800&family=Inter:wght@300;400;500&display=swap');
body { font-family: 'Inter', sans-serif; }
.font-serif { font-family: 'Playfair Display', serif; }
.reveal { opacity:0; transform:translateY(30px); transition:opacity .8s ease,transform .8s ease; }
.reveal.visible { opacity:1; transform:translateY(0); }
</style>

{{-- HERO --}}
<section class="relative pt-36 pb-16 px-6 overflow-hidden" style="background:linear-gradient(135deg,#020817 0%,#0c1a35 50%,#020817 100%);">
    <div class="absolute inset-0 pointer-events-none" style="background-image:linear-gradient(rgba(59,130,246,.04) 1px,transparent 1px),linear-gradient(90deg,rgba(59,130,246,.04) 1px,transparent 1px);background-size:60px 60px"></div>
    <div class="relative max-w-4xl mx-auto text-center">
        <a href="{{ route('servicios') }}" class="inline-flex items-center gap-2 text-slate-400 hover:text-white text-xs mb-6 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Volver a servicios
        </a>
        <span class="block text-xs font-semibold tracking-widest uppercase text-blue-400 mb-4">
            {{ ucwords(str_replace('-', ' ', $service->category)) }}
        </span>
        <h1 class="font-serif text-4xl md:text-5xl font-bold text-white mb-4 leading-tight reveal">
            {{ $service->name }}
        </h1>
        @if($service->price)
        <span class="inline-block text-sm font-semibold text-blue-300 bg-blue-600/20 border border-blue-500/30 px-4 py-2 rounded-full reveal">
            {{ $service->price }}
        </span>
        @endif
    </div>
</section>

{{-- CONTENIDO PRINCIPAL --}}
<section class="py-20 px-6 bg-white">
    <div class="max-w-5xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-16 items-start">

        {{-- IMAGEN --}}
        <div class="reveal">
            @if($service->image_src)
            <img src="{{ $service->image_src }}" alt="{{ $service->name }}"
                 class="w-full rounded-2xl object-cover shadow-xl aspect-video">
            @else
            <div class="w-full rounded-2xl bg-gradient-to-br from-blue-50 to-slate-100 flex items-center justify-center aspect-video">
                <svg class="w-16 h-16 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 3H5a2 2 0 00-2 2v4m6-6h10a2 2 0 012 2v4M9 3v18m0 0h10a2 2 0 002-2v-4M9 21H5a2 2 0 01-2-2v-4m0 0h18"/>
                </svg>
            </div>
            @endif
        </div>

        {{-- DESCRIPCIÓN Y CONTACTO --}}
        <div class="reveal">
            @if($service->description)
            <p class="text-slate-600 leading-relaxed text-base font-light mb-8">
                {{ $service->description }}
            </p>
            @endif

            {{-- PRECIO --}}
            @if($service->price)
            <div class="bg-blue-50 border border-blue-100 rounded-2xl p-5 mb-8">
                <p class="text-xs text-blue-400 font-semibold uppercase tracking-widest mb-1">Precio</p>
                <p class="text-2xl font-bold text-blue-700">{{ $service->price }}</p>
            </div>
            @endif

            {{-- BOTÓN WHATSAPP --}}
            @php
                $sucursal = \App\Models\Branch::where('active', true)->orderBy('order')->first();
                $whatsapp = $sucursal?->whatsapp ?? $sucursal?->phone ?? '';
                $whatsapp = preg_replace('/[^0-9]/', '', $whatsapp);
                $mensaje = urlencode('Hola, me interesa el servicio: ' . $service->name . '. ¿Me pueden dar más información?');
            @endphp

            @if($whatsapp)
            <a href="https://wa.me/593{{ ltrim($whatsapp, '0') }}?text={{ $mensaje }}"
               target="_blank"
               class="flex items-center justify-center gap-3 w-full bg-emerald-500 hover:bg-emerald-600 text-white font-semibold text-sm px-6 py-4 rounded-2xl transition-all shadow-lg hover:shadow-emerald-200">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                </svg>
                Consultar por WhatsApp
            </a>
            @endif

            <a href="{{ route('contacto') }}"
               class="flex items-center justify-center gap-2 w-full mt-3 border border-slate-200 text-slate-600 hover:border-blue-400 hover:text-blue-600 text-sm px-6 py-3.5 rounded-2xl transition-all">
                Enviar consulta por formulario
            </a>
        </div>
    </div>
</section>

{{-- CTA --}}
<section class="py-20 px-6" style="background:linear-gradient(135deg,#1d4ed8 0%,#4f46e5 50%,#7c3aed 100%);">
    <div class="max-w-3xl mx-auto text-center">
        <h2 class="font-serif text-3xl font-bold text-white mb-4">¿Te interesa este servicio?</h2>
        <p class="text-blue-100 font-light mb-8">Contáctanos hoy y recibe atención personalizada.</p>
        <a href="{{ route('servicios') }}"
           class="bg-white text-blue-700 hover:bg-yellow-300 hover:text-blue-900 text-sm font-semibold px-8 py-3.5 rounded-xl transition-all">
            Ver más servicios
        </a>
    </div>
</section>

@endsection

@push('scripts')
<script>
const observer = new IntersectionObserver((entries) => {
    entries.forEach(e => { if(e.isIntersecting) e.target.classList.add('visible'); });
}, { threshold: 0.1 });
document.querySelectorAll('.reveal').forEach(el => observer.observe(el));
</script>
@endpush
