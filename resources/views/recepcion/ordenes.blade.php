<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recepción – {{ $branchName }}</title>
    <link rel="icon" type="image/png" href="{{ asset('images/novitec_logo.png') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { background: #f1f5f9; }
        .field-label { font-size:11px; font-weight:600; text-transform:uppercase; letter-spacing:.05em; color:#94a3b8; margin-bottom:3px; }
        .field-value { font-size:13px; color:#1e293b; font-weight:500; }
        .field-value.mono { font-family: 'Courier New', monospace; font-size:12px; }
    </style>
</head>
<body class="min-h-screen" x-data>

{{-- ═══ NAVBAR ═══════════════════════════════════════════════════════════════ --}}
<nav style="background:linear-gradient(135deg,#020817 0%,#0c1a35 100%);border-bottom:1px solid rgba(255,255,255,.06);position:sticky;top:0;z-index:50;">
    <div class="max-w-6xl mx-auto px-5 py-3.5 flex items-center justify-between gap-4">

        {{-- Logo + sucursal --}}
        <div class="flex items-center gap-4">
            <a href="/" target="_blank">
                <img src="{{ asset('images/novitec_logo.png') }}" alt="Novitec" class="h-7 brightness-0 invert">
            </a>
            <div class="w-px h-6 bg-white/10 hidden sm:block"></div>
            <div class="hidden sm:block">
                <div class="flex items-center gap-2">
                    <span class="w-2 h-2 bg-emerald-400 rounded-full animate-pulse"></span>
                    <p class="text-white text-sm font-semibold">{{ $branchName }}</p>
                </div>
                <p class="text-slate-500 text-xs">Panel de Recepción</p>
            </div>
        </div>

        {{-- Nav links (solo admin ve selector de sucursal) --}}
        @if($user->is_admin)
        <div class="flex items-center gap-1 bg-white/5 rounded-xl p-1">
            @foreach(\App\Models\User::BRANCHES as $code => $name)
            <a href="{{ route('recepcion.ordenes', ['branch' => $code]) }}"
               class="text-xs px-3 py-1.5 rounded-lg font-medium transition-all {{ $branchCode === $code ? 'bg-blue-600 text-white' : 'text-slate-400 hover:text-white hover:bg-white/10' }}">
                {{ $code }}
            </a>
            @endforeach
        </div>
        @endif

        {{-- Usuario + acciones --}}
        <div class="flex items-center gap-2">
            <div class="flex items-center gap-2.5 border border-white/10 rounded-xl px-3 py-1.5">
                <div class="w-7 h-7 rounded-lg flex items-center justify-center text-white text-xs font-bold flex-shrink-0"
                     style="background:linear-gradient(135deg,#2563eb,#7c3aed)">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <div class="hidden md:block min-w-0">
                    <p class="text-white text-xs font-medium truncate max-w-[120px]">{{ $user->name }}</p>
                    <p class="text-slate-500 text-xs">{{ $user->isReceptionist() ? 'Recepcionista' : 'Admin' }}</p>
                </div>
            </div>

            @if($user->is_admin)
            <a href="{{ route('admin.dashboard') }}"
               class="text-xs text-slate-400 hover:text-white border border-white/10 hover:border-white/30 px-3 py-2 rounded-xl transition-colors hidden sm:flex items-center gap-1.5">
                <i class="fa-solid fa-gauge text-xs"></i> Admin
            </a>
            @endif

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                        class="text-xs text-slate-400 hover:text-red-400 border border-white/10 hover:border-red-400/30 px-3 py-2 rounded-xl transition-colors flex items-center gap-1.5">
                    <i class="fa-solid fa-right-from-bracket text-xs"></i>
                    <span class="hidden sm:inline">Salir</span>
                </button>
            </form>
        </div>
    </div>
</nav>

{{-- ═══ CONTENIDO ══════════════════════════════════════════════════════════ --}}
<div class="max-w-6xl mx-auto px-4 py-6">

    {{-- BUSCADOR --}}
    <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden mb-6">

        <div class="px-6 py-5 border-b border-slate-100" style="background:linear-gradient(135deg,#f8faff,#eef3ff);">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center flex-shrink-0">
                    <i class="fa-solid fa-magnifying-glass text-white text-sm"></i>
                </div>
                <div>
                    <h1 class="text-slate-900 font-bold">Consulta de Órdenes</h1>
                    <p class="text-slate-500 text-sm">
                        {{ $branchName }}
                        <span class="text-slate-300 mx-1">·</span>
                        Prefijo <code class="bg-slate-100 text-slate-600 px-1.5 py-0.5 rounded text-xs font-mono">{{ $orderPrefix }}XXXXXX</code>
                    </p>
                </div>
            </div>
        </div>

        <div class="px-6 py-5">
            <form method="GET" action="{{ route('recepcion.ordenes') }}" class="space-y-3" id="searchForm">
                @if($user->is_admin)
                <input type="hidden" name="branch" value="{{ $branchCode }}">
                @endif

                {{-- Tipo de búsqueda --}}
                <div class="flex rounded-xl border border-slate-200 overflow-hidden">
                    @foreach([
                        'nro_orden'      => ['fa-hashtag',  'Nro. Orden',  $orderPrefix.'000123'],
                        'identificacion' => ['fa-id-card',  'CI / RUC',    '1712345678'],
                        'serie'          => ['fa-barcode',  'Serie equipo','SN123456789'],
                    ] as $val => [$icon, $label, $placeholder])
                    <button type="button"
                            onclick="setTipo('{{ $val }}','{{ $placeholder }}')"
                            data-tipo="{{ $val }}"
                            class="tipo-btn flex-1 py-3 flex items-center justify-center gap-2 text-sm font-medium transition-colors border-r border-slate-200 last:border-r-0
                                   {{ $tipo === $val ? 'bg-blue-600 text-white' : 'text-slate-500 hover:bg-slate-50' }}">
                        <i class="fa-solid {{ $icon }} text-xs"></i>
                        <span class="hidden sm:inline">{{ $label }}</span>
                    </button>
                    @endforeach
                </div>

                <input type="hidden" name="tipo" id="tipoHidden" value="{{ $tipo }}">

                <div class="flex gap-3">
                    <input type="text" name="q" id="searchInput"
                           value="{{ $q }}"
                           autofocus
                           placeholder="{{ $tipo === 'nro_orden' ? $orderPrefix.'000123' : ($tipo === 'identificacion' ? '1712345678' : 'SN123456789') }}"
                           class="flex-1 border border-slate-200 rounded-xl px-4 py-3 text-sm font-mono focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/10 transition-all">
                    <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-xl transition-colors flex items-center gap-2 flex-shrink-0">
                        <i class="fa-solid fa-search"></i>
                        <span class="hidden sm:inline">Buscar</span>
                    </button>
                    @if($q)
                    <a href="{{ route('recepcion.ordenes', array_filter(['branch' => $user->is_admin ? $branchCode : null])) }}"
                       class="border border-slate-200 hover:border-slate-300 text-slate-500 hover:text-slate-700 px-4 py-3 rounded-xl transition-colors flex items-center">
                        <i class="fa-solid fa-xmark"></i>
                    </a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    {{-- RESULTADOS --}}
    @if($error)
    <div class="flex items-center gap-3 bg-amber-50 border border-amber-200 text-amber-700 text-sm px-5 py-4 rounded-2xl">
        <i class="fa-solid fa-triangle-exclamation text-lg flex-shrink-0"></i>
        <div>
            <p class="font-semibold">Sin resultados</p>
            <p class="text-amber-600 text-xs mt-0.5">{{ $error }}</p>
        </div>
    </div>

    @elseif($results !== null && $results->count() > 0)
    <div class="flex items-center justify-between mb-4">
        <p class="text-slate-600 text-sm">
            <span class="font-bold text-slate-900">{{ $results->count() }}</span>
            {{ $results->count() === 1 ? 'orden encontrada' : 'órdenes encontradas' }}
            en <span class="font-medium">{{ $branchName }}</span>
        </p>
    </div>

    <div class="space-y-4">
        @foreach($results as $o)
        @php
            $statusMap = [
                'En Revisión'        => ['bg-amber-100 text-amber-800 border-amber-200',  'fa-magnifying-glass', '#fef3c7'],
                'En Reparacion'      => ['bg-blue-100 text-blue-800 border-blue-200',     'fa-screwdriver-wrench','#dbeafe'],
                'Esperando Repuesto' => ['bg-violet-100 text-violet-800 border-violet-200','fa-box',             '#ede9fe'],
                'Finalizada'         => ['bg-green-100 text-green-800 border-green-200',  'fa-circle-check',    '#dcfce7'],
                'Entregada'          => ['bg-slate-100 text-slate-600 border-slate-200',  'fa-box-open',        '#f1f5f9'],
                'Anulada'            => ['bg-red-100 text-red-800 border-red-200',        'fa-ban',             '#fee2e2'],
                'Nota de Credito'    => ['bg-pink-100 text-pink-800 border-pink-200',     'fa-file-invoice',    '#fce7f3'],
            ];
            [$sc, $si, $sbg] = $statusMap[$o->estado_orden ?? ''] ?? ['bg-slate-100 text-slate-600 border-slate-200','fa-file-lines','#f1f5f9'];
            $equipo  = trim(implode(' ', array_filter([$o->tipo ?? '', $o->marca ?? '', $o->modelo ?? ''])));
            $cliente = trim(($o->nombres ?? '') . ' ' . ($o->apellidos ?? '')) ?: ($o->cliente ?? '—');
            $falla   = trim(($o->falla ?? '') . (($o->falla && $o->observacion) ? ' — ' : '') . ($o->observacion ?? ''));
        @endphp

        <div class="bg-white border border-slate-100 rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition-shadow">

            {{-- ── HEADER ORDEN ─────────────────────────────────────── --}}
            <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100"
                 style="background:{{ $sbg }}20;">
                <div class="flex items-center gap-3 flex-wrap">
                    <span class="text-lg font-bold font-mono text-blue-700">{{ $o->nro_orden ?? '—' }}</span>
                    @if(!empty($o->serie))
                    <span class="text-xs bg-white/80 border border-slate-200 text-slate-500 px-2.5 py-1 rounded-full font-mono">
                        <i class="fa-solid fa-barcode mr-1"></i>{{ $o->serie }}
                    </span>
                    @endif
                    @if(!empty($o->estado_garantia))
                    <span class="text-xs bg-white/80 border border-slate-200 text-slate-600 px-2.5 py-1 rounded-full">
                        Garantía: <strong>{{ $o->estado_garantia }}</strong>
                    </span>
                    @endif
                </div>
                <span class="text-xs font-bold px-3 py-1.5 rounded-full border flex items-center gap-1.5 {{ $sc }}">
                    <i class="fa-solid {{ $si }}"></i>
                    {{ $o->estado_orden ?? '—' }}
                </span>
            </div>

            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                    {{-- ── CLIENTE ─────────────────────────────────────────── --}}
                    <div class="space-y-3">
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest flex items-center gap-1.5">
                            <i class="fa-solid fa-user"></i> Cliente
                        </p>
                        <div class="bg-slate-50 rounded-xl p-4 space-y-2.5">
                            <div>
                                <p class="field-label">Nombre completo</p>
                                <p class="field-value text-base font-semibold">{{ $cliente }}</p>
                            </div>
                            @if(!empty($o->identificacion))
                            <div>
                                <p class="field-label">CI / RUC</p>
                                <p class="field-value mono">{{ $o->identificacion }}</p>
                            </div>
                            @endif
                            @if(!empty($o->telefono))
                            <div>
                                <p class="field-label">Teléfono</p>
                                <p class="field-value">
                                    <a href="tel:{{ $o->telefono }}" class="text-blue-600 hover:text-blue-800">
                                        {{ $o->telefono }}
                                    </a>
                                </p>
                            </div>
                            @endif
                            @if(!empty($o->correo))
                            <div>
                                <p class="field-label">Email</p>
                                <p class="field-value text-sm">{{ $o->correo }}</p>
                            </div>
                            @endif
                            @if(!empty($o->ciudad_procedencia))
                            <div>
                                <p class="field-label">Ciudad</p>
                                <p class="field-value">{{ $o->ciudad_procedencia }}</p>
                            </div>
                            @endif
                        </div>
                    </div>

                    {{-- ── EQUIPO ──────────────────────────────────────────── --}}
                    <div class="space-y-3">
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest flex items-center gap-1.5">
                            <i class="fa-solid fa-laptop"></i> Equipo
                        </p>
                        <div class="bg-slate-50 rounded-xl p-4 space-y-2.5">
                            <div>
                                <p class="field-label">Descripción</p>
                                <p class="field-value font-semibold">{{ $equipo ?: '—' }}</p>
                            </div>
                            @if(!empty($o->codigo_producto))
                            <div>
                                <p class="field-label">Código producto</p>
                                <p class="field-value mono">{{ $o->codigo_producto }}</p>
                            </div>
                            @endif
                            @if(!empty($o->serie))
                            <div>
                                <p class="field-label">Serie / IMEI</p>
                                <p class="field-value mono">{{ $o->serie }}</p>
                            </div>
                            @endif
                            @if(!empty($o->nro_factura))
                            <div>
                                <p class="field-label">Nro. Factura</p>
                                <p class="field-value mono">{{ $o->nro_factura }}</p>
                            </div>
                            @endif
                            @if(!empty($o->fecha_facturacion))
                            <div>
                                <p class="field-label">Fecha factura</p>
                                <p class="field-value">{{ $o->fecha_facturacion }}</p>
                            </div>
                            @endif
                        </div>
                    </div>

                    {{-- ── SERVICIO ─────────────────────────────────────────── --}}
                    <div class="space-y-3">
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest flex items-center gap-1.5">
                            <i class="fa-solid fa-wrench"></i> Servicio
                        </p>
                        <div class="bg-slate-50 rounded-xl p-4 space-y-2.5">
                            <div>
                                <p class="field-label">Técnico</p>
                                <p class="field-value">{{ $o->tecnico ?? '—' }}</p>
                            </div>
                            <div>
                                <p class="field-label">Sucursal</p>
                                <p class="field-value">{{ $o->sucursal ?? $branchName }}</p>
                            </div>
                            @if(!empty($o->fecha_de_ingreso_fmt))
                            <div>
                                <p class="field-label">Fecha de ingreso</p>
                                <p class="field-value">{{ $o->fecha_de_ingreso_fmt }}</p>
                            </div>
                            @endif
                            @if(!empty($o->motivo_ingreso))
                            <div>
                                <p class="field-label">Motivo de ingreso</p>
                                <p class="field-value">{{ $o->motivo_ingreso }}</p>
                            </div>
                            @endif
                            @if(!empty($o->precio))
                            <div>
                                <p class="field-label">Precio</p>
                                <p class="field-value font-bold text-green-700">${{ number_format($o->precio, 2) }}</p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- ── FALLA / DESCRIPCIÓN ───────────────────────────────── --}}
                @if($falla)
                <div class="mt-4 border-t border-slate-100 pt-4">
                    <p class="field-label mb-1.5 flex items-center gap-1.5">
                        <i class="fa-solid fa-comment-dots"></i> Descripción del problema
                    </p>
                    <p class="text-sm text-slate-600 leading-relaxed bg-slate-50 rounded-xl px-4 py-3">
                        {{ $falla }}
                    </p>
                </div>
                @endif
            </div>
        </div>
        @endforeach
    </div>

    @elseif($q === '')
    {{-- Estado vacío --}}
    <div class="bg-white border border-slate-100 rounded-2xl p-16 text-center shadow-sm">
        <div class="w-20 h-20 bg-blue-50 rounded-2xl flex items-center justify-center mx-auto mb-5">
            <i class="fa-solid fa-search text-blue-400 text-3xl"></i>
        </div>
        <h2 class="text-slate-700 font-semibold text-lg mb-2">Busca una orden</h2>
        <p class="text-slate-400 text-sm max-w-sm mx-auto">
            Ingresa el número de orden, cédula/RUC del cliente o la serie del equipo para ver la información completa.
        </p>
        <div class="mt-6 flex items-center justify-center gap-6 text-xs text-slate-300">
            <span><i class="fa-solid fa-hashtag mr-1"></i>{{ $orderPrefix }}XXXXXX</span>
            <span><i class="fa-solid fa-id-card mr-1"></i>Cédula / RUC</span>
            <span><i class="fa-solid fa-barcode mr-1"></i>Serie del equipo</span>
        </div>
    </div>
    @endif

</div>

<script>
function setTipo(tipo, placeholder) {
    document.getElementById('tipoHidden').value = tipo;
    document.getElementById('searchInput').placeholder = placeholder;
    document.getElementById('searchInput').focus();
    document.querySelectorAll('.tipo-btn').forEach(btn => {
        const isActive = btn.dataset.tipo === tipo;
        btn.classList.toggle('bg-blue-600', isActive);
        btn.classList.toggle('text-white', isActive);
        btn.classList.toggle('text-slate-500', !isActive);
    });
}
// Enter submits form
document.getElementById('searchInput')?.addEventListener('keydown', function(e) {
    if (e.key === 'Enter') document.getElementById('searchForm').submit();
});
</script>

</body>
</html>
