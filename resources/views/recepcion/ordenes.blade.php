@extends('layouts.recepcion')

@section('title', 'Órdenes')
@section('page-title', 'Consulta de Órdenes')
@section('page-subtitle', $branchName . ' · Prefijo ' . $orderPrefix . 'XXXXXX')

@section('content')

{{-- BUSCADOR --}}
<div class="bg-white border border-slate-100 rounded-2xl shadow-sm overflow-hidden mb-6">
    <div class="px-6 py-5">
        <form method="GET" action="{{ route('recepcion.ordenes') }}" class="space-y-3" id="searchForm">
            @if(auth()->user()->is_admin)
            <input type="hidden" name="branch" value="{{ $branchCode }}">
            @endif

            {{-- Admin: selector de sucursal --}}
            @if(auth()->user()->is_admin)
            <div class="flex items-center gap-2 mb-3">
                <span class="text-xs font-medium text-slate-500">Sucursal:</span>
                @foreach($branches as $code => $name)
                <a href="{{ route('recepcion.ordenes', ['branch' => $code]) }}"
                   class="text-xs px-3 py-1.5 rounded-lg border font-medium transition-all
                          {{ $branchCode === $code ? 'bg-blue-600 text-white border-blue-600' : 'border-slate-200 text-slate-600 hover:border-blue-400' }}">
                    {{ $name }}
                </a>
                @endforeach
            </div>
            @endif

            {{-- Tabs tipo de búsqueda --}}
            <div class="flex rounded-xl border border-slate-200 overflow-hidden">
                @foreach([
                    'nro_orden'      => ['fa-hashtag',  'Nro. Orden',   $orderPrefix.'000123'],
                    'identificacion' => ['fa-id-card',  'CI / RUC',     '1712345678'],
                    'serie'          => ['fa-barcode',  'Serie equipo', 'SN123456789'],
                ] as $val => [$icon, $label, $ph])
                <button type="button" onclick="setTipo('{{ $val }}','{{ $ph }}')" data-tipo="{{ $val }}"
                        class="tipo-btn flex-1 py-3 flex items-center justify-center gap-2 text-sm font-medium transition-colors border-r border-slate-200 last:border-r-0
                               {{ $tipo === $val ? 'bg-blue-600 text-white' : 'text-slate-500 hover:bg-slate-50' }}">
                    <i class="fa-solid {{ $icon }} text-xs"></i>
                    {{ $label }}
                </button>
                @endforeach
            </div>

            <input type="hidden" name="tipo" id="tipoHidden" value="{{ $tipo }}">

            <div class="flex gap-3">
                <input type="text" name="q" id="searchInput" value="{{ $q }}" autofocus
                       placeholder="{{ $tipo === 'nro_orden' ? $orderPrefix.'000123' : ($tipo === 'identificacion' ? '1712345678' : 'SN123456789') }}"
                       class="flex-1 border border-slate-200 rounded-xl px-4 py-3 text-sm font-mono focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/10 transition-all">
                <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-xl transition-colors flex items-center gap-2">
                    <i class="fa-solid fa-search"></i> Buscar
                </button>
                @if($q)
                <a href="{{ route('recepcion.ordenes', array_filter(['branch' => auth()->user()->is_admin ? $branchCode : null])) }}"
                   class="border border-slate-200 text-slate-500 px-4 py-3 rounded-xl transition-colors hover:bg-slate-50">
                    <i class="fa-solid fa-xmark"></i>
                </a>
                @endif
            </div>
        </form>
    </div>
</div>

{{-- RESULTADOS --}}
@if($error)
<div class="flex items-center gap-3 bg-amber-50 border border-amber-200 text-amber-700 px-5 py-4 rounded-2xl">
    <i class="fa-solid fa-triangle-exclamation text-xl flex-shrink-0"></i>
    <div>
        <p class="font-semibold text-sm">Sin resultados</p>
        <p class="text-xs text-amber-600 mt-0.5">{{ $error }}</p>
    </div>
</div>

@elseif($results !== null && $results->count() > 0)
<div class="flex items-center justify-between mb-4">
    <p class="text-slate-500 text-sm">
        <span class="font-bold text-slate-900">{{ $results->count() }}</span>
        {{ $results->count() === 1 ? 'orden encontrada' : 'órdenes encontradas' }}
        en <span class="font-medium text-slate-700">{{ $branchName }}</span>
    </p>
</div>

