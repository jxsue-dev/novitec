@extends('layouts.admin')

@section('title', 'Configuración')
@section('page-title', 'Configuración')
@section('page-subtitle', 'Ajustes generales del sitio')

@section('content')

<div class="max-w-2xl">
    <div class="bg-white border border-slate-100 rounded-2xl p-6">
        <form method="POST" action="{{ route('admin.settings.update') }}" class="space-y-5">
            @csrf
            @foreach($settings as $setting)
            <div>
                <label class="block text-xs text-slate-500 mb-1.5 capitalize">
                    {{ str_replace('_', ' ', $setting->key) }}
                </label>
                <input type="text"
                       name="settings[{{ $setting->key }}]"
                       value="{{ $setting->value }}"
                       class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-blue-400 transition-colors">
            </div>
            @endforeach
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-8 py-2.5 rounded-xl transition-colors">
                Guardar configuración
            </button>
        </form>
    </div>
</div>

@endsection
