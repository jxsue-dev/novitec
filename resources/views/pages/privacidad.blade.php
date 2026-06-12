@extends('layouts.app')

@section('title', 'Política de Privacidad y Protección de Datos – Novitec')

@section('content')

<style>
@import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;800&family=Inter:wght@300;400;500;600&display=swap');
body { font-family: 'Inter', sans-serif; }
.font-serif { font-family: 'Playfair Display', serif; }

.policy-card {
    background: rgba(255, 255, 255, 0.6);
    backdrop-filter: blur(8px);
    border: 1px solid rgba(226, 232, 240, 0.8);
    border-radius: 20px;
    padding: 2.25rem;
    transition: all 0.3s ease;
}
.policy-card:hover {
    border-color: rgba(59, 130, 246, 0.4);
    box-shadow: 0 10px 30px rgba(59, 130, 246, 0.04);
}

.table-of-contents a {
    position: relative;
    transition: all 0.2s ease;
}
.table-of-contents a::before {
    content: '';
    position: absolute;
    left: -16px;
    top: 50%;
    transform: translateY(-50%);
    width: 6px;
    height: 6px;
    border-radius: 50%;
    background-color: #3b82f6;
    opacity: 0;
    transition: all 0.2s ease;
}
.table-of-contents a:hover::before,
.table-of-contents a.active::before {
    opacity: 1;
    transform: translateY(-50%) scale(1.2);
}
.table-of-contents a:hover,
.table-of-contents a.active {
    color: #2563eb;
    padding-left: 4px;
}

html {
    scroll-behavior: smooth;
}
</style>

{{-- HERO --}}
<section class="relative pt-36 pb-20 px-6 overflow-hidden" style="background:linear-gradient(135deg,#020817 0%,#0c1a35 50%,#020817 100%);">
    <div class="absolute inset-0 pointer-events-none" style="background-image:linear-gradient(rgba(59,130,246,.04) 1px,transparent 1px),linear-gradient(90deg,rgba(59,130,246,.04) 1px,transparent 1px);background-size:60px 60px"></div>
    <div class="absolute top-0 right-0 w-96 h-96 rounded-full blur-3xl pointer-events-none" style="background:radial-gradient(circle,rgba(139,92,246,.15),transparent 70%)"></div>
    <div class="absolute bottom-0 left-0 w-72 h-72 rounded-full blur-3xl pointer-events-none" style="background:radial-gradient(circle,rgba(59,130,246,.1),transparent 70%)"></div>

    <div class="relative max-w-4xl mx-auto text-center">
        <p class="text-xs font-semibold tracking-widest uppercase text-blue-400 mb-4">Marco Legal y Cumplimiento</p>
        <h1 class="font-serif text-4xl md:text-5xl font-bold text-white mb-6 leading-tight">
            Política de Privacidad y<br>
            <span style="background:linear-gradient(90deg,#60a5fa,#a78bfa);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">Protección de Datos Personales</span>
        </h1>
        <p class="text-slate-400 text-sm md:text-base font-light max-w-2xl mx-auto leading-relaxed">
            Cumplimiento de la Ley Orgánica de Protección de Datos Personales (LOPDP) y el Código Orgánico Integral Penal (COIP) de Ecuador.
        </p>
    </div>
</section>

