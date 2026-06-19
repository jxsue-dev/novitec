@extends('layouts.app')

@section('title', 'Soporte Autorizado – Novitec')

@section('content')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
@import url('https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,700;0,9..144,900;1,9..144,700&family=Cabinet+Grotesk:wght@300;400;500;700;800&family=DM+Mono:wght@400;500&display=swap');

:root {
    --blue:   #1a56ff;
    --violet: #7c3aed;
    --gold:   #f5a623;
    --dark:   #080c14;
    --dark2:  #0d1424;
    --muted:  #64748b;
    --soft:   #f0f4ff;
    --fd: 'Fraunces', serif;
    --fb: 'Cabinet Grotesk', sans-serif;
    --fm: 'DM Mono', monospace;
}
* { box-sizing:border-box; }
body { font-family:var(--fb); }

@keyframes fade-up   { from{opacity:0;transform:translateY(36px)} to{opacity:1;transform:none} }
@keyframes fade-left { from{opacity:0;transform:translateX(40px)}  to{opacity:1;transform:none} }
@keyframes shimmer   { 0%{background-position:-300% center} 100%{background-position:300% center} }
@keyframes float     { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-10px)} }
@keyframes ping-dot  { 0%{transform:scale(1);opacity:.8} 100%{transform:scale(2.4);opacity:0} }
@keyframes brand-in  { from{opacity:0;transform:translateY(12px)} to{opacity:1;transform:none} }
@keyframes detail-in { from{opacity:0;transform:translateY(16px) scale(.98)} to{opacity:1;transform:none} }

.rv  { opacity:0; transform:translateY(32px); transition:opacity .85s cubic-bezier(.16,1,.3,1),transform .85s cubic-bezier(.16,1,.3,1); }
.rv.on { opacity:1; transform:none; }
.d1{transition-delay:.08s}.d2{transition-delay:.16s}.d3{transition-delay:.24s}.d4{transition-delay:.32s}

