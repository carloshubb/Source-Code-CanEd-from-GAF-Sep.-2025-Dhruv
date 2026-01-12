<?php

namespace App\Http\Resources\Web;

use App\Http\Resources\Admin\MediaResource;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomerMediaResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'customer_id' => $this->customer_id,
            'logo' => $this->logo,
            'image_1' => $this->image_1,
            'image_2' => $this->image_2,
            'image_3' => $this->image_3,
            'image_4' => $this->image_4,
            'video' => $this->video,
            'customer_logo' => new MediaResource($this->whenLoaded('customerLogo')),
            'customer_image1' => new MediaResource($this->whenLoaded('customerImage1')),
            'customer_image2' => new MediaResource($this->whenLoaded('customerImage2')),
            'customer_image3' => new MediaResource($this->whenLoaded('customerImage3')),
            'customer_image4' => new MediaResource($this->whenLoaded('customerImage4')),
        ];
    }
}
