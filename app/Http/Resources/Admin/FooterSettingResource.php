<?php

namespace App\Http\Resources\Admin;

use App\Models\FooterSettingMenu;
use Illuminate\Http\Resources\Json\JsonResource;

class FooterSettingResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'created_at' => date('m/d/Y H:i:s', strtotime($this->created_at)),
            'facebook_icon' => $this->facebook_icon,
            'twitter_icon' => $this->twitter_icon,
            'insta_icon' => $this->insta_icon,
            'linkedin_icon' => $this->linkedin_icon,
            'youtube_icon' => $this->youtube_icon,
            'facebook_url' => $this->facebook_url,
            'twitter_url' => $this->twitter_url,
            'insta_url' => $this->insta_url,
            'linkedin_url' => $this->linkedin_url,
            'youtube_url' => $this->youtube_url,
            'menu1' => $this->menu1,
            'menu2' => $this->menu2,
            'menu3' => $this->menu3,
            'menu4' => $this->menu4,
            'footer_setting_detail' => FooterSettingDetailResource::collection($this->whenLoaded('footerSettingDetail')),
            
        ];
    }
}
