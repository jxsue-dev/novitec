@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Resumen general del sistema')

@section('content')

<div class="grid grid-cols-1 md:grid-cols-4 gap-5 mb-8">
    @foreach([
        ['Usuarios registrados', $stats['users'], 'bg-blue-50 text-blue-600', 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z'],
        ['Administradores', $stats['admins'], 'bg-violet-50 text-violet-600', 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z'],
        ['Sucursales', $stats['branches'], 'bg-emerald-50 text-emerald-600', 'M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z M15 11a3 3 0 11-6 0 3 3 0 016 0z'],
        ['Redes sociales', $stats['socials'], 'bg-amber-50 text-amber-600', 'M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1'],
    ] as $metric)
    <div class="bg-white border border-slate-100 rounded-2xl p-6 hover:shadow-sm transition-shadow">
        <div class="flex items-center justify-between mb-4">
            <p class="text-slate-500 text-xs font-light">{{ $metric[0] }}</p>
            <div class="w-8 h-8 {{ $metric[2] }} rounded-lg flex items-center justify-center">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $metric[3] }}"/>
                </svg>
            </div>
        </div>
        <p class="text-3xl font-bold text-slate-900">{{ $metric[1] }}</p>
    </div>
    @endforeach
</div>

<div class="bg-white border border-slate-100 rounded-2xl overflow-hidden">
    <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
        <h2 class="text-slate-900 text-sm font-semibold">Últimos usuarios registrados</h2>
        <a href="{{ route('admin.users') }}" class="text-xs text-blue-600 hover:text-blue-800 transition-colors">Ver todos →</a>
    </div>
    <div class="divide-y divide-slate-50">
        @forelse($latestUsers as $user)
        <div class="px-6 py-4 flex items-center justify-between hover:bg-slate-50 transition-colors">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center text-white text-xs font-bold">
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
            </div>
        </div>
        @empty
        <div class="px-6 py-8 text-center text-slate-400 text-sm font-light">No hay usuarios registrados aún.</div>
        @endforelse
    </div>
</div>

@endsection
