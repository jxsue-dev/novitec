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

    // ── Recibe resultado desde MacroDroid (sin auth de sesión, usa token)
    public function webhook(Request $request, string $token)
    {
        $llamada = Llamada::where('webhook_token', $token)
            ->where('estado', 'iniciada')
            ->first();

        if (! $llamada) {
            return response()->json(['ok' => false, 'msg' => 'Llamada no encontrada o ya registrada'], 404);
        }

        $duracion  = (int) $request->input('duracion', 0); // segundos
        $contesto  = filter_var($request->input('contesto', false), FILTER_VALIDATE_BOOLEAN);

        $llamada->update([
            'estado'              => $contesto ? 'contestada' : 'no_contestada',
            'duracion_segundos'   => $duracion > 0 ? $duracion : null,
            'completada_at'       => now(),
            'webhook_token'       => null, // invalidar token usado
        ]);

        return response()->json(['ok' => true, 'estado' => $llamada->estado]);
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
