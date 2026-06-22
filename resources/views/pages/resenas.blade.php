@extends('layouts.app')

@section('title', 'Reseñas – Novitecnología Cia. Ltda.')

@section('content')

<style>
@import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;800&family=Inter:wght@300;400;500&display=swap');
body { font-family: 'Inter', sans-serif; }
.font-serif { font-family: 'Playfair Display', serif; }
.reveal { opacity:0; transform:translateY(30px); transition:opacity .8s ease,transform .8s ease; }
.reveal.visible { opacity:1; transform:translateY(0); }
.star-btn { cursor:pointer; transition: transform .1s ease; }
.star-btn:hover { transform: scale(1.2); }
.review-card { background:#fff; border:1px solid #e2e8f0; border-radius:20px; padding:24px; transition:all .3s ease; }
.review-card:hover { border-color:#bfdbfe; box-shadow:0 8px 24px rgba(59,130,246,.08); transform:translateY(-2px); }
.r-hero { padding:140px 24px 80px; }
.r-form-grid { display:grid; grid-template-columns:1fr 1fr; gap:16px; margin-bottom:16px; }
@media (max-width:640px) {
    .r-hero { padding:90px 20px 50px; }
    .r-form-grid { grid-template-columns:1fr; }
    .r-section { padding:48px 20px !important; }
}
</style>

{{-- HERO --}}
<section class="r-hero" style="background:linear-gradient(135deg,#020817 0%,#0c1a35 50%,#020817 100%);position:relative;overflow:hidden;">
    <div style="position:absolute;inset:0;background-image:linear-gradient(rgba(59,130,246,.04) 1px,transparent 1px),linear-gradient(90deg,rgba(59,130,246,.04) 1px,transparent 1px);background-size:60px 60px;pointer-events:none;"></div>
    <div style="max-width:700px;margin:0 auto;text-align:center;position:relative;">
        <p style="font-size:11px;font-weight:600;letter-spacing:.1em;text-transform:uppercase;color:#60a5fa;margin-bottom:16px;" class="reveal">Lo que dicen nuestros clientes</p>
        <h1 style="font-family:'Playfair Display',serif;font-size:clamp(32px,5vw,52px);font-weight:800;color:#fff;margin-bottom:20px;line-height:1.2;" class="reveal">
            Reseñas y <span style="background:linear-gradient(90deg,#60a5fa,#a78bfa);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">opiniones</span>
        </h1>
        <p style="color:#94a3b8;font-size:16px;font-weight:300;line-height:1.7;" class="reveal">
            La satisfacción de nuestros clientes es nuestra mayor recompensa.
        </p>
    </div>
</section>

{{-- RESEÑAS DESTACADAS --}}
@if($featured->count() > 0)
<section class="r-section" style="padding:80px 24px;background:#f8fafc;">
    <div style="max-width:1100px;margin:0 auto;">
        <h2 style="font-family:'Playfair Display',serif;font-size:28px;font-weight:700;color:#0f172a;margin-bottom:8px;text-align:center;" class="reveal">
            Reseñas destacadas
        </h2>
        <p style="color:#94a3b8;font-size:14px;text-align:center;margin-bottom:40px;" class="reveal">Seleccionadas por nuestro equipo</p>

        <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(280px,1fr));gap:24px;">
            @foreach($featured as $i => $review)
            <div class="review-card reveal" style="transition-delay:{{ $i * 0.1 }}s;border-color:#bfdbfe;background:linear-gradient(135deg,#fff,#eff6ff);">
                {{-- ESTRELLAS --}}
                <div style="display:flex;gap:3px;margin-bottom:16px;">
                    @for($s = 1; $s <= 5; $s++)
                    <svg style="width:18px;height:18px;color:{{ $s <= $review->rating ? '#f59e0b' : '#e2e8f0' }};" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                    @endfor
                </div>

                <p style="color:#334155;font-size:14px;line-height:1.7;font-weight:300;margin-bottom:20px;font-style:italic;">
                    "{{ $review->comment }}"
                </p>

                <div style="display:flex;align-items:center;gap:12px;">
                    <div style="width:40px;height:40px;border-radius:50%;background:linear-gradient(135deg,#2563eb,#7c3aed);display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700;font-size:16px;flex-shrink:0;">
                        {{ strtoupper(substr($review->name, 0, 1)) }}
                    </div>
                    <div>
                        <p style="font-weight:600;color:#0f172a;font-size:14px;">{{ $review->name }}</p>
                        <p style="font-size:12px;color:#94a3b8;">{{ $review->created_at->format('d M Y') }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- TODAS LAS RESEÑAS --}}
@if($all->count() > 0)
<section class="r-section" style="padding:80px 24px;background:#fff;">
    <div style="max-width:1100px;margin:0 auto;">
        <h2 style="font-family:'Playfair Display',serif;font-size:28px;font-weight:700;color:#0f172a;margin-bottom:8px;text-align:center;" class="reveal">
            Todas las reseñas
        </h2>
        <p style="color:#94a3b8;font-size:14px;text-align:center;margin-bottom:40px;" class="reveal">{{ $all->count() }} reseñas verificadas</p>

        <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(300px,1fr));gap:20px;">
            @foreach($all as $i => $review)
            <div class="review-card reveal" style="transition-delay:{{ ($i % 3) * 0.1 }}s">
                <div style="display:flex;gap:3px;margin-bottom:12px;">
                    @for($s = 1; $s <= 5; $s++)
                    <svg style="width:16px;height:16px;color:{{ $s <= $review->rating ? '#f59e0b' : '#e2e8f0' }};" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                    @endfor
                </div>
                <p style="color:#475569;font-size:13px;line-height:1.7;font-weight:300;margin-bottom:16px;">
                    "{{ $review->comment }}"
                </p>
                <div style="display:flex;align-items:center;gap:10px;">
                    <div style="width:34px;height:34px;border-radius:50%;background:linear-gradient(135deg,#2563eb,#7c3aed);display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700;font-size:13px;flex-shrink:0;">
                        {{ strtoupper(substr($review->name, 0, 1)) }}
                    </div>
                    <div>
                        <p style="font-weight:600;color:#0f172a;font-size:13px;">{{ $review->name }}</p>
                        <p style="font-size:11px;color:#94a3b8;">{{ $review->created_at->format('d M Y') }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- FORMULARIO --}}
