@extends('layouts.app')

@section('title', 'Contacto – Servicio Técnico Novitec | Quito, Guayaquil y Manta')
@section('description', 'Contáctanos para servicio técnico en Ecuador. Sucursales en Quito (0960500156), Guayaquil (0960500158) y Manta (0998879638). Atención Lun-Vie 9:00-17:00. WhatsApp disponible.')
@section('keywords', 'contacto servicio técnico quito, teléfono novitec, sucursales novitec ecuador, whatsapp soporte técnico quito')

@section('content')

<style>
@import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;800&family=Inter:wght@300;400;500&display=swap');
body { font-family: 'Inter', sans-serif; }
.font-serif { font-family: 'Playfair Display', serif; }

.reveal { opacity:0; transform:translateY(30px); transition:opacity .8s ease,transform .8s ease; }
.reveal.visible { opacity:1; transform:translateY(0); }
.reveal-left { opacity:0; transform:translateX(-40px); transition:opacity .8s ease,transform .8s ease; }
.reveal-left.visible { opacity:1; transform:translateX(0); }
.reveal-right { opacity:0; transform:translateX(40px); transition:opacity .8s ease,transform .8s ease; }
.reveal-right.visible { opacity:1; transform:translateX(0); }
.d1{transition-delay:.1s}.d2{transition-delay:.2s}.d3{transition-delay:.3s}
</style>

{{-- HERO --}}
<section class="relative pt-24 pb-14 md:pt-32 md:pb-20 px-5 md:px-6 overflow-hidden" style="background:linear-gradient(135deg,#020817 0%,#0c1a35 50%,#020817 100%);">
    <div class="absolute inset-0 pointer-events-none" style="background-image:linear-gradient(rgba(59,130,246,.04) 1px,transparent 1px),linear-gradient(90deg,rgba(59,130,246,.04) 1px,transparent 1px);background-size:60px 60px"></div>
    <div class="absolute top-0 right-0 w-96 h-96 rounded-full blur-3xl pointer-events-none" style="background:radial-gradient(circle,rgba(59,130,246,.15),transparent 70%)"></div>

    <div class="relative max-w-4xl mx-auto text-center">
        <p class="text-xs font-semibold tracking-widest uppercase text-blue-400 mb-4 reveal">Estamos aquí para ayudarte</p>
        <h1 class="font-serif text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-6 reveal d1 leading-tight">
            Contáctanos
        </h1>
        <p class="text-slate-400 text-base font-light max-w-2xl mx-auto reveal d2 leading-relaxed">
            Escríbenos, llámanos o visítanos. Respondemos rápido y sin compromiso.
        </p>
    </div>
</section>

{{-- CANALES DE CONTACTO --}}
<section class="py-10 px-4 md:py-16 md:px-6 bg-white">
    <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-6">
        @foreach([
            ['fa-solid fa-phone', 'Llámanos', 'Atención telefónica en horario de oficina.', $branches->first()->phone ?? '', 'tel:' . ($branches->first()->phone ?? '')],
            ['fa-solid fa-envelope', 'Escríbenos', 'Respondemos en menos de 24 horas.', $branches->first()->email ?? '', 'mailto:' . ($branches->first()->email ?? '')],
            ['fa-brands fa-whatsapp', 'WhatsApp', 'La forma más rápida de contactarnos.', 'Escribir ahora', 'https://wa.me/593960500156'],
        ] as $i => $c)
        @if(!empty($c[4]))
        <a href="{{ $c[4] }}" target="_blank" class="block bg-slate-50 border border-slate-100 rounded-2xl p-6 text-center hover:border-blue-200 hover:shadow-md transition-all reveal hover:-translate-y-1" style="transition-delay:{{ $i * 0.1 }}s; text-decoration:none;">
        @else
        <div class="bg-slate-50 border border-slate-100 rounded-2xl p-6 text-center hover:border-blue-200 hover:shadow-md transition-all reveal" style="transition-delay:{{ $i * 0.1 }}s">
        @endif
            <div class="text-4xl mb-4 text-blue-600"><i class="{{ $c[0] }}"></i></div>
            <h3 class="font-semibold text-slate-900 text-sm mb-2">{{ $c[1] }}</h3>
            <p class="text-slate-500 text-xs font-light mb-3">{{ $c[2] }}</p>
            <p class="text-blue-600 text-sm font-medium">{{ $c[3] }}</p>
        @if(!empty($c[4]))
        </a>
        @else
        </div>
        @endif
        @endforeach
    </div>
