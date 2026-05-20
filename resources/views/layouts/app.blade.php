<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Novitec')</title>
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
            <a href="{{ route('conocenos') }}" class="hover:text-white transition-colors duration-200 tracking-wide">Conócenos</a>
            <a href="{{ route('servicios') }}" class="hover:text-white transition-colors duration-200 tracking-wide">Servicios</a>
            <li class="relative group">
                <button class="hover:text-white transition-colors duration-200 tracking-wide flex items-center gap-1">
                    Garantías
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </button>
                <div class="absolute top-full left-0 mt-2 w-52 rounded-xl border border-white/10 overflow-hidden opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200" style="background:rgba(9,11,24,.97);backdrop-filter:blur(12px)">
                    <a href="#" class="block px-4 py-3 text-sm text-slate-400 hover:text-white hover:bg-white/5 transition-colors">🔍 Consultar mi garantía</a>
                    <a href="#" class="block px-4 py-3 text-sm text-slate-400 hover:text-white hover:bg-white/5 transition-colors border-t border-white/5">✅ Validar mi garantía</a>
                </div>
            </li>
            <li><a href="/#contacto" class="hover:text-white transition-colors duration-200 tracking-wide">Contacto</a></li>
        </ul>

        {{-- BOTONES DESKTOP --}}
        <div class="flex items-center gap-2">
            @auth
                @if(auth()->user()->is_admin)
                <a href="{{ route('admin.dashboard') }}" class="hidden md:inline-flex text-sm bg-violet-600 hover:bg-violet-500 text-white px-4 py-2 rounded-xl transition-all">
                    Admin
                </a>
                @else
                <div class="relative group hidden md:block">
                    <button class="text-sm border border-white/20 hover:border-blue-400 text-slate-300 hover:text-white px-4 py-2 rounded-xl transition-all flex items-center gap-1">
                        Mi cuenta
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div class="absolute top-full right-0 mt-2 w-44 rounded-xl border border-white/10 overflow-hidden opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200" style="background:rgba(9,11,24,.97);backdrop-filter:blur(12px)">
                        <a href="{{ route('client.orders') }}" class="block px-4 py-3 text-sm text-slate-400 hover:text-white hover:bg-white/5 transition-colors">📦 Mis órdenes</a>
                        <a href="{{ route('profile.edit') }}" class="block px-4 py-3 text-sm text-slate-400 hover:text-white hover:bg-white/5 transition-colors border-t border-white/5">⚙️ Mi perfil</a>
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
        <a href="/#nosotros" onclick="toggleMenu()" class="block text-sm text-slate-300 hover:text-white py-2.5 transition-colors">Conócenos</a>
        <a href="/#servicios" onclick="toggleMenu()" class="block text-sm text-slate-300 hover:text-white py-2.5 transition-colors">Servicios</a>
        <div class="border-t border-white/5 pt-2 mt-1">
            <p class="text-xs text-slate-500 uppercase tracking-widest mb-2 font-medium">Garantías</p>
            <a href="#" onclick="toggleMenu()" class="block text-sm text-slate-300 hover:text-white py-2 pl-2 transition-colors">🔍 Consultar mi garantía</a>
            <a href="#" onclick="toggleMenu()" class="block text-sm text-slate-300 hover:text-white py-2 pl-2 transition-colors">✅ Validar mi garantía</a>
        </div>
        <a href="/#contacto" onclick="toggleMenu()" class="block text-sm text-slate-300 hover:text-white py-2.5 transition-colors">Contacto</a>
        <div class="pt-2 flex flex-col gap-2 border-t border-white/5 mt-1">
            @auth
                @if(auth()->user()->is_admin)
                <a href="{{ route('admin.dashboard') }}" onclick="toggleMenu()" class="block text-sm bg-violet-600 text-white text-center py-2.5 rounded-xl">Admin</a>
                @else
                <a href="{{ route('client.orders') }}" onclick="toggleMenu()" class="block text-sm border border-white/20 text-slate-300 text-center py-2.5 rounded-xl">Mi cuenta</a>
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

