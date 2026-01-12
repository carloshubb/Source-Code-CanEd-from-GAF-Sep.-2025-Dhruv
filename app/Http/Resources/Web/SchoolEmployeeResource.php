<?php

namespace App\Http\Resources\Web;

use Illuminate\Http\Resources\Json\JsonResource;

class SchoolEmployeeResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'customer_id' => $this->customer_id,
            'position'=> $this->position,
            'telephone'=> $this->telephone,
            'more_1'=> $this->more_1,
            'email'=> $this->email,
            'more_2'=> $this->more_2,
            'order'=> $this->order,
            'image'=> $this->image,
            'school_employee_detail' => SchoolEmployeeDetailResource::collection($this->whenLoaded('schoolEmployeeDetail')),
        ];
    }
}
