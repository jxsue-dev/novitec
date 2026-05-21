@extends('layouts.app')

@section('title', 'Contacto – Novitecnología Cia. Ltda.')

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
<section class="relative pt-36 pb-24 px-6 overflow-hidden" style="background:linear-gradient(135deg,#020817 0%,#0c1a35 50%,#020817 100%);">
    <div class="absolute inset-0 pointer-events-none" style="background-image:linear-gradient(rgba(59,130,246,.04) 1px,transparent 1px),linear-gradient(90deg,rgba(59,130,246,.04) 1px,transparent 1px);background-size:60px 60px"></div>
    <div class="absolute top-0 right-0 w-96 h-96 rounded-full blur-3xl pointer-events-none" style="background:radial-gradient(circle,rgba(59,130,246,.15),transparent 70%)"></div>

    <div class="relative max-w-4xl mx-auto text-center">
        <p class="text-xs font-semibold tracking-widest uppercase text-blue-400 mb-4 reveal">Estamos aquí para ayudarte</p>
        <h1 class="font-serif text-5xl md:text-6xl font-bold text-white mb-6 reveal d1 leading-tight">
            Contáctanos
        </h1>
        <p class="text-slate-400 text-base font-light max-w-2xl mx-auto reveal d2 leading-relaxed">
            Escríbenos, llámanos o visítanos. Respondemos rápido y sin compromiso.
        </p>
    </div>
</section>

{{-- CANALES DE CONTACTO --}}
<section class="py-16 px-6 bg-white">
    <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-6">
        @foreach([
            ['📞', 'Llámanos', 'Atención telefónica en horario de oficina.', $branches->first()->phone ?? ''],
            ['✉️', 'Escríbenos', 'Respondemos en menos de 24 horas.', $branches->first()->email ?? ''],
            ['💬', 'WhatsApp', 'La forma más rápida de contactarnos.', 'Escribir ahora'],
        ] as $i => $c)
        <div class="bg-slate-50 border border-slate-100 rounded-2xl p-6 text-center hover:border-blue-200 hover:shadow-md transition-all reveal" style="transition-delay:{{ $i * 0.1 }}s">
            <div class="text-4xl mb-4">{{ $c[0] }}</div>
            <h3 class="font-semibold text-slate-900 text-sm mb-2">{{ $c[1] }}</h3>
            <p class="text-slate-500 text-xs font-light mb-3">{{ $c[2] }}</p>
            <p class="text-blue-600 text-sm font-medium">{{ $c[3] }}</p>
        </div>
        @endforeach
    </div>
</section>

{{-- SUCURSALES + FORMULARIO --}}
<section class="py-16 px-6" style="background:linear-gradient(135deg,#f8fafc 0%,#eff6ff 100%);">
    <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-12">

        {{-- SUCURSALES --}}
        <div class="reveal-left">
            <p class="text-xs font-semibold tracking-widest uppercase text-blue-600 mb-3">Dónde estamos</p>
            <h2 class="font-serif text-4xl font-bold text-slate-900 mb-8">Nuestras sucursales</h2>
            <div class="space-y-5">
                @foreach($branches as $branch)
                <div class="bg-white border border-slate-100 rounded-2xl p-5 hover:border-blue-200 hover:shadow-sm transition-all">
                    <h3 class="font-semibold text-slate-900 text-sm mb-3 flex items-center gap-2">
                        <span class="w-2 h-2 bg-blue-500 rounded-full animate-pulse"></span>
                        {{ $branch->name }}
                    </h3>
                    <div class="space-y-1.5 text-sm text-slate-500 font-light mb-3">
                        <p>📍 {{ $branch->address }}</p>
                        <p>📞 {{ $branch->phone }}</p>
                        @if($branch->email)<p>✉️ {{ $branch->email }}</p>@endif
                        @if($branch->schedule)<p>🕐 {{ $branch->schedule }}</p>@endif
                    </div>
                    @if($branch->whatsapp)
                    <a href="https://wa.me/{{ $branch->whatsapp }}" target="_blank"
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
                <form method="POST" action="{{ route('contacto.send') }}" class="space-y-4">
                    @csrf
                    <div class="grid grid-cols-2 gap-4">
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
                    <button type="submit"
                            class="w-full bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium py-3 rounded-xl transition-colors">
                        Enviar mensaje
                    </button>
                </form>
            </div>
        </div>

    </div>
</section>

{{-- REDES SOCIALES --}}
<section class="py-16 px-6 bg-white">
    <div class="max-w-3xl mx-auto text-center">
        <p class="text-xs font-semibold tracking-widest uppercase text-blue-600 mb-3 reveal">Síguenos</p>
        <h2 class="font-serif text-3xl font-bold text-slate-900 mb-8 reveal d1">Encuéntranos en redes</h2>
        <div class="flex justify-center gap-4 flex-wrap reveal d2">
            @foreach($socials as $social)
            <a href="{{ $social->url }}" target="_blank"
               class="border border-slate-200 hover:border-blue-400 hover:text-blue-600 text-slate-500 text-sm px-6 py-3 rounded-xl transition-all hover:shadow-sm">
                {{ $social->platform }}
            </a>
            @endforeach
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
const observer = new IntersectionObserver((entries) => {
    entries.forEach(e => { if(e.isIntersecting) e.target.classList.add('visible'); });
}, { threshold: 0.1 });
document.querySelectorAll('.reveal,.reveal-left,.reveal-right').forEach(el => observer.observe(el));
</script>
@endpush
