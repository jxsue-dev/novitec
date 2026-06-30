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
            $estadoCls = match($llamada->estado) {
                'contestada'    => ['bg-green-100 text-green-700', 'fa-phone-volume', 'Contestó'],
                'no_contestada' => ['bg-red-100 text-red-600',    'fa-phone-slash',  'No contestó'],
                'iniciada'      => ['bg-amber-100 text-amber-700','fa-clock',        'Sin respuesta'],
                default         => ['bg-slate-100 text-slate-500','fa-phone',        'Error'],
            };
        @endphp
        <div class="flex items-center gap-4 px-5 py-4 hover:bg-slate-50/50 transition-colors" id="llamada-{{ $llamada->id }}">
            {{-- Estado icono --}}
            <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0 {{ $estadoCls[0] }}">
                <i class="fa-solid {{ $estadoCls[1] }} text-sm"></i>
            </div>

            {{-- Info --}}
            <div class="flex-1 min-w-0">
                <div class="flex items-center gap-2 flex-wrap mb-0.5">
                    <span class="font-mono text-sm font-bold text-slate-800">{{ $llamada->numero }}</span>
                    @if($llamada->nro_orden)
                    <span class="text-xs font-mono text-blue-600">{{ $llamada->nro_orden }}</span>
                    @endif
                    <span class="text-xs px-2 py-0.5 rounded-full font-medium {{ $estadoCls[0] }}">{{ $estadoCls[2] }}</span>
                    @if($llamada->duracion_segundos)
                    <span class="text-xs text-slate-400"><i class="fa-solid fa-stopwatch mr-1"></i>{{ $llamada->duracion_formateada }}</span>
                    @endif
                </div>
                <p class="text-sm text-slate-700 truncate">{{ $llamada->cliente ?? '—' }}</p>
                <p class="text-xs text-slate-400">{{ $llamada->iniciada_at->format('H:i') }} · {{ $llamada->user->name ?? '—' }}</p>
                @if($llamada->notas)
                <p class="text-xs text-slate-500 mt-1 italic">{{ $llamada->notas }}</p>
                @endif
            </div>

            {{-- Acciones --}}
            <div class="flex items-center gap-2 flex-shrink-0">
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