<section class="r-section" style="padding:80px 24px;background:#f8fafc;">
    <div style="max-width:600px;margin:0 auto;">
        <h2 style="font-family:'Playfair Display',serif;font-size:28px;font-weight:700;color:#0f172a;margin-bottom:8px;text-align:center;" class="reveal">
            Deja tu reseña
        </h2>
        <p style="color:#94a3b8;font-size:14px;text-align:center;margin-bottom:40px;" class="reveal">Tu opinión nos ayuda a mejorar</p>

        @if(session('review_success'))
        <div style="background:#f0fdf4;border:1px solid #bbf7d0;border-radius:12px;padding:16px;text-align:center;margin-bottom:24px;color:#15803d;font-size:14px;">
            {{ session('review_success') }}
        </div>
        @endif

        <form method="POST" action="{{ route('reviews.store') }}"
              style="background:#fff;border:1px solid #e2e8f0;border-radius:24px;padding:32px;" class="reveal">
            @csrf

            <div class="r-form-grid">
                <div>
                    <label style="display:block;font-size:12px;color:#64748b;margin-bottom:6px;font-weight:500;">Nombre</label>
                    <input type="text" name="name" required value="{{ old('name') }}"
                           style="width:100%;border:1px solid #e2e8f0;border-radius:10px;padding:10px 14px;font-size:14px;outline:none;box-sizing:border-box;">
                </div>
                <div>
                    <label style="display:block;font-size:12px;color:#64748b;margin-bottom:6px;font-weight:500;">Email</label>
                    <input type="email" name="email" required value="{{ old('email') }}"
                           style="width:100%;border:1px solid #e2e8f0;border-radius:10px;padding:10px 14px;font-size:14px;outline:none;box-sizing:border-box;">
                </div>
            </div>

            {{-- ESTRELLAS --}}
            <div style="margin-bottom:16px;">
                <label style="display:block;font-size:12px;color:#64748b;margin-bottom:10px;font-weight:500;">Calificación</label>
                <div style="display:flex;gap:8px;" id="stars">
                    @for($s = 1; $s <= 5; $s++)
                    <label class="star-btn" style="cursor:pointer;">
                        <input type="radio" name="rating" value="{{ $s }}" style="display:none;" {{ old('rating') == $s ? 'checked' : '' }}>
                        <svg id="star-{{ $s }}" style="width:36px;height:36px;color:#e2e8f0;transition:color .15s;" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                    </label>
                    @endfor
                </div>
                @error('rating')
                <p style="color:#ef4444;font-size:12px;margin-top:4px;">{{ $message }}</p>
                @enderror
            </div>

            <div style="margin-bottom:24px;">
                <label style="display:block;font-size:12px;color:#64748b;margin-bottom:6px;font-weight:500;">Tu reseña</label>
                <textarea name="comment" required rows="4"
                          placeholder="Cuéntanos tu experiencia con nuestros servicios..."
                          style="width:100%;border:1px solid #e2e8f0;border-radius:10px;padding:10px 14px;font-size:14px;outline:none;resize:vertical;box-sizing:border-box;">{{ old('comment') }}</textarea>
                @error('comment')
                <p style="color:#ef4444;font-size:12px;margin-top:4px;">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit"
                    style="width:100%;background:#2563eb;color:#fff;border:none;padding:14px;border-radius:12px;font-size:14px;font-weight:600;cursor:pointer;">
                Enviar reseña
            </button>
        </form>
    </div>
</section>

@endsection

@push('scripts')
<script>
const observer = new IntersectionObserver((entries) => {
    entries.forEach(e => { if(e.isIntersecting) e.target.classList.add('visible'); });
}, { threshold: 0.1 });
document.querySelectorAll('.reveal').forEach(el => observer.observe(el));

// Estrellas interactivas
const stars = document.querySelectorAll('#stars label');
stars.forEach((label, idx) => {
    label.addEventListener('mouseenter', () => {
        stars.forEach((s, i) => {
            s.querySelector('svg').style.color = i <= idx ? '#f59e0b' : '#e2e8f0';
        });
    });
    label.addEventListener('mouseleave', () => {
        const checked = document.querySelector('#stars input:checked');
        const val = checked ? parseInt(checked.value) : 0;
        stars.forEach((s, i) => {
            s.querySelector('svg').style.color = i < val ? '#f59e0b' : '#e2e8f0';
        });
    });
    label.addEventListener('click', () => {
        stars.forEach((s, i) => {
            s.querySelector('svg').style.color = i <= idx ? '#f59e0b' : '#e2e8f0';
        });
    });
});

// Restaurar estrellas si hay old value
const checkedRating = document.querySelector('#stars input:checked');
if (checkedRating) {
    const val = parseInt(checkedRating.value);
    stars.forEach((s, i) => {
        s.querySelector('svg').style.color = i < val ? '#f59e0b' : '#e2e8f0';
    });
}
</script>
@endpush
