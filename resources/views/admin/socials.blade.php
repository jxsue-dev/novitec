@extends('layouts.admin')

@section('title', 'Redes sociales')
@section('page-title', 'Redes sociales')
@section('page-subtitle', 'Gestiona los enlaces a redes sociales')

@section('content')

@php
$platforms = [
    'Facebook'  => ['fa-brands fa-facebook',  '#1877f2'],
    'Instagram' => ['fa-brands fa-instagram',  '#e1306c'],
    'WhatsApp'  => ['fa-brands fa-whatsapp',   '#25d366'],
    'TikTok'    => ['fa-brands fa-tiktok',     '#000'],
    'YouTube'   => ['fa-brands fa-youtube',    '#ff0000'],
    'LinkedIn'  => ['fa-brands fa-linkedin',   '#0077b5'],
    'Twitter/X' => ['fa-brands fa-x-twitter',  '#000'],
    'Otro'      => ['fa-solid fa-link',         '#64748b'],
];
@endphp

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- FORMULARIO NUEVA RED --}}
    <div class="bg-white border border-slate-100 rounded-2xl p-6 self-start lg:sticky lg:top-6">
        <h3 class="text-slate-900 text-sm font-semibold mb-5 flex items-center gap-2">
            <i class="fa-solid fa-plus text-blue-500 text-xs"></i> Nueva red social
        </h3>
        <form method="POST" action="{{ route('admin.socials.store') }}" class="space-y-3">
            @csrf
            <div>
                <label class="block text-xs font-medium text-slate-500 mb-1.5">Plataforma *</label>
                <select name="platform" required
                        class="w-full border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm focus:outline-none focus:border-blue-400 transition-colors">
                    <option value="">Seleccionar…</option>
                    @foreach($platforms as $name => $meta)
                    <option value="{{ $name }}">{{ $name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs font-medium text-slate-500 mb-1.5">URL *</label>
                <input type="url" name="url" required placeholder="https://..."
                       class="w-full border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm focus:outline-none focus:border-blue-400 focus:ring-1 focus:ring-blue-400/20 transition-colors">
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-medium text-slate-500 mb-1.5">Orden</label>
                    <input type="number" name="order" value="0" min="0"
                           class="w-full border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm focus:outline-none focus:border-blue-400 transition-colors">
                </div>
                <div>
                    <label class="block text-xs font-medium text-slate-500 mb-1.5">Estado</label>
                    <select name="active" class="w-full border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm focus:outline-none focus:border-blue-400 transition-colors">
                        <option value="1">✅ Activa</option>
                        <option value="0">❌ Inactiva</option>
                    </select>
                </div>
            </div>
            <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold py-2.5 rounded-xl transition-colors">
                <i class="fa-solid fa-plus mr-1"></i> Agregar
            </button>
        </form>
    </div>

    {{-- LISTA --}}
    <div class="lg:col-span-2 space-y-3">
        <p class="text-slate-400 text-sm">{{ $socials->count() }} {{ $socials->count() === 1 ? 'red registrada' : 'redes registradas' }}</p>

        @forelse($socials as $social)
        @php $meta = $platforms[$social->platform] ?? $platforms['Otro']; @endphp
        <div class="bg-white border border-slate-100 rounded-2xl overflow-hidden">
            {{-- Header con icono de red --}}
            <div class="flex items-center gap-3 px-5 py-3.5 border-b border-slate-50 bg-slate-50/50">
                <div class="w-8 h-8 rounded-lg flex items-center justify-center text-white text-sm flex-shrink-0"
                     style="background:{{ $meta[1] }}">
                    <i class="{{ $meta[0] }}"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-slate-900 text-sm font-semibold">{{ $social->platform }}</p>
                    <a href="{{ $social->url }}" target="_blank" class="text-xs text-blue-500 hover:text-blue-700 truncate block">
                        {{ $social->url }}
                    </a>
                </div>
                <span class="text-xs px-2 py-1 rounded-full {{ $social->active ? 'bg-emerald-50 text-emerald-600' : 'bg-slate-100 text-slate-400' }}">
                    {{ $social->active ? 'Activa' : 'Inactiva' }}
                </span>
            </div>

            <form method="POST" action="{{ route('admin.socials.update', $social) }}" class="p-4">
                @csrf @method('PATCH')
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                    <div>
                        <label class="block text-xs font-medium text-slate-500 mb-1.5">Plataforma</label>
                        <select name="platform" class="w-full border border-slate-200 rounded-xl px-3 py-2 text-sm focus:outline-none focus:border-blue-400 transition-colors">
                            @foreach($platforms as $name => $m)
                            <option value="{{ $name }}" {{ $social->platform === $name ? 'selected' : '' }}>{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-medium text-slate-500 mb-1.5">URL</label>
                        <input type="url" name="url" value="{{ $social->url }}"
                               class="w-full border border-slate-200 rounded-xl px-3 py-2 text-sm focus:outline-none focus:border-blue-400 focus:ring-1 focus:ring-blue-400/20 transition-colors">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-slate-500 mb-1.5">Orden</label>
                        <input type="number" name="order" value="{{ $social->order }}"
                               class="w-full border border-slate-200 rounded-xl px-3 py-2 text-sm focus:outline-none focus:border-blue-400 transition-colors">
                    </div>
                </div>
                <div class="flex items-center justify-between mt-3">
                    <select name="active" class="border border-slate-200 rounded-xl px-3 py-2 text-sm focus:outline-none focus:border-blue-400 transition-colors">
                        <option value="1" {{ $social->active ? 'selected' : '' }}>✅ Activa</option>
                        <option value="0" {{ !$social->active ? 'selected' : '' }}>❌ Inactiva</option>
                    </select>
                    <div class="flex items-center gap-2">
                        <form method="POST" action="{{ route('admin.socials.destroy', $social) }}"
                              onsubmit="return confirm('¿Eliminar {{ $social->platform }}?')" class="inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-xs text-red-400 hover:text-red-600 border border-red-100 hover:border-red-200 bg-red-50 hover:bg-red-100 px-3 py-2 rounded-xl transition-colors">
                                <i class="fa-solid fa-trash-can"></i>
                            </button>
                        </form>
                        <button type="submit"
                                class="bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold px-4 py-2 rounded-xl transition-colors">
                            <i class="fa-solid fa-floppy-disk mr-1"></i> Guardar
                        </button>
                    </div>
                </div>
            </form>
        </div>
        @empty
        <div class="bg-white border border-slate-100 rounded-2xl p-12 text-center">
            <i class="fa-solid fa-share-nodes text-slate-200 text-4xl mb-3 block"></i>
            <p class="text-slate-400 text-sm">No hay redes sociales registradas. Agrega la primera.</p>
        </div>
        @endforelse
    </div>
</div>

@endsection
