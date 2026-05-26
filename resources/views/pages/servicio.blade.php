@extends('layouts.app')

@section('title', 'Servicios – Novitecnología Cia. Ltda.')

@section('content')

<style>
@import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;800&family=Inter:wght@300;400;500&display=swap');
body { font-family: 'Inter', sans-serif; }
.font-serif { font-family: 'Playfair Display', serif; }
.reveal { opacity:0; transform:translateY(30px); transition:opacity .8s ease,transform .8s ease; }
.reveal.visible { opacity:1; transform:translateY(0); }
.filter-btn { transition: all .2s ease; }
.filter-btn.active { background:#1d4ed8; color:#fff; border-color:#1d4ed8; }
.service-card { background:#fff; border:1px solid #e2e8f0; border-radius:20px; overflow:hidden; transition:all .4s ease; position:relative; text-decoration:none; display:block; }
.service-card::after { content:''; position:absolute; bottom:0; left:0; width:0; height:3px; background:linear-gradient(90deg,#1d4ed8,#0ea5e9); transition:width .4s ease; }
.service-card:hover::after { width:100%; }
.service-card:hover { border-color:#bfdbfe; transform:translateY(-5px); box-shadow:0 20px 40px rgba(59,130,246,.12); }
.service-card:hover img { transform:scale(1.05); }
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
        <form method="GET" action="{{ route('servicios') }}">
            <div class="flex flex-col md:flex-row gap-4 items-center mb-6">
                <div style="position:relative;flex:1;width:100%;">
                    <svg style="position:absolute;left:12px;top:50%;transform:translateY(-50%);width:16px;height:16px;color:#94a3b8;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input type="text" name="q" value="{{ request('q') }}"
                           placeholder="Buscar servicio..."
                           style="width:100%;padding:10px 16px 10px 40px;border:1px solid #e2e8f0;border-radius:12px;font-size:14px;outline:none;">
                </div>
                <button type="submit"
                        style="background:#2563eb;color:#fff;border:none;padding:10px 24px;border-radius:12px;font-size:14px;font-weight:500;cursor:pointer;">
                    Buscar
                </button>
                @if(request('q') || request('category'))
                <a href="{{ route('servicios') }}"
                   style="font-size:13px;color:#94a3b8;padding:10px 16px;border:1px solid #e2e8f0;border-radius:12px;text-decoration:none;">
                    Limpiar
                </a>
                @endif
            </div>

            {{-- FILTROS --}}
            <div style="display:flex;flex-wrap:wrap;gap:8px;">
                <a href="{{ route('servicios', array_merge(request()->except('category'), [])) }}"
                   class="filter-btn {{ !request('category') ? 'active' : '' }}"
                   style="font-size:12px;padding:6px 16px;border-radius:20px;border:1px solid #e2e8f0;color:#475569;text-decoration:none;">
                    Todos
                </a>
                @foreach([
                    'reparaciones' => 'Reparaciones',
                    'redes' => 'Redes',
                    'servicios-it-presenciales' => 'IT Presencial',
                    'servicios-it-remotos' => 'IT Remoto',
                ] as $value => $label)
                <a href="{{ route('servicios', array_merge(request()->except('category'), ['category' => $value])) }}"
                   class="filter-btn {{ request('category') === $value ? 'active' : '' }}"
                   style="font-size:12px;padding:6px 16px;border-radius:20px;border:1px solid #e2e8f0;color:#475569;text-decoration:none;">
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
        <div style="text-align:center;padding:80px 0;">
            <svg style="width:48px;height:48px;color:#e2e8f0;margin:0 auto 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <p style="color:#94a3b8;font-size:14px;font-weight:300;">No se encontraron servicios con ese criterio.</p>
            <a href="{{ route('servicios') }}" style="color:#3b82f6;font-size:13px;margin-top:8px;display:inline-block;">Ver todos los servicios</a>
        </div>
        @else
        <p style="color:#94a3b8;font-size:13px;margin-bottom:32px;">{{ $services->count() }} {{ $services->count() === 1 ? 'servicio encontrado' : 'servicios encontrados' }}</p>

        <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:32px;">
            @foreach($services as $i => $service)
            <a href="{{ route('servicios.show', $service->slug) }}"
               class="service-card reveal" style="transition-delay:{{ ($i % 3) * 0.1 }}s">

                {{-- IMAGEN --}}
                <div style="position:relative;aspect-ratio:16/9;overflow:hidden;background:#f1f5f9;">
                    @if($service->image_src)
                        <img src="{{ $service->image_src }}"
                             alt="{{ $service->name }}"
                             style="width:100%;height:100%;object-fit:cover;transition:transform .5s ease;">
                    @else
                        <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;background:linear-gradient(135deg,#eff6ff,#f8fafc);">
                            <svg style="width:48px;height:48px;color:#bfdbfe;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 3H5a2 2 0 00-2 2v4m6-6h10a2 2 0 012 2v4M9 3v18m0 0h10a2 2 0 002-2v-4M9 21H5a2 2 0 01-2-2v-4m0 0h18"/>
                            </svg>
                        </div>
                    @endif
                    <span style="position:absolute;top:12px;left:12px;font-size:11px;font-weight:600;padding:4px 10px;border-radius:20px;background:rgba(255,255,255,0.95);color:#1d4ed8;border:1px solid #bfdbfe;">
                        {{ ucwords(str_replace('-', ' ', $service->category)) }}
                    </span>
                </div>

                {{-- CONTENIDO --}}
                <div style="padding:20px;">
                    <h3 style="font-family:'Playfair Display',serif;font-size:18px;font-weight:700;color:#0f172a;margin-bottom:8px;line-height:1.3;">
                        {{ $service->name }}
                    </h3>
                    @if($service->description)
                    <p style="color:#64748b;font-size:13px;font-weight:300;line-height:1.6;margin-bottom:16px;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;">
                        {{ $service->description }}
                    </p>
                    @endif
                    <div style="display:flex;align-items:center;justify-content:space-between;">
                        @if($service->price)
                        <span style="font-size:13px;font-weight:700;color:#1d4ed8;background:#eff6ff;border:1px solid #bfdbfe;padding:5px 12px;border-radius:20px;">
                            Desde ${{ $service->price }}
                        </span>
                        @else
                        <span></span>
                        @endif
                        <span style="font-size:12px;color:#94a3b8;display:flex;align-items:center;gap:4px;">
                            Ver detalle
                            <svg style="width:14px;height:14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
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
    <div class="max-w-7xl mx-auto" style="display:grid;grid-template-columns:repeat(3,1fr);gap:24px;">
        @foreach([
            ['🔍', 'Diagnóstico incluido', 'Revisamos tu equipo e informamos el problema y costo antes de proceder.'],
            ['🛡️', 'Garantía escrita', 'Todos los servicios incluyen garantía. Si falla, lo resolvemos sin costo.'],
            ['⚡', 'Entrega en 5 días', 'La mayoría de reparaciones listas en máximo 5 días hábiles.'],
        ] as $i => $g)
        <div class="reveal" style="display:flex;gap:16px;transition-delay:{{ $i * 0.1 }}s">
            <div style="width:48px;height:48px;background:rgba(37,99,235,.2);border:1px solid rgba(59,130,246,.3);border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:24px;flex-shrink:0;">{{ $g[0] }}</div>
            <div>
                <p style="color:#fff;font-weight:600;font-size:14px;margin-bottom:4px;">{{ $g[1] }}</p>
                <p style="color:#94a3b8;font-size:13px;font-weight:300;">{{ $g[2] }}</p>
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
        <div style="display:flex;justify-content:center;gap:16px;flex-wrap:wrap;" class="reveal">
            <a href="/contacto" style="background:#fff;color:#1d4ed8;font-weight:600;font-size:14px;padding:14px 32px;border-radius:12px;text-decoration:none;">
                Contáctenos
            </a>
            <a href="{{ route('register') }}" style="border:1px solid rgba(255,255,255,.3);color:#fff;font-size:14px;padding:14px 32px;border-radius:12px;text-decoration:none;">
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
