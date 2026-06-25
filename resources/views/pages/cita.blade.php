@extends('layouts.app')

@section('title', 'Agendar Cita de Servicio Técnico | Novitec Ecuador')
@section('description', 'Agenda tu cita de servicio técnico en Novitec. Reparación de computadoras, celulares e impresoras en Quito, Guayaquil y Manta. Selecciona fecha, hora y sucursal.')
@section('keywords', 'agendar cita servicio técnico quito, reservar turno reparación ecuador, cita técnica novitec')

@section('content')
<style>
@import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Inter:wght@300;400;500&display=swap');
body { font-family: 'Inter', sans-serif; }
.font-serif { font-family: 'Playfair Display', serif; }
.reveal { opacity:0; transform:translateY(30px); transition:opacity .8s ease,transform .8s ease; }
.reveal.visible { opacity:1; transform:translateY(0); }
</style>

{{-- HERO --}}
<section class="relative pt-24 pb-14 md:pt-32 md:pb-20 px-5 md:px-6 overflow-hidden" style="background:linear-gradient(135deg,#020817 0%,#0c1a35 50%,#020817 100%);">
    <div class="absolute inset-0 pointer-events-none" style="background-image:linear-gradient(rgba(59,130,246,.04) 1px,transparent 1px),linear-gradient(90deg,rgba(59,130,246,.04) 1px,transparent 1px);background-size:60px 60px"></div>
    <div class="relative max-w-3xl mx-auto text-center">
        <p class="text-xs font-semibold tracking-widest uppercase text-blue-400 mb-4 reveal">Reserva en línea</p>
        <h1 class="font-serif text-3xl sm:text-4xl md:text-5xl font-bold text-white mb-4 reveal leading-tight">
            Agenda tu cita de<br><span style="background:linear-gradient(90deg,#60a5fa,#a78bfa);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">servicio técnico</span>
        </h1>
        <p class="text-slate-400 text-sm font-light max-w-xl mx-auto reveal">
            Selecciona el servicio, fecha y sucursal. Te confirmaremos por teléfono o WhatsApp.
        </p>
    </div>
</section>