<div class="space-y-5">
    @foreach($results as $o)
    @php
        $statusMap = [
            'En Revisión'        => ['bg-amber-100 text-amber-800 border-amber-200',   'fa-magnifying-glass', '#fef3c7'],
            'En Reparacion'      => ['bg-blue-100 text-blue-800 border-blue-200',      'fa-screwdriver-wrench','#dbeafe'],
            'Esperando Repuesto' => ['bg-violet-100 text-violet-800 border-violet-200','fa-box',              '#ede9fe'],
            'Finalizada'         => ['bg-green-100 text-green-800 border-green-200',   'fa-circle-check',     '#dcfce7'],
            'Entregada'          => ['bg-slate-100 text-slate-600 border-slate-200',   'fa-box-open',         '#f1f5f9'],
            'Anulada'            => ['bg-red-100 text-red-800 border-red-200',         'fa-ban',              '#fee2e2'],
            'Nota de Credito'    => ['bg-pink-100 text-pink-800 border-pink-200',      'fa-file-invoice',     '#fce7f3'],
        ];
        [$sc, $si, $sbg] = $statusMap[$o->estado_orden ?? ''] ?? ['bg-slate-100 text-slate-600 border-slate-200','fa-file-lines','#f1f5f9'];
        $equipo  = trim(implode(' ', array_filter([$o->tipo ?? '', $o->marca ?? '', $o->modelo ?? ''])));
        $cliente = trim(($o->nombres ?? '').' '.($o->apellidos ?? '')) ?: ($o->cliente ?? '—');
        $falla   = trim(($o->falla ?? '').(($o->falla && $o->observacion) ? ' — ' : '').($o->observacion ?? ''));
        $informe = $informes->get($o->orden_id ?? null);
        $fotos   = $informe ? ($informeFotos->get($informe->id) ?? collect()) : collect();

        // Contexto para el asistente IA
        $aiCtx = "ORDEN: {$o->nro_orden}\nESTADO: {$o->estado_orden}\nCLIENTE: {$cliente}\nEQUIPO: {$equipo}\nSERIE: {$o->serie}\nFALLA REPORTADA: {$o->falla}\nOBSERVACION: {$o->observacion}\nTECNICO: {$o->tecnico}\nSUCURSAL: {$o->sucursal}\nMOTIVO INGRESO: {$o->motivo_ingreso}";
        if ($informe) {
            $aiCtx .= "\n\nINFORME TECNICO:\nAntecedentes: {$informe->antecedentes}\nProceso: {$informe->proceso}\nConclusión: {$informe->conclusion}\nRecomendaciones: {$informe->recomendaciones}\nEstado equipo: {$informe->estado_equipo}";
        }
        $aiCtxJs = addslashes(str_replace(["\r","\n"], ['',"\\n"], $aiCtx));
    @endphp

    <div class="bg-white border border-slate-100 rounded-2xl overflow-hidden shadow-sm">

        {{-- Header --}}
        <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100"
             style="background:{{ $sbg }}30;">
            <div class="flex items-center gap-3 flex-wrap">
                <span class="text-xl font-bold font-mono text-blue-700">{{ $o->nro_orden ?? '—' }}</span>
                @if(!empty($o->serie))
                <span class="text-xs bg-white/80 border border-slate-200 text-slate-600 px-2.5 py-1 rounded-full font-mono">
                    <i class="fa-solid fa-barcode mr-1 text-slate-400"></i>{{ $o->serie }}
                </span>
                @endif
                @if(!empty($o->estado_garantia))
                <span class="text-xs border px-2.5 py-1 rounded-full font-medium
                             {{ $o->estado_garantia === 'Aceptada' ? 'bg-green-50 text-green-700 border-green-200' : 'bg-slate-50 text-slate-500 border-slate-200' }}">
                    Garantía: {{ $o->estado_garantia }}
                </span>
                @endif
            </div>
            <div class="flex items-center gap-2 flex-shrink-0">
                <span class="text-xs font-bold px-3 py-1.5 rounded-full border flex items-center gap-1.5 {{ $sc }}">
                    <i class="fa-solid {{ $si }}"></i> {{ $o->estado_orden ?? '—' }}
                </span>
                <button onclick="analizarOrden('{{ $aiCtxJs }}')"
                        title="Analizar con IA"
                        class="flex items-center gap-1.5 text-xs font-semibold px-3 py-1.5 rounded-full border border-indigo-200 bg-indigo-50 text-indigo-600 hover:bg-indigo-100 hover:border-indigo-400 transition-colors">
                    <i class="fa-solid fa-robot text-xs"></i>
                    <span class="hidden sm:inline">Analizar con IA</span>
                </button>
            </div>
        </div>

        {{-- Cuerpo --}}
        <div class="p-6 grid grid-cols-1 md:grid-cols-3 gap-6">

            {{-- CLIENTE --}}
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-3 flex items-center gap-1.5">
                    <i class="fa-solid fa-user text-slate-300"></i> Cliente
                </p>
                <div class="space-y-3">
                    <div>
                        <p class="text-xs text-slate-400 font-medium mb-0.5">Nombre completo</p>
                        <p class="text-sm font-bold text-slate-900">{{ $cliente }}</p>
                    </div>
                    @if(!empty($o->identificacion))
                    <div>
                        <p class="text-xs text-slate-400 font-medium mb-0.5">CI / RUC</p>
                        <p class="text-sm text-slate-700 font-mono">{{ $o->identificacion }}</p>
                    </div>
                    @endif
                    @if(!empty($o->telefono))
                    <div>
                        <p class="text-xs text-slate-400 font-medium mb-0.5">Teléfono</p>
                        <a href="tel:{{ $o->telefono }}" class="text-sm text-blue-600 hover:text-blue-800 font-medium">
                            <i class="fa-solid fa-phone text-xs mr-1"></i>{{ $o->telefono }}
                        </a>
                    </div>
                    @endif
                    @if(!empty($o->numero_contacto))
                    <div>
                        <p class="text-xs text-slate-400 font-medium mb-0.5">Nro. Contacto</p>
                        <a href="tel:{{ $o->numero_contacto }}" class="text-sm text-blue-600 hover:text-blue-800 font-medium">
                            <i class="fa-solid fa-phone text-xs mr-1"></i>{{ $o->numero_contacto }}
                        </a>
                    </div>
                    @endif
                    @if(!empty($o->correo))
                    <div>
                        <p class="text-xs text-slate-400 font-medium mb-0.5">Email</p>
                        <p class="text-sm text-slate-600">{{ $o->correo }}</p>
                    </div>
                    @endif
                    @if(!empty($o->direccion))
                    <div>
                        <p class="text-xs text-slate-400 font-medium mb-0.5">Dirección</p>
                        <p class="text-sm text-slate-700">{{ $o->direccion }}</p>
                    </div>
                    @endif
                    @if(!empty($o->ciudad_procedencia))
                    <div>
                        <p class="text-xs text-slate-400 font-medium mb-0.5">Ciudad</p>
                        <p class="text-sm text-slate-700">{{ $o->ciudad_procedencia }}</p>
                    </div>
                    @endif
                </div>
            </div>

            {{-- EQUIPO --}}
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-3 flex items-center gap-1.5">
                    <i class="fa-solid fa-laptop text-slate-300"></i> Equipo
                </p>
                <div class="space-y-3">
                    <div>
                        <p class="text-xs text-slate-400 font-medium mb-0.5">Descripción</p>
                        <p class="text-sm font-semibold text-slate-900">{{ $equipo ?: '—' }}</p>
                    </div>
                    @if(!empty($o->serie))
                    <div>
                        <p class="text-xs text-slate-400 font-medium mb-0.5">Serie / IMEI</p>
                        <p class="text-sm text-slate-700 font-mono">{{ $o->serie }}</p>
                    </div>
                    @endif
                    @if(!empty($o->codigo_producto))
                    <div>
                        <p class="text-xs text-slate-400 font-medium mb-0.5">Código producto</p>
                        <p class="text-sm text-slate-700 font-mono">{{ $o->codigo_producto }}</p>
                    </div>
                    @endif
                    @if(!empty($o->nro_factura))
                    <div>
                        <p class="text-xs text-slate-400 font-medium mb-0.5">Nro. Factura</p>
                        <p class="text-sm text-slate-700 font-mono">{{ $o->nro_factura }}</p>
                    </div>
                    @endif
                    @if(!empty($o->fecha_facturacion))
                    <div>
                        <p class="text-xs text-slate-400 font-medium mb-0.5">Fecha factura</p>
                        <p class="text-sm text-slate-700">{{ $o->fecha_facturacion }}</p>
                    </div>
                    @endif
                </div>
            </div>

            {{-- SERVICIO --}}
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-3 flex items-center gap-1.5">
                    <i class="fa-solid fa-wrench text-slate-300"></i> Servicio
                </p>
                <div class="space-y-3">
                    <div>
                        <p class="text-xs text-slate-400 font-medium mb-0.5">Técnico</p>
                        <p class="text-sm font-medium text-slate-900">{{ $o->tecnico ?? '—' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-400 font-medium mb-0.5">Sucursal</p>
                        <p class="text-sm text-slate-700">{{ $o->sucursal ?? $branchName }}</p>
                    </div>
                    @if(!empty($o->fecha_de_ingreso_fmt))
                    <div>
                        <p class="text-xs text-slate-400 font-medium mb-0.5">Fecha de ingreso</p>
                        <p class="text-sm text-slate-700">{{ $o->fecha_de_ingreso_fmt }}</p>
                    </div>
                    @endif
                    @if(!empty($o->motivo_ingreso))
                    <div>
                        <p class="text-xs text-slate-400 font-medium mb-0.5">Motivo de ingreso</p>
                        <p class="text-sm text-slate-700">{{ $o->motivo_ingreso }}</p>
                    </div>
                    @endif
                    @if(!empty($o->fecha_prometido_fmt))
                    <div>
                        <p class="text-xs text-slate-400 font-medium mb-0.5">Fecha prometida</p>
                        <p class="text-sm text-slate-700">{{ $o->fecha_prometido_fmt }}</p>
                    </div>
                    @endif
                    @if(!empty($o->fecha_entrega_fmt))
                    <div>
                        <p class="text-xs text-slate-400 font-medium mb-0.5">Fecha entrega</p>
                        <p class="text-sm font-medium text-emerald-700">{{ $o->fecha_entrega_fmt }}</p>
                    </div>
                    @endif
                    @if(!empty($o->precio))
                    <div>
                        <p class="text-xs text-slate-400 font-medium mb-0.5">Precio</p>
                        <p class="text-sm font-bold text-green-700">${{ number_format($o->precio, 2) }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Campos extra de vista_ordenes --}}
        @php
            $extras = array_filter([
                'Tipo de orden'    => $o->tipo_orden ?? null,
                'Estado repuesto'  => $o->estado_repuesto ?? null,
                'Fecha prometida'  => $o->fecha_prometido_fmt ?? null,
                'Fecha entrega'    => $o->fecha_entrega_fmt ?? null,
                'Ingresado por'    => $o->ingresado_por ?? null,
                'Dirección'        => $o->direccion ?? null,
                'Nro. Factura 2'   => $o->nro_factura_2 ?? null,
            ]);
        @endphp
        @if(!empty($extras))
        <div class="px-6 pt-4 pb-2 border-t border-slate-50">
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                @foreach($extras as $label => $val)
                <div>
                    <p class="text-xs text-slate-400 font-medium mb-0.5">{{ $label }}</p>
                    <p class="text-sm text-slate-700">{{ $val }}</p>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        {{-- Descripción del problema --}}
        @if($falla)
        <div class="px-6 pb-4 border-t border-slate-50 pt-4">
            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-2 flex items-center gap-1.5">
                <i class="fa-solid fa-comment-dots text-slate-300"></i> Descripción del problema reportada
            </p>
            <p class="text-sm text-slate-600 leading-relaxed bg-slate-50 border border-slate-100 rounded-xl px-4 py-3">
                {{ $falla }}
            </p>
        </div>
        @endif

        {{-- ═══ INFORME TÉCNICO ══════════════════════════════════════════ --}}
        @if($informe)
        <div class="border-t-4 border-blue-100">
            {{-- Header informe --}}
            <div class="flex items-center gap-3 px-6 py-4 bg-gradient-to-r from-blue-50 to-indigo-50">
                <div class="w-9 h-9 bg-blue-600 rounded-xl flex items-center justify-center flex-shrink-0">
                    <i class="fa-solid fa-file-lines text-white text-sm"></i>
                </div>
                <div>
                    <p class="text-blue-900 text-sm font-bold">Informe Técnico</p>
                    <p class="text-blue-600 text-xs">
                        Fecha: {{ $informe->fecha_informe ?? '—' }}
                        @if(!empty($informe->estado_equipo))
                        · Estado equipo: <strong>{{ $informe->estado_equipo }}</strong>
                        @endif
                    </p>
                </div>
            </div>

            <div class="px-6 py-5 grid grid-cols-1 md:grid-cols-2 gap-5">
                @if(!empty($informe->antecedentes))
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-2 flex items-center gap-1.5">
                        <i class="fa-solid fa-clock-rotate-left text-slate-300"></i> Antecedentes
                    </p>
                    <p class="text-sm text-slate-700 leading-relaxed bg-slate-50 border border-slate-100 rounded-xl px-4 py-3 whitespace-pre-wrap">{{ $informe->antecedentes }}</p>
                </div>
                @endif

                @if(!empty($informe->proceso))
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-2 flex items-center gap-1.5">
                        <i class="fa-solid fa-screwdriver-wrench text-slate-300"></i> Proceso realizado
                    </p>
                    <p class="text-sm text-slate-700 leading-relaxed bg-slate-50 border border-slate-100 rounded-xl px-4 py-3 whitespace-pre-wrap">{{ $informe->proceso }}</p>
                </div>
                @endif

                @if(!empty($informe->conclusion))
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-2 flex items-center gap-1.5">
                        <i class="fa-solid fa-circle-check text-slate-300"></i> Conclusión
                    </p>
                    <p class="text-sm text-slate-700 leading-relaxed bg-green-50 border border-green-100 rounded-xl px-4 py-3 whitespace-pre-wrap">{{ $informe->conclusion }}</p>
                </div>
                @endif

                @if(!empty($informe->recomendaciones))
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-2 flex items-center gap-1.5">
                        <i class="fa-solid fa-lightbulb text-slate-300"></i> Recomendaciones
                    </p>
                    <p class="text-sm text-slate-700 leading-relaxed bg-amber-50 border border-amber-100 rounded-xl px-4 py-3 whitespace-pre-wrap">{{ $informe->recomendaciones }}</p>
                </div>
                @endif
            </div>

            {{-- Fotos del informe --}}
            @if($fotos->count() > 0)
            <div class="px-6 pb-5">
                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-3 flex items-center gap-1.5">
                    <i class="fa-solid fa-images text-slate-300"></i> Fotos del informe ({{ $fotos->count() }})
                </p>
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3">
                    @foreach($fotos as $foto)
                    <a href="{{ route('recepcion.foto', $foto->id) }}" target="_blank"
                       class="block rounded-xl overflow-hidden border border-slate-200 hover:border-blue-400 transition-colors group relative aspect-square bg-slate-100">
                        <img src="{{ route('recepcion.foto', $foto->id) }}"
                             alt="{{ $foto->caption ?? 'Foto ' . $loop->iteration }}"
                             loading="lazy"
                             class="w-full h-full object-cover group-hover:opacity-90 transition-opacity">
                        @if(!empty($foto->caption))
                        <div class="absolute bottom-0 inset-x-0 bg-black/50 px-2 py-1">
                            <p class="text-white text-xs truncate">{{ $foto->caption }}</p>
                        </div>
                        @endif
                        <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity bg-black/20">
                            <i class="fa-solid fa-up-right-and-down-left-from-center text-white text-lg"></i>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
        @endif
    </div>
    @endforeach
</div>

@elseif($q === '')
<div class="bg-white border border-slate-100 rounded-2xl p-16 text-center shadow-sm">
    <div class="w-20 h-20 bg-blue-50 rounded-2xl flex items-center justify-center mx-auto mb-5">
        <i class="fa-solid fa-search text-blue-400 text-3xl"></i>
    </div>
    <h2 class="text-slate-700 font-semibold text-lg mb-2">Busca una orden de trabajo</h2>
    <p class="text-slate-400 text-sm max-w-sm mx-auto">
        Ingresa el número de orden, CI/RUC del cliente o la serie del equipo.
    </p>
    <div class="mt-6 flex items-center justify-center gap-6 text-xs text-slate-300">
        <span><i class="fa-solid fa-hashtag mr-1"></i>{{ $orderPrefix }}XXXXXX</span>
        <span><i class="fa-solid fa-id-card mr-1"></i>Cédula / RUC</span>
        <span><i class="fa-solid fa-barcode mr-1"></i>Serie del equipo</span>
    </div>
</div>
@endif

@endsection

@push('scripts')
<script>
function setTipo(tipo, placeholder) {
    document.getElementById('tipoHidden').value = tipo;
    document.getElementById('searchInput').placeholder = placeholder;
    document.getElementById('searchInput').focus();
    document.querySelectorAll('.tipo-btn').forEach(btn => {
        const active = btn.dataset.tipo === tipo;
        btn.classList.toggle('bg-blue-600', active);
        btn.classList.toggle('text-white', active);
        btn.classList.toggle('text-slate-500', !active);
        btn.classList.toggle('hover:bg-slate-50', !active);
    });
}
document.getElementById('searchInput')?.addEventListener('keydown', e => {
    if (e.key === 'Enter') document.getElementById('searchForm').submit();
});
</script>
@endpush
