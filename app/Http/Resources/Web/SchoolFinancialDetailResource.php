<?php

namespace App\Http\Resources\Web;

use App\Http\Resources\Admin\DegreeResource;
use App\Http\Resources\Admin\ProgramResource;
use Illuminate\Http\Resources\Json\JsonResource;

class SchoolFinancialDetailResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'tabs_pre_description' => $this->tabs_pre_description,
            'tabs_post_description' => $this->tabs_post_description,
            'tab1_name' => $this->tab1_name,
            'tab2_name' => $this->tab2_name,
            'tab3_name' => $this->tab3_name,
            'tab1_description' => $this->tab1_description,
            'tab2_description' => $this->tab2_description,
            'tab3_description' => $this->tab3_description,
            'scholarship_pre_description' => $this->scholarship_pre_description,
            'scholarship_post_description' => $this->scholarship_post_description,
            'programs_pre_description' => $this->programs_pre_description,
            'programs_post_description' => $this->programs_post_description,
            'faq_pre_description' => $this->faq_pre_description,
            'faq_post_description' => $this->faq_post_description,
            'language_code' => $this->language_code,
        ];
    }
}
