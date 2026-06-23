@extends('layouts.app')

@section('title', 'Novitec – Servicio Técnico & Soporte IT')

@section('content')

<style>
@import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;800&family=DM+Sans:wght@300;400;500&display=swap');

body { font-family: 'DM Sans', sans-serif; }
.font-serif { font-family: 'Playfair Display', serif; }

.reveal { opacity:0; transform:translateY(30px); transition:opacity .8s ease,transform .8s ease; }
.reveal.visible { opacity:1; transform:translateY(0); }
.reveal-left { opacity:0; transform:translateX(-40px); transition:opacity .8s ease,transform .8s ease; }
.reveal-left.visible { opacity:1; transform:translateX(0); }
.reveal-right { opacity:0; transform:translateX(40px); transition:opacity .8s ease,transform .8s ease; }
.reveal-right.visible { opacity:1; transform:translateX(0); }
.d1{transition-delay:.1s}.d2{transition-delay:.2s}.d3{transition-delay:.3s}.d4{transition-delay:.4s}.d5{transition-delay:.5s}

@keyframes float {
    0%,100%{transform:translateY(0)}
    50%{transform:translateY(-16px)}
}
.float-anim { animation:float 5s ease-in-out infinite; }

@keyframes shimmer {
    0%{background-position:-200% center}
    100%{background-position:200% center}
}
.text-gradient {
    background:linear-gradient(135deg,#1d4ed8,#3b82f6,#0ea5e9);
    background-size:200% auto;
    -webkit-background-clip:text;
    -webkit-text-fill-color:transparent;
    background-clip:text;
    animation:shimmer 4s linear infinite;
}

@keyframes shimmer-gold {
    0%{background-position:-200% center}
    100%{background-position:200% center}
}
.text-gold {
    background:linear-gradient(90deg,#fbbf24,#f59e0b,#fcd34d,#f59e0b,#fbbf24);
    background-size:200% auto;
    -webkit-background-clip:text;
    -webkit-text-fill-color:transparent;
    background-clip:text;
    animation:shimmer-gold 3s linear infinite;
}

@keyframes pulse-ring {
    0%{box-shadow:0 0 0 0 rgba(251,191,36,.6)}
    70%{box-shadow:0 0 0 15px rgba(251,191,36,0)}
    100%{box-shadow:0 0 0 0 rgba(251,191,36,0)}
}
.pulse-gold { animation:pulse-ring 2s ease-in-out infinite; }

@keyframes badge-bounce {
    0%,100%{transform:translateY(0) rotate(-3deg)}
    50%{transform:translateY(-8px) rotate(-3deg)}
}
.badge-bounce { animation:badge-bounce 2s ease-in-out infinite; }

.service-card {
    background:#fff;
    border:1px solid #e2e8f0;
    border-radius:16px;
    padding:1.75rem;
    transition:all .4s ease;
    position:relative;
    overflow:hidden;
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

.step-card {
    background:#fff;
    border:1px solid #e2e8f0;
    border-radius:16px;
    padding:1.75rem;
    transition:all .4s ease;
    text-align:center;
}
.step-card:hover {
    background:#eff6ff;
    border-color:#bfdbfe;
    transform:translateY(-4px);
}

.testi-card {
    background:rgba(255,255,255,.05);
    border:1px solid rgba(255,255,255,.1);
    border-radius:16px;
    padding:1.75rem;
    transition:all .4s ease;
}
.testi-card:hover {
    background:rgba(255,255,255,.08);
    border-color:rgba(139,92,246,.4);
    transform:translateY(-4px);
}

.branch-card {
    background:#fff;
    border:1px solid #e2e8f0;
    border-radius:16px;
    padding:1.75rem;
    transition:all .4s ease;
}
.branch-card:hover {
    border-color:#93c5fd;
    box-shadow:0 12px 32px rgba(59,130,246,.08);
}
</style>

{{-- HERO --}}
<section class="relative overflow-hidden" style="background:linear-gradient(135deg,#f0f4ff 0%,#e8f0fe 25%,#fdf4ff 50%,#f0f9ff 75%,#ecfdf5 100%);">

    <div class="absolute top-0 right-0 w-[500px] h-[500px] rounded-full blur-3xl -translate-y-1/3 translate-x-1/4 pointer-events-none" style="background:radial-gradient(circle,rgba(139,92,246,.15),transparent 70%)"></div>
    <div class="absolute bottom-0 left-0 w-[400px] h-[400px] rounded-full blur-3xl translate-y-1/3 -translate-x-1/4 pointer-events-none" style="background:radial-gradient(circle,rgba(59,130,246,.12),transparent 70%)"></div>
    <div class="absolute top-1/2 right-1/3 w-[300px] h-[300px] rounded-full blur-2xl pointer-events-none" style="background:radial-gradient(circle,rgba(16,185,129,.1),transparent 70%)"></div>
    <div class="absolute inset-0 pointer-events-none" style="background-image:linear-gradient(rgba(59,130,246,.04) 1px,transparent 1px),linear-gradient(90deg,rgba(59,130,246,.04) 1px,transparent 1px);background-size:60px 60px"></div>

    <div class="relative z-10 max-w-7xl mx-auto px-5 md:px-8 pt-20 pb-8 md:pt-28 md:pb-16 lg:pt-32 lg:pb-24 grid grid-cols-1 md:grid-cols-2 gap-6 md:gap-12 lg:gap-16 items-center">
        <div>
            <div class="inline-flex items-center gap-2 bg-white border border-blue-100 rounded-full px-3 py-1 md:px-4 md:py-1.5 mb-3 md:mb-7 reveal shadow-sm">
                <span class="w-1.5 h-1.5 md:w-2 md:h-2 bg-blue-500 rounded-full animate-pulse"></span>
                <span class="text-blue-700 text-xs font-medium tracking-widest uppercase">Novitecnología Cia. Ldta.</span>
            </div>

            <h1 class="font-serif text-3xl sm:text-4xl md:text-5xl lg:text-6xl xl:text-7xl font-bold mb-3 md:mb-6 reveal d1 leading-tight text-slate-900">
                Servicios<br>que impulsan<br><span class="text-gradient">tu negocio</span>
            </h1>

            <p class="text-slate-500 text-sm md:text-base max-w-md mb-4 md:mb-8 reveal d2 leading-relaxed font-light">
                Reparamos computadores, celulares e impresoras. Soporte IT remoto y presencial, redes y CCTV para personas y empresas.
            </p>

            {{-- 50% OFF DESTACADO --}}
            <div class="reveal d2 mb-4 md:mb-8 flex">
                <div class="relative">
                    <div class="absolute -inset-1 rounded-xl blur-md opacity-75" style="background:linear-gradient(135deg,#f59e0b,#fbbf24)"></div>
                    <div class="relative rounded-xl p-0.5" style="background:linear-gradient(135deg,#d97706,#fbbf24,#d97706)">
                        <div class="relative rounded-xl px-3 py-2 flex items-center gap-2.5" style="background:linear-gradient(135deg,#1e1b4b,#1e3a5f)">
                            <i class="fa-solid fa-gift text-lg md:text-2xl text-yellow-300 flex-shrink-0"></i>
                            <div>
                                <span class="text-gold font-black block" style="font-size:clamp(1.1rem,4vw,1.8rem);line-height:1;font-family:'DM Sans',sans-serif;">50% OFF</span>
                                <span class="text-yellow-200 text-xs font-light">al registrarte</span>
                            </div>
                            <div class="w-px h-7 bg-white/20 flex-shrink-0"></div>
                            <a href="{{ route('register') }}"
                               class="pulse-gold bg-yellow-400 hover:bg-yellow-300 text-slate-900 font-bold text-xs px-2.5 py-1.5 md:px-3 md:py-2 rounded-lg transition-all hover:-translate-y-0.5 whitespace-nowrap text-center flex-shrink-0">
                                Quiero mi<br>descuento →
                            </a>
                        </div>
                    </div>
                    <div class="badge-bounce absolute -top-2.5 -right-2.5 bg-red-500 text-white text-xs font-black px-2 py-0.5 rounded-full shadow-lg border-2 border-white">
                        ¡NUEVO!
                    </div>
                </div>
            </div>

            <div class="flex items-center gap-5 md:gap-8 mt-4 md:mt-10 reveal d4">
                @foreach([['12+','años exp.'],['80K+','equipos'],['100%','garantía']] as $s)
                <div>
                    <p class="text-lg md:text-2xl font-bold text-slate-900 font-serif">{{$s[0]}}</p>
                    <p class="text-xs text-slate-400 font-light">{{$s[1]}}</p>
                </div>
                @endforeach
            </div>
        </div>

        <div class="reveal-right hidden md:flex items-center justify-center">
            <div class="relative group">
                <div class="absolute -inset-6 bg-blue-100 rounded-3xl blur-2xl group-hover:bg-violet-100 transition-all duration-700"></div>
                <video autoplay loop muted playsinline
                       class="relative w-full max-w-lg mx-auto drop-shadow-xl group-hover:scale-105 transition-transform duration-700">
                    <source src="https://res.cloudinary.com/dobuneref/image/upload/f_webm,q_auto/v1782155254/certificaciones_kvy1a4.gif" type="video/webm">
                    <source src="https://res.cloudinary.com/dobuneref/image/upload/f_mp4,q_auto/v1782155254/certificaciones_kvy1a4.gif" type="video/mp4">
                </video>
            </div>
        </div>
    </div>

    <div class="absolute bottom-8 left-1/2 -translate-x-1/2 flex flex-col items-center gap-2 text-slate-300 reveal d5">
        <span class="text-xs tracking-widest uppercase">scroll</span>
        <div class="w-px h-8 bg-gradient-to-b from-slate-300 to-transparent"></div>
    </div>
</section>

{{-- STATS --}}
<div class="bg-slate-900 border-y border-slate-800">
    <div class="max-w-7xl mx-auto grid grid-cols-2 md:grid-cols-4 divide-x divide-slate-800">
        @foreach([['12+','Años de experiencia','fa-trophy'],['80K+','Equipos habilitados','fa-wrench'],['50K+','Cientes satisfechos','fa-laptop'],['100%','De garantia en servicios','fa-circle-check']] as $i=>$s)
        <div class="reveal py-5 px-3 md:py-10 md:px-8 hover:bg-slate-800/50 transition-colors" style="transition-delay:{{$i*.1}}s">
            <div class="text-base md:text-xl mb-1 md:mb-2 text-blue-400"><i class="fa-solid {{ $s[2] }}"></i></div>
            <p class="font-serif text-xl md:text-3xl font-bold text-white mb-0.5 md:mb-1">{{$s[0]}}</p>
            <p class="text-xs text-slate-400 font-light leading-tight">{{$s[1]}}</p>
        </div>
        @endforeach
    </div>
</div>

{{-- SERVICIOS --}}
<section id="servicios" class="py-14 px-4 md:py-24 md:px-6" style="background:linear-gradient(135deg,#f8fafc 0%,#eff6ff 100%);">
    <div class="max-w-7xl mx-auto">
        <div class="max-w-xl mb-14">
            <p class="text-xs font-semibold tracking-widest uppercase text-blue-600 mb-3 reveal">Lo que hacemos</p>
            <h2 class="font-serif text-3xl md:text-5xl font-bold text-slate-900 mb-4 reveal d1">Nuestros servicios</h2>
            <p class="text-slate-500 font-light reveal d2 leading-relaxed">Soluciones tecnológicas completas para personas y empresas — con garantía en cada trabajo.</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            @foreach([
                ['https://images.unsplash.com/photo-1531492746076-161ca9bcad58?w=800&q=80&fit=crop','fa-wrench','Reparación de equipos','Diagnóstico, mantenimiento y reparación de computadores, laptops, celulares e impresoras de cualquier marca.',['Computadores y laptops','Celulares y tablets','Impresoras']],
                ['https://images.unsplash.com/photo-1600267175161-cfaa711b4a81?w=800&q=80&fit=crop','fa-desktop','Soporte IT remoto y presencial','Asistencia técnica especializada para empresas y hogares. Resolución de problemas de software y sistemas.',['Soporte remoto 24/7','Visitas presenciales','Mantenimiento preventivo']],
                ['https://images.unsplash.com/photo-1558494949-ef010cbdcc31?w=800&q=80&fit=crop','fa-globe','Infraestructura de red','Diseño, instalación y configuración de redes cableadas e inalámbricas para hogares y empresas.',['Redes cableadas','WiFi empresarial','Seguridad de red']],
                ['https://images.unsplash.com/photo-1557597774-9d273605dfa9?w=800&q=80&fit=crop','fa-camera','CCTV y videovigilancia','Instalación y configuración de sistemas de videovigilancia con acceso remoto desde cualquier dispositivo.',['Cámaras HD y 4K','Acceso remoto','Monitoreo 24/7']],
            ] as $i=>$s)
            <div class="service-card reveal overflow-hidden p-0" style="transition-delay:{{$i*.1}}s; border-radius:20px;">
                <div class="relative h-40 md:h-52 overflow-hidden">
                    <img src="{{$s[0]}}" alt="{{$s[2]}}" class="w-full h-full object-cover transition-transform duration-700 hover:scale-105">
                    <div class="absolute inset-0" style="background:linear-gradient(to bottom,transparent 40%,rgba(15,23,42,.6) 100%)"></div>
                    <div class="absolute bottom-3 left-4 flex items-center gap-2">
                        <i class="fa-solid {{ $s[1] }} text-white text-xl md:text-2xl"></i>
                        <h3 class="font-serif font-bold text-white text-base md:text-lg">{{$s[2]}}</h3>
                    </div>
                </div>
                <div class="p-4 md:p-6">
                    <p class="text-xs md:text-sm text-slate-500 font-light leading-relaxed mb-4">{{$s[3]}}</p>
                    <div class="flex flex-wrap gap-2">
                        @foreach($s[4] as $tag)
                        <span class="text-xs font-medium text-blue-600 bg-blue-50 border border-blue-100 px-3 py-1 rounded-full">{{$tag}}</span>
                        @endforeach
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="text-center mt-8 reveal">
            <a href="{{ route('servicios') }}" class="inline-flex items-center gap-2 border border-blue-200 hover:border-blue-500 text-blue-600 hover:text-blue-700 text-sm font-medium px-8 py-3 rounded-xl transition-all">
                Ver todos los servicios →
            </a>
        </div>
    </div>
</section>

{{-- PROCESO --}}
<section class="py-14 px-4 md:py-24 md:px-6 bg-white">
    <div class="max-w-7xl mx-auto">
        <div class="text-center max-w-xl mx-auto mb-14">
            <p class="text-xs font-semibold tracking-widest uppercase text-blue-600 mb-3 reveal">Cómo trabajamos</p>
            <h2 class="font-serif text-3xl md:text-5xl font-bold text-slate-900 mb-4 reveal d1">Simple y transparente</h2>
            <p class="text-slate-500 font-light reveal d2">Siempre sabrás qué pasa con tu equipo.</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            @foreach([
                ['01','fa-inbox','Recepción','Traes tu equipo. Registramos el caso y te damos número de seguimiento.'],
                ['02','fa-magnifying-glass','Diagnóstico','Revisamos tu equipo e informamos el problema y presupuesto exacto.'],
                ['03','fa-wrench','Reparación','Con tu aprobación usamos repuestos de alta calidad.'],
                ['04','fa-circle-check','Entrega','Te entregamos en máximo 5 días hábiles con garantía escrita.'],
            ] as $i=>$step)
            <div class="step-card reveal" style="transition-delay:{{$i*.1}}s">
                <div class="relative inline-flex flex-col items-center mb-4">
                    <div class="w-14 h-14 bg-blue-600 rounded-2xl flex items-center justify-center text-2xl shadow-lg shadow-blue-600/20"><i class="fa-solid {{ $step[1] }} text-white"></i></div>
                    <span class="absolute -top-2 -right-2 bg-slate-900 text-white text-xs font-bold w-5 h-5 rounded-full flex items-center justify-center">{{$step[0]}}</span>
                </div>
                <h3 class="font-semibold text-slate-900 text-sm mb-2">{{$step[2]}}</h3>
                <p class="text-xs text-slate-500 font-light leading-relaxed">{{$step[3]}}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- 50% OFF --}}
<section class="py-14 px-4 md:py-24 md:px-6 relative overflow-hidden" style="background:linear-gradient(135deg,#0f172a 0%,#1e1b4b 50%,#0f172a 100%);">
    <div class="absolute inset-0 pointer-events-none" style="background-image:linear-gradient(rgba(139,92,246,.06) 1px,transparent 1px),linear-gradient(90deg,rgba(139,92,246,.06) 1px,transparent 1px);background-size:50px 50px"></div>
    <div class="absolute top-0 right-0 w-96 h-96 rounded-full blur-3xl pointer-events-none" style="background:radial-gradient(circle,rgba(139,92,246,.2),transparent 70%)"></div>
    <div class="absolute bottom-0 left-0 w-72 h-72 rounded-full blur-3xl pointer-events-none" style="background:radial-gradient(circle,rgba(59,130,246,.15),transparent 70%)"></div>
    <div class="absolute top-1/2 left-1/2 w-48 h-48 rounded-full blur-2xl pointer-events-none -translate-x-1/2 -translate-y-1/2" style="background:radial-gradient(circle,rgba(16,185,129,.08),transparent 70%)"></div>

    <div class="relative max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-16 items-center">
        <div class="reveal-left">
            <span class="inline-flex items-center gap-2 bg-violet-500/10 border border-violet-500/20 text-violet-300 text-xs font-medium tracking-widest uppercase px-4 py-1.5 rounded-full mb-6">
                <span class="w-1.5 h-1.5 bg-yellow-400 rounded-full animate-pulse"></span>
                Beneficio exclusivo
            </span>
            <h2 class="font-serif text-3xl md:text-5xl font-bold text-white leading-tight mb-6">
                Obtén un <span class="text-yellow-400">50% OFF</span> en tu próximo servicio
            </h2>
            <p class="text-slate-400 font-light leading-relaxed mb-8 max-w-md">Regístrate y accede a descuentos exclusivos, seguimiento en tiempo real y soporte prioritario.</p>
            <ul class="space-y-3 mb-8">
                @foreach(['50% en tu primer servicio','Seguimiento en tiempo real','Soporte prioritario por WhatsApp','Historial de tus reparaciones'] as $b)
                <li class="flex items-center gap-3 text-slate-300 text-sm font-light">
                    <svg class="w-4 h-4 text-yellow-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                    {{$b}}
                </li>
                @endforeach
            </ul>
            <a href="/register" class="inline-block bg-violet-600 hover:bg-violet-500 text-white text-sm font-semibold px-8 py-3.5 rounded-xl transition-all hover:-translate-y-0.5 hover:shadow-xl hover:shadow-violet-600/30">
                Registrarme y obtener 50% OFF
            </a>
        </div>

        {{-- VISUAL ABSTRACTO --}}
        <div class="reveal-right flex items-center justify-center">
            <div class="relative w-full max-w-md aspect-square">
                {{-- Círculos concéntricos animados --}}
                <div class="absolute inset-0 flex items-center justify-center">
                    <div class="absolute w-80 h-80 rounded-full border border-violet-500/20 animate-ping" style="animation-duration:3s"></div>
                    <div class="absolute w-64 h-64 rounded-full border border-blue-500/20 animate-ping" style="animation-duration:4s"></div>
                    <div class="absolute w-48 h-48 rounded-full border border-violet-400/30"></div>
                    <div class="absolute w-32 h-32 rounded-full border border-blue-400/40"></div>
                </div>

                {{-- Centro --}}
                <div class="absolute inset-0 flex items-center justify-center">
                    <div class="relative">
                        <div class="w-24 h-24 rounded-2xl flex items-center justify-center text-5xl shadow-2xl" style="background:linear-gradient(135deg,#7c3aed,#2563eb)">
                            <i class="fa-solid fa-gem text-white"></i>
                        </div>
                        <div class="absolute -top-3 -right-3 bg-yellow-400 text-slate-900 text-xs font-bold px-3 py-1 rounded-full">50% OFF</div>
                    </div>
                </div>

                {{-- Puntos orbitando --}}
                <div class="absolute inset-0 flex items-center justify-center" style="animation:spin 8s linear infinite">
                    <div class="relative w-64 h-64">
                        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-3 h-3 bg-violet-400 rounded-full shadow-lg shadow-violet-400/50"></div>
                        <div class="absolute bottom-0 left-1/2 -translate-x-1/2 w-3 h-3 bg-blue-400 rounded-full shadow-lg shadow-blue-400/50"></div>
                        <div class="absolute left-0 top-1/2 -translate-y-1/2 w-3 h-3 bg-emerald-400 rounded-full shadow-lg shadow-emerald-400/50"></div>
                        <div class="absolute right-0 top-1/2 -translate-y-1/2 w-3 h-3 bg-yellow-400 rounded-full shadow-lg shadow-yellow-400/50"></div>
                    </div>
                </div>

                {{-- Tags flotantes --}}
                <div class="absolute top-4 right-0 bg-white/5 border border-white/10 backdrop-blur rounded-xl px-3 py-2 float-anim">
                    <p class="text-white text-xs font-medium"><i class="fa-solid fa-wrench"></i> Reparación</p>
                </div>
                <div class="absolute bottom-8 left-0 bg-white/5 border border-white/10 backdrop-blur rounded-xl px-3 py-2 float-anim" style="animation-delay:1s">
                    <p class="text-white text-xs font-medium"><i class="fa-solid fa-globe"></i> Redes</p>
                </div>
                <div class="absolute top-1/2 right-2 bg-white/5 border border-white/10 backdrop-blur rounded-xl px-3 py-2 float-anim" style="animation-delay:2s">
                    <p class="text-white text-xs font-medium"><i class="fa-solid fa-camera"></i> CCTV</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- POR QUÉ NOSOTROS --}}
