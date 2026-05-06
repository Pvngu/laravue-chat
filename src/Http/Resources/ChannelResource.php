<?php

namespace Musonza\Chat\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ChannelResource extends JsonResource
{
    public function toArray($request)
    {
        $user = $request->user();
        
        $members = $this->participants->map(function ($participation) {
            $messageable = $participation->messageable;
            return [
                'id' => $messageable ? $messageable->id : null,
                'name' => $messageable ? ($messageable->name ?? null) : null,
                'avatar' => $messageable ? ($messageable->avatar ?? null) : null,
            ];
        })->values()->all();

        $unreadCount = 0;
        if ($user) {
            $unreadCount = $this->unReadNotifications($user)->count();
        }

        return [
            'id' => $this->id,
            'name' => $this->name,
            'is_private' => (bool) $this->private,
            'description' => $this->data['description'] ?? null,
            'members' => $members,
            'unread_count' => $unreadCount,
        ];
    }
}
