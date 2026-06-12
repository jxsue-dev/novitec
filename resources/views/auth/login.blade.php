<x-guest-layout>
    <x-auth-session-status
        class="mb-6 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-700"
        :status="session('status')"
    />

    <div class="mb-8">
        <p class="text-xs font-semibold uppercase tracking-[0.3em] text-blue-600">Iniciar sesion</p>
        <h1 class="mt-3 text-3xl font-bold text-slate-900" style="font-family:'Playfair Display',serif;">
            Accede a tu cuenta
        </h1>
        <p class="mt-3 text-sm leading-7 text-slate-600">
            Ingresa con tu cedula o RUC para consultar tus ordenes y garantias.
        </p>
    </div>

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf
        <input type="hidden" name="redirect_to" value="{{ request('redirect_to') }}">

        <div>
            <label for="identificacion" class="mb-2 block text-sm font-medium text-slate-700">Cedula o RUC</label>
            <input
                id="identificacion"
                class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100"
                type="text"
                name="identificacion"
                value="{{ old('identificacion') }}"
                required
                autofocus
                autocomplete="username"
                maxlength="13"
                placeholder="Ej: 0912345678"
            />
            <x-input-error :messages="$errors->get('identificacion')" class="mt-2 text-sm text-red-600" />
        </div>

        <div>
            <label for="password" class="mb-2 block text-sm font-medium text-slate-700">Contrasena</label>
            <input
                id="password"
                class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100"
                type="password"
                name="password"
                required
                autocomplete="current-password"
                placeholder="Ingresa tu contrasena"
            />
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm text-red-600" />
        </div>

        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <label for="remember_me" class="inline-flex items-center gap-3 text-sm text-slate-600">
                <input id="remember_me" type="checkbox" class="h-4 w-4 rounded border-slate-300 text-blue-600 focus:ring-blue-500" name="remember">
                <span>Recordarme</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-sm font-medium text-blue-600 transition hover:text-blue-700" href="{{ route('password.request') }}">
                    Olvide mi contrasena
                </a>
            @endif
        </div>

        <button
            type="submit"
            class="inline-flex w-full items-center justify-center rounded-2xl bg-blue-600 px-5 py-3.5 text-sm font-semibold text-white transition hover:bg-blue-700"
        >
            Ingresar
        </button>
    </form>

    <div class="mt-8 border-t border-slate-200 pt-6 text-center">
        <p class="text-sm text-slate-600">
            No tienes cuenta?
            <a href="{{ route('register', request('redirect_to') ? ['redirect_to' => request('redirect_to')] : []) }}" class="font-semibold text-blue-600 transition hover:text-blue-700">
                Registrate aqui
            </a>
        </p>
    </div>
</x-guest-layout>
