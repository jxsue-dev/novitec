@extends('layouts.admin')

@section('title', 'Usuarios')
@section('page-title', 'Usuarios')
@section('page-subtitle', 'Clientes, recepcionistas y administradores')

@section('content')

@php
$branches = \App\Models\User::BRANCHES;
@endphp

<div class="bg-white border border-slate-100 rounded-2xl overflow-hidden">
    <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
        <h2 class="text-slate-900 text-sm font-semibold">Todos los usuarios</h2>
        <div class="flex items-center gap-2 text-xs text-slate-400">
            <span class="px-2.5 py-1 rounded-full bg-violet-50 text-violet-600 border border-violet-100">Admin</span>
            <span class="px-2.5 py-1 rounded-full bg-blue-50 text-blue-600 border border-blue-100">Recepcionista</span>
            <span class="px-2.5 py-1 rounded-full bg-slate-50 text-slate-500 border border-slate-100">Cliente</span>
        </div>
    </div>
    <div class="divide-y divide-slate-50">
        @forelse($users as $user)
        <div class="px-6 py-4 flex items-start justify-between gap-4 hover:bg-slate-50/50 transition-colors" x-data="{ showBranch: false }">

            {{-- AVATAR + INFO --}}
            <div class="flex items-center gap-3 min-w-0">
                <div class="w-9 h-9 rounded-xl flex items-center justify-center text-white text-sm font-bold flex-shrink-0"
                     style="background:{{ $user->is_admin ? 'linear-gradient(135deg,#7c3aed,#4f46e5)' : ($user->isReceptionist() ? 'linear-gradient(135deg,#0284c7,#2563eb)' : 'linear-gradient(135deg,#475569,#334155)') }}">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <div class="min-w-0">
                    <p class="text-slate-900 text-sm font-medium truncate">{{ $user->name }}</p>
                    <p class="text-slate-400 text-xs truncate">{{ $user->email }}</p>
                    @if($user->isReceptionist())
                    <p class="text-blue-500 text-xs font-medium mt-0.5">
                        <i class="fa-solid fa-location-dot text-xs mr-1"></i>{{ $user->branch_name }}
                    </p>
                    @endif
                </div>
            </div>

            {{-- ACCIONES --}}
            <div class="flex items-center gap-2 flex-shrink-0 flex-wrap justify-end">
                {{-- Badge de rol --}}
                @if($user->is_admin)
                <span class="text-xs bg-violet-50 text-violet-600 border border-violet-100 px-2.5 py-1 rounded-full font-medium">
                    <i class="fa-solid fa-shield-halved mr-1"></i>Admin
                </span>
                @elseif($user->isReceptionist())
                <span class="text-xs bg-blue-50 text-blue-600 border border-blue-100 px-2.5 py-1 rounded-full font-medium">
                    <i class="fa-solid fa-headset mr-1"></i>Recepcionista
                </span>
                @else
                <span class="text-xs bg-slate-50 text-slate-500 border border-slate-100 px-2.5 py-1 rounded-full">
                    Cliente
                </span>
                @endif

                <span class="text-xs text-slate-300">{{ $user->created_at->diffForHumans() }}</span>

                {{-- Toggle admin --}}
                @if(!$user->isReceptionist())
                <form method="POST" action="{{ route('admin.users.toggle', $user) }}">
                    @csrf @method('PATCH')
                    <button type="submit"
                            class="text-xs border px-3 py-1.5 rounded-lg transition-all {{ $user->is_admin ? 'border-violet-200 text-violet-500 hover:border-violet-400' : 'border-slate-200 text-slate-500 hover:border-violet-400 hover:text-violet-600' }}">
                        {{ $user->is_admin ? 'Quitar admin' : 'Hacer admin' }}
                    </button>
                </form>
                @endif

                {{-- Asignar sucursal (recepcionista) --}}
                @if(!$user->is_admin && auth()->id() !== $user->id)
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" type="button"
                            class="text-xs border px-3 py-1.5 rounded-lg transition-all {{ $user->isReceptionist() ? 'border-blue-300 text-blue-600 bg-blue-50' : 'border-slate-200 text-slate-500 hover:border-blue-400 hover:text-blue-600' }}">
                        <i class="fa-solid fa-headset mr-1"></i>
                        {{ $user->isReceptionist() ? 'Cambiar sucursal' : 'Asignar recepcionista' }}
                    </button>

                    <div x-show="open" @click.outside="open = false"
                         x-transition
                         class="absolute right-0 top-full mt-2 w-60 bg-white border border-slate-200 rounded-xl shadow-xl z-20 overflow-hidden">
                        <p class="text-xs font-semibold text-slate-500 px-4 py-2.5 border-b border-slate-100 uppercase tracking-wide">
                            Asignar sucursal
                        </p>
                        @foreach($branches as $code => $name)
                        <form method="POST" action="{{ route('admin.users.assign-branch', $user) }}">
                            @csrf @method('PATCH')
                            <input type="hidden" name="branch_code" value="{{ $code }}">
                            <button type="submit"
                                    class="w-full text-left px-4 py-2.5 text-sm transition-colors flex items-center justify-between
                                           {{ $user->branch_code === $code ? 'bg-blue-50 text-blue-600 font-medium' : 'text-slate-700 hover:bg-slate-50' }}">
                                <span>{{ $name }}</span>
                                @if($user->branch_code === $code)
                                <i class="fa-solid fa-check text-blue-500 text-xs"></i>
                                @endif
                            </button>
                        </form>
                        @endforeach
                        @if($user->isReceptionist())
                        <div class="border-t border-slate-100">
                            <form method="POST" action="{{ route('admin.users.assign-branch', $user) }}">
                                @csrf @method('PATCH')
                                <input type="hidden" name="branch_code" value="">
                                <button type="submit"
                                        class="w-full text-left px-4 py-2.5 text-sm text-red-500 hover:bg-red-50 transition-colors">
                                    <i class="fa-solid fa-xmark mr-2"></i>Quitar rol recepcionista
                                </button>
                            </form>
                        </div>
                        @endif
                    </div>
                </div>
                @endif

                {{-- Eliminar --}}
                @if(auth()->id() !== $user->id)
                <form method="POST" action="{{ route('admin.users.destroy', $user) }}"
                      onsubmit="return confirm('¿Eliminar a {{ addslashes($user->name) }}?')">
                    @csrf @method('DELETE')
                    <button type="submit"
                            class="text-xs border border-red-100 hover:border-red-300 hover:text-red-600 text-red-400 px-3 py-1.5 rounded-lg transition-all">
                        <i class="fa-solid fa-trash-can"></i>
                    </button>
                </form>
                @endif
            </div>
        </div>
        @empty
        <div class="px-6 py-10 text-center text-slate-400 text-sm">
            <i class="fa-solid fa-users text-slate-200 text-4xl mb-3 block"></i>
            No hay usuarios registrados.
        </div>
        @endforelse
    </div>
    @if($users->hasPages())
    <div class="px-6 py-4 border-t border-slate-100">
        {{ $users->links() }}
    </div>
    @endif
</div>

@endsection
