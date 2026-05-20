@extends('layouts.app')

@section('title', 'Servicios – Novitec')

@section('content')

<style>
@import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;800&family=Inter:wght@300;400;500&display=swap');
body { font-family: 'Inter', sans-serif; }
.font-serif { font-family: 'Playfair Display', serif; }

.reveal { opacity:0; transform:translateY(30px); transition:opacity .8s ease,transform .8s ease; }
.reveal.visible { opacity:1; transform:translateY(0); }
.reveal-left { opacity:0; transform:translateX(-40px); transition:opacity .8s ease,transform .8s ease; }
.reveal-left.visible { opacity:1; transform:translateX(0); }
.reveal-right { opacity:0; transform:translateX(40px); transition:opacity .8s ease,transform .8s ease; }
.reveal-right.visible { opacity:1; transform:translateX(0); }
.d1{transition-delay:.1s}.d2{transition-delay:.2s}.d3{transition-delay:.3s}.d4{transition-delay:.4s}

.service-card {
    background:#fff;
    border:1px solid #e2e8f0;
    border-radius:20px;
    overflow:hidden;
    transition:all .4s ease;
    position:relative;
}
.service-card::after {
    content:'';
    position:absolute;
    bottom:0; left:0;
    width:0; height:3px;
    background:linear-gradient(90deg,#1d4ed8,#0ea5e9);
    transition:width .4s ease;
}
.service-card:hover::after { width:100%; }
.service-card:hover {
    border-color:#bfdbfe;
    transform:translateY(-5px);
    box-shadow:0 20px 40px rgba(59,130,246,.08);
}
</style>

{{-- HERO --}}
<section class="relative pt-36 pb-24 px-6 overflow-hidden" style="background:linear-gradient(135deg,#020817 0%,#0c1a35 50%,#020817 100%);">
    <div class="absolute inset-0 pointer-events-none" style="background-image:linear-gradient(rgba(59,130,246,.04) 1px,transparent 1px),linear-gradient(90deg,rgba(59,130,246,.04) 1px,transparent 1px);background-size:60px 60px"></div>
    <div class="absolute top-0 right-0 w-96 h-96 rounded-full blur-3xl pointer-events-none" style="background:radial-gradient(circle,rgba(59,130,246,.15),transparent 70%)"></div>

    <div class="relative max-w-4xl mx-auto text-center">
        <p class="text-xs font-semibold tracking-widest uppercase text-blue-400 mb-4 reveal">Lo que hacemos</p>
        <h1 class="font-serif text-5xl md:text-6xl font-bold text-white mb-6 reveal d1 leading-tight">
            Soluciones tecnológicas<br><span style="background:linear-gradient(90deg,#60a5fa,#a78bfa);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">para cada necesidad</span>
        </h1>
        <p class="text-slate-400 text-base font-light max-w-2xl mx-auto reveal d2 leading-relaxed">
            Desde la reparación de un equipo hasta la infraestructura IT completa de tu empresa — con garantía en cada servicio.
        </p>
    </div>
</section>

{{-- SERVICIO 1: REPARACIÓN --}}
<section class="py-24 px-6 bg-white">
    <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-16 items-center">
        <div class="reveal-left">
            <div class="w-12 h-12 bg-blue-50 border border-blue-100 rounded-2xl flex items-center justify-center text-2xl mb-6">🔧</div>
            <p class="text-xs font-semibold tracking-widest uppercase text-blue-600 mb-3">Servicio 01</p>
            <h2 class="font-serif text-4xl font-bold text-slate-900 mb-4 leading-tight">Reparación de equipos</h2>
            <p class="text-slate-500 font-light leading-relaxed mb-6">Diagnóstico, mantenimiento y reparación de computadores, laptops, celulares e impresoras de cualquier marca. Recuperación de datos y cambio de componentes con repuestos de calidad.</p>
            <ul class="space-y-3 mb-8">
                @foreach(['Computadores y laptops de cualquier marca','Celulares y tablets','Impresoras y periféricos','Recuperación de datos','Mantenimiento preventivo y correctivo'] as $item)
                <li class="flex items-center gap-3 text-sm text-slate-600">
                    <svg class="w-4 h-4 text-blue-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                    {{ $item }}
                </li>
                @endforeach
            </ul>
            <div class="flex items-center gap-3">
                <span class="text-xs font-semibold text-blue-600 bg-blue-50 border border-blue-100 px-3 py-1.5 rounded-full">Desde $15</span>
                <span class="text-xs text-slate-400 font-light">Diagnóstico incluido</span>
            </div>
        </div>
        <div class="reveal-right">
            <img src="https://images.unsplash.com/photo-1531492746076-161ca9bcad58?w=800&q=80&fit=crop"
                 alt="Reparación de equipos"
                 class="rounded-2xl w-full object-cover aspect-4/3 shadow-xl">
        </div>
    </div>
</section>

{{-- SERVICIO 2: SOPORTE IT --}}
<section class="py-24 px-6" style="background:linear-gradient(135deg,#f8fafc 0%,#eff6ff 100%);">
    <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-16 items-center">
        <div class="reveal-left order-2 md:order-1">
            <img src="https://images.unsplash.com/photo-1600267175161-cfaa711b4a81?w=800&q=80&fit=crop"
                 alt="Soporte IT"
                 class="rounded-2xl w-full object-cover aspect-4/3 shadow-xl">
        </div>
        <div class="reveal-right order-1 md:order-2">
            <div class="w-12 h-12 bg-violet-50 border border-violet-100 rounded-2xl flex items-center justify-center text-2xl mb-6">🖥️</div>
            <p class="text-xs font-semibold tracking-widest uppercase text-violet-600 mb-3">Servicio 02</p>
            <h2 class="font-serif text-4xl font-bold text-slate-900 mb-4 leading-tight">Soporte IT remoto y presencial</h2>
            <p class="text-slate-500 font-light leading-relaxed mb-6">Asistencia técnica especializada para empresas y hogares. Resolución de problemas de software, configuración de sistemas, gestión de usuarios y mantenimiento preventivo.</p>
            <ul class="space-y-3 mb-8">
                @foreach(['Soporte remoto inmediato','Visitas técnicas presenciales','Gestión de usuarios y permisos','Configuración de software y sistemas','Mantenimiento preventivo mensual'] as $item)
                <li class="flex items-center gap-3 text-sm text-slate-600">
                    <svg class="w-4 h-4 text-violet-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                    {{ $item }}
                </li>
                @endforeach
            </ul>
            <div class="flex items-center gap-3">
                <span class="text-xs font-semibold text-violet-600 bg-violet-50 border border-violet-100 px-3 py-1.5 rounded-full">Desde $30/hora</span>
                <span class="text-xs text-slate-400 font-light">Planes mensuales disponibles</span>
            </div>
        </div>
    </div>
</section>

{{-- SERVICIO 3: REDES --}}
<section class="py-24 px-6 bg-white">
    <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-16 items-center">
        <div class="reveal-left">
            <div class="w-12 h-12 bg-emerald-50 border border-emerald-100 rounded-2xl flex items-center justify-center text-2xl mb-6">🌐</div>
            <p class="text-xs font-semibold tracking-widest uppercase text-emerald-600 mb-3">Servicio 03</p>
            <h2 class="font-serif text-4xl font-bold text-slate-900 mb-4 leading-tight">Infraestructura de red</h2>
            <p class="text-slate-500 font-light leading-relaxed mb-6">Diseño, instalación y configuración de redes cableadas e inalámbricas para hogares, oficinas y empresas. Optimización del rendimiento y seguridad de su red.</p>
            <ul class="space-y-3 mb-8">
                @foreach(['Redes cableadas estructuradas','WiFi empresarial y residencial','Configuración de routers y switches','Seguridad perimetral de red','Monitoreo y optimización'] as $item)
                <li class="flex items-center gap-3 text-sm text-slate-600">
                    <svg class="w-4 h-4 text-emerald-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                    {{ $item }}
                </li>
                @endforeach
            </ul>
            <div class="flex items-center gap-3">
                <span class="text-xs font-semibold text-emerald-600 bg-emerald-50 border border-emerald-100 px-3 py-1.5 rounded-full">Desde $50</span>
                <span class="text-xs text-slate-400 font-light">Incluye materiales básicos</span>
            </div>
        </div>
        <div class="reveal-right">
            <img src="https://images.unsplash.com/photo-1558494949-ef010cbdcc31?w=800&q=80&fit=crop"
                 alt="Infraestructura de red"
                 class="rounded-2xl w-full object-cover aspect-4/3 shadow-xl">
        </div>
    </div>
</section>

{{-- SERVICIO 4: CCTV --}}
<section class="py-24 px-6" style="background:linear-gradient(135deg,#f8fafc 0%,#faf5ff 100%);">
    <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-16 items-center">
        <div class="reveal-left order-2 md:order-1">
            <img src="https://images.unsplash.com/photo-1557597774-9d273605dfa9?w=800&q=80&fit=crop"
                 alt="CCTV"
                 class="rounded-2xl w-full object-cover aspect-4/3 shadow-xl">
        </div>
        <div class="reveal-right order-1 md:order-2">
            <div class="w-12 h-12 bg-amber-50 border border-amber-100 rounded-2xl flex items-center justify-center text-2xl mb-6">📷</div>
            <p class="text-xs font-semibold tracking-widest uppercase text-amber-600 mb-3">Servicio 04</p>
            <h2 class="font-serif text-4xl font-bold text-slate-900 mb-4 leading-tight">CCTV y videovigilancia</h2>
            <p class="text-slate-500 font-light leading-relaxed mb-6">Instalación y configuración de sistemas de videovigilancia profesionales con acceso remoto desde cualquier dispositivo. Monitoreo continuo para hogares y empresas.</p>
            <ul class="space-y-3 mb-8">
                @foreach(['Cámaras HD y 4K','Acceso remoto desde tu celular','Grabación local y en la nube','Alertas de movimiento','Mantenimiento y soporte'] as $item)
                <li class="flex items-center gap-3 text-sm text-slate-600">
                    <svg class="w-4 h-4 text-amber-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                    {{ $item }}
                </li>
                @endforeach
            </ul>
            <div class="flex items-center gap-3">
                <span class="text-xs font-semibold text-amber-600 bg-amber-50 border border-amber-100 px-3 py-1.5 rounded-full">Desde $80</span>
                <span class="text-xs text-slate-400 font-light">Instalación incluida</span>
            </div>
        </div>
    </div>
</section>

{{-- GARANTÍA --}}
<section class="py-20 px-6 bg-slate-900">
    <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-6">
        @foreach([
            ['🔍', 'Diagnóstico incluido', 'Revisamos tu equipo e informamos el problema y costo antes de proceder.'],
            ['🛡️', 'Garantía escrita', 'Todos los servicios incluyen garantía. Si falla, lo resolvemos sin costo.'],
            ['⚡', 'Entrega en 5 días', 'La mayoría de reparaciones listas en máximo 5 días hábiles.'],
        ] as $i => $g)
        <div class="flex gap-4 reveal" style="transition-delay:{{ $i * 0.1 }}s">
            <div class="w-12 h-12 bg-blue-600/20 border border-blue-500/30 rounded-xl flex items-center justify-center text-2xl flex-shrink-0">{{ $g[0] }}</div>
            <div>
                <p class="text-white font-semibold text-sm mb-1">{{ $g[1] }}</p>
                <p class="text-slate-400 text-sm font-light">{{ $g[2] }}</p>
            </div>
        </div>
        @endforeach
    </div>
</section>

{{-- CTA --}}
<section class="py-20 px-6" style="background:linear-gradient(135deg,#1d4ed8 0%,#4f46e5 50%,#7c3aed 100%);">
    <div class="max-w-3xl mx-auto text-center">
        <h2 class="font-serif text-4xl font-bold text-white mb-4 reveal">¿Necesitas alguno de estos servicios?</h2>
        <p class="text-blue-100 font-light mb-10 reveal d1">Contáctanos hoy — atención rápida y garantizada.</p>
        <div class="flex flex-col sm:flex-row justify-center gap-4 reveal d2">
            <a href="/#contacto" class="bg-white text-blue-700 hover:bg-yellow-300 hover:text-blue-900 text-sm font-semibold px-8 py-3.5 rounded-xl transition-all">
                Contáctenos
            </a>
            <a href="{{ route('register') }}" class="border border-white/30 hover:border-white text-white text-sm px-8 py-3.5 rounded-xl transition-all">
                Registrarse y obtener 50% OFF
            </a>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
const observer = new IntersectionObserver((entries) => {
    entries.forEach(e => { if(e.isIntersecting) e.target.classList.add('visible'); });
}, { threshold: 0.1 });
document.querySelectorAll('.reveal,.reveal-left,.reveal-right').forEach(el => observer.observe(el));
</script>
@endpush
