<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Novitec | Acceso clientes</title>

        <link rel="icon" type="image/png" href="{{ asset('images/novitec_logo.png') }}">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&family=Playfair+Display:wght@700;800&display=swap" rel="stylesheet">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen text-slate-900 antialiased" style="font-family:'DM Sans',sans-serif;background:linear-gradient(135deg,#f0f4ff 0%,#e8f0fe 28%,#fdf4ff 58%,#ecfdf5 100%);">
        <div class="fixed inset-0 overflow-hidden pointer-events-none">
            <div class="absolute -top-24 -left-16 h-80 w-80 rounded-full blur-3xl" style="background:radial-gradient(circle,rgba(59,130,246,.18),transparent 70%);"></div>
            <div class="absolute right-0 top-24 h-96 w-96 rounded-full blur-3xl" style="background:radial-gradient(circle,rgba(14,165,233,.12),transparent 70%);"></div>
            <div class="absolute bottom-0 left-1/3 h-72 w-72 rounded-full blur-3xl" style="background:radial-gradient(circle,rgba(16,185,129,.12),transparent 70%);"></div>
            <div class="absolute inset-0 opacity-20" style="background-image:linear-gradient(rgba(59,130,246,.08) 1px,transparent 1px),linear-gradient(90deg,rgba(59,130,246,.08) 1px,transparent 1px);background-size:54px 54px;"></div>
        </div>

        <main class="relative z-10 min-h-screen px-4 py-8 sm:px-6 lg:px-8">
            <div class="mx-auto flex max-w-6xl items-center justify-between pb-6">
                <a href="/" class="inline-flex items-center gap-3 text-sm font-medium text-slate-600 transition hover:text-blue-700">
                    <span class="text-lg leading-none">&larr;</span>
                    <span>Volver al inicio</span>
                </a>

                <img src="{{ asset('images/novitec_logo.png') }}" alt="Novitec" class="h-10">
            </div>

            <div class="mx-auto grid max-w-6xl gap-8 lg:grid-cols-[0.95fr,1.05fr] lg:items-center">
                <section class="hidden lg:block">
                    <div class="max-w-xl">
                        <p class="text-xs font-semibold uppercase tracking-[0.35em] text-blue-600">Portal clientes</p>
                        <h1 class="mt-5 text-5xl font-bold leading-tight text-slate-900" style="font-family:'Playfair Display',serif;">
                            Acceso simple, claro y conectado con Novitec.
                        </h1>
                        <p class="mt-5 max-w-lg text-base leading-8 text-slate-600">
                            Ingresa con tu cedula o RUC, revisa tus ordenes, consulta garantias y mantén tus datos al día desde una sola cuenta web.
                        </p>

                        <div class="mt-8 grid grid-cols-3 gap-4">
                            <div class="rounded-3xl border border-white/60 bg-white/60 p-4 shadow-sm backdrop-blur">
                                <p class="text-2xl font-bold text-slate-900" style="font-family:'Playfair Display',serif;">SGN</p>
                                <p class="mt-1 text-xs uppercase tracking-[0.22em] text-slate-500">Autofill</p>
                            </div>
                            <div class="rounded-3xl border border-white/60 bg-white/60 p-4 shadow-sm backdrop-blur">
                                <p class="text-2xl font-bold text-slate-900" style="font-family:'Playfair Display',serif;">24/7</p>
                                <p class="mt-1 text-xs uppercase tracking-[0.22em] text-slate-500">Consulta</p>
                            </div>
                            <div class="rounded-3xl border border-white/60 bg-white/60 p-4 shadow-sm backdrop-blur">
                                <p class="text-2xl font-bold text-slate-900" style="font-family:'Playfair Display',serif;">1</p>
                                <p class="mt-1 text-xs uppercase tracking-[0.22em] text-slate-500">Cuenta</p>
                            </div>
                        </div>
                    </div>
                </section>

                <section>
                    <div class="mx-auto w-full max-w-2xl rounded-[2rem] border border-white/70 bg-white/88 p-6 shadow-[0_30px_80px_rgba(15,23,42,0.18)] backdrop-blur sm:p-8">
                        {{ $slot }}
                    </div>
                </section>
            </div>
        </main>
    </body>
</html>
