<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class HomePageSettingDetailResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'home_page_setting_id' => $this->home_page_setting_id,
            'language_id' => $this->language_id,
            'welcome_title'=>$this->welcome_title,
            'welcome_description'=>$this->welcome_description,
            'welcome_button_text'=>$this->welcome_button_text,
            'welcome_button_link'=>$this->welcome_button_link,
            'welcome_image'=>$this->welcome_image,
            'featured_title'=>$this->featured_title,
            'featured_description'=>$this->featured_description,
            'featured_business_title'=>$this->featured_business_title,
            'featured_business_description'=>$this->featured_business_description,
            'article_section_1_title'=>$this->article_section_1_title,
            'article_section_1_description'=>$this->article_section_1_description,
            'article_section_2_title'=>$this->article_section_2_title,
            'article_section_2_description'=>$this->article_section_2_description,
            'article_section_3_title'=>$this->article_section_3_title,
            'article_section_3_description'=>$this->article_section_3_description,
            'recent_article_title'=>$this->recent_article_title,
            'recent_article_description'=>$this->recent_article_description,
            'article_card_title'=>$this->article_card_title,
            'video_card_title'=>$this->video_card_title,
            'recent_article_image'=>$this->recent_article_image,
            'recent_video_image'=>$this->recent_video_image,
            'home_page_setting' => new HomePageSettingResource($this->whenLoaded('homePageSetting')),
            'language' => new LanguageResource($this->whenLoaded('language')),
        ];
    }
}
