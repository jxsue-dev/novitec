<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Services\GrokService;
use App\Support\IdentityDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ChatController extends Controller
{
    private const MAX_MESSAGES     = 150;
    private const CONTEXT_MESSAGES = 30;
    private const INACTIVE_DAYS    = 90;

    // Palabras clave que disparan la búsqueda de órdenes
    private const ORDER_KEYWORDS = [
        'orden', 'reparaci', 'equipo', 'estado', 'entrega', 'serie',
        'cedula', 'cédula', 'técnico', 'tecnico', 'sucursal', 'ingreso',
        'mis orden', 'mi orden', 'mi equipo', 'mis equipo',
    ];

    public function __construct(private GrokService $grok) {}

    public function widgetData()
    {
        $this->purgeInactive();

        $conversation = $this->getSingleConversation();
        $messages = $conversation->messages()
            ->where('role', '!=', 'system')
            ->orderBy('created_at')
            ->get(['role', 'content', 'created_at']);

        return response()->json([
            'conversation_id' => $conversation->id,
            'messages'        => $messages,
        ]);
    }

    public function widgetMessage(Request $request)
    {
        $request->validate(['message' => 'required|string|max:4000']);

        $conversation = $this->getSingleConversation();
        $userContent  = $request->input('message');

        $conversation->messages()->create(['role' => 'user', 'content' => $userContent]);

        $history = $conversation->messages()
            ->orderBy('created_at')
            ->latest()
            ->limit(self::CONTEXT_MESSAGES)
            ->get()
            ->sortBy('created_at')
            ->map(fn($m) => ['role' => $m->role, 'content' => $m->content])
            ->values()
            ->toArray();

        // Inyectar contexto de órdenes si el mensaje lo requiere
        $orderContext = $this->buildOrderContext($userContent);

        try {
            $reply = $this->grok->chat($history, $orderContext);
        } catch (\Throwable) {
            $reply = 'Lo siento, ocurrió un error. Por favor intenta de nuevo.';
        }

        $conversation->messages()->create(['role' => 'assistant', 'content' => $reply]);

        $this->pruneMessages($conversation);

        return response()->json(['reply' => $reply]);
    }

    // ── Order context builder ─────────────────────────────────────────────────

    private function buildOrderContext(string $message): string
    {
        $lower = mb_strtolower($message, 'UTF-8');

        $isOrderRelated = collect(self::ORDER_KEYWORDS)
            ->some(fn($k) => str_contains($lower, $k));

        if (! $isOrderRelated) {
            return '';
        }

        $user       = Auth::user();
        $userIdents = $user->orderLookupIdentifications();

        // Detectar si el usuario menciona un número de orden específico
        $mentionedOrderNo = null;
        if (preg_match('/\b([A-Z]{2,4}[-\s]?\d{4,8})\b/i', $message, $m)) {
            $mentionedOrderNo = strtoupper(preg_replace('/\s+/', '-', trim($m[1])));
        }

        // Si menciona una orden específica, verificar propiedad antes de buscar
        if ($mentionedOrderNo) {
            $targetOrder = DB::connection('novitecdb')
                ->table('vista_ordenes')
                ->where('nro_orden', 'like', "%{$mentionedOrderNo}%")
                ->first();

            if ($targetOrder) {
                $targetIdent = IdentityDocument::normalize($targetOrder->identificacion ?? '');
                $belongsToUser = in_array($targetIdent, array_map(
                    fn($i) => IdentityDocument::normalize($i),
                    $userIdents
                ));

                if (! $belongsToUser) {
                    return "[INSTRUCCIÓN OBLIGATORIA DEL SISTEMA]: La orden {$mentionedOrderNo} pertenece a otro cliente. DEBES responder EXACTAMENTE: \"Solo puedo indicarte el estado de tus órdenes de trabajo registradas a tu nombre.\" No des ningún detalle de esa orden.";
                }
            }
        }

        // Obtener todas las órdenes del usuario
        $orders = DB::connection('novitecdb')
            ->table('vista_ordenes')
            ->where(function ($q) use ($userIdents) {
                foreach ($userIdents as $ident) {
                    $q->orWhere('identificacion', $ident);
                }
            })
            ->orderByDesc('fecha_de_ingreso')
            ->limit(15)
            ->get();

        if ($orders->isEmpty()) {
            return "[DATOS DEL SISTEMA]: El usuario (CI: {$user->cedula}) no tiene órdenes de trabajo registradas en el sistema.";
        }

        $lines = $orders->map(fn($o) =>
            "• Orden: {$o->nro_orden}"
            . " | Equipo: {$o->tipo} {$o->marca} {$o->modelo}"
            . " | Estado: {$o->estado_orden}"
            . ($o->tecnico        ? " | Técnico: {$o->tecnico}"        : '')
            . ($o->sucursal       ? " | Sucursal: {$o->sucursal}"      : '')
            . ($o->fecha_de_ingreso_fmt ? " | Ingreso: {$o->fecha_de_ingreso_fmt}" : '')
            . ($o->estado_garantia ? " | Garantía: {$o->estado_garantia}" : '')
        )->implode("\n");

        return "[DATOS DEL SISTEMA - ÓRDENES DE {$user->cedula}]:\n{$lines}\n\nUSO: Responde consultas de órdenes ÚNICAMENTE con estos datos. No inventes información.";
    }

    // ── Helpers ───────────────────────────────────────────────────────────────

    private function getSingleConversation(): Conversation
    {
        $conv = Auth::user()->conversations()->first();
        if (! $conv) {
            $conv = Auth::user()->conversations()->create(['title' => 'Chat']);
        }
        return $conv;
    }

    private function pruneMessages(Conversation $conversation): void
    {
        $total = $conversation->messages()->count();
        if ($total <= self::MAX_MESSAGES) return;

        $idsToDelete = $conversation->messages()
            ->orderBy('created_at')
            ->limit($total - self::MAX_MESSAGES)
            ->pluck('id');

        $conversation->messages()->whereIn('id', $idsToDelete)->delete();
    }

    private function purgeInactive(): void
    {
        $cutoff = now()->subDays(self::INACTIVE_DAYS);
        Auth::user()->conversations()->where('updated_at', '<', $cutoff)->delete();
    }
}
