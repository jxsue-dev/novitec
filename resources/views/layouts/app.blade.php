<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Novitec – Servicio Técnico & Soporte IT')</title>

    {{-- Google Analytics 4 — Consent Mode v2 --}}
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-NNM63X36FH"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}

        // Consent por defecto: denegado hasta que el usuario acepte
        gtag('consent', 'default', {
            'analytics_storage': 'denied',
            'ad_storage':        'denied',
            'wait_for_update':   500
        });

        gtag('js', new Date());
        gtag('config', 'G-NNM63X36FH');

        // Si ya aceptó en sesión anterior, activar datos
        if (localStorage.getItem('nv_cookie_consent') === 'accepted') {
            gtag('consent', 'update', { 'analytics_storage': 'granted', 'ad_storage': 'granted' });
        }

        function loadGA() {
            gtag('consent', 'update', { 'analytics_storage': 'granted', 'ad_storage': 'granted' });
        }
    </script>

    {{-- SEO --}}
    <meta name="description" content="@yield('description', 'Servicio técnico profesional en Ecuador. Reparación de computadoras, laptops, celulares e impresoras. Soporte IT remoto y presencial, redes y CCTV. Novitec – Quito, Guayaquil, Manta.')">
    <meta name="keywords" content="@yield('keywords', 'servicio técnico quito, reparación computadoras quito, reparación celulares ecuador, soporte IT empresarial, servicio técnico ecuador, novitec, novicompu')">
    <meta name="robots" content="index, follow">
    <meta name="author" content="Novitecnología Cia. Ltda.">
    <link rel="canonical" href="{{ url()->current() }}">

    {{-- FAVICON --}}
    <link rel="icon" type="image/png" href="{{ asset('images/novitec_logo.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('images/novitec_logo.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/novitec_logo.png') }}">

    {{-- OPEN GRAPH --}}
    <meta property="og:title" content="@yield('title', 'Novitec – Servicio Técnico Ecuador')">
    <meta property="og:description" content="@yield('description', 'Servicio técnico profesional en Ecuador. Reparación de computadoras, laptops, celulares. Soporte IT, redes y CCTV.')">
    <meta property="og:image" content="{{ asset('images/novitec_og.png') }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="website">
    <meta property="og:locale" content="es_EC">
    <meta property="og:site_name" content="Novitec">

    {{-- TWITTER CARD --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('title', 'Novitec – Servicio Técnico Ecuador')">
    <meta name="twitter:description" content="@yield('description', 'Servicio técnico profesional en Ecuador.')">
    <meta name="twitter:image" content="{{ asset('images/novitec_og.png') }}">

    {{-- SCHEMA.ORG LocalBusiness --}}
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "LocalBusiness",
        "@id": "https://novitec.com.ec/#business",
        "name": "Novitec – Novitecnología Cia. Ltda.",
        "alternateName": ["Novitec", "Novicompu", "Novitecnología"],
        "description": "Empresa ecuatoriana especializada en servicio técnico profesional: reparación de computadoras, laptops, celulares e impresoras. Soporte IT remoto y presencial, infraestructura de redes y sistemas CCTV.",
        "url": "https://novitec.com.ec",
        "logo": "https://novitec.com.ec/images/novitec_logo.png",
        "image": "https://novitec.com.ec/images/novitec_og.png",
        "telephone": "+593960500156",
        "email": "soporte@novitec.com.ec",
        "foundingDate": "2013",
        "priceRange": "$$",
        "currenciesAccepted": "USD",
        "paymentAccepted": "Cash, Credit Card, Bank Transfer",
        "address": {
            "@type": "PostalAddress",
            "streetAddress": "Calle N73 y Mariano Paredes, Ponceano Alto",
            "addressLocality": "Quito",
            "addressRegion": "Pichincha",
            "postalCode": "170102",
            "addressCountry": "EC"
        },
        "geo": {
            "@type": "GeoCoordinates",
            "latitude": -0.1800427,
            "longitude": -78.5734424
        },
        "areaServed": [
            {"@type": "City", "name": "Quito"},
            {"@type": "City", "name": "Guayaquil"},
            {"@type": "City", "name": "Manta"},
            {"@type": "Country", "name": "Ecuador"}
        ],
        "openingHoursSpecification": [{
            "@type": "OpeningHoursSpecification",
            "dayOfWeek": ["Monday","Tuesday","Wednesday","Thursday","Friday"],
            "opens": "09:00",
            "closes": "17:00"
        }],
        "hasOfferCatalog": {
            "@type": "OfferCatalog",
            "name": "Servicios Técnicos Novitec",
            "itemListElement": [
                {"@type": "Offer", "itemOffered": {"@type": "Service", "name": "Reparación de Computadoras y Laptops", "description": "Diagnóstico, mantenimiento y reparación de computadoras y laptops de todas las marcas."}},
                {"@type": "Offer", "itemOffered": {"@type": "Service", "name": "Reparación de Celulares y Tablets"}},
                {"@type": "Offer", "itemOffered": {"@type": "Service", "name": "Reparación de Impresoras"}},
                {"@type": "Offer", "itemOffered": {"@type": "Service", "name": "Soporte IT Remoto y Presencial"}},
                {"@type": "Offer", "itemOffered": {"@type": "Service", "name": "Infraestructura de Redes"}},
                {"@type": "Offer", "itemOffered": {"@type": "Service", "name": "CCTV y Videovigilancia"}}
            ]
        },
        "sameAs": ["https://wa.me/593960500156"]
    }
    </script>

    @stack('schema')

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased">

{{-- NAVBAR --}}
<nav id="navbar" class="fixed top-0 w-full z-50 transition-all duration-500">
    <div class="max-w-7xl mx-auto px-6 md:px-8 py-4 md:py-5 flex items-center justify-between">

        <a href="/">
            <img src="{{ asset('images/novitec_logo.png') }}" alt="Novitec" class="h-8 md:h-9 brightness-0 invert">
        </a>

        {{-- LINKS DESKTOP --}}
        <ul class="hidden md:flex items-center gap-10 text-sm text-slate-400">
            <li><a href="/" class="hover:text-white transition-colors duration-200 tracking-wide">Inicio</a></li>
            <li><a href="{{ route('conocenos') }}" class="hover:text-white transition-colors duration-200 tracking-wide">Conócenos</a></li>
            <li><a href="{{ route('servicios') }}" class="hover:text-white transition-colors duration-200 tracking-wide">Servicios</a></li>
            <li class="relative group">
                <button class="hover:text-white transition-colors duration-200 tracking-wide flex items-center gap-1">
                    Garantías
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </button>
                <div class="absolute top-full left-0 mt-2 w-52 rounded-xl border border-white/10 overflow-hidden opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200" style="background:rgba(9,11,24,.97);backdrop-filter:blur(12px)">
                    <a href="{{ route('garantias') }}" class="block px-4 py-3 text-sm text-slate-400 hover:text-white hover:bg-white/5 transition-colors"><i class="fa-solid fa-magnifying-glass"></i> Consultar mi garantía</a>
                    <a href="{{ route('warranties') }}" class="block px-4 py-3 text-sm text-slate-400 hover:text-white hover:bg-white/5 transition-colors border-t border-white/5"><i class="fa-solid fa-circle-check"></i> Validar mi garantía</a>
                    <a href="{{ route('soporte-autorizado') }}" class="block px-4 py-3 text-sm text-slate-400 hover:text-white hover:bg-white/5 transition-colors border-t border-white/5"><i class="fa-solid fa-screwdriver-wrench"></i> Soporte Autorizado</a>
                </div>
            </li>
            <li><a href="{{ route('contacto') }}" class="hover:text-white transition-colors duration-200 tracking-wide">Contacto</a></li>
        </ul>

        {{-- BOTONES DESKTOP --}}
        <div class="flex items-center gap-2">
            @auth
                {{-- Chat IA (todos los usuarios autenticados) --}}
                <button onclick="toggleWidget()"
                   class="hidden md:inline-flex items-center gap-1.5 text-sm bg-gradient-to-r from-blue-600 to-violet-600 hover:from-blue-500 hover:to-violet-500 text-white px-4 py-2 rounded-xl transition-all shadow-lg shadow-blue-600/20 hover:shadow-blue-500/30 hover:-translate-y-0.5 border-0 cursor-pointer">
                    <i class="fa-solid fa-robot text-xs"></i> Chat IA
                </button>
                @if(auth()->user()->is_admin)
                {{-- Sin botón admin en el header --}}
                @else
                <div class="relative group hidden md:block">
                    <button class="text-sm border border-white/20 hover:border-blue-400 text-slate-300 hover:text-white px-4 py-2 rounded-xl transition-all flex items-center gap-1">
                        Mi cuenta
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div class="absolute top-full right-0 mt-2 w-44 rounded-xl border border-white/10 overflow-hidden opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200" style="background:rgba(9,11,24,.97);backdrop-filter:blur(12px)">
                        <a href="{{ route('client.orders') }}" class="block px-4 py-3 text-sm text-slate-400 hover:text-white hover:bg-white/5 transition-colors"><i class="fa-solid fa-box"></i> Mis órdenes</a>
                        <a href="{{ route('profile.edit') }}" class="block px-4 py-3 text-sm text-slate-400 hover:text-white hover:bg-white/5 transition-colors border-t border-white/5"><i class="fa-solid fa-gear"></i> Mi perfil</a>
                    </div>
                </div>
                @endif
                <form method="POST" action="{{ route('logout') }}" class="hidden md:block">
                    @csrf
                    <button type="submit" class="text-sm border border-white/20 hover:border-white/50 text-slate-300 hover:text-white px-4 py-2 rounded-xl transition-all">
                        Salir
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="hidden md:inline-flex text-sm text-slate-300 hover:text-white px-4 py-2 rounded-xl transition-all">
                    Iniciar sesión
                </a>
                <a href="{{ route('register') }}" class="hidden md:inline-flex text-sm bg-blue-600 hover:bg-blue-500 text-white px-5 py-2 rounded-xl transition-all hover:shadow-lg hover:shadow-blue-600/25">
                    Registrarse
                </a>
            @endauth

            {{-- HAMBURGER MÓVIL --}}
            <button id="menu-btn" class="md:hidden flex flex-col gap-1.5 p-2" onclick="toggleMenu()">
                <span class="w-5 h-0.5 bg-white transition-all duration-300" id="bar1"></span>
                <span class="w-5 h-0.5 bg-white transition-all duration-300" id="bar2"></span>
                <span class="w-5 h-0.5 bg-white transition-all duration-300" id="bar3"></span>
            </button>
        </div>
    </div>

    {{-- MENÚ MÓVIL --}}
    <div id="mobile-menu" class="md:hidden hidden border-t border-white/10 px-6 py-4 space-y-1" style="background:rgba(9,11,24,.97);backdrop-filter:blur(12px)">
        <a href="/" onclick="toggleMenu()" class="block text-sm text-slate-300 hover:text-white py-2.5 transition-colors">Inicio</a>
        <a href="{{ route('conocenos') }}" onclick="toggleMenu()" class="block text-sm text-slate-300 hover:text-white py-2.5 transition-colors">Conócenos</a>
        <a href="{{ route('servicios') }}" onclick="toggleMenu()" class="block text-sm text-slate-300 hover:text-white py-2.5 transition-colors">Servicios</a>
        <div class="border-t border-white/5 pt-2 mt-1">
            <p class="text-xs text-slate-500 uppercase tracking-widest mb-2 font-medium">Garantías</p>
            <a href="{{ route('garantias') }}" onclick="toggleMenu()" class="block text-sm text-slate-300 hover:text-white py-2 pl-2 transition-colors"><i class="fa-solid fa-magnifying-glass"></i> Consultar mi garantía</a>
            <a href="{{ route('warranties') }}" onclick="toggleMenu()" class="block text-sm text-slate-300 hover:text-white py-2 pl-2 transition-colors"><i class="fa-solid fa-circle-check"></i> Validar mi garantía</a>
            <a href="{{ route('soporte-autorizado') }}" onclick="toggleMenu()" class="block text-sm text-slate-300 hover:text-white py-2 pl-2 transition-colors"><i class="fa-solid fa-screwdriver-wrench"></i> Soporte Autorizado</a>
        </div>
        <a href="{{ route('contacto') }}" onclick="toggleMenu()" class="block text-sm text-slate-300 hover:text-white py-2.5 transition-colors">Contacto</a>

        <div class="pt-2 flex flex-col gap-2 border-t border-white/5 mt-1">
            @auth
                <button onclick="toggleMenu(); setTimeout(toggleWidget, 350);"
                   class="block w-full text-sm bg-gradient-to-r from-blue-600 to-violet-600 text-white text-center py-2.5 rounded-xl border-0 cursor-pointer">
                    <i class="fa-solid fa-robot"></i> Chat IA
                </button>
                @if(auth()->user()->is_admin)
                {{-- Sin botón admin en el header --}}
                @else
                <a href="{{ route('client.orders') }}" onclick="toggleMenu()" class="block text-sm border border-white/20 text-slate-300 text-center py-2.5 rounded-xl"><i class="fa-solid fa-box"></i> Mis órdenes</a>
                <a href="{{ route('profile.edit') }}" onclick="toggleMenu()" class="block text-sm border border-white/20 text-slate-300 text-center py-2.5 rounded-xl"><i class="fa-solid fa-gear"></i> Mi perfil</a>
                @endif
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-sm border border-white/20 text-slate-300 text-center py-2.5 rounded-xl">Salir</button>
                </form>
            @else
                <a href="{{ route('login') }}" onclick="toggleMenu()" class="block text-sm border border-white/20 text-slate-300 text-center py-2.5 rounded-xl">Iniciar sesión</a>
                <a href="{{ route('register') }}" onclick="toggleMenu()" class="block text-sm bg-blue-600 text-white text-center py-2.5 rounded-xl">Registrarse</a>
            @endauth
        </div>
    </div>
</nav>

{{-- ═══ CHAT WIDGET ═══════════════════════════════════════════════════════ --}}
<style>
@keyframes chat-pulse{0%{box-shadow:0 0 0 0 rgba(99,102,241,.65),0 8px 32px rgba(99,102,241,.4)}70%{box-shadow:0 0 0 16px rgba(99,102,241,0),0 8px 32px rgba(99,102,241,.4)}100%{box-shadow:0 0 0 0 rgba(99,102,241,0),0 8px 32px rgba(99,102,241,.4)}}
@keyframes widget-in{from{opacity:0;transform:translateY(20px) scale(.96)}to{opacity:1;transform:none}}
#chat-fab{animation:chat-pulse 2.2s ease-in-out infinite;}
#chat-fab:hover{animation:none;transform:scale(1.1) translateY(-3px);}
#chat-widget{animation:widget-in .25s ease;}
#widget-msgs::-webkit-scrollbar{width:4px}
#widget-msgs::-webkit-scrollbar-thumb{background:#334155;border-radius:4px}
.wmsg-user{background:#4f46e5;color:#fff;border-radius:18px 18px 4px 18px;margin-left:auto;}
.wmsg-bot{background:#1e293b;color:#e2e8f0;border-radius:18px 18px 18px 4px;}
@keyframes wdots{0%,100%{opacity:.3}50%{opacity:1}}
.wdot{width:6px;height:6px;border-radius:50%;background:#818cf8;display:inline-block;animation:wdots 1.2s infinite;}
.wdot:nth-child(2){animation-delay:.2s}.wdot:nth-child(3){animation-delay:.4s}
#widget-input::placeholder{color:#64748b}
</style>

{{-- WIDGET POPUP --}}
@auth
<div id="chat-widget" style="display:none;position:fixed;bottom:100px;right:24px;width:370px;z-index:9998;flex-direction:column;border-radius:20px;overflow:hidden;box-shadow:0 24px 64px rgba(0,0,0,.45);border:1px solid rgba(255,255,255,.07);">

    {{-- Header --}}
    <div style="background:linear-gradient(135deg,#4f46e5,#7c3aed);padding:14px 18px;display:flex;align-items:center;gap:12px;">
        <div style="width:38px;height:38px;border-radius:50%;background:rgba(255,255,255,.15);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
            <i class="fa-solid fa-robot" style="color:#fff;font-size:1.1rem;"></i>
        </div>
        <div style="flex:1;min-width:0;">
            <p style="color:#fff;font-weight:600;font-size:14px;margin:0;line-height:1.2;">Asistente IA Novitec</p>
            <p style="color:rgba(255,255,255,.65);font-size:11px;margin:0;display:flex;align-items:center;gap:5px;">
                <span style="width:7px;height:7px;border-radius:50%;background:#4ade80;display:inline-block;flex-shrink:0;"></span>En línea
            </p>
        </div>
        <button onclick="toggleWidget()" style="background:rgba(255,255,255,.15);border:none;color:#fff;width:30px;height:30px;border-radius:8px;cursor:pointer;font-size:14px;display:flex;align-items:center;justify-content:center;">✕</button>
    </div>

    {{-- Messages --}}
    <div id="widget-msgs" style="background:#0f172a;height:380px;overflow-y:auto;padding:16px;display:flex;flex-direction:column;gap:10px;">
        <div id="widget-loading" style="display:flex;align-items:center;justify-content:center;height:100%;color:#475569;font-size:13px;">
            <span>Cargando...</span>
        </div>
    </div>

    {{-- Typing indicator --}}
    <div id="widget-typing" style="display:none;padding:8px 16px;background:#0f172a;border-top:1px solid rgba(255,255,255,.04);">
        <div class="wmsg-bot" style="display:inline-flex;align-items:center;gap:5px;padding:10px 14px;">
            <span class="wdot"></span><span class="wdot"></span><span class="wdot"></span>
        </div>
    </div>

    {{-- Input --}}
    <div style="background:#1e293b;padding:12px;border-top:1px solid rgba(255,255,255,.05);">
        <div style="display:flex;align-items:flex-end;gap:8px;background:#0f172a;border-radius:14px;padding:10px 12px;border:1px solid rgba(255,255,255,.07);">
            <textarea id="widget-input" rows="1"
                      placeholder="Escribe tu mensaje..."
                      style="flex:1;background:none;border:none;color:#f1f5f9;font-size:13px;outline:none;resize:none;font-family:inherit;max-height:100px;line-height:1.5;"
                      onkeydown="if(event.key==='Enter'&&!event.shiftKey){event.preventDefault();widgetSend();}"></textarea>
            <button onclick="widgetSend()" id="widget-send-btn"
                    style="width:34px;height:34px;border-radius:10px;background:linear-gradient(135deg,#4f46e5,#7c3aed);border:none;color:#fff;cursor:pointer;display:flex;align-items:center;justify-content:center;flex-shrink:0;transition:opacity .2s;">
                <i class="fa-solid fa-paper-plane" style="font-size:12px;"></i>
            </button>
        </div>
        <p style="color:#334155;font-size:10px;text-align:center;margin:6px 0 0;">Enter para enviar · Shift+Enter nueva línea</p>
    </div>
</div>
@endauth

{{-- FAB BUTTON --}}
<button id="chat-fab" onclick="{{ auth()->check() ? 'toggleWidget()' : 'window.location=\''.route('login').'\'' }}"
   title="Asistente IA Novitec"
   style="position:fixed;bottom:24px;right:24px;z-index:9999;width:62px;height:62px;border-radius:50%;background:linear-gradient(135deg,#4f46e5,#7c3aed);border:none;display:flex;align-items:center;justify-content:center;cursor:pointer;transition:transform .2s ease;">
    <i class="fa-solid fa-robot" style="color:#fff;font-size:1.5rem;"></i>
</button>

@auth
<script>
let _widgetLoaded = false;
let _widgetConvId = null;
const _csrf = document.querySelector('meta[name="csrf-token"]')?.content ?? '';

function toggleWidget() {
    const w = document.getElementById('chat-widget');
    const open = w.style.display === 'none' || w.style.display === '';
    w.style.display = open ? 'flex' : 'none';
    if (open && !_widgetLoaded) _loadWidget();
}

async function _loadWidget() {
    try {
        const res  = await fetch('{{ route('chat.widget.data') }}', { headers: { 'Accept': 'application/json' } });
        const data = await res.json();
        _widgetConvId = data.conversation_id;

        const msgs = document.getElementById('widget-msgs');
        msgs.innerHTML = '';

        if (!data.messages || data.messages.length === 0) {
            _appendMsg('assistant', '¡Hola! 👋 Soy el asistente de Novitec. ¿En qué puedo ayudarte hoy?');
        } else {
            data.messages.forEach(m => _appendMsg(m.role, m.content));
        }
        _widgetLoaded = true;
        _scrollMsgs();
    } catch(e) {
        document.getElementById('widget-loading').textContent = 'Error al cargar. Recarga la página.';
    }
}

async function widgetSend() {
    const inp = document.getElementById('widget-input');
    const msg = inp.value.trim();
    if (!msg) return;
    inp.value = '';
    inp.style.height = 'auto';

    _appendMsg('user', msg);
    _scrollMsgs();

    document.getElementById('widget-typing').style.display = 'block';
    document.getElementById('widget-send-btn').style.opacity = '.4';
    _scrollMsgs();

    try {
        const res = await fetch('{{ route('chat.widget.message') }}', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': _csrf, 'Accept': 'application/json' },
            body: JSON.stringify({ message: msg }),
        });
        const data = await res.json();
        document.getElementById('widget-typing').style.display = 'none';
        _appendMsg('assistant', data.reply ?? 'Error al responder.');
    } catch {
        document.getElementById('widget-typing').style.display = 'none';
        _appendMsg('assistant', 'Error de conexión. Intenta de nuevo.');
    } finally {
        document.getElementById('widget-send-btn').style.opacity = '1';
        _scrollMsgs();
    }
}

function _appendMsg(role, content) {
    const msgs = document.getElementById('widget-msgs');
    const isUser = role === 'user';
    const el = document.createElement('div');
    el.className = isUser ? 'wmsg-user' : 'wmsg-bot';
    el.style.cssText = `max-width:82%;padding:10px 14px;font-size:13px;line-height:1.6;white-space:pre-wrap;word-break:break-word;`;
    el.textContent = content;
    msgs.appendChild(el);
}

function _scrollMsgs() {
    const msgs = document.getElementById('widget-msgs');
    msgs.scrollTop = msgs.scrollHeight;
}

// Auto-resize textarea
document.getElementById('widget-input')?.addEventListener('input', function() {
    this.style.height = 'auto';
    this.style.height = Math.min(this.scrollHeight, 100) + 'px';
});
</script>
@endauth

{{-- ═══ AVISO DE PRIVACIDAD ════════════════════════════════════════════════ --}}
<div id="nv-privacy-bar"
     style="display:none;position:fixed;bottom:0;left:0;right:0;z-index:10000;
            background:rgba(9,11,24,.98);backdrop-filter:blur(20px);
            border-top:2px solid rgba(79,70,229,.5);
            padding:28px 32px;font-family:inherit;
            box-shadow:0 -8px 40px rgba(0,0,0,.5);">
    <div style="max-width:1280px;margin:0 auto;display:flex;align-items:center;justify-content:space-between;gap:24px;flex-wrap:wrap;">
        <div style="flex:1;min-width:300px;display:flex;align-items:flex-start;gap:16px;">
            <div style="width:46px;height:46px;border-radius:12px;background:linear-gradient(135deg,#4f46e5,#7c3aed);
                        display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="white" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                </svg>
            </div>
            <div>
                <p style="color:#f1f5f9;font-size:15px;font-weight:700;margin:0 0 6px;letter-spacing:-.01em;">
                    Tu privacidad nos importa
                </p>
                <p style="color:#94a3b8;font-size:13px;margin:0;line-height:1.7;max-width:560px;">
                    Usamos tecnologías de seguimiento para mejorar tu experiencia y analizar el uso del sitio.
                    Puedes aceptar todas o solo las esenciales. Más info en nuestra
                    <a href="{{ route('privacidad') }}" style="color:#818cf8;text-decoration:underline;font-weight:500;">Política de privacidad</a>.
                </p>
            </div>
        </div>
        <div style="display:flex;gap:12px;flex-shrink:0;flex-wrap:wrap;align-items:center;">
            <button onclick="nvPrivacyDecline()"
                    style="padding:12px 24px;border:1px solid rgba(255,255,255,.2);background:transparent;
                           color:#cbd5e1;font-size:13px;font-weight:500;border-radius:12px;cursor:pointer;
                           font-family:inherit;transition:all .2s;white-space:nowrap;"
                    onmouseover="this.style.background='rgba(255,255,255,.07)';this.style.color='#fff';this.style.borderColor='rgba(255,255,255,.4)'"
                    onmouseout="this.style.background='transparent';this.style.color='#cbd5e1';this.style.borderColor='rgba(255,255,255,.2)'">
                Solo esenciales
            </button>
            <button onclick="nvPrivacyAccept()"
                    style="padding:13px 28px;background:linear-gradient(135deg,#2563eb,#4f46e5);
                           border:none;color:#fff;font-size:14px;font-weight:700;border-radius:12px;
                           cursor:pointer;font-family:inherit;
                           box-shadow:0 4px 20px rgba(79,70,229,.5);
                           transition:all .2s;white-space:nowrap;letter-spacing:-.01em;"
                    onmouseover="this.style.transform='translateY(-2px)';this.style.boxShadow='0 8px 28px rgba(79,70,229,.6)'"
                    onmouseout="this.style.transform='none';this.style.boxShadow='0 4px 20px rgba(79,70,229,.5)'">
                ✓ Aceptar todo
            </button>
        </div>
    </div>
</div>

<script>
(function(){
    const KEY = 'nv_cookie_consent';
    if (!localStorage.getItem(KEY)) {
        setTimeout(() => {
            const b = document.getElementById('nv-privacy-bar');
            if (b) b.style.display = 'block';
        }, 800);
    }
})();
function nvPrivacyAccept() {
    localStorage.setItem('nv_cookie_consent', 'accepted');
    if (typeof loadGA === 'function') loadGA();
    nvPrivacyHide();
}
function nvPrivacyDecline() {
    localStorage.setItem('nv_cookie_consent', 'essential');
    nvPrivacyHide();
}
function nvPrivacyHide() {
    const b = document.getElementById('nv-privacy-bar');
    if (!b) return;
    b.style.transition = 'opacity .4s ease, transform .4s ease';
    b.style.opacity = '0';
    b.style.transform = 'translateY(20px)';
    setTimeout(() => b.style.display = 'none', 420);
}
// Alias para compatibilidad
function cookieAccept(){ nvPrivacyAccept(); }
function cookieDecline(){ nvPrivacyDecline(); }
function hideCookieBanner(){ nvPrivacyHide(); }
</script>

{{-- CONTENIDO --}}
<main>
    @yield('content')
</main>

{{-- FOOTER --}}
<footer style="background:linear-gradient(135deg,#020817 0%,#0c1a35 50%,#020817 100%);">
    <div class="border-b border-white/5 py-14 md:py-16 px-5 md:px-8">
        <div class="max-w-7xl mx-auto grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-10 lg:gap-12">

            {{-- MARCA --}}
            <div>
                <img src="{{ asset('images/novitec_logo.png') }}" alt="Novitec" style="height:36px; filter:brightness(0) invert(1); margin-bottom:1.25rem;">
                <p style="color:#94a3b8; font-size:0.875rem; font-weight:300; line-height:1.75; margin-bottom:1.5rem;">
                    Soluciones tecnológicas profesionales para personas y empresas. Más de 10 años de experiencia.
                </p>
                <div style="display:flex; gap:0.75rem;">
                    <a href="https://wa.me/593960500156" target="_blank"
                       style="width:36px; height:36px; border-radius:10px; border:1px solid rgba(34,197,94,0.3); background:rgba(34,197,94,0.15); display:flex; align-items:center; justify-content:center; color:#4ade80; font-size:1.1rem; text-decoration:none; transition:all 0.2s;" title="WhatsApp">
                        <i class="fa-brands fa-whatsapp"></i>
                    </a>
                </div>
            </div>

            {{-- SERVICIOS --}}
            <div>
                <p style="color:white; font-size:0.75rem; font-weight:600; letter-spacing:0.1em; text-transform:uppercase; margin-bottom:1.25rem;">Servicios</p>
                <ul style="list-style:none; padding:0; margin:0; display:flex; flex-direction:column; gap:0.75rem;">
                    @foreach(['Reparación de equipos','Soporte IT remoto','Infraestructura de red','CCTV y videovigilancia'] as $item)
                    <li><a href="{{ route('servicios') }}" style="color:#94a3b8; font-size:0.875rem; font-weight:300; text-decoration:none;">{{ $item }}</a></li>
                    @endforeach
                </ul>
            </div>

            {{-- EMPRESA --}}
            <div>
                <p style="color:white; font-size:0.75rem; font-weight:600; letter-spacing:0.1em; text-transform:uppercase; margin-bottom:1.25rem;">Empresa</p>
                <ul style="list-style:none; padding:0; margin:0; display:flex; flex-direction:column; gap:0.75rem;">
                    <li><a href="/" style="color:#94a3b8; font-size:0.875rem; font-weight:300; text-decoration:none;">Inicio</a></li>
                    <li><a href="{{ route('conocenos') }}" style="color:#94a3b8; font-size:0.875rem; font-weight:300; text-decoration:none;">Conócenos</a></li>
                    <li><a href="{{ route('garantias') }}" style="color:#94a3b8; font-size:0.875rem; font-weight:300; text-decoration:none;">Consultar mi garantía</a></li>
                    <li><a href="{{ route('resenas') }}" style="color:#94a3b8; font-size:0.875rem; font-weight:300; text-decoration:none;">⭐ Reseñas</a></li>
                    <li><a href="{{ route('privacidad') }}" style="color:#94a3b8; font-size:0.875rem; font-weight:300; text-decoration:none;">Política de privacidad</a></li>
                    <li><a href="{{ route('terminos') }}" style="color:#94a3b8; font-size:0.875rem; font-weight:300; text-decoration:none;">Términos y condiciones</a></li>
                </ul>
            </div>

            {{-- CONTACTO --}}
            <div>
                @php $mainBranch = ($branches ?? collect())->first(); @endphp
                @if($mainBranch)
                <div style="display:flex; flex-direction:column; gap:0.5rem; margin-bottom:1rem;">
                    <p style="color:#60a5fa; font-size:0.75rem; font-weight:500;">{{ $mainBranch->name }}</p>
                    <p style="color:#94a3b8; font-size:0.875rem; font-weight:300;"><i class="fa-solid fa-location-dot"></i> {{ $mainBranch->address }}</p>
                    <p style="color:#94a3b8; font-size:0.875rem; font-weight:300;"><i class="fa-solid fa-phone"></i> {{ $mainBranch->phone }}</p>
                    @if($mainBranch->email)<p style="color:#94a3b8; font-size:0.875rem; font-weight:300;"><i class="fa-solid fa-envelope"></i> {{ $mainBranch->email }}</p>@endif
                    @if($mainBranch->schedule)<p style="color:#94a3b8; font-size:0.875rem; font-weight:300;"><i class="fa-solid fa-clock"></i> {{ $mainBranch->schedule }}</p>@endif
                </div>
                @if($mainBranch->whatsapp)
                <a href="https://wa.me/{{ $mainBranch->whatsapp }}" target="_blank"
                   style="display:inline-flex; align-items:center; gap:0.5rem; background:rgba(22,163,74,0.2); border:1px solid rgba(22,163,74,0.3); color:#4ade80; font-size:0.75rem; font-weight:500; padding:0.5rem 1rem; border-radius:0.5rem; text-decoration:none; margin-bottom:0.75rem;">
                    WhatsApp
                </a>
                @endif
                <div>
                    <a href="{{ route('conocenos') }}" style="color:#60a5fa; font-size:0.75rem; text-decoration:none;">
                        Ver todas las sucursales →
                    </a>
                </div>
                @endif
            </div>

        </div>
    </div>

    {{-- FRANJA INFERIOR --}}
    <div class="py-6 px-5 md:px-8">
        <div class="max-w-7xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-3">
            <p style="color:#475569; font-size:0.75rem; font-weight:300;">© 2026 Novitecnología Cia. Ltda. — Todos los derechos reservados.</p>
            <div style="display:flex; gap:1.5rem;">
                <a href="{{ route('privacidad') }}" style="color:#475569; font-size:0.75rem; text-decoration:none;">Privacidad</a>
                <a href="{{ route('terminos') }}" style="color:#475569; font-size:0.75rem; text-decoration:none;">Términos</a>
                <a href="{{ route('privacidad') }}" style="color:#475569; font-size:0.75rem; text-decoration:none;">Cookies</a>
            </div>
        </div>
    </div>
</footer>

@stack('scripts')

<script>
    const navbar = document.getElementById('navbar');
    window.addEventListener('scroll', () => {
        if (window.scrollY > 60) {
            navbar.style.background = 'rgba(9,11,24,0.97)';
            navbar.style.backdropFilter = 'blur(12px)';
            navbar.style.borderBottom = '1px solid rgba(255,255,255,0.05)';
        } else {
            navbar.style.background = 'rgba(9,11,24,0.85)';
            navbar.style.backdropFilter = 'blur(12px)';
            navbar.style.borderBottom = '1px solid rgba(255,255,255,0.05)';
        }
    });

    function toggleMenu() {
        const menu = document.getElementById('mobile-menu');
        const bar1 = document.getElementById('bar1');
        const bar2 = document.getElementById('bar2');
        const bar3 = document.getElementById('bar3');
        const isOpen = !menu.classList.contains('hidden');
        if (isOpen) {
            menu.classList.add('hidden');
            bar1.style.transform = 'none';
            bar2.style.opacity = '1';
            bar3.style.transform = 'none';
        } else {
            menu.classList.remove('hidden');
            bar1.style.transform = 'translateY(6px) rotate(45deg)';
            bar2.style.opacity = '0';
            bar3.style.transform = 'translateY(-6px) rotate(-45deg)';
        }
    }
</script>

</body>
</html>
