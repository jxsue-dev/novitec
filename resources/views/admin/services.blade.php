@extends('layouts.admin')

@section('title', 'Servicios')
@section('page-title', 'Servicios')
@section('page-subtitle', 'Gestiona los servicios del catálogo')

@section('content')

<div style="display:grid;grid-template-columns:300px 1fr;gap:24px;align-items:start;">

    {{-- FORMULARIO NUEVO SERVICIO --}}
    <div class="bg-white border border-slate-100 rounded-2xl p-6" style="position:sticky;top:24px;">
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
                    <div style="display:flex;align-items:center;border:1px solid #e2e8f0;border-radius:8px;overflow:hidden;">
                        <span style="padding:8px 12px;background:#f8fafc;color:#94a3b8;font-size:13px;border-right:1px solid #e2e8f0;white-space:nowrap;">Desde $</span>
                        <input type="number" name="price" min="0" step="0.01"
                               style="flex:1;border:none;padding:8px 12px;font-size:13px;outline:none;">
                    </div>
                </div>
                <div>
                    <label class="block text-xs text-slate-400 mb-1">Imagen (archivo)</label>
                    <input type="file" name="image" accept="image/*"
                           class="w-full text-sm text-slate-500">
                </div>
                <div>
                    <label class="block text-xs text-slate-400 mb-1">O URL de imagen</label>
                    <input type="url" name="image_url" placeholder="https://..."
                           class="w-full border border-slate-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-blue-400">
                </div>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
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
                    style="margin-top:16px;width:100%;background:#2563eb;color:#fff;border:none;padding:10px;border-radius:10px;font-size:13px;font-weight:600;cursor:pointer;">
                + Agregar servicio
            </button>
        </form>
    </div>

    {{-- LISTA DE SERVICIOS --}}
    <div style="display:flex;flex-direction:column;gap:16px;">

        <p class="text-slate-400 text-sm">{{ $services->count() }} {{ $services->count() === 1 ? 'servicio' : 'servicios' }} registrados</p>

        @forelse($services as $service)
        <div class="bg-white border border-slate-100 rounded-2xl" style="overflow:hidden;">
            <div style="display:flex;">
                {{-- IMAGEN --}}
                <div style="width:160px;flex-shrink:0;">
                    @if($service->image_src)
                    <img src="{{ $service->image_src }}" alt="{{ $service->name }}"
                         style="width:100%;height:100%;object-fit:cover;min-height:160px;">
                    @else
                    <div style="width:100%;min-height:160px;background:#f8fafc;display:flex;align-items:center;justify-content:center;">
                        <svg style="width:32px;height:32px;color:#e2e8f0;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    @endif
                </div>

                {{-- FORM EDITAR --}}
                <div style="flex:1;padding:20px;">
                    <form method="POST" action="{{ route('admin.services.update', $service) }}" enctype="multipart/form-data">
                        @csrf @method('PATCH')

                        {{-- HEADER --}}
                        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:12px;">
                            <div style="display:flex;align-items:center;gap:8px;flex-wrap:wrap;">
                                <span style="width:8px;height:8px;border-radius:50%;background:{{ $service->active ? '#34d399' : '#94a3b8' }};display:inline-block;"></span>
                                <span style="font-size:14px;font-weight:600;color:#0f172a;">{{ $service->name }}</span>
                                <span style="font-size:11px;color:#64748b;background:#f8fafc;border:1px solid #e2e8f0;padding:2px 8px;border-radius:20px;">
                                    {{ ucwords(str_replace('-', ' ', $service->category)) }}
                                </span>
                                @if($service->price)
                                <span style="font-size:11px;color:#2563eb;background:#eff6ff;border:1px solid #bfdbfe;padding:2px 8px;border-radius:20px;">
                                    Desde ${{ $service->price }}
                                </span>
                                @endif
                            </div>
                            <button type="submit"
                                    style="font-size:12px;background:#eff6ff;color:#2563eb;border:1px solid #bfdbfe;padding:6px 12px;border-radius:8px;cursor:pointer;">
                                Guardar
                            </button>
                        </div>

                        <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
                            <div>
                                <label class="block text-xs text-slate-400 mb-1">Nombre</label>
                                <input type="text" name="name" value="{{ $service->name }}" required
                                       class="w-full border border-slate-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-blue-400">
                            </div>
                            <div>
                                <label class="block text-xs text-slate-400 mb-1">Categoría</label>
                                <select name="category" class="w-full border border-slate-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-blue-400">
                                    <option value="reparaciones" {{ $service->category === 'reparaciones' ? 'selected' : '' }}>Reparaciones</option>
                                    <option value="redes" {{ $service->category === 'redes' ? 'selected' : '' }}>Redes</option>
                                    <option value="servicios-it-presenciales" {{ $service->category === 'servicios-it-presenciales' ? 'selected' : '' }}>IT Presencial</option>
                                    <option value="servicios-it-remotos" {{ $service->category === 'servicios-it-remotos' ? 'selected' : '' }}>IT Remoto</option>
                                </select>
                            </div>
                            <div style="grid-column:span 2;">
                                <label class="block text-xs text-slate-400 mb-1">Descripción</label>
                                <textarea name="description" rows="2"
                                          class="w-full border border-slate-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-blue-400">{{ $service->description }}</textarea>
                            </div>
                            <div>
                                <label class="block text-xs text-slate-400 mb-1">Precio</label>
                                <div style="display:flex;align-items:center;border:1px solid #e2e8f0;border-radius:8px;overflow:hidden;">
                                    <span style="padding:8px 12px;background:#f8fafc;color:#94a3b8;font-size:13px;border-right:1px solid #e2e8f0;white-space:nowrap;">Desde $</span>
                                    <input type="number" name="price" value="{{ $service->price }}" min="0" step="0.01"
                                           style="flex:1;border:none;padding:8px 12px;font-size:13px;outline:none;">
                                </div>
                            </div>
                            <div style="display:grid;grid-template-columns:1fr 1fr;gap:8px;">
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
                            <div>
                                <label class="block text-xs text-slate-400 mb-1">Nueva imagen</label>
                                <input type="file" name="image" accept="image/*" class="w-full text-sm text-slate-500">
                            </div>
                            <div>
                                <label class="block text-xs text-slate-400 mb-1">O URL de imagen</label>
                                <input type="url" name="image_url" value="{{ $service->image_url }}"
                                       class="w-full border border-slate-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-blue-400">
                            </div>
                        </div>
                    </form>

                    <div style="margin-top:12px;display:flex;justify-content:flex-end;">
                        <form method="POST" action="{{ route('admin.services.destroy', $service) }}"
                              onsubmit="return confirm('¿Eliminar este servicio?')">
                            @csrf @method('DELETE')
                            <button type="submit"
                                    style="font-size:12px;background:#fff1f2;color:#f43f5e;border:1px solid #fecdd3;padding:6px 12px;border-radius:8px;cursor:pointer;">
                                Eliminar
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="bg-white border border-slate-100 rounded-2xl p-12 text-center">
            <p class="text-slate-400 text-sm font-light">No hay servicios registrados aún.</p>
        </div>
        @endforelse
    </div>
</div>

@endsection
