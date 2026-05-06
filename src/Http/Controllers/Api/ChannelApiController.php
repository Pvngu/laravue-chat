<?php

namespace Musonza\Chat\Http\Controllers\Api;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Musonza\Chat\Models\Conversation as Channel;
use Musonza\Chat\Http\Resources\ChannelResource;

class ChannelApiController extends Controller
{
    public function index(Request $request)
    {
        // Stub implementation
        $channels = Channel::where('private', false)->paginate(15);
        return response()->json([
            'data' => ChannelResource::collection($channels->items()),
            'next_page_url' => $channels->nextPageUrl(),
        ]);
    }

    public function store(Request $request)
    {
        // Stub implementation
        $channel = new Channel();
        $channel->id = 1;
        return response()->json((new ChannelResource($channel))->resolve());
    }

    public function destroyMemberMe(Channel $channel)
    {
        return response()->json(['success' => true]);
    }

    public function storeMember(Request $request, Channel $channel)
    {
        return response()->json(['success' => true]);
    }

    public function destroyMember(Channel $channel, $user)
    {
        return response()->json(['success' => true]);
    }

    public function favorite(Request $request, Channel $channel)
    {
        return response()->json(['success' => true]);
    }
}
