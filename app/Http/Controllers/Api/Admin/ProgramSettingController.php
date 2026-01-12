<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\ProgramSettingResource;
use App\Models\ProgramSetting;
use App\Models\ProgramSettingDetail;
use App\Traits\StatusResponser;
use Illuminate\Http\Request;

class ProgramSettingController extends Controller
{
    use StatusResponser;

    public function index()
    {
        $programSetting = ProgramSetting::with('programSettingDetail')->first();

        if(!$programSetting){
            $programSetting = ProgramSetting::create([]);
            $languages = getAllLanguages();
            foreach ($languages as $language) {
                ProgramSettingDetail::create([
                    'program_setting_id' => $programSetting->id,
                    'language_id' => $language->id,
                ]);
            }
            $programSetting = $programSetting->loadMissing('programSettingDetail');
        }

        return $this->successResponse(new ProgramSettingResource($programSetting), 'Data get successfully.');
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
            $validationRule = array_merge($validationRule, ['description.description_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['description.description_' . $language->id . '.required' => 'This field is required.']);     
            
            $validationRule = array_merge($validationRule, ['page_title.page_title_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['page_title.page_title_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['button_text.button_text_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['button_text.button_text_' . $language->id . '.required' => 'This field is required.']);     
        }

        $this->validate(
            $request,
            $validationRule,
            $errorMessages
        );

        $programSetting = ProgramSetting::firstOrCreate();
        $programSetting->touch();
        
        foreach ($languages as $language) {
            $programSettingDetail = ProgramSettingDetail::whereLanguageId($language->id)->whereProgramSettingId($programSetting->id)->exists();
            $fields = [
                'description' => $request['description']['description_' . $language->id],   
                'page_title' => $request['page_title']['page_title_' . $language->id],   
                'button_text' => $request['button_text']['button_text_' . $language->id],                
            ];
            if ($programSettingDetail) {
                ProgramSettingDetail::whereLanguageId($language->id)->whereProgramSettingId($programSetting->id)->update($fields);
            } else {
                $fields = array_merge($fields, ['program_setting_id' => $programSetting->id]);
                $fields = array_merge($fields, ['language_id' => $language->id]);
                ProgramSettingDetail::create($fields);
            }
        }

        if ($programSetting) {
            return $this->apiSuccessResponse(new ProgramSettingResource($programSetting), 'Your changes have been done successfully');
        }
        return $this->errorResponse();
    }
}
