@extends('layouts.admin')

@section('title', 'Reseñas')
@section('page-title', 'Reseñas')
@section('page-subtitle', 'Modera las reseñas de clientes')

@section('content')

@php
$total    = $reviews->count();
$featured = $reviews->where('featured', true)->count();
$avg      = $reviews->avg('rating');
$positive = $reviews->where('rating', '>=', 3)->count();
@endphp

{{-- STATS --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    @foreach([
        ['Total reseñas',    $total,                      'bg-blue-50 text-blue-600',    'fa-comments'],
        ['Destacadas',       $featured . ' de 4',         'bg-violet-50 text-violet-600', 'fa-star'],
        ['Positivas (3+★)',  $positive,                   'bg-emerald-50 text-emerald-600','fa-thumbs-up'],
        ['Promedio',         number_format($avg ?? 0, 1) . ' ★', 'bg-amber-50 text-amber-600', 'fa-chart-bar'],
    ] as $s)
    <div class="bg-white border border-slate-100 rounded-2xl p-5">
        <div class="flex items-center gap-3 mb-2">
            <div class="w-8 h-8 rounded-lg {{ $s[2] }} flex items-center justify-center text-sm">
                <i class="fa-solid {{ $s[3] }}"></i>
            </div>
            <p class="text-xs font-semibold text-slate-500 uppercase tracking-wide">{{ $s[0] }}</p>
        </div>
        <p class="text-2xl font-bold text-slate-900">{{ $s[1] }}</p>
    </div>
    @endforeach
</div>

{{-- FILTRO --}}
<div class="bg-white border border-slate-100 rounded-2xl p-4 mb-4 flex items-center gap-3 flex-wrap">
    <span class="text-xs font-medium text-slate-500">Filtrar por rating:</span>
    <div class="flex gap-2 flex-wrap" id="filter-btns">
        <button onclick="filterReviews('all')" data-filter="all"
                class="filter-btn active text-xs px-3 py-1.5 rounded-lg border border-blue-500 bg-blue-500 text-white transition-all">
            Todas
        </button>
        @foreach([5,4,3,2,1] as $r)
        <button onclick="filterReviews({{ $r }})" data-filter="{{ $r }}"
                class="filter-btn text-xs px-3 py-1.5 rounded-lg border border-slate-200 text-slate-500 hover:border-amber-400 hover:text-amber-600 transition-all">
            {{ $r }} ★
        </button>
        @endforeach
        <button onclick="filterReviews('featured')" data-filter="featured"
                class="filter-btn text-xs px-3 py-1.5 rounded-lg border border-slate-200 text-slate-500 hover:border-violet-400 hover:text-violet-600 transition-all">
            <i class="fa-solid fa-star text-amber-400"></i> Destacadas
        </button>
    </div>
</div>

{{-- LISTA --}}
<div class="space-y-3" id="reviews-list">
    @forelse($reviews as $review)
    <div class="review-item bg-white rounded-2xl overflow-hidden transition-all {{ $review->featured ? 'border-2 border-blue-200' : 'border border-slate-100' }}"
         data-rating="{{ $review->rating }}"
         data-featured="{{ $review->featured ? 'true' : 'false' }}">

        <div class="flex items-start gap-4 p-5">
            {{-- Avatar --}}
            <div class="w-10 h-10 rounded-xl flex items-center justify-center text-white font-bold text-sm flex-shrink-0"
                 style="background:linear-gradient(135deg,#2563eb,#7c3aed)">
                {{ strtoupper(substr($review->name, 0, 1)) }}
            </div>

            {{-- Info --}}
            <div class="flex-1 min-w-0">
                <div class="flex items-center gap-2 flex-wrap mb-1">
                    <p class="text-slate-900 text-sm font-semibold">{{ $review->name }}</p>
                    {{-- Estrellas --}}
                    <div class="flex gap-0.5">
                        @for($i = 1; $i <= 5; $i++)
                        <i class="fa-solid fa-star text-xs {{ $i <= $review->rating ? 'text-amber-400' : 'text-slate-200' }}"></i>
                        @endfor
                    </div>
                    @if($review->featured)
                    <span class="text-xs font-semibold text-blue-600 bg-blue-50 border border-blue-200 px-2 py-0.5 rounded-full">
                        <i class="fa-solid fa-star text-amber-400"></i> Destacada
                    </span>
                    @endif
                    @if($review->rating < 3)
                    <span class="text-xs font-medium text-red-500 bg-red-50 border border-red-100 px-2 py-0.5 rounded-full">
                        No visible al público
                    </span>
                    @endif
                </div>
                <p class="text-xs text-slate-400 mb-2">{{ $review->email }} · {{ $review->created_at->format('d M Y') }}</p>
                <p class="text-slate-600 text-sm leading-relaxed">{{ $review->comment }}</p>
            </div>

            {{-- Acciones --}}
            <div class="flex flex-col gap-2 flex-shrink-0">
                <form method="POST" action="{{ route('admin.reviews.toggle', $review) }}">
                    @csrf @method('PATCH')
                    <button type="submit"
                            class="text-xs px-3 py-2 rounded-xl border transition-colors whitespace-nowrap {{ $review->featured ? 'bg-blue-50 text-blue-600 border-blue-200 hover:bg-blue-100' : 'bg-slate-50 text-slate-500 border-slate-200 hover:border-amber-300 hover:text-amber-600' }}">
                        @if($review->featured)
                            <i class="fa-solid fa-star text-amber-400"></i> Quitar
                        @else
                            <i class="fa-regular fa-star"></i> Destacar
                        @endif
                    </button>
                </form>
                <form method="POST" action="{{ route('admin.reviews.destroy', $review) }}"
                      onsubmit="return confirm('¿Eliminar la reseña de {{ $review->name }}?')">
                    @csrf @method('DELETE')
                    <button type="submit"
                            class="text-xs px-3 py-2 rounded-xl border border-red-100 bg-red-50 text-red-400 hover:bg-red-100 hover:text-red-600 hover:border-red-200 transition-colors whitespace-nowrap w-full">
                        <i class="fa-solid fa-trash-can"></i> Eliminar
                    </button>
                </form>
            </div>
        </div>
    </div>
    @empty
    <div class="bg-white border border-slate-100 rounded-2xl p-12 text-center">
        <i class="fa-solid fa-star text-slate-200 text-4xl mb-3 block"></i>
        <p class="text-slate-400 text-sm">No hay reseñas registradas aún.</p>
    </div>
    @endforelse
</div>

@endsection

@push('scripts')
<script>
function filterReviews(filter) {
    // Update buttons
    document.querySelectorAll('.filter-btn').forEach(btn => {
        btn.classList.remove('bg-blue-500', 'text-white', 'border-blue-500');
        btn.classList.add('border-slate-200', 'text-slate-500');
    });
    const active = document.querySelector(`[data-filter="${filter}"]`);
    if (active) {
        active.classList.add('bg-blue-500', 'text-white', 'border-blue-500');
        active.classList.remove('border-slate-200', 'text-slate-500');
    }

    // Filter cards
    document.querySelectorAll('.review-item').forEach(card => {
        const rating   = parseInt(card.dataset.rating);
        const featured = card.dataset.featured === 'true';
        let show = false;
        if (filter === 'all')      show = true;
        else if (filter === 'featured') show = featured;
        else show = rating === parseInt(filter);
        card.style.display = show ? '' : 'none';
    });
}
</script>
@endpush