{{-- FORMULARIO --}}
<section class="py-14 px-4 md:py-20 md:px-6" style="background:linear-gradient(135deg,#f8fafc,#eff6ff);">
    <div class="max-w-2xl mx-auto">

        @if(session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-5 py-4 rounded-2xl flex items-center gap-3">
            <i class="fa-solid fa-circle-check text-green-500 text-lg"></i>
            <p class="text-sm font-medium">{{ session('success') }}</p>
        </div>
        @endif

        <div class="bg-white border border-slate-100 rounded-2xl p-6 md:p-8 shadow-sm reveal">
            <form method="POST" action="{{ route('cita.store') }}" class="space-y-5" onsubmit="novSubmit(this)">
                @csrf

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs text-slate-500 mb-1.5 font-medium">Nombre completo *</label>
                        <input type="text" name="name" required value="{{ old('name') }}"
                               class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-blue-400">
                        @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-xs text-slate-500 mb-1.5 font-medium">Teléfono / WhatsApp *</label>
                        <input type="text" name="phone" required value="{{ old('phone') }}"
                               class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-blue-400">
                        @error('phone')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div>
                    <label class="block text-xs text-slate-500 mb-1.5 font-medium">Correo electrónico *</label>
                    <input type="email" name="email" required value="{{ old('email') }}"
                           class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-blue-400">
                    @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs text-slate-500 mb-1.5 font-medium">Tipo de servicio *</label>
                        <select name="service" required class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-blue-400">
                            <option value="">Selecciona...</option>
                            <option value="Reparación computadora/laptop" {{ old('service') == 'Reparación computadora/laptop' ? 'selected' : '' }}>Reparación computadora/laptop</option>
                            <option value="Reparación celular/tablet" {{ old('service') == 'Reparación celular/tablet' ? 'selected' : '' }}>Reparación celular/tablet</option>
                            <option value="Reparación impresora" {{ old('service') == 'Reparación impresora' ? 'selected' : '' }}>Reparación impresora</option>
                            <option value="Soporte IT presencial" {{ old('service') == 'Soporte IT presencial' ? 'selected' : '' }}>Soporte IT presencial</option>
                            <option value="Instalación de redes" {{ old('service') == 'Instalación de redes' ? 'selected' : '' }}>Instalación de redes</option>
                            <option value="CCTV / Cámaras" {{ old('service') == 'CCTV / Cámaras' ? 'selected' : '' }}>CCTV / Cámaras</option>
                            <option value="Otro" {{ old('service') == 'Otro' ? 'selected' : '' }}>Otro</option>
                        </select>
                        @error('service')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-xs text-slate-500 mb-1.5 font-medium">Equipo / Marca / Modelo</label>
                        <input type="text" name="device" value="{{ old('device') }}" placeholder="Ej: Laptop HP 15, iPhone 13..."
                               class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-blue-400">
                    </div>
                </div>

                <div>
                    <label class="block text-xs text-slate-500 mb-1.5 font-medium">Describe el problema</label>
                    <textarea name="description" rows="3" placeholder="Cuéntanos brevemente qué le pasa a tu equipo..."
                              class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-blue-400 resize-none">{{ old('description') }}</textarea>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs text-slate-500 mb-1.5 font-medium">Fecha preferida *</label>
                        <input type="date" name="preferred_date" required value="{{ old('preferred_date') }}"
                               min="{{ now()->addDay()->toDateString() }}"
                               class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-blue-400">
                        @error('preferred_date')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-xs text-slate-500 mb-1.5 font-medium">Horario preferido *</label>
                        <select name="preferred_time" required class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-blue-400">
                            <option value="">Selecciona...</option>
                            <option value="09:00-11:00">09:00 – 11:00</option>
                            <option value="11:00-13:00">11:00 – 13:00</option>
                            <option value="14:00-16:00">14:00 – 16:00</option>
                            <option value="16:00-17:00">16:00 – 17:00</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs text-slate-500 mb-1.5 font-medium">Sucursal *</label>
                        <select name="branch" required class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-blue-400">
                            @foreach($branches as $branch)
                            <option value="{{ $branch->name }}">{{ $branch->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <button type="submit" id="cita-btn"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold py-3.5 rounded-xl transition-colors flex items-center justify-center gap-2">
                    <i class="fa-solid fa-calendar-check"></i>
                    <span id="cita-btn-text">Agendar cita</span>
                    <svg id="cita-spinner" class="hidden animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"/></svg>
                </button>

                <p class="text-xs text-slate-400 text-center">
                    <i class="fa-solid fa-shield-halved text-blue-400"></i>
                    Tus datos están protegidos. No compartimos tu información.
                </p>
            </form>
        </div>

        {{-- Info adicional --}}
        <div class="mt-8 grid grid-cols-1 sm:grid-cols-3 gap-4">
            @foreach([['fa-clock','Confirmación en 2h','Te llamamos para confirmar tu cita'],['fa-shield-halved','Diagnóstico incluido','Sin costo oculto antes de proceder'],['fa-circle-check','Garantía escrita','En todos nuestros servicios']] as $f)
            <div class="bg-white border border-slate-100 rounded-xl p-4 text-center">
                <i class="fa-solid {{ $f[0] }} text-blue-500 text-xl mb-2"></i>
                <p class="text-slate-900 text-xs font-semibold mb-1">{{ $f[1] }}</p>
                <p class="text-slate-400 text-xs font-light">{{ $f[2] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
function novSubmit(form) {
    const btn = document.getElementById('cita-btn');
    const txt = document.getElementById('cita-btn-text');
    const spin = document.getElementById('cita-spinner');
    btn.disabled = true; btn.classList.add('opacity-75');
    txt.textContent = 'Agendando...'; spin.classList.remove('hidden');
}
const observer = new IntersectionObserver(e => e.forEach(x => { if(x.isIntersecting) x.target.classList.add('visible'); }), {threshold:.1});
document.querySelectorAll('.reveal').forEach(el => observer.observe(el));
</script>
@endpush
