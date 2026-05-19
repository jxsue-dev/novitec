<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Novitec')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased">

{{-- NAVBAR --}}
<nav id="navbar" class="fixed top-0 w-full z-50 transition-all duration-500">
    <div class="max-w-7xl mx-auto px-6 md:px-8 py-4 md:py-5 flex items-center justify-between">

        <a href="/" class="flex items-center gap-3">
            <img src="{{ asset('images/novitec_logo.png') }}" alt="Novitec" class="h-8 md:h-9 brightness-0 invert">
        </a>

        {{-- LINKS DESKTOP --}}
        <ul class="hidden md:flex items-center gap-10 text-sm text-slate-400">
            <li><a href="/" class="hover:text-white transition-colors duration-200 tracking-wide">Inicio</a></li>
            <li><a href="#nosotros" class="hover:text-white transition-colors duration-200 tracking-wide">Conócenos</a></li>
            <li><a href="#servicios" class="hover:text-white transition-colors duration-200 tracking-wide">Servicios</a></li>
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
            <li><a href="#contacto" class="hover:text-white transition-colors duration-200 tracking-wide">Contacto</a></li>
        </ul>

        <div class="flex items-center gap-3">
            <div class="hidden md:flex items-center gap-2">
                <a href="/login" class="text-sm text-slate-300 hover:text-white px-4 py-2 rounded-xl transition-all duration-200">
                    Iniciar sesión
                </a>
                <a href="/register" class="text-sm bg-blue-600 hover:bg-blue-500 text-white px-5 py-2 rounded-xl transition-all duration-200 hover:shadow-lg hover:shadow-blue-600/25">
                    Registrarse
                </a>
            </div>
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
        <a href="#nosotros" onclick="toggleMenu()" class="block text-sm text-slate-300 hover:text-white py-2.5 transition-colors">Conócenos</a>
        <a href="#servicios" onclick="toggleMenu()" class="block text-sm text-slate-300 hover:text-white py-2.5 transition-colors">Servicios</a>
        <div class="border-t border-white/5 pt-2 mt-1">
            <p class="text-xs text-slate-500 uppercase tracking-widest mb-2 font-medium">Garantías</p>
            <a href="#" onclick="toggleMenu()" class="block text-sm text-slate-300 hover:text-white py-2 pl-2 transition-colors">🔍 Consultar mi garantía</a>
            <a href="#" onclick="toggleMenu()" class="block text-sm text-slate-300 hover:text-white py-2 pl-2 transition-colors">✅ Validar mi garantía</a>
        </div>
        <div class="pt-2">
            <a href="#contacto" onclick="toggleMenu()" class="block text-sm bg-blue-600 hover:bg-blue-500 text-white text-center py-2.5 rounded-xl transition-colors">Contáctenos</a>
        </div>
    </div>
</nav>

{{-- CONTENIDO --}}
<main>
    @yield('content')
</main>

{{-- FOOTER --}}
<footer style="background:linear-gradient(135deg,#020817 0%,#0c1a35 50%,#020817 100%);">

    {{-- FRANJA SUPERIOR --}}
    <div class="border-b border-white/5 py-16 px-6 md:px-8">
        <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-4 gap-12">

            {{-- MARCA --}}
            <div class="md:col-span-1">
                <img src="{{ asset('images/novitec_logo.png') }}" alt="Novitec" class="h-9 brightness-0 invert mb-5">
                <p class="text-slate-400 text-sm font-light leading-relaxed mb-6">
                    Soluciones tecnológicas profesionales para personas y empresas en Quito. Más de 10 años de experiencia.
                </p>
                <div class="flex items-center gap-3">
                    @foreach($socials as $social)
                    <a href="{{ $social->url }}" target="_blank"
                       class="w-9 h-9 rounded-xl border border-white/10 hover:border-blue-500/50 hover:bg-blue-500/10 flex items-center justify-center text-slate-400 hover:text-blue-400 transition-all text-xs font-medium">
                        {{ substr($social->platform, 0, 2) }}
                    </a>
                    @endforeach
                </div>
            </div>

            {{-- SERVICIOS --}}
            <div>
                <p class="text-white text-xs font-semibold tracking-widest uppercase mb-5">Servicios</p>
                <ul class="space-y-3">
                    @foreach(['Reparación de equipos','Soporte IT remoto','Infraestructura de red','CCTV y videovigilancia'] as $item)
                    <li><a href="#servicios" class="text-slate-400 hover:text-white text-sm font-light transition-colors">{{ $item }}</a></li>
                    @endforeach
                </ul>
            </div>

            {{-- EMPRESA --}}
            <div>
                <p class="text-white text-xs font-semibold tracking-widest uppercase mb-5">Empresa</p>
                <ul class="space-y-3">
                    @foreach([
                        ['Inicio', '/'],
                        ['Conócenos', '#nosotros'],
                        ['Consultar mi garantía', '#'],
                        ['Validar mi garantía', '#'],
                        ['Política de privacidad', '#'],
                    ] as $item)
                    <li><a href="{{ $item[1] }}" class="text-slate-400 hover:text-white text-sm font-light transition-colors">{{ $item[0] }}</a></li>
                    @endforeach
                </ul>
            </div>

            {{-- CONTACTO --}}
            <div>
                <p class="text-white text-xs font-semibold tracking-widest uppercase mb-5">Contacto</p>
                @foreach($branches as $branch)
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
                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                        WhatsApp
                    </a>
                    @endif
                </div>
                @endforeach
            </div>

        </div>
    </div>

    {{-- FRANJA INFERIOR --}}
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
