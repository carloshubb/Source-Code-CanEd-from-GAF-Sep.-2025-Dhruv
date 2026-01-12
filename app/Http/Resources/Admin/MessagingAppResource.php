<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class MessagingAppResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'created_at' => date('m/d/Y H:i:s', strtotime($this->created_at)),
            'messaging_app_detail' => MessagingAppDetailResource::collection($this->whenLoaded('messagingAppDetail')),
        ];
    }
}
