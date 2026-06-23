<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Chat IA – Novitec</title>
    <link rel="icon" type="image/png" href="{{ asset('images/novitec_logo.png') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'DM Sans', 'Inter', sans-serif; }
        #messages { scroll-behavior: smooth; }
        .msg-user   { background: #2563eb; color: #fff; border-radius: 18px 18px 4px 18px; }
        .msg-bot    { background: #1e293b; color: #e2e8f0; border-radius: 18px 18px 18px 4px; }
        .sidebar-item.active { background: rgba(255,255,255,.08); }
        .sidebar-item:hover  { background: rgba(255,255,255,.05); }
        pre { white-space: pre-wrap; word-break: break-word; font-family: inherit; margin: 0; }

        @keyframes blink { 0%,100%{opacity:.2} 50%{opacity:1} }
        .dot { width:7px; height:7px; border-radius:50%; background:#60a5fa; animation: blink 1.2s infinite; display:inline-block; }
        .dot:nth-child(2){ animation-delay:.2s; }
        .dot:nth-child(3){ animation-delay:.4s; }

        textarea { resize: none; }
        textarea::-webkit-scrollbar { width: 4px; }
        textarea::-webkit-scrollbar-thumb { background: #334155; border-radius: 4px; }

        ::-webkit-scrollbar { width: 5px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #334155; border-radius: 4px; }
    </style>
</head>
<body class="bg-slate-950 text-slate-100 h-screen flex overflow-hidden" x-data="chatApp()" x-init="init()">

{{-- ══ SIDEBAR ══════════════════════════════════════ --}}
<aside class="w-64 flex-shrink-0 flex flex-col border-r border-white/5 bg-slate-900"
       :class="sidebarOpen ? 'flex' : 'hidden md:flex'">

    {{-- Logo --}}
    <div class="px-4 py-4 border-b border-white/5 flex items-center justify-between">
        <a href="/" class="flex items-center gap-2">
            <img src="{{ asset('images/novitec_logo.png') }}" alt="Novitec" class="h-6 brightness-0 invert opacity-80">
        </a>
        <button @click="sidebarOpen=false" class="md:hidden text-slate-500 hover:text-white">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>

    {{-- New chat --}}
    <div class="p-3">
        <form method="POST" action="{{ route('chat.new') }}">
            @csrf
            <button type="submit"
                    class="w-full flex items-center gap-2 px-3 py-2.5 rounded-xl border border-white/10 hover:border-blue-500/50 hover:bg-blue-600/10 text-sm text-slate-300 hover:text-white transition-all">
                <i class="fa-solid fa-plus text-blue-400"></i>
                Nuevo chat
            </button>
        </form>
    </div>

    {{-- Conversations list --}}
    <div class="flex-1 overflow-y-auto px-2 pb-3 space-y-0.5">
        @forelse($conversations as $conv)
        <div class="sidebar-item group flex items-center gap-2 px-3 py-2.5 rounded-xl cursor-pointer transition-all
                    {{ $conv->id === $conversation->id ? 'active' : '' }}">
            <a href="{{ route('chat.show', $conv) }}" class="flex-1 min-w-0">
                <p class="text-sm text-slate-300 truncate">{{ $conv->title }}</p>
                <p class="text-xs text-slate-500 truncate">{{ $conv->updated_at->diffForHumans() }}</p>
            </a>
            <form method="POST" action="{{ route('chat.destroy', $conv) }}" class="opacity-0 group-hover:opacity-100 transition-opacity">
                @csrf @method('DELETE')
                <button type="submit" onclick="return confirm('¿Eliminar esta conversación?')"
                        class="text-slate-500 hover:text-red-400 text-xs p-1 transition-colors">
                    <i class="fa-solid fa-trash-can"></i>
                </button>
            </form>
        </div>
        @empty
        <p class="text-xs text-slate-500 text-center px-3 py-4">Sin conversaciones aún</p>
        @endforelse
    </div>

    {{-- User footer --}}
    <div class="border-t border-white/5 p-3">
        <div class="flex items-center gap-2 px-2 py-2">
            <div class="w-7 h-7 rounded-full bg-blue-600 flex items-center justify-center text-xs font-bold text-white flex-shrink-0">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-xs font-medium text-slate-300 truncate">{{ auth()->user()->name }}</p>
            </div>
            <a href="{{ route('dashboard') }}" class="text-slate-500 hover:text-white text-xs transition-colors" title="Dashboard">
                <i class="fa-solid fa-arrow-right-from-bracket"></i>
            </a>
        </div>
    </div>
</aside>

{{-- ══ MAIN ══════════════════════════════════════════ --}}
<main class="flex-1 flex flex-col min-w-0">

    {{-- Topbar --}}
    <header class="flex items-center gap-3 px-4 py-3 border-b border-white/5 bg-slate-900/50 backdrop-blur flex-shrink-0">
        <button @click="sidebarOpen=true" class="md:hidden text-slate-400 hover:text-white">
            <i class="fa-solid fa-bars"></i>
        </button>
        <div class="flex items-center gap-2 min-w-0">
            <div class="w-7 h-7 rounded-lg bg-gradient-to-br from-blue-500 to-violet-600 flex items-center justify-center flex-shrink-0">
                <i class="fa-solid fa-robot text-white text-xs"></i>
            </div>
            <div class="min-w-0">
                <p class="text-sm font-medium text-white truncate">{{ $conversation->title }}</p>
                <p class="text-xs text-green-400 flex items-center gap-1">
                    <span class="w-1.5 h-1.5 bg-green-400 rounded-full animate-pulse inline-block"></span>
                    Asistente Novitec · Grok IA
                </p>
            </div>
        </div>
    </header>

    {{-- Messages --}}
    <div id="messages" class="flex-1 overflow-y-auto px-4 py-6 space-y-5">

        @if($messages->isEmpty())
        {{-- Empty state --}}
        <div class="flex flex-col items-center justify-center h-full text-center gap-4 pb-16">
            <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-blue-500 to-violet-600 flex items-center justify-center text-3xl shadow-xl">
                <i class="fa-solid fa-robot text-white"></i>
            </div>
            <div>
                <h2 class="text-xl font-semibold text-white mb-1">Asistente Novitec</h2>
                <p class="text-slate-400 text-sm max-w-xs">Puedo ayudarte con servicios, garantías, soporte técnico y preguntas generales de tecnología.</p>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 mt-2 max-w-md w-full">
                @foreach(['¿Cuáles son los servicios de Novitec?', '¿Cómo consulto el estado de mi equipo?', '¿Cuánto cuesta reparar una laptop?', 'Mi celular no enciende, ¿qué hago?'] as $suggestion)
                <button @click="sendSuggestion('{{ $suggestion }}')"
                        class="text-left text-xs text-slate-300 bg-slate-800 hover:bg-slate-700 border border-white/5 hover:border-blue-500/30 px-3 py-2.5 rounded-xl transition-all">
                    {{ $suggestion }}
                </button>
                @endforeach
            </div>
        </div>
        @else
        @foreach($messages as $msg)
        <div class="flex {{ $msg->role === 'user' ? 'justify-end' : 'justify-start' }} gap-3">
            @if($msg->role === 'assistant')
            <div class="w-7 h-7 rounded-lg bg-gradient-to-br from-blue-500 to-violet-600 flex items-center justify-center flex-shrink-0 mt-0.5">
                <i class="fa-solid fa-robot text-white text-xs"></i>
            </div>
            @endif
            <div class="max-w-[75%]">
                <div class="px-4 py-3 text-sm leading-relaxed {{ $msg->role === 'user' ? 'msg-user' : 'msg-bot' }}">
                    <pre>{{ $msg->content }}</pre>
                </div>
                <p class="text-xs text-slate-500 mt-1 {{ $msg->role === 'user' ? 'text-right' : 'text-left' }}">
                    {{ $msg->created_at->format('H:i') }}
                </p>
            </div>
            @if($msg->role === 'user')
            <div class="w-7 h-7 rounded-full bg-blue-600 flex items-center justify-center text-xs font-bold text-white flex-shrink-0 mt-0.5">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
            @endif
        </div>
        @endforeach
        @endif

        {{-- Typing indicator --}}
        <div x-show="typing" x-cloak class="flex justify-start gap-3">
            <div class="w-7 h-7 rounded-lg bg-gradient-to-br from-blue-500 to-violet-600 flex items-center justify-center flex-shrink-0">
                <i class="fa-solid fa-robot text-white text-xs"></i>
            </div>
            <div class="msg-bot px-4 py-3 flex items-center gap-1.5">
                <span class="dot"></span><span class="dot"></span><span class="dot"></span>
            </div>
        </div>

        <div id="anchor"></div>
    </div>

    {{-- Input --}}
    <div class="flex-shrink-0 border-t border-white/5 bg-slate-900/50 backdrop-blur p-3 md:p-4">
        <div class="max-w-3xl mx-auto">
            <div class="flex items-end gap-2 bg-slate-800 border border-white/10 rounded-2xl px-4 py-3 focus-within:border-blue-500/50 transition-colors">
                <textarea
                    x-model="input"
                    @keydown.enter.exact.prevent="send()"
                    @keydown.enter.shift.prevent="input += '\n'"
                    @input="autoResize($el)"
                    rows="1"
                    placeholder="Escribe tu mensaje… (Enter para enviar, Shift+Enter nueva línea)"
                    class="flex-1 bg-transparent text-sm text-slate-100 placeholder-slate-500 outline-none max-h-36"
                    :disabled="typing"
                ></textarea>
                <button @click="send()"
                        :disabled="typing || !input.trim()"
                        class="w-9 h-9 rounded-xl bg-blue-600 hover:bg-blue-500 disabled:bg-slate-700 disabled:text-slate-500 text-white flex items-center justify-center transition-all flex-shrink-0">
                    <i class="fa-solid fa-paper-plane text-sm"></i>
                </button>
            </div>
            <p class="text-xs text-slate-600 text-center mt-2">El asistente puede cometer errores. Verifica información importante.</p>
        </div>
    </div>
</main>

<script>
function chatApp() {
    return {
        input: '',
        typing: false,
        sidebarOpen: false,

        init() {
            this.scrollToBottom();
        },

        scrollToBottom() {
            this.$nextTick(() => {
                const anchor = document.getElementById('anchor');
                if (anchor) anchor.scrollIntoView({ behavior: 'smooth' });
            });
        },

        autoResize(el) {
            el.style.height = 'auto';
            el.style.height = Math.min(el.scrollHeight, 144) + 'px';
        },

        sendSuggestion(text) {
            this.input = text;
            this.send();
        },

        async send() {
            const msg = this.input.trim();
            if (!msg || this.typing) return;

            this.input = '';
            this.typing = true;

            // Render user bubble instantly
            this.appendMessage('user', msg);
            this.scrollToBottom();

            try {
                const res = await fetch('{{ route('chat.message', $conversation) }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({ message: msg }),
                });

                const data = await res.json();
                this.appendMessage('assistant', data.reply ?? 'Error al obtener respuesta.');
            } catch {
                this.appendMessage('assistant', 'Error de conexión. Por favor intenta de nuevo.');
            } finally {
                this.typing = false;
                this.scrollToBottom();
            }
        },

        appendMessage(role, content) {
            const anchor = document.getElementById('anchor');
            const isUser = role === 'user';
            const time   = new Date().toLocaleTimeString('es', { hour: '2-digit', minute: '2-digit' });
            const userInitial = '{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}';

            const wrapper = document.createElement('div');
            wrapper.className = `flex ${isUser ? 'justify-end' : 'justify-start'} gap-3`;

            const botAvatar = `<div class="w-7 h-7 rounded-lg bg-gradient-to-br from-blue-500 to-violet-600 flex items-center justify-center flex-shrink-0 mt-0.5">
                <i class="fa-solid fa-robot text-white text-xs"></i></div>`;
            const userAvatar = `<div class="w-7 h-7 rounded-full bg-blue-600 flex items-center justify-center text-xs font-bold text-white flex-shrink-0 mt-0.5">${userInitial}</div>`;

            const escaped = content.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;');

            wrapper.innerHTML = `
                ${!isUser ? botAvatar : ''}
                <div class="max-w-[75%]">
                    <div class="px-4 py-3 text-sm leading-relaxed ${isUser ? 'msg-user' : 'msg-bot'}">
                        <pre>${escaped}</pre>
                    </div>
                    <p class="text-xs text-slate-500 mt-1 ${isUser ? 'text-right' : 'text-left'}">${time}</p>
                </div>
                ${isUser ? userAvatar : ''}
            `;

            anchor.parentNode.insertBefore(wrapper, anchor);
        }
    }
}
</script>
</body>
</html>
