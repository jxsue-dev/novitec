<x-guest-layout>
    <div class="mb-8">
        <p class="text-xs font-semibold uppercase tracking-[0.3em] text-blue-600">Registro</p>
        <h1 class="mt-3 text-3xl font-bold text-slate-900" style="font-family:'Playfair Display',serif;">
            Crea tu cuenta
        </h1>
        <p class="mt-3 text-sm leading-7 text-slate-600">
            Empieza con tu cedula o RUC. Si ya has ingresado una orden pérsonalmente en nuestras sucursales, completaremos tus datos automaticamente.
        </p>
    </div>

    <form method="POST" action="{{ route('register') }}" id="register-form" class="space-y-5">
        @csrf
        <input type="hidden" name="redirect_to" value="{{ request('redirect_to') }}">

        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
            <div class="flex flex-col gap-3 sm:flex-row sm:items-end">
                <div class="flex-1">
                    <label for="identificacion" class="mb-2 block text-sm font-medium text-slate-700">Cedula o RUC</label>
                    <input
                        id="identificacion"
                        class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-100"
                        type="text"
                        name="identificacion"
                        value="{{ old('identificacion') }}"
                        required
                        maxlength="13"
                        placeholder="Ej: 0912345678"
                    />
                </div>

                <button
                    type="button"
                    id="lookup-identificacion"
                    class="inline-flex items-center justify-center rounded-2xl bg-blue-600 px-5 py-3 text-sm font-semibold text-white transition hover:bg-blue-700 sm:min-w-[180px]"
                >
                    Consultar en nuestro sistema
                </button>
            </div>

            <p id="lookup-status" class="mt-3 text-sm text-slate-500"></p>
            <x-input-error :messages="$errors->get('identificacion')" class="mt-2 text-sm text-red-600" />
        </div>

        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
            <div>
                <label for="nombres" class="mb-2 block text-sm font-medium text-slate-700">Nombres</label>
                <input id="nombres" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100" type="text" name="nombres" value="{{ old('nombres') }}" required />
                <x-input-error :messages="$errors->get('nombres')" class="mt-2 text-sm text-red-600" />
            </div>

            <div>
                <label for="apellidos" class="mb-2 block text-sm font-medium text-slate-700">Apellidos</label>
                <input id="apellidos" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100" type="text" name="apellidos" value="{{ old('apellidos') }}" required />
                <x-input-error :messages="$errors->get('apellidos')" class="mt-2 text-sm text-red-600" />
            </div>
        </div>

        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
            <div>
                <label for="phone" class="mb-2 block text-sm font-medium text-slate-700">Telefono</label>
                <input id="phone" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100" type="text" name="phone" value="{{ old('phone') }}" required maxlength="10" placeholder="0987654321" />
                <x-input-error :messages="$errors->get('phone')" class="mt-2 text-sm text-red-600" />
            </div>

            <div>
                <label for="email" class="mb-2 block text-sm font-medium text-slate-700">Correo electronico</label>
                <input id="email" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100" type="email" name="email" value="{{ old('email') }}" required />
                <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-red-600" />
            </div>
        </div>

        <div>
            <label for="direccion" class="mb-2 block text-sm font-medium text-slate-700">Direccion</label>
            <textarea id="direccion" name="direccion" rows="3" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100">{{ old('direccion') }}</textarea>
            <x-input-error :messages="$errors->get('direccion')" class="mt-2 text-sm text-red-600" />
        </div>

        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
            <div>
                <label for="password" class="mb-2 block text-sm font-medium text-slate-700">Contrasena</label>
                <input id="password" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100" type="password" name="password" required />
                <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm text-red-600" />
            </div>

            <div>
                <label for="password_confirmation" class="mb-2 block text-sm font-medium text-slate-700">Confirmar contrasena</label>
                <input id="password_confirmation" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100" type="password" name="password_confirmation" required />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-sm text-red-600" />
            </div>
        </div>

        <button
            type="submit"
            class="inline-flex w-full items-center justify-center rounded-2xl bg-blue-600 px-5 py-3.5 text-sm font-semibold text-white transition hover:bg-blue-700"
        >
            Crear cuenta
        </button>
    </form>

    <div class="mt-8 border-t border-slate-200 pt-6 text-center">
        <p class="text-sm text-slate-600">
            Ya tienes cuenta?
            <a class="font-semibold text-blue-600 transition hover:text-blue-700" href="{{ route('login', request('redirect_to') ? ['redirect_to' => request('redirect_to')] : []) }}">
                Inicia sesion aqui
            </a>
        </p>
    </div>

    <script>
        (() => {
            const input = document.getElementById('identificacion');
            const button = document.getElementById('lookup-identificacion');
            const status = document.getElementById('lookup-status');
            const fields = {
                nombres: document.getElementById('nombres'),
                apellidos: document.getElementById('apellidos'),
                phone: document.getElementById('phone'),
                email: document.getElementById('email'),
                direccion: document.getElementById('direccion'),
            };

            let lastLookup = '';

            const fillFields = (cliente) => {
                fields.nombres.value = cliente.nombres || '';
                fields.apellidos.value = cliente.apellidos || '';
                fields.phone.value = cliente.telefono || '';
                fields.email.value = cliente.correo || '';
                fields.direccion.value = cliente.direccion || '';
            };

            const setStatus = (message, type = 'default') => {
                const classes = {
                    default: 'text-slate-500',
                    success: 'text-emerald-600',
                    warning: 'text-amber-600',
                    error: 'text-red-600',
                };

                status.className = 'mt-3 text-sm ' + (classes[type] || classes.default);
                status.textContent = message;
            };

            const setLoading = (loading) => {
                button.disabled = loading;
                button.classList.toggle('opacity-70', loading);
                button.classList.toggle('cursor-not-allowed', loading);
                button.textContent = loading ? 'Consultando...' : 'Consultar en SGN';
            };

            const lookup = async () => {
                const identificacion = (input.value || '').replace(/\D/g, '');

                if (!identificacion || identificacion.length < 10) {
                    setStatus('Ingresa una identificacion valida para consultar en SGN.', 'default');
                    return;
                }

                if (identificacion === lastLookup) {
                    return;
                }

                lastLookup = identificacion;
                setLoading(true);
                setStatus('Buscando cliente en SGN...', 'default');

                try {
                    const url = new URL(@json(route('register.lookup-identificacion')), window.location.origin);
                    url.searchParams.set('identificacion', identificacion);

                    const response = await fetch(url, {
                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest',
                        },
                    });

                    const data = await response.json();

                    if (!response.ok) {
                        throw new Error(data.message || 'No se pudo consultar SGN.');
                    }

                    if (data.found && data.cliente) {
                        fillFields(data.cliente);
                        setStatus('Cliente encontrado en SGN. Revisa los datos antes de guardar.', 'success');
                        return;
                    }

                    setStatus('No encontramos ese cliente en SGN. Completa el registro manualmente.', 'warning');
                } catch (error) {
                    setStatus(error.message || 'No se pudo consultar SGN en este momento.', 'error');
                } finally {
                    setLoading(false);
                }
            };

            button.addEventListener('click', lookup);
            input.addEventListener('blur', lookup);
        })();
    </script>
</x-guest-layout>
