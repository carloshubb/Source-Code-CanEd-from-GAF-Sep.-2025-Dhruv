<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\SitemapSettingResource;
use App\Models\SitemapSetting;
use App\Models\SitemapSettingDetail;
use App\Models\SitemapSettingMenu;
use App\Models\MenuDetail;
use App\Traits\StatusResponser;
use Illuminate\Http\Request;

class SitemapSettingController extends Controller
{
    use StatusResponser;

    public function index()
    {
        $sitemapSetting = SitemapSetting::with('sitemapSettingDetail')->first();

        if (!$sitemapSetting) {
            $sitemapSetting = SitemapSetting::create([]);
            $languages = getAllLanguages();
            foreach ($languages as $language) {
                SitemapSettingDetail::create([
                    'sitemap_setting_id' => $sitemapSetting->id,
                    'language_id' => $language->id,
                ]);
            }
            $sitemapSetting = $sitemapSetting->loadMissing('sitemapSettingDetail');
        }

        return $this->successResponse(new SitemapSettingResource($sitemapSetting), 'Data get successfully.');
    }

    public function update(Request $request)
    {

        $validationRule = [];
        $errorMessages = [];
        $languages = getAllLanguages();
        foreach ($languages as $language) {
            $validationRule = array_merge($validationRule, ['section_1_title.section_1_title_' . $language->id => ['required', 'string']]);
            $errorMessages = array_merge($errorMessages, ['section_1_title.section_1_title_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['section_2_title.section_2_title_' . $language->id => ['required', 'string']]);
            $errorMessages = array_merge($errorMessages, ['section_2_title.section_2_title_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['section_3_title.section_3_title_' . $language->id => ['required', 'string']]);
            $errorMessages = array_merge($errorMessages, ['section_3_title.section_3_title_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['section_4_title.section_4_title_' . $language->id => ['required', 'string']]);
            $errorMessages = array_merge($errorMessages, ['section_4_title.section_4_title_' . $language->id . '.required' => 'This field is required.']);

        }
        $this->validate(
            $request,
            $validationRule,
            $errorMessages
        );
        $sitemapSetting = SitemapSetting::firstOrCreate();
        if($sitemapSetting){
            $sitemapSetting->update();
        }else{
            $sitemapSetting = SitemapSetting::create([]);
        }
        
        foreach ($languages as $language) {
            $sitemapSettingDetail = SitemapSettingDetail::whereLanguageId($language->id)->whereSitemapSettingId($sitemapSetting->id)->exists();

            $fields = [
                'section_1_title' => $request['section_1_title']['section_1_title_' . $language->id],
                'section_2_title' => $request['section_2_title']['section_2_title_' . $language->id],
                'section_3_title' => $request['section_3_title']['section_3_title_' . $language->id],
                'section_4_title' => $request['section_4_title']['section_4_title_' . $language->id],
            ];
            if ($sitemapSettingDetail) {
                SitemapSettingDetail::whereLanguageId($language->id)->whereSitemapSettingId($sitemapSetting->id)->update($fields);
            } else {
                $fields = array_merge($fields, ['sitemap_setting_id' => $sitemapSetting->id]);
                $fields = array_merge($fields, ['language_id' => $language->id]);
                SitemapSettingDetail::create($fields);
            }
        }
        SitemapSettingMenu::where('section','section_1')->delete();
        SitemapSettingMenu::where('section','section_2')->delete();
        SitemapSettingMenu::where('section','section_3')->delete();
        SitemapSettingMenu::where('section','section_4')->delete();

        if (isset($request->menu1)) {
            SitemapSettingMenu::where('section', 'section_1')->delete();
            foreach ($request->menu1 as $menu1) {
                SitemapSettingMenu::create([
                    'section' => 'section_1',
                    'menu_id' => $menu1['id']
                ]);
            }
        }

        if (isset($request->menu2)) {
            SitemapSettingMenu::where('section', 'section_2')->delete();
            foreach ($request->menu2 as $menu2) {
                SitemapSettingMenu::create([
                    'section' => 'section_2',
                    'menu_id' => $menu2['id']
                ]);
            }
        }


        if (isset($request->menu3)) {
            SitemapSettingMenu::where('section', 'section_3')->delete();
            foreach ($request->menu3 as $menu3) {
                SitemapSettingMenu::create([
                    'section' => 'section_3',
                    'menu_id' => $menu3['id']
                ]);
            }
        }


        if (isset($request->menu4)) {
            SitemapSettingMenu::where('section', 'section_4')->delete();
            foreach ($request->menu4 as $menu4) {
                SitemapSettingMenu::create([
                    'section' => 'section_4',
                    'menu_id' => $menu4['id']
                ]);
            }
        }

        if ($sitemapSetting) {
            return $this->apiSuccessResponse(new SitemapSettingResource($sitemapSetting), 'Your changes have been done successfully');
        }
        return $this->errorResponse();
    }
}
