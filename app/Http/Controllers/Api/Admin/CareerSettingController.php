<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\CareerSettingResource;
use App\Models\CareerSetting;
use App\Models\CareerSettingDetail;
use App\Traits\StatusResponser;
use Illuminate\Http\Request;

class CareerSettingController extends Controller
{
    use StatusResponser;

    public function index()
    {
        $careerSetting = CareerSetting::with('careerSettingDetail')->first();

        if(!$careerSetting){
            $careerSetting = CareerSetting::create([]);
            $languages = getAllLanguages();
            foreach ($languages as $language) {
                CareerSettingDetail::create([
                    'career_setting_id' => $careerSetting->id,
                    'language_id' => $language->id,
                ]);
            }
            $careerSetting = $careerSetting->loadMissing('careerSettingDetail');
        }

        return $this->successResponse(new CareerSettingResource($careerSetting), 'Data get successfully.');
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
            $validationRule = array_merge($validationRule, ['tab_1_title.tab_1_title_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['tab_1_title.tab_1_title_' . $language->id . '.required' => 'This field is required.']);
            $validationRule = array_merge($validationRule, ['tab_2_title.tab_2_title_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['tab_2_title.tab_2_title_' . $language->id . '.required' => 'This field is required.']);
            $validationRule = array_merge($validationRule, ['tab_3_title.tab_3_title_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['tab_3_title.tab_3_title_' . $language->id . '.required' => 'This field is required.']);
            $validationRule = array_merge($validationRule, ['article_title.article_title_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['article_title.article_title_' . $language->id . '.required' => 'This field is required.']);
            $validationRule = array_merge($validationRule, ['search_input_placeholder.search_input_placeholder_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['search_input_placeholder.search_input_placeholder_' . $language->id . '.required' => 'This field is required.']);
            $validationRule = array_merge($validationRule, ['page_title.page_title_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['page_title.page_title_' . $language->id . '.required' => 'This field is required.']);
            $validationRule = array_merge($validationRule, ['title.title_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['title.title_' . $language->id . '.required' => 'This field is required.']);
            $validationRule = array_merge($validationRule, ['description.description_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['description.description_' . $language->id . '.required' => 'This field is required.']);     
        }

        $this->validate(
            $request,
            $validationRule,
            $errorMessages
        );

        $careerSetting = CareerSetting::firstOrCreate();
        $careerSetting->touch();
        
        foreach ($languages as $language) {
            $careerSettingDetail = CareerSettingDetail::whereLanguageId($language->id)->whereCareerSettingId($careerSetting->id)->exists();
            $fields = [
                'title' => $request['title']['title_' . $language->id]  ?? null,
                'description' => $request['description']['description_' . $language->id]?? null,  
                'page_title' => $request['page_title']['page_title_' . $language->id]?? null,
                'article_title' => $request['article_title']['article_title_' . $language->id]?? null,
                'tab_1_title' => $request['tab_1_title']['tab_1_title_' . $language->id]?? null,
                'tab_2_title' => $request['tab_2_title']['tab_2_title_' . $language->id]?? null,
                'tab_3_title' => $request['tab_3_title']['tab_3_title_' . $language->id]?? null,  
                'search_input_placeholder' => $request['search_input_placeholder']['search_input_placeholder_' . $language->id]?? null,              
            ];
            if ($careerSettingDetail) {
                CareerSettingDetail::whereLanguageId($language->id)->whereCareerSettingId($careerSetting->id)->update($fields);
            } else {
                $fields = array_merge($fields, ['career_setting_id' => $careerSetting->id]);
                $fields = array_merge($fields, ['language_id' => $language->id]);
                CareerSettingDetail::create($fields);
            }
        }

        if ($careerSetting) {
            return $this->apiSuccessResponse(new CareerSettingResource($careerSetting), 'Your changes have been done successfully');
        }
        return $this->errorResponse();
    }
}
