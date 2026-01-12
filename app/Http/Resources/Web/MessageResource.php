<?php

namespace App\Http\Resources\Web;

use Illuminate\Http\Resources\Json\JsonResource;

class MessageResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'type' => $this->message_by,
            'message' => $this->content,
            'conversation' => new ConversationResource($this->whenLoaded('conversation')),
            'created_at' => $this->created_at->diffForHumans()
        ];
    }
}
