<?php

namespace App\Http\Controllers;

use App\Models\Llamada;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class LlamadaController extends Controller
{
    // ── Inicia el registro cuando la recepcionista hace click en el número
    public function iniciar(Request $request)
    {
        $request->validate([
            'numero'    => 'required|string|max:20',
            'nro_orden' => 'nullable|string|max:30',
            'cliente'   => 'nullable|string|max:150',
        ]);

        $token = Str::random(32);

        $llamada = Llamada::create([
            'user_id'       => Auth::id(),
            'numero'        => preg_replace('/[^0-9+]/', '', $request->numero),
            'nro_orden'     => $request->nro_orden,
            'cliente'       => $request->cliente,
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
        // Verificar token fijo (configurado una vez en MacroDroid)
        $tokenEnvio = $request->input('token') ?? $request->header('X-Webhook-Token');
        $tokenConfig = config('services.llamadas.webhook_token', env('LLAMADAS_WEBHOOK_TOKEN', ''));

        if (empty($tokenConfig) || $tokenEnvio !== $tokenConfig) {
            return response()->json(['ok' => false, 'msg' => 'Token inválido'], 401);
        }

        $numero   = preg_replace('/[^0-9+]/', '', $request->input('numero', ''));
        // Acepta 'duracion' o 'call_duration' (distintas versiones de MacroDroid)
        $duracion = (int) ($request->input('duracion') ?? $request->input('call_duration') ?? 0);
        // Acepta 'contesto', 'call_was_answered', 'call_answered'
        $contestoRaw = $request->input('contesto') ?? $request->input('call_was_answered') ?? $request->input('call_answered') ?? null;
        // Si no se envía, determinamos por duración (>5 seg = contestada)
        $contesto = $contestoRaw !== null
            ? filter_var($contestoRaw, FILTER_VALIDATE_BOOLEAN)
            : $duracion > 5;

        if (empty($numero)) {
            return response()->json(['ok' => false, 'msg' => 'Número requerido'], 422);
        }

        $estado = $contesto ? 'contestada' : 'no_contestada';

        // Busca llamada iniciada desde el panel (últimos 30 min)
        $llamada = Llamada::where('numero', 'like', '%' . ltrim($numero, '0'))
            ->where('estado', 'iniciada')
            ->where('iniciada_at', '>=', now()->subMinutes(30))
            ->latest('iniciada_at')
            ->first();

        if ($llamada) {
            // Actualiza registro existente (llamada iniciada desde el panel)
            $llamada->update([
                'estado'            => $estado,
                'duracion_segundos' => $duracion > 0 ? $duracion : null,
                'completada_at'     => now(),
                'webhook_token'     => null,
            ]);
        } else {
            // Crea registro nuevo (llamada manual desde el teléfono, no iniciada en el panel)
            // Intenta asignarla al usuario recepcionista activo de la sucursal según prefijo
            $userId = null;
            $prefixMap = array_flip(\App\Models\User::BRANCH_ORDER_PREFIX);
            $branchCode = null;
            foreach ($prefixMap as $prefix => $code) {
                if (str_starts_with($numero, ltrim($prefix, '+'))) {
                    $branchCode = $code;
                    break;
                }
            }
            if ($branchCode) {
                $receptionist = \App\Models\User::where('branch_code', $branchCode)->first();
                $userId = $receptionist?->id;
            }

            $llamada = Llamada::create([
                'user_id'           => $userId,
                'numero'            => $numero,
                'nro_orden'         => null,
                'cliente'           => null,
                'estado'            => $estado,
                'duracion_segundos' => $duracion > 0 ? $duracion : null,
                'iniciada_at'       => now()->subSeconds($duracion),
                'completada_at'     => now(),
            ]);
        }

        return response()->json(['ok' => true, 'estado' => $llamada->estado, 'llamada_id' => $llamada->id, 'creada' => $llamada->wasRecentlyCreated]);
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
            $query->where('user_id', $user->id);
        }

        $llamadas = $query->paginate(20)->withQueryString();

        $stats = [
            'total'          => Llamada::whereDate('iniciada_at', $fecha)->when(!$user->is_admin, fn($q) => $q->where('user_id', $user->id))->count(),
            'contestadas'    => Llamada::whereDate('iniciada_at', $fecha)->where('estado','contestada')->when(!$user->is_admin, fn($q) => $q->where('user_id', $user->id))->count(),
            'no_contestadas' => Llamada::whereDate('iniciada_at', $fecha)->where('estado','no_contestada')->when(!$user->is_admin, fn($q) => $q->where('user_id', $user->id))->count(),
            'pendientes'     => Llamada::whereDate('iniciada_at', $fecha)->where('estado','iniciada')->when(!$user->is_admin, fn($q) => $q->where('user_id', $user->id))->count(),
        ];

        return view('recepcion.llamadas', compact('llamadas', 'stats', 'fecha', 'user'));
    }
}
