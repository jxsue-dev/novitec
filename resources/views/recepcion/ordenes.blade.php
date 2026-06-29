<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recepción – {{ $branchName }}</title>
    <link rel="icon" type="image/png" href="{{ asset('images/novitec_logo.png') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased min-h-screen" style="background:#f1f5f9;">

{{-- TOPBAR --}}
<header style="background:linear-gradient(135deg,#020817 0%,#0c1a35 100%);border-bottom:1px solid rgba(255,255,255,.06);">
    <div class="max-w-5xl mx-auto px-5 py-4 flex items-center justify-between">
        <div class="flex items-center gap-4">
            <img src="{{ asset('images/novitec_logo.png') }}" alt="Novitec" class="h-7 brightness-0 invert">
            <div class="w-px h-6 bg-white/10"></div>
            <div>
                <p class="text-white text-sm font-semibold">Recepción</p>
                <p class="text-slate-400 text-xs">{{ $branchName }}</p>
            </div>
        </div>
        <div class="flex items-center gap-3">
            <div class="flex items-center gap-2">
                <div class="w-7 h-7 rounded-lg flex items-center justify-center text-white text-xs font-bold"
                     style="background:linear-gradient(135deg,#2563eb,#7c3aed)">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <span class="text-slate-300 text-sm hidden sm:block">{{ $user->name }}</span>
            </div>
            @if($user->is_admin)
            <a href="{{ route('admin.dashboard') }}"
               class="text-xs text-slate-400 hover:text-white border border-white/10 hover:border-white/30 px-3 py-1.5 rounded-lg transition-colors">
                <i class="fa-solid fa-gauge mr-1"></i> Admin
            </a>
            @endif
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-xs text-slate-400 hover:text-red-400 border border-white/10 hover:border-red-400/30 px-3 py-1.5 rounded-lg transition-colors">
                    <i class="fa-solid fa-right-from-bracket"></i>
                </button>
            </form>
        </div>
    </div>
</header>

