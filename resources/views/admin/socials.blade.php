@extends('layouts.admin')

@section('title', 'Redes sociales')
@section('page-title', 'Redes sociales')
@section('page-subtitle', 'Gestiona los enlaces a redes sociales')

@section('content')

@php
$platforms = [
    'Facebook'  => ['fa-brands fa-facebook',   '#1877f2'],
    'Instagram' => ['fa-brands fa-instagram',   '#e1306c'],
    'WhatsApp'  => ['fa-brands fa-whatsapp',    '#25d366'],
    'TikTok'    => ['fa-brands fa-tiktok',      '#010101'],
    'YouTube'   => ['fa-brands fa-youtube',     '#ff0000'],
    'LinkedIn'  => ['fa-brands fa-linkedin',    '#0077b5'],
    'Twitter/X' => ['fa-brands fa-x-twitter',   '#000'],
    'Otro'      => ['fa-solid fa-link',          '#64748b'],
];
@endphp

<div class="max-w-3xl mx-auto space-y-3" x-data="{ newOpen: false }">

    {{-- HEADER --}}
    <div class="flex items-center justify-between mb-2">
        <p class="text-slate-400 text-sm">{{ $socials->count() }} {{ $socials->count() === 1 ? 'red registrada' : 'redes registradas' }}</p>
        <button @click="newOpen = !newOpen"
                class="flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-5 py-2.5 rounded-xl transition-all">
            <i class="fa-solid fa-plus text-xs"></i> Nueva red social
        </button>
    </div>

    {{-- FORM NUEVA RED (colapsable) --}}
    <div x-show="newOpen"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-end="opacity-0 -translate-y-2"
         class="bg-white border-2 border-blue-200 rounded-2xl overflow-hidden shadow-sm">

        <div class="flex items-center justify-between px-5 py-4 bg-blue-50 border-b border-blue-100">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center">
                    <i class="fa-solid fa-plus text-white text-xs"></i>
                </div>
                <p class="text-blue-900 text-sm font-semibold">Nueva red social</p>
            </div>
            <button @click="newOpen = false" type="button"
                    class="text-blue-400 hover:text-blue-600 w-7 h-7 flex items-center justify-center rounded-lg hover:bg-blue-100 transition-colors">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <form method="POST" action="{{ route('admin.socials.store') }}" class="p-5">
            @csrf
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">Plataforma *</label>
                    <select name="platform" required
                            class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/10 transition-all">
                        <option value="">Seleccionar…</option>
                        @foreach($platforms as $name => $meta)
                        <option value="{{ $name }}">{{ $name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">Orden <span class="font-normal text-slate-400">(menor = primero)</span></label>
                    <input type="number" name="order" value="0" min="0"
                           class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-blue-500 transition-all">
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">URL *</label>
                    <input type="url" name="url" required placeholder="https://facebook.com/novitec"
                           class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/10 transition-all">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">Estado</label>
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
                    <i class="fa-solid fa-floppy-disk"></i> Guardar red social
                </button>
            </div>
        </form>
    </div>

    {{-- REDES EXISTENTES (acordeón) --}}
    @forelse($socials as $social)
    @php $meta = $platforms[$social->platform] ?? $platforms['Otro']; @endphp
    <div class="bg-white border border-slate-100 rounded-2xl overflow-hidden shadow-sm" x-data="{ open: false }">

        {{-- HEADER COLAPSADO --}}
        <button @click="open = !open" type="button"
                class="w-full flex items-center gap-3 px-5 py-4 hover:bg-slate-50 transition-colors text-left">

            {{-- Icono de la plataforma --}}
            <div class="w-10 h-10 rounded-xl flex items-center justify-center text-white text-lg flex-shrink-0"
                 style="background:{{ $meta[1] }}">
                <i class="{{ $meta[0] }}"></i>
            </div>

            <div class="flex-1 min-w-0">
                <p class="text-slate-900 text-sm font-semibold">{{ $social->platform }}</p>
                <p class="text-xs text-slate-400 truncate">{{ $social->url }}</p>
            </div>

            <div class="flex items-center gap-2 flex-shrink-0">
                <a href="{{ $social->url }}" target="_blank" onclick="event.stopPropagation()"
                   class="text-xs text-slate-400 hover:text-blue-500 border border-slate-200 hover:border-blue-300 px-2.5 py-1.5 rounded-lg transition-colors">
                    <i class="fa-solid fa-arrow-up-right-from-square"></i>
                </a>
                <span class="text-xs px-2.5 py-1 rounded-full font-medium {{ $social->active ? 'bg-emerald-50 text-emerald-600' : 'bg-slate-100 text-slate-400' }}">
                    {{ $social->active ? 'Activa' : 'Inactiva' }}
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
             class="border-t border-slate-100">

            <form method="POST" action="{{ route('admin.socials.update', $social) }}" class="p-5">
                @csrf @method('PATCH')
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">Plataforma</label>
                        <select name="platform" class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-blue-500 transition-all">
                            @foreach($platforms as $name => $m)
                            <option value="{{ $name }}" {{ $social->platform === $name ? 'selected' : '' }}>{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">Orden</label>
                        <input type="number" name="order" value="{{ $social->order }}" min="0"
                               class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-blue-500 transition-all">
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">URL</label>
                        <input type="url" name="url" value="{{ $social->url }}"
                               class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/10 transition-all">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">Estado</label>
                        <select name="active" class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-blue-500 transition-all">
                            <option value="1" {{ $social->active ? 'selected' : '' }}>✅ Activa</option>
                            <option value="0" {{ !$social->active ? 'selected' : '' }}>❌ Inactiva</option>
                        </select>
                    </div>
                </div>

                <div class="flex items-center justify-between mt-5 pt-4 border-t border-slate-100">
                    <form method="POST" action="{{ route('admin.socials.destroy', $social) }}"
                          onsubmit="return confirm('¿Eliminar {{ addslashes($social->platform) }}?')" class="inline">
                        @csrf @method('DELETE')
                        <button type="submit"
                                class="text-xs text-red-400 hover:text-red-600 border border-red-100 hover:border-red-200 bg-red-50 hover:bg-red-100 px-4 py-2.5 rounded-xl transition-colors flex items-center gap-1.5">
                            <i class="fa-solid fa-trash-can"></i> Eliminar
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
        <i class="fa-solid fa-share-nodes text-slate-200 text-5xl mb-4 block"></i>
        <p class="text-slate-500 text-sm font-medium mb-1">Sin redes sociales registradas</p>
        <p class="text-slate-400 text-xs mb-5">Crea la primera usando el botón de arriba.</p>
        <button @click="newOpen = true"
                class="text-sm text-blue-600 border border-blue-200 hover:bg-blue-50 px-5 py-2.5 rounded-xl transition-colors">
            <i class="fa-solid fa-plus mr-1"></i> Nueva red social
        </button>
    </div>
    @endforelse
</div>

@endsection
