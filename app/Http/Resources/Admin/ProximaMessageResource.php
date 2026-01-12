<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class ProximaMessageResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'type' => $this->message_by,
            'message' => $this->content,
            'conversation' => new ProximaConversationResource($this->whenLoaded('conversation')),
            'created_at' => $this->created_at->diffForHumans()
        ];
    }
}