<div class="max-w-5xl mx-auto px-5 py-8">

    {{-- SELECTOR DE SUCURSAL (solo admin) --}}
    @if($user->is_admin)
    <div class="bg-white border border-slate-200 rounded-2xl p-4 mb-6 flex items-center gap-3 flex-wrap">
        <i class="fa-solid fa-location-dot text-blue-500"></i>
        <span class="text-sm font-medium text-slate-600">Ver sucursal:</span>
        @foreach($branches as $code => $name)
        <a href="{{ route('recepcion.ordenes', ['branch' => $code]) }}"
           class="text-xs px-4 py-2 rounded-xl border font-medium transition-all
                  {{ $branchCode === $code ? 'bg-blue-600 text-white border-blue-600' : 'border-slate-200 text-slate-600 hover:border-blue-400 hover:text-blue-600' }}">
            {{ $name }}
        </a>
        @endforeach
    </div>
    @endif

    {{-- PANEL PRINCIPAL --}}
    <div class="bg-white border border-slate-100 rounded-2xl shadow-sm overflow-hidden">

        {{-- Header --}}
        <div class="px-6 py-5 border-b border-slate-100" style="background:linear-gradient(135deg,#f8faff,#f1f5ff);">
            <div class="flex items-center gap-3 mb-1">
                <div class="w-10 h-10 rounded-xl bg-blue-600 flex items-center justify-center">
                    <i class="fa-solid fa-magnifying-glass text-white"></i>
                </div>
                <div>
                    <h1 class="text-slate-900 font-bold text-lg">Consulta de Órdenes</h1>
                    <p class="text-slate-500 text-sm">{{ $branchName }} · Prefix: <code class="bg-slate-100 px-1.5 py-0.5 rounded text-xs font-mono">{{ $orderPrefix }}XXXXXX</code></p>
                </div>
            </div>
        </div>

        {{-- BUSCADOR --}}
        <div class="px-6 py-5 border-b border-slate-50">
            <form method="GET" action="{{ route('recepcion.ordenes') }}" class="space-y-3">
                @if($user->is_admin)
                <input type="hidden" name="branch" value="{{ $branchCode }}">
                @endif

                {{-- TABS de tipo --}}
                <div class="flex rounded-xl border border-slate-200 overflow-hidden text-sm">
                    @foreach(['nro_orden' => ['fa-hashtag','Nro. Orden'],'identificacion' => ['fa-id-card','CI / RUC'],'serie' => ['fa-barcode','Serie']] as $val => $meta)
                    <button type="submit" name="tipo" value="{{ $val }}"
                            class="flex-1 py-2.5 flex items-center justify-center gap-2 font-medium transition-colors
                                   {{ $tipo === $val ? 'bg-blue-600 text-white' : 'text-slate-500 hover:bg-slate-50' }}">
                        <i class="fa-solid {{ $meta[0] }} text-xs"></i>
                        <span class="hidden sm:inline">{{ $meta[1] }}</span>
                    </button>
                    @endforeach
                </div>

                <div class="flex gap-3">
                    <input type="hidden" name="tipo" value="{{ $tipo }}">
                    <input type="text" name="q" value="{{ $q }}"
                           autofocus
                           placeholder="{{ $tipo === 'nro_orden' ? $orderPrefix.'000123' : ($tipo === 'identificacion' ? '1712345678' : 'SN123456789') }}"
                           class="flex-1 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/10 transition-all font-mono">
                    <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-xl transition-colors flex items-center gap-2">
                        <i class="fa-solid fa-search"></i>
                        <span class="hidden sm:inline">Buscar</span>
                    </button>
                    @if($q)
                    <a href="{{ route('recepcion.ordenes', $user->is_admin ? ['branch' => $branchCode] : []) }}"
                       class="border border-slate-200 hover:border-slate-300 text-slate-500 px-4 py-3 rounded-xl transition-colors text-sm">
                        <i class="fa-solid fa-xmark"></i>
                    </a>
                    @endif
                </div>
            </form>
        </div>

        {{-- RESULTADOS --}}
        <div class="px-6 py-4">

            @if($error)
            <div class="flex items-center gap-3 bg-amber-50 border border-amber-200 text-amber-700 text-sm px-4 py-3 rounded-xl">
                <i class="fa-solid fa-triangle-exclamation flex-shrink-0"></i>
                {{ $error }}
            </div>

            @elseif($results !== null && $results->count() > 0)
            <div class="flex items-center justify-between mb-4">
                <p class="text-slate-500 text-sm">
                    <span class="font-semibold text-slate-900">{{ $results->count() }}</span>
                    {{ $results->count() === 1 ? 'orden encontrada' : 'órdenes encontradas' }}
                </p>
                <span class="text-xs text-slate-400 bg-slate-100 px-3 py-1 rounded-full">{{ $branchName }}</span>
            </div>

            <div class="space-y-3">
                @foreach($results as $o)
                @php
                    $estadoNorm = mb_strtolower(str_replace(['á','é','í','ó','ú'],['a','e','i','o','u'], $o->estado_orden ?? ''), 'UTF-8');
                    $statusColors = [
                        'En Revisión'        => ['bg-amber-100 text-amber-700',  'fa-magnifying-glass'],
                        'En Reparacion'      => ['bg-blue-100 text-blue-700',    'fa-screwdriver-wrench'],
                        'Esperando Repuesto' => ['bg-violet-100 text-violet-700','fa-box'],
                        'Finalizada'         => ['bg-green-100 text-green-700',  'fa-circle-check'],
                        'Entregada'          => ['bg-slate-100 text-slate-600',  'fa-box-open'],
                        'Anulada'            => ['bg-red-100 text-red-700',      'fa-ban'],
                        'Nota de Credito'    => ['bg-pink-100 text-pink-700',    'fa-file-invoice'],
                    ];
                    [$sc, $si] = $statusColors[$o->estado_orden] ?? ['bg-slate-100 text-slate-600', 'fa-file-lines'];
                    $equipo = trim(implode(' ', array_filter([$o->tipo ?? '', $o->marca ?? '', $o->modelo ?? ''])));
                    $cliente = trim(($o->nombres ?? '') . ' ' . ($o->apellidos ?? '')) ?: ($o->cliente ?? '—');
                @endphp
                <div class="border border-slate-100 rounded-2xl overflow-hidden hover:border-blue-200 transition-colors">
                    {{-- Header orden --}}
                    <div class="flex items-center justify-between px-5 py-3.5 bg-slate-50/60 border-b border-slate-100">
                        <div class="flex items-center gap-3">
                            <span class="font-mono text-sm font-bold text-blue-600">{{ $o->nro_orden }}</span>
                            @if($o->serie)
                            <span class="text-xs text-slate-400 font-mono">Serie: {{ $o->serie }}</span>
                            @endif
                        </div>
                        <span class="text-xs font-semibold px-3 py-1 rounded-full flex items-center gap-1.5 {{ $sc }}">
                            <i class="fa-solid {{ $si }} text-xs"></i>
                            {{ $o->estado_orden ?? '—' }}
                        </span>
                    </div>

                    {{-- Datos --}}
                    <div class="px-5 py-4 grid grid-cols-2 sm:grid-cols-4 gap-3">
                        <div>
                            <p class="text-xs text-slate-400 font-medium mb-0.5">Cliente</p>
                            <p class="text-sm text-slate-800 font-medium">{{ $cliente }}</p>
                            @if($o->identificacion)
                            <p class="text-xs text-slate-400 font-mono">{{ $o->identificacion }}</p>
                            @endif
                        </div>
                        <div>
                            <p class="text-xs text-slate-400 font-medium mb-0.5">Equipo</p>
                            <p class="text-sm text-slate-800">{{ $equipo ?: '—' }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-400 font-medium mb-0.5">Técnico</p>
                            <p class="text-sm text-slate-800">{{ $o->tecnico ?? '—' }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-400 font-medium mb-0.5">Ingreso</p>
                            <p class="text-sm text-slate-800">{{ $o->fecha_de_ingreso_fmt ?? '—' }}</p>
                        </div>
                        @if(!empty($o->falla) || !empty($o->observacion))
                        <div class="col-span-2 sm:col-span-4">
                            <p class="text-xs text-slate-400 font-medium mb-0.5">Descripción</p>
                            <p class="text-sm text-slate-600 leading-relaxed">
                                {{ trim(($o->falla ?? '') . (($o->falla && $o->observacion) ? ' — ' : '') . ($o->observacion ?? '')) }}
                            </p>
                        </div>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>

            @elseif($q === '')
            {{-- Estado vacío --}}
            <div class="text-center py-14">
                <div class="w-16 h-16 bg-blue-50 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <i class="fa-solid fa-search text-blue-400 text-2xl"></i>
                </div>
                <p class="text-slate-700 font-medium mb-1">Busca una orden de trabajo</p>
                <p class="text-slate-400 text-sm">Ingresa el número de orden, CI del cliente o serie del equipo</p>
            </div>
            @endif
        </div>
    </div>
</div>

</body>
</html>
