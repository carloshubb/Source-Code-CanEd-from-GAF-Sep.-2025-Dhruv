<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'profile_photo_path' => 'https://ui-avatars.com/api/?name=' . $this->name . '&color=7F9CF5&background=EBF4FF',
        ];
    }
}
