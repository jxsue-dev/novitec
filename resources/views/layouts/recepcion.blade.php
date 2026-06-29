<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Recepción') — Novitec</title>
    <link rel="icon" type="image/png" href="{{ asset('images/novitec_logo.png') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased" style="background:#f8fafc;">

<div class="flex min-h-screen">

    {{-- ═══ SIDEBAR ══════════════════════════════════════════════════════ --}}
    <aside class="fixed top-0 left-0 h-full w-64 z-40 flex flex-col transition-transform duration-300"
           style="background:linear-gradient(180deg,#020817 0%,#0c1a35 100%);">

        {{-- LOGO + SUCURSAL --}}
        <div class="px-6 py-5 border-b border-white/5">
            <a href="/" target="_blank">
                <img src="{{ asset('images/novitec_logo.png') }}" alt="Novitec" class="h-8 brightness-0 invert mb-3">
            </a>
            <div class="flex items-center gap-2">
                <span class="w-2 h-2 bg-emerald-400 rounded-full animate-pulse flex-shrink-0"></span>
                <div class="min-w-0">
                    <p class="text-white text-xs font-semibold truncate">{{ auth()->user()->branch_name }}</p>
                    <p class="text-slate-500 text-xs">Panel de Recepción</p>
                </div>
            </div>
        </div>

        {{-- NAV --}}
        <nav class="flex-1 px-4 py-5 space-y-1 overflow-y-auto">

            <p class="text-slate-600 text-xs font-semibold tracking-widest uppercase px-3 mb-3">Gestión</p>

            <a href="{{ route('recepcion.ordenes') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition-all
               {{ request()->routeIs('recepcion.ordenes') ? 'bg-blue-600 text-white' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">
                <i class="fa-solid fa-magnifying-glass w-4 text-center"></i>
                Consulta de Órdenes
            </a>

            {{-- Admin también puede ir al panel admin --}}
            @if(auth()->user()->is_admin)
            <a href="{{ route('recepcion.ordenes', ['branch' => 'GYE']) }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition-all
               {{ request()->input('branch') === 'GYE' ? 'bg-blue-600/30 text-blue-300' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">
                <i class="fa-solid fa-location-dot w-4 text-center"></i>
                Guayaquil
            </a>
            <a href="{{ route('recepcion.ordenes', ['branch' => 'MTA']) }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition-all
               {{ request()->input('branch') === 'MTA' ? 'bg-blue-600/30 text-blue-300' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">
                <i class="fa-solid fa-location-dot w-4 text-center"></i>
                Manta
            </a>

            <div class="border-t border-white/5 my-3"></div>
            <p class="text-slate-600 text-xs font-semibold tracking-widest uppercase px-3 mb-3">Administración</p>

            <a href="{{ route('admin.dashboard') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition-all text-slate-400 hover:text-white hover:bg-white/5">
                <i class="fa-solid fa-gauge w-4 text-center"></i>
                Panel Admin
            </a>
            @endif

        </nav>

        {{-- USUARIO --}}
        <div class="px-4 py-4 border-t border-white/5">
            <a href="{{ route('recepcion.cuenta') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all {{ request()->routeIs('recepcion.cuenta') ? 'bg-white/10' : 'hover:bg-white/5' }}">
                <div class="w-8 h-8 rounded-xl flex items-center justify-center text-white text-xs font-bold flex-shrink-0"
                     style="background:linear-gradient(135deg,#2563eb,#7c3aed)">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-white text-xs font-medium truncate">{{ auth()->user()->name }}</p>
                    <p class="text-slate-500 text-xs font-light">Mi cuenta</p>
                </div>
                <i class="fa-solid fa-chevron-right text-slate-600 text-xs"></i>
            </a>
            <form method="POST" action="{{ route('logout') }}" class="mt-1">
                @csrf
                <button type="submit" class="w-full flex items-center gap-3 px-3 py-2 rounded-xl text-sm text-slate-500 hover:text-red-400 hover:bg-white/5 transition-all">
                    <i class="fa-solid fa-right-from-bracket w-4 text-center"></i>
                    Cerrar sesión
                </button>
            </form>
        </div>
    </aside>

    {{-- ═══ CONTENIDO PRINCIPAL ═══════════════════════════════════════════ --}}
    <div class="flex-1 ml-64">

        {{-- TOPBAR --}}
        <header class="sticky top-0 z-30 bg-white border-b border-slate-100 px-8 py-4 flex items-center justify-between">
            <div>
                <h1 class="text-slate-900 font-semibold text-base">@yield('page-title', 'Recepción')</h1>
                <p class="text-slate-400 text-xs font-light">@yield('page-subtitle', auth()->user()->branch_name)</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="/" target="_blank"
                   class="text-xs text-slate-400 hover:text-slate-600 border border-slate-200 px-3 py-1.5 rounded-lg transition-colors">
                    Ver sitio →
                </a>
            </div>
        </header>

        {{-- CONTENIDO --}}
        <main class="p-8">
            @if(session('success'))
            <div class="mb-6 bg-green-50 border border-green-200 text-green-700 text-sm px-4 py-3 rounded-xl">
                {{ session('success') }}
            </div>
            @endif
            @if(session('error'))
            <div class="mb-6 bg-red-50 border border-red-200 text-red-700 text-sm px-4 py-3 rounded-xl">
                {{ session('error') }}
            </div>
            @endif
            @yield('content')
        </main>
    </div>
</div>

@stack('scripts')
</body>
</html>
