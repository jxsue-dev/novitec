@extends('layouts.admin')

@section('title', 'Reseñas')
@section('page-title', 'Reseñas')
@section('page-subtitle', 'Gestiona las reseñas de clientes')

@section('content')

<div style="display:flex;flex-direction:column;gap:16px;">

    {{-- STATS --}}
    <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:16px;margin-bottom:8px;">
        @php
            $total = $reviews->count();
            $featured = $reviews->where('featured', true)->count();
            $avg = $reviews->avg('rating');
            $positive = $reviews->where('rating', '>=', 3)->count();
        @endphp
        @foreach([
            ['Total', $total, '#2563eb', null],
            ['Destacadas', $featured . '/4', '#7c3aed', null],
            ['Positivas (3+)', $positive, '#059669', 'fa-star'],
            ['Promedio', number_format($avg, 1), '#d97706', 'fa-star'],
        ] as $stat)
        <div style="background:#fff;border:1px solid #e2e8f0;border-radius:16px;padding:20px;">
            <p style="font-size:11px;color:#94a3b8;font-weight:600;text-transform:uppercase;letter-spacing:.05em;margin-bottom:8px;">{{ $stat[0] }}</p>
            <p style="font-size:24px;font-weight:700;color:{{ $stat[2] }};">{{ $stat[1] }} @if($stat[3])<i class="fa-solid {{ $stat[3] }}" style="font-size:14px;"></i>@endif</p>
        </div>
        @endforeach
    </div>

    {{-- LISTA --}}
    @forelse($reviews as $review)
    <div style="background:#fff;border:1px solid {{ $review->featured ? '#bfdbfe' : '#e2e8f0' }};border-radius:16px;padding:20px;{{ $review->featured ? 'background:linear-gradient(135deg,#fff,#eff6ff);' : '' }}">
        <div style="display:flex;align-items:start;justify-content:space-between;gap:16px;">

            {{-- INFO --}}
            <div style="flex:1;">
                <div style="display:flex;align-items:center;gap:12px;margin-bottom:8px;flex-wrap:wrap;">
                    {{-- AVATAR --}}
                    <div style="width:40px;height:40px;border-radius:50%;background:linear-gradient(135deg,#2563eb,#7c3aed);display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700;font-size:16px;flex-shrink:0;">
                        {{ strtoupper(substr($review->name, 0, 1)) }}
                    </div>
                    <div>
                        <p style="font-weight:600;color:#0f172a;font-size:14px;">{{ $review->name }}</p>
                        <p style="font-size:12px;color:#94a3b8;">{{ $review->email }} · {{ $review->created_at->diffForHumans() }}</p>
                    </div>

                    {{-- ESTRELLAS --}}
                    <div style="display:flex;gap:2px;margin-left:4px;">
                        @for($i = 1; $i <= 5; $i++)
                        <svg style="width:16px;height:16px;color:{{ $i <= $review->rating ? '#f59e0b' : '#e2e8f0' }};" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                        @endfor
                    </div>

                    @if($review->featured)
                    <span style="font-size:11px;font-weight:600;color:#2563eb;background:#eff6ff;border:1px solid #bfdbfe;padding:2px 10px;border-radius:20px;">
                        <i class="fa-solid fa-star"></i> Destacada
                    </span>
                    @endif

                    @if($review->rating < 3)
                    <span style="font-size:11px;font-weight:600;color:#dc2626;background:#fff1f2;border:1px solid #fecdd3;padding:2px 10px;border-radius:20px;">
                        No visible al público
                    </span>
                    @endif
                </div>

                <p style="color:#475569;font-size:14px;font-weight:300;line-height:1.6;">{{ $review->comment }}</p>
            </div>

            {{-- ACCIONES --}}
            <div style="display:flex;flex-direction:column;gap:8px;flex-shrink:0;">
                <form method="POST" action="{{ route('admin.reviews.toggle', $review) }}">
                    @csrf @method('PATCH')
                    <button type="submit"
                            style="font-size:12px;padding:6px 14px;border-radius:8px;cursor:pointer;width:100%;{{ $review->featured ? 'background:#eff6ff;color:#2563eb;border:1px solid #bfdbfe;' : 'background:#f8fafc;color:#64748b;border:1px solid #e2e8f0;' }}">
                        @if($review->featured)<i class="fa-solid fa-star"></i> Quitar@else<i class="fa-regular fa-star"></i> Destacar@endif
                    </button>
                </form>
                <form method="POST" action="{{ route('admin.reviews.destroy', $review) }}"
                      onsubmit="return confirm('¿Eliminar esta reseña?')">
                    @csrf @method('DELETE')
                    <button type="submit"
                            style="font-size:12px;padding:6px 14px;border-radius:8px;cursor:pointer;width:100%;background:#fff1f2;color:#f43f5e;border:1px solid #fecdd3;">
                        Eliminar
                    </button>
                </form>
            </div>
        </div>
    </div>
    @empty
    <div style="background:#fff;border:1px solid #e2e8f0;border-radius:16px;padding:48px;text-align:center;">
        <p style="color:#94a3b8;font-size:14px;font-weight:300;">No hay reseñas aún.</p>
    </div>
    @endforelse

</div>

@endsection
