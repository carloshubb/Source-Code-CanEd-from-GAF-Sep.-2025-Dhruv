<?php

namespace App\Http\Resources\Web;

use App\Http\Resources\Admin\DegreeResource;
use App\Http\Resources\Admin\ProgramResource;
use Illuminate\Http\Resources\Json\JsonResource;

class SchoolProgramSettingResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'customer_id' => $this->customer_id,
            'school_program_apply_button_link' => $this->school_program_apply_button_link,
            'school_program_apply_button_title' => $this->school_program_apply_button_title,
            'school_program_blue_bar_button_title' => $this->school_program_blue_bar_button_title,
            'school_program_blue_bar_button_link' => $this->school_program_blue_bar_button_link,
            'school_program_red_bar_button_title' => $this->school_program_red_bar_button_title,
            'school_program_red_bar_button_link' => $this->school_program_red_bar_button_link,
            'created_at' => date('m/d/Y H:i:s', strtotime($this->created_at)),
            'school_program_setting_detail' => SchoolProgramSettingDetailResource::collection($this->schoolProgramSettingDetail),
        ];
    }
}
