@extends('layouts.app')

@section('title', 'Términos y Condiciones – Novitec')

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
        <p class="text-xs font-semibold tracking-widest uppercase text-blue-400 mb-4 animate-pulse">Condiciones Generales del Servicio</p>
        <h1 class="font-serif text-4xl md:text-5xl font-bold text-white mb-6 leading-tight">
            Términos y Condiciones<br>
            <span style="background:linear-gradient(90deg,#60a5fa,#a78bfa);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">de Servicio Técnico y Garantía</span>
        </h1>
        <p class="text-slate-400 text-sm md:text-base font-light max-w-2xl mx-auto leading-relaxed">
            Consulte los términos que rigen el ingreso de equipos para soporte, políticas de garantías de hardware y condiciones de e-commerce de Novitec.
        </p>
    </div>
</section>

{{-- CONTENT SECTION --}}
<section class="py-16 px-6 bg-slate-50/50">
    <div class="max-w-7xl mx-auto flex flex-col lg:flex-row gap-12">
        
        {{-- TABLE OF CONTENTS (SIDEBAR) --}}
        <aside class="w-full lg:w-1/4 lg:sticky lg:top-28 h-fit self-start order-last lg:order-first">
            <div class="bg-white border border-slate-100 rounded-2xl p-6 shadow-sm">
                <h3 class="text-xs font-semibold tracking-widest uppercase text-slate-400 mb-4 font-bold">Navegación</h3>
                <nav class="table-of-contents flex flex-col gap-3.5 text-sm font-medium text-slate-500 pl-4 border-l border-slate-100">
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mt-2">1. Soporte y Servicio</p>
                    <a href="#st-validacion" class="hover:text-blue-600 active">Validación de Garantía</a>
                    <a href="#st-presupuesto" class="hover:text-blue-600">Emisión de Presupuesto</a>
                    <a href="#st-intento" class="hover:text-blue-600">Intento de Reparación</a>
                    <a href="#st-abandono" class="hover:text-blue-600">Equipos Abandonados</a>
                    <a href="#st-respaldo" class="hover:text-blue-600">Respaldo de Información</a>
                    <a href="#st-documentacion" class="hover:text-blue-600">Documentación</a>
                    <a href="#st-resolucion" class="hover:text-blue-600">Resolución de Controversias</a>
                    
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mt-4">2. Garantía Novitecnología</p>
                    <a href="#nc-cobertura" class="hover:text-blue-600">Cobertura de Hardware</a>
                    <a href="#nc-exclusiones" class="hover:text-blue-600">Exclusiones</a>
                    <a href="#nc-recomendaciones" class="hover:text-blue-600">Recomendaciones</a>
                    <a href="#nc-limitacion" class="hover:text-blue-600">Límite de Responsabilidad</a>
                    <a href="#nc-servicios" class="hover:text-blue-600">Servicios de Garantía</a>

                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mt-4">3. E-Commerce y Envíos</p>
                    <a href="#eco-envio" class="hover:text-blue-600">Despacho y Destinos</a>
                    <a href="#eco-reembolso" class="hover:text-blue-600">Políticas de Reembolso</a>
                    <a href="#eco-garantias" class="hover:text-blue-600">Garantías y Cambios</a>
                </nav>
            </div>
        </aside>

        {{-- MAIN DOCUMENT CONTENT --}}
        <div class="w-full lg:w-3/4 flex flex-col gap-10">
            
            {{-- SECCION 1: SERVICIO TECNICO NOVITEC --}}
            <div class="border-b border-slate-200 pb-2">
                <h2 class="text-xs font-bold tracking-widest uppercase text-blue-600">Sección 1</h2>
                <h3 class="font-serif text-3xl font-bold text-slate-900">Términos y Condiciones Novitec</h3>
                <p class="text-slate-500 font-light text-sm mt-1">Normativas que rigen el ingreso de equipos al taller de soporte técnico.</p>
            </div>

            <div id="st-validacion" class="policy-card bg-white">
                <h4 class="text-base font-bold text-slate-900 mb-3">1. Validación de Garantía</h4>
                <p class="text-slate-600 font-light leading-relaxed text-sm">
                    Los equipos que ingresen bajo esta condición deberán ser evaluados obligatoriamente por un técnico, quien determinará por escrito si éstos cumplen con las condiciones establecidas por los fabricantes y que están disponibles en la documentación y/o manuales suministrados por ellos.
                </p>
            </div>

            <div id="st-presupuesto" class="policy-card bg-white">
                <h4 class="text-base font-bold text-slate-900 mb-3">2. Emisión de Presupuesto</h4>
                <p class="text-slate-600 font-light leading-relaxed text-sm mb-4">
                    Si un equipo ingresa por validación de garantía, y éste no cumple con las condiciones establecidas por el fabricante, será tratado como <strong>"Fuera de Garantía"</strong>. En este caso, se emitirá un informe técnico con las novedades del equipo y un presupuesto aproximado de reparación, el mismo que podrá ser aceptado o negado por el cliente.
                </p>
                <div class="p-4 rounded-xl bg-slate-50 border border-slate-200 text-xs text-slate-700 space-y-2">
                    <p>• <strong>Caso de Rechazo o No Reparación:</strong> En el caso que el cliente niegue el presupuesto o el equipo no se pueda reparar, éste deberá cancelar el valor de revisión, que en todos los casos será de <strong>$28.00 USD + IVA</strong>.</p>
                    <p>• <strong>Caso de Aceptación:</strong> Si el cliente acepta reparar su equipo y el resultado final es que el equipo está operacional, solo se cobrará el valor presupuestado.</p>
                    <p>• <strong>Taller Externo:</strong> En caso que se necesite derivar el equipo a un taller externo para validación de garantía y ésta sea negada, el cliente deberá cancelar los valores por concepto de revisión o reparación que fije dicho taller externo de acuerdo a sus políticas.</p>
                </div>
            </div>

            <div id="st-intento" class="policy-card bg-white">
                <h4 class="text-base font-bold text-slate-900 mb-3">3. Intento de Reparación</h4>
                <p class="text-slate-600 font-light leading-relaxed text-sm">
                    El cliente es consciente que, al intentar reparar el equipo, es posible que éste sufra un daño mayor o irreparable y autoriza al Centro de Servicio a proceder con el intento de reparación por lo que, expresamente, libera a <strong>NOVITECNOLOGIA</strong> de cualquier responsabilidad por este concepto.
                </p>
            </div>

            <div id="st-abandono" class="policy-card bg-white">
                <h4 class="text-base font-bold text-slate-900 mb-3">4. Equipos Abandonados y Dación en Pago</h4>
                <div class="text-slate-600 font-light leading-relaxed text-sm space-y-4">
                    <p>
                        Se considerará como <strong>"abandonado"</strong> a todo equipo que no haya sido retirado después de <strong>30 días calendario</strong> de finalizada la reparación y/o de haber notificado al cliente la finalización de la revisión o reparación.
                    </p>
                    <div class="p-4 rounded-xl bg-amber-50 border border-amber-200 text-xs text-amber-800 space-y-2">
                        <p>• <strong>Cargos por Bodegaje:</strong> En caso de haberse cumplido este plazo sin que el cliente haya pagado sus valores adeudados, a dichos valores le serán sumados cargos adicionales por concepto de bodegaje y custodia por un monto de <strong>$1.00 USD diario</strong>.</p>
                        <p>• <strong>Abandono Definitivo (90 días):</strong> En caso de que el cliente no retire el equipo luego de transcurridos <strong>90 días calendario</strong>, se lo considerará como "abandono definitivo" y el cliente concederá la transferencia definitiva de la propiedad del equipo, pudiendo NOVITECNOLOGIA hacer uso de este como a bien tuviere.</p>
                    </div>
                </div>
            </div>

            <div id="st-respaldo" class="policy-card bg-white">
                <h4 class="text-base font-bold text-slate-900 mb-3">5. Respaldo de Información</h4>
                <p class="text-slate-600 font-light leading-relaxed text-sm mb-3">
                    El cliente es el único responsable de realizar el debido respaldo de toda la información contenida en su equipo. <strong>NOVITECNOLOGIA</strong> no asume responsabilidad alguna sobre la conservación, uso o pérdida de ningún tipo de información contenida en el equipo.
                </p>
                <p class="text-slate-600 font-light leading-relaxed text-sm">
                    El cliente acepta y autoriza a NOVITECNOLOGIA a tener acceso al contenido de su dispositivo, en la medida que fuese indispensable para cumplir con el objetivo de la revisión y/o reparación solicitada.
                </p>
            </div>

            <div id="st-documentacion" class="policy-card bg-white">
                <h4 class="text-base font-bold text-slate-900 mb-3">6. Documentación para Retiro</h4>
                <p class="text-slate-600 font-light leading-relaxed text-sm">
                    La orden de ingreso o documento emitido es el único documento válido para el retiro del equipo ingresado a NOVITECNOLOGIA. El cliente podrá, bajo su exclusiva responsabilidad, delegar a otra persona el retiro de su equipo o dispositivo, para lo cual bastará la presentación del original del documento de ingreso.
                </p>
                <p class="text-slate-600 font-light leading-relaxed text-sm mt-3">
                    NOVITECNOLOGIA se reserva el derecho de rechazar la entrega de un equipo en caso de que el documento esté ilegible, adulterado o por no ser el documento original.
                </p>
            </div>

            <div id="st-resolucion" class="policy-card bg-white">
                <h4 class="text-base font-bold text-slate-900 mb-3">7. Resolución de Controversias</h4>
                <p class="text-slate-600 font-light leading-relaxed text-sm mb-3">
                    La legislación aplicable a este contrato es la ecuatoriana. Las partes contratantes harán todo lo posible para resolver las controversias que surgieren en forma amistosa, de buena fe, mediante negociaciones directas, agotando todas las instancias incluidas mediación y arbitraje.
                </p>
                <p class="text-xs text-slate-500 bg-slate-50 p-4 rounded-xl border border-slate-100 font-light">
                    <strong>Aceptación de Términos:</strong> Con la suscripción del documento de ingreso técnico, el cliente declara haber leído, comprendido y aceptado las cláusulas descritas en todos sus aspectos, lo cual significa que conoce todas las condiciones de la reparación de su dispositivo. En tal sentido, una vez que el cliente ha estampado su firma, no podrá alegar desconocimiento de las condiciones aquí señaladas.
                </p>
                <div class="mt-4 text-xs text-slate-500 font-light">
                    • <strong>Contacto para baja de datos:</strong> informacion@novitec.com.ec. <br>
                    • <strong>Contacto para consultar estado de órdenes:</strong> 026001635 / 026001797 / 0960500156 (Quito) - 0960500158 (WhatsApp - Guayaquil) o mediante los correos soporte@novitec.com.ec / servicios@novitec.com.ec.
                </div>
            </div>

            {{-- SECCION 2: GARANTIA LIMITADA NOVITEC --}}
            <div class="mb-10 reveal">
                <h3 class="font-serif text-3xl font-bold text-slate-900">Garantía Limitada de Hardware Novitecnología</h3>
                <p class="text-slate-500 font-light text-sm mt-1">Garantía limitada concedida por NOVITECNOLOGIA CIA. LTDA. sobre productos comercializados.</p>
            </div>

            <div id="nc-cobertura" class="policy-card bg-white">
                <h4 class="text-base font-bold text-slate-900 mb-3">Cobertura y Territorio</h4>
                <div class="text-slate-600 font-light leading-relaxed text-sm space-y-4">
                    <p>
                        Esta garantía limitada de hardware comercializado por <strong>NOVITECNOLOGIA CIA. LTDA.</strong> le concede a usted, el cliente, los derechos otorgados expresamente por la compañía como comercializador de productos. No se ofrece ninguna otra condición o garantía expresa, oral o escrita, limitando la responsabilidad a los términos indicados.
                    </p>
                    <p>
                        <strong>Ámbito Geográfico:</strong> Tiene efecto en todas las provincias del Ecuador y se solicitará su cumplimiento en las ciudades de Quito y Guayaquil. Los productos adquiridos en una provincia pueden transferirse a otras sin que se anule la garantía.
                    </p>
                    <p>
                        <strong>Tiempos de Respuesta:</strong> El tiempo estándar de respuesta del servicio de garantía está sujeto a la disponibilidad de piezas a nivel local, determinándose en el diagnóstico inicial.
                    </p>
                    <div class="p-4 rounded-xl bg-red-50/50 border border-red-200/50 text-xs text-red-800">
                        <i class="fa-solid fa-triangle-exclamation"></i> NOVITECNOLOGIA CIA. LTDA. no se hace responsable de los gastos de traslado o envío de los productos hasta las oficinas técnicas de Quito o Guayaquil para ejecutar esta garantía.
                    </div>
                    <p>
                        <strong>Aplicabilidad:</strong> Aplica única y exclusivamente a productos de hardware comercializados por la empresa (demostrable mediante la factura de compra original) y no incluye ninguna aplicación de software, programas o productos de terceros.
                    </p>
                    <p>
                        <strong>Repuestos:</strong> Las piezas de repuesto utilizadas cuentan con una garantía de <strong>noventa (90) días</strong> o por el resto del período de garantía limitada original del producto (el que sea más extenso).
                    </p>
                </div>
            </div>

            <div id="nc-exclusiones" class="policy-card bg-white">
                <h4 class="text-base font-bold text-slate-900 mb-3">Exclusiones de Garantía</h4>
                <div class="text-slate-600 font-light leading-relaxed text-sm space-y-3">
                    <p>Esta garantía no cubre fallas ininterrumpidas o errores, ni se extiende a piezas consumibles o productos a los que se les haya extraído el número de serie. La garantía queda anulada por:</p>
                    <ul class="list-disc pl-5 space-y-1.5 font-light text-slate-500">
                        <li>Accidente, mala utilización, abuso, contaminación o mantenimiento inadecuado.</li>
                        <li>Uso bajo parámetros distintos a los establecidos en la documentación del usuario.</li>
                        <li>Uso de software, interfaces, piezas o repuestos no suministrados por NOVITECNOLOGIA CIA. LTDA.</li>
                        <li>Daños provocados por infección de virus informáticos.</li>
                        <li>Pérdida o daños ocurridos durante el transporte del equipo.</li>
                        <li>Modificación o servicios técnicos externos a los talleres de la empresa.</li>
                    </ul>
                </div>
            </div>

            <div id="nc-recomendaciones" class="policy-card bg-white">
                <h4 class="text-base font-bold text-slate-900 mb-3">Recomendaciones de Respaldo</h4>
                <p class="text-slate-600 font-light leading-relaxed text-sm">
                    Debe realizar copias de seguridad periódicas de los datos almacenados en el disco duro u otros dispositivos de almacenamiento. Antes de entregar un equipo para revisión de garantía, asegúrese de respaldar los datos y eliminar cualquier tipo de información confidencial o privada. 
                </p>
                <p class="text-slate-600 font-light leading-relaxed text-sm mt-3 font-semibold text-red-700">
                    La empresa no se responsabiliza de los daños, pérdidas de programas o datos, ni de la reinstalación de software distinto al sistema original.
                </p>
            </div>

            <div id="nc-limitacion" class="policy-card bg-white">
                <h4 class="text-base font-bold text-slate-900 mb-3">Limitación de Responsabilidad</h4>
                <p class="text-slate-600 font-light leading-relaxed text-sm">
                    La responsabilidad máxima de NOVITECNOLOGIA CIA. LTDA. bajo esta Garantía Limitada se reduce expresamente al reembolso del precio menor entre el precio abonado por el producto o el coste de la reparación/sustitución de cualquiera de los componentes de hardware con fallas bajo uso normal.
                </p>
                <p class="text-slate-600 font-light leading-relaxed text-sm mt-3">
                    No se asume responsabilidad alguna por daños indirectos, pérdida de beneficios empresariales, daños especiales o reclamaciones efectuadas por terceros.
                </p>
            </div>

            <div id="nc-servicios" class="policy-card bg-white">
                <h4 class="text-base font-bold text-slate-900 mb-3">Servicios de Garantía Excluidos</h4>
                <p class="text-slate-600 font-light leading-relaxed text-sm mb-3">
                    Los siguientes servicios de garantía <strong>NO</strong> aplican al producto de hardware adquirido:
                </p>
                <ul class="list-disc pl-5 space-y-1 font-light text-slate-500">
                    <li>Servicio de garantía de auto reparación por el cliente.</li>
                    <li>Servicio de garantía de retiro y devolución.</li>
                    <li>Servicio de garantía en taller o actualizaciones del servicio no autorizadas.</li>
                </ul>
                <p class="text-xs text-slate-500 bg-slate-50 p-4 rounded-xl border border-slate-100 mt-4 font-light">
                    Cualquier software y contenido digital preinstalado se entrega <strong>"tal cual"</strong> y no está garantizado por la empresa.
                </p>
            </div>

            {{-- SECCION 3: E-COMMERCE --}}
            <div class="border-b border-slate-200 pb-2 mt-8">
                <h2 class="text-xs font-bold tracking-widest uppercase text-blue-600">Sección 3</h2>
                <h3 class="font-serif text-3xl font-bold text-slate-900">Términos y Condiciones de Uso (E-commerce)</h3>
                <p class="text-slate-500 font-light text-sm mt-1">Condiciones que rigen el proceso de despacho, entregas y reembolsos de la tienda virtual.</p>
            </div>

            <div id="eco-envio" class="policy-card bg-white">
                <h4 class="text-base font-bold text-slate-900 mb-3">Despacho y Destinos</h4>
                <div class="text-slate-600 font-light leading-relaxed text-sm space-y-3">
                    <p>
                        Todo despacho será agendado después de que el pago del pedido sea plenamente confirmado por nuestra pasarela de pagos.
                    </p>
                    <ul class="list-disc pl-5 space-y-2 font-light">
                        <li><strong>Ciudad de Guayaquil:</strong> El despacho del pedido será dentro de <strong>48 horas</strong> laborables.</li>
                        <li><strong>Otros Destinos:</strong> El tiempo de entrega dependerá de la distancia del destino, tomándose entre <strong>48H hasta un máximo de 96H</strong>.</li>
                        <li><strong>Dirección y Entregas:</strong> Las entregas se realizan en la dirección brindada por el cliente en horarios de <strong>8:00 AM a 6:00 PM</strong>. En caso de errores en la dirección, el equipo se comunicará para confirmar facturación y receptor.</li>
                    </ul>
                </div>
            </div>

            <div id="eco-reembolso" class="policy-card bg-white">
                <h4 class="text-base font-bold text-slate-900 mb-3">Políticas de Reembolso</h4>
                <div class="text-slate-600 font-light leading-relaxed text-sm space-y-3">
                    <p>
                        Los reembolsos pueden tardar de <strong>30 a 90 días laborables</strong> debido al procesamiento interbancario y administrativo entre las agencias bancarias y NOVITECNOLOGIA CIA. LTDA.
                    </p>
                    <div class="p-4 rounded-xl bg-amber-50 border border-amber-200 text-xs text-amber-800">
                        <i class="fa-solid fa-triangle-exclamation"></i> Si el reembolso no se aplica el mismo día con el corte de los procesadores de tarjetas (DATAFAST o MEDIANET), el trámite se acogerá a los tiempos indicados anteriormente y adicionalmente se descontará una <strong>comisión bancaria del 10%</strong>.
                    </div>
                </div>
            </div>

            <div id="eco-garantias" class="policy-card bg-white">
                <h4 class="text-base font-bold text-slate-900 mb-3">Condiciones de Garantía y Cambios</h4>
                <div class="text-slate-600 font-light leading-relaxed text-sm space-y-3">
                    <p>
                        Todos nuestros productos cuentan con la garantía provista por el fabricante respectivo.
                    </p>
                    <ul class="list-disc pl-5 space-y-2 font-light">
                        <li><strong>Vigencia:</strong> Comienza desde la fecha de facturación (no desde la entrega del producto). Existen artículos de menor valor que no cuentan con garantía.</li>
                        <li><strong>Requisitos:</strong> Presentar el producto acompañado por la factura de compra original sin alteraciones.</li>
                        <li><strong>Cambio de Producto:</strong> Se realiza cambio físico del producto únicamente cuando no se pueda rehabilitar el artículo, cuando dicha rehabilitación demore más de 30 días, o cuando el costo de reparación supere el valor comercial del artículo.</li>
                        <li><strong>Exclusión por Daño Físico:</strong> La garantía cubre defectos de fábrica bajo uso doméstico normal. Daños físicos, golpes o evidencia de maltrato anulan automáticamente la garantía.</li>
                    </ul>
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
