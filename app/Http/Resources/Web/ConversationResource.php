<?php

namespace App\Http\Resources\Web;

use Illuminate\Http\Resources\Json\JsonResource;

class ConversationResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'customer_id' => $this->customer_id,
            'school_ambassador_id' => $this->school_ambassador_id,
            'customer' => $this->customer,
            'school_ambassador' => $this->school_ambassador,

        ];
    }
}
