@extends('layouts.admin')

@section('title', 'Servicios')
@section('page-title', 'Servicios')
@section('page-subtitle', 'Gestiona el catálogo de servicios')

@section('content')

@php
$categories = [
    'reparaciones'              => 'Reparaciones',
    'redes'                     => 'Redes',
    'servicios-it-presenciales' => 'IT Presencial',
    'servicios-it-remotos'      => 'IT Remoto',
];
@endphp

<div class="max-w-3xl mx-auto space-y-3" x-data="{ newOpen: false }">

    {{-- HEADER --}}
    <div class="flex items-center justify-between mb-2">
        <p class="text-slate-400 text-sm">{{ $services->count() }} {{ $services->count() === 1 ? 'servicio' : 'servicios' }}</p>
        <button @click="newOpen = !newOpen"
                class="flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-5 py-2.5 rounded-xl transition-all">
            <i class="fa-solid fa-plus text-xs"></i> Nuevo servicio
        </button>
    </div>

    {{-- FORM NUEVO (colapsable) --}}
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
                <p class="text-blue-900 text-sm font-semibold">Nuevo servicio</p>
            </div>
            <button @click="newOpen = false" type="button"
                    class="text-blue-400 hover:text-blue-600 w-7 h-7 flex items-center justify-center rounded-lg hover:bg-blue-100 transition-colors">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <form method="POST" action="{{ route('admin.services.store') }}" enctype="multipart/form-data" class="p-5">
            @csrf

            {{-- Preview imagen --}}
            <div id="new-preview-wrap" class="hidden mb-4 rounded-xl overflow-hidden border border-slate-100 aspect-video bg-slate-50">
                <img id="new-preview" src="" alt="Preview" class="w-full h-full object-cover">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="sm:col-span-2">
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">Nombre del servicio *</label>
                    <input type="text" name="name" required autofocus placeholder="Ej: Reparación de laptops"
                           class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/10 transition-all">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">Categoría</label>
                    <select name="category" class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-blue-500 transition-all">
                        @foreach($categories as $val => $label)
                        <option value="{{ $val }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">Precio desde ($)</label>
                    <div class="flex items-center border border-slate-200 rounded-xl overflow-hidden focus-within:border-blue-500 focus-within:ring-2 focus-within:ring-blue-500/10 transition-all">
                        <span class="px-3 py-3 bg-slate-50 text-slate-400 text-sm border-r border-slate-200 flex-shrink-0">$</span>
                        <input type="number" name="price" min="0" step="0.01" placeholder="0.00"
                               class="flex-1 px-3 py-3 text-sm focus:outline-none">
                    </div>
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">Descripción</label>
                    <textarea name="description" rows="3" placeholder="Describe brevemente el servicio…"
                              class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/10 transition-all resize-none"></textarea>
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">Imagen</label>
                    <div class="flex rounded-xl border border-slate-200 overflow-hidden text-xs mb-2">
                        <button type="button" onclick="setImgMode('file','new')" id="new-tab-file"
                                class="flex-1 py-2.5 font-semibold bg-blue-500 text-white transition-colors">
                            <i class="fa-solid fa-upload mr-1"></i> Subir archivo
                        </button>
                        <button type="button" onclick="setImgMode('url','new')" id="new-tab-url"
                                class="flex-1 py-2.5 font-semibold text-slate-500 hover:bg-slate-50 transition-colors">
                            <i class="fa-solid fa-link mr-1"></i> URL externa
                        </button>
                    </div>
                    <div id="new-file-wrap">
                        <input type="file" name="image" accept="image/*" onchange="previewImg(this,'new')"
                               class="w-full text-sm text-slate-500 border border-slate-200 rounded-xl px-4 py-3 cursor-pointer">
                    </div>
                    <div id="new-url-wrap" class="hidden">
                        <input type="url" name="image_url" placeholder="https://images.unsplash.com/..."
                               oninput="previewUrl(this,'new')"
                               class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-blue-500 transition-all">
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">Orden <span class="font-normal text-slate-400">(menor = primero)</span></label>
                    <input type="number" name="order" value="0" min="0"
                           class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-blue-500 transition-all">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">Estado</label>
                    <select name="active" class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-blue-500 transition-all">
                        <option value="1">✅ Activo</option>
                        <option value="0">❌ Inactivo</option>
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
                    <i class="fa-solid fa-floppy-disk"></i> Guardar servicio
                </button>
            </div>
        </form>
    </div>

    {{-- SERVICIOS EXISTENTES (acordeón) --}}
    @forelse($services as $service)
    <div class="bg-white border border-slate-100 rounded-2xl overflow-hidden shadow-sm" x-data="{ open: false }">

        {{-- HEADER COLAPSADO --}}
        <button @click="open = !open" type="button"
                class="w-full flex items-center gap-3 px-5 py-4 hover:bg-slate-50 transition-colors text-left">

            {{-- Thumbnail --}}
            <div class="w-12 h-12 rounded-xl overflow-hidden bg-slate-100 flex-shrink-0">
                @if($service->image_src)
                    <img src="{{ $service->image_src }}" alt="{{ $service->name }}" class="w-full h-full object-cover" loading="lazy">
                @else
                    <div class="w-full h-full flex items-center justify-center">
                        <i class="fa-solid fa-image text-slate-300 text-lg"></i>
                    </div>
                @endif
            </div>

            <div class="flex-1 min-w-0">
                <div class="flex items-center gap-2 flex-wrap">
                    <span class="w-2 h-2 rounded-full flex-shrink-0 {{ $service->active ? 'bg-emerald-400' : 'bg-slate-300' }}"></span>
                    <p class="text-slate-900 text-sm font-semibold truncate">{{ $service->name }}</p>
                    <span class="text-xs text-slate-500 bg-slate-100 px-2 py-0.5 rounded-full flex-shrink-0">
                        {{ $categories[$service->category] ?? $service->category }}
                    </span>
                    @if($service->price)
                    <span class="text-xs text-blue-600 bg-blue-50 border border-blue-100 px-2 py-0.5 rounded-full flex-shrink-0">
                        Desde ${{ $service->price }}
                    </span>
                    @endif
                </div>
                @if($service->description)
                <p class="text-xs text-slate-400 truncate mt-0.5">{{ $service->description }}</p>
                @endif
            </div>

            <div class="flex items-center gap-2 flex-shrink-0">
                <span class="text-xs px-2.5 py-1 rounded-full font-medium {{ $service->active ? 'bg-emerald-50 text-emerald-600' : 'bg-slate-100 text-slate-400' }}">
                    {{ $service->active ? 'Activo' : 'Inactivo' }}
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

            <form method="POST" action="{{ route('admin.services.update', $service) }}" enctype="multipart/form-data" class="p-5">
                @csrf @method('PATCH')

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">Nombre *</label>
                        <input type="text" name="name" value="{{ $service->name }}" required
                               class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/10 transition-all">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">Categoría</label>
                        <select name="category" class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-blue-500 transition-all">
                            @foreach($categories as $val => $label)
                            <option value="{{ $val }}" {{ $service->category === $val ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">Precio desde ($)</label>
                        <div class="flex items-center border border-slate-200 rounded-xl overflow-hidden focus-within:border-blue-500 focus-within:ring-2 focus-within:ring-blue-500/10 transition-all">
                            <span class="px-3 py-3 bg-slate-50 text-slate-400 text-sm border-r border-slate-200 flex-shrink-0">$</span>
                            <input type="number" name="price" value="{{ $service->price }}" min="0" step="0.01"
                                   class="flex-1 px-3 py-3 text-sm focus:outline-none">
                        </div>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">Descripción</label>
                        <textarea name="description" rows="3"
                                  class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/10 transition-all resize-none">{{ $service->description }}</textarea>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">Imagen</label>
                        <div class="flex rounded-xl border border-slate-200 overflow-hidden text-xs mb-2">
                            <button type="button" onclick="setImgMode('file','{{ $service->id }}')" id="{{ $service->id }}-tab-file"
                                    class="flex-1 py-2.5 font-semibold bg-blue-500 text-white transition-colors">
                                <i class="fa-solid fa-upload mr-1"></i> Nuevo archivo
                            </button>
                            <button type="button" onclick="setImgMode('url','{{ $service->id }}')" id="{{ $service->id }}-tab-url"
                                    class="flex-1 py-2.5 font-semibold text-slate-500 hover:bg-slate-50 transition-colors">
                                <i class="fa-solid fa-link mr-1"></i> URL externa
                            </button>
                        </div>
                        <div id="{{ $service->id }}-file-wrap">
                            <input type="file" name="image" accept="image/*"
                                   class="w-full text-sm text-slate-500 border border-slate-200 rounded-xl px-4 py-3 cursor-pointer">
                        </div>
                        <div id="{{ $service->id }}-url-wrap" class="hidden">
                            <input type="url" name="image_url" value="{{ $service->image_url }}" placeholder="https://..."
                                   class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-blue-500 transition-all">
                        </div>
                        @if($service->image_src)
                        <p class="text-xs text-slate-400 mt-1.5">
                            <i class="fa-solid fa-circle-info mr-1"></i>
                            Imagen actual: <a href="{{ $service->image_src }}" target="_blank" class="text-blue-500 hover:underline">ver</a>
                        </p>
                        @endif
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">Orden <span class="font-normal text-slate-400">(menor = primero)</span></label>
                        <input type="number" name="order" value="{{ $service->order }}" min="0"
                               class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-blue-500 transition-all">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">Estado</label>
                        <select name="active" class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-blue-500 transition-all">
                            <option value="1" {{ $service->active ? 'selected' : '' }}>✅ Activo</option>
                            <option value="0" {{ !$service->active ? 'selected' : '' }}>❌ Inactivo</option>
                        </select>
                    </div>
                </div>

                <div class="flex items-center justify-between mt-5 pt-4 border-t border-slate-100">
                    <form method="POST" action="{{ route('admin.services.destroy', $service) }}"
                          onsubmit="return confirm('¿Eliminar {{ addslashes($service->name) }}?')" class="inline">
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
        <i class="fa-solid fa-wrench text-slate-200 text-5xl mb-4 block"></i>
        <p class="text-slate-500 text-sm font-medium mb-1">Sin servicios registrados</p>
        <p class="text-slate-400 text-xs mb-5">Crea el primero usando el botón de arriba.</p>
        <button @click="newOpen = true"
                class="text-sm text-blue-600 border border-blue-200 hover:bg-blue-50 px-5 py-2.5 rounded-xl transition-colors">
            <i class="fa-solid fa-plus mr-1"></i> Nuevo servicio
        </button>
    </div>
    @endforelse
</div>

@endsection

@push('scripts')
<script>
function setImgMode(mode, id) {
    const fw = document.getElementById(`${id}-file-wrap`);
    const uw = document.getElementById(`${id}-url-wrap`);
    const ft = document.getElementById(`${id}-tab-file`);
    const ut = document.getElementById(`${id}-tab-url`);
    if (!fw) return;
    if (mode === 'file') {
        fw.classList.remove('hidden'); uw.classList.add('hidden');
        ft.classList.add('bg-blue-500','text-white'); ft.classList.remove('text-slate-500');
        ut.classList.remove('bg-blue-500','text-white'); ut.classList.add('text-slate-500');
    } else {
        uw.classList.remove('hidden'); fw.classList.add('hidden');
        ut.classList.add('bg-blue-500','text-white'); ut.classList.remove('text-slate-500');
        ft.classList.remove('bg-blue-500','text-white'); ft.classList.add('text-slate-500');
    }
}
function previewImg(input, id) {
    if (!input.files?.[0]) return;
    const wrap = document.getElementById(`${id}-preview-wrap`);
    const img  = document.getElementById(`${id}-preview`);
    if (!wrap || !img) return;
    img.src = URL.createObjectURL(input.files[0]);
    wrap.classList.remove('hidden');
}
function previewUrl(input, id) {
    const wrap = document.getElementById(`${id}-preview-wrap`);
    const img  = document.getElementById(`${id}-preview`);
    if (!wrap || !img) return;
    if (input.value) { img.src = input.value; wrap.classList.remove('hidden'); }
    else wrap.classList.add('hidden');
}
</script>
@endpush
