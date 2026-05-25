@extends('layouts.app')

@section('title', 'Conócenos – Novitec')

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
</style>

{{-- HERO --}}
<section class="relative pt-36 pb-24 px-6 overflow-hidden" style="background:linear-gradient(135deg,#020817 0%,#0c1a35 50%,#020817 100%);">
    <div class="absolute inset-0 pointer-events-none" style="background-image:linear-gradient(rgba(59,130,246,.04) 1px,transparent 1px),linear-gradient(90deg,rgba(59,130,246,.04) 1px,transparent 1px);background-size:60px 60px"></div>
    <div class="absolute top-0 right-0 w-96 h-96 rounded-full blur-3xl pointer-events-none" style="background:radial-gradient(circle,rgba(139,92,246,.15),transparent 70%)"></div>
    <div class="absolute bottom-0 left-0 w-72 h-72 rounded-full blur-3xl pointer-events-none" style="background:radial-gradient(circle,rgba(59,130,246,.1),transparent 70%)"></div>

    <div class="relative max-w-4xl mx-auto text-center">
        <p class="text-xs font-semibold tracking-widest uppercase text-blue-400 mb-4 reveal">Novitecnología Cia. Ldta.</p>
        <h1 class="font-serif text-5xl md:text-6xl font-bold text-white mb-6 reveal d1 leading-tight">
            Más de una década<br>resolviendo lo que<br><span style="background:linear-gradient(90deg,#60a5fa,#a78bfa);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">otros no pueden</span>
        </h1>
        <p class="text-slate-400 text-base font-light max-w-2xl mx-auto reveal d2 leading-relaxed">
            Somos una empresa ecuatoriana especializada en soporte tecnológico integral — desde la reparación de un celular hasta la infraestructura IT de una empresa.
        </p>
    </div>
</section>

{{-- EQUIPO --}}
<section class="py-24 px-6 bg-white overflow-hidden">
    <div class="max-w-7xl mx-auto">
        <div class="text-center max-w-xl mx-auto mb-16">
            <p class="text-xs font-semibold tracking-widest uppercase text-blue-600 mb-3 reveal">Las personas detrás</p>
            <h2 class="font-serif text-4xl font-bold text-slate-900 mb-4 reveal d1">Nuestro equipo</h2>
            <p class="text-slate-500 font-light reveal d2">Técnicos certificados con pasión por la tecnología y vocación de servicio.</p>
        </div>

        <div class="relative reveal">
            <div id="slider" class="flex transition-transform duration-700 ease-in-out">
                @foreach([
                    ['eq_uio.png',  'Servicio Técnico Quito',      'Nuestro equipo en Quito — listos para atenderte de lunes a sábado con el más alto nivel técnico.'],
                    ['eq_gye.png',  'Servicio Técnico Guayaquil',   'Presencia en la costa con técnicos especializados en reparación y soporte IT para la región.'],
                    ['eq_mta.png',  'Servicio Técnico Manta',       'Equipo comprometido en Manta, brindando soluciones tecnológicas a empresas y personas de la zona.'],
                    ['it_uio.png',  'Sistemas y Desarrollo',        'El equipo de sistemas y desarrollo que mantiene nuestra plataforma y soluciones IT corporativas.'],
                ] as $i => $slide)
                <div class="min-w-full px-4">
                    <div class="relative rounded-3xl overflow-hidden aspect-video md:aspect-[21/8] bg-slate-100">
                        <img src="{{ asset('images/' . $slide[0]) }}"
                             alt="{{ $slide[1] }}"
                             class="w-full h-full object-cover">
                        <div class="absolute inset-0" style="background:linear-gradient(to top,rgba(2,8,23,.8) 0%,transparent 60%)"></div>
                        <div class="absolute bottom-0 left-0 p-6 md:p-10">
                            <p class="text-blue-400 text-xs font-semibold tracking-widest uppercase mb-2">Equipo {{ $i + 1 }} / 4</p>
                            <h3 class="font-serif text-2xl md:text-3xl font-bold text-white mb-2">{{ $slide[1] }}</h3>
                            <p class="text-slate-300 text-sm font-light max-w-lg">{{ $slide[2] }}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <button onclick="prevSlide()"
                    class="absolute left-2 top-1/2 -translate-y-1/2 w-10 h-10 bg-white/10 hover:bg-white/20 backdrop-blur border border-white/20 rounded-full flex items-center justify-center text-white transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            </button>
            <button onclick="nextSlide()"
                    class="absolute right-2 top-1/2 -translate-y-1/2 w-10 h-10 bg-white/10 hover:bg-white/20 backdrop-blur border border-white/20 rounded-full flex items-center justify-center text-white transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </button>

            <div class="flex justify-center gap-2 mt-5">
                @foreach([0,1,2,3] as $dot)
                <button onclick="goToSlide({{ $dot }})"
                        id="dot-{{ $dot }}"
                        class="h-2 rounded-full transition-all {{ $dot === 0 ? 'bg-blue-600 w-6' : 'bg-slate-300 w-2' }}">
                </button>
                @endforeach
            </div>
        </div>
    </div>
