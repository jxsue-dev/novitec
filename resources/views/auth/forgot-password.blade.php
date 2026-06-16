<x-guest-layout>
    <x-auth-session-status
        class="mb-6 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-700"
        :status="session('status')"
    />

    <div class="mb-8">
        <p class="text-xs font-semibold uppercase tracking-[0.3em] text-blue-600">Recuperar contraseña</p>
        <h1 class="mt-3 text-3xl font-bold text-slate-900" style="font-family:'Playfair Display',serif;">
            Restablece tu acceso
        </h1>
        <p class="mt-3 text-sm leading-7 text-slate-600">
            Confirma el correo registrado en tu cuenta. Si existe, te enviaremos un enlace seguro para crear una nueva contraseña.
        </p>
    </div>

    <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
        @csrf

        <div>
            <label for="email" class="mb-2 block text-sm font-medium text-slate-700">Correo electrónico</label>
            <input
                id="email"
                class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100"
                type="email"
                name="email"
                value="{{ old('email') }}"
                required
                autofocus
                autocomplete="username"
                placeholder="tu-correo@ejemplo.com"
            />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-red-600" />
        </div>

        <button
            type="submit"
            class="inline-flex w-full items-center justify-center rounded-2xl bg-blue-600 px-5 py-3.5 text-sm font-semibold text-white transition hover:bg-blue-700"
        >
            Enviar enlace de recuperación
        </button>
    </form>

    <div class="mt-8 border-t border-slate-200 pt-6 text-center">
        <p class="text-sm text-slate-600">
            ¿Ya recordaste tu contraseña?
            <a class="font-semibold text-blue-600 transition hover:text-blue-700" href="{{ route('login') }}">
                Inicia sesión aquí
            </a>
        </p>
    </div>
</x-guest-layout>
