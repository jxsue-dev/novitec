@extends('layouts.admin')

@section('title', 'Redes sociales')
@section('page-title', 'Redes sociales')
@section('page-subtitle', 'Gestiona los enlaces a redes sociales')

@section('content')

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    <div class="bg-white border border-slate-100 rounded-2xl p-6">
        <h3 class="text-slate-900 text-sm font-semibold mb-5">Nueva red social</h3>
        <form method="POST" action="{{ route('admin.socials.store') }}" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs text-slate-500 mb-1.5">Plataforma *</label>
                <input type="text" name="platform" required placeholder="Facebook"
                       class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-blue-400">
            </div>
            <div>
                <label class="block text-xs text-slate-500 mb-1.5">URL *</label>
                <input type="url" name="url" required placeholder="https://facebook.com/novitec"
                       class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-blue-400">
            </div>
            <div>
                <label class="block text-xs text-slate-500 mb-1.5">Orden</label>
                <input type="number" name="order" value="0"
                       class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-blue-400">
            </div>
            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium py-2.5 rounded-xl transition-colors">
                Agregar red social
            </button>
        </form>
    </div>

    <div class="lg:col-span-2 space-y-4">
        @forelse($socials as $social)
        <div class="bg-white border border-slate-100 rounded-2xl p-5">
            <form method="POST" action="{{ route('admin.socials.update', $social) }}">
                @csrf @method('PATCH')
                <div class="flex items-center justify-between mb-4">
                    <h4 class="text-slate-900 text-sm font-semibold">{{ $social->platform }}</h4>
                    <div class="flex items-center gap-2">
                        <button type="submit" class="text-xs bg-blue-50 hover:bg-blue-100 text-blue-600 border border-blue-100 px-3 py-1.5 rounded-lg transition-colors">
                            Guardar
                        </button>
                        <form method="POST" action="{{ route('admin.socials.destroy', $social) }}"
                              onsubmit="return confirm('¿Eliminar?')" class="inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-xs bg-red-50 hover:bg-red-100 text-red-500 border border-red-100 px-3 py-1.5 rounded-lg transition-colors">
                                Eliminar
                            </button>
                        </form>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs text-slate-400 mb-1">Plataforma</label>
                        <input type="text" name="platform" value="{{ $social->platform }}"
                               class="w-full border border-slate-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-blue-400">
                    </div>
                    <div>
                        <label class="block text-xs text-slate-400 mb-1">Orden</label>
                        <input type="number" name="order" value="{{ $social->order }}"
                               class="w-full border border-slate-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-blue-400">
                    </div>
                    <div class="col-span-2">
                        <label class="block text-xs text-slate-400 mb-1">URL</label>
                        <input type="url" name="url" value="{{ $social->url }}"
                               class="w-full border border-slate-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-blue-400">
                    </div>
                    <div>
                        <label class="block text-xs text-slate-400 mb-1">Activa</label>
                        <select name="active" class="w-full border border-slate-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-blue-400">
                            <option value="1" {{ $social->active ? 'selected' : '' }}>Sí</option>
                            <option value="0" {{ !$social->active ? 'selected' : '' }}>No</option>
                        </select>
                    </div>
                </div>
            </form>
        </div>
        @empty
        <div class="bg-white border border-slate-100 rounded-2xl p-8 text-center text-slate-400 text-sm font-light">
            No hay redes sociales registradas.
        </div>
        @endforelse
    </div>
</div>

@endsection
