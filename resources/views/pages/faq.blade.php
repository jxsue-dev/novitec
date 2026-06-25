@extends('layouts.app')

@section('title', 'Preguntas Frecuentes | Novitec Ecuador')
@section('description', 'Respuestas a las preguntas más frecuentes sobre reparación de equipos, garantías, precios y procesos en Novitec. Servicio técnico en Ecuador.')
@section('keywords', 'preguntas frecuentes servicio técnico ecuador, FAQ reparación computadoras, dudas garantía novitec')

@section('content')
<style>
@import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Inter:wght@300;400;500&display=swap');
body { font-family: 'Inter', sans-serif; }
.font-serif { font-family: 'Playfair Display', serif; }
.reveal { opacity:0; transform:translateY(30px); transition:opacity .8s ease,transform .8s ease; }
.reveal.visible { opacity:1; transform:translateY(0); }
details summary { cursor:pointer; list-style:none; }
details summary::-webkit-details-marker { display:none; }
details[open] .faq-icon { transform:rotate(45deg); }
.faq-icon { transition:transform .3s ease; }
</style>

{{-- HERO --}}
<section class="relative pt-24 pb-14 md:pt-32 md:pb-20 px-5 md:px-6 overflow-hidden" style="background:linear-gradient(135deg,#020817 0%,#0c1a35 50%,#020817 100%);">
    <div class="absolute inset-0 pointer-events-none" style="background-image:linear-gradient(rgba(59,130,246,.04) 1px,transparent 1px),linear-gradient(90deg,rgba(59,130,246,.04) 1px,transparent 1px);background-size:60px 60px"></div>
    <div class="relative max-w-3xl mx-auto text-center">
        <p class="text-xs font-semibold tracking-widest uppercase text-blue-400 mb-4 reveal">Ayuda</p>
        <h1 class="font-serif text-3xl sm:text-4xl md:text-5xl font-bold text-white mb-4 reveal leading-tight">
            Preguntas <span style="background:linear-gradient(90deg,#60a5fa,#a78bfa);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">frecuentes</span>
        </h1>
        <p class="text-slate-400 text-sm font-light max-w-xl mx-auto reveal">
            Todo lo que necesitas saber sobre nuestros servicios, procesos y garantías.
        </p>
    </div>
</section>

