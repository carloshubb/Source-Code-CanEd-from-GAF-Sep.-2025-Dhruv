<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class CookieSettingDetailResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'cookie_setting_id' => $this->cookie_setting_id,
            'language_id' => $this->language_id,
            'text' => $this->text,
            'learn_more_text' => $this->learn_more_text,
            'learn_more_link' => $this->learn_more_link,
            'button_text' => $this->button_text
        ];
    }
}
