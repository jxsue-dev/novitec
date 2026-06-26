@extends('layouts.admin')

@section('title', 'Configuración')
@section('page-title', 'Configuración')
@section('page-subtitle', 'Ajustes generales del sitio')

@section('content')

@php
// Mapa de keys → [label, descripción, tipo de input]
$fieldMap = [
    'site_name'           => ['Nombre del sitio',        'Aparece en el título del navegador',              'text'],
    'site_description'    => ['Descripción del sitio',   'Descripción corta para SEO y redes sociales',     'textarea'],
    'contact_email'       => ['Email de contacto',       'Correo que recibe los mensajes del formulario',   'email'],
    'contact_phone'       => ['Teléfono principal',      'Número visible en el sitio',                      'text'],
    'whatsapp'            => ['WhatsApp',                'Número de WhatsApp sin código de país (+593)',     'text'],
    'address'             => ['Dirección principal',     'Dirección de la sede principal',                  'text'],
    'google_maps_url'     => ['Google Maps URL',         'URL del embed de Google Maps',                    'url'],
    'facebook_url'        => ['Facebook URL',            'Enlace a la página de Facebook',                  'url'],
    'instagram_url'       => ['Instagram URL',           'Enlace al perfil de Instagram',                   'url'],
    'discount_percent'    => ['Descuento de registro (%)', 'Porcentaje de descuento al registrarse',        'number'],
    'meta_title'          => ['Meta título',             'Título SEO de la página principal',               'text'],
    'meta_description'    => ['Meta descripción',        'Descripción SEO de la página principal',          'textarea'],
    'maintenance_mode'    => ['Modo mantenimiento',      '1 = activado, 0 = desactivado',                   'text'],
];

// Grupos de settings
$groups = [
    'general'   => ['label' => 'General',        'icon' => 'fa-gear',         'keys' => ['site_name','site_description']],
    'contacto'  => ['label' => 'Contacto',       'icon' => 'fa-phone',        'keys' => ['contact_email','contact_phone','whatsapp','address','google_maps_url']],
    'redes'     => ['label' => 'Redes sociales', 'icon' => 'fa-share-nodes',  'keys' => ['facebook_url','instagram_url']],
    'seo'       => ['label' => 'SEO',            'icon' => 'fa-magnifying-glass','keys' => ['meta_title','meta_description']],
    'otros'     => ['label' => 'Otros',          'icon' => 'fa-sliders',      'keys' => ['discount_percent','maintenance_mode']],
];

// Indexar settings por key
$settingsByKey = $settings->keyBy('key');
// Keys ya asignadas a grupos
$assignedKeys  = collect($groups)->flatMap(fn($g) => $g['keys'])->all();
// Keys sin grupo definido
$ungroupedKeys = $settings->pluck('key')->reject(fn($k) => in_array($k, $assignedKeys))->values();
@endphp

<div class="max-w-2xl">

    @if(session('success'))
    <div class="mb-5 bg-green-50 border border-green-200 text-green-700 text-sm px-4 py-3 rounded-xl flex items-center gap-2">
        <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
    </div>
    @endif

    <form method="POST" action="{{ route('admin.settings.update') }}" class="space-y-4"
          onsubmit="this.querySelector('button[type=submit]').disabled=true">
        @csrf

        {{-- Grupos definidos --}}
        @foreach($groups as $groupKey => $group)
        @php
            $groupSettings = collect($group['keys'])
                ->filter(fn($k) => $settingsByKey->has($k))
                ->values();
        @endphp
        @if($groupSettings->isNotEmpty())
        <div class="bg-white border border-slate-100 rounded-2xl overflow-hidden shadow-sm" x-data="{ open: true }">
            <button type="button" @click="open = !open"
                    class="w-full flex items-center justify-between px-6 py-4 hover:bg-slate-50 transition-colors text-left">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 bg-blue-50 text-blue-600 rounded-lg flex items-center justify-center text-sm">
                        <i class="fa-solid {{ $group['icon'] }}"></i>
                    </div>
                    <p class="text-slate-900 text-sm font-semibold">{{ $group['label'] }}</p>
                </div>
                <i class="fa-solid fa-chevron-down text-slate-300 text-xs transition-transform duration-200"
                   :class="open ? 'rotate-180' : ''"></i>
            </button>

            <div x-show="open" x-transition class="border-t border-slate-100 px-6 py-5 space-y-4">
                @foreach($groupSettings as $key)
                @php
                    $setting = $settingsByKey->get($key);
                    $meta = $fieldMap[$key] ?? [ucwords(str_replace('_',' ',$key)), null, 'text'];
                @endphp
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">{{ $meta[0] }}</label>
                    @if($meta[1])
                    <p class="text-xs text-slate-400 mb-1.5">{{ $meta[1] }}</p>
                    @endif
                    @if($meta[2] === 'textarea')
                    <textarea name="settings[{{ $key }}]" rows="3"
                              class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/10 transition-all resize-none">{{ $setting->value }}</textarea>
                    @else
                    <input type="{{ $meta[2] }}"
                           name="settings[{{ $key }}]"
                           value="{{ $setting->value }}"
                           class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/10 transition-all">
                    @endif
                </div>
                @endforeach
            </div>
        </div>
        @endif
        @endforeach

        {{-- Settings sin grupo (raw) --}}
        @if($ungroupedKeys->isNotEmpty())
        <div class="bg-white border border-slate-100 rounded-2xl overflow-hidden shadow-sm" x-data="{ open: false }">
            <button type="button" @click="open = !open"
                    class="w-full flex items-center justify-between px-6 py-4 hover:bg-slate-50 transition-colors text-left">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 bg-slate-50 text-slate-500 rounded-lg flex items-center justify-center text-sm">
                        <i class="fa-solid fa-ellipsis"></i>
                    </div>
                    <p class="text-slate-900 text-sm font-semibold">Otros ajustes</p>
                    <span class="text-xs text-slate-400 bg-slate-100 px-2 py-0.5 rounded-full">{{ $ungroupedKeys->count() }}</span>
                </div>
                <i class="fa-solid fa-chevron-down text-slate-300 text-xs transition-transform duration-200"
                   :class="open ? 'rotate-180' : ''"></i>
            </button>

            <div x-show="open" x-transition class="border-t border-slate-100 px-6 py-5 space-y-4">
                @foreach($ungroupedKeys as $key)
                @php $setting = $settingsByKey->get($key); @endphp
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5 capitalize">
                        {{ str_replace('_', ' ', $key) }}
                    </label>
                    <input type="text"
                           name="settings[{{ $key }}]"
                           value="{{ $setting->value }}"
                           class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/10 transition-all">
                </div>
                @endforeach
            </div>
        </div>
        @endif

        {{-- Submit --}}
        <div class="flex justify-end pt-2">
            <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-8 py-3 rounded-xl transition-colors flex items-center gap-2 shadow-sm">
                <i class="fa-solid fa-floppy-disk"></i> Guardar configuración
            </button>
        </div>
    </form>
</div>

@endsection