</section>

{{-- SUCURSALES + FORMULARIO --}}
<section class="py-10 px-4 md:py-16 md:px-6" style="background:linear-gradient(135deg,#f8fafc 0%,#eff6ff 100%);">
    <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-8 md:gap-12">

        {{-- SUCURSALES --}}
        <div class="reveal-left">
            <p class="text-xs font-semibold tracking-widest uppercase text-blue-600 mb-3">Dónde estamos</p>
            <h2 class="font-serif text-4xl font-bold text-slate-900 mb-8">Nuestras sucursales</h2>
            <div class="space-y-5">
                @foreach($branches as $branch)
                <div onclick="openMap('{{ $branch->maps_url }}', '{{ $branch->name }}', '{{ $branch->address }}')"
                     class="bg-white border border-slate-100 rounded-2xl p-5 hover:border-blue-300 hover:shadow-md transition-all cursor-pointer group">
                    <h3 class="font-semibold text-slate-900 text-sm mb-3 flex items-center justify-between">
                        <span class="flex items-center gap-2">
                            <span class="w-2 h-2 bg-blue-500 rounded-full animate-pulse"></span>
                            {{ $branch->name }}
                        </span>
                        <span class="text-xs text-blue-500 opacity-0 group-hover:opacity-100 transition-opacity flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/></svg>
                            Ver en mapa
                        </span>
                    </h3>
                    <div class="space-y-1.5 text-sm text-slate-500 font-light mb-3">
                        <p class="flex items-center gap-2"><i class="fa-solid fa-location-dot text-blue-500"></i> {{ $branch->address }}</p>
                        <p><i class="fa-solid fa-phone text-blue-500"></i> {{ $branch->phone }}</p>
                        @if($branch->email)<p><i class="fa-solid fa-envelope text-blue-500"></i> {{ $branch->email }}</p>@endif
                        @if($branch->schedule)<p><i class="fa-solid fa-clock text-blue-500"></i> {{ $branch->schedule }}</p>@endif
                    </div>
                    @if($branch->whatsapp)
                    <a href="https://wa.me/{{ $branch->whatsapp }}" target="_blank"
                       onclick="event.stopPropagation()"
                       class="inline-flex items-center gap-2 bg-green-500 hover:bg-green-600 text-white text-xs font-medium px-4 py-2 rounded-lg transition-all">
                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                        WhatsApp
                    </a>
                    @endif
                </div>
                @endforeach
            </div>
        </div>

        {{-- FORMULARIO --}}
        <div class="reveal-right">
            <p class="text-xs font-semibold tracking-widest uppercase text-blue-600 mb-3">Formulario</p>
            <h2 class="font-serif text-4xl font-bold text-slate-900 mb-8">Envíanos un mensaje</h2>
            <div class="bg-white border border-slate-100 rounded-2xl p-6">
                @if(session('success'))
                <div class="mb-5 bg-green-50 border border-green-200 text-green-700 text-sm px-4 py-3 rounded-xl">
                    {{ session('success') }}
                </div>
                @endif
                <form method="POST" action="{{ route('contacto.send') }}" class="space-y-4" onsubmit="novSubmit(this)"
                    @csrf
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs text-slate-500 mb-1.5">Nombre *</label>
                            <input type="text" name="name" required value="{{ old('name') }}"
                                   class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-blue-400 transition-colors">
                            @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-xs text-slate-500 mb-1.5">Teléfono</label>
                            <input type="text" name="phone" value="{{ old('phone') }}"
                                   class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-blue-400 transition-colors">
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs text-slate-500 mb-1.5">Correo electrónico *</label>
                        <input type="email" name="email" required value="{{ old('email') }}"
                               class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-blue-400 transition-colors">
                        @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-xs text-slate-500 mb-1.5">Asunto *</label>
                        <select name="subject" required
                                class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-blue-400 transition-colors">
                            <option value="">Selecciona un asunto</option>
                            <option value="Reparación de equipo">Reparación de equipo</option>
                            <option value="Soporte IT">Soporte IT</option>
                            <option value="Redes">Redes</option>
                            <option value="CCTV">CCTV</option>
                            <option value="Cotización">Cotización</option>
                            <option value="Otro">Otro</option>
                        </select>
                        @error('subject')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-xs text-slate-500 mb-1.5">Mensaje *</label>
                        <textarea name="message" required rows="4"
                                  placeholder="Cuéntanos en qué podemos ayudarte..."
                                  class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-blue-400 transition-colors resize-none">{{ old('message') }}</textarea>
                        @error('message')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <button type="submit" id="contact-btn"
                            class="w-full bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium py-3 rounded-xl transition-colors flex items-center justify-center gap-2">
                        <span id="contact-btn-text">Enviar mensaje</span>
                        <svg id="contact-spinner" class="hidden animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"/></svg>
                    </button>
                </form>
            </div>
        </div>

    </div>
