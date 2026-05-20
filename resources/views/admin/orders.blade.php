@extends('layouts.admin')

@section('title', 'Órdenes')
@section('page-title', 'Órdenes de servicio')
@section('page-subtitle', 'Gestiona todas las órdenes de reparación')

@section('content')

<div class="flex items-center justify-between mb-6">
    <div></div>
    <a href="{{ route('admin.orders.create') }}"
       class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-5 py-2.5 rounded-xl transition-colors">
        + Nueva orden
    </a>
</div>

<div class="bg-white border border-slate-100 rounded-2xl overflow-hidden">
    <div class="px-6 py-4 border-b border-slate-100">
        <h2 class="text-slate-900 text-sm font-semibold">Todas las órdenes</h2>
    </div>
    <div class="divide-y divide-slate-50">
        @forelse($orders as $order)
        <div x-data="{ open: false }">
            <div class="px-6 py-4 flex items-center justify-between hover:bg-slate-50 transition-colors cursor-pointer"
                 onclick="this.closest('[x-data]').__x.$data.open = !this.closest('[x-data]').__x.$data.open">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 bg-blue-50 rounded-lg flex items-center justify-center text-sm">💻</div>
                    <div>
                        <p class="text-slate-900 text-sm font-medium">{{ $order->device }}
                            @if($order->brand) — {{ $order->brand }} @endif
                        </p>
                        <p class="text-slate-400 text-xs font-light">{{ $order->code }} · {{ $order->user->name }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <span class="text-xs font-medium px-3 py-1 rounded-full {{ $order->status_color }}">
                        {{ $order->status_label }}
                    </span>
                    <span class="text-xs text-slate-400">{{ $order->created_at->diffForHumans() }}</span>
                </div>
            </div>

            {{-- PANEL DE EDICIÓN --}}
            <div class="hidden px-6 py-5 bg-slate-50 border-t border-slate-100" id="order-{{ $order->id }}">
                <form method="POST" action="{{ route('admin.orders.update', $order) }}"
                      class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    @csrf @method('PATCH')
                    <div>
                        <label class="block text-xs text-slate-400 mb-1">Estado</label>
                        <select name="status" class="w-full border border-slate-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-blue-400">
                            @foreach(['recibido','diagnostico','reparacion','listo','entregado'] as $status)
                            <option value="{{ $status }}" {{ $order->status === $status ? 'selected' : '' }}>
                                {{ ucfirst($status) }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs text-slate-400 mb-1">Precio ($)</label>
                        <input type="number" name="price" step="0.01" value="{{ $order->price }}"
                               class="w-full border border-slate-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-blue-400">
                    </div>
                    <div>
                        <label class="block text-xs text-slate-400 mb-1">Entrega estimada</label>
                        <input type="date" name="estimated_at"
                               value="{{ $order->estimated_at ? $order->estimated_at->format('Y-m-d') : '' }}"
                               class="w-full border border-slate-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-blue-400">
                    </div>
                    <div>
                        <label class="block text-xs text-slate-400 mb-1">Notas</label>
                        <input type="text" name="notes" value="{{ $order->notes }}"
                               class="w-full border border-slate-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-blue-400">
                    </div>
                    <div class="col-span-2 md:col-span-4 flex items-center gap-3">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white text-xs font-medium px-5 py-2 rounded-lg transition-colors">
                            Guardar cambios
                        </button>
                        <form method="POST" action="{{ route('admin.orders.destroy', $order) }}"
                              onsubmit="return confirm('¿Eliminar esta orden?')" class="inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-xs text-red-500 hover:text-red-700 border border-red-100 hover:border-red-300 px-5 py-2 rounded-lg transition-colors">
                                Eliminar
                            </button>
                        </form>
                    </div>
                </form>
            </div>
        </div>
        @empty
        <div class="px-6 py-8 text-center text-slate-400 text-sm font-light">No hay órdenes registradas.</div>
        @endforelse
    </div>
    @if($orders->hasPages())
    <div class="px-6 py-4 border-t border-slate-100">
        {{ $orders->links() }}
    </div>
    @endif
</div>

@endsection

@push('scripts')
<script>
document.querySelectorAll('.cursor-pointer').forEach(row => {
    row.addEventListener('click', () => {
        const panel = row.nextElementSibling;
        panel.classList.toggle('hidden');
    });
});
</script>
@endpush
