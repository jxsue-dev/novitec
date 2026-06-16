<x-guest-layout>
    <div class="mb-8">
        <p class="text-xs font-semibold uppercase tracking-[0.3em] text-blue-600">Nueva contraseña</p>
        <h1 class="mt-3 text-3xl font-bold text-slate-900" style="font-family:'Playfair Display',serif;">
            Actualiza tu contraseña
        </h1>
        <p class="mt-3 text-sm leading-7 text-slate-600">
            Confirma tu correo y define una nueva contraseña segura para volver a entrar a tu cuenta.
        </p>
    </div>

    <form method="POST" action="{{ route('password.store') }}" class="space-y-5">
        @csrf

        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <div>
            <label for="email" class="mb-2 block text-sm font-medium text-slate-700">Correo electrónico</label>
            <input
                id="email"
                class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100"
                type="email"
                name="email"
                value="{{ old('email', $request->email) }}"
                required
                autofocus
                autocomplete="username"
                placeholder="tu-correo@ejemplo.com"
            />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-red-600" />
        </div>

        <div>
            <label for="password" class="mb-2 block text-sm font-medium text-slate-700">Nueva contraseña</label>
            <input
                id="password"
                class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100"
                type="password"
                name="password"
                required
                autocomplete="new-password"
                placeholder="Ingresa tu nueva contraseña"
            />
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm text-red-600" />
        </div>

        <div>
            <label for="password_confirmation" class="mb-2 block text-sm font-medium text-slate-700">Confirmar nueva contraseña</label>
            <input
                id="password_confirmation"
                class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100"
                type="password"
                name="password_confirmation"
                required
                autocomplete="new-password"
                placeholder="Repite tu nueva contraseña"
            />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-sm text-red-600" />
        </div>

        <button
            type="submit"
            class="inline-flex w-full items-center justify-center rounded-2xl bg-blue-600 px-5 py-3.5 text-sm font-semibold text-white transition hover:bg-blue-700"
        >
            Guardar nueva contraseña
        </button>
    </form>

    <div class="mt-8 border-t border-slate-200 pt-6 text-center">
        <p class="text-sm text-slate-600">
            ¿Prefieres volver al acceso?
            <a class="font-semibold text-blue-600 transition hover:text-blue-700" href="{{ route('login') }}">
                Ir a iniciar sesión
            </a>
        </p>
    </div>
</x-guest-layout>
