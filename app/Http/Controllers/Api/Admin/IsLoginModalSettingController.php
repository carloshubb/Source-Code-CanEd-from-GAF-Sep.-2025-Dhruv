<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\IsLoginModalSettingResource;
use App\Models\IsLoginModalSetting;
use App\Models\IsLoginModalSettingDetail;
use App\Traits\StatusResponser;
use Illuminate\Http\Request;

class IsLoginModalSettingController extends Controller
{
    use StatusResponser;

    public function index()
    {
        $isLoginModalSetting = IsLoginModalSetting::with('isLoginModalSettingDetail')->first();

        if (!$isLoginModalSetting) {
            $isLoginModalSetting = IsLoginModalSetting::create([]);
            $languages = getAllLanguages();
            foreach ($languages as $language) {
                IsLoginModalSettingDetail::create([
                    'is_login_modal_setting_id' => $isLoginModalSetting->id,
                    'language_id' => $language->id,
                ]);
            }
            $isLoginModalSetting = $isLoginModalSetting->loadMissing('isLoginModalSettingDetail');
        }

        return $this->successResponse(new IsLoginModalSettingResource($isLoginModalSetting), 'Data get successfully.');
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
            $validationRule = array_merge($validationRule, ['modal_title.modal_title_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['modal_title.modal_title_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['login_button_text.login_button_text_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['login_button_text.login_button_text_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['register_button_text.register_button_text_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['register_button_text.register_button_text_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['back_button_text.back_button_text_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['back_button_text.back_button_text_' . $language->id . '.required' => 'This field is required.']);
        }

        $this->validate(
            $request,
            $validationRule,
            $errorMessages
        );

        $isLoginModalSetting = IsLoginModalSetting::firstOrCreate([]);
        $isLoginModalSetting->touch();
        foreach ($languages as $language) {
            $isLoginModalSettingDetail = IsLoginModalSettingDetail::whereLanguageId($language->id)->whereIsLoginModalSettingId($isLoginModalSetting->id)->exists();

            $fields = [
                'modal_title' => $request['modal_title']['modal_title_' . $language->id],
                'login_button_text' => $request['login_button_text']['login_button_text_' . $language->id],
                'register_button_text' => $request['register_button_text']['register_button_text_' . $language->id],
                'back_button_text' => $request['back_button_text']['back_button_text_' . $language->id],

            ];
            if ($isLoginModalSettingDetail) {
                IsLoginModalSettingDetail::whereLanguageId($language->id)->whereIsLoginModalSettingId($isLoginModalSetting->id)->update($fields);
            } else {
                $fields = array_merge($fields, ['is_login_modal_setting_id' => $isLoginModalSetting->id]);
                $fields = array_merge($fields, ['language_id' => $language->id]);
                IsLoginModalSettingDetail::create($fields);
            }
        }

        if ($isLoginModalSetting) {
            return $this->apiSuccessResponse(new IsLoginModalSettingResource($isLoginModalSetting), 'Your changes have been done successfully');
        }
        return $this->errorResponse();
    }
}
