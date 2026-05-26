@extends('layouts.admin')

@section('title', 'Sucursales')
@section('page-title', 'Sucursales')
@section('page-subtitle', 'Gestiona las sucursales y datos de contacto')

@section('content')

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- FORMULARIO NUEVA SUCURSAL --}}
    <div class="bg-white border border-slate-100 rounded-2xl p-6">
        <h3 class="text-slate-900 text-sm font-semibold mb-5">Nueva sucursal</h3>
        <form method="POST" action="{{ route('admin.branches.store') }}"
              onsubmit="return syncFields({{ $branch->id }}, this)">
            @csrf @method('PATCH')
            <input type="hidden" name="name" id="name-{{$branch->id}}">
            <input type="hidden" name="phone" id="phone-{{$branch->id}}">
            <input type="hidden" name="address" id="address-{{$branch->id}}">
            <input type="hidden" name="whatsapp" id="whatsapp-{{$branch->id}}">
            <input type="hidden" name="email" id="email-{{$branch->id}}">
            <input type="hidden" name="schedule" id="schedule-{{$branch->id}}">
            <input type="hidden" name="maps_url" id="maps_url-{{$branch->id}}">
            <input type="hidden" name="active" id="active-{{$branch->id}}">
            <button type="submit"
                    class="text-xs bg-blue-50 hover:bg-blue-100 text-blue-600 border border-blue-100 px-3 py-1.5 rounded-lg transition-colors">
                Guardar
            </button>
        </form>
    </div>

    {{-- LISTA DE SUCURSALES --}}
    <div class="lg:col-span-2 space-y-4">
        @forelse($branches as $branch)
        <div class="bg-white border border-slate-100 rounded-2xl p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center gap-2">
                    <span class="w-2 h-2 bg-{{ $branch->active ? 'emerald' : 'slate' }}-400 rounded-full"></span>
                    <h4 class="text-slate-900 text-sm font-semibold">{{ $branch->name }}</h4>
                </div>
                <div class="flex items-center gap-2">
                    {{-- FORM GUARDAR --}}
                    <form method="POST" action="{{ route('admin.branches.update', $branch) }}">
                        @csrf @method('PATCH')
                        <input type="hidden" name="name" id="name-{{$branch->id}}">
                        <input type="hidden" name="phone" id="phone-{{$branch->id}}">
                        <input type="hidden" name="address" id="address-{{$branch->id}}">
                        <input type="hidden" name="whatsapp" id="whatsapp-{{$branch->id}}">
                        <input type="hidden" name="email" id="email-{{$branch->id}}">
                        <input type="hidden" name="schedule" id="schedule-{{$branch->id}}">
                        <input type="hidden" name="maps_url" id="maps_url-{{$branch->id}}">
                        <input type="hidden" name="active" id="active-{{$branch->id}}">
                        <button type="submit"
                                onclick="syncFields({{$branch->id}})"
                                class="text-xs bg-blue-50 hover:bg-blue-100 text-blue-600 border border-blue-100 px-3 py-1.5 rounded-lg transition-colors">
                            Guardar
                        </button>
                    </form>

                    {{-- FORM ELIMINAR --}}
                    <form method="POST" action="{{ route('admin.branches.destroy', $branch) }}"
                          onsubmit="return confirm('¿Eliminar esta sucursal?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-xs bg-red-50 hover:bg-red-100 text-red-500 border border-red-100 px-3 py-1.5 rounded-lg transition-colors">
                            Eliminar
                        </button>
                    </form>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs text-slate-400 mb-1">Nombre</label>
                    <input type="text" data-field="name" data-id="{{$branch->id}}" value="{{ $branch->name }}"
                           class="branch-input w-full border border-slate-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-blue-400">
                </div>
                <div>
                    <label class="block text-xs text-slate-400 mb-1">Teléfono</label>
                    <input type="text" data-field="phone" data-id="{{$branch->id}}" value="{{ $branch->phone }}"
                           class="branch-input w-full border border-slate-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-blue-400">
                </div>
                <div class="col-span-2">
                    <label class="block text-xs text-slate-400 mb-1">Dirección</label>
                    <input type="text" data-field="address" data-id="{{$branch->id}}" value="{{ $branch->address }}"
                           class="branch-input w-full border border-slate-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-blue-400">
                </div>
                <div>
                    <label class="block text-xs text-slate-400 mb-1">WhatsApp</label>
                    <input type="text" data-field="whatsapp" data-id="{{$branch->id}}" value="{{ $branch->whatsapp }}"
                           class="branch-input w-full border border-slate-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-blue-400">
                </div>
                <div>
                    <label class="block text-xs text-slate-400 mb-1">Email</label>
                    <input type="email" data-field="email" data-id="{{$branch->id}}" value="{{ $branch->email }}"
                           class="branch-input w-full border border-slate-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-blue-400">
                </div>
                <div>
                    <label class="block text-xs text-slate-400 mb-1">Horario</label>
                    <input type="text" data-field="schedule" data-id="{{$branch->id}}" value="{{ $branch->schedule }}"
                           class="branch-input w-full border border-slate-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-blue-400">
                </div>
                <div>
                    <label class="block text-xs text-slate-400 mb-1">Activa</label>
                    <select data-field="active" data-id="{{$branch->id}}"
                            class="branch-input w-full border border-slate-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-blue-400">
                        <option value="1" {{ $branch->active ? 'selected' : '' }}>Sí</option>
                        <option value="0" {{ !$branch->active ? 'selected' : '' }}>No</option>
                    </select>
                </div>
                <div class="col-span-2">
                    <label class="block text-xs text-slate-400 mb-1">Link Google Maps</label>
                    <input type="text" data-field="maps_url" data-id="{{$branch->id}}" value="{{ $branch->maps_url }}"
                           placeholder="https://maps.google.com/..."
                           class="branch-input w-full border border-slate-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-blue-400">
                    @if($branch->maps_url)
                    <a href="{{ $branch->maps_url }}" target="_blank" class="text-xs text-blue-500 hover:text-blue-700 mt-1 inline-block">
                        Ver en mapa →
                    </a>
                    @endif
                </div>
            </div>
        </div>
        @empty
        <div class="bg-white border border-slate-100 rounded-2xl p-8 text-center text-slate-400 text-sm font-light">
            No hay sucursales registradas.
        </div>
        @endforelse
    </div>
</div>

@endsection

@push('scripts')
<script>
function syncFields(id, form) {
    document.querySelectorAll(`.branch-input[data-id="${id}"]`).forEach(input => {
        const field = input.dataset.field;
        const hidden = document.getElementById(`${field}-${id}`);
        if (hidden) hidden.value = input.value;
    });
    return true;
}
</script>
@endpush
