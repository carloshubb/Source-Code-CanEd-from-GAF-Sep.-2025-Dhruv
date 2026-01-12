<?php

namespace App\Http\Resources\Web;

use App\Http\Resources\Admin\DegreeResource;
use App\Http\Resources\Admin\ProgramResource;
use Illuminate\Http\Resources\Json\JsonResource;

class SchoolContactSettingDetailResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'main_paragraph' => $this->main_paragraph,
            'brief_description' => $this->brief_description,
            'language_code' => $this->language_code,
        ];
    }
}
