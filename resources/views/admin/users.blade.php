@extends('layouts.admin')

@section('title', 'Usuarios')
@section('page-title', 'Usuarios')
@section('page-subtitle', 'Clientes y administradores registrados')

@section('content')

<div class="bg-white border border-slate-100 rounded-2xl overflow-hidden">
    <div class="px-6 py-4 border-b border-slate-100">
        <h2 class="text-slate-900 text-sm font-semibold">Todos los usuarios</h2>
    </div>
    <div class="divide-y divide-slate-50">
        @forelse($users as $user)
        <div class="px-6 py-4 flex items-center justify-between hover:bg-slate-50 transition-colors">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 bg-blue-600 rounded-full flex items-center justify-center text-white text-sm font-bold flex-shrink-0">
                    {{ substr($user->name, 0, 1) }}
                </div>
                <div>
                    <p class="text-slate-900 text-sm font-medium">{{ $user->name }}</p>
                    <p class="text-slate-400 text-xs font-light">{{ $user->email }}</p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                @if($user->is_admin)
                <span class="text-xs bg-violet-50 text-violet-600 border border-violet-100 px-2.5 py-1 rounded-full">Admin</span>
                @else
                <span class="text-xs bg-slate-50 text-slate-500 border border-slate-100 px-2.5 py-1 rounded-full">Cliente</span>
                @endif
                <span class="text-xs text-slate-400 font-light">{{ $user->created_at->diffForHumans() }}</span>
                <form method="POST" action="{{ route('admin.users.toggle', $user) }}">
                    @csrf @method('PATCH')
                    <button type="submit" class="text-xs border border-slate-200 hover:border-violet-400 hover:text-violet-600 text-slate-500 px-3 py-1.5 rounded-lg transition-all">
                        {{ $user->is_admin ? 'Quitar admin' : 'Hacer admin' }}
                    </button>
                </form>
                @if(auth()->id() !== $user->id)
                <form method="POST" action="{{ route('admin.users.destroy', $user) }}"
                      onsubmit="return confirm('¿Eliminar este usuario?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="text-xs border border-red-100 hover:border-red-400 hover:text-red-600 text-red-400 px-3 py-1.5 rounded-lg transition-all">
                        Eliminar
                    </button>
                </form>
                @endif
            </div>
        </div>
        @empty
        <div class="px-6 py-8 text-center text-slate-400 text-sm font-light">No hay usuarios registrados.</div>
        @endforelse
    </div>
    @if($users->hasPages())
    <div class="px-6 py-4 border-t border-slate-100">
        {{ $users->links() }}
    </div>
    @endif
</div>

@endsection
