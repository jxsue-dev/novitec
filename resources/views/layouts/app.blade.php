<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Novitec – Servicio Técnico & Soporte IT')</title>

    {{-- SEO --}}
    <meta name="description" content="Servicios que impulsan tu negocio. Reparamos computadores, celulares e impresoras. Soporte IT remoto y presencial, redes y CCTV para personas y empresas.">

    {{-- FAVICON --}}
    <link rel="icon" type="image/png" href="{{ asset('images/novitec_logo.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('images/novitec_logo.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/novitec_logo.png') }}">

    {{-- OPEN GRAPH --}}
    <meta property="og:title" content="@yield('title', 'Novitec – Servicio Técnico & Soporte IT')">
    <meta property="og:description" content="Servicios que impulsan tu negocio. Reparamos computadores, celulares e impresoras. Soporte IT remoto y presencial, redes y CCTV.">
    <meta property="og:image" content="{{ asset('images/novitec_og.png') }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="website">

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
                <a href="{{ route('chat.index') }}"
                   class="hidden md:inline-flex items-center gap-1.5 text-sm bg-gradient-to-r from-blue-600 to-violet-600 hover:from-blue-500 hover:to-violet-500 text-white px-4 py-2 rounded-xl transition-all shadow-lg shadow-blue-600/20 hover:shadow-blue-500/30 hover:-translate-y-0.5">
                    <i class="fa-solid fa-robot text-xs"></i> Chat IA
                </a>
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
                <a href="{{ route('chat.index') }}" onclick="toggleMenu()"
                   class="block text-sm bg-gradient-to-r from-blue-600 to-violet-600 text-white text-center py-2.5 rounded-xl">
                    <i class="fa-solid fa-robot"></i> Chat IA
                </a>
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

{{-- BOTÓN FLOTANTE CHAT IA --}}
<style>
@keyframes chat-pulse {
    0%   { box-shadow: 0 0 0 0 rgba(99,102,241,.65), 0 8px 32px rgba(99,102,241,.4); }
    70%  { box-shadow: 0 0 0 16px rgba(99,102,241,0), 0 8px 32px rgba(99,102,241,.4); }
    100% { box-shadow: 0 0 0 0 rgba(99,102,241,0),  0 8px 32px rgba(99,102,241,.4); }
}
#chat-fab { animation: chat-pulse 2.2s ease-in-out infinite; }
#chat-fab:hover { animation: none; transform: scale(1.1) translateY(-3px); box-shadow: 0 12px 40px rgba(99,102,241,.55) !important; }
#chat-fab .chat-tip { opacity:0; transition: opacity .2s ease; pointer-events:none; }
#chat-fab:hover .chat-tip { opacity:1; }
</style>
<a id="chat-fab"
   href="{{ auth()->check() ? route('chat.index') : route('login') }}"
   title="Chat IA – Asistente Novitec"
   style="position:fixed;bottom:24px;right:24px;z-index:9999;width:62px;height:62px;border-radius:50%;background:linear-gradient(135deg,#4f46e5,#7c3aed);display:flex;align-items:center;justify-content:center;text-decoration:none;transition:transform .2s ease,box-shadow .2s ease;cursor:pointer;">
    <i class="fa-solid fa-robot" style="color:#fff;font-size:1.5rem;"></i>
    <span class="chat-tip"
          style="position:absolute;bottom:calc(100% + 10px);right:0;background:#0f172a;color:#fff;font-size:12px;font-weight:500;padding:6px 14px;border-radius:10px;white-space:nowrap;border:1px solid rgba(255,255,255,.1);box-shadow:0 4px 16px rgba(0,0,0,.3);">
        🤖 Asistente IA
    </span>
</a>

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
