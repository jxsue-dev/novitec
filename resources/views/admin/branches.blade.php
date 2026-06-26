@extends('layouts.admin')

@section('title', 'Sucursales')
@section('page-title', 'Sucursales')
@section('page-subtitle', 'Gestiona las sucursales y datos de contacto')

@section('content')

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- FORMULARIO NUEVA SUCURSAL --}}
    <div class="bg-white border border-slate-100 rounded-2xl p-6 lg:sticky lg:top-6 self-start">
        <h3 class="text-slate-900 text-sm font-semibold mb-5 flex items-center gap-2">
            <i class="fa-solid fa-plus text-blue-500 text-xs"></i> Nueva sucursal
        </h3>
        <form method="POST" action="{{ route('admin.branches.store') }}" class="space-y-3">
            @csrf
            <div>
                <label class="block text-xs font-medium text-slate-500 mb-1.5">Nombre *</label>
                <input type="text" name="name" required placeholder="Ej: Novitec Quito"
                       class="w-full border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm focus:outline-none focus:border-blue-400 focus:ring-1 focus:ring-blue-400/20 transition-colors">
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-medium text-slate-500 mb-1.5">Teléfono *</label>
                    <input type="text" name="phone" required placeholder="02 600-1635"
                           class="w-full border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm focus:outline-none focus:border-blue-400 focus:ring-1 focus:ring-blue-400/20 transition-colors">
                </div>
                <div>
                    <label class="block text-xs font-medium text-slate-500 mb-1.5">WhatsApp</label>
                    <input type="text" name="whatsapp" placeholder="0960500156"
                           class="w-full border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm focus:outline-none focus:border-blue-400 focus:ring-1 focus:ring-blue-400/20 transition-colors">
                </div>
            </div>
            <div>
                <label class="block text-xs font-medium text-slate-500 mb-1.5">Dirección *</label>
                <input type="text" name="address" required placeholder="Calle N73 y Mariano Paredes"
                       class="w-full border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm focus:outline-none focus:border-blue-400 focus:ring-1 focus:ring-blue-400/20 transition-colors">
            </div>
            <div>
                <label class="block text-xs font-medium text-slate-500 mb-1.5">Email</label>
                <input type="email" name="email" placeholder="quito@novitec.com.ec"
                       class="w-full border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm focus:outline-none focus:border-blue-400 focus:ring-1 focus:ring-blue-400/20 transition-colors">
            </div>
            <div>
                <label class="block text-xs font-medium text-slate-500 mb-1.5">Horario</label>
                <input type="text" name="schedule" placeholder="Lun-Vie 9:00-17:00"
                       class="w-full border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm focus:outline-none focus:border-blue-400 focus:ring-1 focus:ring-blue-400/20 transition-colors">
                <p class="text-xs text-slate-400 mt-1">Formato: Lun-Vie 9:00-17:00</p>
            </div>
            <div>
                <label class="block text-xs font-medium text-slate-500 mb-1.5">Link Google Maps</label>
                <input type="text" name="maps_url" placeholder="https://maps.google.com/maps?..."
                       class="w-full border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm focus:outline-none focus:border-blue-400 focus:ring-1 focus:ring-blue-400/20 transition-colors">
                <p class="text-xs text-slate-400 mt-1">URL del iframe embed de Google Maps</p>
            </div>
            <div>
                <label class="block text-xs font-medium text-slate-500 mb-1.5">Estado</label>
                <select name="active" class="w-full border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm focus:outline-none focus:border-blue-400 transition-colors">
                    <option value="1">✅ Activa</option>
                    <option value="0">❌ Inactiva</option>
                </select>
            </div>
            <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold py-2.5 rounded-xl transition-colors mt-2">
                <i class="fa-solid fa-plus mr-1"></i> Agregar sucursal
            </button>
        </form>
    </div>

    {{-- LISTA DE SUCURSALES --}}
    <div class="lg:col-span-2 space-y-4">
        <p class="text-slate-400 text-sm">{{ $branches->count() }} {{ $branches->count() === 1 ? 'sucursal registrada' : 'sucursales registradas' }}</p>

        @forelse($branches as $branch)
        <div class="bg-white border rounded-2xl overflow-hidden {{ $branch->active ? 'border-slate-100' : 'border-slate-200 opacity-70' }}">
            {{-- Header --}}
            <div class="flex items-center justify-between px-5 py-4 border-b border-slate-50 bg-slate-50/50">
                <div class="flex items-center gap-2.5">
                    <span class="w-2.5 h-2.5 rounded-full {{ $branch->active ? 'bg-emerald-400' : 'bg-slate-300' }}"></span>
                    <h4 class="text-slate-900 text-sm font-semibold">{{ $branch->name }}</h4>
                    @if(!$branch->active)
                    <span class="text-xs text-slate-400 bg-slate-100 px-2 py-0.5 rounded-full">Inactiva</span>
                    @endif
                </div>
                <div class="flex items-center gap-2">
                    <form method="POST" action="{{ route('admin.branches.destroy', $branch) }}"
                          onsubmit="return confirm('¿Eliminar la sucursal {{ $branch->name }}?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-xs text-red-400 hover:text-red-600 border border-red-100 hover:border-red-300 bg-red-50 hover:bg-red-100 px-3 py-1.5 rounded-lg transition-colors">
                            <i class="fa-solid fa-trash-can mr-1"></i> Eliminar
                        </button>
                    </form>
                </div>
            </div>

            {{-- Form editar (sin hidden inputs ni syncFields) --}}
            <form method="POST" action="{{ route('admin.branches.update', $branch) }}" class="p-5">
                @csrf @method('PATCH')
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-medium text-slate-500 mb-1.5">Nombre *</label>
                        <input type="text" name="name" value="{{ $branch->name }}" required
                               class="w-full border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm focus:outline-none focus:border-blue-400 focus:ring-1 focus:ring-blue-400/20 transition-colors">
                    </div>
                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <label class="block text-xs font-medium text-slate-500 mb-1.5">Teléfono *</label>
                            <input type="text" name="phone" value="{{ $branch->phone }}" required
                                   class="w-full border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm focus:outline-none focus:border-blue-400 focus:ring-1 focus:ring-blue-400/20 transition-colors">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-slate-500 mb-1.5">WhatsApp</label>
                            <input type="text" name="whatsapp" value="{{ $branch->whatsapp }}"
                                   class="w-full border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm focus:outline-none focus:border-blue-400 focus:ring-1 focus:ring-blue-400/20 transition-colors">
                        </div>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-medium text-slate-500 mb-1.5">Dirección *</label>
                        <input type="text" name="address" value="{{ $branch->address }}" required
                               class="w-full border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm focus:outline-none focus:border-blue-400 focus:ring-1 focus:ring-blue-400/20 transition-colors">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-slate-500 mb-1.5">Email</label>
                        <input type="email" name="email" value="{{ $branch->email }}"
                               class="w-full border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm focus:outline-none focus:border-blue-400 focus:ring-1 focus:ring-blue-400/20 transition-colors">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-slate-500 mb-1.5">Horario</label>
                        <input type="text" name="schedule" value="{{ $branch->schedule }}" placeholder="Lun-Vie 9:00-17:00"
                               class="w-full border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm focus:outline-none focus:border-blue-400 focus:ring-1 focus:ring-blue-400/20 transition-colors">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-slate-500 mb-1.5">Estado</label>
                        <select name="active" class="w-full border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm focus:outline-none focus:border-blue-400 transition-colors">
                            <option value="1" {{ $branch->active ? 'selected' : '' }}>✅ Activa</option>
                            <option value="0" {{ !$branch->active ? 'selected' : '' }}>❌ Inactiva</option>
                        </select>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-medium text-slate-500 mb-1.5">Link Google Maps (embed)</label>
                        <div class="flex gap-2">
                            <input type="text" name="maps_url" value="{{ $branch->maps_url }}"
                                   placeholder="https://maps.google.com/maps?..."
                                   class="flex-1 border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm focus:outline-none focus:border-blue-400 focus:ring-1 focus:ring-blue-400/20 transition-colors">
                            @if($branch->maps_url)
                            <a href="{{ $branch->maps_url }}" target="_blank"
                               class="flex-shrink-0 text-xs text-blue-500 hover:text-blue-700 border border-blue-100 hover:border-blue-300 bg-blue-50 px-3 py-2.5 rounded-xl transition-colors whitespace-nowrap">
                                <i class="fa-solid fa-map-location-dot"></i> Ver
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="flex justify-end mt-4">
                    <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-6 py-2.5 rounded-xl transition-colors">
                        <i class="fa-solid fa-floppy-disk mr-1"></i> Guardar cambios
                    </button>
                </div>
            </form>
        </div>
        @empty
        <div class="bg-white border border-slate-100 rounded-2xl p-12 text-center">
            <i class="fa-solid fa-location-dot text-slate-200 text-4xl mb-3 block"></i>
            <p class="text-slate-400 text-sm">No hay sucursales registradas. Agrega la primera.</p>
        </div>
        @endforelse
    </div>
</div>

@endsection
