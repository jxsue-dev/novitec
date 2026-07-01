<?php

namespace App\Http\Controllers;

use App\Models\Llamada;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class LlamadaController extends Controller
{
    // ── Inicia el registro cuando la recepcionista hace click en el número
    // Normaliza número a formato local ecuatoriano: 0XXXXXXXXX
    private function normalizeNumero(string $raw): string
    {
        $n = preg_replace('/[^0-9]/', '', $raw);
        // Quita prefijo 593 → agrega 0
        if (str_starts_with($n, '593') && strlen($n) >= 11) {
            $n = '0' . substr($n, 3);
        }
        // Sin cero inicial (9 dígitos) → agrega 0
        if (strlen($n) === 9 && str_starts_with($n, '9')) {
            $n = '0' . $n;
        }
        return $n;
    }

    // Busca la orden más reciente de un número en vista_ordenes y devuelve datos del cliente
    private function buscarClientePorNumero(string $numero): array
    {
        if (empty($numero)) return [];

        $numeroSin0 = ltrim($numero, '0');
        $orden = DB::connection('novitecdb')
            ->table('vista_ordenes')
            ->where(function ($q) use ($numero, $numeroSin0) {
                $q->where('numero_contacto', $numero)
                  ->orWhere('numero_contacto', $numeroSin0);
            })
            ->orderByDesc('fecha_de_ingreso')
            ->select('nro_orden', 'nombres', 'apellidos', 'cliente', 'identificacion')
            ->first();

        if (!$orden) return [];

        $cliente = trim(($orden->nombres ?? '') . ' ' . ($orden->apellidos ?? ''))
            ?: ($orden->cliente ?? '');

        return [
            'nro_orden' => $orden->nro_orden,
            'cliente'   => $cliente,
        ];
    }

    public function iniciar(Request $request)
    {
        $request->validate([
            'numero'    => 'required|string|max:20',
            'nro_orden' => 'nullable|string|max:30',
            'cliente'   => 'nullable|string|max:150',
        ]);

        $token  = Str::random(32);
        $numero = $this->normalizeNumero($request->numero);

        // Auto-vincular si no se pasó cliente/orden
        $infoCliente = ($request->filled('nro_orden') || $request->filled('cliente'))
            ? []
            : $this->buscarClientePorNumero($numero);

        $llamada = Llamada::create([
            'user_id'       => Auth::id(),
            'numero'        => $numero,
            'nro_orden'     => $request->nro_orden ?? ($infoCliente['nro_orden'] ?? null),
            'cliente'       => $request->cliente   ?? ($infoCliente['cliente']   ?? null),
            'estado'        => 'iniciada',
            'webhook_token' => $token,
            'iniciada_at'   => now(),
        ]);

        return response()->json([
            'ok'          => true,
            'llamada_id'  => $llamada->id,
            'webhook_url' => route('llamadas.webhook', $token),
        ]);
    }

    // ── Recibe resultado desde MacroDroid
    // URL fija: POST /api/llamada-webhook
    // Body: token=SECRET&numero=0960500156&duracion=65&contesto=true
    public function webhook(Request $request)
    {
        $tokenEnvio = $request->input('token') ?? $request->header('X-Webhook-Token') ?? '';

        // 1. Buscar recepcionista por su token personal
        $receptionist = \App\Models\User::where('call_webhook_token', $tokenEnvio)
            ->whereNotNull('branch_code')
            ->first();

        // 2. Fallback: token global del .env (compatibilidad)
        if (! $receptionist) {
            $tokenGlobal = config('services.llamadas.webhook_token', env('LLAMADAS_WEBHOOK_TOKEN', ''));
            if (empty($tokenEnvio) || $tokenEnvio !== $tokenGlobal) {
                return response()->json(['ok' => false, 'msg' => 'Token inválido'], 401);
            }
        }

        $userId      = $receptionist?->id;
        $branchCode  = $receptionist?->branch_code;

        // Log completo para debug — así vemos exactamente qué envía MacroDroid
        \Illuminate\Support\Facades\Log::info('Webhook llamada', $request->all());

        $numeroRaw = $request->input('numero') ?? $request->input('number') ?? $request->input('phone') ?? '';
        $numero    = $this->normalizeNumero($numeroRaw);
        if (empty($numero)) $numero = $numeroRaw;

        $duracion = (int) ($request->input('duracion') ?? $request->input('call_duration') ?? $request->input('duration') ?? 0);

        $contestoRaw = $request->input('contesto') ?? $request->input('call_was_answered') ?? $request->input('call_answered') ?? $request->input('answered') ?? null;
        $contesto = $contestoRaw !== null ? filter_var($contestoRaw, FILTER_VALIDATE_BOOLEAN) : $duracion > 5;

        if (empty($numero)) {
            return response()->json(['ok' => false, 'msg' => 'Número requerido', 'recibido' => $request->all()], 422);
        }

        $tipo   = in_array($request->input('tipo'), ['entrante', 'saliente']) ? $request->input('tipo') : 'saliente';
        $estado = $contesto ? 'contestada' : 'no_contestada';

        // Busca llamada iniciada desde el panel (últimos 30 min)
        $llamada = Llamada::where('numero', 'like', '%' . ltrim($numero, '0'))
            ->where('estado', 'iniciada')
            ->where('iniciada_at', '>=', now()->subMinutes(30))
            ->latest('iniciada_at')
            ->first();

        if ($llamada) {
            $llamada->update([
                'estado'            => $estado,
                'tipo'              => $tipo,
                'duracion_segundos' => $duracion > 0 ? $duracion : null,
                'completada_at'     => now(),
                'webhook_token'     => null,
            ]);
        } else {
            // Si no hay recepcionista por token, intentar por prefijo del número
            if (! $userId) {
                $prefixMap = array_flip(\App\Models\User::BRANCH_ORDER_PREFIX);
                foreach ($prefixMap as $prefix => $code) {
                    if (str_starts_with($numero, ltrim($prefix, '+'))) {
                        $byBranch = \App\Models\User::where('branch_code', $code)->first();
                        $userId   = $byBranch?->id;
                        break;
                    }
                }
            }

            $infoCliente = $this->buscarClientePorNumero($numero);

            $llamada = Llamada::create([
                'user_id'           => $userId,
                'numero'            => $numero,
                'tipo'              => $tipo,
                'nro_orden'         => $infoCliente['nro_orden'] ?? null,
                'cliente'           => $infoCliente['cliente']   ?? null,
                'estado'            => $estado,
                'duracion_segundos' => $duracion > 0 ? $duracion : null,
                'iniciada_at'       => now()->subSeconds($duracion),
                'completada_at'     => now(),
            ]);
        }

        return response()->json(['ok' => true, 'estado' => $llamada->estado, 'llamada_id' => $llamada->id, 'creada' => $llamada->wasRecentlyCreated]);
    }

    // ── Buscar orden para preview (AJAX)
    public function buscarOrdenAjax(Request $request)
    {
        $nro = strtoupper(trim($request->input('q', '')));
        if (empty($nro)) return response()->json(['ok' => false]);

        $orden = DB::connection('novitecdb')
            ->table('vista_ordenes')
            ->where('nro_orden', 'like', "%{$nro}%")
            ->select('nro_orden', 'nombres', 'apellidos', 'cliente', 'tipo', 'marca', 'modelo', 'estado_orden', 'numero_contacto')
            ->limit(5)
            ->get();

        return response()->json(['ok' => true, 'ordenes' => $orden]);
    }

    // ── Vincular llamada a una orden
    public function vincular(Request $request, Llamada $llamada)
    {
        abort_if($llamada->user_id !== Auth::id() && !Auth::user()->is_admin, 403);

        $nroOrden = trim($request->input('nro_orden', ''));

        if (empty($nroOrden)) {
            $llamada->update(['nro_orden' => null, 'cliente' => null]);
            return response()->json(['ok' => true, 'msg' => 'Desvinculada']);
        }

        $orden = DB::connection('novitecdb')
            ->table('vista_ordenes')
            ->where('nro_orden', $nroOrden)
            ->select('nro_orden', 'nombres', 'apellidos', 'cliente', 'tipo', 'marca', 'modelo', 'estado_orden')
            ->first();

        if (!$orden) {
            return response()->json(['ok' => false, 'msg' => 'Orden no encontrada'], 404);
        }

        $cliente = trim(($orden->nombres ?? '') . ' ' . ($orden->apellidos ?? '')) ?: ($orden->cliente ?? '');

        $llamada->update(['nro_orden' => $orden->nro_orden, 'cliente' => $cliente]);

        return response()->json([
            'ok'      => true,
            'orden'   => $orden->nro_orden,
            'cliente' => $cliente,
            'equipo'  => trim(implode(' ', array_filter([$orden->tipo ?? '', $orden->marca ?? '', $orden->modelo ?? '']))),
            'estado'  => $orden->estado_orden,
        ]);
    }

    // ── Agregar notas a una llamada
    public function notas(Request $request, Llamada $llamada)
    {
        abort_if($llamada->user_id !== Auth::id() && !Auth::user()->is_admin, 403);
        $llamada->update(['notas' => $request->input('notas', '')]);
        return response()->json(['ok' => true]);
    }

    // ── Historial de llamadas del día para la recepcionista
    public function historial(Request $request)
    {
        $user  = Auth::user();
        $fecha = $request->input('fecha', now()->format('Y-m-d'));

        $query = Llamada::with('user')
            ->whereDate('iniciada_at', $fecha)
            ->orderByDesc('iniciada_at');

        if (! $user->is_admin) {
            // Muestra llamadas propias + las sin usuario asignado (vienen de MacroDroid)
            $query->where(function ($q) use ($user) {
                $q->where('user_id', $user->id)->orWhereNull('user_id');
            });
        }

        $llamadas = $query->paginate(20)->withQueryString();

        $stats = [
            'total'          => Llamada::whereDate('iniciada_at', $fecha)->when(!$user->is_admin, fn($q) => $q->where('user_id', $user->id))->count(),
            'contestadas'    => Llamada::whereDate('iniciada_at', $fecha)->where('estado','contestada')->when(!$user->is_admin, fn($q) => $q->where('user_id', $user->id))->count(),
            'no_contestadas' => Llamada::whereDate('iniciada_at', $fecha)->where('estado','no_contestada')->when(!$user->is_admin, fn($q) => $q->where('user_id', $user->id))->count(),
            'pendientes'     => Llamada::whereDate('iniciada_at', $fecha)->where('estado','iniciada')->when(!$user->is_admin, fn($q) => $q->where('user_id', $user->id))->count(),
        ];

        // Pre-cargar identificaciones en una sola query (evita N+1)
        $nrosConOrden = $llamadas->pluck('nro_orden')->filter()->unique()->values()->toArray();
        $identificaciones = [];
        if (!empty($nrosConOrden)) {
            $rows = DB::connection('novitecdb')
                ->table('vista_ordenes')
                ->whereIn('nro_orden', $nrosConOrden)
                ->pluck('identificacion', 'nro_orden');
            $identificaciones = $rows->toArray();
        }

        return view('recepcion.llamadas', compact('llamadas', 'stats', 'fecha', 'user', 'identificaciones'));
    }
}
