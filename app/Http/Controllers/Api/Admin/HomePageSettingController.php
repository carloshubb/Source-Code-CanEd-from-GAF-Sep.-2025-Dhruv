<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\HomePageSettingResource;
use App\Models\HomePageSetting;
use App\Models\HomePageSettingDetail;
use App\Traits\StatusResponser;
use Illuminate\Http\Request;

class HomePageSettingController extends Controller
{
    use StatusResponser;

    public function index()
    {
        $homePageSetting = HomePageSetting::with('homePageSettingDetail')->first();

        if(!$homePageSetting){
            $homePageSetting = HomePageSetting::create([]);
            $languages = getAllLanguages();
            foreach ($languages as $language) {
                HomePageSettingDetail::create([
                    'home_page_setting_id' => $homePageSetting->id,
                    'language_id' => $language->id,
                ]);
            }
            $homePageSetting = $homePageSetting->loadMissing('homePageSettingDetail');
        }

        return $this->successResponse(new HomePageSettingResource($homePageSetting), 'Data get successfully.');
    }

    public function update(Request $request)
    {
        // dd($request->all());
        $validationRule = [];
        $errorMessages = [];
        $languages = getAllLanguages();
        foreach ($languages as $language) {
            $requiredVal = 'nullable';
            if ($language->is_default == '1') {
                $requiredVal = 'required';
            }
            $validationRule = array_merge($validationRule, ['welcome_title.welcome_title_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['welcome_title.welcome_title_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['welcome_description.welcome_description_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['welcome_description.welcome_description_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['welcome_button_text.welcome_button_text_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['welcome_button_text.welcome_button_text_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['welcome_button_link.welcome_button_link_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['welcome_button_link.welcome_button_link_' . $language->id . '.required' => 'This field is required.']);

            // first name
            $validationRule = array_merge($validationRule, ['welcome_image.welcome_image_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['welcome_image.welcome_image_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['featured_title.featured_title_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['featured_title.featured_title_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['featured_description.featured_description_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['featured_description.featured_description_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['featured_business_title.featured_business_title_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['featured_business_title.featured_business_title_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['featured_business_description.featured_business_description_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['featured_business_description.featured_business_description_' . $language->id . '.required' => 'This field is required.']);

            // last name
            $validationRule = array_merge($validationRule, ['article_section_1_title.article_section_1_title_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['article_section_1_title.article_section_1_title_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['article_section_1_description.article_section_1_description_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['article_section_1_description.article_section_1_description_' . $language->id . '.required' => 'This field is required.']);

            
            $validationRule = array_merge($validationRule, ['article_section_2_title.article_section_2_title_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['article_section_2_title.article_section_2_title_' . $language->id . '.required' => 'This field is required.']);


            $validationRule = array_merge($validationRule, ['article_section_2_description.article_section_2_description_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['article_section_2_description.article_section_2_description_' . $language->id . '.required' => 'This field is required.']);

            
            $validationRule = array_merge($validationRule, ['article_section_3_title.article_section_3_title_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['article_section_3_title.article_section_3_title_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['article_section_3_description.article_section_3_description_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['article_section_3_description.article_section_3_description_' . $language->id . '.required' => 'This field is required.']);



            $validationRule = array_merge($validationRule, ['recent_article_title.recent_article_title_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['recent_article_title.recent_article_title_' . $language->id . '.required' => 'This field is required.']);



            $validationRule = array_merge($validationRule, ['recent_article_description.recent_article_description_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['recent_article_description.recent_article_description_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['article_card_title.article_card_title_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['article_card_title.article_card_title_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['video_card_title.video_card_title_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['video_card_title.video_card_title_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['recent_article_image.recent_article_image_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['recent_article_image.recent_article_image_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['recent_video_image.recent_video_image_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['recent_video_image.recent_video_image_' . $language->id . '.required' => 'This field is required.']);
        }

        $validationRule = array_merge($validationRule, ['banner_1' => [$requiredVal]]);
        $errorMessages = array_merge($errorMessages, ['banner_1.required' => 'This field is required.']);

        $validationRule = array_merge($validationRule, ['banner_2' => [$requiredVal]]);
        $errorMessages = array_merge($errorMessages, ['banner_2.required' => 'This field is required.']);

        $validationRule = array_merge($validationRule, ['banner_3' => [$requiredVal]]);
        $errorMessages = array_merge($errorMessages, ['banner_3.required' => 'This field is required.']);

        $validationRule = array_merge($validationRule, ['article_section_1_category_id' => [$requiredVal]]);
        $errorMessages = array_merge($errorMessages, ['article_section_1_category_id.required' => 'This field is required.']);

        $validationRule = array_merge($validationRule, ['article_section_2_category_id' => [$requiredVal]]);
        $errorMessages = array_merge($errorMessages, ['article_section_2_category_id.required' => 'This field is required.']);

        $validationRule = array_merge($validationRule, ['article_section_3_category_id' => [$requiredVal]]);
        $errorMessages = array_merge($errorMessages, ['article_section_3_category_id.required' => 'This field is required.']);

        $this->validate(
            $request,
            $validationRule,
            $errorMessages
        );

        $homePageSetting = HomePageSetting::first();
        if(!$homePageSetting){
            $homePageSetting = HomePageSetting::Create([
                'banner_1' => $request->banner_1,
                'banner_2' => $request->banner_2,
                'banner_3' => $request->banner_3,
                'article_section_1_category_id' => $request->article_section_1_category_id,
                'article_section_2_category_id' => $request->article_section_2_category_id,
                'article_section_3_category_id' => $request->article_section_3_category_id,
            ]);
        }else{
            $homePageSetting->update([
                'banner_1' => $request->banner_1,
                'banner_2' => $request->banner_2,
                'banner_3' => $request->banner_3,
                'article_section_1_category_id' => $request->article_section_1_category_id,
                'article_section_2_category_id' => $request->article_section_2_category_id,
                'article_section_3_category_id' => $request->article_section_3_category_id,
            ]);
        }
        
        $homePageSetting->touch();
        foreach ($languages as $language) {
            $homePageSettingDetail = HomePageSettingDetail::whereLanguageId($language->id)->whereHomePageSettingId($homePageSetting->id)->first();

            $fields = [
                'welcome_title' => $request['welcome_title']['welcome_title_' . $language->id] ?? null,
                'welcome_image' => $request['welcome_image']['welcome_image_' . $language->id] ?? null,
                'featured_title' => $request['featured_title']['featured_title_' . $language->id]?? null,
                'featured_description' => $request['featured_description']['featured_description_' . $language->id]?? null,
                'featured_business_title' => $request['featured_business_title']['featured_business_title_' . $language->id]?? null,
                'featured_business_description' => $request['featured_business_description']['featured_business_description_' . $language->id]?? null,
                'article_section_1_title' => $request['article_section_1_title']['article_section_1_title_' . $language->id]?? null,
                'article_section_1_description' => $request['article_section_1_description']['article_section_1_description_' . $language->id]?? null,
                 'welcome_description' => $request['welcome_description']['welcome_description_' . $language->id]?? null,
                'welcome_button_text' => $request['welcome_button_text']['welcome_button_text_' . $language->id]?? null,
                'welcome_button_link' => $request['welcome_button_link']['welcome_button_link_' . $language->id]?? null,
                'article_section_2_title' => $request['article_section_2_title']['article_section_2_title_' . $language->id]?? null,
                'article_section_2_description' => $request['article_section_2_description']['article_section_2_description_' . $language->id]?? null,
                'article_section_3_title' => $request['article_section_3_title']['article_section_3_title_' . $language->id]?? null,
                'article_section_3_description' => $request['article_section_3_description']['article_section_3_description_' . $language->id]?? null,
                'recent_article_title' => $request['recent_article_title']['recent_article_title_' . $language->id]?? null,
                'recent_article_description' => $request['recent_article_description']['recent_article_description_' . $language->id]?? null,
                'article_card_title' => $request['article_card_title']['article_card_title_' . $language->id]?? null,
                'video_card_title' => $request['video_card_title']['video_card_title_' . $language->id]?? null,
                'recent_article_image' => $request['recent_article_image']['recent_article_image_' . $language->id]?? null,
                'recent_video_image' => $request['recent_video_image']['recent_video_image_' . $language->id]?? null,
            ];
            // dd([
            //     'recent_article_image' => $request['recent_article_image']['recent_article_image_' . $language->id] ?? null,
            //     'recent_video_image' => $request['recent_video_image']['recent_video_image_' . $language->id] ?? null
            // ]);
            
            if ($homePageSettingDetail) {
                HomePageSettingDetail::whereLanguageId($language->id)->whereHomePageSettingId($homePageSetting->id)->update($fields);
            } else {
                $fields = array_merge($fields, ['home_page_setting_id' => $homePageSetting->id]);
                $fields = array_merge($fields, ['language_id' => $language->id]);
                HomePageSettingDetail::create($fields);
            }
        }

        if ($homePageSetting) {
            return $this->apiSuccessResponse(new HomePageSettingResource($homePageSetting), 'Your changes have been done successfully');
        }
        return $this->errorResponse();
    }
}
