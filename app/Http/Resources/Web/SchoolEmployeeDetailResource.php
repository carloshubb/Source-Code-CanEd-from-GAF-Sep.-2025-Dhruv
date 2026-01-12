<?php

namespace App\Http\Resources\Web;

use Illuminate\Http\Resources\Json\JsonResource;

class SchoolEmployeeDetailResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'school_employee_id' => $this->school_employee_id,
            'language_code' => $this->language_code,
            'description' => $this->description,
            'name' => $this->name,
        ];
    }
}