.shimmer-blue {
    background:linear-gradient(90deg,#60a5fa,#a78bfa,#60a5fa);
    background-size:300% auto;
    -webkit-background-clip:text; -webkit-text-fill-color:transparent;
    background-clip:text; animation:shimmer 4s linear infinite;
}

/* ══ HERO ══════════════════════════════════ */
.g-hero {
    position:relative; overflow:hidden;
    padding:8rem 3rem 4rem;
    background:linear-gradient(135deg,#020817 0%,#0c1a35 50%,#020817 100%);
}
.g-hero-grid {
    position:absolute; inset:0; pointer-events:none;
    background-image:linear-gradient(rgba(255,255,255,.025) 1px,transparent 1px),linear-gradient(90deg,rgba(255,255,255,.025) 1px,transparent 1px);
    background-size:48px 48px;
    mask-image:radial-gradient(ellipse 80% 80% at 50% 50%,black 30%,transparent 100%);
}
.g-hero-glow1 {
    position:absolute; top:-100px; right:-100px;
    width:500px; height:500px; border-radius:50%;
    background:radial-gradient(circle,rgba(26,86,255,.12),transparent 70%);
    pointer-events:none;
}
.g-hero-glow2 {
    position:absolute; bottom:-100px; left:-100px;
    width:400px; height:400px; border-radius:50%;
    background:radial-gradient(circle,rgba(124,58,237,.1),transparent 70%);
    pointer-events:none;
}
.g-hero-inner {
    position:relative; z-index:1;
    max-width:1280px; margin:0 auto;
    display:grid; grid-template-columns:1fr; text-align:center;
}
.g-hero-tag {
    display:inline-flex; align-items:center; gap:8px;
    font-family:var(--fm); font-size:.68rem; letter-spacing:.16em;
    text-transform:uppercase; color:#60a5fa;
    background:rgba(26,86,255,.08); border:1px solid rgba(26,86,255,.2);
    border-radius:4px; padding:6px 14px; margin:0 auto 1.75rem;
    animation:fade-up .6s .1s both;
    width:fit-content;
}
.g-hero-dot {
    width:6px; height:6px; border-radius:50%; background:#3b82f6;
    position:relative;
}
.g-hero-dot::after {
    content:''; position:absolute; inset:0; border-radius:50%;
    background:#3b82f6; animation:ping-dot 2s ease-in-out infinite;
}
.g-hero-h1 {
    font-family:var(--fd);
    font-size:clamp(2.2rem,4.5vw,3.8rem);
    font-weight:900; color:white; line-height:1.08;
    letter-spacing:-.03em; margin-bottom:1.25rem;
    animation:fade-up .7s .2s both;
}
.g-hero-h1 em { font-style:italic; }
.g-hero-p {
    font-size:1rem; color:rgba(255,255,255,.5);
    font-weight:300; line-height:1.8; max-width:620px;
    margin:0 auto 2rem; animation:fade-up .7s .3s both;
}

/* ══ CATEGORÍAS ══════════════════════════ */
.g-cats-sec {
    padding:6rem 3rem;
    background:linear-gradient(135deg,#f0f4ff 0%,#eef3ff 100%);
    position:relative; overflow:hidden;
}
.g-cats-sec::before {
    content:''; position:absolute; top:0; left:50%; transform:translateX(-50%);
    width:800px; height:1px;
    background:linear-gradient(to right,transparent,rgba(26,86,255,.2),transparent);
}
.g-sec-head { text-align:center; max-width:560px; margin:0 auto 3.5rem; }
.g-sec-tag {
    font-family:var(--fm); font-size:.68rem; font-weight:500;
    letter-spacing:.16em; text-transform:uppercase; color:var(--blue); margin-bottom:.6rem;
}
.g-sec-title {
    font-family:var(--fd); font-size:clamp(2rem,3.5vw,3rem);
    font-weight:900; color:#0f172a; line-height:1.06; letter-spacing:-.03em; margin-bottom:.6rem;
}
.g-sec-sub { font-size:.9rem; color:var(--muted); font-weight:300; line-height:1.7; }

.g-cats-grid {
    display:grid; grid-template-columns:repeat(7,1fr);
    gap:1rem; max-width:1100px; margin:0 auto;
}
.g-cat { perspective:900px; cursor:pointer; height:120px; }
.g-cat-inner {
    position:relative; width:100%; height:100%;
    transform-style:preserve-3d;
    transition:transform .6s cubic-bezier(.22,.68,0,1.1);
}
.g-cat:hover .g-cat-inner, .g-cat.active .g-cat-inner { transform:rotateY(180deg); }
.g-cat-face {
    position:absolute; inset:0; border-radius:20px;
    display:flex; flex-direction:column; align-items:center; justify-content:center;
    gap:.6rem; backface-visibility:hidden; -webkit-backface-visibility:hidden;
}
.g-cat-front {
    background:white; border:1px solid rgba(0,0,0,.06);
    box-shadow:0 2px 12px rgba(0,0,0,.04);
    transition:all .3s;
}
.g-cat:hover .g-cat-front { border-color:rgba(26,86,255,.15); box-shadow:0 8px 24px rgba(26,86,255,.1); }
.g-cat-back {
    background:linear-gradient(135deg,var(--blue),#4f46e5);
    transform:rotateY(180deg);
    box-shadow:0 12px 32px rgba(26,86,255,.3);
}
.g-cat-ico { font-size:1.6rem; color:var(--blue); transition:transform .3s; }
.g-cat:hover .g-cat-ico { transform:scale(1.1); }
.g-cat-back .g-cat-ico { color:rgba(255,255,255,.9); font-size:1.4rem; }
.g-cat-lbl {
    font-family:var(--fm); font-size:.62rem; font-weight:500;
    letter-spacing:.1em; text-transform:uppercase; color:var(--muted);
    text-align:center; transition:color .3s;
}
.g-cat:hover .g-cat-lbl { color:var(--blue); }
.g-cat-back .g-cat-lbl { color:rgba(255,255,255,.8); }

/* ══ BRANDS ════════════════════════════ */
.g-brands {
    max-height:0; overflow:hidden; background:white;
    transition:max-height .7s cubic-bezier(.22,.68,0,1),padding .5s;
    padding:0 3rem;
}
.g-brands.open {
    max-height:1800px; padding:3.5rem 3rem;
    border-top:1px solid rgba(0,0,0,.05);
    border-bottom:1px solid rgba(0,0,0,.05);
}
.g-brands-hdr {
    display:flex; align-items:center; justify-content:space-between;
    max-width:1100px; margin:0 auto 2rem; gap:1.5rem; flex-wrap:wrap;
}
.g-brands-title {
    font-family:var(--fd); font-size:1.8rem; font-weight:700;
    color:#0f172a; display:flex; align-items:center; gap:.75rem;
    letter-spacing:-.03em;
}
.g-brands-title i { color:var(--blue); font-size:1.4rem; }
.g-search-wrap { position:relative; }
.g-search-wrap i { position:absolute; left:13px; top:50%; transform:translateY(-50%); color:var(--muted); font-size:12px; pointer-events:none; }
.g-search {
    padding:10px 14px 10px 38px; background:#f8fafc;
    border:1px solid #e2e8f0; border-radius:10px;
    font-family:var(--fb); font-size:13px; color:#0f172a;
    outline:none; width:220px; transition:all .25s;
}
.g-search::placeholder { color:var(--muted); }
.g-search:focus { border-color:rgba(26,86,255,.4); box-shadow:0 0 0 3px rgba(26,86,255,.08); background:white; }

.g-brands-grid {
    display:grid; grid-template-columns:repeat(auto-fill,minmax(130px,1fr));
    grid-auto-rows:100px; gap:1rem; max-width:1100px; margin:0 auto;
}
.g-brand {
    display:flex; flex-direction:column; align-items:center; justify-content:center;
    padding:.85rem; background:#f8fafc; border:1px solid rgba(0,0,0,.06);
    border-radius:14px; cursor:pointer; text-align:center; height:100px;
    overflow:hidden; transition:all .35s cubic-bezier(.22,.68,0,1.2);
    animation:brand-in .4s ease both;
}
.g-brand:hover, .g-brand.active {
    transform:translateY(-5px); border-color:rgba(26,86,255,.2);
    box-shadow:0 12px 32px rgba(26,86,255,.1); background:white;
}
.g-brand-ico { font-size:1.5rem; color:rgba(26,86,255,.25); transition:all .3s; margin-bottom:.5rem; }
.g-brand-logo {
    width:32px; height:32px; object-fit:contain; margin-bottom:.5rem;
    opacity:.35; filter:grayscale(1); transition:all .3s;
}
.g-brand:hover .g-brand-logo, .g-brand.active .g-brand-logo { opacity:1; filter:none; transform:scale(1.1); }
.g-brand:hover .g-brand-ico, .g-brand.active .g-brand-ico { color:var(--blue); transform:scale(1.1); }
.g-brand-name {
    font-family:var(--fm); font-size:.6rem; font-weight:500;
    letter-spacing:.06em; text-transform:uppercase; color:var(--muted);
    transition:color .3s; overflow:hidden; display:-webkit-box;
    -webkit-line-clamp:2; -webkit-box-orient:vertical; word-break:break-word;
}
.g-brand:hover .g-brand-name, .g-brand.active .g-brand-name { color:var(--blue); }
.g-brand.hidden { display:none; }

/* ══ DETAIL ════════════════════════════ */
.g-detail {
    max-width:1100px; margin:2rem auto 0;
    border:1px solid rgba(0,0,0,.07); border-radius:20px;
    overflow:hidden; display:none;
    animation:detail-in .5s cubic-bezier(.22,.68,0,1.1);
}
.g-detail.show { display:grid; grid-template-columns:1fr 1fr; }
.g-detail-info {
    padding:2.5rem; background:white;
    border-right:1px solid rgba(0,0,0,.06);
}
.g-detail-name {
    font-family:var(--fd); font-size:2rem; font-weight:900;
    color:#0f172a; text-transform:uppercase; margin-bottom:.25rem;
    letter-spacing:-.03em;
}
.g-detail-cat {
    font-family:var(--fm); font-size:.65rem; font-weight:500;
    letter-spacing:.12em; text-transform:uppercase; color:var(--blue);
    margin-bottom:1.5rem; display:flex; align-items:center; gap:.5rem;
}
.g-detail-info h4 {
    font-family:var(--fd); font-size:1rem; font-weight:700;
    color:var(--blue); margin-bottom:.85rem;
}
.g-detail-info p {
    font-size:.84rem; line-height:1.75; color:var(--muted); margin-bottom:.65rem;
    padding:.75rem 1rem; background:#f8fafc; border-radius:10px;
    border-left:3px solid rgba(26,86,255,.15); transition:all .3s;
}
.g-detail-info p:hover { border-color:var(--blue); background:#eff6ff; color:#0f172a; }
.g-detail-info p strong { color:#0f172a; font-weight:600; }
.g-detail-info a { color:var(--blue); word-break:break-all; }
.g-detail-info a:hover { text-decoration:underline; }
.g-detail-map { position:relative; min-height:380px; background:#e8eef8; }
.g-detail-map iframe { width:100%; height:100%; border:none; display:block; min-height:380px; }

/* ══ RESPONSIVE ════════════════════════ */
@media (max-width:1100px) { .g-cats-grid { grid-template-columns:repeat(4,1fr); } }
@media (max-width:860px) {
    .g-hero-inner { grid-template-columns:1fr; gap:3rem; }
    .g-hero { padding:6rem 1.5rem 3rem; }
    .g-cats-sec,.g-brands.open { padding:4rem 1.5rem; }
    .g-brands { padding:0 1.5rem; }
    .g-detail.show { grid-template-columns:1fr; }
    .g-brands-hdr { flex-direction:column; align-items:flex-start; }
    .g-search { width:100%; }
}
@media (max-width:600px) {
    .g-cats-grid { grid-template-columns:repeat(3,1fr); gap:.75rem; }
    .g-brands-grid { grid-template-columns:repeat(auto-fill,minmax(110px,1fr)); }
}
</style>

{{-- ═══ HERO ═══ --}}
<section class="g-hero">
    <div class="g-hero-grid"></div>
    <div class="g-hero-glow1"></div>
    <div class="g-hero-glow2"></div>
    <div class="g-hero-inner">
        <div>
            <div class="g-hero-tag rv">
                <div class="g-hero-dot"></div>
                Soporte Oficial
            </div>
            <h1 class="g-hero-h1 rv d1">
                Marcas y Centros de<br><em class="shimmer-blue">Soporte Autorizado</em>
            </h1>
            <p class="g-hero-p rv d2">
                Consulta los centros de servicio técnico oficiales y marcas aliadas en Ecuador para tramitar tus garantías.
            </p>
        </div>
    </div>
</section>

{{-- ═══ CATEGORÍAS ═══ --}}
<section class="g-cats-sec">
    <div class="g-sec-head rv">
        <div class="g-sec-tag">Selecciona tu equipo</div>
        <h2 class="g-sec-title">¿Qué tipo de <em class="shimmer-blue" style="font-style:italic">equipo</em> tienes?</h2>
        <p class="g-sec-sub">Haz clic en la categoría para ver las marcas y el centro de soporte autorizado.</p>
    </div>
    <div class="g-cats-grid rv d1" id="gCatsGrid">
        @foreach([
            ['COMPUTADORAS','fa-solid fa-laptop','Computadoras'],
            ['CELULARES','fas fa-mobile-alt','Celulares'],
            ['TABLETS','fas fa-tablet-alt','Tablets'],
            ['IMPRESORAS','fa-solid fa-print','Impresoras'],
            ['TELEVISIONES','fa-solid fa-tv','Televisiones'],
            ['CONSOLAS','fa-solid fa-gamepad','Consolas'],
            ['OTROS','fa-solid fa-headphones','Otros'],
        ] as $cat)
        <div class="g-cat" data-cat="{{ $cat[0] }}">
            <div class="g-cat-inner">
                <div class="g-cat-face g-cat-front">
                    <span class="g-cat-ico"><i class="{{ $cat[1] }}"></i></span>
                    <span class="g-cat-lbl">{{ $cat[2] }}</span>
                </div>
                <div class="g-cat-face g-cat-back">
                    <span class="g-cat-ico"><i class="{{ $cat[1] }}"></i></span>
                    <span class="g-cat-lbl">Ver marcas</span>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</section>

{{-- ═══ BRANDS + DETAIL ═══ --}}
<section class="g-brands" id="gBrands">
    <div class="g-brands-hdr">
        <div class="g-brands-title">
            <i id="gActIcon" class="fa-solid fa-laptop"></i>
            <span id="gActName">COMPUTADORAS</span>
        </div>
        <div class="g-search-wrap">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input type="text" class="g-search" id="gSearch" placeholder="Buscar marca…">
        </div>
    </div>
    <div class="g-brands-grid" id="gBrandsGrid"></div>
    <div class="g-detail" id="gDetail">
        <div class="g-detail-info" id="gDetailInfo"></div>
        <div class="g-detail-map" id="gDetailMap"></div>
    </div>
</section>

@endsection

@push('scripts')
<script>
(function(){

const io = new IntersectionObserver(entries => {
    entries.forEach(e => { if(e.isIntersecting){ e.target.classList.add('on'); io.unobserve(e.target); } });
},{threshold:.1});
document.querySelectorAll('.rv,.rvl,.rvr').forEach(el => io.observe(el));

const CATS = {
    COMPUTADORAS:['HP','ASUS','LENOVO','ENV','DELL'],
    CELULARES:['SAMSUNG','XIAOMI','ENV','HONOR','INFINIX','TECNO','MOTOROLA','ITEL','VIVOQ','REALME'],
    TABLETS:['LENOVO','AMAZON','ONE','REALME','ENV','CHUWI','BLACKVIEW','DOOGEE','SAMSUNG','XIAOMI'],
    IMPRESORAS:['EPSON / CANNON / HP'],
    TELEVISIONES:['EVVO / TCL / ZITRO / RCA / HOUSETV','TCL / RCA / ZITRO','NAKAMICHI / BLAUPUNKT','SAMSUNG','DAEWO','MOTOROLA'],
    CONSOLAS:['SONY'],
    OTROS:['OSTER','JBL','TCL']
};
const CAT_ICO = {
    COMPUTADORAS:'fa-solid fa-laptop',CELULARES:'fas fa-mobile-alt',
    TABLETS:'fas fa-tablet-alt',IMPRESORAS:'fa-solid fa-print',
    TELEVISIONES:'fa-solid fa-tv',CONSOLAS:'fa-solid fa-gamepad',OTROS:'fa-solid fa-headphones'
};
const LOGOS = {
    HP:'https://cdn.simpleicons.org/hp/1a56ff',
    ASUS:'https://cdn.simpleicons.org/asus/1a56ff',
    LENOVO:'https://cdn.simpleicons.org/lenovo/1a56ff',
    DELL:'https://cdn.simpleicons.org/dell/1a56ff',
    SAMSUNG:'https://cdn.simpleicons.org/samsung/1a56ff',
    XIAOMI:'https://cdn.simpleicons.org/xiaomi/1a56ff',
    HONOR:'https://cdn.simpleicons.org/honor/1a56ff',
    MOTOROLA:'https://cdn.simpleicons.org/motorola/1a56ff',
    REALME:'https://cdn.simpleicons.org/realme/1a56ff',
    AMAZON:'https://cdn.simpleicons.org/amazon/1a56ff',
    SONY:'https://cdn.simpleicons.org/sony/1a56ff',
    JBL:'https://cdn.simpleicons.org/jbl/1a56ff',
    TCL:'https://cdn.simpleicons.org/tcl/1a56ff',
};
const ENV_LOGO = '{{ asset("images/novitec_logo.png") }}';
const INFO = {
    'HP':{contacto:'<h4>Soporte Técnico HP (NETSER)</h4><p><strong>Info:</strong> Generar ticket al 1800 225528 o 1800 7112884.</p><p><strong>Dirección UIO:</strong> Av. José Tamayo N24-490 y Luis Cordero, Locales 1 y 2.</p><p><strong>Teléfono:</strong> 02 5132593</p><p><strong>Horarios:</strong> 09:00 – 17:00 (Lun–Vie)</p>',mapa:'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3989.792961718442!2d-78.48581949999999!3d-0.2042792!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x91d59b1d4c00188d%3A0x36d12ff078b732b6!2sNetser%20Ecuador!5e0!3m2!1ses!2sec!4v1771882449251!5m2!1ses!2sec'},
    'ASUS':{contacto:'<h4>Soporte Técnico ASUS (COMPUHELP S.A)</h4><p><strong>Dirección UIO:</strong> Eloy Alfaro 2013 y Suiza.</p><p><strong>Teléfono:</strong> 2224-4026 / 2244-0298</p><p><strong>Horarios:</strong> 09:00 – 17:00 (Lun–Vie)</p>',mapa:'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3989.796968271351!2d-78.4807761!3d-0.18744819999999998!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x91d59a7eabc6e2cf%3A0x9f5cfeceeb34165b!2sCOMPUHELP%20S.A!5e0!3m2!1ses!2sec!4v1771873666698!5m2!1ses!2sec'},
    'LENOVO':{contacto:'<h4>Soporte Técnico LENOVO (INACORP S.A)</h4><p><strong>Info:</strong> Ticket en <a href="https://support.lenovo.com/ec/es/track-repair-status" target="_blank">support.lenovo.com</a></p><p><strong>Dirección UIO:</strong> Juan Severino E6-80 y Eloy Alfaro (Matriz)</p><p><strong>Teléfono:</strong> 2904-129</p><p><strong>Horarios:</strong> 09:00 – 17:00 (Lun–Vie)</p>',mapa:'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3989.7962715235344!2d-78.48358600000002!3d-0.19048199999999998!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x91d59a7a568e23e7%3A0x7b95f2b137507a92!2sInacorpsa%20Del%20Ecuador%20S.A.%20UIO!5e0!3m2!1ses!2sec!4v1771873792428!5m2!1ses!2sec'},
    'ENV':{contacto:'<h4>Soporte Técnico ENV (NOVITEC)</h4><p><strong>Dirección UIO:</strong> Calle N73 y Mariano Paredes (Ponceano Alto).</p><p><strong>Teléfono:</strong> 6001-635 / 0960500156</p><p><strong>Horarios:</strong> 09:00 – 17:00 (Lun–Vie)</p>',mapa:'https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d127673.5559056865!2d-78.5734424!3d-0.1800427!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x91d58585e2ade465%3A0x1da55fd6da94142c!2sNOVICOMPU%20-%20NOVITEC!5e0!3m2!1ses!2sec!4v1771873910567!5m2!1ses!2sec'},
    'DELL':{contacto:'<h4>Soporte Técnico DELL (PC LAPTOP)</h4><p><strong>Info:</strong> Ticket en <a href="https://www.dell.com/support/incidents-online/contactus" target="_blank">dell.com/support</a></p><p><strong>Dirección:</strong> Av. De los Shyris y República del Salvador, Edif. Alfa, PB</p><p><strong>Teléfono:</strong> 0999023049</p>',mapa:'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3989.797585641065!2d-78.4821468!3d-0.18471839999999998!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x91d59bdc59128d6d%3A0xc4289f6c0fae7e5e!2sPC%20LAPTOP%20ECUADOR!5e0!3m2!1ses!2sec!4v1771874050278!5m2!1ses!2sec'},
    'SAMSUNG':{contacto:'<h4>Soporte Técnico SAMSUNG (ELECSERVITEC)</h4><p><strong>Dirección:</strong> Av. Amazonas, CC El Globo</p><p><strong>Teléfono:</strong> 2436-686 / 2264-541</p><p><strong>Horarios:</strong> 09:30 – 18:00 (Lun–Vie)</p>',mapa:'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3989.801087924078!2d-78.48409579999999!3d-0.168397!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x91d59a890cb7a6d5%3A0xca1cef9b8e2681d!2sSamsung%20Smart%20Center%20%7C%20Quito!5e0!3m2!1ses!2sec!4v1771877685873!5m2!1ses!2sec'},
    'XIAOMI':{contacto:'<h4>Soporte Técnico XIAOMI (WODEN ECUADOR)</h4><p><strong>Dirección:</strong> Sector Carcelén industrial Antonio Flor, Quito</p><p><strong>Teléfono:</strong> 0963000279</p><p><strong>Horarios:</strong> 09:00 – 17:00 (Lun–Vie)</p>',mapa:'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3989.812100850824!2d-78.47660052515242!3d-0.10116693547878694!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x91d58f44752ced57%3A0x8fbe2f4a586f17f4!2sWoden%20Ecuador!5e0!3m2!1ses!2sec!4v1771877857771!5m2!1ses!2sec'},
    'HONOR':{contacto:'<h4>Soporte Técnico HONOR (WODEN ECUADOR)</h4><p><strong>Dirección:</strong> Sector Carcelén industrial Antonio Flor, Quito</p><p><strong>Teléfono:</strong> 0963000279</p><p><strong>Horarios:</strong> 09:00 – 17:00 (Lun–Vie)</p>',mapa:'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3989.812100850824!2d-78.47660052515242!3d-0.10116693547878694!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x91d58f44752ced57%3A0x8fbe2f4a586f17f4!2sWoden%20Ecuador!5e0!3m2!1ses!2sec!4v1771877857771!5m2!1ses!2sec'},
    'INFINIX':{contacto:'<h4>Soporte Técnico INFINIX (CARLCARE)</h4><p><strong>Dirección:</strong> Av. Diego de Almagro 1824 (antes de Whymper)</p><p><strong>Teléfono:</strong> 0962241641</p><p><strong>Horarios:</strong> 09:00 – 18:00 (Lun–Vie)</p>',mapa:'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3989.812100850824!2d-78.47660052515242!3d-0.10116693547878694!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x91d58f44752ced57%3A0x8fbe2f4a586f17f4!2sWoden%20Ecuador!5e0!3m2!1ses!2sec!4v1771877857771!5m2!1ses!2sec'},
    'TECNO':{contacto:'<h4>Soporte Técnico TECNO (CARLCARE)</h4><p><strong>Dirección:</strong> Av. Diego de Almagro 1824 (antes de Whymper)</p><p><strong>Teléfono:</strong> 0962241641</p><p><strong>Horarios:</strong> 09:00 – 18:00 (Lun–Vie)</p>',mapa:'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3989.812100850824!2d-78.47660052515242!3d-0.10116693547878694!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x91d58f44752ced57%3A0x8fbe2f4a586f17f4!2sWoden%20Ecuador!5e0!3m2!1ses!2sec!4v1771877857771!5m2!1ses!2sec'},
    'MOTOROLA':{contacto:'<h4>Soporte Técnico MOTOROLA (INDURAMA SERVIHOGAR)</h4><p><strong>Dirección:</strong> Av. Río Amazonas y Japón</p><p><strong>Teléfono:</strong> 0988766868</p><p><strong>Horarios:</strong> 09:30 – 18:00 (Lun–Vie)</p>',mapa:'https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d127673.99134149682!2d-78.5586632!3d-0.1001158!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x91d59a63c9b3405b%3A0x4cff6bd37292bc6b!2sIndurama%20Servihogar!5e0!3m2!1ses!2sec!4v1771880831150!5m2!1ses!2sec'},
    'ITEL':{contacto:'<h4>Soporte Técnico ITEL (NOVITEC)</h4><p><strong>Dirección UIO:</strong> Calle N73 y Mariano Paredes (Ponceano Alto).</p><p><strong>Teléfono:</strong> 6001-635 / 0960500156</p><p><strong>Horarios:</strong> 09:00 – 17:00 (Lun–Vie)</p>',mapa:'https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d127673.5559056865!2d-78.5734424!3d-0.1800427!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x91d58585e2ade465%3A0x1da55fd6da94142c!2sNOVICOMPU%20-%20NOVITEC!5e0!3m2!1ses!2sec!4v1771873910567!5m2!1ses!2sec'},
    'VIVOQ':{contacto:'<h4>Soporte Técnico VIVOQ (NOVITEC)</h4><p><strong>Dirección UIO:</strong> Calle N73 y Mariano Paredes (Ponceano Alto).</p><p><strong>Teléfono:</strong> 6001-635 / 0960500156</p><p><strong>Horarios:</strong> 09:00 – 17:00 (Lun–Vie)</p>',mapa:'https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d127673.5559056865!2d-78.5734424!3d-0.1800427!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x91d58585e2ade465%3A0x1da55fd6da94142c!2sNOVICOMPU%20-%20NOVITEC!5e0!3m2!1ses!2sec!4v1771873910567!5m2!1ses!2sec'},
    'REALME':{contacto:'<h4>Soporte Técnico REALME (NOVITEC)</h4><p><strong>Dirección UIO:</strong> Calle N73 y Mariano Paredes (Ponceano Alto).</p><p><strong>Teléfono:</strong> 6001-635 / 0960500156</p><p><strong>Horarios:</strong> 09:00 – 17:00 (Lun–Vie)</p>',mapa:'https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d127673.5559056865!2d-78.5734424!3d-0.1800427!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x91d58585e2ade465%3A0x1da55fd6da94142c!2sNOVICOMPU%20-%20NOVITEC!5e0!3m2!1ses!2sec!4v1771873910567!5m2!1ses!2sec'},
    'AMAZON':{contacto:'<h4>Soporte Técnico AMAZON (NOVITEC)</h4><p><strong>Dirección UIO:</strong> Calle N73 y Mariano Paredes (Ponceano Alto).</p><p><strong>Teléfono:</strong> 6001-635 / 0960500156</p><p><strong>Horarios:</strong> 09:00 – 17:00 (Lun–Vie)</p>',mapa:'https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d127673.5559056865!2d-78.5734424!3d-0.1800427!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x91d58585e2ade465%3A0x1da55fd6da94142c!2sNOVICOMPU%20-%20NOVITEC!5e0!3m2!1ses!2sec!4v1771873910567!5m2!1ses!2sec'},
    'ONE':{contacto:'<h4>Soporte Técnico ONE (NOVITEC)</h4><p><strong>Dirección UIO:</strong> Calle N73 y Mariano Paredes (Ponceano Alto).</p><p><strong>Teléfono:</strong> 6001-635 / 0960500156</p><p><strong>Horarios:</strong> 09:00 – 17:00 (Lun–Vie)</p>',mapa:'https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d127673.5559056865!2d-78.5734424!3d-0.1800427!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x91d58585e2ade465%3A0x1da55fd6da94142c!2sNOVICOMPU%20-%20NOVITEC!5e0!3m2!1ses!2sec!4v1771873910567!5m2!1ses!2sec'},
    'CHUWI':{contacto:'<h4>Soporte Técnico CHUWI (NOVITEC)</h4><p><strong>Dirección UIO:</strong> Calle N73 y Mariano Paredes (Ponceano Alto).</p><p><strong>Teléfono:</strong> 6001-635 / 0960500156</p><p><strong>Horarios:</strong> 09:00 – 17:00 (Lun–Vie)</p>',mapa:'https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d127673.5559056865!2d-78.5734424!3d-0.1800427!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x91d58585e2ade465%3A0x1da55fd6da94142c!2sNOVICOMPU%20-%20NOVITEC!5e0!3m2!1ses!2sec!4v1771873910567!5m2!1ses!2sec'},
    'BLACKVIEW':{contacto:'<h4>Soporte Técnico BLACKVIEW (NOVITEC)</h4><p><strong>Dirección UIO:</strong> Calle N73 y Mariano Paredes (Ponceano Alto).</p><p><strong>Teléfono:</strong> 6001-635 / 0960500156</p><p><strong>Horarios:</strong> 09:00 – 17:00 (Lun–Vie)</p>',mapa:'https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d127673.5559056865!2d-78.5734424!3d-0.1800427!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x91d58585e2ade465%3A0x1da55fd6da94142c!2sNOVICOMPU%20-%20NOVITEC!5e0!3m2!1ses!2sec!4v1771873910567!5m2!1ses!2sec'},
    'DOOGEE':{contacto:'<h4>Soporte Técnico DOOGEE (NOVITEC)</h4><p><strong>Dirección UIO:</strong> Calle N73 y Mariano Paredes (Ponceano Alto).</p><p><strong>Teléfono:</strong> 6001-635 / 0960500156</p><p><strong>Horarios:</strong> 09:00 – 17:00 (Lun–Vie)</p>',mapa:'https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d127673.5559056865!2d-78.5734424!3d-0.1800427!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x91d58585e2ade465%3A0x1da55fd6da94142c!2sNOVICOMPU%20-%20NOVITEC!5e0!3m2!1ses!2sec!4v1771873910567!5m2!1ses!2sec'},
    'EPSON / CANNON / HP':{contacto:'<h4>Soporte Técnico MULTIMARCA (SIGLO XXI)</h4><p><strong>Dirección:</strong> Sector El Cóndor OE5-32 y Edmundo Carvajal (sector el bosque)</p><p><strong>Teléfono:</strong> 0979685359</p><p><strong>Horarios:</strong> 09:00 – 18:00 (Lun–Vie)</p>',mapa:'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3989.802878179228!2d-78.4923714!3d-0.1594099!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x91d59abbde246e4b%3A0x445f794511ff7219!2sElectronica%20Siglo21%20UIO!5e0!3m2!1ses!2sec!4v1771879077466!5m2!1ses!2sec'},
    'EVVO / TCL / ZITRO / RCA / HOUSETV':{contacto:'<h4>Soporte Técnico MULTIMARCA (MASTERTECH)</h4><p><strong>Dirección UIO:</strong> Pascual de Andagoya y Antonio de Ulloa</p><p><strong>Teléfono:</strong> 0999219043</p><p><strong>Horarios:</strong> 09:00 – 17:00 (Lun–Vie)</p>',mapa:'https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d7979.591971845032!2d-78.5015497!3d-0.1917117!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x91d59bd5bcb49f99%3A0x2994c2ccc4b23028!2sMastertech!5e0!3m2!1ses!2sec!4v1771880007048!5m2!1ses!2sec'},
    'TCL / RCA / ZITRO':{contacto:'<h4>Soporte Técnico MULTIMARCA (SERMATEC)</h4><p><strong>Dirección UIO:</strong> Av. Napo (Frente al colegio Montúfar)</p><p><strong>Teléfono:</strong> 3131-265</p><p><strong>Horarios:</strong> 09:00 – 18:00 (Lun–Vie)</p>',mapa:'https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d127673.0808657145!2d-78.6542331!3d-0.2384203!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x91d599a2bcf41bef%3A0x52f93e829eb06047!2sSERMATEC!5e0!3m2!1ses!2sec!4v1771879905563!5m2!1ses!2sec'},
    'NAKAMICHI / BLAUPUNKT':{contacto:'<h4>Soporte Técnico MULTIMARCA (SERVIHOGAR)</h4><p><strong>Dirección UIO:</strong> Av. Río Amazonas y Japón</p><p><strong>Teléfono:</strong> 1700 500 700 / 0999303030</p><p><strong>Horarios:</strong> 09:00 – 17:00 (Lun–Vie)</p>',mapa:'https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d7979.591971845032!2d-78.5015497!3d-0.1917117!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x91d59bd5bcb49f99%3A0x2994c2ccc4b23028!2sMastertech!5e0!3m2!1ses!2sec!4v1771880007048!5m2!1ses!2sec'},
    'DAEWO':{contacto:'<h4>Soporte Técnico DAEWO (ENSAB)</h4><p><strong>Dirección:</strong> Vireti y San Jorge (Carapungo)</p><p><strong>Teléfono:</strong> 0983515579</p><p><strong>Horarios:</strong> 09:30 – 18:00 (Lun–Vie)</p>',mapa:'https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d3989.8120684266883!2d-78.445772!3d-0.1014303!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x91d58f0e357960a5%3A0x96d71c692b8ecaf1!2sEnsab!5e0!3m2!1ses!2sec!4v1771880502675!5m2!1ses!2sec'},
    'SONY':{contacto:'<h4>Soporte Técnico SONY (VIDEOAUDIO SISTEMAS)</h4><p><strong>Dirección:</strong> Av. 10 de Agosto y Falconi N42-49 (Sector la Y)</p><p><strong>Teléfono:</strong> 2921-473</p><p><strong>Horarios:</strong> 09:00 – 18:00 (Lun–Vie)</p>',mapa:'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3989.801782050693!2d-78.4865683!3d-0.16497059999999997!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x91d59b7a6c5320e1%3A0x9b067d912adb522b!2sVIDEOAUDIO%20SISTEMAS!5e0!3m2!1ses!2sec!4v1771881075361!5m2!1ses!2sec'},
    'OSTER':{contacto:'<h4>Soporte Técnico OSTER (SERVICIO MASTER ECUADOR)</h4><p><strong>Dirección:</strong> Capitán Rafael Ramos OE1-85 y Av. Galo Plaza Lasso</p><p><strong>Teléfono:</strong> 2813-882 / 2409-870</p><p><strong>Horarios:</strong> 09:00 – 17:00 (Lun–Vie)</p>',mapa:'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3989.8045086112934!2d-78.4850859!3d-0.1507597!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x91d59aadddb56ca9%3A0x991fd5eeb723e2d8!2sServicio%20Master%20Ecuador!5e0!3m2!1ses!2sec!4v1771881726521!5m2!1ses!2sec'},
    'JBL':{contacto:'<h4>Soporte Técnico JBL (NOVITEC)</h4><p><strong>Dirección UIO:</strong> Calle N73 y Mariano Paredes (Ponceano Alto).</p><p><strong>Teléfono:</strong> 6001-635 / 0960500156</p><p><strong>Horarios:</strong> 09:00 – 17:00 (Lun–Vie)</p>',mapa:'https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d127673.5559056865!2d-78.5734424!3d-0.1800427!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x91d58585e2ade465%3A0x1da55fd6da94142c!2sNOVICOMPU%20-%20NOVITEC!5e0!3m2!1ses!2sec!4v1771873910567!5m2!1ses!2sec'},
    'TCL':{contacto:'<h4>Soporte Técnico TCL (MASTERTECH)</h4><p><strong>Dirección UIO:</strong> Pascual de Andagoya y Antonio de Ulloa</p><p><strong>Teléfono:</strong> 0999219043</p><p><strong>Horarios:</strong> 09:00 – 17:00 (Lun–Vie)</p>',mapa:'https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d7979.591971845032!2d-78.5015497!3d-0.1917117!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x91d59bd5bcb49f99%3A0x2994c2ccc4b23028!2sMastertech!5e0!3m2!1ses!2sec!4v1771880007048!5m2!1ses!2sec'},
};

let currentCat = null;

document.getElementById('gCatsGrid').addEventListener('click', e => {
    const card = e.target.closest('.g-cat');
    if(!card) return;
    const cat = card.dataset.cat;
    if(currentCat === cat){
        card.classList.remove('active');
        document.getElementById('gBrands').classList.remove('open');
        document.getElementById('gDetail').classList.remove('show');
        currentCat = null; return;
    }
    document.querySelectorAll('.g-cat.active').forEach(c => c.classList.remove('active'));
    card.classList.add('active');
    currentCat = cat;
    document.getElementById('gActIcon').className = CAT_ICO[cat] || 'fa-solid fa-star';
    document.getElementById('gActName').textContent = cat;
    document.getElementById('gSearch').value = '';
    document.getElementById('gDetail').classList.remove('show');
    renderBrands(cat);
    document.getElementById('gBrands').classList.add('open');
    setTimeout(() => document.getElementById('gBrands').scrollIntoView({behavior:'smooth',block:'start'}), 140);
});

function renderBrands(cat){
    const grid = document.getElementById('gBrandsGrid');
    grid.innerHTML = '';
    const fallback = CAT_ICO[cat] || 'fas fa-circle';
    (CATS[cat]||[]).forEach((name, i) => {
        const btn = document.createElement('div');
        btn.className = 'g-brand';
        btn.style.animationDelay = (i * 40) + 'ms';
        let iconEl;
        if(name === 'ENV'){
            iconEl = document.createElement('img');
            iconEl.src = ENV_LOGO; iconEl.className = 'g-brand-logo'; iconEl.alt = 'ENV';
        } else if(LOGOS[name]){
            iconEl = document.createElement('img');
            iconEl.src = LOGOS[name]; iconEl.className = 'g-brand-logo'; iconEl.alt = name;
            iconEl.onerror = function(){
                const f = document.createElement('i');
                f.className = fallback + ' g-brand-ico';
                btn.replaceChild(f, this);
            };
        } else {
            iconEl = document.createElement('i');
            iconEl.className = fallback + ' g-brand-ico';
        }
        const nameEl = document.createElement('span');
        nameEl.className = 'g-brand-name'; nameEl.textContent = name;
        btn.appendChild(iconEl); btn.appendChild(nameEl);
        btn.addEventListener('click', () => showBrand(name, cat, btn));
        grid.appendChild(btn);
    });
}

document.getElementById('gSearch').addEventListener('input', e => {
    const q = e.target.value.toLowerCase().trim();
    document.querySelectorAll('.g-brand').forEach(b => {
        b.classList.toggle('hidden', q !== '' && !b.querySelector('.g-brand-name').textContent.toLowerCase().includes(q));
    });
});

function showBrand(name, cat, btn){
    document.querySelectorAll('.g-brand.active').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    const data = INFO[name];
    const det = document.getElementById('gDetail');
    det.classList.remove('show');
    if(data){
        document.getElementById('gDetailInfo').innerHTML =
            `<div class="g-detail-name">${name}</div>
             <div class="g-detail-cat"><i class="${CAT_ICO[cat]||''}"></i> ${cat}</div>
             ${data.contacto}`;
        document.getElementById('gDetailMap').innerHTML =
            `<iframe src="${data.mapa}" allowfullscreen loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>`;
    }
    void det.offsetWidth;
    det.classList.add('show');
    setTimeout(() => det.scrollIntoView({behavior:'smooth',block:'nearest'}), 100);
}

})();
</script>
@endpush
