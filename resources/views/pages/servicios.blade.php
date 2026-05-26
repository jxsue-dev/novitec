@extends('layouts.app')

@section('title', 'Servicios – Novitecnología Cia. Ltda.')

@section('content')

<style>
@import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;800&family=Inter:wght@300;400;500&display=swap');
body { font-family: 'Inter', sans-serif; }
.font-serif { font-family: 'Playfair Display', serif; }
.reveal { opacity:0; transform:translateY(30px); transition:opacity .8s ease,transform .8s ease; }
.reveal.visible { opacity:1; transform:translateY(0); }
.service-card { background:#fff; border:1px solid #e2e8f0; border-radius:20px; overflow:hidden; transition:all .4s ease; position:relative; }
.service-card::after { content:''; position:absolute; bottom:0; left:0; width:0; height:3px; background:linear-gradient(90deg,#1d4ed8,#0ea5e9); transition:width .4s ease; }
.service-card:hover::after { width:100%; }
.service-card:hover { border-color:#bfdbfe; transform:translateY(-5px); box-shadow:0 20px 40px rgba(59,130,246,.08); }
.filter-btn { transition: all .2s ease; }
.filter-btn.active { background:#1d4ed8; color:#fff; border-color:#1d4ed8; }
</style>

{{-- HERO --}}
<section class="relative pt-36 pb-24 px-6 overflow-hidden" style="background:linear-gradient(135deg,#020817 0%,#0c1a35 50%,#020817 100%);">
    <div class="absolute inset-0 pointer-events-none" style="background-image:linear-gradient(rgba(59,130,246,.04) 1px,transparent 1px),linear-gradient(90deg,rgba(59,130,246,.04) 1px,transparent 1px);background-size:60px 60px"></div>
    <div class="relative max-w-4xl mx-auto text-center">
        <p class="text-xs font-semibold tracking-widest uppercase text-blue-400 mb-4 reveal">Lo que hacemos</p>
        <h1 class="font-serif text-5xl md:text-6xl font-bold text-white mb-6 reveal leading-tight">
            Soluciones tecnológicas<br>
            <span style="background:linear-gradient(90deg,#60a5fa,#a78bfa);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">para cada necesidad</span>
        </h1>
        <p class="text-slate-400 text-base font-light max-w-2xl mx-auto reveal leading-relaxed">
            Desde la reparación de un equipo hasta la infraestructura IT completa de tu empresa — con garantía en cada servicio.
        </p>
    </div>
</section>

{{-- BUSCADOR Y FILTROS --}}
<section class="py-10 px-6 bg-white border-b border-slate-100 sticky top-16 z-20">
    <div class="max-w-7xl mx-auto">
        <form method="GET" action="{{ route('servicios') }}" id="filterForm">
            {{-- BUSCADOR --}}
            <div class="flex flex-col md:flex-row gap-4 items-center mb-6">
                <div class="relative flex-1 w-full">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input type="text" name="q" value="{{ request('q') }}"
                           placeholder="Buscar servicio..."
                           class="w-full pl-10 pr-4 py-2.5 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-blue-400">
                </div>
                <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white text-sm px-6 py-2.5 rounded-xl transition-colors">
                    Buscar
                </button>
                @if(request('q') || request('category'))
                <a href="{{ route('servicios') }}"
                   class="text-sm text-slate-400 hover:text-slate-600 px-4 py-2.5 border border-slate-200 rounded-xl transition-colors">
                    Limpiar
                </a>
                @endif
            </div>

            {{-- FILTROS DE CATEGORÍA --}}
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('servicios', array_merge(request()->except('category'), [])) }}"
                   class="filter-btn text-xs px-4 py-2 rounded-full border border-slate-200 text-slate-600 hover:border-blue-400 {{ !request('category') ? 'active' : '' }}">
                    Todos
                </a>
                @foreach([
                    'reparaciones' => 'Reparaciones',
                    'redes' => 'Redes',
                    'servicios-it-presenciales' => 'IT Presencial',
                    'servicios-it-remotos' => 'IT Remoto',
                ] as $value => $label)
                <a href="{{ route('servicios', array_merge(request()->except('category'), ['category' => $value])) }}"
                   class="filter-btn text-xs px-4 py-2 rounded-full border border-slate-200 text-slate-600 hover:border-blue-400 {{ request('category') === $value ? 'active' : '' }}">
                    {{ $label }}
                </a>
                @endforeach
            </div>
        </form>
    </div>
</section>

{{-- CATÁLOGO --}}
<section class="py-16 px-6 bg-white">
    <div class="max-w-7xl mx-auto">

        @if($services->isEmpty())
        <div class="text-center py-20">
            <svg class="w-12 h-12 text-slate-200 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <p class="text-slate-400 font-light">No se encontraron servicios con ese criterio.</p>
            <a href="{{ route('servicios') }}" class="text-blue-500 text-sm mt-2 inline-block hover:underline">Ver todos los servicios</a>
        </div>
        @else
        <p class="text-slate-400 text-sm mb-8">{{ $services->count() }} {{ $services->count() === 1 ? 'servicio encontrado' : 'servicios encontrados' }}</p>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($services as $i => $service)
            <a href="{{ route('servicios.show', $service->slug) }}"
               class="service-card reveal block" style="transition-delay:{{ ($i % 3) * 0.1 }}s">
                {{-- IMAGEN --}}
                <div class="aspect-video overflow-hidden bg-slate-100 relative">
                    @if($service->image_src)
                        <img src="{{ $service->image_src }}"
                             alt="{{ $service->name }}"
                             class="w-full h-full object-cover transition-transform duration-500 hover:scale-105">
                    @else
                        <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-blue-50 to-slate-100">
                            <svg class="w-12 h-12 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 3H5a2 2 0 00-2 2v4m6-6h10a2 2 0 012 2v4M9 3v18m0 0h10a2 2 0 002-2v-4M9 21H5a2 2 0 01-2-2v-4m0 0h18"/>
                            </svg>
                        </div>
                    @endif
                    {{-- BADGE CATEGORÍA --}}
                    <span class="absolute top-3 left-3 text-xs font-semibold px-2.5 py-1 rounded-full bg-white/90 text-blue-700 border border-blue-100">
                        {{ ucwords(str_replace('-', ' ', $service->category)) }}
                    </span>
                </div>

                {{-- CONTENIDO --}}
                <div class="p-6">
                    <h3 class="font-serif text-lg font-bold text-slate-900 mb-2 leading-tight">
                        {{ $service->name }}
                    </h3>
                    @if($service->description)
                    <p class="text-slate-500 text-sm font-light leading-relaxed mb-4 line-clamp-2">
                        {{ $service->description }}
                    </p>
                    @endif
                    <div class="flex items-center justify-between">
                        @if($service->price_formatted)
                        <span class="text-sm font-semibold text-blue-600 bg-blue-50 border border-blue-100 px-3 py-1 rounded-full">
                            {{ $service->price }}
                        </span>
                        @endif
                        <span class="text-xs text-slate-400 hover:text-blue-500 transition-colors ml-auto">
                            Ver detalle →
                        </span>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
        @endif
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
        <p class="text-blue-100 font-light mb-10 reveal">Contáctanos hoy — atención rápida y garantizada.</p>
        <div class="flex flex-col sm:flex-row justify-center gap-4 reveal">
            <a href="/contacto" class="bg-white text-blue-700 hover:bg-yellow-300 hover:text-blue-900 text-sm font-semibold px-8 py-3.5 rounded-xl transition-all">
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
document.querySelectorAll('.reveal').forEach(el => observer.observe(el));
</script>
@endpush
