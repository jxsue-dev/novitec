<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReceptionistController extends Controller
{
    public function dashboard(Request $request)
    {
        $user        = Auth::user();
        $branchCode  = $user->is_admin ? $request->input('branch', 'UIO') : $user->branch_code;
        $branchName  = User::BRANCHES[$branchCode] ?? 'NOVITEC';
        $orderPrefix = User::BRANCH_ORDER_PREFIX[$branchCode] ?? '';

        $tab     = $request->input('tab', 'listas');
        $buscar  = trim($request->input('q', ''));
        $fecha   = $request->input('fecha', now()->format('Y-m-d'));
        $tecnico = trim($request->input('tecnico', ''));

        $fechaValida     = "fecha_prometido REGEXP '^[0-9]{4}-[0-9]{2}-[0-9]{2}'";
        $estadosActivos  = ['En Revisión', 'En Reparacion', 'Esperando Repuesto'];
        $estadosCerrados = ['Finalizada', 'Entregada', 'Anulada', 'Nota de Credito'];

        $base = DB::connection('novitecdb')->table('vista_ordenes');
        if ($orderPrefix) {
            $base = $base->where('nro_orden', 'like', $orderPrefix . '%');
        }

        // ── Stats (siempre) ───────────────────────────────────────────────
        $stats = [
            'listas'    => (clone $base)->where('estado_orden', 'Finalizada')->count(),
            'atrasadas' => (clone $base)->whereRaw($fechaValida)->whereRaw("DATE(fecha_prometido) < CURDATE()")->whereNotIn('estado_orden', $estadosCerrados)->count(),
            'hoy'       => (clone $base)->whereRaw("DATE(fecha_de_ingreso) = CURDATE()")->count(),
            'proceso'   => (clone $base)->whereIn('estado_orden', $estadosActivos)->count(),
        ];

        // Helper: aplicar filtros comunes de búsqueda y técnico
        $applyFilters = function ($q) use ($buscar, $tecnico) {
            if ($buscar) {
                $q->where(function ($sub) use ($buscar) {
                    $sub->where('nro_orden', 'like', "%{$buscar}%")
                        ->orWhere('nombres', 'like', "%{$buscar}%")
                        ->orWhere('apellidos', 'like', "%{$buscar}%")
                        ->orWhere('cliente', 'like', "%{$buscar}%")
                        ->orWhere('serie', 'like', "%{$buscar}%");
                });
            }
            if ($tecnico) {
                $q->where('tecnico', 'like', "%{$tecnico}%");
            }
            return $q;
        };

        $cols = ['nro_orden','nombres','apellidos','cliente','tipo','marca','modelo','estado_orden','tecnico','serie','numero_contacto','fecha_de_ingreso_fmt','fecha_prometido_fmt'];

        $listas = $atrasadas = $ingresadas = $porEstado = null;

        switch ($tab) {
            case 'listas':
                $q = $applyFilters(clone $base)->where('estado_orden', 'Finalizada')->orderBy('fecha_de_ingreso', 'desc');
                $listas = $q->paginate(12, $cols)->withQueryString();
                break;

            case 'atrasadas':
                $q = $applyFilters(clone $base)->whereRaw($fechaValida)->whereRaw("DATE(fecha_prometido) < CURDATE()")->whereNotIn('estado_orden', $estadosCerrados)->orderBy('fecha_prometido', 'asc');
                $atrasadas = $q->paginate(12, $cols)->withQueryString();
                break;

            case 'hoy':
                $q = $applyFilters(clone $base)->whereRaw("DATE(fecha_de_ingreso) = ?", [$fecha])->orderBy('fecha_de_ingreso', 'desc');
                $ingresadas = $q->paginate(12, $cols)->withQueryString();
                break;

            case 'resumen':
                $porEstado = (clone $base)->select('estado_orden', DB::raw('count(*) as total'))->groupBy('estado_orden')->orderBy('total', 'desc')->get();
                break;

            case 'preordenes':
                $preordenes = DB::connection('novitecdb')->table('preordenes')
                    ->when($orderPrefix, fn($q) => $q->where('nro_preorden', 'like', 'PRE-' . $branchCode . '-%'))
                    ->when($buscar, fn($q) => $q->where(function ($s) use ($buscar) {
                        $s->where('nro_preorden', 'like', "%{$buscar}%")
                          ->orWhere('nombres', 'like', "%{$buscar}%")
                          ->orWhere('apellidos', 'like', "%{$buscar}%")
                          ->orWhere('serie', 'like', "%{$buscar}%")
                          ->orWhere('identificacion', 'like', "%{$buscar}%");
                    }))
                    ->orderByDesc('created_at')
                    ->paginate(12)
                    ->withQueryString();
                break;
        }

        // Rango de fechas para ingresadas
        $fechaDesde = $request->input('fecha_desde', $fecha);
        $fechaHasta = $request->input('fecha_hasta', $fecha);
        if ($tab === 'hoy' && $fechaDesde !== $fechaHasta) {
            $q = clone $base;
            if ($buscar) $q->where(fn($s) => $s->where('nro_orden','like',"%{$buscar}%")->orWhere('nombres','like',"%{$buscar}%")->orWhere('cliente','like',"%{$buscar}%"));
            if ($tecnico) $q->where('tecnico','like',"%{$tecnico}%");
            $ingresadas = $q->whereRaw("DATE(fecha_de_ingreso) BETWEEN ? AND ?", [$fechaDesde, $fechaHasta])->orderBy('fecha_de_ingreso','desc')->paginate(12, $cols)->withQueryString();
        }

        return view('recepcion.dashboard', compact(
            'stats', 'listas', 'atrasadas', 'ingresadas', 'porEstado', 'preordenes',
            'branchName', 'branchCode', 'user', 'tab', 'buscar', 'fecha', 'tecnico',
            'fechaDesde', 'fechaHasta'
        ));
    }

    public function historial(Request $request)
    {
        $user        = Auth::user();
        $branchCode  = $user->is_admin ? $request->input('branch', 'UIO') : $user->branch_code;
        $branchName  = User::BRANCHES[$branchCode] ?? 'NOVITEC';
        $orderPrefix = User::BRANCH_ORDER_PREFIX[$branchCode] ?? '';

        $ci     = trim($request->input('ci', ''));
        $nombre = trim($request->input('nombre', ''));
        $orders = null;
        $clienteInfo = null;

        if ($ci || $nombre) {
            $q = DB::connection('novitecdb')->table('vista_ordenes');
            if ($orderPrefix) $q->where('nro_orden', 'like', $orderPrefix . '%');

            if ($ci) {
                $q->where('identificacion', 'like', "%{$ci}%");
            } elseif ($nombre) {
                $q->where(function ($s) use ($nombre) {
                    $s->where('nombres', 'like', "%{$nombre}%")
                      ->orWhere('apellidos', 'like', "%{$nombre}%")
                      ->orWhere('cliente', 'like', "%{$nombre}%");
                });
            }

            $orders = $q->orderByDesc('fecha_de_ingreso')->paginate(15)->withQueryString();

            if ($orders->isNotEmpty()) {
                $first = $orders->first();
                $clienteInfo = [
                    'nombre'         => trim(($first->nombres ?? '') . ' ' . ($first->apellidos ?? '')) ?: ($first->cliente ?? ''),
                    'identificacion' => $first->identificacion ?? '',
                    'contacto'       => $first->numero_contacto ?? '',
                    'correo'         => $first->correo ?? '',
                    'total'          => $orders->total(),
                ];
            }
        }

        return view('recepcion.historial', compact('orders', 'clienteInfo', 'ci', 'nombre', 'branchName', 'branchCode', 'user'));
    }

    public function exportPdf(Request $request)
    {
        $user        = Auth::user();
        $branchCode  = $user->is_admin ? $request->input('branch', 'UIO') : $user->branch_code;
        $branchName  = User::BRANCHES[$branchCode] ?? 'NOVITEC';
        $orderPrefix = User::BRANCH_ORDER_PREFIX[$branchCode] ?? '';
        $tipo        = $request->input('tipo', 'listas');

        $fechaValida     = "fecha_prometido REGEXP '^[0-9]{4}-[0-9]{2}-[0-9]{2}'";
        $estadosCerrados = ['Finalizada', 'Entregada', 'Anulada', 'Nota de Credito'];
        $cols            = ['nro_orden','nombres','apellidos','cliente','tipo','marca','modelo','estado_orden','tecnico','serie','numero_contacto','fecha_de_ingreso_fmt','fecha_prometido_fmt'];

        $base = DB::connection('novitecdb')->table('vista_ordenes');
        if ($orderPrefix) $base->where('nro_orden', 'like', $orderPrefix . '%');

        $rows = match($tipo) {
            'atrasadas' => (clone $base)->whereRaw($fechaValida)->whereRaw("DATE(fecha_prometido) < CURDATE()")->whereNotIn('estado_orden', $estadosCerrados)->orderBy('fecha_prometido')->get($cols),
            'hoy'       => (clone $base)->whereRaw("DATE(fecha_de_ingreso) = CURDATE()")->orderByDesc('fecha_de_ingreso')->get($cols),
            default     => (clone $base)->where('estado_orden', 'Finalizada')->orderBy('fecha_de_ingreso', 'desc')->get($cols),
        };

        $titulo = match($tipo) {
            'atrasadas' => 'Órdenes Atrasadas',
            'hoy'       => 'Ingresadas Hoy — ' . now()->format('d/m/Y'),
            default     => 'Listas para Entregar',
        };

        return view('recepcion.pdf', compact('rows', 'titulo', 'branchName', 'tipo'));
    }

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
                } elseif ($tipo === 'nombre') {
                    $query->where(function ($s) use ($q) {
                        $s->where('nombres', 'like', '%' . $q . '%')
                          ->orWhere('apellidos', 'like', '%' . $q . '%')
                          ->orWhere('cliente', 'like', '%' . $q . '%');
                    });
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
