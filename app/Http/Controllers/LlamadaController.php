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
        $duracion = (int) $request->input('duracion', 0);
        $contesto = filter_var($request->input('contesto', false), FILTER_VALIDATE_BOOLEAN);

        if (empty($numero)) {
            return response()->json(['ok' => false, 'msg' => 'Número requerido'], 422);
        }

        // Busca la llamada más reciente a ese número que esté pendiente (últimos 30 min)
        $llamada = Llamada::where('numero', 'like', '%' . ltrim($numero, '0'))
            ->where('estado', 'iniciada')
            ->where('iniciada_at', '>=', now()->subMinutes(30))
            ->latest('iniciada_at')
            ->first();

        if (! $llamada) {
            // Crea un registro aunque no haya uno iniciado desde el web (llamada externa)
            return response()->json(['ok' => false, 'msg' => 'No se encontró llamada activa en los últimos 30 min'], 404);
        }

        $llamada->update([
            'estado'            => $contesto ? 'contestada' : 'no_contestada',
            'duracion_segundos' => $duracion > 0 ? $duracion : null,
            'completada_at'     => now(),
            'webhook_token'     => null,
        ]);

        return response()->json(['ok' => true, 'estado' => $llamada->estado, 'llamada_id' => $llamada->id]);
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
