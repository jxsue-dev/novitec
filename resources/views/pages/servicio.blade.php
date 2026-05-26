@extends('layouts.app')

@section('title', $service->name . ' – Novitecnología Cia. Ltda.')

@section('content')

<style>
@import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;800&family=Inter:wght@300;400;500&display=swap');
body { font-family: 'Inter', sans-serif; }
.font-serif { font-family: 'Playfair Display', serif; }
.reveal { opacity:0; transform:translateY(30px); transition:opacity .8s ease,transform .8s ease; }
.reveal.visible { opacity:1; transform:translateY(0); }
.btn-whatsapp { background:#25d366; color:#fff; display:flex; align-items:center; justify-content:center; gap:12px; padding:16px 32px; border-radius:16px; text-decoration:none; font-weight:600; font-size:15px; transition:all .3s ease; box-shadow:0 8px 24px rgba(37,211,102,.3); }
.btn-whatsapp:hover { background:#22c55e; transform:translateY(-2px); box-shadow:0 12px 32px rgba(37,211,102,.4); }
.btn-contacto { background:#fff; color:#475569; display:flex; align-items:center; justify-content:center; gap:8px; padding:14px 32px; border-radius:16px; text-decoration:none; font-size:14px; border:1px solid #e2e8f0; transition:all .3s ease; }
.btn-contacto:hover { border-color:#3b82f6; color:#2563eb; }
</style>

{{-- HERO --}}
<section style="background:linear-gradient(135deg,#020817 0%,#0c1a35 50%,#020817 100%);padding:140px 24px 80px;position:relative;overflow:hidden;">
    <div style="position:absolute;inset:0;background-image:linear-gradient(rgba(59,130,246,.04) 1px,transparent 1px),linear-gradient(90deg,rgba(59,130,246,.04) 1px,transparent 1px);background-size:60px 60px;pointer-events:none;"></div>
    <div style="max-width:800px;margin:0 auto;text-align:center;position:relative;">

        {{-- BREADCRUMB --}}
        <div style="display:flex;align-items:center;justify-content:center;gap:8px;margin-bottom:24px;">
            <a href="{{ route('servicios') }}" style="color:#64748b;font-size:13px;text-decoration:none;display:flex;align-items:center;gap:4px;transition:color .2s;">
                <svg style="width:14px;height:14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                Servicios
            </a>
            <span style="color:#334155;font-size:13px;">/</span>
            <span style="color:#94a3b8;font-size:13px;">{{ $service->name }}</span>
        </div>

        {{-- BADGE CATEGORÍA --}}
        <span style="display:inline-block;font-size:11px;font-weight:600;padding:5px 14px;border-radius:20px;background:rgba(37,99,235,.2);color:#93c5fd;border:1px solid rgba(59,130,246,.3);margin-bottom:20px;letter-spacing:.05em;text-transform:uppercase;">
            {{ ucwords(str_replace('-', ' ', $service->category)) }}
        </span>

        <h1 style="font-family:'Playfair Display',serif;font-size:clamp(32px,5vw,52px);font-weight:800;color:#fff;margin-bottom:20px;line-height:1.2;" class="reveal">
            {{ $service->name }}
        </h1>

        @if($service->price)
        <div style="display:inline-flex;align-items:center;gap:8px;background:rgba(37,99,235,.15);border:1px solid rgba(59,130,246,.3);padding:10px 24px;border-radius:20px;" class="reveal">
            <span style="color:#93c5fd;font-size:13px;">Precio:</span>
            <span style="color:#fff;font-size:20px;font-weight:700;">Desde ${{ $service->price }}</span>
        </div>
        @endif
    </div>
</section>

{{-- CONTENIDO PRINCIPAL --}}
<section style="padding:80px 24px;background:#fff;">
    <div style="max-width:1100px;margin:0 auto;display:grid;grid-template-columns:1fr 1fr;gap:64px;align-items:start;">

        {{-- IMAGEN --}}
        <div class="reveal">
            @if($service->image_src)
            <img src="{{ $service->image_src }}" alt="{{ $service->name }}"
                 style="width:100%;border-radius:24px;object-fit:cover;aspect-ratio:4/3;box-shadow:0 24px 48px rgba(0,0,0,.1);">
            @else
            <div style="width:100%;border-radius:24px;background:linear-gradient(135deg,#eff6ff,#f8fafc);display:flex;align-items:center;justify-content:center;aspect-ratio:4/3;">
                <svg style="width:64px;height:64px;color:#bfdbfe;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 3H5a2 2 0 00-2 2v4m6-6h10a2 2 0 012 2v4M9 3v18m0 0h10a2 2 0 002-2v-4M9 21H5a2 2 0 01-2-2v-4m0 0h18"/>
                </svg>
            </div>
            @endif
        </div>

        {{-- INFO --}}
        <div class="reveal">

            @if($service->description)
            <p style="color:#475569;font-size:16px;font-weight:300;line-height:1.8;margin-bottom:32px;">
                {{ $service->description }}
            </p>
            @endif

            {{-- PRECIO --}}
            @if($service->price)
            <div style="background:linear-gradient(135deg,#eff6ff,#f0f9ff);border:1px solid #bfdbfe;border-radius:20px;padding:24px;margin-bottom:24px;">
                <p style="font-size:11px;font-weight:600;color:#3b82f6;text-transform:uppercase;letter-spacing:.08em;margin-bottom:8px;">Precio del servicio</p>
                <p style="font-size:32px;font-weight:800;color:#1d4ed8;">Desde ${{ $service->price }}</p>
                <p style="font-size:12px;color:#64748b;margin-top:4px;font-weight:300;">Precio referencial — puede variar según el caso</p>
            </div>
            @endif

            {{-- WHATSAPP --}}
            @php
                $sucursal = \App\Models\Branch::where('active', true)->orderBy('order')->first();
                $whatsapp = $sucursal?->whatsapp ?? $sucursal?->phone ?? '';
                $whatsapp = preg_replace('/[^0-9]/', '', $whatsapp);
                $mensaje = urlencode('Hola, me interesa el servicio: ' . $service->name . '. ¿Me pueden dar más información?');
            @endphp

            <div style="display:flex;flex-direction:column;gap:12px;">
                @if($whatsapp)
                <a href="https://wa.me/593{{ ltrim($whatsapp, '0') }}?text={{ $mensaje }}" target="_blank" class="btn-whatsapp">
                    <svg style="width:22px;height:22px;flex-shrink:0;" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                    </svg>
                    Consultar por WhatsApp
                </a>
                @endif

                <a href="{{ route('contacto') }}" class="btn-contacto">
                    <svg style="width:16px;height:16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    Enviar consulta por formulario
                </a>

                <a href="{{ route('servicios') }}" style="text-align:center;font-size:13px;color:#94a3b8;text-decoration:none;padding:8px;display:block;">
                    ← Ver todos los servicios
                </a>
            </div>
        </div>
    </div>
</section>

{{-- GARANTÍAS --}}
<section style="padding:80px 24px;background:#f8fafc;">
    <div style="max-width:1100px;margin:0 auto;">
        <h2 style="font-family:'Playfair Display',serif;font-size:28px;font-weight:700;color:#0f172a;margin-bottom:32px;text-align:center;" class="reveal">
            Nuestro compromiso
        </h2>
        <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:24px;">
            @foreach([
                ['🔍', 'Diagnóstico incluido', 'Revisamos e informamos el problema y costo antes de proceder.'],
                ['🛡️', 'Garantía escrita', 'Todos los servicios incluyen garantía. Si falla, lo resolvemos sin costo.'],
                ['⚡', 'Entrega en 5 días', 'La mayoría de trabajos listos en máximo 5 días hábiles.'],
            ] as $i => $g)
            <div class="reveal" style="background:#fff;border:1px solid #e2e8f0;border-radius:20px;padding:24px;display:flex;flex-direction:column;gap:12px;transition-delay:{{ $i * 0.1 }}s">
                <span style="font-size:32px;">{{ $g[0] }}</span>
                <p style="font-weight:600;color:#0f172a;font-size:15px;">{{ $g[1] }}</p>
                <p style="color:#64748b;font-size:13px;font-weight:300;line-height:1.6;">{{ $g[2] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- CTA --}}
<section style="padding:80px 24px;background:linear-gradient(135deg,#1d4ed8 0%,#4f46e5 50%,#7c3aed 100%);">
    <div style="max-width:600px;margin:0 auto;text-align:center;">
        <h2 style="font-family:'Playfair Display',serif;font-size:32px;font-weight:700;color:#fff;margin-bottom:16px;" class="reveal">
            ¿Te interesa este servicio?
        </h2>
        <p style="color:#c7d2fe;font-weight:300;margin-bottom:32px;" class="reveal">
            Contáctanos hoy y recibe atención personalizada.
        </p>
        <a href="{{ route('servicios') }}"
           style="background:#fff;color:#1d4ed8;font-weight:600;font-size:14px;padding:14px 32px;border-radius:12px;text-decoration:none;display:inline-block;" class="reveal">
            Ver más servicios
        </a>
    </div>
</section>

@endsection

@push('scripts')
<script>
const observer = new IntersectionObserver((entries) => {
    entries.forEach(e => { if(e.isIntersecting) e.target.classList.add('visible'); });
}, { threshold: 0.1 });
document.querySelectorAll('.reveal').forEach(el => observer.observe(el));
</script>
@endpush
