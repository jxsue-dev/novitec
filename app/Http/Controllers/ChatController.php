<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Services\GrokService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function __construct(private GrokService $grok) {}

    // ── Widget endpoints ──────────────────────────────────────────────────────

    public function widgetData()
    {
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
            ->get()
            ->map(fn($m) => ['role' => $m->role, 'content' => $m->content])
            ->toArray();

        try {
            $reply = $this->grok->chat($history);
        } catch (\Throwable) {
            $reply = 'Lo siento, ocurrió un error. Por favor intenta de nuevo.';
        }

        $conversation->messages()->create(['role' => 'assistant', 'content' => $reply]);

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
}
