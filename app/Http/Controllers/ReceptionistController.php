<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReceptionistController extends Controller
{
    public function aiChat(Request $request)
    {
        $request->validate([
            'message'       => 'required|string|max:2000',
            'order_context' => 'nullable|string|max:4000',
            'history'       => 'nullable|array|max:20',
        ]);

        $systemPrompt = <<<PROMPT
Eres un asistente de apoyo para RECEPCIONISTAS de Novitec (empresa ecuatoriana de servicio técnico).
Las recepcionistas NO tienen conocimiento técnico. Tu misión es ayudarlas a entender y comunicar el estado de los equipos.

PUEDES AYUDAR CON:
- Explicar términos técnicos en lenguaje simple (sin jerga)
- Decirles cómo informar al cliente sobre el estado de su equipo
- Explicar qué significa el trabajo que realizó el técnico
- Sugerir respuestas amables para dar al cliente
- Interpretar el diagnóstico o informe técnico
- Explicar estados: "En Revisión", "En Reparación", "Esperando Repuesto", "Finalizada", "Entregada"
- Responder preguntas sobre tiempos, garantías o procesos de Novitec

NO PUEDES:
- Dar información de otras empresas
- Comprometerte con precios o fechas exactas sin autorización del técnico
- Modificar órdenes o datos del sistema

TONO: Amigable, claro, sin tecnicismos. Si hay términos técnicos, explícalos con analogías simples.
Responde siempre en español ecuatoriano.
PROMPT;

        $messages = [];

        // Inyectar contexto de orden si se proporcionó
        if ($request->filled('order_context')) {
            $messages[] = [
                'role'    => 'user',
                'content' => '[CONTEXTO DE LA ORDEN]\n' . $request->order_context,
            ];
            $messages[] = [
                'role'    => 'assistant',
                'content' => 'Entendido. Tengo el contexto de esta orden. ¿En qué te puedo ayudar?',
            ];
        }

        // Historial de la conversación actual
        if ($request->filled('history')) {
            foreach ($request->history as $msg) {
                if (isset($msg['role'], $msg['content']) && in_array($msg['role'], ['user', 'assistant'])) {
                    $messages[] = ['role' => $msg['role'], 'content' => (string)$msg['content']];
                }
            }
        }

        $messages[] = ['role' => 'user', 'content' => $request->message];

        try {
            $grok = app(\App\Services\GrokService::class);
            $reply = $grok->chat($messages, '', $systemPrompt);
        } catch (\Throwable) {
            $reply = 'Lo siento, hubo un error al consultar el asistente. Intenta de nuevo.';
        }

        return response()->json(['reply' => $reply]);
    }

    public function fotoInforme(int $fotoId)
    {
        $foto = DB::connection('novitecdb')
            ->table('informefotos')
            ->where('id', $fotoId)
            ->select('foto_data', 'tipo_mime', 'nombre_archivo')
            ->first();

        abort_if(!$foto || !$foto->foto_data, 404);

        return response($foto->foto_data)
            ->header('Content-Type', $foto->tipo_mime ?: 'image/jpeg')
            ->header('Cache-Control', 'public, max-age=3600');
    }

    public function index(Request $request)
    {
        $user    = Auth::user();
        $results = null;
        $error   = null;

        // Admin puede elegir sucursal; recepcionista solo la suya
        if ($user->is_admin) {
            $branchCode  = $request->input('branch', 'UIO');
        } else {
            $branchCode  = $user->branch_code;
        }

        $branchName  = User::BRANCHES[$branchCode]  ?? 'NOVITEC';
        $orderPrefix = User::BRANCH_ORDER_PREFIX[$branchCode] ?? '';

        $q    = trim($request->input('q', ''));
        $tipo = $request->input('tipo', 'nro_orden');

        if ($q !== '') {
            try {
                $query = DB::connection('novitecdb')->table('vista_ordenes');

                // Filtro de sucursal SIEMPRE aplicado
                if ($orderPrefix) {
                    $query->where('nro_orden', 'like', $orderPrefix . '%');
                }

                // Filtro de búsqueda adicional
                if ($tipo === 'nro_orden') {
                    $query->where('nro_orden', 'like', '%' . $q . '%');
                } elseif ($tipo === 'serie') {
                    $query->where('serie', 'like', '%' . $q . '%');
                } elseif ($tipo === 'identificacion') {
                    $query->where('identificacion', 'like', '%' . $q . '%');
                }

                $results = $query->orderByDesc('fecha_de_ingreso')->limit(30)->get();

                if ($results->isEmpty()) {
                    $error = 'No se encontraron órdenes en ' . $branchName . ' con ese criterio.';
                } else {
                    $ordenIds = $results->pluck('orden_id')->filter()->values()->toArray();

                    // Resolver nombres de "ingresado_por" (IDs → nombres)
                    $ingresadoPorIds = $results->pluck('ingresado_por')
                        ->filter(fn($v) => is_numeric($v) && $v > 0)
                        ->unique()->values()->toArray();

                    $usuariosMap = collect();
                    if (!empty($ingresadoPorIds)) {
                        $usuariosMap = DB::connection('novitecdb')
                            ->table('usuarios')
                            ->whereIn('id', $ingresadoPorIds)
                            ->pluck('nombre_tecnico', 'id'); // id => nombre_tecnico
                    }

                    // Mutamos la colección para resolver el nombre
                    $results = $results->map(function ($r) use ($usuariosMap) {
                        if (is_numeric($r->ingresado_por) && $r->ingresado_por > 0) {
                            $r->ingresado_por = $usuariosMap->get($r->ingresado_por, "ID {$r->ingresado_por}");
                        }
                        return $r;
                    });

                    // Cargar informes por orden_id
                    if (!empty($ordenIds)) {
                        $informes = DB::connection('novitecdb')
                            ->table('informes')
                            ->whereIn('orden_id', $ordenIds)
                            ->get()
                            ->keyBy('orden_id');

                        $informeFotos = DB::connection('novitecdb')
                            ->table('informefotos')
                            ->whereIn('informe_id', $informes->pluck('id')->toArray())
                            ->select('id', 'informe_id', 'caption', 'nombre_archivo', 'tipo_mime', 'orden_foto')
                            ->orderBy('orden_foto')
                            ->get()
                            ->groupBy('informe_id');
                    }
                }
            } catch (\Throwable) {
                $error = 'Error al consultar las órdenes. Intenta de nuevo.';
            }
        }

        return view('recepcion.ordenes', [
            'results'      => $results,
            'error'        => $error,
            'q'            => $q,
            'tipo'         => $tipo,
            'branchCode'   => $branchCode,
            'branchName'   => $branchName,
            'orderPrefix'  => $orderPrefix,
            'branches'     => User::BRANCHES,
            'user'         => $user,
            'informes'     => $informes ?? collect(),
            'informeFotos' => $informeFotos ?? collect(),
        ]);
    }
}
