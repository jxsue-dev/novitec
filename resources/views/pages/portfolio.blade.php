@extends('layouts.app')

@section('title', 'Galería de Trabajos Realizados | Novitec Ecuador')
@section('description', 'Conoce algunos de los trabajos realizados por el equipo técnico de Novitec: reparaciones, instalación de redes, CCTV y soporte IT en Ecuador.')
@section('keywords', 'trabajos realizados servicio técnico ecuador, reparaciones novitec, instalación redes quito, galería técnica')

@section('content')
<style>
@import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Inter:wght@300;400;500&display=swap');
body { font-family: 'Inter', sans-serif; }
.font-serif { font-family: 'Playfair Display', serif; }
.reveal { opacity:0; transform:translateY(30px); transition:opacity .8s ease,transform .8s ease; }
.reveal.visible { opacity:1; transform:translateY(0); }
.portfolio-card:hover .portfolio-overlay { opacity:1; }
.portfolio-overlay { transition:opacity .3s ease; }
</style>

{{-- HERO --}}
<section class="relative pt-24 pb-14 md:pt-32 md:pb-20 px-5 md:px-6 overflow-hidden" style="background:linear-gradient(135deg,#020817 0%,#0c1a35 50%,#020817 100%);">
    <div class="absolute inset-0 pointer-events-none" style="background-image:linear-gradient(rgba(59,130,246,.04) 1px,transparent 1px),linear-gradient(90deg,rgba(59,130,246,.04) 1px,transparent 1px);background-size:60px 60px"></div>
    <div class="relative max-w-4xl mx-auto text-center">
        <p class="text-xs font-semibold tracking-widest uppercase text-blue-400 mb-4 reveal">Nuestro trabajo</p>
        <h1 class="font-serif text-3xl sm:text-4xl md:text-5xl font-bold text-white mb-4 reveal leading-tight">
            Galería de <span style="background:linear-gradient(90deg,#60a5fa,#a78bfa);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">proyectos</span>
        </h1>
        <p class="text-slate-400 text-sm font-light max-w-xl mx-auto reveal">
            Algunos de los trabajos realizados por nuestro equipo técnico certificado.
        </p>
    </div>
</section>

