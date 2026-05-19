@extends('layouts.app')

@section('title', 'Novitec – Servicio Técnico & Soporte IT')

@section('content')

<style>
    .reveal {
        opacity: 0;
        transform: translateY(40px);
        transition: opacity 0.7s ease, transform 0.7s ease;
    }
    .reveal.visible {
        opacity: 1;
        transform: translateY(0);
    }
    .reveal-left {
        opacity: 0;
        transform: translateX(-40px);
        transition: opacity 0.7s ease, transform 0.7s ease;
    }
    .reveal-left.visible {
        opacity: 1;
        transform: translateX(0);
    }
    .reveal-right {
        opacity: 0;
        transform: translateX(40px);
        transition: opacity 0.7s ease, transform 0.7s ease;
    }
    .reveal-right.visible {
        opacity: 1;
        transform: translateX(0);
    }
    .delay-1 { transition-delay: 0.1s; }
    .delay-2 { transition-delay: 0.2s; }
    .delay-3 { transition-delay: 0.3s; }
    .delay-4 { transition-delay: 0.4s; }
</style>

{{-- HERO --}}
<div class="relative h-screen min-h-[600px] flex items-center justify-center overflow-hidden">
    <img src="https://images.unsplash.com/photo-1461749280684-dccba630e2f6?w=1600&q=80&fit=crop"
         alt="hero"
         class="absolute inset-0 w-full h-full object-cover">
    <div class="absolute inset-0 bg-neutral-900/70"></div>
    <div class="relative z-10 text-center px-8">
        <p class="text-xs font-semibold tracking-widest uppercase text-blue-400 mb-4 reveal">Servicio técnico especializado</p>
        <h1 class="text-6xl md:text-7xl font-bold tracking-tight text-white mb-6 reveal delay-1">
            Tu equipo de confianza<br>siempre disponible
        </h1>
        <p class="text-neutral-300 text-lg max-w-xl mx-auto mb-10 reveal delay-2">
            Reparamos computadores, celulares e impresoras. Brindamos soporte IT remoto y presencial, redes y CCTV.
        </p>
        <div class="flex items-center justify-center gap-4 reveal delay-3">
            <a href="#servicios" class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-8 py-3 rounded transition-colors">
                Ver servicios
            </a>
            <a href="#contacto" class="border border-white/40 hover:border-white text-white text-sm px-8 py-3 rounded transition-colors">
                Contáctenos
            </a>
        </div>
    </div>
</div>

{{-- STATS --}}
<div class="border-b border-neutral-100">
    <div class="max-w-7xl mx-auto grid grid-cols-2 md:grid-cols-4">
        @foreach([
            ['10+', 'Años de experiencia'],
            ['500+', 'Equipos reparados'],
            ['24/7', 'Soporte remoto'],
            ['100%', 'Garantía de servicio'],
        ] as $stat)
        <div class="reveal py-10 px-8 border-r border-neutral-100 last:border-r-0">
            <p class="text-3xl font-bold text-neutral-900">{{ $stat[0] }}</p>
            <p class="text-sm text-neutral-500 mt-1">{{ $stat[1] }}</p>
        </div>
        @endforeach
    </div>
</div>

