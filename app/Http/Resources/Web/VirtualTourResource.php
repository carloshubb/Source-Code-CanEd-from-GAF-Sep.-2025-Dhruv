<?php

namespace App\Http\Resources\Web;

use Illuminate\Http\Resources\Json\JsonResource;

class VirtualTourResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'link' => $this->link,
            'date' => $this->deadline_date ? $this->deadline_date->format('Y-m-d') : null,
            'color' => $this->color,
            'image' => $this->image,
            'status' => $this->status,
            'virtual_tour_detail'=> $this->virtualTourDetail,
            'created_at' => date('m/d/Y H:i:s', strtotime($this->created_at)),
        ];
    }
}
