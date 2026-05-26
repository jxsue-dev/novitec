@extends('layouts.admin')

@section('title', 'Servicios')
@section('page-title', 'Servicios')
@section('page-subtitle', 'Gestiona los servicios del catálogo')

@section('content')

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- FORMULARIO NUEVO SERVICIO --}}
    <div class="bg-white border border-slate-100 rounded-2xl p-6">
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
                        <option value="servicios-it-presenciales">Servicios IT Presenciales</option>
                        <option value="servicios-it-remotos">Servicios IT Remotos</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs text-slate-400 mb-1">Descripción</label>
                    <textarea name="description" rows="3"
                              class="w-full border border-slate-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-blue-400"></textarea>
                </div>
                <div>
                    <label class="block text-xs text-slate-400 mb-1">Precio (ej: Desde $15)</label>
                    <input type="text" name="price" placeholder="Desde $15"
                           class="w-full border border-slate-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-blue-400">
                </div>
                <div>
                    <label class="block text-xs text-slate-400 mb-1">Imagen (subir archivo)</label>
                    <input type="file" name="image" accept="image/*"
                           class="w-full text-sm text-slate-500 file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border file:border-slate-200 file:text-xs file:bg-slate-50">
                </div>
                <div>
                    <label class="block text-xs text-slate-400 mb-1">O pegar URL de imagen</label>
                    <input type="url" name="image_url" placeholder="https://..."
                           class="w-full border border-slate-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-blue-400">
                </div>
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
            <button type="submit"
                    class="mt-4 w-full text-xs bg-blue-50 hover:bg-blue-100 text-blue-600 border border-blue-100 px-3 py-2 rounded-lg transition-colors">
                Guardar servicio
            </button>
        </form>
    </div>

    {{-- LISTA DE SERVICIOS --}}
    <div class="lg:col-span-2 space-y-4">
        @forelse($services as $service)
        <div class="bg-white border border-slate-100 rounded-2xl p-6">
            <div class="flex gap-4">
                {{-- IMAGEN --}}
                @if($service->image_src)
                <img src="{{ $service->image_src }}" alt="{{ $service->name }}"
                     class="w-24 h-24 object-cover rounded-xl flex-shrink-0">
                @else
                <div class="w-24 h-24 bg-slate-100 rounded-xl flex items-center justify-center flex-shrink-0">
                    <span class="text-slate-300 text-xs">Sin imagen</span>
                </div>
                @endif

                <div class="flex-1">
                    <form method="POST" action="{{ route('admin.services.update', $service) }}" enctype="multipart/form-data">
                        @csrf @method('PATCH')
                        <div class="grid grid-cols-2 gap-3">
                            <div class="col-span-2 flex items-center justify-between mb-1">
                                <div class="flex items-center gap-2">
                                    <span class="w-2 h-2 bg-{{ $service->active ? 'emerald' : 'slate' }}-400 rounded-full"></span>
                                    <span class="text-sm font-semibold text-slate-900">{{ $service->name }}</span>
                                </div>
                                <button type="submit"
                                        class="text-xs bg-blue-50 hover:bg-blue-100 text-blue-600 border border-blue-100 px-3 py-1.5 rounded-lg transition-colors">
                                    Guardar
                                </button>
                            </div>
                            <div class="col-span-2">
                                <label class="block text-xs text-slate-400 mb-1">Nombre</label>
                                <input type="text" name="name" value="{{ $service->name }}" required
                                       class="w-full border border-slate-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-blue-400">
                            </div>
                            <div class="col-span-2">
                                <label class="block text-xs text-slate-400 mb-1">Categoría</label>
                                <select name="category" class="w-full border border-slate-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-blue-400">
                                    <option value="reparaciones" {{ $service->category === 'reparaciones' ? 'selected' : '' }}>Reparaciones</option>
                                    <option value="redes" {{ $service->category === 'redes' ? 'selected' : '' }}>Redes</option>
                                    <option value="servicios-it-presenciales" {{ $service->category === 'servicios-it-presenciales' ? 'selected' : '' }}>Servicios IT Presenciales</option>
                                    <option value="servicios-it-remotos" {{ $service->category === 'servicios-it-remotos' ? 'selected' : '' }}>Servicios IT Remotos</option>
                                </select>
                            </div>
                            <div class="col-span-2">
                                <label class="block text-xs text-slate-400 mb-1">Descripción</label>
                                <textarea name="description" rows="2"
                                          class="w-full border border-slate-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-blue-400">{{ $service->description }}</textarea>
                            </div>
                            <div>
                                <label class="block text-xs text-slate-400 mb-1">Precio</label>
                                <input type="text" name="price" value="{{ $service->price }}"
                                       class="w-full border border-slate-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-blue-400">
                            </div>
                            <div>
                                <label class="block text-xs text-slate-400 mb-1">Orden</label>
                                <input type="number" name="order" value="{{ $service->order }}"
                                       class="w-full border border-slate-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-blue-400">
                            </div>
                            <div>
                                <label class="block text-xs text-slate-400 mb-1">Nueva imagen</label>
                                <input type="file" name="image" accept="image/*"
                                       class="w-full text-sm text-slate-500 file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border file:border-slate-200 file:text-xs file:bg-slate-50">
                            </div>
                            <div>
                                <label class="block text-xs text-slate-400 mb-1">O URL de imagen</label>
                                <input type="url" name="image_url" value="{{ $service->image_url }}"
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
                    </form>
                </div>
            </div>

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
        @empty
        <div class="bg-white border border-slate-100 rounded-2xl p-8 text-center text-slate-400 text-sm font-light">
            No hay servicios registrados.
        </div>
        @endforelse
    </div>
</div>

@endsection
