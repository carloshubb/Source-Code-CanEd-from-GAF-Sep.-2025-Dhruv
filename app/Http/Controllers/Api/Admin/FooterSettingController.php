<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\FooterSettingResource;
use App\Models\FooterSetting;
use App\Models\FooterSettingDetail;
use App\Models\FooterSettingMenu;
use App\Models\MenuDetail;
use App\Rules\ValidUrl;
use App\Traits\StatusResponser;
use Illuminate\Http\Request;

class FooterSettingController extends Controller
{
    use StatusResponser;

    public function index()
    {
        $footerSetting = FooterSetting::with('footerSettingDetail')->first();

        if (!$footerSetting) {
            $footerSetting = FooterSetting::create([]);
            $languages = getAllLanguages();
            foreach ($languages as $language) {
                FooterSettingDetail::create([
                    'footer_setting_id' => $footerSetting->id,
                    'language_id' => $language->id,
                ]);
            }
            $footerSetting = $footerSetting->loadMissing('footerSettingDetail');
        }

        return $this->successResponse(new FooterSettingResource($footerSetting), 'Data get successfully.');
    }

    public function update(Request $request)
    {

        $validationRule = [];
        $errorMessages = [];
        $languages = getAllLanguages();
        foreach ($languages as $language) {
            $requiredVal = 'nullable';
            if ($language->is_default == '1') {
                $requiredVal = 'required';
            }
            $validationRule = array_merge($validationRule, ['section_1_title.section_1_title_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['section_1_title.section_1_title_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['section_2_title.section_2_title_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['section_2_title.section_2_title_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['section_3_title.section_3_title_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['section_3_title.section_3_title_' . $language->id . '.required' => 'This field is required.']);
            // first name
            $validationRule = array_merge($validationRule, ['copy_right_text.copy_right_text_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['copy_right_text.copy_right_text_' . $language->id . '.required' => 'This field is required.']);
        }

        $validationRule = array_merge($validationRule, ['facebook_icon' => ['required', 'string']]);
        $errorMessages = array_merge($errorMessages, ['facebook_icon.required' => 'This field is required.']);

        $validationRule = array_merge($validationRule, ['twitter_icon' => ['required', 'string']]);
        $errorMessages = array_merge($errorMessages, ['twitter_icon.required' => 'This field is required.']);

        // last name
        $validationRule = array_merge($validationRule, ['insta_icon' => ['required', 'string']]);
        $errorMessages = array_merge($errorMessages, ['insta_icon.required' => 'This field is required.']);

        $validationRule = array_merge($validationRule, ['linkedin_icon' => ['required', 'string']]);
        $errorMessages = array_merge($errorMessages, ['linkedin_icon.required' => 'This field is required.']);

        $validationRule = array_merge($validationRule, ['youtube_icon' => ['required', 'string']]);
        $errorMessages = array_merge($errorMessages, ['youtube_icon.required' => 'This field is required.']);


        //password
        $validationRule = array_merge($validationRule, ['facebook_url' => ['required', 'string', new ValidUrl()]]);
        $errorMessages = array_merge($errorMessages, ['facebook_url.required' => 'This field is required.']);

        $validationRule = array_merge($validationRule, ['twitter_url' => ['required', 'string', new ValidUrl()]]);
        $errorMessages = array_merge($errorMessages, ['twitter_url.required' => 'This field is required.']);

        $validationRule = array_merge($validationRule, ['insta_url' => ['required', 'string', new ValidUrl()]]);
        $errorMessages = array_merge($errorMessages, ['insta_url.required' => 'This field is required.']);

        //confirm password
        $validationRule = array_merge($validationRule, ['linkedin_url' => ['required', 'string', new ValidUrl()]]);
        $errorMessages = array_merge($errorMessages, ['linkedin_url.required' => 'This field is required.']);

        $validationRule = array_merge($validationRule, ['youtube_url' => ['required', 'string', new ValidUrl()]]);
        $errorMessages = array_merge($errorMessages, ['youtube_url.required' => 'This field is required.']);

        $validationRule = array_merge($validationRule, ['menu1' => ['required']]);
        $errorMessages = array_merge($errorMessages, ['menu1.required' => 'This field is required.']);
        $validationRule = array_merge($validationRule, ['menu2' => ['required']]);
        $errorMessages = array_merge($errorMessages, ['menu2.required' => 'This field is required.']);
        $validationRule = array_merge($validationRule, ['menu3' => ['required']]);
        $errorMessages = array_merge($errorMessages, ['menu3.required' => 'This field is required.']);
        $this->validate(
            $request,
            $validationRule,
            $errorMessages
        );
        $footerSetting = FooterSetting::first();
        if($footerSetting){
            $footerSetting->update([
                'facebook_icon' => $request->facebook_icon,
                'facebook_url' => $request->facebook_url,
                'insta_icon' => $request->insta_icon,
                'insta_url' => $request->insta_url,
                'twitter_icon' => $request->twitter_icon,
                'twitter_url' => $request->twitter_url,
                'youtube_icon' => $request->youtube_icon,
                'youtube_url' => $request->youtube_url,
                'linkedin_icon' => $request->linkedin_icon,
                'linkedin_url' => $request->linkedin_url,
                'menu1' => $request->menu1,
                'menu2' => $request->menu2,
                'menu3' => $request->menu3
            ]);
        }else{
            $footerSetting = FooterSetting::create([
                'facebook_icon' => $request->facebook_icon,
                'facebook_url' => $request->facebook_url,
                'insta_icon' => $request->insta_icon,
                'insta_url' => $request->insta_url,
                'twitter_icon' => $request->twitter_icon,
                'twitter_url' => $request->twitter_url,
                'youtube_icon' => $request->youtube_icon,
                'youtube_url' => $request->youtube_url,
                'linkedin_icon' => $request->linkedin_icon,
                'linkedin_url' => $request->linkedin_url,
                'menu1' => $request->menu1,
                'menu2' => $request->menu2,
                'menu3' => $request->menu3
            ]);
        }
        
        foreach ($languages as $language) {
            $footerSettingDetail = FooterSettingDetail::whereLanguageId($language->id)->whereFooterSettingId($footerSetting->id)->exists();

            $fields = [
                // 'section_1_title' => $request['section_1_title']['section_1_title_' . $language->id],
                // 'copy_right_text' => $request['copy_right_text']['copy_right_text_' . $language->id],
                // 'section_2_title' => $request['section_2_title']['section_2_title_' . $language->id],
                // 'section_3_title' => $request['section_3_title']['section_3_title_' . $language->id],

                'section_1_title' => isset($request['section_1_title']['section_1_title_' . $language->id]) ? $request['section_1_title']['section_1_title_' . $language->id] : null,
                'copy_right_text' => isset($request['copy_right_text']['copy_right_text_' . $language->id]) ? $request['copy_right_text']['copy_right_text_' . $language->id] : null,
                'section_2_title' => isset($request['section_2_title']['section_2_title_' . $language->id]) ? $request['section_2_title']['section_2_title_' . $language->id] : null,
                'section_3_title' => isset($request['section_3_title']['section_3_title_' . $language->id]) ? $request['section_3_title']['section_3_title_' . $language->id] : null,


                // 'section_4_title' => $request['section_4_title']['section_4_title_' . $language->id],
            ];
            if ($footerSettingDetail) {
                FooterSettingDetail::whereLanguageId($language->id)->whereFooterSettingId($footerSetting->id)->update($fields);
            } else {
                $fields = array_merge($fields, ['footer_setting_id' => $footerSetting->id]);
                $fields = array_merge($fields, ['language_id' => $language->id]);
                FooterSettingDetail::create($fields);
            }
        }

        if ($footerSetting) {
            return $this->apiSuccessResponse(new FooterSettingResource($footerSetting), 'Your changes have been done successfully');
        }
        return $this->errorResponse();
    }
}
