<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class ContactPageSettingDetailResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'contact_page_setting_id' => $this->contact_page_setting_id,
            'language_id' => $this->language_id,
            'page_title_1' => $this->page_title_1,
            'page_title_2' => $this->page_title_2,
            'name_input_lable' => $this->name_input_lable,
            'name_input_placeholder' => $this->name_input_placeholder,
            'name_input_error' => $this->name_input_error,
            'email_input_lable' => $this->email_input_lable,
            'email_input_placeholder' => $this->email_input_placeholder,
            'email_input_error' => $this->email_input_error,
            'message_input_lable' => $this->message_input_lable,
            'message_input_placeholder' => $this->message_input_placeholder,
            'message_input_error' => $this->message_input_error,
            'button_text' => $this->button_text,
            'website' => $this->website,
            'email' => $this->email,
            'phone' => $this->phone,
            'toll_free' => $this->toll_free,
            'mainling_address' => $this->mainling_address,
            'website_lable' => $this->website_lable,
            'email_lable' => $this->email_lable,
            'phone_lable' => $this->phone_lable,
            'toll_free_lable' => $this->toll_free_lable,
            'mainling_address_lable' => $this->mainling_address_lable,
            'description' => $this->description,
            'contact_page_setting' => new ContactPageSettingResource($this->whenLoaded('contactPageSetting')),
            'language' => new LanguageResource($this->whenLoaded('language')),
        ];
    }
}