<section id="nosotros" class="py-14 px-4 md:py-24 md:px-6" style="background:linear-gradient(135deg,#faf5ff 0%,#f0f9ff 50%,#fff 100%);">
    <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-20 items-center">

        <div class="reveal-left flex items-center justify-center order-2 md:order-1">
            <div class="relative w-full max-w-md aspect-square">
                <div class="absolute inset-0 rounded-3xl blur-3xl pointer-events-none" style="background:radial-gradient(circle,rgba(139,92,246,.12),transparent 70%)"></div>
                <div class="absolute top-0 left-1/2 -translate-x-1/2 bg-white border border-violet-100 rounded-2xl px-6 py-4 shadow-lg float-anim text-center" style="animation-delay:0s">
                    <p class="font-serif font-bold text-4xl text-violet-600">80K+</p>
                    <p class="text-xs text-slate-400 font-light mt-1">Equipos habilitados</p>
                </div>
                <div class="absolute bottom-8 left-0 bg-white border border-blue-100 rounded-2xl px-5 py-4 shadow-lg float-anim text-center" style="animation-delay:1s">
                    <p class="font-serif font-bold text-3xl text-blue-600">12+</p>
                    <p class="text-xs text-slate-400 font-light mt-1">Años de experiencia</p>
                </div>
                <div class="absolute bottom-8 right-0 bg-white border border-emerald-100 rounded-2xl px-5 py-4 shadow-lg float-anim text-center" style="animation-delay:2s">
                    <p class="font-serif font-bold text-3xl text-emerald-600">100%</p>
                    <p class="text-xs text-slate-400 font-light mt-1">De garantia en servicios</p>
                </div>
                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 bg-white border border-slate-100 rounded-2xl px-5 py-4 shadow-xl float-anim text-center" style="animation-delay:0.5s">
                    <p class="font-serif font-bold text-3xl text-slate-900">50K+</p>
                    <p class="text-xs text-slate-400 font-light mt-1">Clientes Satisfechos</p>
                </div>
                <svg class="absolute inset-0 w-full h-full" viewBox="0 0 400 400" fill="none">
                    <line x1="200" y1="80" x2="200" y2="190" stroke="rgba(139,92,246,.15)" stroke-width="1" stroke-dasharray="4 4"/>
                    <line x1="200" y1="210" x2="90" y2="300" stroke="rgba(59,130,246,.15)" stroke-width="1" stroke-dasharray="4 4"/>
                    <line x1="200" y1="210" x2="310" y2="300" stroke="rgba(16,185,129,.15)" stroke-width="1" stroke-dasharray="4 4"/>
                    <circle cx="200" cy="200" r="6" fill="rgba(139,92,246,.3)"/>
                    <circle cx="200" cy="200" r="12" fill="none" stroke="rgba(139,92,246,.15)" stroke-width="1"/>
                </svg>
            </div>
        </div>

        <div class="order-1 md:order-2">
            <p class="text-xs font-semibold tracking-widest uppercase text-violet-600 mb-3 reveal-right">Por qué Novitec</p>
            <h2 class="font-serif text-3xl md:text-5xl font-bold text-slate-900 mb-3 reveal-right d1 leading-tight">Rápido, confiable<br>y con garantía</h2>
            <p class="text-slate-500 font-light mb-10 reveal-right d2">Más de 10 años resolviendo problemas tecnológicos en Quito.</p>
            <div class="space-y-5">
                @foreach([
                    ['fa-medal','Técnicos certificados','Nuestro equipo cuenta con certificaciones en las principales marcas y tecnologías del mercado.'],
                    ['fa-shield-halved','Garantía en todos los servicios','Todos nuestros trabajos incluyen garantía escrita. Si falla, lo resolvemos sin costo adicional.'],
                    ['fa-box','Tiempo de entrega de 5 días','Entregamos tu equipo reparado en un plazo máximo de 5 días hábiles según el diagnóstico.'],
                    ['fa-wrench','Repuestos de calidad','Trabajamos únicamente con repuestos originales o de alta calidad certificada.'],
                ] as $i=>$f)
                <div class="flex gap-4 reveal-right" style="transition-delay:{{($i+3)*.08}}s">
                    <div class="w-10 h-10 bg-violet-50 border border-violet-100 rounded-xl flex items-center justify-center flex-shrink-0 text-lg text-violet-600"><i class="fa-solid {{ $f[0] }}"></i></div>
                    <div>
                        <p class="font-semibold text-slate-900 text-sm mb-1">{{$f[1]}}</p>
                        <p class="text-sm text-slate-500 font-light">{{$f[2]}}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