{{-- CONTENT SECTION --}}
<section class="py-16 px-6 bg-slate-50/50">
    <div class="max-w-7xl mx-auto flex flex-col lg:flex-row gap-12">
        
        {{-- TABLE OF CONTENTS (SIDEBAR) --}}
        <aside class="w-full lg:w-1/4 lg:sticky lg:top-28 h-fit self-start order-last lg:order-first">
            <div class="bg-white border border-slate-100 rounded-2xl p-6 shadow-sm">
                <h3 class="text-xs font-semibold tracking-widest uppercase text-slate-400 mb-4 font-bold">Contenido</h3>
                <nav class="table-of-contents flex flex-col gap-3.5 text-sm font-medium text-slate-500 pl-4 border-l border-slate-100">
                    <a href="#introduccion" class="hover:text-blue-600 active">Introducción</a>
                    <a href="#lopdp" class="hover:text-blue-600">LOPDP y Claves</a>
                    <a href="#aplicacion-lopdp" class="hover:text-blue-600">Aplicación LOPDP</a>
                    <a href="#coip" class="hover:text-blue-600">COIP y Delitos</a>
                    <a href="#aplicacion-coip" class="hover:text-blue-600">Aplicación COIP</a>
                    <a href="#integracion" class="hover:text-blue-600">Integración Legal</a>
                    <a href="#responsable" class="hover:text-blue-600">Responsable del Tratamiento</a>
                    <a href="#marco-juridico" class="hover:text-blue-600">Marco Jurídico</a>
                    <a href="#clasificacion" class="hover:text-blue-600">Clasificación de Datos</a>
                    <a href="#acciones-checklist" class="hover:text-blue-600">Plan de Acciones</a>
                </nav>
            </div>
        </aside>

        {{-- MAIN DOCUMENT CONTENT --}}
        <div class="w-full lg:w-3/4 flex flex-col gap-10">
            
            {{-- INTRODUCCIÓN --}}
            <div id="introduccion" class="policy-card bg-white">
                <h2 class="font-serif text-2xl font-bold text-slate-900 mb-4 flex items-center gap-3">
                    <span class="w-8 h-8 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-sm font-bold">1</span>
                    Introducción
                </h2>
                <div class="text-slate-600 font-light leading-relaxed text-sm space-y-4">
                    <p>
                        El presente documento detalla el marco legal vigente en Ecuador en materia de protección de datos personales y delitos informáticos, aplicable a las operaciones de <strong>NOVISOLUTIONS CIA LTDA</strong>, bajo su nombre comercial <strong>Novicompu</strong>.
                    </p>
                    <p>
                        Se abordan las disposiciones de la Ley Orgánica de Protección de Datos Personales (LOPDP) y las secciones pertinentes del Código Orgánico Integral Penal (COIP), con el fin de establecer las directrices de cumplimiento y mitigar riesgos legales asociados al giro de negocio de la empresa.
                    </p>
                </div>
            </div>

            {{-- LOPDP --}}
            <div id="lopdp" class="policy-card bg-white">
                <h2 class="font-serif text-2xl font-bold text-slate-900 mb-4 flex items-center gap-3">
                    <span class="w-8 h-8 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-sm font-bold">2</span>
                    Ley Orgánica de Protección de Datos Personales (LOPDP)
                </h2>
                <div class="text-slate-600 font-light leading-relaxed text-sm space-y-4 mb-6">
                    <p>
                        La Ley Orgánica de Protección de Datos Personales fue publicada en el Registro Oficial Suplemento N° 459 el 26 de mayo de 2021, y se encuentra vigente en el Ecuador. Su objetivo primordial es garantizar el ejercicio del derecho a la protección de datos personales, que incluye el acceso y la decisión sobre dicha información.
                    </p>
                </div>
                
                <h3 class="text-xs font-semibold tracking-widest uppercase text-blue-600 mb-4">Claves de la LOPDP</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="p-4 rounded-xl bg-slate-50 border border-slate-100">
                        <h4 class="font-semibold text-slate-800 text-sm mb-2">Definición de Dato Personal</h4>
                        <p class="text-xs text-slate-500 leading-relaxed font-light">
                            Cualquier información que identifica o hace identificable a una persona natural, directa o indirectamente. Abarca información de clientes, empleados, proveedores y usuarios del sitio web.
                        </p>
                    </div>
                    <div class="p-4 rounded-xl bg-slate-50 border border-slate-100">
                        <h4 class="font-semibold text-slate-800 text-sm mb-2">Ámbito de Aplicación</h4>
                        <p class="text-xs text-slate-500 leading-relaxed font-light">
                            Aplica al tratamiento de datos personales de titulares que residan en Ecuador, independientemente de dónde esté establecido el responsable del tratamiento.
                        </p>
                    </div>
                    <div class="p-4 rounded-xl bg-slate-50 border border-slate-100">
                        <h4 class="font-semibold text-slate-800 text-sm mb-2">Rol como Responsable</h4>
                        <p class="text-xs text-slate-500 leading-relaxed font-light">
                            Novicompu determina los fines y medios del tratamiento, asumiendo la responsabilidad de cumplir los principios de licitud, lealtad, transparencia, minimización y confidencialidad.
                        </p>
                    </div>
                    <div class="p-4 rounded-xl bg-slate-50 border border-slate-100">
                        <h4 class="font-semibold text-slate-800 text-sm mb-2">Derechos de los Titulares</h4>
                        <p class="text-xs text-slate-500 leading-relaxed font-light">
                            Se deben garantizar los derechos de acceso, rectificación, supresión (olvido), oposición, portabilidad, limitación del tratamiento y a no ser objeto de decisiones automatizadas.
                        </p>
                    </div>
                </div>
            </div>

            {{-- APLICACION LOPDP --}}
            <div id="aplicacion-lopdp" class="policy-card bg-white">
                <h2 class="font-serif text-2xl font-bold text-slate-900 mb-4 flex items-center gap-3">
                    <span class="w-8 h-8 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-sm font-bold">3</span>
                    Detalles de Aplicación a NOVISOLUTIONS CIA LTDA
                </h2>
                <div class="text-slate-600 font-light leading-relaxed text-sm space-y-4 mb-6">
                    <p>
                        Como empresa que opera un comercio electrónico y maneja información de clientes y transacciones, Novicompu recopila y procesa datos personales (nombres, direcciones, números de identificación, datos de contacto y, potencialmente, información de pago).
                    </p>
                </div>
                <h3 class="text-xs font-semibold tracking-widest uppercase text-blue-600 mb-4">Acciones de Cumplimiento Requeridas:</h3>
                <div class="space-y-4">
                    <div class="flex gap-4 items-start">
                        <span class="w-6 h-6 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center text-xs font-semibold shrink-0">1</span>
                        <div>
                            <h4 class="text-sm font-semibold text-slate-800">Avisos de Privacidad</h4>
                            <p class="text-xs text-slate-500 font-light">Implementar avisos de privacidad claros y accesibles en el sitio web sobre el tratamiento de datos y los derechos de los titulares.</p>
                        </div>
                    </div>
                    <div class="flex gap-4 items-start">
                        <span class="w-6 h-6 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center text-xs font-semibold shrink-0">2</span>
                        <div>
                            <h4 class="text-sm font-semibold text-slate-800">Consentimiento Explícito</h4>
                            <p class="text-xs text-slate-500 font-light">Obtener el consentimiento explícito de los titulares para el tratamiento de sus datos, especialmente para fines publicitarios o no esenciales.</p>
                        </div>
                    </div>
                    <div class="flex gap-4 items-start">
                        <span class="w-6 h-6 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center text-xs font-semibold shrink-0">3</span>
                        <div>
                            <h4 class="text-sm font-semibold text-slate-800">Seguridad de la Información</h4>
                            <p class="text-xs text-slate-500 font-light">Implementar medidas técnicas y organizativas robustas contra el acceso no autorizado, alteración, divulgación o destrucción de datos.</p>
                        </div>
                    </div>
                    <div class="flex gap-4 items-start">
                        <span class="w-6 h-6 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center text-xs font-semibold shrink-0">4</span>
                        <div>
                            <h4 class="text-sm font-semibold text-slate-800">Gestión de Derechos</h4>
                            <p class="text-xs text-slate-500 font-light">Establecer procedimientos internos para atender de manera efectiva las solicitudes ARCO (Acceso, Rectificación, Cancelación, Oposición).</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- COIP --}}
            <div id="coip" class="policy-card bg-white">
                <h2 class="font-serif text-2xl font-bold text-slate-900 mb-4 flex items-center gap-3">
                    <span class="w-8 h-8 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-sm font-bold">4</span>
                    Código Orgánico Integral Penal (COIP)
                </h2>
                <div class="text-slate-600 font-light leading-relaxed text-sm space-y-4 mb-6">
                    <p>
                        El Código Orgánico Integral Penal (COIP) de Ecuador, promulgado el 10 de agosto de 2014, tipifica varios delitos que son directamente relevantes para la seguridad de la información y la protección de la privacidad en el contexto digital.
                    </p>
                </div>
                <h3 class="text-xs font-semibold tracking-widest uppercase text-blue-600 mb-4">Delitos Informáticos y Privacidad (COIP)</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="p-4 rounded-xl bg-slate-50 border border-slate-100">
                        <h4 class="font-semibold text-slate-800 text-sm mb-2">Inviolabilidad de la Vida Privada</h4>
                        <p class="text-xs text-slate-500 leading-relaxed font-light">
                            Se sanciona la violación de correspondencia o la difusión de información privada sin consentimiento (crucial para comunicaciones con clientes).
                        </p>
                    </div>
                    <div class="p-4 rounded-xl bg-slate-50 border border-slate-100">
                        <h4 class="font-semibold text-slate-800 text-sm mb-2">Acceso No Consentido a Sistemas</h4>
                        <p class="text-xs text-slate-500 leading-relaxed font-light">
                            Se penaliza a quien, sin autorización, acceda total o parcialmente a un sistema informático, telemático o de telecomunicaciones.
                        </p>
                    </div>
                    <div class="p-4 rounded-xl bg-slate-50 border border-slate-100">
                        <h4 class="font-semibold text-slate-800 text-sm mb-2">Destrucción de Información</h4>
                        <p class="text-xs text-slate-500 leading-relaxed font-light">
                            Sanción a quien destruya o inutilice información clasificada de conformidad con la ley, lo que incluye datos personales.
                        </p>
                    </div>
                    <div class="p-4 rounded-xl bg-slate-50 border border-slate-100">
                        <h4 class="font-semibold text-slate-800 text-sm mb-2">Fraude Informático</h4>
                        <p class="text-xs text-slate-500 leading-relaxed font-light">
                            Tipificación de fraude electrónico, que impacta directamente en las transacciones en línea y la seguridad financiera de los clientes.
                        </p>
                    </div>
                </div>
            </div>

            {{-- APLICACION COIP --}}
            <div id="aplicacion-coip" class="policy-card bg-white">
                <h2 class="font-serif text-2xl font-bold text-slate-900 mb-4 flex items-center gap-3">
                    <span class="w-8 h-8 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-sm font-bold">5</span>
                    Acciones de Cumplimiento COIP
                </h2>
                <div class="text-slate-600 font-light leading-relaxed text-sm space-y-4 mb-6">
                    <p>
                        Las disposiciones del COIP son fundamentales, ya que tipifican conductas que pueden derivar en responsabilidad penal tanto para terceros que atenten contra sus sistemas, como para la propia empresa o sus empleados si incurren en prácticas ilícitas.
                    </p>
                </div>
                <div class="space-y-4">
                    <div class="flex gap-4 items-start">
                        <span class="w-6 h-6 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center text-xs font-semibold shrink-0">1</span>
                        <div>
                            <h4 class="text-sm font-semibold text-slate-800">Ciberseguridad Reforzada</h4>
                            <p class="text-xs text-slate-500 font-light">Implementación de firewalls, cifrado de datos, autenticación robusta y sistemas de detección de intrusiones en la infraestructura web.</p>
                        </div>
                    </div>
                    <div class="flex gap-4 items-start">
                        <span class="w-6 h-6 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center text-xs font-semibold shrink-0">2</span>
                        <div>
                            <h4 class="text-sm font-semibold text-slate-800">Políticas de Uso de Sistemas</h4>
                            <p class="text-xs text-slate-500 font-light">Establecer políticas claras sobre el uso de los sistemas informáticos de la empresa para evitar la destrucción, alteración o revelación no autorizada.</p>
                        </div>
                    </div>
                    <div class="flex gap-4 items-start">
                        <span class="w-6 h-6 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center text-xs font-semibold shrink-0">3</span>
                        <div>
                            <h4 class="text-sm font-semibold text-slate-800">Respaldo y Recuperación de Datos</h4>
                            <p class="text-xs text-slate-500 font-light">Implementar sistemas de respaldo y planes de recuperación ante desastres para proteger la disponibilidad y la integridad de la información.</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- INTEGRACION --}}
            <div id="integracion" class="policy-card bg-white">
                <h2 class="font-serif text-2xl font-bold text-slate-900 mb-4 flex items-center gap-3">
                    <span class="w-8 h-8 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-sm font-bold">6</span>
                    Integración y Cumplimiento de LOPDP & COIP
                </h2>
                <div class="text-slate-600 font-light leading-relaxed text-sm space-y-4">
                    <p>
                        La LOPDP y el COIP son complementarios en la protección de la información. Mientras la LOPDP establece los derechos de los individuos sobre sus datos y las obligaciones de quienes los tratan, el COIP impone sanciones penales a las conductas que vulneran la privacidad y la seguridad de los sistemas informáticos.
                    </p>
                    <div class="p-5 rounded-2xl bg-amber-50/50 border border-amber-200/50 text-xs text-amber-800 space-y-2 mt-4">
                        <p class="font-semibold text-sm">Implicaciones Prácticas para el Negocio:</p>
                        <ul class="list-disc pl-5 space-y-1.5 font-light">
                            <li><strong>Gestión de Riesgos:</strong> Identificar y mitigar riesgos asociados a sanciones administrativas (LOPDP) y penales (COIP).</li>
                            <li><strong>Contratos con Terceros:</strong> Cláusulas obligatorias de protección de datos con proveedores de hosting y logística.</li>
                            <li><strong>Respuesta a Incidentes:</strong> Planes para notificar brechas de seguridad a la autoridad y realizar denuncias en caso de delitos informáticos.</li>
                        </ul>
                    </div>
                </div>
            </div>

            {{-- RESPONSABLE --}}
            <div id="responsable" class="policy-card bg-white">
                <h2 class="font-serif text-2xl font-bold text-slate-900 mb-4 flex items-center gap-3">
                    <span class="w-8 h-8 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-sm font-bold">7</span>
                    Identificación del Responsable del Tratamiento
                </h2>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm font-light text-slate-600 border-collapse">
                        <tbody>
                            <tr class="border-b border-slate-100"><td class="py-3 font-medium text-slate-900 w-1/3">Razón Social</td><td class="py-3">NOVISOLUTIONS CIA LTDA</td></tr>
                            <tr class="border-b border-slate-100"><td class="py-3 font-medium text-slate-900">Nombre Comercial</td><td class="py-3">Novicompu</td></tr>
                            <tr class="border-b border-slate-100"><td class="py-3 font-medium text-slate-900">RUC</td><td class="py-3">1792291666001</td></tr>
                            <tr class="border-b border-slate-100"><td class="py-3 font-medium text-slate-900">Sitio Web Oficial</td><td class="py-3"><a href="http://www.novicompu.com" target="_blank" class="text-blue-600 hover:underline">www.novicompu.com</a></td></tr>
                            <tr><td class="py-3 font-medium text-slate-900">Actividad Principal</td><td class="py-3">Comercialización de productos tecnológicos, electrónica de consumo y servicios relacionados a través de canales físicos y plataformas de comercio electrónico (E-commerce).</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- MARCO JURIDICO --}}
            <div id="marco-juridico" class="policy-card bg-white">
                <h2 class="font-serif text-2xl font-bold text-slate-900 mb-4 flex items-center gap-3">
                    <span class="w-8 h-8 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-sm font-bold">8</span>
                    Marco Jurídico Aplicable
                </h2>
                <div class="text-slate-600 font-light leading-relaxed text-sm space-y-3">
                    <p>El presente documento se fundamenta en la legislación ecuatoriana y normas técnicas internacionales de cumplimiento voluntario:</p>
                    <ol class="list-decimal pl-5 space-y-2 font-light">
                        <li><strong>Constitución de la República del Ecuador:</strong> Art. 66, numeral 19 (Derecho a la protección de datos de carácter personal).</li>
                        <li><strong>Ley Orgánica de Protección de Datos Personales (LOPDP):</strong> Publicada en el Registro Oficial Suplemento 459 el 26 de mayo de 2021. Es la norma matriz.</li>
                        <li><strong>Reglamento a la LOPDP:</strong> Normativa técnica para la implementación de medidas de seguridad y ejercicio de derechos.</li>
                        <li><strong>Código Orgánico Integral Penal (COIP):</strong> Artículos referidos a delitos contra la inviolabilidad de la privacidad e informáticos.</li>
                        <li><strong>Estándar Internacional ISO/IEC 27001 y 27701:</strong> Sistemas de Gestión de Seguridad de la Información (SGSI) y Gestión de Privacidad.</li>
                    </ol>
                </div>
            </div>

            {{-- CLASIFICACION --}}
            <div id="clasificacion" class="policy-card bg-white">
                <h2 class="font-serif text-2xl font-bold text-slate-900 mb-4 flex items-center gap-3">
                    <span class="w-8 h-8 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-sm font-bold">9</span>
                    Clasificación de Datos Tratados & Bases de Legitimación
                </h2>
                <div class="space-y-6">
                    <div>
                        <h3 class="text-xs font-semibold tracking-widest uppercase text-blue-600 mb-3">Clasificación de Datos Tratados</h3>
                        <ul class="list-disc pl-5 space-y-2 text-sm text-slate-600 font-light">
                            <li><strong>Datos Identificativos:</strong> Nombres, cédula, dirección física, correo electrónico, teléfono (Clientes y Empleados).</li>
                            <li><strong>Datos Financieros:</strong> Historial de compras, datos de tarjetas (procesados mediante pasarelas seguras), comportamiento crediticio.</li>
                            <li><strong>Datos Electrónicos:</strong> Direcciones IP, cookies de navegación, metadatos de transacciones.</li>
                        </ul>
                    </div>
                    <hr class="border-slate-100">
                    <div>
                        <h3 class="text-xs font-semibold tracking-widest uppercase text-blue-600 mb-3">Bases de Legitimación (Art. 7 LOPDP)</h3>
                        <ul class="list-disc pl-5 space-y-2 text-sm text-slate-600 font-light">
                            <li><strong>Ejecución de medidas contractuales:</strong> Para procesar la venta, facturación y entrega de productos.</li>
                            <li><strong>Consentimiento:</strong> Para el envío de publicidad, promociones y marketing digital.</li>
                            <li><strong>Obligación Legal:</strong> Para reportes tributarios (SRI) y prevención de lavado de activos.</li>
                        </ul>
                    </div>
                </div>
            </div>

            {{-- ACCIONES CHECKLIST --}}
            <div id="acciones-checklist" class="policy-card bg-white">
                <h2 class="font-serif text-2xl font-bold text-slate-900 mb-4 flex items-center gap-3">
                    <span class="w-8 h-8 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-sm font-bold">10</span>
                    Matriz de Acciones Obligatorias
                </h2>
                <p class="text-slate-500 text-xs font-light mb-6">Acciones para garantizar el cumplimiento de "Debida Diligencia" de acuerdo a la LOPDP y el COIP.</p>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs font-light text-slate-600 border-collapse">
                        <thead>
                            <tr class="border-b border-slate-200 text-slate-900 font-medium bg-slate-50">
                                <th class="py-3 px-4 w-1/4">Área / Apartado</th>
                                <th class="py-3 px-4 w-1/2">Acción Requerida</th>
                                <th class="py-3 px-4 w-1/4">Fundamento</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="border-b border-slate-100 hover:bg-slate-50/50">
                                <td class="py-4 px-4 font-medium text-slate-900">Oficial de Protección</td>
                                <td class="py-4 px-4">Designar un Oficial de Protección de Datos (DPO) si el volumen de datos es masivo.</td>
                                <td class="py-4 px-4">LOPDP</td>
                            </tr>
                            <tr class="border-b border-slate-100 hover:bg-slate-50/50">
                                <td class="py-4 px-4 font-medium text-slate-900">Contratos</td>
                                <td class="py-4 px-4">Incluir cláusulas de confidencialidad con proveedores de hosting y logística.</td>
                                <td class="py-4 px-4">LOPDP / COIP</td>
                            </tr>
                            <tr class="border-b border-slate-100 hover:bg-slate-50/50">
                                <td class="py-4 px-4 font-medium text-slate-900">Seguridad</td>
                                <td class="py-4 px-4">Cifrado de base de datos de clientes (AES-256) y protocolo HTTPS en la web.</td>
                                <td class="py-4 px-4">COIP / ISO 27001</td>
                            </tr>
                            <tr class="border-b border-slate-100 hover:bg-slate-50/50">
                                <td class="py-4 px-4 font-medium text-slate-900">Capacitación</td>
                                <td class="py-4 px-4">Formar al personal de ventas y bodega en manejo ético de datos.</td>
                                <td class="py-4 px-4">LOPDP</td>
                            </tr>
                            <tr class="hover:bg-slate-50/50">
                                <td class="py-4 px-4 font-medium text-slate-900">Transparencia</td>
                                <td class="py-4 px-4">Actualizar la "Política de Privacidad" visible en el pie de página de la web.</td>
                                <td class="py-4 px-4">LOPDP</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                
                <div class="mt-8 pt-6 border-t border-slate-100 text-center text-xs text-slate-400 font-light">
                    <p class="font-medium text-slate-600 mb-1">FIRMADO ELECTRÓNICAMENTE POR:</p>
                    <p class="text-slate-800 font-semibold">Abg. Stalin Rene Sacoto Zambrano M. Sc.</p>
                    <p>GERENTE GENERAL — NOVISOLUTIONS CIA LTDA</p>
                    <p class="text-blue-500">gerencia@novicompu.com</p>
                </div>
            </div>

        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const sections = document.querySelectorAll('div[id]');
    const navLinks = document.querySelectorAll('.table-of-contents a');

    window.addEventListener('scroll', () => {
        let current = '';
        sections.forEach(section => {
            const sectionTop = section.offsetTop - 150;
            if (window.pageYOffset >= sectionTop) {
                current = section.getAttribute('id');
            }
        });

        navLinks.forEach(link => {
            link.classList.remove('active');
            if (link.getAttribute('href') === `#${current}`) {
                link.classList.add('active');
            }
        });
    });
});
</script>

@endsection
