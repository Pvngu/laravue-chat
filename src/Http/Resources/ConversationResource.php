<?php

namespace Musonza\Chat\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ConversationResource extends JsonResource
{
    public function toArray($request)
    {
        $user = $request->user();
        
        $participants = $this->participants->map(function ($participation) {
            $messageable = $participation->messageable;
            return [
                'id' => $messageable ? $messageable->id : null,
                'name' => $messageable ? ($messageable->name ?? null) : null,
                'avatar' => $messageable ? ($messageable->avatar ?? null) : null,
            ];
        })->values()->all();

        $lastMessage = null;
        if ($this->last_message) {
            $sender = $this->last_message->sender;
            $lastMessage = [
                'body' => $this->last_message->body,
                'created_at' => $this->last_message->created_at ? $this->last_message->created_at->toIso8601String() : null,
                'sender' => $sender ? [
                    'id' => $sender->id,
                    'name' => $sender->name ?? null,
                ] : null,
            ];
        }

        $unreadCount = 0;
        if ($user) {
            $unreadCount = $this->unReadNotifications($user)->count();
        }

        return [
            'id' => $this->id,
            'is_direct' => (bool) $this->direct_message,
            'is_private' => (bool) $this->private,
            'data' => [
                'title' => $this->data['title'] ?? null,
                'description' => $this->data['description'] ?? null,
            ],
            'participants' => $participants,
            'last_message' => $lastMessage,
            'unread_count' => $unreadCount,
        ];
    }
}
