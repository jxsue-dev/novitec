@extends('layouts.recepcion')

@section('title', 'Mi Cuenta')
@section('page-title', 'Mi cuenta')
@section('page-subtitle', 'Gestiona tu perfil y contraseña')

@section('content')

<div class="max-w-2xl space-y-5">

    {{-- PERFIL --}}
    <div class="bg-white border border-slate-100 rounded-2xl overflow-hidden shadow-sm">
        <div class="flex items-center gap-4 px-6 py-5 border-b border-slate-100 bg-slate-50/50">
            <div class="w-14 h-14 rounded-2xl flex items-center justify-center text-white text-xl font-bold flex-shrink-0"
                 style="background:linear-gradient(135deg,#2563eb,#7c3aed)">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
            <div>
                <p class="text-slate-900 font-semibold">{{ auth()->user()->name }}</p>
                <p class="text-slate-400 text-sm">{{ auth()->user()->email }}</p>
                <div class="flex items-center gap-2 mt-1">
                    <span class="inline-flex items-center gap-1.5 text-xs font-medium text-blue-600 bg-blue-50 border border-blue-100 px-2.5 py-1 rounded-full">
                        <i class="fa-solid fa-headset text-xs"></i> Recepcionista
                    </span>
                    <span class="inline-flex items-center gap-1.5 text-xs font-medium text-slate-500 bg-slate-100 px-2.5 py-1 rounded-full">
                        <i class="fa-solid fa-location-dot text-xs"></i> {{ auth()->user()->branch_name }}
                    </span>
                </div>
            </div>
        </div>

        <form method="POST" action="{{ route('recepcion.cuenta.update') }}" class="p-6 space-y-4">
            @csrf @method('PATCH')

            @if(session('status') === 'profile-updated')
            <div class="bg-green-50 border border-green-200 text-green-700 text-sm px-4 py-3 rounded-xl flex items-center gap-2">
                <i class="fa-solid fa-circle-check"></i> Perfil actualizado correctamente.
            </div>
            @endif

            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1.5">Nombre *</label>
                <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}" required
                       class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/10 transition-all">
                @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1.5">Correo electrónico *</label>
                <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" required
                       class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/10 transition-all">
                @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div class="flex justify-end pt-2">
                <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-6 py-2.5 rounded-xl transition-colors flex items-center gap-2">
                    <i class="fa-solid fa-floppy-disk"></i> Guardar perfil
                </button>
            </div>
        </form>
    </div>

    {{-- CONTRASEÑA --}}
    <div class="bg-white border border-slate-100 rounded-2xl overflow-hidden shadow-sm">
        <div class="px-6 py-4 border-b border-slate-100">
            <p class="text-slate-900 text-sm font-semibold flex items-center gap-2">
                <i class="fa-solid fa-lock text-slate-400 text-xs"></i> Cambiar contraseña
            </p>
            <p class="text-xs text-slate-400 mt-0.5">Mínimo 8 caracteres</p>
        </div>
        <form method="POST" action="{{ route('recepcion.cuenta.password') }}" class="p-6 space-y-4">
            @csrf @method('PUT')

            @if(session('status') === 'password-updated')
            <div class="bg-green-50 border border-green-200 text-green-700 text-sm px-4 py-3 rounded-xl flex items-center gap-2">
                <i class="fa-solid fa-circle-check"></i> Contraseña actualizada correctamente.
            </div>
            @endif

            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1.5">Contraseña actual *</label>
                <input type="password" name="current_password" required
                       class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/10 transition-all">
                @error('current_password')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">Nueva contraseña *</label>
                    <input type="password" name="password" required
                           class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/10 transition-all">
                    @error('password')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">Confirmar contraseña *</label>
                    <input type="password" name="password_confirmation" required
                           class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/10 transition-all">
                </div>
            </div>
            <div class="flex justify-end pt-2">
                <button type="submit"
                        class="bg-slate-800 hover:bg-slate-900 text-white text-sm font-semibold px-6 py-2.5 rounded-xl transition-colors flex items-center gap-2">
                    <i class="fa-solid fa-key"></i> Cambiar contraseña
                </button>
            </div>
        </form>
    </div>

</div>

@endsection