{{-- TESTIMONIOS --}}
<section class="py-14 px-4 md:py-24 md:px-6 bg-slate-900">
    <div class="max-w-7xl mx-auto">
        <div class="text-center max-w-xl mx-auto mb-14">
            <p class="text-xs font-semibold tracking-widest uppercase text-violet-400 mb-3 reveal">Testimonios</p>
            <h2 class="font-serif text-3xl md:text-5xl font-bold text-white mb-4 reveal d1">Lo que dicen<br>nuestros clientes</h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach([
                ['Carlos M.','Empresa Constructora','Llevé mi laptop con pantalla rota y en menos de 5 días ya estaba lista. Excelente servicio y precio justo.'],
                ['María F.','Diseñadora independiente','Recuperaron todos mis archivos cuando el disco duro falló. Pensé que había perdido 3 años de trabajo.'],
                ['Roberto A.','Gerente TI','Contratamos el soporte IT mensual y ha sido excelente. Responden rápido y resuelven todo eficientemente.'],
            ] as $i=>$t)
            <div class="testi-card reveal" style="transition-delay:{{$i*.1}}s">
                <p class="text-xl mb-4 text-yellow-400">@for($k=0;$k<5;$k++)<i class="fa-solid fa-star"></i>@endfor</p>
                <p class="text-slate-300 text-sm font-light leading-relaxed mb-6 italic">"{{$t[2]}}"</p>
                <div class="flex items-center gap-3 pt-4 border-t border-white/10">
                    <div class="w-9 h-9 bg-violet-600 rounded-full flex items-center justify-center text-white text-sm font-bold">{{substr($t[0],0,1)}}</div>
                    <div>
                        <p class="text-white text-sm font-medium">{{$t[0]}}</p>
                        <p class="text-slate-400 text-xs font-light">{{$t[1]}}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- CONTACTO --}}
