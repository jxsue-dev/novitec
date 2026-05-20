@extends('layouts.admin')

@section('title', 'Sucursales')
@section('page-title', 'Sucursales')
@section('page-subtitle', 'Gestiona las sucursales y datos de contacto')

@section('content')

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- FORMULARIO NUEVA SUCURSAL --}}
    <div class="bg-white border border-slate-100 rounded-2xl p-6">
        <h3 class="text-slate-900 text-sm font-semibold mb-5">Nueva sucursal</h3>
        <form method="POST" action="{{ route('admin.branches.store') }}" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs text-slate-500 mb-1.5">Nombre *</label>
                <input type="text" name="name" required placeholder="Sucursal Principal"
                       class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-blue-400 transition-colors">
            </div>
            <div>
                <label class="block text-xs text-slate-500 mb-1.5">Dirección *</label>
                <input type="text" name="address" required placeholder="Av. Principal 123"
                       class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-blue-400 transition-colors">
            </div>
            <div>
                <label class="block text-xs text-slate-500 mb-1.5">Teléfono *</label>
                <input type="text" name="phone" required placeholder="+593 99 000 0000"
                       class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-blue-400 transition-colors">
            </div>
            <div>
                <label class="block text-xs text-slate-500 mb-1.5">WhatsApp</label>
                <input type="text" name="whatsapp" placeholder="593990000000"
                       class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-blue-400 transition-colors">
            </div>
            <div>
                <label class="block text-xs text-slate-500 mb-1.5">Email</label>
                <input type="email" name="email" placeholder="sucursal@novitec.com"
                       class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-blue-400 transition-colors">
            </div>
            <div>
                <label class="block text-xs text-slate-500 mb-1.5">Horario</label>
                <input type="text" name="schedule" placeholder="Lun–Vie 8:00–18:00"
                       class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-blue-400 transition-colors">
            </div>
            <div>
                <label class="block text-xs text-slate-500 mb-1.5">Orden</label>
                <input type="number" name="order" value="0"
                       class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-blue-400 transition-colors">
            </div>
            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium py-2.5 rounded-xl transition-colors">
                Agregar sucursal
            </button>
        </form>
    </div>

    {{-- LISTA DE SUCURSALES --}}
    <div class="lg:col-span-2 space-y-4">
        @forelse($branches as $branch)
        <div class="bg-white border border-slate-100 rounded-2xl p-6">
            <form method="POST" action="{{ route('admin.branches.update', $branch) }}">
                @csrf @method('PATCH')
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-2 bg-{{ $branch->active ? 'emerald' : 'slate' }}-400 rounded-full"></span>
                        <h4 class="text-slate-900 text-sm font-semibold">{{ $branch->name }}</h4>
                    </div>
                    <div class="flex items-center gap-2">
                        <button type="submit" class="text-xs bg-blue-50 hover:bg-blue-100 text-blue-600 border border-blue-100 px-3 py-1.5 rounded-lg transition-colors">
                            Guardar
                        </button>
                        <form method="POST" action="{{ route('admin.branches.destroy', $branch) }}"
                              onsubmit="return confirm('¿Eliminar esta sucursal?')" class="inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-xs bg-red-50 hover:bg-red-100 text-red-500 border border-red-100 px-3 py-1.5 rounded-lg transition-colors">
                                Eliminar
                            </button>
                        </form>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs text-slate-400 mb-1">Nombre</label>
                        <input type="text" name="name" value="{{ $branch->name }}"
                               class="w-full border border-slate-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-blue-400">
                    </div>
                    <div>
                        <label class="block text-xs text-slate-400 mb-1">Teléfono</label>
                        <input type="text" name="phone" value="{{ $branch->phone }}"
                               class="w-full border border-slate-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-blue-400">
                    </div>
                    <div class="col-span-2">
                        <label class="block text-xs text-slate-400 mb-1">Dirección</label>
                        <input type="text" name="address" value="{{ $branch->address }}"
                               class="w-full border border-slate-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-blue-400">
                    </div>
                    <div>
                        <label class="block text-xs text-slate-400 mb-1">WhatsApp</label>
                        <input type="text" name="whatsapp" value="{{ $branch->whatsapp }}"
                               class="w-full border border-slate-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-blue-400">
                    </div>
                    <div>
                        <label class="block text-xs text-slate-400 mb-1">Email</label>
                        <input type="email" name="email" value="{{ $branch->email }}"
                               class="w-full border border-slate-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-blue-400">
                    </div>
                    <div>
                        <label class="block text-xs text-slate-400 mb-1">Horario</label>
                        <input type="text" name="schedule" value="{{ $branch->schedule }}"
                               class="w-full border border-slate-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-blue-400">
                    </div>
                    <div>
                        <label class="block text-xs text-slate-400 mb-1">Activa</label>
                        <select name="active" class="w-full border border-slate-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-blue-400">
                            <option value="1" {{ $branch->active ? 'selected' : '' }}>Sí</option>
                            <option value="0" {{ !$branch->active ? 'selected' : '' }}>No</option>
                        </select>
                    </div>
                </div>
            </form>
        </div>
        @empty
        <div class="bg-white border border-slate-100 rounded-2xl p-8 text-center text-slate-400 text-sm font-light">
            No hay sucursales registradas.
        </div>
        @endforelse
    </div>
</div>

@endsection