{{-- GALERÍA --}}
<section class="py-14 px-4 md:py-20 md:px-6 bg-white">
    <div class="max-w-7xl mx-auto">

        @if($categories->isNotEmpty())
        {{-- Filtros --}}
        <div class="flex flex-wrap gap-2 mb-10 justify-center reveal">
            <button onclick="filterPortfolio('all')" data-filter="all"
                    class="filter-btn active text-xs px-4 py-2 rounded-full border border-slate-200 text-slate-600 hover:border-blue-400 transition-all">
                Todos
            </button>
            @foreach($categories as $cat)
            <button onclick="filterPortfolio('{{ $cat }}')" data-filter="{{ $cat }}"
                    class="filter-btn text-xs px-4 py-2 rounded-full border border-slate-200 text-slate-600 hover:border-blue-400 transition-all capitalize">
                {{ $cat }}
            </button>
            @endforeach
        </div>
        @endif

        @if($items->isEmpty())
        {{-- Placeholder si no hay items --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach([
                ['Reparación de Laptop HP','reparaciones','Reemplazo de pantalla y teclado en laptop HP Pavilion. Cliente satisfecho con resultado.'],
                ['Instalación Red Empresarial','redes','Diseño e instalación de red estructurada para empresa en Quito con 30 puntos de acceso.'],
                ['Sistema CCTV 8 Cámaras','cctv','Instalación de 8 cámaras HD con acceso remoto desde celular para local comercial.'],
                ['Recuperación de Datos','reparaciones','Recuperación exitosa de disco duro con falla mecánica. 250GB de información recuperados.'],
                ['Soporte IT Mensual','soporte','Gestión completa de infraestructura IT para empresa de 15 empleados en Quito.'],
                ['Reparación iPhone 13','reparaciones','Cambio de batería y cristal trasero en iPhone 13. Garantía de 3 meses.'],
            ] as $i => $p)
            <div class="portfolio-card bg-white border border-slate-100 rounded-2xl overflow-hidden hover:shadow-lg hover:-translate-y-1 transition-all reveal" style="transition-delay:{{ ($i%3)*.1 }}s">
                <div class="relative h-48 bg-gradient-to-br from-slate-100 to-slate-200 overflow-hidden">
                    <div class="portfolio-overlay absolute inset-0 bg-blue-600/80 opacity-0 flex items-center justify-center">
                        <span class="text-white text-xs font-medium px-4 py-2 border border-white/30 rounded-full">Ver detalle</span>
                    </div>
                    <div class="flex items-center justify-center h-full">
                        <i class="fa-solid fa-wrench text-slate-300 text-5xl"></i>
                    </div>
                    <span class="absolute top-3 left-3 text-xs font-medium px-2.5 py-1 rounded-full bg-white/90 text-blue-700 capitalize">{{ $p[1] }}</span>
                </div>
                <div class="p-5">
                    <h3 class="font-semibold text-slate-900 text-sm mb-2">{{ $p[0] }}</h3>
                    <p class="text-slate-500 text-xs font-light leading-relaxed">{{ $p[2] }}</p>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6" id="portfolio-grid">
            @foreach($items as $i => $item)
            <div class="portfolio-card bg-white border border-slate-100 rounded-2xl overflow-hidden hover:shadow-lg hover:-translate-y-1 transition-all reveal"
                 style="transition-delay:{{ ($i%3)*.1 }}s"
                 data-category="{{ $item->category }}">
                <div class="relative h-48 overflow-hidden bg-slate-100">
                    <div class="portfolio-overlay absolute inset-0 bg-blue-600/80 opacity-0 flex items-center justify-center z-10">
                        <span class="text-white text-xs font-medium px-4 py-2 border border-white/30 rounded-full">Ver detalle</span>
                    </div>
                    @if($item->image_src)
                    <img src="{{ $item->image_src }}" alt="{{ $item->title }}" loading="lazy" class="w-full h-full object-cover transition-transform duration-500 hover:scale-105">
                    @else
                    <div class="flex items-center justify-center h-full"><i class="fa-solid fa-wrench text-slate-300 text-5xl"></i></div>
                    @endif
                    <span class="absolute top-3 left-3 text-xs font-medium px-2.5 py-1 rounded-full bg-white/90 text-blue-700 capitalize z-20">{{ $item->category }}</span>
                </div>
                <div class="p-5">
                    <h3 class="font-semibold text-slate-900 text-sm mb-1">{{ $item->title }}</h3>
                    @if($item->device)<p class="text-blue-500 text-xs mb-2">{{ $item->device }}</p>@endif
                    @if($item->description)<p class="text-slate-500 text-xs font-light leading-relaxed">{{ $item->description }}</p>@endif
                </div>
            </div>
            @endforeach
        </div>
        @endif

        {{-- CTA --}}
        <div class="mt-14 text-center reveal">
            <p class="text-slate-500 text-sm mb-4">¿Necesitas un servicio similar?</p>
            <a href="{{ route('cita') }}" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-500 text-white text-sm font-semibold px-8 py-3.5 rounded-xl transition-all hover:-translate-y-0.5">
                <i class="fa-solid fa-calendar-check"></i> Agendar cita
            </a>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
function filterPortfolio(cat) {
    document.querySelectorAll('.filter-btn').forEach(b => {
        b.classList.toggle('active', b.dataset.filter === cat);
        b.classList.toggle('bg-blue-600', b.dataset.filter === cat);
        b.classList.toggle('text-white', b.dataset.filter === cat);
        b.classList.toggle('border-blue-600', b.dataset.filter === cat);
    });
    document.querySelectorAll('.portfolio-card[data-category]').forEach(card => {
        card.style.display = (cat === 'all' || card.dataset.category === cat) ? '' : 'none';
    });
}
const observer = new IntersectionObserver(e => e.forEach(x => { if(x.isIntersecting) x.target.classList.add('visible'); }), {threshold:.1});
document.querySelectorAll('.reveal').forEach(el => observer.observe(el));
</script>
<style>
.filter-btn.active { background:#2563eb; color:#fff; border-color:#2563eb; }
</style>
@endpush
