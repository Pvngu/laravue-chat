<?php

namespace Musonza\Chat\Http\Controllers\Api;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Musonza\Chat\Models\Conversation;
use Musonza\Chat\Http\Resources\ConversationResource;
use Musonza\Chat\Http\Resources\MessageResource;

class ConversationApiController extends Controller
{
    public function index(Request $request)
    {
        // Stub implementation
        $conversations = Conversation::paginate(15);
        return response()->json([
            'data' => ConversationResource::collection($conversations->items()),
            'next_page_url' => $conversations->nextPageUrl(),
        ]);
    }

    public function store(Request $request)
    {
        // Stub implementation
        $conversation = new Conversation();
        $conversation->id = 1;
        return response()->json((new ConversationResource($conversation))->resolve());
    }

    public function messages(Request $request, Conversation $conversation)
    {
        // Stub implementation
        $messages = $conversation->messages()->paginate(15);
        return response()->json([
            'data' => MessageResource::collection($messages->items()),
            'next_page_url' => $messages->nextPageUrl(),
        ]);
    }

    public function storeMessage(Request $request, Conversation $conversation)
    {
        // Stub implementation
        $message = new \Musonza\Chat\Models\Message();
        $message->id = 101;
        return response()->json((new MessageResource($message))->resolve());
    }

    public function read(Conversation $conversation)
    {
        return response()->json(['success' => true]);
    }

    public function pin(Request $request, Conversation $conversation)
    {
        return response()->json(['success' => true]);
    }

    public function favorite(Request $request, Conversation $conversation)
    {
        return response()->json(['success' => true]);
    }

    public function archive(Conversation $conversation)
    {
        return response()->json(['success' => true]);
    }

    public function storeParticipant(Request $request, Conversation $conversation)
    {
        return response()->json(['success' => true]);
    }

    public function destroyParticipant(Conversation $conversation, $user)
    {
        return response()->json(['success' => true]);
    }
}
