<?php

namespace Musonza\Chat\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MessageResource extends JsonResource
{
    public function toArray($request)
    {
        $sender = $this->sender;
        
        $reactions = $this->reactions->groupBy('reaction')->map(function ($items, $emoji) {
            return [
                'emoji' => $emoji,
                'count' => $items->count(),
                'participantIds' => $items->pluck('messageable_id')->map(function($id) { return (string) $id; })->values()->all(),
            ];
        })->values()->all();

        return [
            'id' => (string) $this->id,
            'senderId' => $sender ? (string) $sender->id : null,
            'text' => $this->body,
            'sentAt' => $this->created_at ? $this->created_at->toIso8601String() : null,
            'isEdited' => (bool) $this->is_edited,
            'isForwarded' => (bool) $this->is_forwarded,
            'isPinned' => (bool) $this->is_pinned,
            'replyTo' => $this->reply_to_id ? (string) $this->reply_to_id : null,
            'reactions' => $reactions,
            'attachments' => $this->attachments ?? [],
        ];
    }
}
