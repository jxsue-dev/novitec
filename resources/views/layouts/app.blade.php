<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Novitec')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white text-neutral-800 antialiased">

    {{-- NAVBAR --}}
    <nav class="fixed top-0 w-full z-50 bg-white border-b border-neutral-100">
        <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
            <a href="/" class="flex items-center gap-2">
                <img src="{{ asset('images/novitec_logo.png') }}" alt="Novitec" class="h-8">
            </a>
            <ul class="hidden md:flex items-center gap-8 text-sm text-neutral-500">
                <li><a href="#servicios" class="hover:text-neutral-900 transition-colors">Servicios</a></li>
                <li><a href="#nosotros" class="hover:text-neutral-900 transition-colors">Nosotros</a></li>
                <li><a href="#contacto" class="hover:text-neutral-900 transition-colors">Contacto</a></li>
            </ul>
            <a href="#contacto" class="text-sm border border-neutral-300 px-5 py-2 rounded hover:bg-neutral-50 transition-colors">
                Contáctenos
            </a>
        </div>
    </nav>

    {{-- CONTENIDO --}}
    <main>
        @yield('content')
    </main>

    {{-- FOOTER --}}
    <footer class="border-t border-neutral-100 py-8 px-6">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row items-center justify-between gap-4 text-sm text-neutral-400">
            <img src="{{ asset('images/novitec_logo.png') }}" alt="Novitec" class="h-6 opacity-60">
            <p>©2026 Novitecnología Cia. Ltda. - Todos los derechos reservados.</p>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
