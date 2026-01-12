<?php

namespace App\Http\Resources\Web;

use Illuminate\Http\Resources\Json\JsonResource;

class AmbassadorMessagingAppResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'ambassador_id' => $this->ambassador_id,
            'messaging_app_id' => $this->messaging_app_id,
            'username' => $this->username,
            
        ];
    }
}
