<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Services\GrokService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function __construct(private GrokService $grok) {}

    public function index()
    {
        $conversations = Auth::user()->conversations()->latest()->get();
        $conversation  = $conversations->first();

        if (! $conversation) {
            $conversation = $this->createConversation();
        }

        return redirect()->route('chat.show', $conversation);
    }

    public function show(Conversation $conversation)
    {
        abort_if($conversation->user_id !== Auth::id(), 403);

        $conversations = Auth::user()->conversations()->latest()->get();
        $messages      = $conversation->messages()->where('role', '!=', 'system')->get();

        return view('chat.show', compact('conversation', 'conversations', 'messages'));
    }

    public function store()
    {
        $conversation = $this->createConversation();
        return redirect()->route('chat.show', $conversation);
    }

    public function sendMessage(Request $request, Conversation $conversation)
    {
        abort_if($conversation->user_id !== Auth::id(), 403);

        $request->validate(['message' => 'required|string|max:4000']);

        $userContent = $request->input('message');

        $conversation->messages()->create([
            'role'    => 'user',
            'content' => $userContent,
        ]);

        $history = $conversation->messages()
            ->orderBy('created_at')
            ->get()
            ->map(fn($m) => ['role' => $m->role, 'content' => $m->content])
            ->toArray();

        try {
            $reply = $this->grok->chat($history);
        } catch (\Throwable) {
            $reply = 'Lo siento, ocurrió un error al procesar tu mensaje. Por favor intenta de nuevo.';
        }

        $conversation->messages()->create([
            'role'    => 'assistant',
            'content' => $reply,
        ]);

        if ($conversation->title === 'Nueva conversación' && $conversation->messages()->count() <= 3) {
            $conversation->update(['title' => mb_substr($userContent, 0, 60)]);
        }

        if ($request->expectsJson()) {
            return response()->json(['reply' => $reply]);
        }

        return back();
    }

    public function destroy(Conversation $conversation)
    {
        abort_if($conversation->user_id !== Auth::id(), 403);

        $conversation->delete();

        $next = Auth::user()->conversations()->latest()->first();
        if ($next) {
            return redirect()->route('chat.show', $next);
        }

        return redirect()->route('chat.new');
    }

    private function createConversation(): Conversation
    {
        return Auth::user()->conversations()->create(['title' => 'Nueva conversación']);
    }
}
