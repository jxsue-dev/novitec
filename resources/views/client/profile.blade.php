@extends('layouts.app')

@section('title', 'Mi perfil')

@section('content')

<div class="min-h-screen pt-24 pb-16 px-6" style="background:linear-gradient(135deg,#f0f4ff 0%,#e8f0fe 25%,#fdf4ff 50%,#f0f9ff 75%,#ecfdf5 100%);">
    <div class="max-w-4xl mx-auto">

        {{-- HEADER --}}
        <div class="mb-8 flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold tracking-widest uppercase text-blue-600 mb-2">Mi cuenta</p>
                <h1 class="text-3xl font-bold text-slate-900" style="font-family:'Playfair Display',serif;">Mi perfil</h1>
            </div>
            <a href="{{ route('client.orders') }}"
               class="text-sm text-slate-500 hover:text-slate-700 border border-slate-200 hover:border-slate-300 px-4 py-2 rounded-xl transition-all">
                ← Mis órdenes
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            {{-- SIDEBAR --}}
            <div class="md:col-span-1">
                <div class="bg-white border border-slate-100 rounded-2xl p-6 text-center">
                    <div class="w-20 h-20 bg-blue-600 rounded-full flex items-center justify-center text-white text-3xl font-bold mx-auto mb-4">
                        {{ substr($user->name, 0, 1) }}
                    </div>
                    <p class="text-slate-900 font-semibold">{{ $user->name }}</p>
                    <p class="text-slate-400 text-xs font-light mt-1">{{ $user->email }}</p>
                    <div class="mt-4 pt-4 border-t border-slate-100 space-y-2 text-left">
                        <div>
                            <p class="text-xs text-slate-400 font-light">Cédula / RUC</p>
                            <p class="text-slate-900 text-sm font-medium">{{ $user->cedula }}</p>
                        </div>
                        @if($user->phone)
                        <div>
                            <p class="text-xs text-slate-400 font-light">Teléfono</p>
                            <p class="text-slate-900 text-sm font-medium">{{ $user->phone }}</p>
                        </div>
                        @endif
                        <div>
                            <p class="text-xs text-slate-400 font-light">Miembro desde</p>
                            <p class="text-slate-900 text-sm font-medium">{{ $user->created_at->format('d/m/Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- FORMULARIO --}}
            <div class="md:col-span-2 space-y-5">

                {{-- MENSAJES --}}
                @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-700 text-sm px-4 py-3 rounded-xl">
                    {{ session('success') }}
                </div>
                @endif

                {{-- DATOS PERSONALES --}}
                <div class="bg-white border border-slate-100 rounded-2xl p-6">
                    <h2 class="text-slate-900 text-sm font-semibold mb-5">Datos personales</h2>
                    <form method="POST" action="{{ route('profile.update') }}" class="space-y-4">
                        @csrf @method('PATCH')

                        <div>
                            <label class="block text-xs text-slate-500 mb-1.5">Nombre completo</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                                   class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-blue-400 transition-colors">
                            @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="block text-xs text-slate-500 mb-1.5">Cédula / RUC</label>
                            <input type="text" value="{{ $user->cedula }}" disabled
                                   class="w-full border border-slate-100 rounded-xl px-4 py-2.5 text-sm bg-slate-50 text-slate-400 cursor-not-allowed">
                            <p class="text-xs text-slate-400 mt-1 font-light">La cédula no puede ser modificada.</p>
                        </div>

                        <div>
                            <label class="block text-xs text-slate-500 mb-1.5">Teléfono</label>
                            <input type="text" name="phone" value="{{ old('phone', $user->phone) }}"
                                   placeholder="0987654321" maxlength="10"
                                   class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-blue-400 transition-colors">
                            @error('phone')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="block text-xs text-slate-500 mb-1.5">Correo electrónico</label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                                   class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-blue-400 transition-colors">
                            @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>

                        <button type="submit"
                                class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-8 py-2.5 rounded-xl transition-colors">
                            Guardar cambios
                        </button>
                    </form>
                </div>

                {{-- CAMBIAR CONTRASEÑA --}}
                <div class="bg-white border border-slate-100 rounded-2xl p-6">
                    <h2 class="text-slate-900 text-sm font-semibold mb-5">Cambiar contraseña</h2>
                    <form method="POST" action="{{ route('profile.update') }}" class="space-y-4">
                        @csrf @method('PATCH')

                        <input type="hidden" name="name" value="{{ $user->name }}">
                        <input type="hidden" name="email" value="{{ $user->email }}">
                        <input type="hidden" name="phone" value="{{ $user->phone }}">

                        <div>
                            <label class="block text-xs text-slate-500 mb-1.5">Nueva contraseña</label>
                            <input type="password" name="password"
                                   class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-blue-400 transition-colors">
                            @error('password')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="block text-xs text-slate-500 mb-1.5">Confirmar contraseña</label>
                            <input type="password" name="password_confirmation"
                                   class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-blue-400 transition-colors">
                        </div>

                        <button type="submit"
                                class="bg-slate-800 hover:bg-slate-900 text-white text-sm font-medium px-8 py-2.5 rounded-xl transition-colors">
                            Actualizar contraseña
                        </button>
                    </form>
                </div>

                {{-- ELIMINAR CUENTA --}}
                <div class="bg-white border border-red-100 rounded-2xl p-6">
                    <h2 class="text-red-600 text-sm font-semibold mb-2">Eliminar cuenta</h2>
                    <p class="text-slate-500 text-xs font-light mb-5">Esta acción es irreversible. Se eliminarán todos tus datos.</p>
                    <form method="POST" action="{{ route('profile.destroy') }}"
                          onsubmit="return confirm('¿Estás seguro? Esta acción no se puede deshacer.')">
                        @csrf @method('DELETE')
                        <div class="mb-4">
                            <label class="block text-xs text-slate-500 mb-1.5">Confirma tu contraseña</label>
                            <input type="password" name="password" required
                                   class="w-full border border-red-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-red-400 transition-colors">
                            @error('password', 'userDeletion')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <button type="submit"
                                class="bg-red-600 hover:bg-red-700 text-white text-sm font-medium px-8 py-2.5 rounded-xl transition-colors">
                            Eliminar mi cuenta
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>

@endsection
