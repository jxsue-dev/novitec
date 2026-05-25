@extends('layouts.app')

@section('title', 'Garantías – Novitec')

@section('content')

<style>
@import url('https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,700;0,9..144,900;1,9..144,700&family=Cabinet+Grotesk:wght@300;400;500;700;800&family=DM+Mono:wght@400;500&display=swap');
@import url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css');

:root {
    --blue: #1a3d7c;
    --cyan: #00c8f0;
    --gold: #f5a623;
    --dark: #07111f;
    --soft: #f0f5ff;
    --muted: #5a6f8f;
    --font-display: 'Fraunces', serif;
    --font-body: 'Cabinet Grotesk', sans-serif;
    --font-mono: 'DM Mono', monospace;
}

* { box-sizing: border-box; }
.grt { font-family: var(--font-body); color: #0c1a2e; overflow-x: hidden; }

@keyframes fadeUp   { from{opacity:0;transform:translateY(20px)} to{opacity:1;transform:none} }
@keyframes logoIn   { from{opacity:0;transform:scale(.88) translateY(18px)} to{opacity:1;transform:none} }
@keyframes ringP    { 0%,100%{transform:scale(1);opacity:.7} 50%{transform:scale(1.05);opacity:.25} }
@keyframes pillFloat{ 0%,100%{transform:translateY(0)} 50%{transform:translateY(-8px)} }
@keyframes liveDot  { 0%,100%{box-shadow:0 0 0 3px rgba(34,197,94,.2)} 50%{box-shadow:0 0 0 7px rgba(34,197,94,.06)} }
@keyframes lineGrow { to{transform:scaleX(1)} }
@keyframes brandIn  { from{opacity:0;transform:translateY(14px)} to{opacity:1;transform:none} }
@keyframes detailIn { from{opacity:0;transform:translateY(20px) scale(.98)} to{opacity:1;transform:none} }
@keyframes shimmer  { 0%{background-position:-200% center} 100%{background-position:200% center} }

.rv { opacity:0; transform:translateY(28px); transition:opacity .65s ease,transform .65s ease; }
.rv.vis { opacity:1; transform:none; }

/* ══ HERO ══ */
.grt-hero {
    display:grid; grid-template-columns:1fr 1fr;
    min-height:calc(100vh - 96px);
    width:100vw; position:relative;
    left:50%; right:50%; margin-left:-50vw; margin-right:-50vw;
    overflow:hidden;
}
.grt-hero-photo {
    position:relative; overflow:hidden;
    background:linear-gradient(135deg,#dce8ff,#b8d4ff);
    display:flex; align-items:center; justify-content:center;
}
.grt-hex {
    position:absolute; inset:0; opacity:.06;
    background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='56' height='100'%3E%3Cpath d='M28 66L0 50V16L28 0l28 16v34z' fill='none' stroke='%231a3d7c' stroke-width='1'/%3E%3C/svg%3E");
    background-size:56px 100px;
}
.grt-photo-bar {
    position:absolute; top:0; bottom:0; right:0; width:5px;
    background:linear-gradient(to bottom,var(--cyan),var(--blue)); z-index:2;
}
.grt-logo-wrap {
    position:relative; z-index:3;
    display:flex; flex-direction:column; align-items:center; gap:20px;
    animation:logoIn .9s cubic-bezier(.22,.68,0,1.1) .3s both;
}
.grt-logo-ring {
    width:200px; height:200px; border-radius:50%;
    position:relative; display:flex; align-items:center; justify-content:center;
    background:rgba(255,255,255,.75); box-shadow:0 20px 60px rgba(26,61,124,.18);
}
.grt-logo-ring::before {
    content:''; position:absolute; inset:-10px; border-radius:50%;
    border:1.5px solid rgba(26,61,124,.15); animation:ringP 4s ease-in-out infinite;
}
.grt-logo-ring::after {
    content:''; position:absolute; inset:-22px; border-radius:50%;
    border:1px dashed rgba(0,200,240,.2); animation:ringP 6s ease-in-out infinite reverse;
}
.grt-logo { width:140px; height:auto; }
.grt-logo-badge {
    background:rgba(255,255,255,.9); backdrop-filter:blur(12px);
    border:1px solid rgba(26,61,124,.15); border-radius:100px; padding:10px 22px;
    font-family:var(--font-mono); font-size:11px; font-weight:500;
    letter-spacing:.12em; text-transform:uppercase; color:var(--blue);
    box-shadow:0 8px 24px rgba(26,61,124,.12); animation:pillFloat 5s ease-in-out infinite;
}
.grt-live {
    position:absolute; bottom:32px; right:28px; z-index:4;
    background:rgba(255,255,255,.92); backdrop-filter:blur(12px);
    border-radius:100px; padding:10px 18px 10px 14px;
    display:flex; align-items:center; gap:9px;
    box-shadow:0 12px 36px rgba(0,0,0,.12); animation:pillFloat 6s ease-in-out infinite .5s;
}
.grt-live-dot {
    width:9px; height:9px; border-radius:50%; background:#22c55e; flex-shrink:0;
    box-shadow:0 0 0 3px rgba(34,197,94,.2); animation:liveDot 2s ease-in-out infinite;
}
.grt-live span { font-size:12px; font-weight:600; color:var(--dark); }
.grt-live small { font-size:11px; color:var(--muted); display:block; line-height:1.1; }

.grt-hero-right {
    background:#fff; display:flex; flex-direction:column;
    justify-content:center; padding:80px 72px 80px 64px;
    position:relative; overflow:hidden;
}
.grt-hero-deco {
    position:absolute; top:-10px; right:-20px;
    font-family:var(--font-display); font-size:240px; font-weight:700;
    color:rgba(26,61,124,.03); pointer-events:none; user-select:none;
    line-height:1; letter-spacing:-12px;
}
.grt-eyebrow { display:flex; align-items:center; gap:12px; margin-bottom:28px; animation:fadeUp .7s ease .35s both; }
.grt-eyebrow-line { width:36px; height:2px; background:var(--cyan); border-radius:2px; }
.grt-eyebrow-txt { font-family:var(--font-mono); font-size:11px; font-weight:500; letter-spacing:.2em; text-transform:uppercase; color:var(--blue); }
.grt-h1 {
    font-family:var(--font-display); font-size:clamp(32px,3.5vw,52px);
    font-weight:900; color:var(--dark); line-height:1.08; margin-bottom:22px;
    animation:fadeUp .7s ease .5s both;
}
.grt-h1 em {
    font-style:italic; color:var(--blue); position:relative; display:inline-block;
}
.grt-h1 em::after {
    content:''; position:absolute; left:0; right:0; bottom:2px; height:3px;
    background:var(--cyan); border-radius:2px;
    transform:scaleX(0); transform-origin:left;
    animation:lineGrow 1s cubic-bezier(.22,.68,0,1) .9s forwards;
}
.grt-desc {
    font-size:15px; line-height:1.8; color:var(--muted); margin-bottom:32px; max-width:440px;
    animation:fadeUp .7s ease .65s both;
}
.grt-desc strong { color:var(--dark); }

.grt-rules { display:flex; flex-direction:column; animation:fadeUp .7s ease .75s both; }
.grt-rule {
    display:flex; align-items:flex-start; gap:14px; padding:12px 0;
    border-bottom:1px solid rgba(26,61,124,.07);
    opacity:0; transform:translateX(-14px);
    transition:opacity .5s ease,transform .5s ease;
}
.grt-rule.vis { opacity:1; transform:translateX(0); }
.grt-rule:last-child { border-bottom:none; }
.grt-rule-n {
    font-family:var(--font-display); font-size:18px; font-weight:700;
    color:rgba(26,61,124,.2); line-height:1.4; flex-shrink:0; width:22px; transition:color .3s;
}
.grt-rule:hover .grt-rule-n { color:var(--cyan); }
.grt-rule-t { font-size:13px; line-height:1.65; color:var(--muted); transition:color .3s; }
.grt-rule:hover .grt-rule-t { color:var(--dark); }
.grt-rule-t strong { color:var(--dark); font-weight:600; }

.grt-stats { display:flex; border-top:1px solid rgba(26,61,124,.09); padding-top:28px; margin-top:24px; animation:fadeUp .7s ease .85s both; }
.grt-stat { flex:1; padding-right:20px; border-right:1px solid rgba(26,61,124,.09); }
.grt-stat:last-child { border-right:none; padding-right:0; padding-left:20px; }
.grt-stat:nth-child(2) { padding-left:20px; }
.grt-stat-n { font-family:var(--font-display); font-size:30px; font-weight:700; color:var(--blue); line-height:1; display:flex; align-items:flex-start; gap:2px; }
.grt-stat-n sup { font-size:13px; color:var(--cyan); margin-top:4px; }
.grt-stat-l { font-family:var(--font-mono); font-size:10px; color:var(--muted); text-transform:uppercase; letter-spacing:.1em; margin-top:4px; }

/* ══ CATEGORÍAS ══ */
.grt-cats {
    padding:80px 60px; background:var(--soft); position:relative; overflow:hidden;
}
.grt-cats::before {
    content:''; position:absolute; top:0; left:50%; transform:translateX(-50%);
    width:600px; height:2px; background:linear-gradient(to right,transparent,var(--blue),transparent);
}
.grt-sec-head { text-align:center; max-width:540px; margin:0 auto 56px; }
.grt-sec-tag { display:block; font-family:var(--font-mono); font-size:10px; font-weight:500; letter-spacing:.24em; text-transform:uppercase; color:var(--blue); margin-bottom:10px; }
.grt-sec-title { font-family:var(--font-display); font-size:clamp(24px,2.8vw,36px); font-weight:700; color:var(--dark); line-height:1.15; margin-bottom:12px; }
.grt-sec-sub { font-size:14px; color:var(--muted); line-height:1.7; }

.grt-cats-grid { display:grid; grid-template-columns:repeat(7,1fr); gap:14px; max-width:1100px; margin:0 auto; }

.grt-cat { perspective:800px; cursor:pointer; height:110px; }
.grt-cat-inner {
    position:relative; width:100%; height:100%;
    transform-style:preserve-3d; transition:transform .55s cubic-bezier(.22,.68,0,1.1);
}
.grt-cat:hover .grt-cat-inner, .grt-cat.active .grt-cat-inner { transform:rotateY(180deg); }
.grt-cat-front, .grt-cat-back {
    position:absolute; inset:0; border-radius:20px;
    display:flex; flex-direction:column; align-items:center; justify-content:center;
    gap:10px; backface-visibility:hidden; -webkit-backface-visibility:hidden;
}
.grt-cat-front {
    background:#fff; border:1px solid rgba(26,61,124,.09);
    transition:border-color .3s,box-shadow .3s;
}
.grt-cat:hover .grt-cat-front, .grt-cat.active .grt-cat-front {
    border-color:rgba(26,61,124,.2); box-shadow:0 12px 32px rgba(26,61,124,.1);
}
.grt-cat-back {
    background:linear-gradient(135deg,var(--blue),#2860c4);
    border:1px solid var(--blue); transform:rotateY(180deg);
    box-shadow:0 12px 36px rgba(26,61,124,.25);
}
.grt-cat-ico { font-size:26px; color:var(--blue); transition:transform .3s; }
.grt-cat:hover .grt-cat-ico { transform:scale(1.1); }
.grt-cat-back .grt-cat-ico { color:rgba(255,255,255,.9); font-size:22px; }
.grt-cat-lbl {
    font-family:var(--font-mono); font-size:9px; font-weight:500;
    letter-spacing:.12em; text-transform:uppercase; color:var(--muted);
    text-align:center; transition:color .3s;
}
.grt-cat:hover .grt-cat-lbl { color:var(--blue); }
.grt-cat-back .grt-cat-lbl { color:rgba(255,255,255,.85); }

/* ══ BRANDS ══ */
.grt-brands {
    padding:0 60px; max-height:0; overflow:hidden; background:#fff;
    transition:max-height .7s cubic-bezier(.22,.68,0,1),padding .5s ease;
}
.grt-brands.open {
    max-height:1600px; padding:64px 60px;
    border-top:1px solid rgba(26,61,124,.08);
}
.grt-brands-hdr {
    display:flex; align-items:flex-end; justify-content:space-between;
    max-width:1100px; margin:0 auto 36px; gap:24px; flex-wrap:wrap;
}
.grt-brands-title {
    font-family:var(--font-display); font-size:26px; font-weight:700;
    color:var(--dark); display:flex; align-items:center; gap:12px;
}
.grt-search-w { position:relative; }
.grt-search-w i { position:absolute; left:14px; top:50%; transform:translateY(-50%); color:var(--muted); font-size:13px; pointer-events:none; }
.grt-search {
    padding:10px 14px 10px 40px; background:var(--soft);
    border:1px solid rgba(26,61,124,.12); border-radius:10px;
    font-family:var(--font-body); font-size:13px; color:var(--dark);
    outline:none; width:220px; transition:border-color .3s,box-shadow .3s;
}
.grt-search::placeholder { color:var(--muted); }
.grt-search:focus { border-color:rgba(26,61,124,.35); box-shadow:0 0 0 3px rgba(26,61,124,.07); }

.grt-brands-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(130px,1fr)); grid-auto-rows:100px; gap:12px; max-width:1100px; margin:0 auto; }
.grt-brand {
    display:flex; flex-direction:column; align-items:center; justify-content:center;
    gap:0; padding:16px 10px; background:var(--soft);
    border:1px solid rgba(26,61,124,.08); border-radius:14px;
    cursor:pointer; text-align:center; height:100px;
    overflow:hidden; transition:transform .35s cubic-bezier(.22,.68,0,1.2),border-color .3s,box-shadow .3s,background .3s;
    animation:brandIn .4s ease both;
}
.grt-brand:hover, .grt-brand.active {
    transform:translateY(-4px); border-color:rgba(26,61,124,.25);
    box-shadow:0 10px 28px rgba(26,61,124,.12); background:#fff;
}
.grt-brand-ico { font-size:24px; color:rgba(26,61,124,.3); transition:color .3s,transform .3s; margin-bottom:8px; }
.grt-brand-logo {
    width:34px; height:34px; object-fit:contain; margin-bottom:8px;
    opacity:.4; transition:opacity .3s,transform .3s; filter:grayscale(1);
}
.grt-brand:hover .grt-brand-logo, .grt-brand.active .grt-brand-logo { opacity:1; filter:grayscale(0); transform:scale(1.1); }
.grt-brand:hover .grt-brand-ico, .grt-brand.active .grt-brand-ico { color:var(--blue); transform:scale(1.1); }
.grt-brand-name {
    font-family:var(--font-mono); font-size:9px; font-weight:500;
    letter-spacing:.06em; text-transform:uppercase; color:var(--muted);
    transition:color .3s; overflow:hidden; display:-webkit-box;
    -webkit-line-clamp:2; -webkit-box-orient:vertical;
    word-break:break-word; max-width:100%;
}
.grt-brand:hover .grt-brand-name, .grt-brand.active .grt-brand-name { color:var(--blue); }
.grt-brand.hidden { display:none; }

/* ══ DETAIL ══ */
.grt-detail {
    max-width:1100px; margin:32px auto 0;
    background:var(--soft); border:1px solid rgba(26,61,124,.1);
    border-radius:20px; overflow:hidden; display:none;
    animation:detailIn .5s cubic-bezier(.22,.68,0,1.1);
}
.grt-detail.show { display:grid; grid-template-columns:1fr 1fr; }
.grt-detail-info { padding:36px 40px; background:#fff; }
.grt-detail-name {
    font-family:var(--font-display); font-size:28px; font-weight:700;
    color:var(--dark); text-transform:uppercase; margin-bottom:4px; letter-spacing:-.02em;
}
.grt-detail-cat {
    font-family:var(--font-mono); font-size:10px; font-weight:500;
    letter-spacing:.14em; text-transform:uppercase; color:var(--blue);
    margin-bottom:24px; display:flex; align-items:center; gap:7px;
}
.grt-detail-info h4 {
    font-family:var(--font-display); font-size:15px; font-weight:700;
    color:var(--blue); margin-bottom:14px;
}
.grt-detail-info p {
    font-size:13.5px; line-height:1.7; color:var(--muted); margin-bottom:10px;
    padding:10px 14px; background:var(--soft); border-radius:10px;
    border-left:3px solid rgba(26,61,124,.15); transition:border-color .3s,background .3s;
}
.grt-detail-info p:hover { border-color:var(--cyan); background:#eaf6ff; }
.grt-detail-info p strong { color:var(--dark); font-weight:600; }
.grt-detail-info a { color:var(--blue); word-break:break-all; }
.grt-detail-info a:hover { text-decoration:underline; }
.grt-detail-map { position:relative; min-height:380px; background:#e8eef8; border-left:1px solid rgba(26,61,124,.09); }
.grt-detail-map iframe { width:100%; height:100%; border:none; display:block; min-height:380px; }

/* ══ CONSULTA ══ */
.consulta-sec {
    padding:80px 60px;
    background:linear-gradient(135deg,#020817 0%,#0c1a35 50%,#020817 100%);
    position:relative; overflow:hidden;
}
.consulta-sec::before {
    content:''; position:absolute; inset:0;
    background-image:linear-gradient(rgba(255,255,255,.025) 1px,transparent 1px),linear-gradient(90deg,rgba(255,255,255,.025) 1px,transparent 1px);
    background-size:44px 44px; pointer-events:none;
}
.consulta-sec::after {
    content:''; position:absolute;
    top:-150px; right:-150px; width:500px; height:500px; border-radius:50%;
    background:radial-gradient(circle,rgba(26,86,255,.12),transparent 70%);
    pointer-events:none;
}
.consulta-inner { position:relative; z-index:1; max-width:1100px; margin:0 auto; }
.consulta-header { margin-bottom:3rem; }
.consulta-tag {
    font-family:var(--font-mono); font-size:10px; font-weight:500;
    letter-spacing:.2em; text-transform:uppercase; color:#60a5fa; margin-bottom:.6rem;
}
.consulta-title {
    font-family:var(--font-display); font-size:clamp(2rem,4vw,3rem);
    font-weight:900; color:white; line-height:1.05; letter-spacing:-.03em;
}
.consulta-title em {
    font-style:italic;
    background:linear-gradient(90deg,#60a5fa,#a78bfa,#60a5fa);
    background-size:200% auto;
    -webkit-background-clip:text; -webkit-text-fill-color:transparent;
    background-clip:text; animation:shimmer 4s linear infinite;
}
.consulta-sub { font-size:.9rem; color:rgba(255,255,255,.4); font-weight:300; margin-top:.5rem; }

/* Search box */
.search-box {
    background:rgba(255,255,255,.04);
    border:1px solid rgba(255,255,255,.08);
    border-radius:20px; padding:2rem;
    margin-bottom:2rem;
    backdrop-filter:blur(12px);
}
.tipo-tabs { display:flex; gap:.5rem; margin-bottom:1.25rem; }
.tipo-tab {
    flex:1; padding:10px 16px;
    border:1px solid rgba(255,255,255,.1);
    border-radius:10px; background:rgba(255,255,255,.04);
    color:rgba(255,255,255,.5); font-family:var(--font-body);
    font-size:13px; font-weight:500; cursor:pointer;
    transition:all .2s; display:flex; align-items:center; justify-content:center; gap:7px;
}
.tipo-tab:hover { border-color:rgba(59,130,246,.4); color:#60a5fa; }
.tipo-tab.active { background:rgba(26,86,255,.15); border-color:rgba(26,86,255,.4); color:#60a5fa; }

.input-row { display:flex; gap:.75rem; align-items:stretch; }
.input-group { flex:1; position:relative; }
.input-group i { position:absolute; left:14px; top:50%; transform:translateY(-50%); color:rgba(255,255,255,.3); font-size:13px; }
.input-group input {
    width:100%; background:rgba(255,255,255,.06); border:1px solid rgba(255,255,255,.1);
    border-radius:10px; padding:13px 14px 13px 40px; font-size:15px;
    color:white; outline:none; transition:all .2s;
    font-family:var(--font-mono); letter-spacing:0.3px;
}
.input-group input::placeholder { font-family:var(--font-body); letter-spacing:0; color:rgba(255,255,255,.25); font-size:14px; }
.input-group input:focus { border-color:rgba(26,86,255,.5); box-shadow:0 0 0 3px rgba(26,86,255,.12); }

.btn-consultar {
    padding:13px 28px; background:#1a56ff; color:#fff; border:none;
    border-radius:10px; font-family:var(--font-body); font-size:14px; font-weight:700;
    cursor:pointer; white-space:nowrap; display:flex; align-items:center; gap:8px;
    transition:all .2s; flex-shrink:0; letter-spacing:-.01em;
}
.btn-consultar:hover { background:#0f3fcc; transform:translateY(-1px); box-shadow:0 8px 24px rgba(26,86,255,.4); }
.btn-limpiar {
    padding:13px 18px; background:rgba(255,255,255,.06); color:rgba(255,255,255,.5);
    border:1px solid rgba(255,255,255,.1); border-radius:10px;
    font-family:var(--font-body); font-size:14px; font-weight:500; cursor:pointer;
    white-space:nowrap; display:flex; align-items:center; gap:7px;
    text-decoration:none; transition:all .2s; flex-shrink:0;
}
.btn-limpiar:hover { background:rgba(239,68,68,.1); color:#f87171; border-color:rgba(239,68,68,.3); }
.hint {
    font-family:var(--font-mono); font-size:11px; color:rgba(255,255,255,.2);
    margin-top:.75rem; letter-spacing:.04em;
}

/* Error */
.msg-error {
    background:rgba(239,68,68,.1); border:1px solid rgba(239,68,68,.2);
    border-radius:12px; padding:14px 18px; color:#f87171; font-size:14px;
    display:flex; align-items:flex-start; gap:10px; margin-bottom:2rem;
}

/* Resultados */
.res-header {
    display:flex; align-items:center; justify-content:space-between; margin-bottom:1rem;
}
.res-label {
    font-family:var(--font-mono); font-size:10px; font-weight:500;
    letter-spacing:.14em; text-transform:uppercase; color:rgba(255,255,255,.3);
}
.res-count {
    font-family:var(--font-mono); font-size:11px;
    background:rgba(26,86,255,.15); color:#60a5fa;
    padding:3px 12px; border-radius:100px;
    border:1px solid rgba(26,86,255,.25);
}

/* Orden card */
.orden-card {
    background:rgba(255,255,255,.04); border:1px solid rgba(255,255,255,.08);
    border-radius:16px; overflow:hidden; margin-bottom:12px;
    transition:all .3s; animation:brandIn .3s ease both;
}
.orden-card:hover {
    background:rgba(255,255,255,.07); border-color:rgba(59,130,246,.25);
    transform:translateY(-2px); box-shadow:0 12px 40px rgba(0,0,0,.3);
}
.card-head {
    display:flex; align-items:center; justify-content:space-between;
    padding:16px 20px; border-bottom:1px solid rgba(255,255,255,.06);
    flex-wrap:wrap; gap:10px;
    background:rgba(255,255,255,.02);
}
.nro-orden {
    font-family:var(--font-mono); font-size:15px; font-weight:500;
    color:#60a5fa; letter-spacing:0.5px;
}
.estado-badge {
    display:inline-flex; align-items:center; gap:6px;
    font-family:var(--font-mono); font-size:11px; font-weight:500;
    padding:5px 14px; border-radius:100px; border:1px solid;
    letter-spacing:.04em;
}
.card-body {
    padding:18px 20px; display:grid;
    grid-template-columns:repeat(auto-fill,minmax(180px,1fr));
    gap:14px 20px;
}
.info-item label {
    display:block; font-family:var(--font-mono); font-size:9.5px; font-weight:500;
    text-transform:uppercase; letter-spacing:.1em;
    color:rgba(255,255,255,.25); margin-bottom:4px;
}
.info-item span { font-size:13.5px; color:rgba(255,255,255,.8); font-weight:500; line-height:1.4; }
.info-item span.empty { color:rgba(255,255,255,.2); font-style:italic; font-weight:300; }
.info-full {
    grid-column:1/-1; background:rgba(255,255,255,.03);
    border:1px solid rgba(255,255,255,.06); border-radius:10px; padding:14px 16px;
}
.info-full label {
    display:block; font-family:var(--font-mono); font-size:9.5px; font-weight:500;
    text-transform:uppercase; letter-spacing:.1em;
    color:rgba(255,255,255,.25); margin-bottom:6px;
}
.info-full p { font-size:13px; color:rgba(255,255,255,.6); line-height:1.7; }

/* ══ ENV ══ */
.grt-env {
    padding:80px 60px; background:var(--soft);
    border-top:1px solid rgba(26,61,124,.08); position:relative; overflow:hidden;
}
.grt-env::before {
    content:''; position:absolute; top:0; left:50%; transform:translateX(-50%);
    width:500px; height:2px; background:linear-gradient(to right,transparent,var(--blue),transparent);
}
.grt-env-inner { max-width:1100px; margin:0 auto; display:grid; grid-template-columns:1fr auto; gap:60px; align-items:center; position:relative; z-index:1; }
.grt-env-tag { font-family:var(--font-mono); font-size:10px; font-weight:500; letter-spacing:.2em; text-transform:uppercase; color:var(--blue); margin-bottom:10px; }
.grt-env-title { font-family:var(--font-display); font-size:clamp(24px,3vw,40px); font-weight:700; color:var(--dark); line-height:1.1; margin-bottom:14px; }
.grt-env-desc { font-size:14px; color:var(--muted); line-height:1.75; margin-bottom:28px; max-width:420px; }
.grt-env-btn {
    display:inline-flex; align-items:center; gap:9px; background:var(--blue); color:#fff;
    font-family:var(--font-display); font-size:13px; font-weight:700;
    letter-spacing:.06em; text-transform:uppercase; padding:14px 30px;
    border-radius:100px; text-decoration:none;
    transition:transform .3s,box-shadow .3s,background .3s;
    box-shadow:0 6px 24px rgba(26,61,124,.3);
}
.grt-env-btn:hover { transform:translateY(-3px); background:#2860c4; box-shadow:0 12px 36px rgba(26,61,124,.4); color:#fff; }
.grt-env-img-wrap { animation:pillFloat 5s ease-in-out infinite; }
.grt-env-img { height:160px; width:auto; filter:drop-shadow(0 16px 32px rgba(26,61,124,.25)); }

/* ══ RESPONSIVE ══ */
@media (max-width:1100px) { .grt-cats-grid { grid-template-columns:repeat(4,1fr); } }
@media (max-width:860px) {
    .grt-hero { grid-template-columns:1fr; }
    .grt-hero-photo { display:none; }
    .grt-hero-right { padding:60px 32px; }
    .grt-cats, .grt-brands.open, .grt-env, .consulta-sec { padding:60px 24px; }
    .grt-detail.show { grid-template-columns:1fr; }
    .grt-env-inner { grid-template-columns:1fr; }
    .grt-env-img-wrap { display:none; }
    .grt-brands-hdr { flex-direction:column; align-items:flex-start; }
    .grt-search { width:100%; }
    .input-row { flex-direction:column; }
    .tipo-tabs { flex-direction:column; }
}
@media (max-width:600px) {
    .grt-cats-grid { grid-template-columns:repeat(3,1fr); gap:10px; }
    .grt-brands-grid { grid-template-columns:repeat(auto-fill,minmax(110px,1fr)); }
}
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<div class="grt">

{{-- ═══ HERO ═══ --}}
<section class="grt-hero">
    <div class="grt-hero-photo">
        <div class="grt-hex"></div>
        <div class="grt-photo-bar"></div>
        <div class="grt-logo-wrap">
            <div class="grt-logo-ring">
                <img src="{{ asset('images/novitec_logo.png') }}" alt="Novitec" class="grt-logo">
            </div>
            <div class="grt-logo-badge">Servicio Técnico Autorizado</div>
        </div>
        <div class="grt-live">
            <div class="grt-live-dot"></div>
            <div><span>Soporte activo</span><small>Lun – Vie · 9h a 17h</small></div>
        </div>
    </div>
    <div class="grt-hero-right">
        <div class="grt-hero-deco">G</div>
        <div class="grt-eyebrow"><div class="grt-eyebrow-line"></div><span class="grt-eyebrow-txt">Centro de Garantías</span></div>
        <h1 class="grt-h1">Garantías y<br>soporte <em>técnico</em><br>oficial</h1>
        <p class="grt-desc">Gestiona la garantía de tu equipo con <strong>Novitecnología</strong>. Selecciona la categoría y la marca para ver el centro de servicio autorizado.</p>
        <div class="grt-rules" id="grtRules">
            @foreach([
                ['El equipo debe ingresar <strong>completo con todos sus accesorios</strong>. Impresoras: envases de tinta, caja original y mínimo 30% de carga.'],
                ['Presentar la <strong>factura de compra original</strong> al momento de entregar el equipo.'],
                ['Tiendas de provincia (jurisdicción Quito): enviar a <strong>NOVITEC UIO</strong> con factura, estado estético y descripción de falla.'],
                ['Equipos con <strong>golpes o mala manipulación anulan la garantía</strong> y serán devueltos sin revisión.'],
                ['Tiempo de respuesta: <strong>10 a 15 días laborables</strong>, según políticas de cada marca.'],
                ['Se aplican las <strong>políticas oficiales de Novicompu</strong> en todos los casos.'],
            ] as $i=>$r)
            <div class="grt-rule">
                <span class="grt-rule-n">{{$i+1}}</span>
                <p class="grt-rule-t">{!! $r[0] !!}</p>
            </div>
            @endforeach
        </div>
        <div class="grt-stats">
            <div class="grt-stat"><div class="grt-stat-n">10–<sup>15</sup></div><div class="grt-stat-l">días laborables</div></div>
            <div class="grt-stat"><div class="grt-stat-n">7<sup>+</sup></div><div class="grt-stat-l">categorías</div></div>
            <div class="grt-stat"><div class="grt-stat-n">20<sup>+</sup></div><div class="grt-stat-l">marcas</div></div>
        </div>
    </div>
</section>

{{-- ═══ CATEGORÍAS ═══ --}}
<section class="grt-cats">
    <div class="grt-sec-head rv">
        <span class="grt-sec-tag">Selecciona tu equipo</span>
        <h2 class="grt-sec-title">¿Qué tipo de equipo tienes?</h2>
        <p class="grt-sec-sub">Haz clic en la categoría para ver las marcas y el centro de soporte autorizado.</p>
    </div>
    <div class="grt-cats-grid" id="grtCatsGrid">
        @foreach([
            ['COMPUTADORAS','fa-solid fa-laptop'],
            ['CELULARES','fas fa-mobile-alt'],
            ['TABLETS','fas fa-tablet-alt'],
            ['IMPRESORAS','fa-solid fa-print'],
            ['TELEVISIONES','fa-solid fa-tv'],
            ['CONSOLAS','fa-solid fa-gamepad'],
            ['OTROS','fa-solid fa-headphones'],
        ] as $cat)
        <div class="grt-cat" data-cat="{{$cat[0]}}">
            <div class="grt-cat-inner">
                <div class="grt-cat-front">
                    <span class="grt-cat-ico"><i class="{{$cat[1]}}"></i></span>
                    <span class="grt-cat-lbl">{{ucfirst(strtolower($cat[0]))}}</span>
                </div>
                <div class="grt-cat-back">
                    <span class="grt-cat-ico"><i class="{{$cat[1]}}"></i></span>
                    <span class="grt-cat-lbl">Ver marcas</span>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</section>

{{-- ═══ BRANDS + DETAIL ═══ --}}
<section class="grt-brands" id="grtBrands">
    <div class="grt-brands-hdr">
        <div class="grt-brands-title"><i id="grtActIcon" class="fa-solid fa-laptop"></i><span id="grtActName">COMPUTADORAS</span></div>
        <div class="grt-search-w">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input type="text" class="grt-search" id="grtSearch" placeholder="Buscar marca…">
        </div>
    </div>
    <div class="grt-brands-grid" id="grtBrandsGrid"></div>
    <div class="grt-detail" id="grtDetail">
        <div class="grt-detail-info" id="grtDetailInfo"></div>
        <div class="grt-detail-map" id="grtDetailMap"></div>
    </div>
</section>

{{-- ═══ CONSULTA ═══ --}}
<section class="consulta-sec" id="consulta">
    <div class="consulta-inner">
        <div class="consulta-header rv">
            <div class="consulta-tag">Consulta en línea</div>
            <h2 class="consulta-title">¿Dónde está<br>tu <em>equipo</em>?</h2>
            <p class="consulta-sub">Ingresa tu número de orden o cédula para ver el estado en tiempo real.</p>
        </div>

        <form class="search-box" method="POST" action="{{ route('garantias.consulta') }}" autocomplete="off">
            @csrf
            <div class="tipo-tabs">
                <button type="button" class="tipo-tab active" onclick="setTipo('nro_orden', this)">
                    <i class="fa-solid fa-hashtag"></i> Número de orden
                </button>
                <button type="button" class="tipo-tab" onclick="setTipo('identificacion', this)">
                    <i class="fa-solid fa-id-card"></i> Cédula / RUC
                </button>
            </div>
            <input type="hidden" name="tipo" id="tipo-input" value="nro_orden">
            <div class="input-row">
                <div class="input-group">
                    <i class="fa-solid fa-magnifying-glass" id="input-icon"></i>
                    <input type="text" name="q" id="q-input" placeholder="Ej: UIO-000123" required>
                </div>
                <button type="submit" class="btn-consultar">
                    <i class="fa-solid fa-search"></i> Consultar
                </button>
            </div>
            <p class="hint" id="hint-text">Ingresa el número completo tal como aparece en tu comprobante de ingreso.</p>
        </form>

        @if(session('consulta_error'))
        <div class="msg-error">
            <i class="fa-solid fa-circle-exclamation" style="margin-top:2px;flex-shrink:0"></i>
            <span>{{ session('consulta_error') }}</span>
        </div>
        @endif

        @if(session('consulta_resultados'))
        @php $resultados = session('consulta_resultados'); @endphp
        <div class="res-header">
            <span class="res-label">Resultados</span>
            <span class="res-count">{{ count($resultados) }} orden{{ count($resultados) > 1 ? 'es' : '' }} encontrada{{ count($resultados) > 1 ? 's' : '' }}</span>
        </div>
        @foreach($resultados as $i => $o)
        @php
            $estados = [
                'En Revisión'        => ['#D97706','En revisión','fa-magnifying-glass'],
                'En Reparacion'      => ['#2563EB','En reparación','fa-screwdriver-wrench'],
                'Esperando Repuesto' => ['#7C3AED','Esperando repuesto','fa-box'],
                'Finalizada'         => ['#059669','Finalizada','fa-circle-check'],
                'Entregada'          => ['#6B7280','Entregada','fa-hand-holding-box'],
                'Anulada'            => ['#DC2626','Anulada','fa-ban'],
                'Nota de Credito'    => ['#DB2777','Nota de crédito','fa-file-invoice'],
            ];
            [$color,$label,$icon] = $estados[$o['estado_orden'] ?? ''] ?? ['#6B7280',$o['estado_orden'] ?? 'Sin estado','fa-file-lines'];
            $equipo = trim(implode(' ', array_filter([$o['tipo_equipo'] ?? '',$o['marca_equipo'] ?? '',$o['modelo_equipo'] ?? ''])));
            $cliente = trim(($o['nombres'] ?? '') . ' ' . ($o['apellidos'] ?? '')) ?: ($o['cliente'] ?? '');
            $texto_falla = trim(($o['falla'] ?? '') . (($o['falla'] && $o['observacion']) ? ' — ' : '') . ($o['observacion'] ?? ''));
        @endphp
        <div class="orden-card" style="animation-delay:{{ $i * 0.06 }}s">
            <div class="card-head">
                <span class="nro-orden">{{ $o['nro_orden'] ?? '—' }}</span>
                <span class="estado-badge" style="color:{{ $color }};border-color:{{ $color }}40;background:{{ $color }}18">
                    <i class="fa-solid {{ $icon }}" style="font-size:10px"></i>
                    {{ $label }}
                </span>
            </div>
            <div class="card-body">
                @if($cliente)
                <div class="info-item"><label>Cliente</label><span>{{ $cliente }}</span></div>
                @endif
                <div class="info-item"><label>Equipo</label><span>{{ $equipo ?: '—' }}</span></div>
                <div class="info-item"><label>Técnico</label><span>{{ $o['tecnico'] ?? '—' }}</span></div>
                <div class="info-item"><label>Sucursal</label><span>{{ $o['sucursal'] ?? '—' }}</span></div>
                @if(!empty($o['fecha_ingreso']))
                <div class="info-item"><label>Fecha de ingreso</label><span>{{ $o['fecha_ingreso'] }}</span></div>
                @endif
                @if(!empty($o['motivo_ingreso']))
                <div class="info-item"><label>Motivo</label><span>{{ $o['motivo_ingreso'] }}</span></div>
                @endif
                @if($texto_falla)
                <div class="info-full"><label>Descripción del problema</label><p>{{ $texto_falla }}</p></div>
                @endif
            </div>
        </div>
        @endforeach
        @endif

    </div>
</section>

{{-- ═══ ENV ═══ --}}
<section class="grt-env">
    <div class="grt-env-inner rv">
        <div>
            <div class="grt-env-tag">Centro de Recursos</div>
            <h2 class="grt-env-title">Drivers y soporte<br>oficial ENV</h2>
            <p class="grt-env-desc">Accede a todos los controladores y actualizaciones oficiales para equipos ENV. Siempre la versión más reciente, verificada y segura.</p>
            <a href="https://www.env.com.ec/downloads" class="grt-env-btn" target="_blank" rel="noopener">
                Centro de descargas <i class="fa-solid fa-arrow-up-right-from-square"></i>
            </a>
        </div>
        <div class="grt-env-img-wrap">
            <img src="{{ asset('images/novitec_logo.png') }}" class="grt-env-img" alt="Novitec">
        </div>
    </div>
</section>

</div>

@endsection

@push('scripts')
<script>
(function(){

var ro = new IntersectionObserver(function(en){
    en.forEach(function(e){ if(e.isIntersecting){ e.target.classList.add('vis'); ro.unobserve(e.target); } });
},{threshold:.1});
document.querySelectorAll('.rv').forEach(function(el){ ro.observe(el); });

var rules = document.querySelectorAll('.grt-rule');
var rObs = new IntersectionObserver(function(en){
    en.forEach(function(e){
        if(e.isIntersecting){
            var idx = Array.prototype.indexOf.call(rules, e.target);
            setTimeout(function(){ e.target.classList.add('vis'); }, idx*110);
            rObs.unobserve(e.target);
        }
    });
},{threshold:.15});
rules.forEach(function(r){ rObs.observe(r); });

var CATS = {
    COMPUTADORAS: ['HP','ASUS','LENOVO','ENV','DELL'],
    CELULARES:    ['SAMSUNG','XIAOMI','ENV','HONOR','INFINIX','TECNO','MOTOROLA','ITEL','VIVOQ','REALME'],
    TABLETS:      ['LENOVO','AMAZON','ONE','REALME','ENV','CHUWI','BLACKVIEW','DOOGEE','SAMSUNG','XIAOMI'],
    IMPRESORAS:   ['EPSON / CANNON / HP'],
    TELEVISIONES: ['EVVO / TCL / ZITRO / RCA / HOUSETV','TCL / RCA / ZITRO','NAKAMICHI / BLAUPUNKT','SAMSUNG','DAEWO','MOTOROLA'],
    CONSOLAS:     ['SONY'],
    OTROS:        ['OSTER','JBL','TCL']
};
var CAT_ICO = {
    COMPUTADORAS:'fa-solid fa-laptop', CELULARES:'fas fa-mobile-alt',
    TABLETS:'fas fa-tablet-alt', IMPRESORAS:'fa-solid fa-print',
    TELEVISIONES:'fa-solid fa-tv', CONSOLAS:'fa-solid fa-gamepad', OTROS:'fa-solid fa-headphones'
};
var BRAND_LOGO = {
    'HP':      'https://cdn.simpleicons.org/hp/1A3D7C',
    'ASUS':    'https://cdn.simpleicons.org/asus/1A3D7C',
    'LENOVO':  'https://cdn.simpleicons.org/lenovo/1A3D7C',
    'DELL':    'https://cdn.simpleicons.org/dell/1A3D7C',
    'SAMSUNG': 'https://cdn.simpleicons.org/samsung/1A3D7C',
    'XIAOMI':  'https://cdn.simpleicons.org/xiaomi/1A3D7C',
    'HONOR':   'https://cdn.simpleicons.org/honor/1A3D7C',
    'MOTOROLA':'https://cdn.simpleicons.org/motorola/1A3D7C',
    'REALME':  'https://cdn.simpleicons.org/realme/1A3D7C',
    'AMAZON':  'https://cdn.simpleicons.org/amazon/1A3D7C',
    'SONY':    'https://cdn.simpleicons.org/sony/1A3D7C',
    'JBL':     'https://cdn.simpleicons.org/jbl/1A3D7C',
};
var ENV_LOGO = '{{ asset("images/novitec_logo.png") }}';
var CAT_FALLBACK = {
    COMPUTADORAS:'fa-solid fa-laptop', CELULARES:'fas fa-mobile-alt',
    TABLETS:'fas fa-tablet-alt', IMPRESORAS:'fa-solid fa-print',
    TELEVISIONES:'fa-solid fa-tv', CONSOLAS:'fa-solid fa-gamepad', OTROS:'fa-solid fa-headphones'
};
var INFO = {
    'HP': { contacto: '<h4>Soporte Técnico HP (NETSER)</h4><p><strong>Info:</strong> Generar ticket vía telefónica al 1800 225528 o al 1800 7112884.</p><p><strong>Dirección UIO:</strong> Av. José Tamayo N24-490 y Luis Cordero, Locales 1 y 2.</p><p><strong>Teléfono:</strong> 02 5132593</p><p><strong>Horarios:</strong> 09:00 – 17:00 (Lun–Vie)</p>', mapa: 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3989.792961718442!2d-78.48581949999999!3d-0.2042792!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x91d59b1d4c00188d%3A0x36d12ff078b732b6!2sNetser%20Ecuador!5e0!3m2!1ses!2sec!4v1771882449251!5m2!1ses!2sec' },
    'ASUS': { contacto: '<h4>Soporte Técnico ASUS (COMPUHELP S.A)</h4><p><strong>Dirección UIO:</strong> Eloy Alfaro 2013 y Suiza.</p><p><strong>Teléfono:</strong> 2224-4026 - 2244-0298</p><p><strong>Horarios:</strong> 09:00 – 17:00 (Lun–Vie)</p>', mapa: 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3989.796968271351!2d-78.4807761!3d-0.18744819999999998!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x91d59a7eabc6e2cf%3A0x9f5cfeceeb34165b!2sCOMPUHELP%20S.A!5e0!3m2!1ses!2sec!4v1771873666698!5m2!1ses!2sec' },
    'LENOVO': { contacto: '<h4>Soporte Técnico LENOVO (INACORP S.A)</h4><p><strong>Info:</strong> Generar ticket en <a href="https://support.lenovo.com/ec/es/track-repair-status" target="_blank">support.lenovo.com</a></p><p><strong>Dirección UIO:</strong> Juan Severino E6-80 y Eloy Alfaro (Matriz)</p><p><strong>Teléfono:</strong> 2904-129</p><p><strong>Horarios:</strong> 09:00 – 17:00 (Lun–Vie)</p>', mapa: 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3989.7962715235344!2d-78.48358600000002!3d-0.19048199999999998!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x91d59a7a568e23e7%3A0x7b95f2b137507a92!2sInacorpsa%20Del%20Ecuador%20S.A.%20UIO!5e0!3m2!1ses!2sec!4v1771873792428!5m2!1ses!2sec' },
    'ENV': { contacto: '<h4>Soporte Técnico ENV (NOVITEC)</h4><p><strong>Dirección UIO:</strong> Calle N73 y Mariano Paredes (Ponceano Alto).</p><p><strong>Teléfono:</strong> 6001-635 / 0960500156</p><p><strong>Horarios:</strong> 09:00 – 17:00 (Lun–Vie)</p>', mapa: 'https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d127673.5559056865!2d-78.5734424!3d-0.1800427!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x91d58585e2ade465%3A0x1da55fd6da94142c!2sNOVICOMPU%20-%20NOVITEC!5e0!3m2!1ses!2sec!4v1771873910567!5m2!1ses!2sec' },
    'DELL': { contacto: '<h4>Soporte Técnico DELL (PC LAPTOP)</h4><p><strong>Info:</strong> Ticket en <a href="https://www.dell.com/support/incidents-online/contactus" target="_blank">dell.com/support</a> o WhatsApp <a href="https://wa.me/5215548220642" target="_blank">+521 5548220642</a></p><p><strong>Dirección:</strong> Av. De los Shyris y República del Salvador, Edif. Alfa, PB</p><p><strong>Teléfono:</strong> 0999023049</p>', mapa: 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3989.797585641065!2d-78.4821468!3d-0.18471839999999998!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x91d59bdc59128d6d%3A0xc4289f6c0fae7e5e!2sPC%20LAPTOP%20ECUADOR!5e0!3m2!1ses!2sec!4v1771874050278!5m2!1ses!2sec' },
    'SAMSUNG': { contacto: '<h4>Soporte Técnico SAMSUNG (ELECSERVITEC)</h4><p><strong>Dirección:</strong> Av. Amazonas, CC El Globo</p><p><strong>Teléfono:</strong> 2436-686 / 2264-541</p><p><strong>Horarios:</strong> 09:30 – 18:00 (Lun–Vie)</p>', mapa: 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3989.801087924078!2d-78.48409579999999!3d-0.168397!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x91d59a890cb7a6d5%3A0xca1cef9b8e2681d!2sSamsung%20Smart%20Center%20%7C%20Quito!5e0!3m2!1ses!2sec!4v1771877685873!5m2!1ses!2sec' },
    'XIAOMI': { contacto: '<h4>Soporte Técnico XIAOMI (WODEN ECUADOR)</h4><p><strong>Dirección:</strong> Sector Carcelén industrial Antonio Flor, Quito</p><p><strong>Teléfono:</strong> 0963000279</p><p><strong>Horarios:</strong> 09:00 – 17:00 (Lun–Vie)</p>', mapa: 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3989.812100850824!2d-78.47660052515242!3d-0.10116693547878694!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x91d58f44752ced57%3A0x8fbe2f4a586f17f4!2sWoden%20Ecuador!5e0!3m2!1ses!2sec!4v1771877857771!5m2!1ses!2sec' },
    'HONOR': { contacto: '<h4>Soporte Técnico HONOR (WODEN ECUADOR)</h4><p><strong>Dirección:</strong> Sector Carcelén industrial Antonio Flor, Quito</p><p><strong>Teléfono:</strong> 0963000279</p><p><strong>Horarios:</strong> 09:00 – 17:00 (Lun–Vie)</p>', mapa: 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3989.812100850824!2d-78.47660052515242!3d-0.10116693547878694!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x91d58f44752ced57%3A0x8fbe2f4a586f17f4!2sWoden%20Ecuador!5e0!3m2!1ses!2sec!4v1771877857771!5m2!1ses!2sec' },
    'INFINIX': { contacto: '<h4>Soporte Técnico INFINIX (CARLCARE)</h4><p><strong>Dirección:</strong> Av. Diego de Almagro 1824 (antes de Whymper)</p><p><strong>Teléfono:</strong> 0962241641</p><p><strong>Horarios:</strong> 09:00 – 18:00 (Lun–Vie)</p>', mapa: 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3989.812100850824!2d-78.47660052515242!3d-0.10116693547878694!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x91d58f44752ced57%3A0x8fbe2f4a586f17f4!2sWoden%20Ecuador!5e0!3m2!1ses!2sec!4v1771877857771!5m2!1ses!2sec' },
    'TECNO': { contacto: '<h4>Soporte Técnico TECNO (CARLCARE)</h4><p><strong>Dirección:</strong> Av. Diego de Almagro 1824 (antes de Whymper)</p><p><strong>Teléfono:</strong> 0962241641</p><p><strong>Horarios:</strong> 09:00 – 18:00 (Lun–Vie)</p>', mapa: 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3989.812100850824!2d-78.47660052515242!3d-0.10116693547878694!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x91d58f44752ced57%3A0x8fbe2f4a586f17f4!2sWoden%20Ecuador!5e0!3m2!1ses!2sec!4v1771877857771!5m2!1ses!2sec' },
    'MOTOROLA': { contacto: '<h4>Soporte Técnico MOTOROLA (INDURAMA SERVIHOGAR)</h4><p><strong>Dirección:</strong> Av. Río Amazonas y Japón</p><p><strong>Teléfono:</strong> 0988766868</p><p><strong>Horarios:</strong> 09:30 – 18:00 (Lun–Vie)</p>', mapa: 'https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d127673.99134149682!2d-78.5586632!3d-0.1001158!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x91d59a63c9b3405b%3A0x4cff6bd37292bc6b!2sIndurama%20Servihogar!5e0!3m2!1ses!2sec!4v1771880831150!5m2!1ses!2sec' },
    'ITEL': { contacto: '<h4>Soporte Técnico ITEL (NOVITEC)</h4><p><strong>Dirección UIO:</strong> Calle N73 y Mariano Paredes (Ponceano Alto).</p><p><strong>Teléfono:</strong> 6001-635 / 0960500156</p><p><strong>Horarios:</strong> 09:00 – 17:00 (Lun–Vie)</p>', mapa: 'https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d127673.5559056865!2d-78.5734424!3d-0.1800427!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x91d58585e2ade465%3A0x1da55fd6da94142c!2sNOVICOMPU%20-%20NOVITEC!5e0!3m2!1ses!2sec!4v1771873910567!5m2!1ses!2sec' },
    'VIVOQ': { contacto: '<h4>Soporte Técnico VIVOQ (NOVITEC)</h4><p><strong>Dirección UIO:</strong> Calle N73 y Mariano Paredes (Ponceano Alto).</p><p><strong>Teléfono:</strong> 6001-635 / 0960500156</p><p><strong>Horarios:</strong> 09:00 – 17:00 (Lun–Vie)</p>', mapa: 'https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d127673.5559056865!2d-78.5734424!3d-0.1800427!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x91d58585e2ade465%3A0x1da55fd6da94142c!2sNOVICOMPU%20-%20NOVITEC!5e0!3m2!1ses!2sec!4v1771873910567!5m2!1ses!2sec' },
    'REALME': { contacto: '<h4>Soporte Técnico REALME (NOVITEC)</h4><p><strong>Dirección UIO:</strong> Calle N73 y Mariano Paredes (Ponceano Alto).</p><p><strong>Teléfono:</strong> 6001-635 / 0960500156</p><p><strong>Horarios:</strong> 09:00 – 17:00 (Lun–Vie)</p>', mapa: 'https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d127673.5559056865!2d-78.5734424!3d-0.1800427!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x91d58585e2ade465%3A0x1da55fd6da94142c!2sNOVICOMPU%20-%20NOVITEC!5e0!3m2!1ses!2sec!4v1771873910567!5m2!1ses!2sec' },
    'AMAZON': { contacto: '<h4>Soporte Técnico AMAZON (NOVITEC)</h4><p><strong>Dirección UIO:</strong> Calle N73 y Mariano Paredes (Ponceano Alto).</p><p><strong>Teléfono:</strong> 6001-635 / 0960500156</p><p><strong>Horarios:</strong> 09:00 – 17:00 (Lun–Vie)</p>', mapa: 'https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d127673.5559056865!2d-78.5734424!3d-0.1800427!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x91d58585e2ade465%3A0x1da55fd6da94142c!2sNOVICOMPU%20-%20NOVITEC!5e0!3m2!1ses!2sec!4v1771873910567!5m2!1ses!2sec' },
    'ONE': { contacto: '<h4>Soporte Técnico ONE (NOVITEC)</h4><p><strong>Dirección UIO:</strong> Calle N73 y Mariano Paredes (Ponceano Alto).</p><p><strong>Teléfono:</strong> 6001-635 / 0960500156</p><p><strong>Horarios:</strong> 09:00 – 17:00 (Lun–Vie)</p>', mapa: 'https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d127673.5559056865!2d-78.5734424!3d-0.1800427!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x91d58585e2ade465%3A0x1da55fd6da94142c!2sNOVICOMPU%20-%20NOVITEC!5e0!3m2!1ses!2sec!4v1771873910567!5m2!1ses!2sec' },
    'CHUWI': { contacto: '<h4>Soporte Técnico CHUWI (NOVITEC)</h4><p><strong>Dirección UIO:</strong> Calle N73 y Mariano Paredes (Ponceano Alto).</p><p><strong>Teléfono:</strong> 6001-635 / 0960500156</p><p><strong>Horarios:</strong> 09:00 – 17:00 (Lun–Vie)</p>', mapa: 'https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d127673.5559056865!2d-78.5734424!3d-0.1800427!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x91d58585e2ade465%3A0x1da55fd6da94142c!2sNOVICOMPU%20-%20NOVITEC!5e0!3m2!1ses!2sec!4v1771873910567!5m2!1ses!2sec' },
    'BLACKVIEW': { contacto: '<h4>Soporte Técnico BLACKVIEW (NOVITEC)</h4><p><strong>Dirección UIO:</strong> Calle N73 y Mariano Paredes (Ponceano Alto).</p><p><strong>Teléfono:</strong> 6001-635 / 0960500156</p><p><strong>Horarios:</strong> 09:00 – 17:00 (Lun–Vie)</p>', mapa: 'https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d127673.5559056865!2d-78.5734424!3d-0.1800427!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x91d58585e2ade465%3A0x1da55fd6da94142c!2sNOVICOMPU%20-%20NOVITEC!5e0!3m2!1ses!2sec!4v1771873910567!5m2!1ses!2sec' },
    'DOOGEE': { contacto: '<h4>Soporte Técnico DOOGEE (NOVITEC)</h4><p><strong>Dirección UIO:</strong> Calle N73 y Mariano Paredes (Ponceano Alto).</p><p><strong>Teléfono:</strong> 6001-635 / 0960500156</p><p><strong>Horarios:</strong> 09:00 – 17:00 (Lun–Vie)</p>', mapa: 'https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d127673.5559056865!2d-78.5734424!3d-0.1800427!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x91d58585e2ade465%3A0x1da55fd6da94142c!2sNOVICOMPU%20-%20NOVITEC!5e0!3m2!1ses!2sec!4v1771873910567!5m2!1ses!2sec' },
    'EPSON / CANNON / HP': { contacto: '<h4>Soporte Técnico MULTIMARCA (SIGLO XXI)</h4><p><strong>Dirección:</strong> Sector El Cóndor OE5-32 y Edmundo Carvajal (sector el bosque)</p><p><strong>Teléfono:</strong> 0979685359</p><p><strong>Horarios:</strong> 09:00 – 18:00 (Lun–Vie)</p>', mapa: 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3989.802878179228!2d-78.4923714!3d-0.1594099!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x91d59abbde246e4b%3A0x445f794511ff7219!2sElectronica%20Siglo21%20UIO!5e0!3m2!1ses!2sec!4v1771879077466!5m2!1ses!2sec' },
    'EVVO / TCL / ZITRO / RCA / HOUSETV': { contacto: '<h4>Soporte Técnico MULTIMARCA (MASTERTECH)</h4><p><strong>Dirección UIO:</strong> Pascual de Andagoya y Antonio de Ulloa</p><p><strong>Teléfono:</strong> 0999219043</p><p><strong>Horarios:</strong> 09:00 – 17:00 (Lun–Vie)</p>', mapa: 'https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d7979.591971845032!2d-78.5015497!3d-0.1917117!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x91d59bd5bcb49f99%3A0x2994c2ccc4b23028!2sMastertech!5e0!3m2!1ses!2sec!4v1771880007048!5m2!1ses!2sec' },
    'TCL / RCA / ZITRO': { contacto: '<h4>Soporte Técnico MULTIMARCA (SERMATEC)</h4><p><strong>Dirección UIO:</strong> Av. Napo (Frente al colegio Montúfar)</p><p><strong>Teléfono:</strong> 3131-265</p><p><strong>Horarios:</strong> 09:00 – 18:00 (Lun–Vie)</p>', mapa: 'https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d127673.0808657145!2d-78.6542331!3d-0.2384203!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x91d599a2bcf41bef%3A0x52f93e829eb06047!2sSERMATEC!5e0!3m2!1ses!2sec!4v1771879905563!5m2!1ses!2sec' },
    'NAKAMICHI / BLAUPUNKT': { contacto: '<h4>Soporte Técnico MULTIMARCA (SERVIHOGAR)</h4><p><strong>Dirección UIO:</strong> Av. Río Amazonas y Japón</p><p><strong>Teléfono:</strong> 1700 500 700 / 0999303030</p><p><strong>Horarios:</strong> 09:00 – 17:00 (Lun–Vie)</p>', mapa: 'https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d7979.591971845032!2d-78.5015497!3d-0.1917117!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x91d59bd5bcb49f99%3A0x2994c2ccc4b23028!2sMastertech!5e0!3m2!1ses!2sec!4v1771880007048!5m2!1ses!2sec' },
    'DAEWO': { contacto: '<h4>Soporte Técnico DAEWO (ENSAB)</h4><p><strong>Dirección:</strong> Vireti y San Jorge (Carapungo)</p><p><strong>Teléfono:</strong> 0983515579</p><p><strong>Horarios:</strong> 09:30 – 18:00 (Lun–Vie)</p>', mapa: 'https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d3989.8120684266883!2d-78.445772!3d-0.1014303!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x91d58f0e357960a5%3A0x96d71c692b8ecaf1!2sEnsab!5e0!3m2!1ses!2sec!4v1771880502675!5m2!1ses!2sec' },
    'SONY': { contacto: '<h4>Soporte Técnico SONY (VIDEOAUDIO SISTEMAS)</h4><p><strong>Dirección:</strong> Av. 10 de Agosto y Falconi N42-49 (Sector la Y)</p><p><strong>Teléfono:</strong> 2921-473</p><p><strong>Horarios:</strong> 09:00 – 18:00 (Lun–Vie)</p>', mapa: 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3989.801782050693!2d-78.4865683!3d-0.16497059999999997!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x91d59b7a6c5320e1%3A0x9b067d912adb522b!2sVIDEOAUDIO%20SISTEMAS!5e0!3m2!1ses!2sec!4v1771881075361!5m2!1ses!2sec' },
    'OSTER': { contacto: '<h4>Soporte Técnico OSTER (SERVICIO MASTER ECUADOR)</h4><p><strong>Dirección:</strong> Capitán Rafael Ramos OE1-85 y Av. Galo Plaza Lasso</p><p><strong>Teléfono:</strong> 2813-882 / 2409-870</p><p><strong>Horarios:</strong> 09:00 – 17:00 (Lun–Vie)</p>', mapa: 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3989.8045086112934!2d-78.4850859!3d-0.1507597!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x91d59aadddb56ca9%3A0x991fd5eeb723e2d8!2sServicio%20Master%20Ecuador!5e0!3m2!1ses!2sec!4v1771881726521!5m2!1ses!2sec' },
    'JBL': { contacto: '<h4>Soporte Técnico JBL (NOVITEC)</h4><p><strong>Dirección UIO:</strong> Calle N73 y Mariano Paredes (Ponceano Alto).</p><p><strong>Teléfono:</strong> 6001-635 / 0960500156</p><p><strong>Horarios:</strong> 09:00 – 17:00 (Lun–Vie)</p>', mapa: 'https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d127673.5559056865!2d-78.5734424!3d-0.1800427!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x91d58585e2ade465%3A0x1da55fd6da94142c!2sNOVICOMPU%20-%20NOVITEC!5e0!3m2!1ses!2sec!4v1771873910567!5m2!1ses!2sec' },
    'TCL': { contacto: '<h4>Soporte Técnico TCL (MASTERTECH)</h4><p><strong>Dirección UIO:</strong> Pascual de Andagoya y Antonio de Ulloa</p><p><strong>Teléfono:</strong> 0999219043</p><p><strong>Horarios:</strong> 09:00 – 17:00 (Lun–Vie)</p>', mapa: 'https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d7979.591971845032!2d-78.5015497!3d-0.1917117!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x91d59bd5bcb49f99%3A0x2994c2ccc4b23028!2sMastertech!5e0!3m2!1ses!2sec!4v1771880007048!5m2!1ses!2sec' },
};

var currentCat = null;
document.getElementById('grtCatsGrid').addEventListener('click', function(e){
    var card = e.target.closest('.grt-cat');
    if(!card) return;
    var cat = card.dataset.cat;
    if(currentCat === cat){
        card.classList.remove('active');
        document.getElementById('grtBrands').classList.remove('open');
        document.getElementById('grtDetail').classList.remove('show');
        currentCat = null; return;
    }
    document.querySelectorAll('.grt-cat.active').forEach(function(c){ c.classList.remove('active'); });
    card.classList.add('active');
    currentCat = cat;
    document.getElementById('grtActIcon').className = CAT_ICO[cat]||'fa-solid fa-star';
    document.getElementById('grtActName').textContent = cat;
    document.getElementById('grtSearch').value = '';
    document.getElementById('grtDetail').classList.remove('show');
    renderBrands(cat);
    document.getElementById('grtBrands').classList.add('open');
    setTimeout(function(){ document.getElementById('grtBrands').scrollIntoView({behavior:'smooth',block:'start'}); },140);
});

function renderBrands(cat){
    var grid = document.getElementById('grtBrandsGrid');
    grid.innerHTML = '';
    var fallbackIco = CAT_FALLBACK[cat]||'fas fa-circle';
    (CATS[cat]||[]).forEach(function(name,i){
        var btn = document.createElement('div');
        btn.className = 'grt-brand';
        btn.style.animationDelay = (i*40)+'ms';
        var iconEl;
        if(name==='ENV'){
            iconEl = document.createElement('img');
            iconEl.src = ENV_LOGO; iconEl.className = 'grt-brand-logo'; iconEl.alt = 'ENV';
        } else if(BRAND_LOGO[name]){
            iconEl = document.createElement('img');
            iconEl.src = BRAND_LOGO[name]; iconEl.className = 'grt-brand-logo'; iconEl.alt = name;
            iconEl.onerror = function(){
                var f = document.createElement('i');
                f.className = fallbackIco + ' grt-brand-ico';
                btn.replaceChild(f, this);
            };
        } else {
            iconEl = document.createElement('i');
            iconEl.className = fallbackIco + ' grt-brand-ico';
        }
        var nameEl = document.createElement('span');
        nameEl.className = 'grt-brand-name'; nameEl.textContent = name;
        btn.appendChild(iconEl); btn.appendChild(nameEl);
        btn.addEventListener('click', function(){ showBrand(name, cat, btn); });
        grid.appendChild(btn);
    });
}

document.getElementById('grtSearch').addEventListener('input', function(e){
    var q = e.target.value.toLowerCase().trim();
    document.querySelectorAll('.grt-brand').forEach(function(b){
        b.classList.toggle('hidden', q!==''&&!b.querySelector('.grt-brand-name').textContent.toLowerCase().includes(q));
    });
});

function showBrand(name, cat, btn){
    document.querySelectorAll('.grt-brand.active').forEach(function(b){ b.classList.remove('active'); });
    btn.classList.add('active');
    var data = INFO[name];
    var det = document.getElementById('grtDetail');
    det.classList.remove('show');
    if(data){
        document.getElementById('grtDetailInfo').innerHTML = '<div class="grt-detail-name">'+name+'</div><div class="grt-detail-cat"><i class="'+(CAT_ICO[cat]||'')+'"></i> '+cat+'</div>'+data.contacto;
        document.getElementById('grtDetailMap').innerHTML = '<iframe src="'+data.mapa+'" allowfullscreen loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>';
    }
    void det.offsetWidth;
    det.classList.add('show');
    setTimeout(function(){ det.scrollIntoView({behavior:'smooth',block:'nearest'}); },100);
}

function setTipo(tipo, btn){
    document.getElementById('tipo-input').value = tipo;
    document.querySelectorAll('.tipo-tab').forEach(function(b){ b.classList.remove('active'); });
    btn.classList.add('active');
    var inp = document.getElementById('q-input');
    var icon = document.getElementById('input-icon');
    var hint = document.getElementById('hint-text');
    if(tipo==='nro_orden'){
        inp.placeholder = 'Ej: UIO-000123';
        icon.className = 'fa-solid fa-magnifying-glass';
        hint.textContent = 'Ingresa el número completo tal como aparece en tu comprobante de ingreso.';
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
