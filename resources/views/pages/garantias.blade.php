@extends('layouts.app')

@section('title', 'Consulta tu Garantía | Centro de Garantías Novitec Ecuador')
@section('description', 'Consulta el estado de tu equipo en garantía en línea. Novitec es centro de soporte autorizado para HP, ASUS, Lenovo, Samsung, Xiaomi y más marcas en Ecuador.')
@section('keywords', 'garantía equipo ecuador, centro garantías quito, servicio autorizado HP ecuador, consultar garantía novitec, estado orden reparación')

@section('content')

@if(config('services.turnstile.site'))
<script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>
@endif

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
@keyframes line-grow { to{transform:scaleX(1)} }
@keyframes brand-in  { from{opacity:0;transform:translateY(12px)} to{opacity:1;transform:none} }
@keyframes detail-in { from{opacity:0;transform:translateY(16px) scale(.98)} to{opacity:1;transform:none} }
@keyframes card-in   { from{opacity:0;transform:translateY(14px)} to{opacity:1;transform:none} }

.rv  { opacity:0; transform:translateY(32px); transition:opacity .85s cubic-bezier(.16,1,.3,1),transform .85s cubic-bezier(.16,1,.3,1); }
.rvl { opacity:0; transform:translateX(-32px); transition:opacity .85s cubic-bezier(.16,1,.3,1),transform .85s cubic-bezier(.16,1,.3,1); }
.rvr { opacity:0; transform:translateX(32px);  transition:opacity .85s cubic-bezier(.16,1,.3,1),transform .85s cubic-bezier(.16,1,.3,1); }
.rv.on,.rvl.on,.rvr.on { opacity:1; transform:none; }
.d1{transition-delay:.08s}.d2{transition-delay:.16s}.d3{transition-delay:.24s}.d4{transition-delay:.32s}

