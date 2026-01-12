<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\CookieSettingResource;
use App\Models\CookieSetting;
use App\Models\CookieSettingDetail;
use App\Models\CookieSettingMenu;
use App\Models\MenuDetail;
use App\Traits\StatusResponser;
use Illuminate\Http\Request;

class CookieSettingController extends Controller
{
    use StatusResponser;

    public function index()
    {
        $cookieSetting = CookieSetting::with('cookieSettingDetail')->first();

        if (!$cookieSetting) {
            $cookieSetting = CookieSetting::create([]);
            $languages = getAllLanguages();
            foreach ($languages as $language) {
                CookieSettingDetail::create([
                    'cookie_setting_id' => $cookieSetting->id,
                    'language_id' => $language->id,
                ]);
            }
            $cookieSetting = $cookieSetting->loadMissing('cookieSettingDetail');
        }

        return $this->successResponse(new CookieSettingResource($cookieSetting), 'Data get successfully.');
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
            $validationRule = array_merge($validationRule, ['text.text_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['text.text_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['learn_more_text.learn_more_text_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['learn_more_text.learn_more_text_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['learn_more_link.learn_more_link_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['learn_more_link.learn_more_link_' . $language->id . '.required' => 'This field is required.']);
            // first name
            $validationRule = array_merge($validationRule, ['button_text.button_text_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['button_text.button_text_' . $language->id . '.required' => 'This field is required.']);
        }
        $this->validate(
            $request,
            $validationRule,
            $errorMessages
        );
        $cookieSetting = CookieSetting::first();
        if(!$cookieSetting){
            $cookieSetting->Create([]);
        }
        foreach ($languages as $language) {
            $cookieSettingDetail = CookieSettingDetail::whereLanguageId($language->id)->whereCookieSettingId($cookieSetting->id)->exists();

            $fields = [
                // 'text' => $request['text']['text_' . $language->id],
                // 'button_text' => $request['button_text']['button_text_' . $language->id],
                // 'learn_more_text' => $request['learn_more_text']['learn_more_text_' . $language->id],
                // 'learn_more_link' => $request['learn_more_link']['learn_more_link_' . $language->id],

                'text' => isset($request['text']['text_' . $language->id]) ? $request['text']['text_' . $language->id] : null,
                'button_text' => isset($request['button_text']['button_text_' . $language->id]) ? $request['button_text']['button_text_' . $language->id] : null,
                'learn_more_text' => isset($request['learn_more_text']['learn_more_text_' . $language->id]) ? $request['learn_more_text']['learn_more_text_' . $language->id] : null,
                'learn_more_link' => isset($request['learn_more_link']['learn_more_link_' . $language->id]) ? $request['learn_more_link']['learn_more_link_' . $language->id] : null,
                // 'section_4_title' => $request['section_4_title']['section_4_title_' . $language->id],
            ];
            if ($cookieSettingDetail) {
                CookieSettingDetail::whereLanguageId($language->id)->whereCookieSettingId($cookieSetting->id)->update($fields);
            } else {
                $fields = array_merge($fields, ['cookie_setting_id' => $cookieSetting->id]);
                $fields = array_merge($fields, ['language_id' => $language->id]);
                CookieSettingDetail::create($fields);
            }
        }

        if ($cookieSetting) {
            return $this->apiSuccessResponse(new CookieSettingResource($cookieSetting), 'Your changes have been done successfully');
        }
        return $this->errorResponse();
    }
}
