@extends('layouts.admin')

@section('title', 'Servicios')
@section('page-title', 'Servicios')
@section('page-subtitle', 'Gestiona el catálogo de servicios')

@section('content')

@php
$categories = [
    'reparaciones'           => 'Reparaciones',
    'redes'                  => 'Redes',
    'servicios-it-presenciales' => 'IT Presencial',
    'servicios-it-remotos'   => 'IT Remoto',
];
@endphp

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- FORMULARIO NUEVO SERVICIO --}}
    <div class="bg-white border border-slate-100 rounded-2xl p-6 self-start lg:sticky lg:top-6">
        <h3 class="text-slate-900 text-sm font-semibold mb-5 flex items-center gap-2">
            <i class="fa-solid fa-plus text-blue-500 text-xs"></i> Nuevo servicio
        </h3>
        <form method="POST" action="{{ route('admin.services.store') }}" enctype="multipart/form-data" class="space-y-3">
            @csrf

            {{-- Preview imagen --}}
            <div id="new-preview-wrap" class="hidden rounded-xl overflow-hidden border border-slate-100 aspect-video bg-slate-50">
                <img id="new-preview" src="" alt="Preview" class="w-full h-full object-cover">
            </div>

            <div>
                <label class="block text-xs font-medium text-slate-500 mb-1.5">Nombre *</label>
                <input type="text" name="name" required placeholder="Ej: Reparación de laptops"
                       class="w-full border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm focus:outline-none focus:border-blue-400 focus:ring-1 focus:ring-blue-400/20 transition-colors">
            </div>
            <div>
                <label class="block text-xs font-medium text-slate-500 mb-1.5">Categoría</label>
                <select name="category" class="w-full border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm focus:outline-none focus:border-blue-400 transition-colors">
                    @foreach($categories as $val => $label)
                    <option value="{{ $val }}">{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs font-medium text-slate-500 mb-1.5">Descripción</label>
                <textarea name="description" rows="3" placeholder="Describe brevemente el servicio…"
                          class="w-full border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm focus:outline-none focus:border-blue-400 focus:ring-1 focus:ring-blue-400/20 transition-colors resize-none"></textarea>
            </div>
            <div>
                <label class="block text-xs font-medium text-slate-500 mb-1.5">Precio desde ($)</label>
                <div class="flex items-center border border-slate-200 rounded-xl overflow-hidden focus-within:border-blue-400 focus-within:ring-1 focus-within:ring-blue-400/20 transition-colors">
                    <span class="px-3 py-2.5 bg-slate-50 text-slate-400 text-sm border-r border-slate-200 flex-shrink-0">$</span>
                    <input type="number" name="price" min="0" step="0.01" placeholder="0.00"
                           class="flex-1 px-3 py-2.5 text-sm focus:outline-none">
                </div>
            </div>

            {{-- Imagen: tabs archivo / URL --}}
            <div>
                <label class="block text-xs font-medium text-slate-500 mb-1.5">Imagen</label>
                <div class="flex rounded-xl border border-slate-200 overflow-hidden text-xs mb-2">
                    <button type="button" onclick="setImgMode('file','new')"
                            id="new-tab-file"
                            class="img-tab flex-1 py-2 font-medium bg-blue-500 text-white transition-colors">
                        <i class="fa-solid fa-upload mr-1"></i> Archivo
                    </button>
                    <button type="button" onclick="setImgMode('url','new')"
                            id="new-tab-url"
                            class="img-tab flex-1 py-2 font-medium text-slate-500 hover:bg-slate-50 transition-colors">
                        <i class="fa-solid fa-link mr-1"></i> URL
                    </button>
                </div>
                <div id="new-file-wrap">
                    <input type="file" name="image" accept="image/*" onchange="previewImg(this,'new')"
                           class="w-full text-sm text-slate-500 border border-slate-200 rounded-xl px-3 py-2 cursor-pointer">
                </div>
                <div id="new-url-wrap" class="hidden">
                    <input type="url" name="image_url" placeholder="https://images.unsplash.com/..."
                           oninput="previewUrl(this,'new')"
                           class="w-full border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm focus:outline-none focus:border-blue-400 focus:ring-1 focus:ring-blue-400/20 transition-colors">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-medium text-slate-500 mb-1.5">Orden</label>
                    <input type="number" name="order" value="0" min="0"
                           class="w-full border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm focus:outline-none focus:border-blue-400 transition-colors">
                    <p class="text-xs text-slate-400 mt-1">Menor = aparece primero</p>
                </div>
                <div>
                    <label class="block text-xs font-medium text-slate-500 mb-1.5">Estado</label>
                    <select name="active" class="w-full border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm focus:outline-none focus:border-blue-400 transition-colors">
                        <option value="1">✅ Activo</option>
                        <option value="0">❌ Inactivo</option>
                    </select>
                </div>
            </div>
            <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold py-2.5 rounded-xl transition-colors">
                <i class="fa-solid fa-plus mr-1"></i> Agregar servicio
            </button>
        </form>
    </div>

    {{-- LISTA --}}
    <div class="lg:col-span-2 flex flex-col gap-4">
        <p class="text-slate-400 text-sm">{{ $services->count() }} {{ $services->count() === 1 ? 'servicio' : 'servicios' }} registrados</p>

        @forelse($services as $service)
        <div class="bg-white border border-slate-100 rounded-2xl overflow-hidden">
            <div class="flex">
                {{-- Imagen preview --}}
                <div class="w-36 flex-shrink-0 bg-slate-50">
                    @if($service->image_src)
                    <img src="{{ $service->image_src }}" alt="{{ $service->name }}"
                         class="w-full h-full object-cover" style="min-height:144px;" loading="lazy">
                    @else
                    <div class="w-full flex items-center justify-center" style="min-height:144px;">
                        <i class="fa-solid fa-image text-slate-200 text-3xl"></i>
                    </div>
                    @endif
                </div>

                {{-- Form --}}
                <div class="flex-1 p-4">
                    {{-- Header --}}
                    <div class="flex items-center gap-2 mb-3 flex-wrap">
                        <span class="w-2 h-2 rounded-full {{ $service->active ? 'bg-emerald-400' : 'bg-slate-300' }}"></span>
                        <span class="text-slate-900 text-sm font-semibold">{{ $service->name }}</span>
                        <span class="text-xs text-slate-500 bg-slate-100 px-2 py-0.5 rounded-full">
                            {{ $categories[$service->category] ?? $service->category }}
                        </span>
                        @if($service->price)
                        <span class="text-xs text-blue-600 bg-blue-50 border border-blue-100 px-2 py-0.5 rounded-full">
                            Desde ${{ $service->price }}
                        </span>
                        @endif
                    </div>

                    <form method="POST" action="{{ route('admin.services.update', $service) }}" enctype="multipart/form-data">
                        @csrf @method('PATCH')
                        <div class="grid grid-cols-2 gap-2.5 mb-2.5">
                            <div>
                                <label class="block text-xs text-slate-400 mb-1">Nombre *</label>
                                <input type="text" name="name" value="{{ $service->name }}" required
                                       class="w-full border border-slate-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-blue-400 transition-colors">
                            </div>
                            <div>
                                <label class="block text-xs text-slate-400 mb-1">Categoría</label>
                                <select name="category" class="w-full border border-slate-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-blue-400 transition-colors">
                                    @foreach($categories as $val => $label)
                                    <option value="{{ $val }}" {{ $service->category === $val ? 'selected' : '' }}>{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-span-2">
                                <label class="block text-xs text-slate-400 mb-1">Descripción</label>
                                <textarea name="description" rows="2"
                                          class="w-full border border-slate-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-blue-400 transition-colors resize-none">{{ $service->description }}</textarea>
                            </div>
                            <div>
                                <label class="block text-xs text-slate-400 mb-1">Precio ($)</label>
                                <div class="flex items-center border border-slate-200 rounded-lg overflow-hidden focus-within:border-blue-400 transition-colors">
                                    <span class="px-2 py-2 bg-slate-50 text-slate-400 text-xs border-r border-slate-200">$</span>
                                    <input type="number" name="price" value="{{ $service->price }}" min="0" step="0.01"
                                           class="flex-1 px-2 py-2 text-sm focus:outline-none">
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-2">
                                <div>
                                    <label class="block text-xs text-slate-400 mb-1">Orden</label>
                                    <input type="number" name="order" value="{{ $service->order }}"
                                           class="w-full border border-slate-200 rounded-lg px-2 py-2 text-sm focus:outline-none focus:border-blue-400 transition-colors">
                                </div>
                                <div>
                                    <label class="block text-xs text-slate-400 mb-1">Estado</label>
                                    <select name="active" class="w-full border border-slate-200 rounded-lg px-2 py-2 text-sm focus:outline-none focus:border-blue-400 transition-colors">
                                        <option value="1" {{ $service->active ? 'selected' : '' }}>✅ Activo</option>
                                        <option value="0" {{ !$service->active ? 'selected' : '' }}>❌ Inactivo</option>
                                    </select>
                                </div>
                            </div>

                            {{-- Imagen con tabs --}}
                            <div class="col-span-2">
                                <label class="block text-xs text-slate-400 mb-1">Imagen</label>
                                <div class="flex rounded-lg border border-slate-200 overflow-hidden text-xs mb-1.5">
                                    <button type="button" onclick="setImgMode('file','{{ $service->id }}')"
                                            id="{{ $service->id }}-tab-file"
                                            class="img-tab flex-1 py-1.5 font-medium bg-blue-500 text-white transition-colors">
                                        <i class="fa-solid fa-upload mr-1"></i> Nuevo archivo
                                    </button>
                                    <button type="button" onclick="setImgMode('url','{{ $service->id }}')"
                                            id="{{ $service->id }}-tab-url"
                                            class="img-tab flex-1 py-1.5 font-medium text-slate-500 hover:bg-slate-50 transition-colors">
                                        <i class="fa-solid fa-link mr-1"></i> URL externa
                                    </button>
                                </div>
                                <div id="{{ $service->id }}-file-wrap">
                                    <input type="file" name="image" accept="image/*"
                                           class="w-full text-xs text-slate-500 border border-slate-200 rounded-lg px-2 py-1.5 cursor-pointer">
                                </div>
                                <div id="{{ $service->id }}-url-wrap" class="hidden">
                                    <input type="url" name="image_url" value="{{ $service->image_url }}"
                                           placeholder="https://..."
                                           class="w-full border border-slate-200 rounded-lg px-3 py-1.5 text-sm focus:outline-none focus:border-blue-400 transition-colors">
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-between">
                            <form method="POST" action="{{ route('admin.services.destroy', $service) }}"
                                  onsubmit="return confirm('¿Eliminar {{ $service->name }}?')" class="inline">
                                @csrf @method('DELETE')
                                <button type="submit"
                                        class="text-xs text-red-400 hover:text-red-600 border border-red-100 bg-red-50 hover:bg-red-100 px-3 py-2 rounded-lg transition-colors">
                                    <i class="fa-solid fa-trash-can mr-1"></i> Eliminar
                                </button>
                            </form>
                            <button type="submit"
                                    class="bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold px-5 py-2 rounded-lg transition-colors">
                                <i class="fa-solid fa-floppy-disk mr-1"></i> Guardar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div class="bg-white border border-slate-100 rounded-2xl p-12 text-center">
            <i class="fa-solid fa-wrench text-slate-200 text-4xl mb-3 block"></i>
            <p class="text-slate-400 text-sm">No hay servicios registrados. Agrega el primero.</p>
        </div>
        @endforelse
    </div>
</div>

@endsection

@push('scripts')
<script>
function setImgMode(mode, id) {
    const fileWrap = document.getElementById(`${id}-file-wrap`);
    const urlWrap  = document.getElementById(`${id}-url-wrap`);
    const fileTab  = document.getElementById(`${id}-tab-file`);
    const urlTab   = document.getElementById(`${id}-tab-url`);
    if (!fileWrap) return;

    if (mode === 'file') {
        fileWrap.classList.remove('hidden');
        urlWrap.classList.add('hidden');
        fileTab.classList.add('bg-blue-500','text-white');
        fileTab.classList.remove('text-slate-500');
        urlTab.classList.remove('bg-blue-500','text-white');
        urlTab.classList.add('text-slate-500');
    } else {
        urlWrap.classList.remove('hidden');
        fileWrap.classList.add('hidden');
        urlTab.classList.add('bg-blue-500','text-white');
        urlTab.classList.remove('text-slate-500');
        fileTab.classList.remove('bg-blue-500','text-white');
        fileTab.classList.add('text-slate-500');
    }
}

function previewImg(input, id) {
    if (!input.files || !input.files[0]) return;
    const wrap = document.getElementById(`${id}-preview-wrap`);
    const img  = document.getElementById(`${id}-preview`);
    if (!wrap || !img) return;
    const url = URL.createObjectURL(input.files[0]);
    img.src = url;
    wrap.classList.remove('hidden');
}

function previewUrl(input, id) {
    const wrap = document.getElementById(`${id}-preview-wrap`);
    const img  = document.getElementById(`${id}-preview`);
    if (!wrap || !img) return;
    if (input.value) {
        img.src = input.value;
        wrap.classList.remove('hidden');
    } else {
        wrap.classList.add('hidden');
    }
}
</script>
@endpush
