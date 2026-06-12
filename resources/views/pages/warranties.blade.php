@extends('layouts.app')

@section('title', 'Validar Garantía – Novitecnología Cia. Ltda.')

@section('content')

<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');
*{box-sizing:border-box;}
body{font-family:'Inter',sans-serif;}

/* WRAP */
.po-wrap{min-height:60vh;background:linear-gradient(135deg,#f0f4ff 0%,#e8f0fe 28%,#fdf4ff 58%,#ecfdf5 100%);display:flex;align-items:center;justify-content:center;padding:100px 24px 60px;}
.po-shell{width:100%;max-width:920px;display:flex;flex-direction:column;gap:24px;}

/* ENTRY */
.po-entry{background:rgba(255,255,255,.9);border:1px solid rgba(255,255,255,.7);border-radius:32px;box-shadow:0 30px 80px rgba(15,23,42,.16);overflow:hidden;backdrop-filter:blur(10px);}
.po-entry-top{padding:34px 38px 18px;color:#0f172a;background:transparent;}
.po-entry-top .po-kicker{font-size:11px;font-weight:700;letter-spacing:.12em;text-transform:uppercase;color:#2563eb;margin-bottom:10px;}
.po-entry-top h1{font-size:30px;font-weight:800;line-height:1.18;margin:0 0 10px;font-family:'Playfair Display',serif;}
.po-entry-top p{font-size:14px;line-height:1.75;color:#64748b;margin:0;max-width:720px;}
.po-entry-body{padding:12px 38px 38px;}
.po-entry-grid{display:grid;grid-template-columns:1fr;gap:18px;}
.po-entry-panel{border:1px solid #e2e8f0;border-radius:24px;padding:24px;background:#fff;}
.po-entry-title{font-size:16px;font-weight:800;color:#0f172a;margin:0 0 10px;}
.po-entry-copy{font-size:13px;line-height:1.7;color:#64748b;margin:0 0 14px;}
.po-legal-list{display:flex;flex-direction:column;gap:12px;}
.po-legal-item{display:flex;gap:12px;align-items:flex-start;padding:14px 16px;border:1px solid #e2e8f0;border-radius:16px;background:#fff;transition:border-color .2s,box-shadow .2s;}
.po-legal-item:has(input:checked){border-color:#60a5fa;box-shadow:0 0 0 3px rgba(37,99,235,.08);}
.po-legal-item input{margin-top:3px;width:18px;height:18px;accent-color:#2563eb;cursor:pointer;flex-shrink:0;}
.po-legal-item strong{display:block;font-size:13px;color:#0f172a;margin-bottom:4px;}
.po-legal-item span{display:block;font-size:12px;line-height:1.55;color:#64748b;}
.po-entry-note{margin-top:16px;font-size:12px;line-height:1.7;color:#64748b;background:#f8fafc;border:1px dashed #cbd5e1;border-radius:16px;padding:13px 15px;}
.po-user-box{background:#eff6ff;border:1px solid #bfdbfe;color:#1d4ed8;border-radius:16px;padding:13px 15px;font-size:13px;line-height:1.6;margin-bottom:14px;}
.po-gate-error{display:none;margin-top:14px;background:#fef2f2;border:1px solid #fca5a5;color:#991b1b;border-radius:12px;padding:11px 14px;font-size:13px;line-height:1.5;}
.po-entry-actions{display:flex;flex-direction:column;gap:12px;margin-top:18px;}
.po-entry-btn,.po-entry-link{display:flex;align-items:center;justify-content:center;text-align:center;padding:14px 18px;border-radius:18px;font-size:14px;font-weight:800;transition:transform .15s,opacity .2s,box-shadow .2s;text-decoration:none;border:none;font-family:'Inter',sans-serif;}
.po-entry-btn:hover:not(:disabled),.po-entry-link:hover:not(.is-disabled){transform:translateY(-2px);}
.po-entry-btn{background:#2563eb;color:#fff;box-shadow:0 12px 28px rgba(37,99,235,.22);cursor:pointer;}
.po-entry-btn:disabled{opacity:.5;cursor:not-allowed;box-shadow:none;}
.po-entry-link.pri{background:#2563eb;color:#fff;box-shadow:0 12px 28px rgba(37,99,235,.22);}
.po-entry-link.sec{background:#f8fafc;color:#2563eb;border:1px solid #bfdbfe;}
.po-entry-link.is-disabled{opacity:.5;pointer-events:none;box-shadow:none;}

/* CARD */
.po-card{background:rgba(255,255,255,.94);border:1px solid rgba(255,255,255,.72);border-radius:28px;box-shadow:0 30px 80px rgba(15,23,42,.16);width:100%;max-width:640px;overflow:hidden;backdrop-filter:blur(10px);}

/* HEADER */
.po-hdr{padding:32px 40px 22px;color:#0f172a;background:transparent;border-bottom:1px solid #e2e8f0;}
.po-hdr .po-logo{font-size:11px;font-weight:700;letter-spacing:.12em;text-transform:uppercase;color:#2563eb;margin-bottom:8px;}
.po-hdr h1{font-size:28px;font-weight:800;margin:0 0 6px;line-height:1.2;font-family:'Playfair Display',serif;}
.po-hdr p{font-size:14px;color:#64748b;margin:0;}

/* STEPS */
.po-steps{display:flex;background:#f8fafc;border-bottom:1px solid #e2e8f0;}
.po-step{flex:1;display:flex;flex-direction:column;align-items:center;padding:16px 6px 12px;font-size:12px;font-weight:600;color:#9ca3af;position:relative;gap:6px;}
.po-step::after{content:'';position:absolute;bottom:0;left:0;right:0;height:3px;background:transparent;border-radius:2px 2px 0 0;transition:background .3s;}
.po-step.active{color:#1a3d7c;}.po-step.active::after{background:#2563eb;}
.po-step.done{color:#059669;}.po-step.done::after{background:#059669;}
.po-snum{width:28px;height:28px;border-radius:50%;border:2px solid #d1d5db;display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:700;background:#fff;transition:all .3s;}
.po-step.active .po-snum{border-color:#2563eb;color:#2563eb;background:#eff6ff;}
.po-step.done .po-snum{border-color:#059669;background:#059669;color:#fff;}

/* BODY */
.po-body{padding:32px 40px;background:transparent;}
.po-pane{display:none;}.po-pane.active{display:block;}

/* FORM GROUPS */
.po-g{margin-bottom:20px;}
.po-g label{display:block;font-size:14px;font-weight:600;color:#374151;margin-bottom:7px;}
.po-g .req{color:#ef4444;}
.po-g input,.po-g select,.po-g textarea{display:block;width:100%;padding:14px 16px;border:1px solid #e2e8f0;border-radius:18px;font-size:15px;color:#111;background:#f8fafc;transition:border-color .2s,box-shadow .2s,background .2s;outline:none;font-family:'Inter',sans-serif;}
.po-g input:focus,.po-g select:focus,.po-g textarea:focus{border-color:#2563eb;box-shadow:0 0 0 3px rgba(37,99,235,.12);}
.po-g input.poe,.po-g select.poe,.po-g textarea.poe{border-color:#ef4444;box-shadow:0 0 0 3px rgba(239,68,68,.1);}
.po-g textarea{resize:vertical;min-height:80px;line-height:1.5;}
.po-hint{font-size:12px;color:#94a3b8;margin-top:5px;line-height:1.4;}
.po-em{font-size:12px;color:#ef4444;margin-top:5px;display:none;line-height:1.4;}

/* BADGE SUCURSAL */
.po-suc-badge{display:none;margin-top:10px;padding:14px 16px;border-radius:18px;background:#eff6ff;border:1px solid #bfdbfe;font-size:13px;line-height:1.6;}
.po-suc-badge .suc-nom{font-weight:700;color:#1a3d7c;font-size:14px;}
.po-suc-badge .suc-nov{display:inline-block;background:#2563eb;color:#fff;font-size:11px;font-weight:700;padding:2px 8px;border-radius:5px;margin-left:6px;}

/* BADGE PRODUCTO */
.po-badge{margin-top:9px;padding:12px 14px;border-radius:16px;font-size:13.5px;font-weight:600;display:none;line-height:1.45;}
.po-badge.ok{background:#dcfce7;color:#166534;border:1px solid #86efac;}
.po-badge.nok{background:#fef9c3;color:#92400e;border:1px solid #fde68a;}

/* BOTONES */
.po-brow{display:flex;gap:12px;margin-top:16px;}
.po-btn{flex:1;display:block;text-align:center;padding:14px 20px;border-radius:18px;font-size:15px;font-weight:700;cursor:pointer;transition:opacity .2s,transform .15s;border:none;font-family:'Inter',sans-serif;}
.po-btn:hover:not([disabled]){opacity:.9;transform:translateY(-2px);}
.po-btn[disabled]{opacity:.5;cursor:not-allowed;}
.po-btn.pri{background:#2563eb;color:#fff;box-shadow:0 10px 24px rgba(37,99,235,.24);}
.po-btn.sec{background:#f8fafc;color:#475569;border:1px solid #e2e8f0;}

/* ERROR GLOBAL */
.po-gerr{background:#fef2f2;border:1px solid #fca5a5;color:#991b1b;border-radius:9px;padding:11px 16px;font-size:13px;margin-bottom:16px;display:none;line-height:1.5;}

/* FOTOS */
.po-fotos-grid{display:grid;grid-template-columns:repeat(2,1fr);gap:10px;margin-bottom:8px;}
.po-foto-slot{position:relative;border:2px dashed #d1d5db;border-radius:12px;aspect-ratio:4/3;overflow:hidden;cursor:pointer;background:#f8fafc;display:flex;align-items:center;justify-content:center;flex-direction:column;gap:4px;transition:border-color .2s,background .2s;}
.po-foto-slot:hover{border-color:#2563eb;background:#eff6ff;}
.po-foto-slot.poe-foto{border-color:#ef4444;background:#fef2f2;}
.po-foto-slot.has-img{border-style:solid;border-color:#059669;background:#f0fdf4;}
.po-foto-slot input[type=file]{display:none;}
.pf-body{display:flex;flex-direction:column;align-items:center;gap:4px;padding:6px 4px;}
.po-foto-slot.has-img .pf-body{display:none;}
.pf-tag{font-size:10px;font-weight:700;letter-spacing:.04em;text-transform:uppercase;color:#2563eb;background:#eff6ff;border:1px solid #bfdbfe;border-radius:5px;padding:2px 7px;margin-top:2px;}
.pf-lbl{font-size:11px;color:#94a3b8;font-weight:600;text-align:center;}
.pf-check{position:absolute;top:7px;left:7px;background:#059669;color:#fff;border-radius:50%;width:22px;height:22px;display:none;align-items:center;justify-content:center;font-size:13px;}
.po-foto-slot.has-img .pf-check{display:flex;}
.pf-rm{position:absolute;top:7px;right:7px;background:rgba(239,68,68,.9);color:#fff;border:none;border-radius:50%;width:22px;height:22px;font-size:15px;cursor:pointer;display:none;align-items:center;justify-content:center;z-index:4;}
.po-foto-slot.has-img .pf-rm{display:flex;}
.po-foto-slot img.po-prev{position:absolute;inset:0;width:100%;height:100%;object-fit:cover;border-radius:10px;}

/* MODAL FOTO */
.pf-modal-overlay{display:none;position:fixed;inset:0;background:rgba(0,0,0,.45);z-index:9999;align-items:flex-end;justify-content:center;}
.pf-modal-overlay.open{display:flex;}
.pf-modal{background:#fff;border-radius:20px 20px 0 0;padding:24px 20px 32px;width:100%;max-width:480px;box-shadow:0 -8px 40px rgba(0,0,0,.2);}
.pf-modal h3{font-size:15px;font-weight:700;color:#1a3d7c;text-align:center;margin:0 0 6px;}
.pf-modal p{font-size:12px;color:#94a3b8;text-align:center;margin:0 0 20px;}
.pf-modal-opts{display:flex;gap:12px;}
.pf-mopt{flex:1;border:2px solid #e2e8f0;border-radius:14px;padding:18px 10px 14px;display:flex;flex-direction:column;align-items:center;gap:8px;cursor:pointer;background:#f8fafc;transition:border-color .2s;}
.pf-mopt:hover{border-color:#2563eb;background:#eff6ff;}
.pf-mopt-icon{font-size:32px;}
.pf-mopt-lbl{font-size:13px;font-weight:700;color:#374151;}
.pf-mopt-sub{font-size:11px;color:#94a3b8;text-align:center;}
.pf-modal-cancel{display:block;width:100%;margin-top:12px;padding:12px;border:none;background:none;color:#94a3b8;font-size:13px;cursor:pointer;font-weight:600;}
#pf-input-file,#pf-input-cam{display:none;}

/* CONFIRM */
.po-confirm-box{background:#f8fafc;border:1px solid #e2e8f0;border-radius:18px;padding:16px 18px;margin-bottom:16px;font-size:13px;color:#374151;line-height:1.8;}
.cf-row{display:flex;gap:8px;border-bottom:1px solid #f1f5f9;padding:5px 0;}
.cf-row:last-child{border-bottom:none;}
.cf-lbl{color:#94a3b8;font-weight:600;min-width:130px;flex-shrink:0;}
.cf-val{color:#111;font-weight:500;word-break:break-word;}

/* TERMS */
.po-terms-box{background:#fffbeb;border:1px solid #fde68a;border-radius:18px;padding:14px 16px;margin-bottom:16px;}
.po-terms-title{font-size:13px;font-weight:700;color:#92400e;margin-bottom:8px;}
.po-terms-body{max-height:160px;overflow-y:auto;font-size:12px;color:#374151;line-height:1.6;padding-right:4px;margin-bottom:10px;}
.po-terms-body p{margin-bottom:6px;}
.po-terms-check{display:flex;align-items:center;gap:8px;font-size:13px;font-weight:600;color:#374151;cursor:pointer;}
.po-terms-check input{width:16px;height:16px;accent-color:#2563eb;cursor:pointer;flex-shrink:0;}

/* SUCCESS */
.po-ok{text-align:center;padding:10px 0 6px;}
.po-ok-icon{width:72px;height:72px;background:#dcfce7;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 18px;font-size:34px;color:#059669;}
.po-ok h2{font-size:20px;color:#111;margin:0 0 6px;font-weight:700;}
.po-ok p{font-size:14px;color:#6b7280;margin:7px 0;line-height:1.65;}
.po-nro{display:inline-block;background:#eff6ff;border:2px solid #2563eb;color:#1a3d7c;font-size:21px;font-weight:800;padding:11px 30px;border-radius:11px;letter-spacing:.06em;margin:10px 0 6px;}
.po-eq{background:#f8fafc;border:1px solid #e5e7eb;border-radius:9px;padding:13px 18px;margin:14px 0;font-size:14px;text-align:left;color:#374151;line-height:1.65;}

/* MODAL SUGERENCIAS */
#sg-overlay{display:none;position:fixed;inset:0;z-index:99990;background:rgba(0,0,0,.55);align-items:center;justify-content:center;padding:16px;backdrop-filter:blur(3px);}
#sg-overlay.open{display:flex;}
#sg-card{background:#fff;border-radius:20px;width:100%;max-width:520px;max-height:92vh;overflow-y:auto;box-shadow:0 20px 60px rgba(0,0,0,.28);position:relative;}
#sg-hdr{background:linear-gradient(135deg,#059669,#10b981);padding:24px 28px 20px;border-radius:20px 20px 0 0;color:#fff;}
#sg-hdr h3{margin:0 0 4px;font-size:18px;font-weight:800;}
#sg-hdr p{margin:0;font-size:13px;opacity:.8;}
#sg-close{position:absolute;top:16px;right:18px;background:rgba(255,255,255,.2);border:none;color:#fff;width:30px;height:30px;border-radius:50%;font-size:18px;cursor:pointer;display:flex;align-items:center;justify-content:center;}
#sg-body{padding:24px 28px 28px;}
.sg-g{margin-bottom:16px;}
.sg-g label{display:block;font-size:13px;font-weight:600;color:#374151;margin-bottom:6px;}
.sg-g .req{color:#ef4444;}
.sg-g input,.sg-g select,.sg-g textarea{display:block;width:100%;padding:11px 15px;border:1.5px solid #e2e8f0;border-radius:10px;font-size:14px;color:#111;background:#fff;outline:none;font-family:'Inter',sans-serif;}
.sg-g input:focus,.sg-g select:focus,.sg-g textarea:focus{border-color:#059669;box-shadow:0 0 0 3px rgba(5,150,105,.12);}
.sg-g textarea{resize:vertical;min-height:110px;line-height:1.55;}
.sg-row{display:grid;grid-template-columns:1fr 1fr;gap:12px;}
.sg-em{font-size:12px;color:#ef4444;margin-top:4px;display:none;}
.sg-gerr{background:#fef2f2;border:1px solid #fca5a5;color:#991b1b;border-radius:9px;padding:10px 14px;font-size:13px;margin-bottom:14px;display:none;}
.sg-brow{display:flex;gap:10px;margin-top:6px;}
.sg-btn{flex:1;text-align:center;padding:12px 18px;border-radius:10px;font-size:14px;font-weight:700;cursor:pointer;border:none;font-family:'Inter',sans-serif;}
.sg-btn.pri{background:#059669;color:#fff;box-shadow:0 4px 14px rgba(5,150,105,.35);}
.sg-btn.sec{background:#f1f5f9;color:#475569;border:1px solid #e2e8f0;}
#sg-ok{display:none;padding:32px 28px;text-align:center;}
#sg-ok .sg-ok-icon{width:66px;height:66px;background:#d1fae5;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 16px;font-size:32px;color:#059669;}
#sg-ok h3{font-size:18px;font-weight:800;color:#111;margin:0 0 8px;}
#sg-ok p{font-size:14px;color:#6b7280;margin:0 0 20px;line-height:1.6;}
.sg-sep{font-size:11px;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:#94a3b8;margin:18px 0 14px;display:flex;align-items:center;gap:8px;}
.sg-sep::before,.sg-sep::after{content:'';flex:1;height:1px;background:#e5e7eb;}

@media(max-width:640px){
    .po-hdr,.po-body{padding-left:22px;padding-right:22px;}
    .po-hdr{padding-top:24px;padding-bottom:20px;}
    .po-body{padding-top:24px;padding-bottom:24px;}
    .po-hdr h1{font-size:20px;}
    .po-step{font-size:11px;padding:13px 4px 10px;}
    .po-g input{font-size:14px;padding:11px 14px;}
    .po-btn{font-size:14px;padding:12px 16px;}
    .sg-row{grid-template-columns:1fr;}
    .po-entry-top,.po-entry-body{padding-left:22px;padding-right:22px;}
    .po-entry-top h1{font-size:23px;}
    .po-entry-grid{grid-template-columns:1fr;}
}
</style>

@php
    $authUser = auth()->user();
    $warrantiesRedirect = route('warranties', [], false);
    $authIdentity = $authUser ? ($authUser->identificacion ?: $authUser->cedula) : '';
@endphp

<div class="po-wrap">
    <div class="po-shell">

        <div class="po-entry" id="po-entry-card">
            <div class="po-entry-top">
                <div class="po-kicker">Validacion de garantia</div>
                <h1>Antes de ingresar tu preorden, confirma estas autorizaciones.</h1>
                <p>Queremos que el proceso sea claro y ordenado. Primero acepta las condiciones iniciales y luego ingresa con tu cuenta para continuar con la validacion de garantia.</p>
            </div>
            <div class="po-entry-body">
                <div class="po-entry-grid">
                    <div class="po-entry-panel">
                        <h2 class="po-entry-title">Autorizaciones requeridas</h2>
                        <p class="po-entry-copy">Acepta estas condiciones iniciales y luego accede con tu cuenta para continuar con la preorden de garantia.</p>
                        <div class="po-legal-list">
                            <label class="po-legal-item">
                                <input type="checkbox" id="po-gate-terms">
                                <span>
                                    <strong>Acepto <a href="{{ route('terminos') }}" target="_blank" class="text-blue-600 hover:underline hover:text-blue-800 transition-colors">TyC</a></strong>
                                    <span>Confirmo que he leído y acepto los <a href="{{ route('terminos') }}" target="_blank" class="text-blue-500 hover:underline font-medium hover:text-blue-700 transition-colors">términos y condiciones</a> aplicables al proceso de validación de garantía.</span>
                                </span>
                            </label>

                            <label class="po-legal-item">
                                <input type="checkbox" id="po-gate-data">
                                <span>
                                    <strong>Acepto el <a href="{{ route('privacidad') }}" target="_blank" class="text-blue-600 hover:underline hover:text-blue-800 transition-colors">tratamiento de datos</a></strong>
                                    <span>Autorizo que mis datos sean tratados conforme a la <a href="{{ route('privacidad') }}" target="_blank" class="text-blue-500 hover:underline font-medium hover:text-blue-700 transition-colors">política de privacidad y protección de datos</a> para gestionar la preorden y la garantía.</span>
                                </span>
                            </label>
                        </div>
                        <div class="po-gate-error" id="po-gate-error">Debes marcar ambas casillas para continuar.</div>

                        @if ($authUser)
                            <div class="po-entry-actions">
                                <div class="po-user-box">
                                    Has iniciado sesion como <strong>{{ $authUser->full_name }}</strong><br>
                                    Identificacion: <strong>{{ $authIdentity }}</strong>
                                </div>
                                <button type="button" class="po-entry-btn" id="po-gate-continue" onclick="poStartFlow()" disabled>
                                    Continuar con mi preorden
                                </button>
                            </div>
                        @else
                            <div class="po-entry-actions">
                                <p class="po-entry-copy" style="margin:0;">Para ingresar tu preorden primero debes acceder con tu cuenta o registrarte en el portal.</p>
                                <a href="{{ route('login', ['redirect_to' => $warrantiesRedirect]) }}" class="po-entry-link pri po-gate-link is-disabled" onclick="return poGateFollow(event)">
                                    Iniciar sesion
                                </a>
                                <a href="{{ route('register', ['redirect_to' => $warrantiesRedirect]) }}" class="po-entry-link sec po-gate-link is-disabled" onclick="return poGateFollow(event)">
                                    Crear cuenta
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        @if ($authUser)
        <div class="po-card" id="po-flow-card" style="display:none;">

        <div class="po-hdr">
            <div class="po-logo">Novitecnología Cía. Ltda.</div>
            <h1>¡Valida tu Garantía!</h1>
            <p>Es muy fácil — solo sigue los pasos y listo</p>
        </div>

        <div class="po-steps" id="po-sbar">
            <div class="po-step active" id="pos1"><div class="po-snum">1</div>Tu Factura</div>
            <div class="po-step" id="pos2"><div class="po-snum">2</div>Tu Equipo</div>
            <div class="po-step" id="pos3"><div class="po-snum">3</div>Tus Datos</div>
            <div class="po-step" id="pos4"><div class="po-snum">4</div>¡Listo!</div>
        </div>

        <div class="po-body">

            {{-- PASO 1: FACTURA --}}
            <div class="po-pane active" id="pp1">
                <div class="po-g">
                    <label>Número de tu Factura <span class="req">*</span></label>
                    <input type="text" id="po-fac" placeholder="001-001-000000001" maxlength="17" oninput="poFmt(this)">
                    <div class="po-hint"> Encuéntralo en tu factura de compra. Se ve así: <strong>001-001-000000001</strong></div>
                    <div class="po-em" id="pe1"> Ese número de factura no es válido. Revísalo e inténtalo de nuevo.</div>
                    <div class="po-suc-badge" id="po-suc-badge">
                        <span class="suc-nom" id="po-suc-nom"></span>
                        <span class="suc-nov" id="po-suc-nov"></span>
                        <br><span style="font-size:12px;color:#475569;"> Llevarás tu equipo a nuestra tienda en <strong id="po-suc-ciudad"></strong></span>
                    </div>
                </div>
                <div class="po-g" id="po-fecha-wrap" style="display:none;">
                    <label>¿Cuándo compraste el equipo? <span class="req">*</span></label>
                    <input type="date" id="po-fecha-fac">
                    <div class="po-hint"> Mira la fecha que aparece en tu factura de compra.</div>
                    <div class="po-em" id="pe1f"> La fecha no es válida. Debe ser del último año.</div>
                </div>
                <input type="hidden" id="po-suc-cliente-id">
                <input type="hidden" id="po-novitec-suc-id">
                <input type="hidden" id="po-secuencial">
                <div class="po-brow">
                    <button class="po-btn pri" onclick="poGo(2)">Siguiente →</button>
                </div>
            </div>

            {{-- PASO 2: EQUIPO --}}
            <div class="po-pane" id="pp2">
                <div class="po-g">
                    <label>Código de tu Equipo <span class="req">*</span></label>
                    <input type="text" id="po-cod" placeholder="Ej: 1ENV4569" maxlength="50" autocomplete="off"
                           oninput="this.value=this.value.toUpperCase();poBuscar(this.value)">
                    <div class="po-hint"> Está en tu factura o en una etiqueta pegada en el equipo.</div>
                    <div class="po-badge" id="po-bdg"></div>
                    <div class="po-em" id="pe2"> Ese código no lo encontramos. Revísalo bien.</div>
                </div>
                <div class="po-g">
                    <label>¿Qué le pasa a tu equipo? <span class="req">*</span></label>
                    <textarea id="po-det" placeholder="Ej: La pantalla no enciende, se cayó al suelo, no carga la batería..." maxlength="1000"></textarea>
                    <div class="po-hint"> Cuéntanos con tus propias palabras qué falla o qué pasó.</div>
                    <div class="po-em" id="pe2d"> Por favor cuéntanos qué le pasa a tu equipo.</div>
                </div>
                <div class="po-g">
                    <label>📸 Fotos de tu equipo <span class="req">*</span></label>
                    <div class="po-fotos-grid">
                        @foreach([['1','Lado derecho'],['2','Lado izquierdo'],['3','De frente'],['4','Parte trasera']] as [$n,$label])
                        <div class="po-foto-slot" id="pfs{{ $n }}" onclick="poAbrirModal({{ $n }})">
                            <input type="file" accept="image/*" onchange="poFotoLoad(this,{{ $n }})">
                            <div class="pf-body">
                                <span style="font-size:28px;">📷</span>
                                <span class="pf-tag">{{ $label }}</span>
                                <span class="pf-lbl">Toca para subir</span>
                            </div>
                            <span class="pf-check">✓</span>
                            <button class="pf-rm" type="button" onclick="poFotoRm(event,{{ $n }})">×</button>
                        </div>
                        @endforeach
                    </div>
                    <div style="font-size:12px;color:#ef4444;margin-top:4px;display:none;" id="pe2f">⚠️ Necesitas subir las 4 fotos de tu equipo para continuar.</div>
                    <div class="po-hint">📷 Sube 4 fotos de tu equipo · JPG, PNG o WEBP · Máx. 5 MB por foto</div>
                </div>

                {{-- Modal selección foto --}}
                <div class="pf-modal-overlay" id="pf-modal" onclick="pfCerrarModal(event)">
                    <div class="pf-modal">
                        <h3 id="pf-modal-titulo">Agregar fotografía</h3>
                        <p>¿Cómo deseas agregar la foto?</p>
                        <div class="pf-modal-opts">
                            <div class="pf-mopt" onclick="pfElegir('archivo')">
                                <span class="pf-mopt-icon">🖼️</span>
                                <span class="pf-mopt-lbl">Galería</span>
                                <span class="pf-mopt-sub">Elige una foto guardada</span>
                            </div>
                            <div class="pf-mopt" onclick="pfElegir('camara')">
                                <span class="pf-mopt-icon">📷</span>
                                <span class="pf-mopt-lbl">Cámara</span>
                                <span class="pf-mopt-sub">Toma una foto ahora</span>
                            </div>
                        </div>
                        <button class="pf-modal-cancel" onclick="pfCerrarModal()">Cancelar</button>
                    </div>
                </div>
                <input type="file" id="pf-input-file" accept="image/*">
                <input type="file" id="pf-input-cam" accept="image/*" capture="environment">

                <div class="po-brow">
                    <button class="po-btn sec" onclick="poGo(1)">← Atrás</button>
                    <button class="po-btn pri" onclick="poGo(3)">Siguiente →</button>
                </div>
            </div>

            {{-- PASO 3: DATOS CLIENTE --}}
            <div class="po-pane" id="pp3">
                <div class="po-confirm-box" style="margin-bottom:20px;background:#eff6ff;border-color:#bfdbfe;">
                    <strong style="display:block;color:#1a3d7c;margin-bottom:4px;">Datos de tu cuenta</strong>
                    <span style="font-size:13px;color:#475569;">Precargamos tu informacion desde el portal. Puedes ajustar nombre, telefono o correo si hace falta. La identificacion debe coincidir con tu cuenta.</span>
                </div>
                <div class="po-g">
                    <label>Tu C.I. o RUC <span class="req">*</span></label>
                    <input type="text" id="po-ci" placeholder="1720000000" maxlength="13"
                           value="{{ $authIdentity }}"
                           readonly
                           oninput="this.value=this.value.replace(/\D/g,'').slice(0,13)">
                    <div class="po-hint">Tu número de cédula (10 dígitos) o RUC (13 dígitos).</div>
                    <div class="po-em" id="pe3ci">Ingresa tu C.I. (10 dígitos) o RUC (13 dígitos).</div>
                </div>
                <div class="po-g">
                    <label>Tu Nombre <span class="req">*</span></label>
                    <input type="text" id="po-nom" placeholder="JUAN" maxlength="80"
                           value="{{ $authUser?->nombres }}"
                           oninput="this.value=this.value.toUpperCase().replace(/[^A-ZÁÉÍÓÚÜÑ\s]/g,'')">
                    <div class="po-em" id="pe3n"> Ingresa solo tu nombre.</div>
                </div>
                <div class="po-g">
                    <label>Tu Apellido <span class="req">*</span></label>
                    <input type="text" id="po-ape" placeholder="PEREZ" maxlength="80"
                           value="{{ $authUser?->apellidos }}"
                           oninput="this.value=this.value.toUpperCase().replace(/[^A-ZÁÉÍÓÚÜÑ\s]/g,'')">
                    <div class="po-em" id="pe3a">Ingresa solo tu apellido.</div>
                </div>
                <div class="po-g">
                    <label>Provincia de procedencia <span class="req">*</span></label>
                    <select id="po-prov">
                        <option value="">Seleccione provincia</option>
                        <option value="AZUAY">AZUAY</option>
                        <option value="BOLIVAR">BOLIVAR</option>
                        <option value="CANAR">CANAR</option>
                        <option value="CARCHI">CARCHI</option>
                        <option value="COTOPAXI">COTOPAXI</option>
                        <option value="CHIMBORAZO">CHIMBORAZO</option>
                        <option value="EL ORO">EL ORO</option>
                        <option value="ESMERALDAS">ESMERALDAS</option>
                        <option value="GUAYAS">GUAYAS</option>
                        <option value="IMBABURA">IMBABURA</option>
                        <option value="LOJA">LOJA</option>
                        <option value="LOS RIOS">LOS RIOS</option>
                        <option value="MANABI">MANABI</option>
                        <option value="MORONA SANTIAGO">MORONA SANTIAGO</option>
                        <option value="NAPO">NAPO</option>
                        <option value="PASTAZA">PASTAZA</option>
                        <option value="PICHINCHA">PICHINCHA</option>
                        <option value="TUNGURAHUA">TUNGURAHUA</option>
                        <option value="ZAMORA CHINCHIPE">ZAMORA CHINCHIPE</option>
                        <option value="GALAPAGOS">GALAPAGOS</option>
                        <option value="SUCUMBIOS">SUCUMBIOS</option>
                        <option value="ORELLANA">ORELLANA</option>
                        <option value="SANTO DOMINGO">SANTO DOMINGO</option>
                        <option value="SANTA ELENA">SANTA ELENA</option>
                    </select>
                    <div class="po-hint">Se usara para identificar desde donde ingresa la preorden.</div>
                    <div class="po-em" id="pe3p">Selecciona la provincia de procedencia.</div>
                </div>
                <div class="po-g">
                    <label>Tu Número de Celular <span class="req">*</span></label>
                    <input type="tel" id="po-tel" placeholder="0999999999" maxlength="10"
                           value="{{ $authUser?->phone }}"
                           oninput="this.value=this.value.replace(/\D/g,'').slice(0,10)">
                    <div class="po-hint">📱 Tu número de celular ecuatoriano (10 dígitos, empieza con 09).</div>
                    <div class="po-em" id="pe3t">Revisa tu número. Debe empezar con 09 y tener 10 dígitos.</div>
                </div>
                <div class="po-g">
                    <label>Tu Correo Electrónico <span class="req">*</span></label>
                    <input type="email" id="po-cor" placeholder="tucorreo@ejemplo.com" maxlength="150" value="{{ $authUser?->email }}">
                    <div class="po-hint">Te enviaremos una confirmación aquí.</div>
                    <div class="po-em" id="pe3c">Ese correo no parece válido.</div>
                </div>
                <div class="po-gerr" id="po-gerr3"></div>
                <div class="po-brow">
                    <button class="po-btn sec" onclick="poGo(2)">← Atrás</button>
                    <button class="po-btn pri" onclick="poGo(4)">Siguiente →</button>
                </div>
            </div>

            {{-- PASO 4: CONFIRMACIÓN --}}
            <div class="po-pane" id="pp4">
                <p style="font-size:14px;font-weight:700;color:#374151;margin-bottom:12px;">Revisa que todo esté correcto antes de enviar</p>
                <div class="po-confirm-box" id="po-resumen"></div>
                <div class="po-terms-box" style="background:#eff6ff;border-color:#bfdbfe;">
                    <div class="po-terms-title" style="color:#1a3d7c;">Resumen antes de enviar</div>
                    <div class="po-terms-body" style="max-height:none;color:#475569;margin-bottom:0;">
                        <p>Al enviar la preorden confirmas que la informacion registrada es correcta y que el equipo sera llevado a la sucursal Novitec asignada para su revision tecnica.</p>
                        <p>Las aceptaciones de terminos y tratamiento de datos ya quedaron marcadas en el paso inicial del flujo.</p>
                    </div>
                </div>
                <div class="po-gerr" id="po-gerr4"></div>
                <div class="po-brow">
                    <button class="po-btn sec" onclick="poGo(3)">← Atrás</button>
                    <button class="po-btn pri" id="po-send" onclick="poSend()">¡Enviar mi solicitud!</button>
                </div>
            </div>

            {{-- PASO 5: ÉXITO --}}
            <div class="po-pane" id="pp5">
                <div class="po-ok">
                    <div class="po-ok-icon">✓</div>
                    <h2>¡Todo listo! Tu garantía está registrada</h2>
                    <p>Tu número de solicitud es:</p>
                    <div class="po-nro" id="po-rnro">—</div>
                    <div class="po-eq" id="po-req"></div>
                    <p>Te enviamos un correo de confirmación a <strong id="po-rcor"></strong>.</p>
                    <p>Un técnico de Novitecnología te llamará pronto. </p>
                    <button class="po-btn pri" onclick="poImprimir()" style="margin-top:16px;max-width:260px;display:inline-block;">
                         Imprimir comprobante
                    </button>
                    <br>
                    <button onclick="sgAbrir()" style="margin-top:12px;max-width:260px;display:inline-block;background:linear-gradient(135deg,#059669,#10b981);color:#fff;border:none;border-radius:10px;padding:13px 20px;font-size:15px;font-weight:700;cursor:pointer;width:100%;">
                        Dejar una sugerencia
                    </button>
                </div>
            </div>

        </div>
        @endif
    </div>
</div>

{{-- MODAL SUGERENCIAS --}}
<div id="sg-overlay" onclick="sgCerrar(event)">
    <div id="sg-card">
        <div id="sg-hdr">
            <h3>Envíanos tu Sugerencia</h3>
            <p>Tu opinión nos ayuda a mejorar. ¡Gracias por compartirla!</p>
            <button id="sg-close" onclick="sgCerrar()">×</button>
        </div>
        <div id="sg-body">
            <div class="sg-sep">Tus datos</div>
            <div class="sg-row">
                <div class="sg-g">
                    <label>Nombres <span class="req">*</span></label>
                    <input type="text" id="sg-nom" placeholder="Juan" maxlength="80" oninput="this.value=this.value.toUpperCase()">
                    <div class="sg-em" id="sge-nom">Ingresa tu nombre.</div>
                </div>
                <div class="sg-g">
                    <label>Apellidos <span class="req">*</span></label>
                    <input type="text" id="sg-ape" placeholder="Pérez" maxlength="80" oninput="this.value=this.value.toUpperCase()">
                    <div class="sg-em" id="sge-ape">Ingresa tu apellido.</div>
                </div>
            </div>
            <div class="sg-row">
                <div class="sg-g">
                    <label>C.I. / RUC</label>
                    <input type="text" id="sg-ci" placeholder="0912345678" maxlength="13" oninput="this.value=this.value.replace(/\D/g,'').slice(0,13)">
                </div>
                <div class="sg-g">
                    <label>Teléfono</label>
                    <input type="tel" id="sg-tel" placeholder="0999999999" maxlength="10" oninput="this.value=this.value.replace(/\D/g,'').slice(0,10)">
                </div>
            </div>
            <div class="sg-g">
                <label>Correo Electrónico</label>
                <input type="email" id="sg-cor" placeholder="tucorreo@ejemplo.com" maxlength="150">
            </div>
            <div class="sg-sep">Tu sugerencia</div>
            <div class="sg-g">
                <label>Categoría</label>
                <select id="sg-cat">
                    <option value="Servicio al cliente">Servicio al cliente</option>
                    <option value="Tiempos de atención">Tiempos de atención</option>
                    <option value="Proceso de garantía">Proceso de garantía</option>
                    <option value="Atención en tienda">Atención en tienda</option>
                    <option value="App / Sistema">App / Sistema</option>
                    <option value="Producto">Producto</option>
                    <option value="General" selected>General</option>
                </select>
            </div>
            <div class="sg-g">
                <label>Tu sugerencia <span class="req">*</span></label>
                <textarea id="sg-txt" placeholder="Cuéntanos qué podríamos mejorar..." maxlength="2000"></textarea>
                <div class="sg-em" id="sge-txt">⚠️ Escribe tu sugerencia antes de enviar.</div>
            </div>
            <div class="sg-gerr" id="sg-gerr"></div>
            <div class="sg-brow">
                <button class="sg-btn sec" onclick="sgCerrar()">Cancelar</button>
                <button class="sg-btn pri" id="sg-send" onclick="sgEnviar()">Enviar sugerencia</button>
            </div>
        </div>
        <div id="sg-ok">
            <div class="sg-ok-icon">✓</div>
            <h3>¡Gracias por tu sugerencia! </h3>
            <p>La recibimos correctamente. Tu opinión es muy valiosa para nosotros.</p>
            <button class="sg-btn pri" onclick="sgCerrar()" style="max-width:180px;display:inline-block;">Cerrar</button>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
var _CSRF = '{{ csrf_token() }}';
var _PO_AUTH = {{ $authUser ? 'true' : 'false' }};
var _pv=false,_pt=null,_fv=false,_ft=null,_cp=1;

// ── MODAL AVISO ────────────────────────────────────────────────────
(function(){
    var seg=5, btn=document.getElementById('po-aviso-ok'),
        cnt=document.getElementById('po-aviso-seg'),
        overlay=document.getElementById('po-aviso-overlay');
    if(!btn||!cnt||!overlay)return;
    var t=setInterval(function(){
        seg--; cnt.textContent=seg;
        if(seg<=0){
            clearInterval(t); btn.disabled=false; btn.classList.add('listo');
            document.getElementById('po-aviso-count').textContent='¡Ya puedes continuar!';
        }
    },1000);
    btn.addEventListener('click',function(){
        if(!btn.classList.contains('listo'))return;
        overlay.style.display='none';
    });
})();

// ── NAVEGACIÓN ─────────────────────────────────────────────────────
function poGateAccepted(){
    var terms=document.getElementById('po-gate-terms');
    var data=document.getElementById('po-gate-data');
    return !!(terms && data && terms.checked && data.checked);
}

function poGateSetError(show){
    var err=document.getElementById('po-gate-error');
    if(err)err.style.display=show ? 'block' : 'none';
}

function poGateRefresh(){
    var ok=poGateAccepted();
    poGateSetError(false);

    var btn=document.getElementById('po-gate-continue');
    if(btn)btn.disabled=!ok;

    document.querySelectorAll('.po-gate-link').forEach(function(link){
        link.classList.toggle('is-disabled', !ok);
    });
}

window.poGateFollow=function(ev){
    if(poGateAccepted())return true;
    if(ev)ev.preventDefault();
    poGateSetError(true);
    return false;
};

window.poStartFlow=function(){
    if(!poGateAccepted()){
        poGateSetError(true);
        return;
    }

    var entry=document.getElementById('po-entry-card');
    var flow=document.getElementById('po-flow-card');
    if(entry)entry.style.display='none';
    if(flow){
        flow.style.display='block';
        flow.scrollIntoView({behavior:'smooth',block:'start'});
    }
};

(function(){
    ['po-gate-terms','po-gate-data'].forEach(function(id){
        var el=document.getElementById(id);
        if(el)el.addEventListener('change', poGateRefresh);
    });
    poGateRefresh();
})();

window.poGo=function(n){
    if(n>_cp&&!poVal(_cp))return;
    if(n===4)poMostrarResumen();
    for(var i=1;i<=4;i++){
        var s=document.getElementById('pos'+i);
        if(!s)continue;
        s.classList.remove('active','done');
        if(i<n)s.classList.add('done');
        else if(i===n)s.classList.add('active');
    }
    for(var j=1;j<=5;j++){
        var p=document.getElementById('pp'+j);
        if(p)p.classList.toggle('active',j===n);
    }
    _cp=n;
};

function poVal(n){
    if(n===1){
        if(!_fv){poSE('pe1',document.getElementById('po-fac'));return false;}
        poHE('pe1',document.getElementById('po-fac'));
        var fInp=document.getElementById('po-fecha-fac');
        if(!fInp.value){poSE('pe1f',fInp);return false;}
        var fDate=new Date(fInp.value+'T00:00:00');
        var hoy=new Date();hoy.setHours(23,59,59,999);
        var minD=new Date(hoy);minD.setFullYear(minD.getFullYear()-1);
        if(fDate>hoy||fDate<minD){poSE('pe1f',fInp);return false;}
        poHE('pe1f',fInp);
        return true;
    }
    if(n===2){
        var ok=true;
        var c=document.getElementById('po-cod');
        if(!_pv){poSE('pe2',c);ok=false;}else poHE('pe2',c);
        var det=document.getElementById('po-det');
        if(!det.value.trim()){poSE('pe2d',det);det.classList.add('poe');ok=false;}
        else{poHE('pe2d',det);det.classList.remove('poe');}
        var faltaFoto=false;
        for(var fi=1;fi<=4;fi++){
            var slot=document.getElementById('pfs'+fi);
            if(!slot._archivoFoto){slot.classList.add('poe-foto');faltaFoto=true;}
            else slot.classList.remove('poe-foto');
        }
        if(faltaFoto){document.getElementById('pe2f').style.display='block';ok=false;}
        else document.getElementById('pe2f').style.display='none';
        return ok;
    }
    if(n===3){
        var ci=document.getElementById('po-ci');
        var ciVal=ci?ci.value.replace(/\D/g,''):'';
        if(!ciVal||(ciVal.length!==10&&ciVal.length!==13)){poSE('pe3ci',ci);return false;}
        poHE('pe3ci',ci);
        return poValC();
    }
    if(n===4){
        return true;
    }
    return true;
}

function poSE(id,el){var e=document.getElementById(id);if(e)e.style.display='block';if(el)el.classList.add('poe');}
function poHE(id,el){var e=document.getElementById(id);if(e)e.style.display='none';if(el)el.classList.remove('poe');}

// ── FORMATO FACTURA ────────────────────────────────────────────────
window.poFmt=function(inp){
    var n=inp.value.replace(/\D/g,'').slice(0,15);
    if(n.length<=3)inp.value=n;
    else if(n.length<=6)inp.value=n.slice(0,3)+'-'+n.slice(3);
    else inp.value=n.slice(0,3)+'-'+n.slice(3,6)+'-'+n.slice(6);
    poHE('pe1',inp);
    _fv=false;
    document.getElementById('po-suc-badge').style.display='none';
    document.getElementById('po-fecha-wrap').style.display='none';
    clearTimeout(_ft);
    var m=inp.value.match(/^(\d{3})-(\d{3})-(\d{9,15})$/);
    if(!m)return;
    var b=parseInt(m[1],10);
    if(b<1||b>177)return;
    _ft=setTimeout(function(){poValidarFactura(inp.value);},400);
};

function poValidarFactura(nro){
    fetch('/warranties/validar-factura?nro='+encodeURIComponent(nro))
    .then(function(r){return r.json();})
    .then(function(d){
        var inp=document.getElementById('po-fac');
        if(!d.ok){
            _fv=false;
            document.getElementById('pe1').textContent=d.error||'Sucursal no encontrada.';
            poSE('pe1',inp);
            document.getElementById('po-suc-badge').style.display='none';
            document.getElementById('po-fecha-wrap').style.display='none';
            return;
        }
        _fv=true;
        poHE('pe1',inp);
        document.getElementById('po-suc-cliente-id').value=d.suc_cliente_id;
        document.getElementById('po-novitec-suc-id').value=d.novitec_suc_id;
        document.getElementById('po-secuencial').value=d.secuencial;
        document.getElementById('po-suc-nom').textContent=d.suc_cliente_cod+' — '+d.suc_cliente_nom;
        document.getElementById('po-suc-nov').textContent=d.novitec_suc;
        document.getElementById('po-suc-ciudad').textContent=d.novitec_ciudad;
        document.getElementById('po-suc-badge').style.display='block';
        var hoy=new Date();
        var hoyStr=hoy.toISOString().split('T')[0];
        var anioAtras=new Date(hoy);anioAtras.setFullYear(anioAtras.getFullYear()-1);
        var minStr=anioAtras.toISOString().split('T')[0];
        var fInp=document.getElementById('po-fecha-fac');
        fInp.max=hoyStr;fInp.min=minStr;fInp.value='';
        document.getElementById('po-fecha-wrap').style.display='block';
    })
    .catch(function(){_fv=false;});
}

// ── FOTOS ──────────────────────────────────────────────────────────
var _pfSlot=0;
window.poAbrirModal=function(n){
    if(document.getElementById('pfs'+n).classList.contains('has-img'))return;
    _pfSlot=n;
    var tags=['Lado derecho','Lado izquierdo','De frente','Parte trasera'];
    document.getElementById('pf-modal-titulo').textContent='Foto '+n+': '+tags[n-1];
    document.getElementById('pf-modal').classList.add('open');
};
window.pfCerrarModal=function(ev){
    if(ev&&ev.target!==document.getElementById('pf-modal')&&ev.type==='click')return;
    document.getElementById('pf-modal').classList.remove('open');
};
window.pfElegir=function(tipo){
    document.getElementById('pf-modal').classList.remove('open');
    var inp=document.getElementById(tipo==='camara'?'pf-input-cam':'pf-input-file');
    inp.value='';
    inp.onchange=function(){if(inp.files&&inp.files[0])poFotoLoad(inp,_pfSlot);};
    inp.click();
};
window.poFotoLoad=function(inp,n){
    if(!inp.files||!inp.files[0])return;
    var slot=document.getElementById('pfs'+n);
    var prev=slot.querySelector('img.po-prev');if(prev)prev.remove();
    var img=document.createElement('img');
    img.className='po-prev';
    img.src=URL.createObjectURL(inp.files[0]);
    slot.insertBefore(img,slot.querySelector('.pf-check'));
    slot.classList.add('has-img');
    slot.classList.remove('poe-foto');
    slot._archivoFoto=inp.files[0];
    var todas=true;
    for(var fi=1;fi<=4;fi++){if(!document.getElementById('pfs'+fi)._archivoFoto){todas=false;break;}}
    if(todas)document.getElementById('pe2f').style.display='none';
};
window.poFotoRm=function(ev,n){
    ev.stopPropagation();ev.preventDefault();
    var slot=document.getElementById('pfs'+n);
    var prev=slot.querySelector('img.po-prev');if(prev)prev.remove();
    slot.classList.remove('has-img');
    slot._archivoFoto=null;
};

// ── BUSCAR PRODUCTO ────────────────────────────────────────────────
window.poBuscar=function(codigo){
    clearTimeout(_pt);_pv=false;
    var bdg=document.getElementById('po-bdg'),inp=document.getElementById('po-cod');
    bdg.style.display='none';bdg.className='po-badge';poHE('pe2',inp);
    if(!codigo||codigo.length<3)return;
    _pt=setTimeout(function(){
        fetch('/warranties/buscar-producto?codigo='+encodeURIComponent(codigo))
        .then(function(r){return r.json();})
        .then(function(d){
            if(d.ok&&d.producto){
                _pv=true;
                bdg.className='po-badge ok';
                bdg.textContent='✓ '+d.producto.descripcion+' · '+d.producto.marca+(d.producto.tipo_nombre?' · '+d.producto.tipo_nombre:'');
                bdg.style.display='block';
                inp.classList.remove('poe');
            } else {
                _pv=false;
                bdg.className='po-badge nok';
                bdg.textContent='Código no encontrado en nuestro catálogo.';
                bdg.style.display='block';
            }
        }).catch(function(){_pv=false;});
    },500);
};

// ── VALIDAR CLIENTE ────────────────────────────────────────────────
function poValC(){
    var ok=true;
    var n=document.getElementById('po-nom'),a=document.getElementById('po-ape'),
        p=document.getElementById('po-prov'),t=document.getElementById('po-tel'),c=document.getElementById('po-cor');
    if(!n.value.trim()){poSE('pe3n',n);ok=false;}else poHE('pe3n',n);
    if(!a.value.trim()){poSE('pe3a',a);ok=false;}else poHE('pe3a',a);
    if(!p.value.trim()){poSE('pe3p',p);ok=false;}else poHE('pe3p',p);
    if(!/^09\d{8}$/.test(t.value.trim())){poSE('pe3t',t);ok=false;}else poHE('pe3t',t);
    var em=c.value.trim();
    if(!em||!em.includes('@')||em.indexOf('.')<0){poSE('pe3c',c);ok=false;}else poHE('pe3c',c);
    return ok;
}

// ── RESUMEN ────────────────────────────────────────────────────────
window.poMostrarResumen=function(){
    var rows=[
        ['Factura', document.getElementById('po-fac').value.trim()],
        ['Fecha Factura', document.getElementById('po-fecha-fac').value],
        ['Sucursal', document.getElementById('po-suc-nom').textContent],
        ['Novitec', document.getElementById('po-suc-nov').textContent+' — '+document.getElementById('po-suc-ciudad').textContent],
        ['Código equipo', document.getElementById('po-cod').value.trim()],
        ['Equipo', document.getElementById('po-bdg').textContent.replace('✓ ','')],
        ['Detalle', document.getElementById('po-det').value.trim()],
        ['C.I. / RUC', document.getElementById('po-ci').value.trim()],
        ['Nombre', document.getElementById('po-nom').value.trim()+' '+document.getElementById('po-ape').value.trim()],
        ['Procedencia', document.getElementById('po-prov').value.trim()],
        ['Teléfono', document.getElementById('po-tel').value.trim()],
        ['Correo', document.getElementById('po-cor').value.trim()],
    ];
    var html='';
    rows.forEach(function(r){
        html+='<div class="cf-row"><span class="cf-lbl">'+r[0]+'</span><span class="cf-val">'+r[1]+'</span></div>';
    });
    document.getElementById('po-resumen').innerHTML=html;
};

// ── ENVIAR ─────────────────────────────────────────────────────────
window.poSend=function(){
    var ge=document.getElementById('po-gerr4');ge.style.display='none';
    var fd=new FormData();
    fd.append('_token', _CSRF);
    fd.append('nro_factura', document.getElementById('po-fac').value.trim());
    fd.append('suc_cliente_id', document.getElementById('po-suc-cliente-id').value);
    fd.append('novitec_suc_id', document.getElementById('po-novitec-suc-id').value);
    fd.append('secuencial', document.getElementById('po-secuencial').value);
    fd.append('identificacion', document.getElementById('po-ci').value.trim());
    fd.append('nombres', document.getElementById('po-nom').value.trim());
    fd.append('apellidos', document.getElementById('po-ape').value.trim());
    fd.append('ciudad_procedencia', document.getElementById('po-prov').value.trim());
    fd.append('telefono', document.getElementById('po-tel').value.trim());
    fd.append('correo', document.getElementById('po-cor').value.trim());
    fd.append('codigo_producto', document.getElementById('po-cod').value.trim());
    fd.append('fecha_facturacion', document.getElementById('po-fecha-fac').value);
    fd.append('detalle_equipo', document.getElementById('po-det').value.trim());
    for(var fi=1;fi<=4;fi++){
        var archivo=document.getElementById('pfs'+fi)._archivoFoto;
        if(archivo)fd.append('foto_'+fi,archivo);
    }
    var btn=document.getElementById('po-send');
    btn.disabled=true;btn.textContent='Enviando...';
    fetch('/warranties/guardar',{method:'POST',body:fd})
    .then(function(r){return r.json();})
    .then(function(d){
        if(!d.ok){
            ge.textContent=d.error||'Hubo un problema. Inténtalo de nuevo.';
            ge.style.display='block';
            btn.disabled=false;btn.textContent='🚀 ¡Enviar mi solicitud!';
            return;
        }
        document.getElementById('po-rnro').textContent=d.nro_preorden;
        document.getElementById('po-req').innerHTML='<strong>Equipo:</strong> '+d.equipo;
        document.getElementById('po-rcor').textContent=document.getElementById('po-cor').value.trim();
        document.getElementById('po-sbar').style.display='none';
        for(var j=1;j<=5;j++){
            var p=document.getElementById('pp'+j);
            if(p)p.classList.toggle('active',j===5);
        }
        // Pre-cargar datos en sugerencias
        document.getElementById('sg-nom').value=document.getElementById('po-nom').value.trim();
        document.getElementById('sg-ape').value=document.getElementById('po-ape').value.trim();
        document.getElementById('sg-ci').value=document.getElementById('po-ci').value.trim();
        document.getElementById('sg-tel').value=document.getElementById('po-tel').value.trim();
        document.getElementById('sg-cor').value=document.getElementById('po-cor').value.trim();
    })
    .catch(function(){
        ge.textContent='⚠️ Sin conexión. Revisa tu internet e inténtalo de nuevo.';
        ge.style.display='block';
        btn.disabled=false;btn.textContent='🚀 ¡Enviar mi solicitud!';
    });
};

// ── IMPRIMIR ───────────────────────────────────────────────────────
window.poImprimir=function(){
    var nro=document.getElementById('po-rnro').textContent;
    var ci=document.getElementById('po-ci').value.trim();
    var nombre=document.getElementById('po-nom').value.trim()+' '+document.getElementById('po-ape').value.trim();
    var procedencia=document.getElementById('po-prov').value.trim();
    var tel=document.getElementById('po-tel').value.trim();
    var correo=document.getElementById('po-cor').value.trim();
    var fac=document.getElementById('po-fac').value.trim();
    var fechaFac=document.getElementById('po-fecha-fac').value;
    var sucNom=document.getElementById('po-suc-nom').textContent;
    var sucCiudad=document.getElementById('po-suc-ciudad').textContent;
    var codigo=document.getElementById('po-cod').value.trim();
    var equipo=document.getElementById('po-bdg').textContent.replace('✓ ','');
    var detalle=document.getElementById('po-det').value.trim();
    var ahora=new Date();
    var pad=function(n){return n<10?'0'+n:n;};
    var fechaImp=pad(ahora.getDate())+'/'+(pad(ahora.getMonth()+1))+'/'+ahora.getFullYear()+' '+pad(ahora.getHours())+':'+pad(ahora.getMinutes());

    var css='*{margin:0;padding:0;box-sizing:border-box;}body{font-family:Arial,sans-serif;font-size:7.5pt;color:#000;background:#fff;}@media print{@page{size:A4 portrait;margin:10mm}.no-print{display:none!important}body{print-color-adjust:exact;-webkit-print-color-adjust:exact}}.wrap{width:100%;max-width:190mm;margin:auto;padding:4mm;}.header{display:flex;justify-content:space-between;align-items:flex-start;border-bottom:1.5px solid #000;padding-bottom:3px;margin-bottom:4px;}.header-info{font-size:7pt;line-height:1.4;}.header-info .empresa{font-size:9pt;font-weight:bold;}.orden-header{display:flex;justify-content:space-between;align-items:center;background:#1a56db;color:#fff;padding:3px 8px;border-radius:3px;margin-bottom:4px;}.orden-header .nro{font-size:10pt;font-weight:bold;}.orden-header .meta{font-size:6.5pt;text-align:right;}.sec-titulo{background:#dbeafe;font-weight:bold;font-size:6.5pt;text-transform:uppercase;padding:2px 6px;border-left:3px solid #1a56db;margin-bottom:1px;}table.datos{width:100%;border-collapse:collapse;margin-bottom:3px;}table.datos td{border:1px solid #d1d5db;padding:2px 5px;font-size:7pt;vertical-align:top;}table.datos td .lbl{font-size:5.5pt;color:#6b7280;font-weight:bold;text-transform:uppercase;display:block;margin-bottom:0;}.firmas{display:flex;justify-content:space-between;margin:4px 0;}.firma-box{width:44%;text-align:center;}.firma-linea{border-top:1px solid #000;padding-top:3px;font-size:7pt;margin-top:20px;}.condiciones-titulo{text-align:center;font-weight:bold;font-size:7.5pt;text-decoration:underline;margin-bottom:2px;}.condiciones{font-size:5.5pt;text-align:justify;line-height:1.3;color:#111;}.condiciones p{margin-bottom:1px;}.btn-print{position:fixed;top:10px;right:10px;background:#1a56db;color:white;border:none;padding:10px 20px;border-radius:6px;font-size:13px;cursor:pointer;font-weight:bold;z-index:999;}';

    var html='<!DOCTYPE html><html lang="es"><head><meta charset="UTF-8"><title>Pre-Orden '+nro+'</title><style>'+css+'</style></head><body>'+
        '<button class="btn-print no-print" onclick="window.print()">🖨️ Imprimir / Guardar PDF</button>'+
        '<div class="wrap">'+
        '<div class="header"><div class="header-info"><div class="empresa">Novitecnología Cía. Ltda.</div><div><b>GYE:</b> 04-6031337 / 0960500158 &nbsp;&nbsp; <b>UIO:</b> 02-6001635 / 0960500156</div><div>https://www.novitec.com.ec</div></div></div>'+
        '<div class="orden-header"><div class="nro">Pre-Orden: '+nro+'</div><div class="meta">Fecha: '+fechaImp+'<br>Estado: Pendiente de ingreso</div></div>'+
        '<div class="sec-titulo">Datos del Cliente</div>'+
        '<table class="datos"><tr><td width="25%"><span class="lbl">Cliente</span>'+nombre+'</td><td width="25%"><span class="lbl">C.I / RUC</span>'+(ci||'-')+'</td><td width="25%"><span class="lbl">Teléfono</span>'+tel+'</td><td width="25%"><span class="lbl">Correo</span>'+correo+'</td></tr>'+
        '<tr><td><span class="lbl">Procedencia</span>'+procedencia+'</td><td><span class="lbl">Sucursal del Cliente</span>'+sucNom+'</td><td><span class="lbl">Motivo de Ingreso</span>Validación de Garantía</td><td><span class="lbl">Nro. Factura</span>'+fac+'</td></tr></table>'+
        '<div class="sec-titulo">Datos del Equipo</div>'+
        '<table class="datos"><tr><td width="25%"><span class="lbl">Código</span>'+codigo+'</td><td width="25%"><span class="lbl">Equipo</span>'+equipo+'</td><td width="25%"><span class="lbl">Fecha Facturación</span>'+fechaFac+'</td><td width="25%"><span class="lbl">Sucursal de Atención</span>'+sucCiudad+'</td></tr>'+
        '<tr><td colspan="4"><span class="lbl">Problema Reportado</span>'+detalle+'</td></tr></table>'+
        '<div style="border-top:1.5px solid #000;padding-top:4px;margin-top:6px;"><div class="condiciones-titulo">Condiciones</div><div class="condiciones">'+
        '<p><b>1. VALIDACIÓN GARANTÍA:</b> Los equipos que ingresen bajo esta condición deberán ser evaluados obligatoriamente por un técnico.</p>'+
        '<p><b>2. RESPALDO DE INFORMACIÓN:</b> El cliente es el único responsable de realizar el debido respaldo de toda la información contenida en su equipo.</p>'+
        '<p><b>3. DOCUMENTACIÓN:</b> El presente documento es el único válido para el retiro del equipo ingresado a NOVITECNOLOGIA.</p>'+
        '</div></div>'+
        '<div class="firmas" style="margin-top:10px;"><div class="firma-box"><div class="firma-linea">Recibido por:</div></div><div class="firma-box"><div class="firma-linea">Firma del cliente:</div></div></div>'+
        '<div style="text-align:center;margin-top:8px;font-size:7pt;color:#94a3b8;border-top:1px solid #e5e7eb;padding-top:6px;">Novitecnología Cía. Ltda. — Impreso el: '+fechaImp+'</div>'+
        '</div></body></html>';

    var w=window.open('','_blank');
    w.document.write(html);
    w.document.close();
    w.focus();
    setTimeout(function(){w.print();},500);
};

// ── SUGERENCIAS ────────────────────────────────────────────────────
window.sgAbrir=function(){
    document.getElementById('sg-body').style.display='';
    document.getElementById('sg-ok').style.display='none';
    document.getElementById('sg-gerr').style.display='none';
    ['sge-nom','sge-ape','sge-txt'].forEach(function(id){
        var e=document.getElementById(id);if(e)e.style.display='none';
    });
    var btn=document.getElementById('sg-send');
    btn.disabled=false;btn.textContent='📨 Enviar sugerencia';
    document.getElementById('sg-overlay').classList.add('open');
    document.body.style.overflow='hidden';
};
window.sgCerrar=function(ev){
    if(ev&&ev.target!==document.getElementById('sg-overlay'))return;
    document.getElementById('sg-overlay').classList.remove('open');
    document.body.style.overflow='';
};
window.sgEnviar=function(){
    var nom=document.getElementById('sg-nom').value.trim();
    var ape=document.getElementById('sg-ape').value.trim();
    var txt=document.getElementById('sg-txt').value.trim();
    var ok=true;
    if(!nom){document.getElementById('sge-nom').style.display='block';ok=false;}
    else document.getElementById('sge-nom').style.display='none';
    if(!ape){document.getElementById('sge-ape').style.display='block';ok=false;}
    else document.getElementById('sge-ape').style.display='none';
    if(!txt||txt.length<10){document.getElementById('sge-txt').style.display='block';ok=false;}
    else document.getElementById('sge-txt').style.display='none';
    if(!ok)return;
    var btn=document.getElementById('sg-send');
    btn.disabled=true;btn.textContent='Enviando...';
    document.getElementById('sg-gerr').style.display='none';
    var fd=new FormData();
    fd.append('_token',_CSRF);
    fd.append('sg_nombres',nom);
    fd.append('sg_apellidos',ape);
    fd.append('sg_identificacion',document.getElementById('sg-ci').value.replace(/\D/g,''));
    fd.append('sg_telefono',document.getElementById('sg-tel').value.trim());
    fd.append('sg_correo',document.getElementById('sg-cor').value.trim());
    fd.append('sg_categoria',document.getElementById('sg-cat').value);
    fd.append('sg_texto',txt);
    fetch('/warranties/sugerencia',{method:'POST',body:fd})
    .then(function(r){return r.json();})
    .then(function(d){
        if(!d.ok){
            var ge=document.getElementById('sg-gerr');
            ge.textContent=d.error||'Hubo un problema. Inténtalo de nuevo.';
            ge.style.display='block';
            btn.disabled=false;btn.textContent='📨 Enviar sugerencia';
            return;
        }
        document.getElementById('sg-body').style.display='none';
        document.getElementById('sg-ok').style.display='';
    })
    .catch(function(){
        var ge=document.getElementById('sg-gerr');
        ge.textContent='⚠️ Sin conexión. Inténtalo de nuevo.';
        ge.style.display='block';
        btn.disabled=false;btn.textContent='📨 Enviar sugerencia';
    });
};
</script>
@endpush