{{-- FAQs --}}
<section class="py-14 px-4 md:py-20 md:px-6 bg-white">
    <div class="max-w-3xl mx-auto">

        @if($faqs->isEmpty())
        {{-- FAQs por defecto si la DB está vacía --}}
        @php
        $defaultFaqs = [
            'Reparaciones' => [
                ['¿Cuánto tiempo tarda una reparación?','La mayoría de reparaciones están listas en 1 a 5 días hábiles, dependiendo del diagnóstico y disponibilidad de repuestos. Siempre te informamos el tiempo estimado antes de proceder.'],
                ['¿Tienen garantía los servicios?','Sí, todos nuestros servicios incluyen garantía escrita. Si el mismo problema vuelve a ocurrir dentro del período de garantía, lo resolvemos sin costo adicional.'],
                ['¿Qué pasa si no se puede reparar mi equipo?','Si el diagnóstico indica que no es posible la reparación, te lo informamos y no cobramos por el diagnóstico. Solo cobras si aceptas proceder con el servicio.'],
                ['¿Usan repuestos originales?','Trabajamos con repuestos originales o de alta calidad certificada. Siempre te informamos qué tipo de repuesto se usará antes de realizar la reparación.'],
            ],
            'Precios' => [
                ['¿Cuánto cuesta el diagnóstico?','El diagnóstico inicial es incluido en el servicio. Si decides no proceder con la reparación después del diagnóstico, no se cobra.'],
                ['¿Cómo se paga?','Aceptamos efectivo, transferencia bancaria y tarjetas de crédito/débito. El pago se realiza al retirar el equipo.'],
            ],
            'Garantías' => [
                ['¿Cómo consulto el estado de mi garantía?','Puedes consultar el estado de tu garantía en la sección "Garantías" de nuestro sitio web ingresando tu número de orden o cédula.'],
                ['¿Qué cubre la garantía de los equipos?','Cubrimos defectos de fabricación y fallas técnicas no atribuibles a daños físicos o mal uso. Para ver los términos específicos por marca, visita nuestra sección de Soporte Autorizado.'],
            ],
            'General' => [
                ['¿Atienden a domicilio?','Sí, ofrecemos soporte IT presencial en Quito, Guayaquil y Manta. El costo de la visita depende de la ubicación y el tipo de servicio.'],
                ['¿Tienen soporte remoto?','Sí, brindamos soporte técnico remoto para software, configuraciones y problemas que no requieran intervención física. Contáctanos por WhatsApp para coordinarlo.'],
            ],
        ];
        @endphp

        @foreach($defaultFaqs as $category => $items)
        <div class="mb-10 reveal">
            <h2 class="font-serif text-xl font-bold text-slate-900 mb-4 pb-3 border-b border-slate-100">{{ $category }}</h2>
            <div class="space-y-3">
                @foreach($items as $faq)
                <details class="bg-slate-50 border border-slate-100 rounded-xl overflow-hidden group">
                    <summary class="flex items-center justify-between px-5 py-4 text-sm font-medium text-slate-900 hover:bg-slate-100 transition-colors">
                        {{ $faq[0] }}
                        <i class="fa-solid fa-plus faq-icon text-blue-500 flex-shrink-0 ml-4 text-xs"></i>
                    </summary>
                    <div class="px-5 pb-4 pt-1 text-sm text-slate-500 font-light leading-relaxed border-t border-slate-100">
                        {{ $faq[1] }}
                    </div>
                </details>
                @endforeach
            </div>
        </div>
        @endforeach

        @else
        @foreach($faqs as $category => $items)
        <div class="mb-10 reveal">
            <h2 class="font-serif text-xl font-bold text-slate-900 mb-4 pb-3 border-b border-slate-100 capitalize">{{ $category }}</h2>
            <div class="space-y-3">
                @foreach($items as $faq)
                <details class="bg-slate-50 border border-slate-100 rounded-xl overflow-hidden">
                    <summary class="flex items-center justify-between px-5 py-4 text-sm font-medium text-slate-900 hover:bg-slate-100 transition-colors">
                        {{ $faq->question }}
                        <i class="fa-solid fa-plus faq-icon text-blue-500 flex-shrink-0 ml-4 text-xs"></i>
                    </summary>
                    <div class="px-5 pb-4 pt-1 text-sm text-slate-500 font-light leading-relaxed border-t border-slate-100">
                        {!! nl2br(e($faq->answer)) !!}
                    </div>
                </details>
                @endforeach
            </div>
        </div>
        @endforeach
        @endif

        {{-- CTA --}}
        <div class="mt-12 bg-slate-900 rounded-2xl p-8 text-center reveal">
            <p class="text-white font-semibold mb-2">¿No encontraste tu respuesta?</p>
            <p class="text-slate-400 text-sm mb-5">Contáctanos directamente y te ayudamos.</p>
            <div class="flex flex-col sm:flex-row justify-center gap-3">
                <a href="{{ route('contacto') }}" class="bg-blue-600 hover:bg-blue-500 text-white text-sm font-medium px-6 py-3 rounded-xl transition-all">
                    Enviar pregunta
                </a>
                <a href="https://wa.me/593960500156" target="_blank" class="bg-green-600 hover:bg-green-500 text-white text-sm font-medium px-6 py-3 rounded-xl transition-all">
                    <i class="fa-brands fa-whatsapp mr-1"></i> WhatsApp
                </a>
            </div>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
const observer = new IntersectionObserver(e => e.forEach(x => { if(x.isIntersecting) x.target.classList.add('visible'); }), {threshold:.1});
document.querySelectorAll('.reveal').forEach(el => observer.observe(el));
</script>
@endpush
