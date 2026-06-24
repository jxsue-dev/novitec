<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Services\GrokService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ChatController extends Controller
{
    private const MAX_MESSAGES     = 150;  // máx mensajes por conversación
    private const CONTEXT_MESSAGES = 30;   // mensajes enviados al AI
    private const INACTIVE_DAYS    = 90;   // días sin uso para purgar

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

        // Solo los últimos N mensajes como contexto para el AI
        $history = $conversation->messages()
            ->orderBy('created_at')
            ->latest()
            ->limit(self::CONTEXT_MESSAGES)
            ->get()
            ->sortBy('created_at')
            ->map(fn($m) => ['role' => $m->role, 'content' => $m->content])
            ->values()
            ->toArray();

        try {
            $reply = $this->grok->chat($history);
        } catch (\Throwable) {
            $reply = 'Lo siento, ocurrió un error. Por favor intenta de nuevo.';
        }

        $conversation->messages()->create(['role' => 'assistant', 'content' => $reply]);

        // Podar mensajes viejos si supera el límite
        $this->pruneMessages($conversation);

        return response()->json(['reply' => $reply]);
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
        if ($total <= self::MAX_MESSAGES) {
            return;
        }

        $deleteCount = $total - self::MAX_MESSAGES;
        $idsToDelete = $conversation->messages()
            ->orderBy('created_at')
            ->limit($deleteCount)
            ->pluck('id');

        $conversation->messages()->whereIn('id', $idsToDelete)->delete();
    }

    private function purgeInactive(): void
    {
        // Elimina conversaciones del usuario actual sin actividad en X días
        $cutoff = now()->subDays(self::INACTIVE_DAYS);
        Auth::user()
            ->conversations()
            ->where('updated_at', '<', $cutoff)
            ->delete();
    }
}
