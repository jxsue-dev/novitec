<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') — Novitec</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased" style="background:#f8fafc;">

<div class="flex min-h-screen">

    {{-- SIDEBAR --}}
    <aside id="sidebar" class="fixed top-0 left-0 h-full w-64 z-40 flex flex-col transition-transform duration-300"
           style="background:linear-gradient(180deg,#020817 0%,#0c1a35 100%);">

        {{-- LOGO --}}
        <div class="px-6 py-6 border-b border-white/5">
            <a href="/" target="_blank">
                <img src="{{ asset('images/novitec_logo.png') }}" alt="Novitec" class="h-8 brightness-0 invert">
            </a>
            <p class="text-slate-500 text-xs mt-1 font-light">Panel de administración</p>
        </div>

        {{-- NAV --}}
        <nav class="flex-1 px-4 py-6 space-y-1 overflow-y-auto">

            <p class="text-slate-600 text-xs font-semibold tracking-widest uppercase px-3 mb-3">General</p>

            <a href="{{ route('admin.dashboard') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition-all
               {{ request()->routeIs('admin.dashboard') ? 'bg-blue-600 text-white' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                Dashboard
            </a>

            <a href="{{ route('admin.users') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition-all
               {{ request()->routeIs('admin.users') ? 'bg-blue-600 text-white' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                Usuarios
            </a>

            <a href="{{ route('admin.orders') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition-all
               {{ request()->routeIs('admin.orders*') ? 'bg-blue-600 text-white' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                Órdenes
            </a>

            <p class="text-slate-600 text-xs font-semibold tracking-widest uppercase px-3 mb-3 mt-6">Configuración</p>

            <a href="{{ route('admin.branches') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition-all
               {{ request()->routeIs('admin.branches') ? 'bg-blue-600 text-white' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                Sucursales
            </a>

            <a href="{{ route('admin.services') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition-all
               {{ request()->routeIs('admin.services') ? 'bg-blue-600 text-white' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                Servicios
            </a>

            <a href="{{ route('admin.reviews') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition-all
               {{ request()->routeIs('admin.reviews') ? 'bg-blue-600 text-white' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
                Reseñas
            </a>

            <a href="{{ route('admin.socials') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition-all
               {{ request()->routeIs('admin.socials') ? 'bg-blue-600 text-white' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
                Redes sociales
            </a>

            <a href="{{ route('admin.settings') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition-all
               {{ request()->routeIs('admin.settings') ? 'bg-blue-600 text-white' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                Configuración
            </a>
        </nav>

        {{-- USUARIO --}}
        <div class="px-4 py-4 border-t border-white/5">
            <div class="flex items-center gap-3 px-3 py-2">
                <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center text-white text-xs font-bold flex-shrink-0">
                    {{ substr(auth()->user()->name ?? 'A', 0, 1) }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-white text-xs font-medium truncate">{{ auth()->user()->name ?? 'Admin' }}</p>
                    <p class="text-slate-500 text-xs font-light truncate">{{ auth()->user()->email ?? '' }}</p>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}" class="mt-2">
                @csrf
                <button type="submit" class="w-full flex items-center gap-3 px-3 py-2 rounded-xl text-sm text-slate-400 hover:text-white hover:bg-white/5 transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    Cerrar sesión
                </button>
            </form>
        </div>
    </aside>

    {{-- CONTENIDO PRINCIPAL --}}
    <div class="flex-1 ml-64">

        {{-- TOPBAR --}}
        <header class="sticky top-0 z-30 bg-white border-b border-slate-100 px-8 py-4 flex items-center justify-between">
            <div>
                <h1 class="text-slate-900 font-semibold text-base">@yield('page-title', 'Dashboard')</h1>
                <p class="text-slate-400 text-xs font-light">@yield('page-subtitle', 'Panel de administración')</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="/" target="_blank" class="text-xs text-slate-400 hover:text-slate-600 border border-slate-200 px-3 py-1.5 rounded-lg transition-colors">
                    Ver sitio →
                </a>
            </div>
        </header>

        {{-- PÁGINA --}}
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