</section>

{{-- MISIÓN Y VISIÓN --}}
<section class="py-24 px-6" style="background:linear-gradient(135deg,#f8fafc 0%,#eff6ff 100%);">
    <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-12">
        <div class="reveal-left">
            <div class="w-12 h-12 bg-blue-50 border border-blue-100 rounded-2xl flex items-center justify-center text-2xl mb-6">🎯</div>
            <h2 class="font-serif text-3xl font-bold text-slate-900 mb-4">Nuestra misión</h2>
            <p class="text-slate-500 font-light leading-relaxed">
                Brindar soluciones tecnológicas accesibles, confiables y de alta calidad a personas y empresas en Ecuador, siendo el aliado estratégico que garantiza la continuidad operativa de nuestros clientes con rapidez, honestidad y garantía en cada servicio.
            </p>
        </div>
        <div class="reveal-right">
            <div class="w-12 h-12 bg-violet-50 border border-violet-100 rounded-2xl flex items-center justify-center text-2xl mb-6">🔭</div>
            <h2 class="font-serif text-3xl font-bold text-slate-900 mb-4">Nuestra visión</h2>
            <p class="text-slate-500 font-light leading-relaxed">
                Ser la empresa de soporte tecnológico más confiable y reconocida del Ecuador, expandiendo nuestra presencia nacional con un equipo certificado, tecnología de punta y un modelo de servicio que pone al cliente en el centro de cada decisión.
            </p>
        </div>
    </div>
</section>

{{-- VALORES --}}
<section class="py-24 px-6 bg-white">
    <div class="max-w-7xl mx-auto">
        <div class="text-center max-w-xl mx-auto mb-16">
            <p class="text-xs font-semibold tracking-widest uppercase text-blue-600 mb-3 reveal">Lo que nos define</p>
            <h2 class="font-serif text-4xl font-bold text-slate-900 reveal d1">Nuestros valores</h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach([
                ['🤝', 'Honestidad', 'Transparencia total en diagnósticos, precios y tiempos. Si no podemos repararlo, te lo decimos antes de cobrar.'],
                ['⚡', 'Rapidez', 'Sabemos que tu equipo es tu herramienta de trabajo. Por eso actuamos con urgencia sin sacrificar la calidad.'],
                ['🛡️', 'Garantía', 'Todos nuestros servicios tienen garantía escrita. Si falla, volvemos a resolverlo sin costo adicional.'],
                ['🏅', 'Excelencia', 'Técnicos certificados, repuestos de calidad y procesos estandarizados para un resultado siempre profesional.'],
                ['❤️', 'Compromiso', 'Cada equipo que recibimos lo tratamos como si fuera nuestro. El cuidado está en cada detalle.'],
                ['🌱', 'Mejora continua', 'Nos capacitamos constantemente para estar al día con las últimas tecnologías y ofrecer siempre lo mejor.'],
            ] as $i => $v)
            <div class="bg-slate-50 border border-slate-100 rounded-2xl p-6 hover:border-blue-200 hover:shadow-md transition-all reveal" style="transition-delay:{{ $i * 0.08 }}s">
                <div class="text-3xl mb-4">{{ $v[0] }}</div>
                <h3 class="font-semibold text-slate-900 text-sm mb-2">{{ $v[1] }}</h3>
                <p class="text-sm text-slate-500 font-light leading-relaxed">{{ $v[2] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- STATS --}}
