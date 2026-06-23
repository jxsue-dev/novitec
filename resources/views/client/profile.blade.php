@extends('layouts.app')

@section('title', 'Mi perfil')

@section('content')
<div class="min-h-screen pt-24 pb-16 px-6" style="background:linear-gradient(135deg,#f0f4ff 0%,#e8f0fe 25%,#fdf4ff 50%,#f0f9ff 75%,#ecfdf5 100%);">
    <div class="max-w-4xl mx-auto">
        <div class="mb-8 flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold tracking-widest uppercase text-blue-600 mb-2">Mi cuenta</p>
                <h1 class="text-3xl font-bold text-slate-900" style="font-family:'Playfair Display',serif;">Mi perfil</h1>
            </div>
            <a href="{{ route('client.orders') }}"
               class="text-sm text-slate-500 hover:text-slate-700 border border-slate-200 hover:border-slate-300 px-4 py-2 rounded-xl transition-all">
                Volver a mis ordenes
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="md:col-span-1 space-y-6">
                <div class="bg-white border border-slate-100 rounded-2xl p-6 text-center">
                    <div class="w-20 h-20 bg-blue-600 rounded-full flex items-center justify-center text-white text-3xl font-bold mx-auto mb-4">
                        {{ substr($user->full_name, 0, 1) }}
                    </div>
                    <p class="text-slate-900 font-semibold">{{ $user->full_name }}</p>
                    <p class="text-slate-400 text-xs font-light mt-1">{{ $user->email }}</p>
                    <div class="mt-4 pt-4 border-t border-slate-100 space-y-2 text-left">
                        <div>
                            <p class="text-xs text-slate-400 font-light">Cedula / RUC</p>
                            <p class="text-slate-900 text-sm font-medium">{{ $user->identificacion ?? $user->cedula }}</p>
                        </div>
                        @if($user->phone)
                            <div>
                                <p class="text-xs text-slate-400 font-light">Telefono</p>
                                <p class="text-slate-900 text-sm font-medium">{{ $user->phone }}</p>
                            </div>
                        @endif
                        @if($user->direccion)
                            <div>
                                <p class="text-xs text-slate-400 font-light">Direccion</p>
                                <p class="text-slate-900 text-sm font-medium">{{ $user->direccion }}</p>
                            </div>
                        @endif
                        <div>
                            <p class="text-xs text-slate-400 font-light">Miembro desde</p>
                            <p class="text-slate-900 text-sm font-medium">{{ $user->created_at->format('d/m/Y') }}</p>
                        </div>
                    </div>
                </div>

                {{-- CARD DE MEMBRESÍA Y DESCUENTOS --}}
                @php
                    $years = max(0, (int) $user->created_at->diffInYears(now()));
                    $discountPercent = min(20, $years * 5);
                    $nextAnniversary = $user->created_at->copy()->addYears($years + 1);
                    $daysToNext = max(1, (int) now()->diffInDays($nextAnniversary, false));
                @endphp
                <div class="bg-white border border-slate-100 rounded-2xl p-6 text-center">
                    <div class="flex items-center justify-between gap-2 mb-6 border-b border-slate-100 pb-4">
                        <div class="text-left">
                            <span class="text-[10px] font-bold tracking-widest uppercase text-blue-600 block">Club Novitec</span>
                            <span class="text-[11px] text-slate-400 font-light">Programa de Lealtad</span>
                        </div>
                        <span class="bg-blue-50 text-blue-600 border border-blue-100 text-[10px] font-semibold px-2.5 py-1 rounded-full">
                            Fidelidad
                        </span>
                    </div>
                    
                    <div class="space-y-4 text-left">
                        <div>
                            <p class="text-xs text-slate-400 font-light">Tiempo de membresía</p>
                            <p class="text-slate-900 text-sm font-semibold mt-0.5">
                                @if($years == 0)
                                    Primer año como miembro
                                @elseif($years == 1)
                                    1 año de antigüedad
                                @else
                                    {{ $years }} años de antigüedad
                                @endif
                            </p>
                        </div>

                        <div>
                            <p class="text-xs text-slate-400 font-light">Descuento acumulado</p>
                            <div class="flex items-baseline gap-1 mt-0.5">
                                <span class="text-3xl font-bold tracking-tight text-blue-600">{{ $discountPercent }}%</span>
                                <span class="text-xs text-slate-500 font-medium">de descuento en tus órdenes</span>
                            </div>
                        </div>

                        @if($discountPercent < 20)
                            <div class="pt-4 border-t border-slate-100">
                                <div class="rounded-xl p-3 flex items-start gap-2" style="background-color: rgba(239, 246, 255, 0.5); border: 1px solid rgba(191, 219, 254, 0.5);">
                                    <i class="fa-solid fa-gift text-blue-500 mt-0.5 text-xs"></i>
                                    <p class="text-[11px] text-slate-600 leading-relaxed font-light">
                                        Faltan <strong>{{ $daysToNext }}</strong> días para obtener el <strong>{{ $discountPercent + 5 }}%</strong> de descuento por antigüedad.
                                    </p>
                                </div>
                            </div>
                        @else
                            <div class="pt-4 border-t border-slate-100">
                                <div class="rounded-xl p-3 flex items-start gap-2" style="background-color: rgba(240, 253, 244, 1); border: 1px solid rgba(187, 247, 208, 1);">
                                    <i class="fa-solid fa-circle-check text-emerald-600 mt-0.5 text-xs"></i>
                                    <p class="text-[11px] text-emerald-700 leading-relaxed font-light">
                                        ¡Has alcanzado el límite máximo del <strong>20%</strong> de descuento por antigüedad!
                                    </p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="md:col-span-2 space-y-5">
                @if(session('success'))
                    <div class="bg-green-50 border border-green-200 text-green-700 text-sm px-4 py-3 rounded-xl">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="bg-white border border-slate-100 rounded-2xl p-6">
                    <h2 class="text-slate-900 text-sm font-semibold mb-5">Datos personales</h2>
                    <form method="POST" action="{{ route('profile.update') }}" class="space-y-4">
                        @csrf
                        @method('PATCH')

                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <div>
                                <label class="block text-xs text-slate-500 mb-1.5">Nombres</label>
                                <input type="text" name="nombres" value="{{ old('nombres', $user->nombres) }}" required
                                       class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-blue-400 transition-colors">
                                @error('nombres')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                            </div>

                            <div>
                                <label class="block text-xs text-slate-500 mb-1.5">Apellidos</label>
                                <input type="text" name="apellidos" value="{{ old('apellidos', $user->apellidos) }}" required
                                       class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-blue-400 transition-colors">
                                @error('apellidos')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs text-slate-500 mb-1.5">Cedula / RUC</label>
                            <input type="text" value="{{ $user->identificacion ?? $user->cedula }}" disabled
                                   class="w-full border border-slate-100 rounded-xl px-4 py-2.5 text-sm bg-slate-50 text-slate-400 cursor-not-allowed">
                            <p class="text-xs text-slate-400 mt-1 font-light">La identificacion no puede ser modificada.</p>
                        </div>

                        <div>
                            <label class="block text-xs text-slate-500 mb-1.5">Telefono</label>
                            <input type="text" name="phone" value="{{ old('phone', $user->phone) }}"
                                   placeholder="0987654321" maxlength="10"
                                   class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-blue-400 transition-colors">
                            @error('phone')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="block text-xs text-slate-500 mb-1.5">Correo electronico</label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                                   class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-blue-400 transition-colors">
                            @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="block text-xs text-slate-500 mb-1.5">Direccion</label>
                            <textarea name="direccion" rows="3"
                                      class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-blue-400 transition-colors">{{ old('direccion', $user->direccion) }}</textarea>
                            @error('direccion')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>

                        <button type="submit"
                                class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-8 py-2.5 rounded-xl transition-colors">
                            Guardar cambios
                        </button>
                    </form>
                </div>

                <div class="bg-white border border-slate-100 rounded-2xl p-6">
                    <h2 class="text-slate-900 text-sm font-semibold mb-5">Cambiar contrasena</h2>
                    <form method="POST" action="{{ route('profile.update') }}" class="space-y-4">
                        @csrf
                        @method('PATCH')

                        <input type="hidden" name="nombres" value="{{ $user->nombres }}">
                        <input type="hidden" name="apellidos" value="{{ $user->apellidos }}">
                        <input type="hidden" name="email" value="{{ $user->email }}">
                        <input type="hidden" name="phone" value="{{ $user->phone }}">
                        <input type="hidden" name="direccion" value="{{ $user->direccion }}">

                        <div>
                            <label class="block text-xs text-slate-500 mb-1.5">Nueva contrasena</label>
                            <input type="password" name="password"
                                   class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-blue-400 transition-colors">
                            @error('password')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="block text-xs text-slate-500 mb-1.5">Confirmar contrasena</label>
                            <input type="password" name="password_confirmation"
                                   class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-blue-400 transition-colors">
                        </div>

                        <button type="submit"
                                class="bg-slate-800 hover:bg-slate-900 text-white text-sm font-medium px-8 py-2.5 rounded-xl transition-colors">
                            Actualizar contrasena
                        </button>
                    </form>
                </div>

                <div class="bg-white border border-red-100 rounded-2xl p-6">
                    <h2 class="text-red-600 text-sm font-semibold mb-2">Eliminar cuenta</h2>
                    <p class="text-slate-500 text-xs font-light mb-5">Esta accion es irreversible. Se eliminaran todos tus datos.</p>
                    <form method="POST" action="{{ route('profile.destroy') }}"
                          onsubmit="return confirm('Estas seguro? Esta accion no se puede deshacer.')">
                        @csrf
                        @method('DELETE')
                        <div class="mb-4">
                            <label class="block text-xs text-slate-500 mb-1.5">Confirma tu contrasena</label>
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