<section id="contacto" class="py-14 px-4 md:py-24 md:px-6" style="background:linear-gradient(135deg,#eff6ff 0%,#f8fafc 100%);">
    <div class="max-w-5xl mx-auto">
        <div class="text-center mb-14">
            <p class="text-xs font-semibold tracking-widest uppercase text-blue-600 mb-3 reveal">Encuéntranos</p>
            <h2 class="font-serif text-3xl md:text-5xl font-bold text-slate-900 mb-4 reveal d1">¿Tu equipo tiene<br>un problema?</h2>
            <p class="text-slate-500 font-light reveal d2">Diagnóstico y atención rápida garantizada.</p>
        </div>
        @php $branchCols = count($branches) > 1 ? '2' : '1'; @endphp
        <div class="grid grid-cols-1 md:grid-cols-{{ $branchCols }} gap-6 mb-10">
            @foreach($branches as $branch)
            <div class="branch-card reveal">
                <h3 class="font-semibold text-slate-900 text-sm mb-4 flex items-center gap-2">
                    <span class="w-2 h-2 bg-blue-500 rounded-full animate-pulse"></span>{{$branch->name}}
                </h3>
                <div class="space-y-2 text-sm text-slate-500 font-light mb-5">
                    <p><i class="fa-solid fa-location-dot text-blue-500"></i> {{$branch->address}}</p>
                    <p><i class="fa-solid fa-phone text-blue-500"></i> {{$branch->phone}}</p>
                    @if($branch->email)<p><i class="fa-solid fa-envelope text-blue-500"></i> {{$branch->email}}</p>@endif
                    @if($branch->schedule)<p><i class="fa-solid fa-clock text-blue-500"></i> {{$branch->schedule}}</p>@endif
                </div>
                @if($branch->whatsapp)
                <a href="https://wa.me/{{$branch->whatsapp}}" target="_blank"
                   class="inline-flex items-center gap-2 bg-green-500 hover:bg-green-600 text-white text-xs font-medium px-5 py-2.5 rounded-xl transition-all hover:-translate-y-0.5">
                    WhatsApp
                </a>
                @endif
            </div>
            @endforeach
        </div>
        <div class="flex justify-center gap-3 flex-wrap reveal d2">
            @foreach($socials as $social)
            <a href="{{$social->url}}" target="_blank"
               class="border border-slate-200 hover:border-blue-400 hover:text-blue-600 text-slate-500 text-sm px-6 py-2.5 rounded-xl transition-all">
                {{$social->platform}}
            </a>
            @endforeach
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
