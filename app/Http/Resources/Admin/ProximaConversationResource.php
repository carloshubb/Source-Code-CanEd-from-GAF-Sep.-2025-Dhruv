<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class ProximaConversationResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'customer_id' => $this->customer_id,
            'admin_id' => $this->admin_id,
            'customer' => $this->customer,
            'admin' => $this->admin,

        ];
    }
}