.shimmer-blue {
    background:linear-gradient(90deg,#60a5fa,#a78bfa,#60a5fa);
    background-size:300% auto;
    -webkit-background-clip:text; -webkit-text-fill-color:transparent;
    background-clip:text; animation:shimmer 4s linear infinite;
}
.shimmer-gold {
    background:linear-gradient(90deg,#f5a623,#fbbf24,#f5a623);
    background-size:300% auto;
    -webkit-background-clip:text; -webkit-text-fill-color:transparent;
    background-clip:text; animation:shimmer 3s linear infinite;
}

/* ══ HERO ══════════════════════════════════ */
.g-hero {
    position:relative; overflow:hidden;
    padding:9rem 3rem 6rem;
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
    display:grid; grid-template-columns:1.2fr 1fr; gap:5rem; align-items:center;
}
.g-hero-tag {
    display:inline-flex; align-items:center; gap:8px;
    font-family:var(--fm); font-size:.68rem; letter-spacing:.16em;
    text-transform:uppercase; color:#60a5fa;
    background:rgba(26,86,255,.08); border:1px solid rgba(26,86,255,.2);
    border-radius:4px; padding:6px 14px; margin-bottom:1.75rem;
    animation:fade-up .6s .1s both;
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
    font-size:clamp(2.8rem,5vw,5rem);
    font-weight:900; color:white; line-height:1.04;
    letter-spacing:-.03em; margin-bottom:1.25rem;
    animation:fade-up .7s .2s both;
}
.g-hero-h1 em { font-style:italic; }
.g-hero-p {
    font-size:1rem; color:rgba(255,255,255,.5);
    font-weight:300; line-height:1.8; max-width:480px;
    margin-bottom:2.5rem; animation:fade-up .7s .3s both;
}

/* Reglas */
.g-rules { display:flex; flex-direction:column; gap:.5rem; animation:fade-up .7s .35s both; }
.g-rule {
    display:flex; align-items:flex-start; gap:1rem;
    padding:.85rem 1rem;
    background:rgba(255,255,255,.03);
    border:1px solid rgba(255,255,255,.06);
    border-radius:12px;
    opacity:0; transform:translateX(-16px);
    transition:opacity .5s ease,transform .5s ease,background .3s,border-color .3s;
}
.g-rule.on { opacity:1; transform:none; }
.g-rule:hover { background:rgba(255,255,255,.06); border-color:rgba(26,86,255,.2); }
.g-rule-n {
    font-family:var(--fd); font-size:1.1rem; font-weight:700;
    color:rgba(26,86,255,.4); line-height:1.4; flex-shrink:0; width:20px;
    transition:color .3s;
}
.g-rule:hover .g-rule-n { color:#60a5fa; }
.g-rule-t { font-size:.82rem; line-height:1.7; color:rgba(255,255,255,.45); }
.g-rule-t strong { color:rgba(255,255,255,.8); font-weight:600; }

/* Stats lado derecho */
.g-hero-right { display:flex; flex-direction:column; gap:1.25rem; }
.g-stat-card {
    background:rgba(255,255,255,.04);
    border:1px solid rgba(255,255,255,.07);
    border-radius:20px; padding:1.75rem 2rem;
    position:relative; overflow:hidden;
    transition:all .35s; cursor:default;
    animation:fade-left .7s both;
}
.g-stat-card::before {
    content:''; position:absolute; left:0; top:0; bottom:0;
    width:3px; background:linear-gradient(180deg,var(--blue),var(--violet));
    opacity:0; transition:opacity .3s;
}
.g-stat-card:hover { background:rgba(255,255,255,.07); border-color:rgba(26,86,255,.2); }
.g-stat-card:hover::before { opacity:1; }
.g-stat-icon { font-size:1.4rem; margin-bottom:.75rem; }
.g-stat-num {
    font-family:var(--fd); font-size:2.2rem; font-weight:900;
    color:white; line-height:1; letter-spacing:-.04em; margin-bottom:.3rem;
}
.g-stat-num sup { font-size:.9rem; color:#60a5fa; }
.g-stat-lbl { font-family:var(--fm); font-size:.65rem; color:rgba(255,255,255,.3); letter-spacing:.08em; text-transform:uppercase; }



/* ══ CONSULTA ══════════════════════════ */
.g-consulta {
    padding:6rem 3rem;
    background:linear-gradient(135deg,#020817 0%,#0c1a35 50%,#020817 100%);
    position:relative; overflow:hidden;
}
.g-consulta::before {
    content:''; position:absolute; inset:0; pointer-events:none;
    background-image:linear-gradient(rgba(255,255,255,.02) 1px,transparent 1px),linear-gradient(90deg,rgba(255,255,255,.02) 1px,transparent 1px);
    background-size:44px 44px;
}
.g-consulta::after {
    content:''; position:absolute; top:-150px; right:-150px;
    width:500px; height:500px; border-radius:50%;
    background:radial-gradient(circle,rgba(26,86,255,.1),transparent 70%);
    pointer-events:none;
}
.g-consulta-inner { position:relative; z-index:1; max-width:900px; margin:0 auto; }
.g-consulta-head { margin-bottom:2.5rem; }
.g-consulta-tag {
    font-family:var(--fm); font-size:.68rem; letter-spacing:.16em;
    text-transform:uppercase; color:#60a5fa; margin-bottom:.6rem;
}
.g-consulta-title {
    font-family:var(--fd); font-size:clamp(2rem,4vw,3.2rem);
    font-weight:900; color:white; line-height:1.04; letter-spacing:-.03em;
}
.g-consulta-sub { font-size:.9rem; color:rgba(255,255,255,.35); font-weight:300; margin-top:.5rem; }

.g-search-box {
    background:rgba(255,255,255,.04); border:1px solid rgba(255,255,255,.08);
    border-radius:20px; padding:2rem; margin-bottom:2rem;
}
.g-tabs { display:flex; gap:.5rem; margin-bottom:1.25rem; }
.g-tab {
    flex:1; padding:10px 16px; border:1px solid rgba(255,255,255,.1);
    border-radius:10px; background:rgba(255,255,255,.03);
    color:rgba(255,255,255,.45); font-family:var(--fb); font-size:.82rem;
    font-weight:500; cursor:pointer; transition:all .2s;
    display:flex; align-items:center; justify-content:center; gap:.5rem;
}
.g-tab:hover { border-color:rgba(26,86,255,.3); color:#60a5fa; }
.g-tab.active { background:rgba(26,86,255,.12); border-color:rgba(26,86,255,.35); color:#60a5fa; }

.g-input-row { display:flex; gap:.75rem; }
.g-input-wrap { flex:1; position:relative; }
.g-input-wrap i { position:absolute; left:14px; top:50%; transform:translateY(-50%); color:rgba(255,255,255,.25); font-size:13px; }
.g-input {
    width:100%; background:rgba(255,255,255,.06); border:1px solid rgba(255,255,255,.1);
    border-radius:12px; padding:13px 14px 13px 42px;
    font-family:var(--fm); font-size:.9rem; color:white;
    outline:none; transition:all .25s; letter-spacing:.02em;
}
.g-input::placeholder { font-family:var(--fb); letter-spacing:0; color:rgba(255,255,255,.2); font-size:.85rem; }
.g-input:focus { border-color:rgba(26,86,255,.45); box-shadow:0 0 0 3px rgba(26,86,255,.1); }
.g-btn-buscar {
    padding:13px 28px; background:var(--blue); color:white; border:none;
    border-radius:12px; font-family:var(--fb); font-size:.875rem; font-weight:700;
    cursor:pointer; display:flex; align-items:center; gap:.5rem;
    transition:all .25s; white-space:nowrap; letter-spacing:-.01em; flex-shrink:0;
}
.g-btn-buscar:hover { background:#0f3fcc; transform:translateY(-2px); box-shadow:0 10px 28px rgba(26,86,255,.4); }
.g-hint {
    font-family:var(--fm); font-size:.65rem; color:rgba(255,255,255,.2);
    margin-top:.75rem; letter-spacing:.04em;
}

.g-error {
    background:rgba(239,68,68,.08); border:1px solid rgba(239,68,68,.2);
    border-radius:12px; padding:14px 18px; color:#f87171; font-size:.875rem;
    display:flex; align-items:flex-start; gap:.75rem; margin-bottom:1.5rem;
}
.g-res-header {
    display:flex; align-items:center; justify-content:space-between; margin-bottom:1rem;
}
.g-res-label {
    font-family:var(--fm); font-size:.65rem; letter-spacing:.12em;
    text-transform:uppercase; color:rgba(255,255,255,.3);
}
.g-res-count {
    font-family:var(--fm); font-size:.7rem;
    background:rgba(26,86,255,.12); color:#60a5fa;
    padding:3px 12px; border-radius:999px; border:1px solid rgba(26,86,255,.2);
}

.g-orden-card {
    background:rgba(255,255,255,.04); border:1px solid rgba(255,255,255,.07);
    border-radius:16px; overflow:hidden; margin-bottom:.85rem;
    transition:all .3s; animation:card-in .4s ease both;
}
.g-orden-card:hover {
    background:rgba(255,255,255,.07); border-color:rgba(59,130,246,.2);
    transform:translateY(-2px); box-shadow:0 12px 40px rgba(0,0,0,.3);
}
.g-card-head {
    display:flex; align-items:center; justify-content:space-between;
    padding:1rem 1.5rem; border-bottom:1px solid rgba(255,255,255,.05);
    background:rgba(255,255,255,.02); flex-wrap:wrap; gap:.75rem;
}
.g-nro {
    font-family:var(--fm); font-size:.95rem; font-weight:500;
    color:#60a5fa; letter-spacing:.04em;
}
.g-estado {
    display:inline-flex; align-items:center; gap:.4rem;
    font-family:var(--fm); font-size:.65rem; font-weight:500;
    padding:5px 14px; border-radius:999px; border:1px solid;
    letter-spacing:.06em; text-transform:uppercase;
}
.g-card-body {
    padding:1.25rem 1.5rem;
    display:grid; grid-template-columns:repeat(auto-fill,minmax(160px,1fr));
    gap:1rem 1.5rem;
}
.g-info label {
    display:block; font-family:var(--fm); font-size:.6rem; font-weight:500;
    text-transform:uppercase; letter-spacing:.1em;
    color:rgba(255,255,255,.22); margin-bottom:3px;
}
.g-info span { font-size:.84rem; color:rgba(255,255,255,.75); font-weight:500; line-height:1.4; }
.g-info-full {
    grid-column:1/-1; background:rgba(255,255,255,.03);
    border:1px solid rgba(255,255,255,.06); border-radius:10px; padding:1rem;
}
.g-info-full label {
    display:block; font-family:var(--fm); font-size:.6rem; font-weight:500;
    text-transform:uppercase; letter-spacing:.1em;
    color:rgba(255,255,255,.22); margin-bottom:.4rem;
}
.g-info-full p { font-size:.82rem; color:rgba(255,255,255,.55); line-height:1.7; }

.g-track {
    padding:1.35rem 1.5rem 1rem;
    border-bottom:1px solid rgba(255,255,255,.05);
    background:linear-gradient(180deg,rgba(5,150,105,.06),rgba(255,255,255,.015));
}
.g-track-line {
    display:grid;
    grid-template-columns:repeat(5,1fr);
    position:relative;
    gap:.35rem;
}
.g-track-line::before {
    content:'';
    position:absolute;
    left:10%;
    right:10%;
    top:18px;
    height:6px;
    border-radius:999px;
    background:rgba(255,255,255,.1);
}
.g-track-line::after {
    content:'';
    position:absolute;
    left:10%;
    top:18px;
    width:var(--track-progress,0%);
    max-width:80%;
    height:6px;
    border-radius:999px;
    background:#16a34a;
    box-shadow:0 0 18px rgba(22,163,74,.45);
}
.g-track-step {
    position:relative;
    z-index:1;
    display:flex;
    flex-direction:column;
    align-items:center;
    gap:.45rem;
    text-align:center;
}
.g-track-dot {
    width:42px;
    height:42px;
    border-radius:999px;
    display:flex;
    align-items:center;
    justify-content:center;
    border:3px solid rgba(255,255,255,.18);
    background:#111827;
    color:rgba(255,255,255,.35);
    transition:.25s ease;
}
.g-track-step.done .g-track-dot {
    background:#16a34a;
    border-color:#86efac;
    color:#fff;
}
.g-track-step.active .g-track-dot {
    background:#2563eb;
    border-color:#93c5fd;
    color:#fff;
    box-shadow:0 0 0 6px rgba(37,99,235,.16);
}
.g-track-step.blocked .g-track-dot {
    background:#dc2626;
    border-color:#fca5a5;
    color:#fff;
}
.g-track-label {
    font-family:var(--fm);
    font-size:.58rem;
    letter-spacing:.05em;
    text-transform:uppercase;
    color:rgba(255,255,255,.42);
}
.g-track-step.done .g-track-label,
.g-track-step.active .g-track-label { color:rgba(255,255,255,.82); }
.g-track-note {
    margin-top:1rem;
    color:rgba(255,255,255,.55);
    font-size:.78rem;
    text-align:center;
}

/* ══ ENV BANNER ════════════════════════ */
.g-env {
    padding:5rem 3rem;
    background:linear-gradient(135deg,#f8fafc 0%,#eff6ff 100%);
    position:relative; overflow:hidden;
}
.g-env::before {
    content:''; position:absolute; top:0; left:50%; transform:translateX(-50%);
    width:800px; height:1px;
    background:linear-gradient(to right,transparent,rgba(26,86,255,.2),transparent);
}
.g-env-inner {
    max-width:1100px; margin:0 auto;
    display:grid; grid-template-columns:1fr auto; gap:4rem; align-items:center;
}
.g-env-tag { font-family:var(--fm); font-size:.68rem; letter-spacing:.16em; text-transform:uppercase; color:var(--blue); margin-bottom:.6rem; }
.g-env-title {
    font-family:var(--fd); font-size:clamp(1.8rem,3vw,2.8rem);
    font-weight:900; color:#0f172a; line-height:1.06; letter-spacing:-.03em; margin-bottom:.85rem;
}
.g-env-desc { font-size:.9rem; color:var(--muted); font-weight:300; line-height:1.75; margin-bottom:2rem; max-width:440px; }
.g-env-btn {
    display:inline-flex; align-items:center; gap:.6rem;
    background:var(--blue); color:white;
    font-family:var(--fd); font-size:.8rem; font-weight:700;
    letter-spacing:.06em; text-transform:uppercase;
    padding:13px 28px; border-radius:999px; text-decoration:none;
    transition:all .3s; box-shadow:0 6px 24px rgba(26,86,255,.3);
}
.g-env-btn:hover { background:#0f3fcc; transform:translateY(-3px); box-shadow:0 14px 36px rgba(26,86,255,.4); color:white; }
.g-env-img { height:140px; width:auto; filter:drop-shadow(0 16px 32px rgba(26,86,255,.2)); animation:float 5s ease-in-out infinite; }

/* ══ RESPONSIVE ════════════════════════ */
@media (max-width:860px) {
    .g-hero-inner { grid-template-columns:1fr; gap:3rem; }
    .g-hero { padding:7rem 1.5rem 4rem; }
    .g-consulta,.g-env { padding:4rem 1.5rem; }
    .g-env-inner { grid-template-columns:1fr; }
    .g-env-img { display:none; }
    .g-input-row { flex-direction:column; }
    .g-tabs { flex-direction:column; }
}
@media (max-width:600px) {
    .g-track { padding:1rem .75rem; }
    .g-track-line { gap:.1rem; }
    .g-track-dot { width:34px; height:34px; font-size:.8rem; }
    .g-track-line::before,
    .g-track-line::after { top:14px; height:5px; }
    .g-track-label { font-size:.5rem; }
    .g-track-note { font-size:.72rem; }
}
</style>

{{-- ═══ HERO ═══ --}}
{{-- ═════════ CONSULTA ═════════ --}}
<section class="g-consulta" id="consulta">
    <div class="g-consulta-inner">
        <div class="g-consulta-head rv">
            <div class="g-consulta-tag">Consulta en línea</div>
            <h2 class="g-consulta-title">Consulta el estado de tu <em class="shimmer-blue" style="font-style:italic">equipo</em></h2>
            <p class="g-consulta-sub">Ingresa tu número de orden o cédula para ver el estado en tiempo real.</p>
        </div>

        <form class="g-search-box rv d1" method="POST" action="{{ route('garantias.consulta') }}" autocomplete="off">
            @csrf
            <div class="g-tabs">
                <button type="button" class="g-tab active" onclick="setTipo('nro_orden',this)">
                    <i class="fa-solid fa-hashtag"></i> Número de orden
                </button>
                <button type="button" class="g-tab" onclick="setTipo('identificacion',this)">
                    <i class="fa-solid fa-id-card"></i> Cédula / RUC
                </button>
                <button type="button" class="g-tab" onclick="setTipo('serie',this)">
                    <i class="fa-solid fa-barcode"></i> Serie de equipo
                </button>
            </div>
            <input type="hidden" name="tipo" id="tipoInput" value="nro_orden">
            @if(config('services.turnstile.site'))
            <div class="cf-turnstile mb-4 flex justify-center" data-sitekey="{{ config('services.turnstile.site') }}"></div>
            @endif
            <div class="g-input-row">
                <div class="g-input-wrap">
                    <i class="fa-solid fa-magnifying-glass" id="inputIcon"></i>
                    <input type="text" name="q" id="qInput" class="g-input" placeholder="Ej: UIO-000123" required>
                </div>
                <button type="submit" class="g-btn-buscar">
                    <i class="fa-solid fa-search"></i> Consultar
                </button>
            </div>
            <p class="g-hint" id="hintText">Ingresa el número completo tal como aparece en tu comprobante de ingreso.</p>
        </form>

        @if(session('consulta_error'))
        <div class="g-error rv">
            <i class="fa-solid fa-circle-exclamation" style="margin-top:2px;flex-shrink:0"></i>
            <span>{{ session('consulta_error') }}</span>
        </div>
        @endif

        @if(session('consulta_resultados'))
        @php $resultados = session('consulta_resultados'); @endphp
        <div class="g-res-header rv">
            <span class="g-res-label">Resultados</span>
            <span class="g-res-count">{{ count($resultados) }} orden{{ count($resultados) > 1 ? 'es' : '' }} encontrada{{ count($resultados) > 1 ? 's' : '' }}</span>
        </div>
        @foreach($resultados as $i => $o)
        @php
            $estadoRaw = trim((string) ($o['estado_orden'] ?? ''));
            $estadoGarantia = trim((string) ($o['estado_garantia'] ?? ''));
            $estadoNorm = str_replace(
                ['Ã¡','Ã©','Ã­','Ã³','Ãº','Ã','Ã‰','Ã','Ã“','Ãš'],
                ['a','e','i','o','u','a','e','i','o','u'],
                mb_strtolower($estadoRaw, 'UTF-8')
            );
            $bloqueada = str_contains($estadoNorm, 'anulad') || str_contains($estadoNorm, 'rechaz');
            $pasoActual = 0;
            if (str_contains($estadoNorm, 'revision') || str_contains($estadoNorm, 'revisi')) $pasoActual = 1;
            if (str_contains($estadoNorm, 'reparacion') || str_contains($estadoNorm, 'repar') || str_contains($estadoNorm, 'repuesto')) $pasoActual = 2;
            if (str_contains($estadoNorm, 'finaliz') || str_contains($estadoNorm, 'credito') || str_contains($estadoNorm, 'credit')) $pasoActual = 3;
            if (str_contains($estadoNorm, 'entreg')) $pasoActual = 4;
            $labelListo = 'Reparado';
            if (str_contains($estadoNorm, 'credito') || str_contains($estadoNorm, 'credit')) {
                $labelListo = 'Nota de crédito';
            }
            $avance = $bloqueada ? 0 : ($pasoActual / 4) * 80;
            $trackSteps = [
                ['Recibida','fa-file-circle-check'],
                ['En revisión','fa-magnifying-glass'],
                ['En proceso','fa-screwdriver-wrench'],
                [$labelListo,'fa-circle-check'],
                ['Entregada','fa-box-open'],
            ];
            $estados = [
                'En Revisión'        => ['#D97706','En revisión','fa-magnifying-glass'],
                'En Reparacion'      => ['#2563EB','En reparación','fa-screwdriver-wrench'],
                'Esperando Repuesto' => ['#7C3AED','Esperando repuesto','fa-box'],
                'Finalizada'         => ['#059669','Finalizada','fa-circle-check'],
                'Entregada'          => ['#6B7280','Entregada','fa-box-open'],
                'Anulada'            => ['#DC2626','Anulada','fa-ban'],
                'Nota de Credito'    => ['#DB2777','Nota de crédito','fa-file-invoice'],
            ];
            [$color,$label,$icon] = $estados[$o['estado_orden'] ?? ''] ?? ['#6B7280',$o['estado_orden'] ?? '—','fa-file-lines'];
            $equipo = trim(implode(' ', array_filter([$o['tipo_equipo'] ?? '',$o['marca_equipo'] ?? '',$o['modelo_equipo'] ?? ''])));
            $cliente = trim(($o['nombres'] ?? '').' '.($o['apellidos'] ?? '')) ?: ($o['cliente'] ?? '');
            $falla = trim(($o['falla'] ?? '').(($o['falla'] && $o['observacion']) ? ' — ' : '').($o['observacion'] ?? ''));
        @endphp
        <div class="g-orden-card" style="animation-delay:{{ $i * 0.06 }}s">
            <div class="g-card-head">
                <span class="g-nro">{{ $o['nro_orden'] ?? '—' }}</span>
                <span class="g-estado" style="color:{{ $color }};border-color:{{ $color }}40;background:{{ $color }}15">
                    <i class="fa-solid {{ $icon }}" style="font-size:9px"></i>
                    {{ $label }}
                </span>
            </div>
            <div class="g-track">
                <div class="g-track-line" style="--track-progress:{{ number_format($avance, 2, '.', '') }}%">
                    @foreach($trackSteps as $idx => $step)
                    @php
                        $stepClass = $bloqueada ? ($idx === 0 ? 'blocked active' : '') : ($idx <= $pasoActual ? 'done' : '');
                    @endphp
                    <div class="g-track-step {{ $stepClass }}">
                        <span class="g-track-dot">
                            <i class="fa-solid {{ $bloqueada && $idx === 0 ? 'fa-xmark' : ($idx <= $pasoActual ? 'fa-check' : $step[1]) }}"></i>
                        </span>
                        <span class="g-track-label">{{ $step[0] }}</span>
                    </div>
                    @endforeach
                </div>
                <div class="g-track-note">
                    Estado actual: <strong>{{ $label }}</strong>@if($estadoGarantia) · Garantia: <strong>{{ $estadoGarantia }}</strong>@endif
                </div>
            </div>
            @if($o['show_details'])
            <div class="g-card-body">
                @if($cliente)<div class="g-info"><label>Cliente</label><span>{{ $cliente }}</span></div>@endif
                <div class="g-info"><label>Equipo</label><span>{{ $equipo ?: '—' }}</span></div>
                <div class="g-info"><label>Técnico</label><span>{{ $o['tecnico'] ?? '—' }}</span></div>
                <div class="g-info"><label>Sucursal</label><span>{{ $o['sucursal'] ?? '—' }}</span></div>
                @if(!empty($o['fecha_ingreso']))<div class="g-info"><label>Ingreso</label><span>{{ $o['fecha_ingreso'] }}</span></div>@endif
                @if(!empty($o['motivo_ingreso']))<div class="g-info"><label>Motivo</label><span>{{ $o['motivo_ingreso'] }}</span></div>@endif
                @if($falla)<div class="g-info-full"><label>Descripción</label><p>{{ $falla }}</p></div>@endif
            </div>
            @else
            <div class="p-6 text-center bg-slate-50/50 border-t border-slate-100/80">
                <div class="max-w-md mx-auto py-2">
                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-slate-100 text-slate-400 text-sm mb-2"><i class="fa-solid fa-lock"></i></span>
                    @auth
                        <p class="text-xs text-slate-400 font-light leading-relaxed">
                            Esta orden no pertenece a tu cuenta registrada. Solo puedes consultar su estado público.
                        </p>
                    @else
                        <p class="text-xs text-slate-400 font-light leading-relaxed mb-3">
                            Por seguridad, los detalles de la orden están ocultos en la consulta pública.
                        </p>
                        <a href="{{ route('login') }}" class="inline-flex items-center gap-1.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold px-4 py-2 rounded-xl transition-colors shadow-sm">
                            <i class="fa-solid fa-right-to-bracket"></i> Iniciar sesión para ver detalles
                        </a>
                    @endauth
                </div>
            </div>
            @endif
        </div>
        @endforeach
        @endif
    </div>
</section>

<section class="g-hero">
    <div class="g-hero-grid"></div>
    <div class="g-hero-glow1"></div>
    <div class="g-hero-glow2"></div>
    <div class="g-hero-inner">
        <div>
            <div class="g-hero-tag rv">
                <div class="g-hero-dot"></div>
                Centro de Garantías
            </div>
            <h1 class="g-hero-h1 rv d1">
                Garantías y<br>soporte <em class="shimmer-blue">técnico</em><br>oficial
            </h1>
            <p class="g-hero-p rv d2">
                Gestiona la garantía de tu equipo con <strong style="color:rgba(255,255,255,.8)">Novitecnología</strong>. Selecciona la categoría y la marca para ver el centro de servicio autorizado.
            </p>
            <div class="g-rules" id="gRules">
                @foreach([
                    'El equipo debe ingresar <strong>completo con todos sus accesorios</strong>. Impresoras: envases de tinta, caja original y mínimo 30% de carga.',
                    'Presentar la <strong>factura de compra original</strong> al momento de entregar el equipo.',
                    'Tiendas de provincia (jurisdicción Quito): enviar a <strong>NOVITEC UIO</strong> con factura, estado estético y descripción de falla.',
                    'Equipos con <strong>golpes o mala manipulación anulan la garantía</strong> y serán devueltos sin revisión.',
                    'Tiempo de respuesta: <strong>10 a 15 días laborables</strong>, según políticas de cada marca.',
                    'Se aplican las <strong>políticas oficiales de Novicompu</strong> en todos los casos.',
                ] as $i => $r)
                <div class="g-rule">
                    <span class="g-rule-n">{{ $i + 1 }}</span>
                    <p class="g-rule-t">{!! $r !!}</p>
                </div>
                @endforeach
            </div>
        </div>

        <div class="g-hero-right">
            @foreach([
                ['fa-calendar-days','10–<sup>15</sup>','Días laborables de respuesta'],
                ['fa-folder-open','7<sup>+</sup>','Categorías de equipos'],
                ['fa-tag','20<sup>+</sup>','Marcas con soporte autorizado'],
            ] as $i => $s)
            <div class="g-stat-card rv" style="animation-delay:{{ .3 + $i * .12 }}s">
                <div class="g-stat-icon"><i class="fa-solid {{ $s[0] }}"></i></div>
                <div class="g-stat-num">{!! $s[1] !!}</div>
                <div class="g-stat-lbl">{{ $s[2] }}</div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ═══ CONSULTA ═══ --}}
<section class="g-consulta" id="consulta-legacy" style="display:none;">
    <div class="g-consulta-inner">
        <div class="g-consulta-head rv">
            <div class="g-consulta-tag">Consulta en línea</div>
            <h2 class="g-consulta-title">Consulta el estado de tu <em class="shimmer-blue" style="font-style:italic">equipo</em></h2>
            <p class="g-consulta-sub">Ingresa tu número de orden o cédula para ver el estado en tiempo real.</p>
        </div>

        <form class="g-search-box rv d1" method="POST" action="{{ route('garantias.consulta') }}" autocomplete="off">
            @csrf
            <div class="g-tabs">
                <button type="button" class="g-tab active" onclick="setTipo('nro_orden',this)">
                    <i class="fa-solid fa-hashtag"></i> Número de orden
                </button>
                <button type="button" class="g-tab" onclick="setTipo('identificacion',this)">
                    <i class="fa-solid fa-id-card"></i> Cédula / RUC
                </button>
                <button type="button" class="g-tab" onclick="setTipo('serie',this)">
                    <i class="fa-solid fa-barcode"></i> Serie de equipo
                </button>
            </div>
            <input type="hidden" name="tipo" id="tipoInput" value="nro_orden">
            @if(config('services.turnstile.site'))
            <div class="cf-turnstile mb-4 flex justify-center" data-sitekey="{{ config('services.turnstile.site') }}"></div>
            @endif
            <div class="g-input-row">
                <div class="g-input-wrap">
                    <i class="fa-solid fa-magnifying-glass" id="inputIcon"></i>
                    <input type="text" name="q" id="qInput" class="g-input" placeholder="Ej: UIO-000123" required>
                </div>
                <button type="submit" class="g-btn-buscar">
                    <i class="fa-solid fa-search"></i> Consultar
                </button>
            </div>
            <p class="g-hint" id="hintText">Ingresa el número completo tal como aparece en tu comprobante de ingreso.</p>
        </form>

        @if(session('consulta_error'))
        <div class="g-error rv">
            <i class="fa-solid fa-circle-exclamation" style="margin-top:2px;flex-shrink:0"></i>
            <span>{{ session('consulta_error') }}</span>
        </div>
        @endif

        @if(session('consulta_resultados'))
        @php $resultados = session('consulta_resultados'); @endphp
        <div class="g-res-header rv">
            <span class="g-res-label">Resultados</span>
            <span class="g-res-count">{{ count($resultados) }} orden{{ count($resultados) > 1 ? 'es' : '' }} encontrada{{ count($resultados) > 1 ? 's' : '' }}</span>
        </div>
        @foreach($resultados as $i => $o)
        @php
            $estadoRaw = trim((string) ($o['estado_orden'] ?? ''));
            $estadoGarantia = trim((string) ($o['estado_garantia'] ?? ''));
            $estadoNorm = str_replace(
                ['á','é','í','ó','ú','Á','É','Í','Ó','Ú'],
                ['a','e','i','o','u','a','e','i','o','u'],
                mb_strtolower($estadoRaw, 'UTF-8')
            );
            $bloqueada = str_contains($estadoNorm, 'anulad') || str_contains($estadoNorm, 'rechaz');
            $pasoActual = 0;
            if (str_contains($estadoNorm, 'revision') || str_contains($estadoNorm, 'revisi')) $pasoActual = 1;
            if (str_contains($estadoNorm, 'reparacion') || str_contains($estadoNorm, 'repar') || str_contains($estadoNorm, 'repuesto')) $pasoActual = 2;
            if (str_contains($estadoNorm, 'finaliz') || str_contains($estadoNorm, 'credito') || str_contains($estadoNorm, 'credit')) $pasoActual = 3;
            if (str_contains($estadoNorm, 'entreg')) $pasoActual = 4;
            $labelListo = 'Reparado';
            if (str_contains($estadoNorm, 'credito') || str_contains($estadoNorm, 'credit')) {
                $labelListo = 'Nota de crédito';
            }
            $avance = $bloqueada ? 0 : ($pasoActual / 4) * 80;
            $trackSteps = [
                ['Recibida','fa-file-circle-check'],
                ['En revisión','fa-magnifying-glass'],
                ['En proceso','fa-screwdriver-wrench'],
                [$labelListo,'fa-circle-check'],
                ['Entregada','fa-box-open'],
            ];
            $estados = [
                'En Revisión'        => ['#D97706','En revisión','fa-magnifying-glass'],
                'En Reparacion'      => ['#2563EB','En reparación','fa-screwdriver-wrench'],
                'Esperando Repuesto' => ['#7C3AED','Esperando repuesto','fa-box'],
                'Finalizada'         => ['#059669','Finalizada','fa-circle-check'],
                'Entregada'          => ['#6B7280','Entregada','fa-box-open'],
                'Anulada'            => ['#DC2626','Anulada','fa-ban'],
                'Nota de Credito'    => ['#DB2777','Nota de crédito','fa-file-invoice'],
            ];
            [$color,$label,$icon] = $estados[$o['estado_orden'] ?? ''] ?? ['#6B7280',$o['estado_orden'] ?? '—','fa-file-lines'];
            $equipo = trim(implode(' ', array_filter([$o['tipo_equipo'] ?? '',$o['marca_equipo'] ?? '',$o['modelo_equipo'] ?? ''])));
            $cliente = trim(($o['nombres'] ?? '').' '.($o['apellidos'] ?? '')) ?: ($o['cliente'] ?? '');
            $falla = trim(($o['falla'] ?? '').(($o['falla'] && $o['observacion']) ? ' — ' : '').($o['observacion'] ?? ''));
        @endphp
        <div class="g-orden-card" style="animation-delay:{{ $i * 0.06 }}s">
            <div class="g-card-head">
                <span class="g-nro">{{ $o['nro_orden'] ?? '—' }}</span>
                <span class="g-estado" style="color:{{ $color }};border-color:{{ $color }}40;background:{{ $color }}15">
                    <i class="fa-solid {{ $icon }}" style="font-size:9px"></i>
                    {{ $label }}
                </span>
            </div>
            <div class="g-track">
                <div class="g-track-line" style="--track-progress:{{ number_format($avance, 2, '.', '') }}%">
                    @foreach($trackSteps as $idx => $step)
                    @php
                        $stepClass = $bloqueada ? ($idx === 0 ? 'blocked active' : '') : ($idx <= $pasoActual ? 'done' : '');
                    @endphp
                    <div class="g-track-step {{ $stepClass }}">
                        <span class="g-track-dot">
                            <i class="fa-solid {{ $bloqueada && $idx === 0 ? 'fa-xmark' : ($idx <= $pasoActual ? 'fa-check' : $step[1]) }}"></i>
                        </span>
                        <span class="g-track-label">{{ $step[0] }}</span>
                    </div>
                    @endforeach
                </div>
                <div class="g-track-note">
                    Estado actual: <strong>{{ $label }}</strong>@if($estadoGarantia) · Garantia: <strong>{{ $estadoGarantia }}</strong>@endif
                </div>
            </div>
            @if($o['show_details'])
            <div class="g-card-body">
                @if($cliente)<div class="g-info"><label>Cliente</label><span>{{ $cliente }}</span></div>@endif
                <div class="g-info"><label>Equipo</label><span>{{ $equipo ?: '—' }}</span></div>
                <div class="g-info"><label>Técnico</label><span>{{ $o['tecnico'] ?? '—' }}</span></div>
                <div class="g-info"><label>Sucursal</label><span>{{ $o['sucursal'] ?? '—' }}</span></div>
                @if(!empty($o['fecha_ingreso']))<div class="g-info"><label>Ingreso</label><span>{{ $o['fecha_ingreso'] }}</span></div>@endif
                @if(!empty($o['motivo_ingreso']))<div class="g-info"><label>Motivo</label><span>{{ $o['motivo_ingreso'] }}</span></div>@endif
                @if($falla)<div class="g-info-full"><label>Descripción</label><p>{{ $falla }}</p></div>@endif
            </div>
            @else
            <div class="p-6 text-center bg-slate-50/50 border-t border-slate-100/80">
                <div class="max-w-md mx-auto py-2">
                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-slate-100 text-slate-400 text-sm mb-2"><i class="fa-solid fa-lock"></i></span>
                    @auth
                        <p class="text-xs text-slate-400 font-light leading-relaxed">
                            Esta orden no pertenece a tu cuenta registrada. Solo puedes consultar su estado público.
                        </p>
                    @else
                        <p class="text-xs text-slate-400 font-light leading-relaxed mb-3">
                            Por seguridad, los detalles de la orden están ocultos en la consulta pública.
                        </p>
                        <a href="{{ route('login') }}" class="inline-flex items-center gap-1.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold px-4 py-2 rounded-xl transition-colors shadow-sm">
                            <i class="fa-solid fa-right-to-bracket"></i> Iniciar sesión para ver detalles
                        </a>
                    @endauth
                </div>
            </div>
            @endif
        </div>
        @endforeach
        @endif
    </div>
</section>



@endsection

@push('scripts')
<script>
(function(){

@if(session('consulta_resultados') || session('consulta_error'))
window.addEventListener('load', function(){
    setTimeout(function(){
        document.getElementById('consulta').scrollIntoView({behavior:'smooth',block:'start'});
    }, 100);
});
@endif

const io = new IntersectionObserver(entries => {
    entries.forEach(e => { if(e.isIntersecting){ e.target.classList.add('on'); io.unobserve(e.target); } });
},{threshold:.1});
document.querySelectorAll('.rv,.rvl,.rvr').forEach(el => io.observe(el));

const rules = document.querySelectorAll('.g-rule');
const rObs = new IntersectionObserver(entries => {
    entries.forEach(e => {
        if(e.isIntersecting){
            const idx = [...rules].indexOf(e.target);
            setTimeout(() => e.target.classList.add('on'), idx * 100);
            rObs.unobserve(e.target);
        }
    });
},{threshold:.15});
rules.forEach(r => rObs.observe(r));



function setTipo(tipo, btn){
    document.getElementById('tipoInput').value = tipo;
    document.querySelectorAll('.g-tab').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    const inp = document.getElementById('qInput');
    const icon = document.getElementById('inputIcon');
    const hint = document.getElementById('hintText');
    if(tipo === 'nro_orden'){
        inp.placeholder = 'Ej: UIO-000123';
        icon.className = 'fa-solid fa-magnifying-glass';
        hint.textContent = 'Ingresa el número completo tal como aparece en tu comprobante de ingreso.';
    } else if(tipo === 'serie'){
        inp.placeholder = 'Ej: S123456789';
        icon.className = 'fa-solid fa-barcode';
        hint.textContent = 'Ingresa la serie de tu equipo (se aceptan búsquedas parciales).';
    } else {
        inp.placeholder = 'Ej: 1712345678';
        icon.className = 'fa-solid fa-id-card';
        hint.textContent = 'Ingresa tu cédula o RUC. Se mostrarán todas tus órdenes registradas.';
    }
    inp.value = ''; inp.focus();
}
window.setTipo = setTipo;

})();
</script>
@endpush