{{-- CONTENIDO --}}
<main>
    @yield('content')
</main>

{{-- FOOTER --}}
<footer style="background:linear-gradient(135deg,#020817 0%,#0c1a35 50%,#020817 100%);">
    <div class="border-b border-white/5 py-16 px-6 md:px-8">
        <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-4 gap-12">

            <div class="md:col-span-1">
                <img src="{{ asset('images/novitec_logo.png') }}" alt="Novitec" class="h-9 brightness-0 invert mb-5">
                <p class="text-slate-400 text-sm font-light leading-relaxed mb-6">Soluciones tecnológicas profesionales para personas y empresas en Quito. Más de 10 años de experiencia.</p>
                <div class="flex items-center gap-3">
                    @foreach($socials ?? [] as $social)
                    <a href="{{ $social->url }}" target="_blank"
                       class="w-9 h-9 rounded-xl border border-white/10 hover:border-blue-500/50 hover:bg-blue-500/10 flex items-center justify-center text-slate-400 hover:text-blue-400 transition-all text-xs font-medium">
                        {{ substr($social->platform, 0, 2) }}
                    </a>
                    @endforeach
                </div>
            </div>

            <div>
                <p class="text-white text-xs font-semibold tracking-widest uppercase mb-5">Servicios</p>
                <ul class="space-y-3">
                    @foreach(['Reparación de equipos','Soporte IT remoto','Infraestructura de red','CCTV y videovigilancia'] as $item)
                    <li><a href="/#servicios" class="text-slate-400 hover:text-white text-sm font-light transition-colors">{{ $item }}</a></li>
                    @endforeach
                </ul>
            </div>

            <div>
                <p class="text-white text-xs font-semibold tracking-widest uppercase mb-5">Empresa</p>
                <ul class="space-y-3">
                    @foreach([['Inicio','/'],['Conócenos','/#nosotros'],['Consultar mi garantía','#'],['Validar mi garantía','#'],['Política de privacidad','#']] as $item)
                    <li><a href="{{ $item[1] }}" class="text-slate-400 hover:text-white text-sm font-light transition-colors">{{ $item[0] }}</a></li>
                    @endforeach
                </ul>
            </div>

            <div>
                <p class="text-white text-xs font-semibold tracking-widest uppercase mb-5">Contacto</p>
                @foreach($branches ?? [] as $branch)
                <div class="space-y-3 mb-6">
                    <p class="text-blue-400 text-xs font-medium">{{ $branch->name }}</p>
                    <div class="space-y-2 text-sm text-slate-400 font-light">
                        <p class="flex items-start gap-2"><span>📍</span><span>{{ $branch->address }}</span></p>
                        <p class="flex items-start gap-2"><span>📞</span><span>{{ $branch->phone }}</span></p>
                        @if($branch->email)<p class="flex items-start gap-2"><span>✉️</span><span>{{ $branch->email }}</span></p>@endif
                        @if($branch->schedule)<p class="flex items-start gap-2"><span>🕐</span><span>{{ $branch->schedule }}</span></p>@endif
                    </div>
                    @if($branch->whatsapp)
                    <a href="https://wa.me/{{ $branch->whatsapp }}" target="_blank"
                       class="inline-flex items-center gap-2 bg-green-600/20 hover:bg-green-600/30 border border-green-600/30 text-green-400 text-xs font-medium px-4 py-2 rounded-lg transition-all">
                        WhatsApp
                    </a>
                    @endif
                </div>
                @endforeach
            </div>

        </div>
    </div>
    <div class="py-6 px-6 md:px-8">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row items-center justify-between gap-4">
            <p class="text-slate-600 text-xs font-light">© 2026 Novitecnología Cia. Ltda. — Todos los derechos reservados.</p>
            <div class="flex items-center gap-6 text-xs text-slate-600">
                <a href="#" class="hover:text-slate-400 transition-colors">Privacidad</a>
                <a href="#" class="hover:text-slate-400 transition-colors">Términos</a>
                <a href="#" class="hover:text-slate-400 transition-colors">Cookies</a>
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