{{-- SERVICIOS --}}
<section id="servicios" class="py-24 px-6">
    <div class="max-w-7xl mx-auto">
        <p class="text-xs font-semibold tracking-widest uppercase text-blue-600 mb-3 reveal">Lo que hacemos</p>
        <h2 class="text-4xl font-bold text-neutral-900 mb-4 reveal delay-1">Nuestros servicios</h2>
        <p class="text-neutral-500 max-w-lg mb-16 reveal delay-2">Soluciones técnicas completas para personas y empresas — rápido, confiable y con garantía.</p>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach([
                ['💻', 'Reparación de computadores', 'Diagnóstico, mantenimiento, cambio de piezas y recuperación de datos para laptops y PCs de cualquier marca.'],
                ['📱', 'Reparación de celulares', 'Cambio de pantallas, baterías, conectores y solución de fallas de software en smartphones y tablets.'],
                ['🖨️', 'Servicio de impresoras', 'Mantenimiento, recarga de tóner, reparación de cabezales y configuración de impresoras en red.'],
                ['🖥️', 'Soporte IT remoto y presencial', 'Asistencia técnica para empresas y hogares — resolución de problemas de software, sistemas y usuarios.'],
                ['🌐', 'Redes', 'Diseño, instalación y configuración de redes cableadas e inalámbricas para hogares y oficinas.'],
                ['📷', 'CCTV', 'Instalación y configuración de sistemas de videovigilancia con acceso remoto desde cualquier dispositivo.'],
            ] as $i => $s)
            <div class="reveal border border-neutral-100 rounded-xl p-7 hover:border-blue-200 hover:shadow-sm transition-all"
                 style="transition-delay: {{ $i * 0.1 }}s">
                <div class="text-3xl mb-5">{{ $s[0] }}</div>
                <h3 class="text-base font-semibold text-neutral-900 mb-2">{{ $s[1] }}</h3>
                <p class="text-sm text-neutral-500 leading-relaxed">{{ $s[2] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- POR QUÉ NOSOTROS --}}
<section id="nosotros" class="py-24 px-6 bg-neutral-50">
    <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-16 items-center">
        <div>
            <p class="text-xs font-semibold tracking-widest uppercase text-blue-600 mb-3 reveal-left">Por qué Novitec</p>
            <h2 class="text-4xl font-bold text-neutral-900 mb-6 reveal-left delay-1">Rápido, confiable<br>y con garantía</h2>
            <div class="space-y-6">
                @foreach([
                    ['Diagnóstico sin costo', 'Revisamos tu equipo sin costo antes de comprometerte a cualquier reparación.'],
                    ['Técnicos certificados', 'Nuestro equipo cuenta con experiencia y certificaciones en las principales marcas del mercado.'],
                    ['Garantía en todos los servicios', 'Todos nuestros trabajos incluyen garantía — si falla, lo resolvemos sin costo adicional.'],
                ] as $i => $f)
                <div class="flex gap-4 reveal-left" style="transition-delay: {{ ($i+2) * 0.1 }}s">
                    <div class="w-7 h-7 bg-blue-600 rounded flex items-center justify-center flex-shrink-0 mt-0.5">
                        <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                    <div>
                        <p class="font-semibold text-neutral-900 text-sm mb-1">{{ $f[0] }}</p>
                        <p class="text-sm text-neutral-500 leading-relaxed">{{ $f[1] }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        <div class="reveal-right">
            <img src="https://images.unsplash.com/photo-1588702547923-7408eb6e9826?w=800&q=80&fit=crop"
                 alt="Técnico Novitec"
                 class="rounded-2xl w-full object-cover aspect-4/3">
        </div>
    </div>
</section>

{{-- CTA --}}
<section id="contacto" class="py-24 px-6 bg-blue-700">
    <div class="max-w-3xl mx-auto text-center">
        <h2 class="text-4xl font-bold text-white mb-4 reveal">¿Tu equipo tiene un problema?</h2>
        <p class="text-blue-200 mb-10 reveal delay-1">Contáctanos hoy — diagnóstico sin costo y atención rápida garantizada.</p>
        <div class="flex justify-center gap-4 reveal delay-2">
            <a href="mailto:info@novitec.com" class="bg-white text-blue-700 font-medium text-sm px-8 py-3 rounded hover:bg-blue-50 transition-colors">
                Escribirnos
            </a>
            <a href="https://wa.me/593000000000" target="_blank" class="border border-white/40 text-white text-sm px-8 py-3 rounded hover:border-white transition-colors">
                WhatsApp
            </a>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
            }
        });
    }, { threshold: 0.15 });

    document.querySelectorAll('.reveal, .reveal-left, .reveal-right').forEach(el => {
        observer.observe(el);
    });
</script>
@endpush
