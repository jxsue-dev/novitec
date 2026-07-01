@extends('layouts.recepcion')

@section('title', 'Llamadas')
@section('page-title', 'Registro de llamadas')
@section('page-subtitle', 'Historial del día')

@section('content')

{{-- Stats --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    @foreach([
        ['Total',           $stats['total'],          'bg-blue-50 text-blue-600',   'fa-phone'],
        ['Contestadas',     $stats['contestadas'],    'bg-green-50 text-green-600', 'fa-phone-volume'],
        ['No contestadas',  $stats['no_contestadas'], 'bg-red-50 text-red-600',     'fa-phone-slash'],
        ['Sin respuesta aún',$stats['pendientes'],   'bg-amber-50 text-amber-600', 'fa-clock'],
    ] as [$lbl, $val, $cls, $ico])
    <div class="bg-white border border-slate-100 rounded-2xl p-5 shadow-sm">
        <div class="flex items-center justify-between mb-2">
            <p class="text-xs font-semibold text-slate-500 uppercase tracking-wide">{{ $lbl }}</p>
            <div class="w-8 h-8 rounded-xl {{ $cls }} flex items-center justify-center text-sm">
                <i class="fa-solid {{ $ico }}"></i>
            </div>
        </div>
        <p class="text-3xl font-bold text-slate-900">{{ $val }}</p>
    </div>
    @endforeach
</div>

{{-- Filtro fecha --}}
<div class="bg-white border border-slate-100 rounded-2xl shadow-sm overflow-hidden">
    <div class="flex items-center gap-3 px-5 py-3.5 border-b border-slate-100 bg-slate-50/40">
        <form method="GET" action="{{ route('recepcion.llamadas') }}" class="flex items-center gap-3">
            <label class="text-xs font-semibold text-slate-500">Fecha:</label>
            <input type="date" name="fecha" value="{{ $fecha }}"
                   class="border border-slate-200 rounded-xl px-3 py-2 text-sm focus:outline-none focus:border-blue-500 transition-all">
            <button type="submit" class="bg-blue-600 text-white text-sm px-4 py-2 rounded-xl hover:bg-blue-700 transition-colors">
                Ver
            </button>
        </form>
        <div class="ml-auto text-xs text-slate-400">
            <i class="fa-solid fa-circle-info mr-1"></i>
            Los estados se actualizan automáticamente vía MacroDroid
        </div>
    </div>

    @if($llamadas->isEmpty())
    <div class="py-16 text-center">
        <i class="fa-solid fa-phone text-slate-200 text-5xl mb-4 block"></i>
        <p class="text-slate-500 font-medium">Sin llamadas registradas para esta fecha</p>
        <p class="text-slate-400 text-sm mt-1">Haz click en un número de teléfono para iniciar una llamada</p>
    </div>
    @else
    <div class="divide-y divide-slate-50">
        @foreach($llamadas as $llamada)
        @php
            $entrante   = ($llamada->tipo ?? 'saliente') === 'entrante';
            $estadoCls  = match($llamada->estado) {
                'contestada'    => ['bg-green-100 text-green-700', 'Contestó'],
                'no_contestada' => ['bg-red-100 text-red-600',    $entrante ? 'Perdida' : 'No contestó'],
                'iniciada'      => ['bg-amber-100 text-amber-700','Sin respuesta'],
                default         => ['bg-slate-100 text-slate-500','Error'],
            };
            // Icono de dirección
            $iconDir = $entrante
                ? ($llamada->estado === 'contestada' ? 'fa-phone-arrow-down-left text-blue-500' : 'fa-phone-missed text-red-400')
                : ($llamada->estado === 'contestada' ? 'fa-phone-arrow-up-right text-green-500' : 'fa-phone-slash text-red-400');
        @endphp
        <div class="flex items-center gap-4 px-5 py-4 hover:bg-slate-50/50 transition-colors" id="llamada-{{ $llamada->id }}">
            {{-- Icono dirección + estado --}}
            <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0 {{ $estadoCls[0] }}">
                <i class="fa-solid {{ $iconDir }} text-sm"></i>
            </div>

            {{-- Info --}}
            <div class="flex-1 min-w-0">
                <div class="flex items-center gap-2 flex-wrap mb-0.5">
                    <span class="font-mono text-sm font-bold text-slate-800">{{ $llamada->numero }}</span>
                    @if($llamada->cliente)
                    <span class="text-sm font-semibold text-slate-700">{{ $llamada->cliente }}</span>
                    @endif
                    @if($llamada->nro_orden)
                    <span class="text-xs font-mono text-blue-600 bg-blue-50 px-2 py-0.5 rounded-full">{{ $llamada->nro_orden }}</span>
                    @endif
                </div>
                <div class="flex items-center gap-2 flex-wrap">
                    <span class="text-xs px-2 py-0.5 rounded-full font-medium {{ $estadoCls[0] }}">{{ $estadoCls[1] }}</span>
                    <span class="text-xs px-2 py-0.5 rounded-full {{ $entrante ? 'bg-blue-50 text-blue-600' : 'bg-slate-100 text-slate-500' }}">
                        {{ $entrante ? '↙ Entrante' : '↗ Saliente' }}
                    </span>
                    @if($llamada->duracion_segundos)
                    <span class="text-xs text-slate-400"><i class="fa-solid fa-stopwatch mr-1"></i>{{ $llamada->duracion_formateada }}</span>
                    @endif
                </div>
                <p class="text-xs text-slate-400 mt-0.5">{{ $llamada->iniciada_at->setTimezone('America/Guayaquil')->format('H:i') }} · {{ $llamada->user->name ?? '—' }}</p>
                @if($llamada->notas)
                <p class="text-xs text-slate-500 mt-1 italic">{{ $llamada->notas }}</p>
                @endif
            </div>

            {{-- Acciones --}}
            <div class="flex items-center gap-2 flex-shrink-0">
                {{-- Vincular a orden --}}
                <button onclick="abrirVincular({{ $llamada->id }}, '{{ addslashes($llamada->nro_orden ?? '') }}')"
                        class="w-8 h-8 border {{ $llamada->nro_orden ? 'border-blue-300 bg-blue-50 text-blue-600' : 'border-slate-200 text-slate-400 hover:border-blue-300 hover:text-blue-600' }} rounded-lg flex items-center justify-center transition-colors text-xs"
                        title="{{ $llamada->nro_orden ? 'Cambiar orden vinculada' : 'Vincular a orden' }}">
                    <i class="fa-solid fa-link"></i>
                </button>
                {{-- Agregar nota --}}
                <button onclick="agregarNota({{ $llamada->id }}, '{{ addslashes($llamada->notas ?? '') }}')"
                        class="w-8 h-8 border border-slate-200 hover:border-blue-300 text-slate-400 hover:text-blue-600 rounded-lg flex items-center justify-center transition-colors text-xs"
                        title="Agregar nota">
                    <i class="fa-solid fa-note-sticky"></i>
                </button>
                {{-- Rellamar --}}
                <button onclick="iniciarLlamada('{{ $llamada->numero }}','{{ addslashes($llamada->nro_orden ?? '') }}','{{ addslashes($llamada->cliente ?? '') }}')"
                        class="w-8 h-8 border border-green-200 bg-green-50 hover:bg-green-100 text-green-600 rounded-lg flex items-center justify-center transition-colors text-xs"
                        title="Volver a llamar">
                    <i class="fa-solid fa-phone-flip"></i>
                </button>
            </div>
        </div>
        @endforeach
    </div>
    <div class="px-5 py-4 border-t border-slate-100 bg-slate-50/30">
        {{ $llamadas->links() }}
    </div>
    @endif
</div>

{{-- Modal vincular orden --}}
<div id="modal-vincular" class="fixed inset-0 z-50 hidden items-center justify-center" style="background:rgba(0,0,0,.5);backdrop-filter:blur(4px)">
    <div class="bg-white rounded-2xl p-6 w-full max-w-md shadow-2xl mx-4">
        <h3 class="text-slate-900 font-semibold mb-1">Vincular llamada a orden</h3>
        <p class="text-slate-400 text-xs mb-4">Escribe el número de orden (ej: UIO-000123)</p>
        <input type="hidden" id="vincular-llamada-id">
        <div class="flex gap-2 mb-3">
            <input type="text" id="vincular-nro-orden" placeholder="UIO-000123"
                   class="flex-1 border border-slate-200 rounded-xl px-4 py-3 text-sm font-mono focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500/10 transition-all"
                   onkeydown="if(event.key==='Enter') buscarOrden()">
            <button onclick="buscarOrden()"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-3 rounded-xl text-sm font-semibold transition-colors">
                Buscar
            </button>
        </div>
        {{-- Resultado de búsqueda --}}
        <div id="vincular-resultado" class="hidden bg-slate-50 border border-slate-200 rounded-xl p-3 mb-4 text-sm">
            <p id="vincular-res-orden" class="font-mono font-bold text-blue-600 text-sm"></p>
            <p id="vincular-res-cliente" class="text-slate-800 font-medium"></p>
            <p id="vincular-res-equipo" class="text-slate-500 text-xs mt-0.5"></p>
            <p id="vincular-res-estado" class="text-xs mt-0.5"></p>
        </div>
        <div id="vincular-error" class="hidden bg-red-50 border border-red-200 text-red-600 text-sm px-3 py-2 rounded-xl mb-4"></div>
        <div class="flex gap-3">
            <button onclick="cerrarVincular()" class="flex-1 border border-slate-200 text-slate-500 py-2.5 rounded-xl text-sm hover:bg-slate-50 transition-colors">
                Cancelar
            </button>
            <button onclick="desvincularOrden()" class="border border-red-100 text-red-400 hover:bg-red-50 px-4 py-2.5 rounded-xl text-sm transition-colors" title="Quitar vínculo">
                <i class="fa-solid fa-unlink"></i>
            </button>
            <button onclick="confirmarVinculo()" id="btn-confirmar-vinculo" disabled
                    class="flex-1 bg-blue-600 text-white py-2.5 rounded-xl text-sm font-semibold hover:bg-blue-700 transition-colors disabled:opacity-40 disabled:cursor-not-allowed">
                Vincular
            </button>
        </div>
    </div>
</div>

{{-- Modal nota --}}
<div id="modal-nota" class="fixed inset-0 z-50 hidden items-center justify-center" style="background:rgba(0,0,0,.5);backdrop-filter:blur(4px)">
    <div class="bg-white rounded-2xl p-6 w-full max-w-sm shadow-2xl mx-4">
        <h3 class="text-slate-900 font-semibold mb-4">Agregar nota a la llamada</h3>
        <input type="hidden" id="nota-llamada-id">
        <textarea id="nota-texto" rows="3" placeholder="Ej: No contestó, intentar más tarde…"
                  class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500/10 transition-all resize-none mb-4"></textarea>
        <div class="flex gap-3">
            <button onclick="cerrarNota()" class="flex-1 border border-slate-200 text-slate-500 py-2.5 rounded-xl text-sm hover:bg-slate-50 transition-colors">
                Cancelar
            </button>
            <button onclick="guardarNota()" class="flex-1 bg-blue-600 text-white py-2.5 rounded-xl text-sm font-semibold hover:bg-blue-700 transition-colors">
                Guardar nota
            </button>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
const _csrf = document.querySelector('meta[name="csrf-token"]')?.content ?? '';
let _nroConfirmado = null;

function abrirVincular(id, nroActual) {
    document.getElementById('vincular-llamada-id').value = id;
    document.getElementById('vincular-nro-orden').value = nroActual || '';
    document.getElementById('vincular-resultado').classList.add('hidden');
    document.getElementById('vincular-error').classList.add('hidden');
    document.getElementById('btn-confirmar-vinculo').disabled = true;
    _nroConfirmado = null;
    const m = document.getElementById('modal-vincular');
    m.classList.remove('hidden'); m.classList.add('flex');
    setTimeout(() => document.getElementById('vincular-nro-orden').focus(), 100);
}

function cerrarVincular() {
    document.getElementById('modal-vincular').classList.add('hidden');
    document.getElementById('modal-vincular').classList.remove('flex');
    _nroConfirmado = null;
}

async function buscarOrden() {
    const q = document.getElementById('vincular-nro-orden').value.trim();
    const errEl = document.getElementById('vincular-error');
    const resEl = document.getElementById('vincular-resultado');
    errEl.classList.add('hidden'); resEl.classList.add('hidden');
    document.getElementById('btn-confirmar-vinculo').disabled = true;
    _nroConfirmado = null;
    if (!q) return;

    try {
        const res = await fetch(`{{ route('recepcion.llamadas.buscar-orden') }}?q=${encodeURIComponent(q)}`, {
            headers: { 'Accept': 'application/json' }
        });
        const data = await res.json();
        if (data.ok && data.ordenes.length > 0) {
            const o = data.ordenes[0];
            const nombre = ((o.nombres || '') + ' ' + (o.apellidos || '')).trim() || o.cliente || '—';
            const equipo = [o.tipo, o.marca, o.modelo].filter(Boolean).join(' ');
            document.getElementById('vincular-res-orden').textContent = o.nro_orden;
            document.getElementById('vincular-res-cliente').textContent = nombre;
            document.getElementById('vincular-res-equipo').textContent = equipo;
            document.getElementById('vincular-res-estado').textContent = o.estado_orden ? `Estado: ${o.estado_orden}` : '';
            resEl.classList.remove('hidden');
            document.getElementById('btn-confirmar-vinculo').disabled = false;
            _nroConfirmado = o.nro_orden;
        } else {
            errEl.textContent = 'Orden no encontrada';
            errEl.classList.remove('hidden');
        }
    } catch { errEl.textContent = 'Error de conexión'; errEl.classList.remove('hidden'); }
}

async function confirmarVinculo() {
    if (!_nroConfirmado) return;
    const id = document.getElementById('vincular-llamada-id').value;
    await fetch(`/recepcion/llamadas/${id}/vincular`, {
        method: 'PATCH',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': _csrf, 'Accept': 'application/json' },
        body: JSON.stringify({ nro_orden: _nroConfirmado }),
    });
    cerrarVincular(); location.reload();
}

async function desvincularOrden() {
    const id = document.getElementById('vincular-llamada-id').value;
    await fetch(`/recepcion/llamadas/${id}/vincular`, {
        method: 'PATCH',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': _csrf, 'Accept': 'application/json' },
        body: JSON.stringify({ nro_orden: '' }),
    });
    cerrarVincular(); location.reload();
}

function agregarNota(id, notaActual) {
    document.getElementById('nota-llamada-id').value = id;
    document.getElementById('nota-texto').value = notaActual;
    const m = document.getElementById('modal-nota');
    m.classList.remove('hidden');
    m.classList.add('flex');
    document.getElementById('nota-texto').focus();
}
function cerrarNota() {
    const m = document.getElementById('modal-nota');
    m.classList.add('hidden');
    m.classList.remove('flex');
}
async function guardarNota() {
    const id    = document.getElementById('nota-llamada-id').value;
    const notas = document.getElementById('nota-texto').value;
    await fetch(`/recepcion/llamadas/${id}/notas`, {
        method: 'PATCH',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': _csrf, 'Accept': 'application/json' },
        body: JSON.stringify({ notas }),
    });
    cerrarNota();
    location.reload();
}

// La función iniciarLlamada está disponible desde el layout (en recepcion.blade.php)
</script>
@endpush