</section>

{{-- MODAL MAPA --}}
<div id="map-modal" class="fixed inset-0 z-50 hidden items-center justify-center p-4" style="background:rgba(0,0,0,0.7);backdrop-filter:blur(4px)">
    <div class="bg-white rounded-2xl overflow-hidden w-full max-w-2xl shadow-2xl">
        <div class="flex items-center justify-between px-5 py-4 border-b border-slate-100">
            <div>
                <p class="text-xs text-slate-400 font-light">Ubicación</p>
                <h3 id="map-title" class="text-slate-900 font-semibold text-sm"></h3>
            </div>
            <button onclick="closeMap()" class="w-8 h-8 flex items-center justify-center rounded-lg hover:bg-slate-100 transition-colors text-slate-500">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <div class="relative" style="height:380px;">
            <iframe id="map-iframe" src="" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
        </div>
        <div class="px-5 py-3 border-t border-slate-100 flex justify-end">
            <a id="map-link" href="#" target="_blank"
               class="text-xs text-blue-600 hover:text-blue-800 font-medium transition-colors">
                Abrir en Google Maps →
            </a>
        </div>
    </div>
</div>

{{-- REDES SOCIALES --}}
<section class="py-10 px-4 md:py-16 md:px-6 bg-white">
    <div class="max-w-3xl mx-auto text-center">
        <p class="text-xs font-semibold tracking-widest uppercase text-blue-600 mb-3 reveal">Síguenos</p>
        <h2 class="font-serif text-3xl font-bold text-slate-900 mb-8 reveal d1">Encuéntranos en redes</h2>
        <div class="flex justify-center gap-4 flex-wrap reveal d2">
            <a href="https://wa.me/593960500156" target="_blank"
               class="border border-green-200 hover:border-green-400 hover:text-green-600 text-slate-500 text-sm px-6 py-3 rounded-xl transition-all hover:shadow-sm flex items-center gap-2">
                <i class="fa-brands fa-whatsapp text-lg text-green-500"></i> WhatsApp
            </a>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
function novSubmit(form) {
    const btn = document.getElementById('contact-btn');
    const txt = document.getElementById('contact-btn-text');
    const spin = document.getElementById('contact-spinner');
    btn.disabled = true;
    btn.classList.add('opacity-75');
    txt.textContent = 'Enviando...';
    spin.classList.remove('hidden');
}
const observer = new IntersectionObserver((entries) => {
    entries.forEach(e => { if(e.isIntersecting) e.target.classList.add('visible'); });
}, { threshold: 0.1 });
document.querySelectorAll('.reveal,.reveal-left,.reveal-right').forEach(el => observer.observe(el));

function openMap(url, name, address) {
    const modal = document.getElementById('map-modal');
    const iframe = document.getElementById('map-iframe');
    const title = document.getElementById('map-title');
    const link = document.getElementById('map-link');

    title.textContent = name;

    if (url && url.length > 5) {
        iframe.src = url;
        link.href = url;
    } else {
        const encoded = encodeURIComponent(address);
        iframe.src = `https://maps.google.com/maps?q=${encoded}&output=embed&z=16`;
        link.href = `https://maps.google.com/?q=${encoded}`;
    }

    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closeMap() {
    const modal = document.getElementById('map-modal');
    const iframe = document.getElementById('map-iframe');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
    iframe.src = '';
}

document.getElementById('map-modal').addEventListener('click', function(e) {
    if (e.target === this) closeMap();
});
</script>
@endpush
