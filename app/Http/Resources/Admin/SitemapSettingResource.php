<?php

namespace App\Http\Resources\Admin;

use App\Models\SitemapSettingMenu;
use Illuminate\Http\Resources\Json\JsonResource;

class SitemapSettingResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'created_at' => date('m/d/Y H:i:s', strtotime($this->created_at)),
            'sitemap_setting_detail' => SitemapSettingDetailResource::collection($this->whenLoaded('sitemapSettingDetail')),
            'menu_1' => SitemapSettingMenu::with('menu','menu.menuDetail')->where('section','section_1')->get(),
            'menu_2' => SitemapSettingMenu::with('menu','menu.menuDetail')->where('section','section_2')->get(),
            'menu_3' => SitemapSettingMenu::with('menu','menu.menuDetail')->where('section','section_3')->get(),
            'menu_4' => SitemapSettingMenu::with('menu','menu.menuDetail')->where('section','section_4')->get(),
        ];
    }
}
