<?php

namespace App\Http\Resources\Web;

use Illuminate\Http\Resources\Json\JsonResource;

class SchoolFinancialResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id ?? null,
            'customer_id' => $this->customer_id ?? null,
            'video_url' => $this->video_url ?? null,
            'school_financials_apply_button_link' => $this->school_financials_apply_button_link ?? null,
            'school_financials_apply_button_title' => $this->school_financials_apply_button_title ?? null,
            'school_financials_red_bar_button_link' => $this->school_financials_red_bar_button_link ?? null,
            'school_financials_red_bar_button_title' => $this->school_financials_red_bar_button_title ?? null,
            'school_financials_blue_bar_button_link' => $this->school_financials_blue_bar_button_link ?? null,
            'school_financials_blue_bar_button_title' => $this->school_financials_blue_bar_button_title ?? null,
            'video_iframe' => $this->video_iframe ?? null,
            'created_at' => isset($this->created_at) ? date('m/d/Y H:i:s', strtotime($this->created_at)) : null,
            'school_financial_detail' => isset($this->schoolFinancialDetail) ? SchoolFinancialDetailResource::collection($this->schoolFinancialDetail) : null,
        ];
    }
}
