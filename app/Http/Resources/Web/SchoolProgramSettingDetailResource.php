<?php

namespace App\Http\Resources\Web;

use App\Http\Resources\Admin\DegreeResource;
use App\Http\Resources\Admin\ProgramResource;
use Illuminate\Http\Resources\Json\JsonResource;

class SchoolProgramSettingDetailResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title_1' => $this->title_1,
            'title_1_paragraph' => $this->title_1_paragraph,
            'language_code' => $this->language_code,
        ];
    }
}
