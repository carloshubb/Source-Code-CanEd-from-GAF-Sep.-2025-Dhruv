<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class ProximaRequestResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'inquiry' => $this->inquiry,
            'customer_id' => $this->customer_id,
            'customer' => $this->customer,
            'status' => $this->status,
            'quotation_amount' => $this->quotation_amount,
            'quotation_detail' => $this->quotation_detail,
        ];
    }
}
