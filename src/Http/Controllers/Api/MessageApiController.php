<?php

namespace Musonza\Chat\Http\Controllers\Api;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Musonza\Chat\Models\Message;
use Musonza\Chat\Http\Resources\MessageResource;

class MessageApiController extends Controller
{
    public function update(Request $request, Message $message)
    {
        // Stub implementation
        return response()->json((new MessageResource($message))->resolve());
    }

    public function destroy(Message $message)
    {
        return response()->json(['success' => true]);
    }

    public function storeReaction(Request $request, Message $message)
    {
        return response()->json(['success' => true]);
    }

    public function destroyReaction(Message $message, $emoji)
    {
        return response()->json(['success' => true]);
    }

    public function pin(Request $request, Message $message)
    {
        return response()->json(['success' => true]);
    }
}