<section class="py-20 px-6" style="background:linear-gradient(135deg,#020817 0%,#0c1a35 50%,#020817 100%);">
    <div class="max-w-7xl mx-auto grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
        @foreach([
            ['10+', 'Años de experiencia'],
            ['500+', 'Equipos reparados'],
            ['24/7', 'Soporte disponible'],
            ['100%', 'Garantía en servicios'],
        ] as $i => $s)
        <div class="reveal" style="transition-delay:{{ $i * 0.1 }}s">
            <p class="font-serif text-4xl font-bold text-white mb-2">{{ $s[0] }}</p>
            <p class="text-slate-400 text-sm font-light">{{ $s[1] }}</p>
        </div>
        @endforeach
    </div>
</section>

{{-- SUCURSALES --}}
<section id="sucursales" class="py-24 px-6" style="background:linear-gradient(135deg,#eff6ff 0%,#f8fafc 100%);">
    <div class="max-w-5xl mx-auto">
        <div class="text-center mb-16">
            <p class="text-xs font-semibold tracking-widest uppercase text-blue-600 mb-3 reveal">Dónde estamos</p>
            <h2 class="font-serif text-4xl font-bold text-slate-900 mb-4 reveal d1">Nuestras sucursales</h2>
            <p class="text-slate-500 font-light reveal d2">Encuéntranos en estas ubicaciones.</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-{{ count($branches) > 1 ? '2' : '1' }} gap-6">
            @foreach($branches as $branch)
            <div class="bg-white border border-slate-100 rounded-2xl p-6 hover:border-blue-200 hover:shadow-md transition-all reveal">
                <h3 class="font-semibold text-slate-900 text-sm mb-4 flex items-center gap-2">
                    <span class="w-2 h-2 bg-blue-500 rounded-full animate-pulse"></span>
                    {{ $branch->name }}
                </h3>
                <div class="space-y-2 text-sm text-slate-500 font-light mb-4">
                    <p>📍 {{ $branch->address }}</p>
                    <p>📞 {{ $branch->phone }}</p>
                    @if($branch->email)<p>✉️ {{ $branch->email }}</p>@endif
                    @if($branch->schedule)<p>🕐 {{ $branch->schedule }}</p>@endif
                </div>
                @if($branch->whatsapp)
                <a href="https://wa.me/{{ $branch->whatsapp }}" target="_blank"
                   class="inline-flex items-center gap-2 bg-green-500 hover:bg-green-600 text-white text-xs font-medium px-4 py-2 rounded-lg transition-all">
                    WhatsApp
                </a>
                @endif
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- CTA --}}
<section class="py-20 px-6" style="background:linear-gradient(135deg,#1d4ed8 0%,#4f46e5 50%,#7c3aed 100%);">
    <div class="max-w-3xl mx-auto text-center">
        <h2 class="font-serif text-4xl font-bold text-white mb-4 reveal">¿Listo para trabajar juntos?</h2>
        <p class="text-blue-100 font-light mb-10 reveal d1">Cuéntanos tu problema y lo resolvemos.</p>
        <div class="flex flex-col sm:flex-row justify-center gap-4 reveal d2">
            <a href="{{ route('contacto') }}" class="bg-white text-blue-700 hover:bg-yellow-300 hover:text-blue-900 text-sm font-semibold px-8 py-3.5 rounded-xl transition-all">
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
let current = 0;
const total = 4;

function updateSlider() {
    document.getElementById('slider').style.transform = `translateX(-${current * 100}%)`;
    for (let i = 0; i < total; i++) {
        const dot = document.getElementById('dot-' + i);
        dot.classList.remove('bg-blue-600', 'w-6', 'bg-slate-300', 'w-2');
        if (i === current) {
            dot.classList.add('bg-blue-600', 'w-6');
        } else {
            dot.classList.add('bg-slate-300', 'w-2');
        }
    }
}

function nextSlide() {
    current = (current + 1) % total;
    updateSlider();
}

function prevSlide() {
    current = (current - 1 + total) % total;
    updateSlider();
}

function goToSlide(n) {
    current = n;
    updateSlider();
}

setInterval(nextSlide, 5000);

const observer = new IntersectionObserver((entries) => {
    entries.forEach(e => { if(e.isIntersecting) e.target.classList.add('visible'); });
}, { threshold: 0.1 });
document.querySelectorAll('.reveal,.reveal-left,.reveal-right').forEach(el => observer.observe(el));
</script>
@endpush
