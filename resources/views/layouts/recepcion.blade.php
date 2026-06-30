<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Recepción') — Novitec</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="{{ asset('images/novitec_logo.png') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased" style="background:#f8fafc;">

<div class="flex min-h-screen">

    {{-- ═══ SIDEBAR ══════════════════════════════════════════════════════ --}}
    <aside class="fixed top-0 left-0 h-full w-64 z-40 flex flex-col transition-transform duration-300"
           style="background:linear-gradient(180deg,#020817 0%,#0c1a35 100%);">

        {{-- LOGO + SUCURSAL --}}
        <div class="px-6 py-5 border-b border-white/5">
            <a href="/" target="_blank">
                <img src="{{ asset('images/novitec_logo.png') }}" alt="Novitec" class="h-8 brightness-0 invert mb-3">
            </a>
            <div class="flex items-center gap-2">
                <span class="w-2 h-2 bg-emerald-400 rounded-full animate-pulse flex-shrink-0"></span>
                <div class="min-w-0">
                    <p class="text-white text-xs font-semibold truncate">{{ auth()->user()->branch_name }}</p>
                    <p class="text-slate-500 text-xs">Panel de Recepción</p>
                </div>
            </div>
        </div>

        {{-- Badges contadores --}}
        @php
        try {
            $__bc  = auth()->user()->is_admin ? 'UIO' : auth()->user()->branch_code;
            $__pfx = \App\Models\User::BRANCH_ORDER_PREFIX[$__bc] ?? '';
            $__q   = \Illuminate\Support\Facades\DB::connection('novitecdb')->table('vista_ordenes');
            if ($__pfx) $__q->where('nro_orden', 'like', $__pfx . '%');
            $__listas    = (clone $__q)->where('estado_orden', 'Finalizada')->count();
            $__atrasadas = (clone $__q)->whereRaw("fecha_prometido REGEXP '^[0-9]{4}-[0-9]{2}-[0-9]{2}'")->whereRaw("DATE(fecha_prometido) < CURDATE()")->whereNotIn('estado_orden', ['Finalizada','Entregada','Anulada','Nota de Credito'])->count();
        } catch (\Throwable) { $__listas = 0; $__atrasadas = 0; }
        @endphp

        {{-- NAV --}}
        <nav class="flex-1 px-4 py-5 space-y-1 overflow-y-auto">

            <p class="text-slate-600 text-xs font-semibold tracking-widest uppercase px-3 mb-3">Gestión</p>

            <a href="{{ route('recepcion.dashboard') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition-all
               {{ request()->routeIs('recepcion.dashboard') ? 'bg-blue-600 text-white' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">
                <i class="fa-solid fa-gauge w-4 text-center"></i>
                <span class="flex-1">Dashboard del día</span>
                @if($__atrasadas > 0)
                <span class="text-xs bg-red-500 text-white px-1.5 py-0.5 rounded-full font-bold">{{ $__atrasadas }}</span>
                @endif
            </a>

            <a href="{{ route('recepcion.dashboard', ['tab' => 'listas']) }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition-all text-slate-400 hover:text-white hover:bg-white/5">
                <i class="fa-solid fa-circle-check w-4 text-center text-green-400"></i>
                <span class="flex-1">Listas p/ entregar</span>
                @if($__listas > 0)
                <span class="text-xs bg-green-500 text-white px-1.5 py-0.5 rounded-full font-bold">{{ $__listas }}</span>
                @endif
            </a>

            <a href="{{ route('recepcion.ordenes') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition-all
               {{ request()->routeIs('recepcion.ordenes') ? 'bg-blue-600 text-white' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">
                <i class="fa-solid fa-magnifying-glass w-4 text-center"></i>
                Consulta de Órdenes
            </a>

            <a href="{{ route('recepcion.historial') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition-all
               {{ request()->routeIs('recepcion.historial') ? 'bg-blue-600 text-white' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">
                <i class="fa-solid fa-clock-rotate-left w-4 text-center"></i>
                Historial de cliente
            </a>

            {{-- Admin también puede ir al panel admin --}}
            @if(auth()->user()->is_admin)
            <a href="{{ route('recepcion.ordenes', ['branch' => 'GYE']) }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition-all
               {{ request()->input('branch') === 'GYE' ? 'bg-blue-600/30 text-blue-300' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">
                <i class="fa-solid fa-location-dot w-4 text-center"></i>
                Guayaquil
            </a>
            <a href="{{ route('recepcion.ordenes', ['branch' => 'MTA']) }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition-all
               {{ request()->input('branch') === 'MTA' ? 'bg-blue-600/30 text-blue-300' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">
                <i class="fa-solid fa-location-dot w-4 text-center"></i>
                Manta
            </a>

            <div class="border-t border-white/5 my-3"></div>
            <p class="text-slate-600 text-xs font-semibold tracking-widest uppercase px-3 mb-3">Administración</p>

            <a href="{{ route('admin.dashboard') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition-all text-slate-400 hover:text-white hover:bg-white/5">
                <i class="fa-solid fa-gauge w-4 text-center"></i>
                Panel Admin
            </a>
            @endif

        </nav>

        {{-- USUARIO --}}
        <div class="px-4 py-4 border-t border-white/5">
            <a href="{{ route('recepcion.cuenta') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all {{ request()->routeIs('recepcion.cuenta') ? 'bg-white/10' : 'hover:bg-white/5' }}">
                <div class="w-8 h-8 rounded-xl flex items-center justify-center text-white text-xs font-bold flex-shrink-0"
                     style="background:linear-gradient(135deg,#2563eb,#7c3aed)">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-white text-xs font-medium truncate">{{ auth()->user()->name }}</p>
                    <p class="text-slate-500 text-xs font-light">Mi cuenta</p>
                </div>
                <i class="fa-solid fa-chevron-right text-slate-600 text-xs"></i>
            </a>
            <form method="POST" action="{{ route('logout') }}" class="mt-1">
                @csrf
                <button type="submit" class="w-full flex items-center gap-3 px-3 py-2 rounded-xl text-sm text-slate-500 hover:text-red-400 hover:bg-white/5 transition-all">
                    <i class="fa-solid fa-right-from-bracket w-4 text-center"></i>
                    Cerrar sesión
                </button>
            </form>
        </div>
    </aside>

    {{-- ═══ CONTENIDO PRINCIPAL ═══════════════════════════════════════════ --}}
    <div class="flex-1 ml-64">

        {{-- TOPBAR --}}
        <header class="sticky top-0 z-30 bg-white border-b border-slate-100 px-8 py-4 flex items-center justify-between">
            <div>
                <h1 class="text-slate-900 font-semibold text-base">@yield('page-title', 'Recepción')</h1>
                <p class="text-slate-400 text-xs font-light">@yield('page-subtitle', auth()->user()->branch_name)</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="/" target="_blank"
                   class="text-xs text-slate-400 hover:text-slate-600 border border-slate-200 px-3 py-1.5 rounded-lg transition-colors">
                    Ver sitio →
                </a>
            </div>
        </header>

        {{-- CONTENIDO --}}
        <main class="p-8">
            @if(session('success'))
            <div class="mb-6 bg-green-50 border border-green-200 text-green-700 text-sm px-4 py-3 rounded-xl">
                {{ session('success') }}
            </div>
            @endif
            @if(session('error'))
            <div class="mb-6 bg-red-50 border border-red-200 text-red-700 text-sm px-4 py-3 rounded-xl">
                {{ session('error') }}
            </div>
            @endif
            @yield('content')
        </main>
    </div>
</div>

{{-- ═══ ASISTENTE IA RECEPCIÓN ═══════════════════════════════════════════ --}}
<style>
@keyframes recep-pulse{0%{box-shadow:0 0 0 0 rgba(99,102,241,.65),0 6px 24px rgba(99,102,241,.4)}70%{box-shadow:0 0 0 14px rgba(99,102,241,0),0 6px 24px rgba(99,102,241,.4)}100%{box-shadow:0 0 0 0 rgba(99,102,241,0),0 6px 24px rgba(99,102,241,.4)}}
@keyframes ai-in{from{opacity:0;transform:translateY(16px) scale(.97)}to{opacity:1;transform:none}}
#recep-ai-fab{animation:recep-pulse 2.5s ease-in-out infinite;}
#recep-ai-fab:hover{animation:none;transform:scale(1.08);}
#recep-ai-widget{animation:ai-in .22s ease;}
#recep-ai-msgs::-webkit-scrollbar{width:4px}
#recep-ai-msgs::-webkit-scrollbar-thumb{background:#e2e8f0;border-radius:4px}
.rai-user{background:#4f46e5;color:#fff;border-radius:18px 18px 4px 18px;margin-left:auto;max-width:82%;}
.rai-bot{background:#f8fafc;border:1px solid #e2e8f0;color:#1e293b;border-radius:18px 18px 18px 4px;max-width:88%;}
@keyframes rdots{0%,100%{opacity:.3}50%{opacity:1}}
.rdot{width:6px;height:6px;border-radius:50%;background:#6366f1;display:inline-block;animation:rdots 1.2s infinite;}
.rdot:nth-child(2){animation-delay:.2s}.rdot:nth-child(3){animation-delay:.4s}
</style>

{{-- WIDGET --}}
<div id="recep-ai-widget"
     style="display:none;position:fixed;bottom:90px;right:24px;width:370px;z-index:9997;flex-direction:column;border-radius:20px;overflow:hidden;box-shadow:0 20px 60px rgba(0,0,0,.18);border:1px solid rgba(99,102,241,.2);">

    {{-- Header --}}
    <div style="background:linear-gradient(135deg,#4f46e5,#7c3aed);padding:14px 18px;display:flex;align-items:center;gap:12px;">
        <div style="width:36px;height:36px;border-radius:50%;background:rgba(255,255,255,.15);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
            <i class="fa-solid fa-robot" style="color:#fff;font-size:1rem;"></i>
        </div>
        <div style="flex:1;">
            <p style="color:#fff;font-weight:700;font-size:13px;margin:0;">Asistente IA — Recepción</p>
            <p style="color:rgba(255,255,255,.65);font-size:11px;margin:0;">Explica órdenes en lenguaje simple</p>
        </div>
        <button onclick="toggleRecepAI()" style="background:rgba(255,255,255,.15);border:none;color:#fff;width:28px;height:28px;border-radius:8px;cursor:pointer;font-size:13px;">✕</button>
    </div>

    {{-- Mensajes --}}
    <div id="recep-ai-msgs" style="background:#fff;height:360px;overflow-y:auto;padding:14px;display:flex;flex-direction:column;gap:10px;">
        <div class="rai-bot" style="padding:10px 14px;font-size:13px;line-height:1.6;">
            👋 Hola! Soy tu asistente para entender las órdenes.<br><br>
            Puedo ayudarte a:
            <ul style="margin:6px 0 0 16px;padding:0;font-size:12px;color:#475569;">
                <li>Explicar términos técnicos en palabras simples</li>
                <li>Decirte cómo comunicar el estado al cliente</li>
                <li>Interpretar el informe del técnico</li>
            </ul>
            <br>¿Sobre qué orden necesitas ayuda? Puedes usar el botón <strong>"Analizar con IA"</strong> en la orden, o preguntarme directamente.
        </div>
    </div>

    {{-- Typing indicator --}}
    <div id="recep-ai-typing" style="display:none;padding:8px 14px;background:#fff;border-top:1px solid #f1f5f9;">
        <div class="rai-bot" style="display:inline-flex;align-items:center;gap:5px;padding:8px 12px;">
            <span class="rdot"></span><span class="rdot"></span><span class="rdot"></span>
        </div>
    </div>

    {{-- Input --}}
    <div style="background:#f8fafc;border-top:1px solid #e2e8f0;padding:10px;">
        <div style="display:flex;align-items:flex-end;gap:8px;background:#fff;border-radius:14px;padding:8px 12px;border:1px solid #e2e8f0;">
            <textarea id="recep-ai-input" rows="1"
                      placeholder="Pregunta sobre esta orden…"
                      style="flex:1;background:none;border:none;color:#1e293b;font-size:13px;outline:none;resize:none;font-family:inherit;max-height:80px;line-height:1.5;"
                      onkeydown="if(event.key==='Enter'&&!event.shiftKey){event.preventDefault();sendRecepAI();}"></textarea>
            <button onclick="sendRecepAI()" id="recep-ai-send"
                    style="width:32px;height:32px;border-radius:10px;background:linear-gradient(135deg,#4f46e5,#7c3aed);border:none;color:#fff;cursor:pointer;display:flex;align-items:center;justify-content:center;flex-shrink:0;transition:opacity .2s;">
                <i class="fa-solid fa-paper-plane" style="font-size:11px;"></i>
            </button>
        </div>
        <p style="color:#94a3b8;font-size:10px;text-align:center;margin:5px 0 0;">Solo para análisis de órdenes de Novitec</p>
    </div>
</div>

{{-- FAB --}}
<button id="recep-ai-fab" onclick="toggleRecepAI()"
        title="Asistente IA Recepción"
        style="position:fixed;bottom:24px;right:24px;z-index:9998;width:58px;height:58px;border-radius:50%;background:linear-gradient(135deg,#4f46e5,#7c3aed);border:none;display:flex;align-items:center;justify-content:center;cursor:pointer;transition:transform .2s ease;">
    <i class="fa-solid fa-robot" style="color:#fff;font-size:1.3rem;"></i>
</button>

<script>
let _recepOpen = false;
let _recepHistory = [];
let _recepContext = '';
const _recepCsrf = document.querySelector('meta[name="csrf-token"]')?.content ?? '';

function toggleRecepAI() {
    _recepOpen = !_recepOpen;
    document.getElementById('recep-ai-widget').style.display = _recepOpen ? 'flex' : 'none';
    if (_recepOpen) {
        document.getElementById('recep-ai-input').focus();
        _scrollRecep();
    }
}

// Llamado desde botón "Analizar con IA" en cada orden
function analizarOrden(orderData) {
    _recepContext = orderData;
    _recepHistory = [];

    // Limpiar mensajes y mostrar contexto cargado
    const msgs = document.getElementById('recep-ai-msgs');
    msgs.innerHTML = '';
    _appendRecepMsg('bot', '✅ Orden cargada. ¿Qué quieres saber sobre ella?\n\nPuedo explicarte:\n• Qué hizo el técnico\n• Cómo informar al cliente\n• Qué significa el estado\n• Cualquier término técnico');

    _recepOpen = true;
    document.getElementById('recep-ai-widget').style.display = 'flex';
    document.getElementById('recep-ai-input').placeholder = 'Ej: ¿Cómo le explico al cliente el diagnóstico?';
    document.getElementById('recep-ai-input').focus();
    _scrollRecep();
}

async function sendRecepAI() {
    const inp = document.getElementById('recep-ai-input');
    const msg = inp.value.trim();
    if (!msg) return;
    inp.value = '';
    inp.style.height = 'auto';

    _appendRecepMsg('user', msg);
    _scrollRecep();

    document.getElementById('recep-ai-typing').style.display = 'block';
    document.getElementById('recep-ai-send').style.opacity = '.4';
    _scrollRecep();

    // Agregar al historial
    _recepHistory.push({ role: 'user', content: msg });

    try {
        const res = await fetch('{{ route('recepcion.ai-chat') }}', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': _recepCsrf, 'Accept': 'application/json' },
            body: JSON.stringify({
                message:       msg,
                order_context: _recepContext || null,
                history:       _recepHistory.slice(-10), // últimos 10 mensajes
            }),
        });
        const data = await res.json();
        const reply = data.reply ?? 'Error al responder.';
        _recepHistory.push({ role: 'assistant', content: reply });
        document.getElementById('recep-ai-typing').style.display = 'none';
        _appendRecepMsg('bot', reply);
    } catch {
        document.getElementById('recep-ai-typing').style.display = 'none';
        _appendRecepMsg('bot', 'Error de conexión. Intenta de nuevo.');
    } finally {
        document.getElementById('recep-ai-send').style.opacity = '1';
        _scrollRecep();
        // Limpiar contexto después del primer mensaje (ya está en el historial)
        _recepContext = '';
    }
}

function _appendRecepMsg(role, content) {
    const msgs = document.getElementById('recep-ai-msgs');
    const el = document.createElement('div');
    el.className = role === 'user' ? 'rai-user' : 'rai-bot';
    el.style.cssText = 'padding:10px 14px;font-size:13px;line-height:1.6;white-space:pre-wrap;word-break:break-word;';
    el.textContent = content;
    msgs.appendChild(el);
}

function _scrollRecep() {
    const msgs = document.getElementById('recep-ai-msgs');
    msgs.scrollTop = msgs.scrollHeight;
}

document.getElementById('recep-ai-input')?.addEventListener('input', function() {
    this.style.height = 'auto';
    this.style.height = Math.min(this.scrollHeight, 80) + 'px';
});
</script>

@stack('scripts')
</body>
</html>
