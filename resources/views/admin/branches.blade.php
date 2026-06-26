@extends('layouts.admin')

@section('title', 'Sucursales')
@section('page-title', 'Sucursales')
@section('page-subtitle', 'Gestiona las sucursales y datos de contacto')

@section('content')

<div class="max-w-3xl mx-auto space-y-3" x-data="{ newOpen: false }">

    {{-- BOTÓN CREAR NUEVA --}}
    <div class="flex items-center justify-between mb-2">
        <p class="text-slate-400 text-sm">{{ $branches->count() }} {{ $branches->count() === 1 ? 'sucursal' : 'sucursales' }}</p>
        <button @click="newOpen = !newOpen"
                class="flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-5 py-2.5 rounded-xl transition-all">
            <i class="fa-solid fa-plus text-xs"></i>
            Nueva sucursal
        </button>
    </div>

    {{-- FORMULARIO NUEVA SUCURSAL (colapsable) --}}
    <div x-show="newOpen"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-2"
         class="bg-white border-2 border-blue-200 rounded-2xl overflow-hidden shadow-sm">

        <div class="flex items-center justify-between px-5 py-4 bg-blue-50 border-b border-blue-100">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center">
                    <i class="fa-solid fa-plus text-white text-xs"></i>
                </div>
                <p class="text-blue-900 text-sm font-semibold">Nueva sucursal</p>
            </div>
            <button @click="newOpen = false" type="button"
                    class="text-blue-400 hover:text-blue-600 w-7 h-7 flex items-center justify-center rounded-lg hover:bg-blue-100 transition-colors">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <form method="POST" action="{{ route('admin.branches.store') }}" class="p-5">
            @csrf
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="sm:col-span-2">
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">Nombre de la sucursal *</label>
                    <input type="text" name="name" required autofocus
                           placeholder="Ej: Novitec Quito Norte"
                           class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/10 transition-all">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">Teléfono *</label>
                    <input type="text" name="phone" required placeholder="02 600-1635"
                           class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/10 transition-all">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">WhatsApp</label>
                    <input type="text" name="whatsapp" placeholder="0960500156"
                           class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/10 transition-all">
                    <p class="text-xs text-slate-400 mt-1">Solo números, sin el +593</p>
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">Dirección *</label>
                    <input type="text" name="address" required placeholder="Calle N73 y Mariano Paredes, Ponceano Alto"
                           class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/10 transition-all">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">Email</label>
                    <input type="email" name="email" placeholder="quito@novitec.com.ec"
                           class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/10 transition-all">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">Horario</label>
                    <input type="text" name="schedule" placeholder="Lun-Vie 9:00-17:00"
                           class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/10 transition-all">
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">
                        Link Google Maps (embed)
                        <span class="font-normal text-slate-400 ml-1">— pega la URL del iframe de Google Maps</span>
                    </label>
                    <input type="text" name="maps_url" placeholder="https://www.google.com/maps/embed?pb=..."
                           class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/10 transition-all">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">Estado inicial</label>
                    <select name="active" class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-blue-500 transition-all">
                        <option value="1">✅ Activa</option>
                        <option value="0">❌ Inactiva</option>
                    </select>
                </div>
            </div>
            <div class="flex items-center justify-end gap-3 mt-5 pt-4 border-t border-slate-100">
                <button type="button" @click="newOpen = false"
                        class="text-sm text-slate-500 hover:text-slate-700 px-4 py-2.5 rounded-xl hover:bg-slate-100 transition-colors">
                    Cancelar
                </button>
                <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-6 py-2.5 rounded-xl transition-colors flex items-center gap-2">
                    <i class="fa-solid fa-floppy-disk"></i> Guardar sucursal
                </button>
            </div>
        </form>
    </div>

    {{-- SUCURSALES EXISTENTES (acordeón) --}}
    @forelse($branches as $branch)
    <div class="bg-white border border-slate-100 rounded-2xl overflow-hidden shadow-sm"
         x-data="{ open: false }">

        {{-- HEADER COLAPSADO --}}
        <button @click="open = !open" type="button"
                class="w-full flex items-center justify-between px-5 py-4 hover:bg-slate-50 transition-colors text-left">
            <div class="flex items-center gap-3 min-w-0">
                <span class="w-2.5 h-2.5 rounded-full flex-shrink-0 {{ $branch->active ? 'bg-emerald-400' : 'bg-slate-300' }}"></span>
                <div class="min-w-0">
                    <p class="text-slate-900 text-sm font-semibold truncate">{{ $branch->name }}</p>
                    <p class="text-slate-400 text-xs truncate">
                        <i class="fa-solid fa-location-dot text-slate-300 mr-1"></i>{{ $branch->address }}
                        @if($branch->phone)
                        &nbsp;·&nbsp;<i class="fa-solid fa-phone text-slate-300 mr-1"></i>{{ $branch->phone }}
                        @endif
                    </p>
                </div>
            </div>
            <div class="flex items-center gap-2 flex-shrink-0 ml-3">
                <span class="text-xs px-2.5 py-1 rounded-full font-medium {{ $branch->active ? 'bg-emerald-50 text-emerald-600' : 'bg-slate-100 text-slate-400' }}">
                    {{ $branch->active ? 'Activa' : 'Inactiva' }}
                </span>
                <i class="fa-solid fa-chevron-down text-slate-300 text-xs transition-transform duration-200"
                   :class="open ? 'rotate-180' : ''"></i>
            </div>
        </button>

        {{-- FORM EDITAR (desplegable) --}}
        <div x-show="open"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="border-t border-slate-100">

            <form method="POST" action="{{ route('admin.branches.update', $branch) }}" class="p-5">
                @csrf @method('PATCH')
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">Nombre *</label>
                        <input type="text" name="name" value="{{ $branch->name }}" required
                               class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/10 transition-all">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">Teléfono *</label>
                        <input type="text" name="phone" value="{{ $branch->phone }}" required
                               class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/10 transition-all">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">WhatsApp</label>
                        <input type="text" name="whatsapp" value="{{ $branch->whatsapp }}" placeholder="0960500156"
                               class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/10 transition-all">
                        <p class="text-xs text-slate-400 mt-1">Solo números, sin el +593</p>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">Dirección *</label>
                        <input type="text" name="address" value="{{ $branch->address }}" required
                               class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/10 transition-all">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">Email</label>
                        <input type="email" name="email" value="{{ $branch->email }}" placeholder="quito@novitec.com.ec"
                               class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/10 transition-all">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">Horario</label>
                        <input type="text" name="schedule" value="{{ $branch->schedule }}" placeholder="Lun-Vie 9:00-17:00"
                               class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/10 transition-all">
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">
                            Link Google Maps (embed)
                        </label>
                        <div class="flex gap-2">
                            <input type="text" name="maps_url" value="{{ $branch->maps_url }}"
                                   placeholder="https://www.google.com/maps/embed?pb=..."
                                   class="flex-1 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/10 transition-all">
                            @if($branch->maps_url)
                            <a href="{{ $branch->maps_url }}" target="_blank"
                               class="flex-shrink-0 flex items-center gap-1.5 text-xs text-blue-600 border border-blue-200 bg-blue-50 hover:bg-blue-100 px-4 py-3 rounded-xl transition-colors whitespace-nowrap">
                                <i class="fa-solid fa-map-location-dot"></i> Ver
                            </a>
                            @endif
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">Estado</label>
                        <select name="active" class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-blue-500 transition-all">
                            <option value="1" {{ $branch->active ? 'selected' : '' }}>✅ Activa</option>
                            <option value="0" {{ !$branch->active ? 'selected' : '' }}>❌ Inactiva</option>
                        </select>
                    </div>
                </div>

                <div class="flex items-center justify-between mt-5 pt-4 border-t border-slate-100">
                    <form method="POST" action="{{ route('admin.branches.destroy', $branch) }}"
                          onsubmit="return confirm('¿Eliminar {{ addslashes($branch->name) }}? Esta acción no se puede deshacer.')"
                          class="inline">
                        @csrf @method('DELETE')
                        <button type="submit"
                                class="text-xs text-red-400 hover:text-red-600 border border-red-100 hover:border-red-200 bg-red-50 hover:bg-red-100 px-4 py-2.5 rounded-xl transition-colors flex items-center gap-1.5">
                            <i class="fa-solid fa-trash-can"></i> Eliminar sucursal
                        </button>
                    </form>
                    <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-6 py-2.5 rounded-xl transition-colors flex items-center gap-2">
                        <i class="fa-solid fa-floppy-disk"></i> Guardar cambios
                    </button>
                </div>
            </form>
        </div>
    </div>
    @empty
    <div class="bg-white border border-slate-100 rounded-2xl p-14 text-center">
        <i class="fa-solid fa-location-dot text-slate-200 text-5xl mb-4 block"></i>
        <p class="text-slate-500 text-sm font-medium mb-1">Sin sucursales registradas</p>
        <p class="text-slate-400 text-xs mb-5">Crea la primera usando el botón de arriba.</p>
        <button @click="newOpen = true"
                class="text-sm text-blue-600 border border-blue-200 hover:bg-blue-50 px-5 py-2.5 rounded-xl transition-colors">
            <i class="fa-solid fa-plus mr-1"></i> Nueva sucursal
        </button>
    </div>
    @endforelse

</div>

@endsection
