@extends('layouts.admin')

@section('title', 'Servicios')
@section('page-title', 'Servicios')
@section('page-subtitle', 'Gestiona los servicios del catálogo')

@section('content')

<div class="grid grid-cols-1 lg:grid-cols-4 gap-6">

    {{-- FORMULARIO NUEVO SERVICIO --}}
    <div class="lg:col-span-1">
        <div class="bg-white border border-slate-100 rounded-2xl p-6 sticky top-24">
            <h3 class="text-slate-900 text-sm font-semibold mb-5">Nuevo servicio</h3>
            <form method="POST" action="{{ route('admin.services.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="space-y-3">
                    <div>
                        <label class="block text-xs text-slate-400 mb-1">Nombre</label>
                        <input type="text" name="name" required
                               class="w-full border border-slate-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-blue-400">
                    </div>
                    <div>
                        <label class="block text-xs text-slate-400 mb-1">Categoría</label>
                        <select name="category" class="w-full border border-slate-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-blue-400">
                            <option value="reparaciones">Reparaciones</option>
                            <option value="redes">Redes</option>
                            <option value="servicios-it-presenciales">IT Presencial</option>
                            <option value="servicios-it-remotos">IT Remoto</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs text-slate-400 mb-1">Descripción</label>
                        <textarea name="description" rows="3"
                                  class="w-full border border-slate-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-blue-400"></textarea>
                    </div>
                    <div>
                        <label class="block text-xs text-slate-400 mb-1">Precio</label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-sm">Desde $</span>
                            <input type="number" name="price" min="0" step="0.01"
                                   class="w-full border border-slate-200 rounded-lg pl-16 pr-3 py-2 text-sm focus:outline-none focus:border-blue-400">
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs text-slate-400 mb-1">Imagen (archivo)</label>
                        <input type="file" name="image" accept="image/*"
                               class="w-full text-sm text-slate-500 file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border file:border-slate-200 file:text-xs file:bg-slate-50">
                    </div>
                    <div>
                        <label class="block text-xs text-slate-400 mb-1">O URL de imagen</label>
                        <input type="url" name="image_url" placeholder="https://..."
                               class="w-full border border-slate-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-blue-400">
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs text-slate-400 mb-1">Orden</label>
                            <input type="number" name="order" value="0"
                                   class="w-full border border-slate-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-blue-400">
                        </div>
                        <div>
                            <label class="block text-xs text-slate-400 mb-1">Activo</label>
                            <select name="active" class="w-full border border-slate-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-blue-400">
                                <option value="1">Sí</option>
                                <option value="0">No</option>
                            </select>
                        </div>
                    </div>
                </div>
                <button type="submit"
                        class="mt-4 w-full text-sm bg-blue-600 hover:bg-blue-700 text-white px-3 py-2.5 rounded-xl transition-colors font-medium">
                    + Agregar servicio
                </button>
            </form>
        </div>
    </div>

    {{-- LISTA DE SERVICIOS --}}
    <div class="lg:col-span-3 space-y-4">

        {{-- CONTADOR --}}
        <div class="flex items-center justify-between">
            <p class="text-slate-400 text-sm">{{ $services->count() }} {{ $services->count() === 1 ? 'servicio' : 'servicios' }} registrados</p>
        </div>

        @forelse($services as $service)
        <div class="bg-white border border-slate-100 rounded-2xl overflow-hidden">
            <div class="flex gap-0">
                {{-- IMAGEN --}}
                <div class="w-40 flex-shrink-0">
                    @if($service->image_src)
                    <img src="{{ $service->image_src }}" alt="{{ $service->name }}"
                         class="w-full h-full object-cover" style="min-height:160px">
                    @else
                    <div class="w-full h-full bg-slate-50 flex items-center justify-center" style="min-height:160px">
                        <svg class="w-8 h-8 text-slate-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    @endif
                </div>

                {{-- FORM EDITAR --}}
                <div class="flex-1 p-5">
                    <form method="POST" action="{{ route('admin.services.update', $service) }}" enctype="multipart/form-data">
                        @csrf @method('PATCH')
                        <div class="grid grid-cols-2 gap-3">

                            {{-- HEADER --}}
                            <div class="col-span-2 flex items-center justify-between mb-1">
                                <div class="flex items-center gap-2">
                                    <span class="w-2 h-2 rounded-full bg-{{ $service->active ? 'emerald' : 'slate' }}-400"></span>
                                    <span class="text-sm font-semibold text-slate-800">{{ $service->name }}</span>
                                    <span class="text-xs text-slate-400 bg-slate-50 border border-slate-100 px-2 py-0.5 rounded-full">
                                        {{ ucwords(str_replace('-', ' ', $service->category)) }}
                                    </span>
                                    @if($service->price)
                                    <span class="text-xs text-blue-600 bg-blue-50 border border-blue-100 px-2 py-0.5 rounded-full">
                                        Desde ${{ $service->price }}
                                    </span>
                                    @endif
                                </div>
                                <div class="flex gap-2">
                                    <button type="submit"
                                            class="text-xs bg-blue-50 hover:bg-blue-100 text-blue-600 border border-blue-100 px-3 py-1.5 rounded-lg transition-colors">
                                        Guardar
                                    </button>
                                </div>
                            </div>

                            {{-- NOMBRE --}}
                            <div>
                                <label class="block text-xs text-slate-400 mb-1">Nombre</label>
                                <input type="text" name="name" value="{{ $service->name }}" required
                                       class="w-full border border-slate-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-blue-400">
                            </div>

                            {{-- CATEGORÍA --}}
                            <div>
                                <label class="block text-xs text-slate-400 mb-1">Categoría</label>
                                <select name="category" class="w-full border border-slate-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-blue-400">
                                    <option value="reparaciones" {{ $service->category === 'reparaciones' ? 'selected' : '' }}>Reparaciones</option>
                                    <option value="redes" {{ $service->category === 'redes' ? 'selected' : '' }}>Redes</option>
                                    <option value="servicios-it-presenciales" {{ $service->category === 'servicios-it-presenciales' ? 'selected' : '' }}>IT Presencial</option>
                                    <option value="servicios-it-remotos" {{ $service->category === 'servicios-it-remotos' ? 'selected' : '' }}>IT Remoto</option>
                                </select>
                            </div>

                            {{-- DESCRIPCIÓN --}}
                            <div class="col-span-2">
                                <label class="block text-xs text-slate-400 mb-1">Descripción</label>
                                <textarea name="description" rows="2"
                                          class="w-full border border-slate-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-blue-400">{{ $service->description }}</textarea>
                            </div>

                            {{-- PRECIO --}}
                            <div>
                                <label class="block text-xs text-slate-400 mb-1">Precio</label>
                                <div class="relative">
                                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-sm">Desde $</span>
                                    <input type="number" name="price" value="{{ $service->price }}" min="0" step="0.01"
                                           class="w-full border border-slate-200 rounded-lg pl-16 pr-3 py-2 text-sm focus:outline-none focus:border-blue-400">
                                </div>
                            </div>

                            {{-- ORDEN Y ACTIVO --}}
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-xs text-slate-400 mb-1">Orden</label>
                                    <input type="number" name="order" value="{{ $service->order }}"
                                           class="w-full border border-slate-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-blue-400">
                                </div>
                                <div>
                                    <label class="block text-xs text-slate-400 mb-1">Activo</label>
                                    <select name="active" class="w-full border border-slate-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-blue-400">
                                        <option value="1" {{ $service->active ? 'selected' : '' }}>Sí</option>
                                        <option value="0" {{ !$service->active ? 'selected' : '' }}>No</option>
                                    </select>
                                </div>
                            </div>

                            {{-- IMAGEN --}}
                            <div>
                                <label class="block text-xs text-slate-400 mb-1">Nueva imagen</label>
                                <input type="file" name="image" accept="image/*"
                                       class="w-full text-sm text-slate-500 file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border file:border-slate-200 file:text-xs file:bg-slate-50">
                            </div>

                            {{-- URL IMAGEN --}}
                            <div>
                                <label class="block text-xs text-slate-400 mb-1">O URL de imagen</label>
                                <input type="url" name="image_url" value="{{ $service->image_url }}"
                                       class="w-full border border-slate-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-blue-400">
                            </div>
                        </div>
                    </form>

                    {{-- ELIMINAR --}}
                    <div class="mt-3 flex justify-end">
                        <form method="POST" action="{{ route('admin.services.destroy', $service) }}"
                              onsubmit="return confirm('¿Eliminar este servicio?')">
                            @csrf @method('DELETE')
                            <button type="submit"
                                    class="text-xs bg-red-50 hover:bg-red-100 text-red-500 border border-red-100 px-3 py-1.5 rounded-lg transition-colors">
                                Eliminar
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="bg-white border border-slate-100 rounded-2xl p-12 text-center">
            <svg class="w-10 h-10 text-slate-200 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
            </svg>
            <p class="text-slate-400 text-sm font-light">No hay servicios registrados aún.</p>
        </div>
        @endforelse
    </div>
</div>

@endsection
