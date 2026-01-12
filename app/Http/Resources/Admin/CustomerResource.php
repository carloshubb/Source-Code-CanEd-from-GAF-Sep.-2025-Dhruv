<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'display_name' => $this->display_name,
            'image' => $this->image,
            'user_type' => $this->user_type,
            'dob' => $this->dob,
            'gender' => $this->gender,
            'martial_status' => $this->martial_status,
            'messagingAppDetail_id' => $this->messagingAppDetail_id,
            'city' => $this->city,
            'country' => $this->country,
            'province' => $this->province,
            'postal_code' => $this->postal_code,
            'home_phone' => $this->home_phone,
            'mobile_phone' => $this->mobile_phone,
            'deactive_account' => $this->deactive_account,
        ];
    }
}
