<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\ContactPageSettingResource;
use App\Models\ContactPageSetting;
use App\Models\ContactPageSettingDetail;
use App\Traits\StatusResponser;
use Illuminate\Http\Request;

class ContactPageSettingController extends Controller
{
    use StatusResponser;

    public function index()
    {
        $conactuspageSetting = ContactPageSetting::with('contactPageSettingDetail')->first();

        if (!$conactuspageSetting) {
            $conactuspageSetting = ContactPageSetting::create([]);
            $languages = getAllLanguages();
            foreach ($languages as $language) {
                ContactPageSettingDetail::create([
                    'conact_page_setting_id' => $conactuspageSetting->id,
                    'language_id' => $language->id,
                ]);
            }
            $conactuspageSetting = $conactuspageSetting->loadMissing('contactPageSettingDetail');
        }

        return $this->successResponse(new ContactPageSettingResource($conactuspageSetting), 'Data get successfully.');
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
            $validationRule = array_merge($validationRule, ['page_title_1.page_title_1_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['page_title_1.page_title_1_' . $language->id . '.required' => 'This field is required.']);
            $validationRule = array_merge($validationRule, ['page_title_2.page_title_2_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['page_title_2.page_title_2_' . $language->id . '.required' => 'This field is required.']);
            $validationRule = array_merge($validationRule, ['description.description_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['description.description_' . $language->id . '.required' => 'This field is required.']);
            $validationRule = array_merge($validationRule, ['button_text.button_text_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['button_text.button_text_' . $language->id . '.required' => 'This field is required.']);
            $validationRule = array_merge($validationRule, ['mainling_address.mainling_address_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['mainling_address.mainling_address_' . $language->id . '.required' => 'This field is required.']);
            $validationRule = array_merge($validationRule, ['toll_free.toll_free_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['toll_free.toll_free_' . $language->id . '.required' => 'This field is required.']);
            $validationRule = array_merge($validationRule, ['phone.phone_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['phone.phone_' . $language->id . '.required' => 'This field is required.']);
            $validationRule = array_merge($validationRule, ['email.email_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['email.email_' . $language->id . '.required' => 'This field is required.']);
            $validationRule = array_merge($validationRule, ['website.website_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['website.website_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['mainling_address_lable.mainling_address_lable_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['mainling_address_lable.mainling_address_lable_' . $language->id . '.required' => 'This field is required.']);
            $validationRule = array_merge($validationRule, ['toll_free_lable.toll_free_lable_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['toll_free_lable.toll_free_lable_' . $language->id . '.required' => 'This field is required.']);
            $validationRule = array_merge($validationRule, ['phone_lable.phone_lable_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['phone_lable.phone_lable_' . $language->id . '.required' => 'This field is required.']);
            $validationRule = array_merge($validationRule, ['email_lable.email_lable_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['email_lable.email_lable_' . $language->id . '.required' => 'This field is required.']);
            $validationRule = array_merge($validationRule, ['website_lable.website_lable_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['website_lable.website_lable_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['name_input_lable.name_input_lable_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['name_input_lable.name_input_lable_' . $language->id . '.required' => 'This field is required.']);
            $validationRule = array_merge($validationRule, ['name_input_placeholder.name_input_placeholder_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['name_input_placeholder.name_input_placeholder_' . $language->id . '.required' => 'This field is required.']);
            $validationRule = array_merge($validationRule, ['name_input_error.name_input_error_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['name_input_error.name_input_error_' . $language->id . '.required' => 'This field is required.']);
            $validationRule = array_merge($validationRule, ['email_input_lable.email_input_lable_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['email_input_lable.email_input_lable_' . $language->id . '.required' => 'This field is required.']);
            $validationRule = array_merge($validationRule, ['email_input_placeholder.email_input_placeholder_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['email_input_placeholder.email_input_placeholder_' . $language->id . '.required' => 'This field is required.']);
            $validationRule = array_merge($validationRule, ['email_input_error.email_input_error_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['email_input_error.email_input_error_' . $language->id . '.required' => 'This field is required.']);
            $validationRule = array_merge($validationRule, ['message_input_lable.message_input_lable_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['message_input_lable.message_input_lable_' . $language->id . '.required' => 'This field is required.']);
            $validationRule = array_merge($validationRule, ['message_input_placeholder.message_input_placeholder_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['message_input_placeholder.message_input_placeholder_' . $language->id . '.required' => 'This field is required.']);
            $validationRule = array_merge($validationRule, ['message_input_error.message_input_error_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['message_input_error.message_input_error_' . $language->id . '.required' => 'This field is required.']);
        }

        $this->validate(
            $request,
            $validationRule,
            $errorMessages
        );

        $conactuspageSetting = ContactPageSetting::firstOrCreate();
        $conactuspageSetting->touch();

        foreach ($languages as $language) {
            $contactPageSettingDetail = ContactPageSettingDetail::whereLanguageId($language->id)->whereContactPageSettingId($conactuspageSetting->id)->exists();
            $fields = [
                'page_title_1' => $request['page_title_1']['page_title_1_' . $language->id],
                'page_title_2' => $request['page_title_2']['page_title_2_' . $language->id],
                'description' => $request['description']['description_' . $language->id],
                'mainling_address' => $request['mainling_address']['mainling_address_' . $language->id],
                'toll_free' => $request['toll_free']['toll_free_' . $language->id],
                'phone' => $request['phone']['phone_' . $language->id],
                'email' => $request['email']['email_' . $language->id],
                'website' => $request['website']['website_' . $language->id],
                'mainling_address_lable' => $request['mainling_address_lable']['mainling_address_lable_' . $language->id],
                'toll_free_lable' => $request['toll_free_lable']['toll_free_lable_' . $language->id],
                'phone_lable' => $request['phone_lable']['phone_lable_' . $language->id],
                'email_lable' => $request['email_lable']['email_lable_' . $language->id],
                'website_lable' => $request['website_lable']['website_lable_' . $language->id],
                'name_input_lable' => $request['name_input_lable']['name_input_lable_' . $language->id],
                'name_input_placeholder' => $request['name_input_placeholder']['name_input_placeholder_' . $language->id],
                'name_input_error' => $request['name_input_error']['name_input_error_' . $language->id],
                'email_input_lable' => $request['email_input_lable']['email_input_lable_' . $language->id],
                'email_input_placeholder' => $request['email_input_placeholder']['email_input_placeholder_' . $language->id],
                'email_input_error' => $request['email_input_error']['email_input_error_' . $language->id],
                'message_input_lable' => $request['message_input_lable']['message_input_lable_' . $language->id],
                'message_input_placeholder' => $request['message_input_placeholder']['message_input_placeholder_' . $language->id],
                'message_input_error' => $request['message_input_error']['message_input_error_' . $language->id],
                'button_text' => $request['button_text']['button_text_' . $language->id]
            ];
            if ($contactPageSettingDetail) {
                ContactPageSettingDetail::whereLanguageId($language->id)->whereContactPageSettingId($conactuspageSetting->id)->update($fields);
            } else {
                $fields = array_merge($fields, ['contact_page_setting_id' => $conactuspageSetting->id]);
                $fields = array_merge($fields, ['language_id' => $language->id]);
                ContactPageSettingDetail::create($fields);
            }
        }

        if ($conactuspageSetting) {
            return $this->apiSuccessResponse(new ContactPageSettingResource($conactuspageSetting), 'Your changes have been done successfully');
        }
        return $this->errorResponse();
    }
}
