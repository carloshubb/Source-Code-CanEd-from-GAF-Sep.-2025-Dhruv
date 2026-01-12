<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\MasterApplicationSettingResource;
use App\Models\MasterApplicationSetting;
use App\Models\MasterApplicationSettingDetail;
use App\Traits\StatusResponser;
use Illuminate\Http\Request;

class MasterApplicationSettingController extends Controller
{
    use StatusResponser;

    public function index()
    {
        $masterApplicationSetting = MasterApplicationSetting::with('masterApplicationSettingDetail')->first();

        if (!$masterApplicationSetting) {
            $masterApplicationSetting = MasterApplicationSetting::create([]);
            $languages = getAllLanguages();
            foreach ($languages as $language) {
                MasterApplicationSettingDetail::create([
                    'mas_app_stng_id' => $masterApplicationSetting->id,
                    'language_id' => $language->id,
                ]);
            }
            $masterApplicationSetting = $masterApplicationSetting->loadMissing('masterApplicationSettingDetail');
        }

        return $this->successResponse(new MasterApplicationSettingResource($masterApplicationSetting), 'Data get successfully.');
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
            $validationRule = array_merge($validationRule, ['page_title.page_title_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['page_title.page_title_' . $language->id . '.required' => 'This field is required.']);
            $validationRule = array_merge($validationRule, ['description.description_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['description.description_' . $language->id . '.required' => 'This field is required.']);
            $validationRule = array_merge($validationRule, ['first_name_label.first_name_label_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['first_name_label.first_name_label_' . $language->id . '.required' => 'This field is required.']);
            $validationRule = array_merge($validationRule, ['first_name_error.first_name_error_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['first_name_error.first_name_error_' . $language->id . '.required' => 'This field is required.']);
            $validationRule = array_merge($validationRule, ['last_name_label.last_name_label_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['last_name_label.last_name_label_' . $language->id . '.required' => 'This field is required.']);
            $validationRule = array_merge($validationRule, ['last_name_error.last_name_error_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['last_name_error.last_name_error_' . $language->id . '.required' => 'This field is required.']);
            $validationRule = array_merge($validationRule, ['dob_label.dob_label_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['dob_label.dob_label_' . $language->id . '.required' => 'This field is required.']);
            $validationRule = array_merge($validationRule, ['dob_placeholder.dob_placeholder_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['dob_placeholder.dob_placeholder_' . $language->id . '.nullable' => 'This field is required.']);
            $validationRule = array_merge($validationRule, ['dob_error.dob_error_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['dob_error.dob_error_' . $language->id . '.required' => 'This field is required.']);
            $validationRule = array_merge($validationRule, ['gender_label.gender_label_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['gender_label.gender_label_' . $language->id . '.required' => 'This field is required.']);
            $validationRule = array_merge($validationRule, ['gender_placeholder.gender_placeholder_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['gender_placeholder.gender_placeholder_' . $language->id . '.nullable' => 'This field is required.']);
            $validationRule = array_merge($validationRule, ['gender_error.gender_error_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['gender_error.gender_error_' . $language->id . '.required' => 'This field is required.']);
            $validationRule = array_merge($validationRule, ['email_label.email_label_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['email_label.email_label_' . $language->id . '.required' => 'This field is required.']);
            $validationRule = array_merge($validationRule, ['email_error.email_error_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['email_error.email_error_' . $language->id . '.required' => 'This field is required.']);
            $validationRule = array_merge($validationRule, ['confirm_email_label.confirm_email_label_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['confirm_email_label.confirm_email_label_' . $language->id . '.required' => 'This field is required.']);
            $validationRule = array_merge($validationRule, ['confirm_email_error.confirm_email_error_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['confirm_email_error.confirm_email_error_' . $language->id . '.required' => 'This field is required.']);
            $validationRule = array_merge($validationRule, ['phone_label.phone_label_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['phone_label.phone_label_' . $language->id . '.required' => 'This field is required.']);
            $validationRule = array_merge($validationRule, ['phone_placeholder.phone_placeholder_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['phone_placeholder.phone_placeholder_' . $language->id . '.nullable' => 'This field is required.']);
            $validationRule = array_merge($validationRule, ['phone_error.phone_error_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['phone_error.phone_error_' . $language->id . '.required' => 'This field is required.']);
            $validationRule = array_merge($validationRule, ['can_school_text_label.can_school_text_label_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['can_school_text_label.can_school_text_label_' . $language->id . '.required' => 'This field is required.']);
            $validationRule = array_merge($validationRule, ['can_school_text_placeholder.can_school_text_placeholder_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['can_school_text_placeholder.can_school_text_placeholder_' . $language->id . '.nullable' => 'This field is required.']);
            $validationRule = array_merge($validationRule, ['can_school_text_error.can_school_text_error_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['can_school_text_error.can_school_text_error_' . $language->id . '.required' => 'This field is required.']);
            $validationRule = array_merge($validationRule, ['message_app_label.message_app_label_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['message_app_label.message_app_label_' . $language->id . '.required' => 'This field is required.']);
            $validationRule = array_merge($validationRule, ['message_app_placeholder.message_app_placeholder_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['message_app_placeholder.message_app_placeholder_' . $language->id . '.nullable' => 'This field is required.']);
            $validationRule = array_merge($validationRule, ['message_app_error.message_app_error_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['message_app_error.message_app_error_' . $language->id . '.required' => 'This field is required.']);
            $validationRule = array_merge($validationRule, ['currently_study_label.currently_study_label_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['currently_study_label.currently_study_label_' . $language->id . '.required' => 'This field is required.']);
            $validationRule = array_merge($validationRule, ['currently_study_placeholder.currently_study_placeholder_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['currently_study_placeholder.currently_study_placeholder_' . $language->id . '.nullable' => 'This field is required.']);
            $validationRule = array_merge($validationRule, ['currently_study_error.currently_study_error_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['currently_study_error.currently_study_error_' . $language->id . '.required' => 'This field is required.']);
            $validationRule = array_merge($validationRule, ['country_citzenship_label.country_citzenship_label_' . $language->id => [$requiredVal, 'string']]);
            $validationRule = array_merge($validationRule, ['country_citzenship_placeholder.country_citzenship_placeholder_' . $language->id => ['nullable', 'string']]);
            $validationRule = array_merge($validationRule, ['country_citzenship_error.country_citzenship_error_' . $language->id => [$requiredVal, 'string']]);
            $validationRule = array_merge($validationRule, ['live_in_country_citzenship_label.live_in_country_citzenship_label_' . $language->id => [$requiredVal, 'string']]);
            $validationRule = array_merge($validationRule, ['live_in_country_citzenship_placeholder.live_in_country_citzenship_placeholder_' . $language->id => ['nullable', 'string']]);
            $validationRule = array_merge($validationRule, ['live_in_country_citzenship_error.live_in_country_citzenship_error_' . $language->id => [$requiredVal, 'string']]);
            $validationRule = array_merge($validationRule, ['current_residence_label.current_residence_label_' . $language->id => [$requiredVal, 'string']]);
            $validationRule = array_merge($validationRule, ['current_residence_placeholder.current_residence_placeholder_' . $language->id => ['nullable', 'string']]);
            $validationRule = array_merge($validationRule, ['current_residence_error.current_residence_error_' . $language->id => [$requiredVal, 'string']]);
            $validationRule = array_merge($validationRule, ['country_residence_status_label.country_residence_status_label_' . $language->id => [$requiredVal, 'string']]);
            $validationRule = array_merge($validationRule, ['country_residence_status_placeholder.country_residence_status_placeholder_' . $language->id => ['nullable', 'string']]);
            $validationRule = array_merge($validationRule, ['country_residence_status_error.country_residence_status_error_' . $language->id => [$requiredVal, 'string']]);
            $validationRule = array_merge($validationRule, ['mailing_address_label.mailing_address_label_' . $language->id => [$requiredVal, 'string']]);
            $validationRule = array_merge($validationRule, ['mailing_address_placeholder.mailing_address_placeholder_' . $language->id => ['nullable', 'string']]);
            $validationRule = array_merge($validationRule, ['mailing_address_error.mailing_address_error_' . $language->id => [$requiredVal, 'string']]);
            $validationRule = array_merge($validationRule, ['high_school_name_label.high_school_name_label_' . $language->id => [$requiredVal, 'string']]);
            $validationRule = array_merge($validationRule, ['high_school_name_placeholder.high_school_name_placeholder_' . $language->id => ['nullable', 'string']]);
            $validationRule = array_merge($validationRule, ['high_school_name_error.high_school_name_error_' . $language->id => [$requiredVal, 'string']]);
            $validationRule = array_merge($validationRule, ['letter_of_intent_label.letter_of_intent_label_' . $language->id => [$requiredVal, 'string']]);
            $validationRule = array_merge($validationRule, ['letter_of_intent_placeholder.letter_of_intent_placeholder_' . $language->id => ['nullable', 'string']]);
            $validationRule = array_merge($validationRule, ['letter_of_intent_error.letter_of_intent_error_' . $language->id => [$requiredVal, 'string']]);
            $validationRule = array_merge($validationRule, ['statement_of_purpose_label.statement_of_purpose_label_' . $language->id => [$requiredVal, 'string']]);
            $validationRule = array_merge($validationRule, ['statement_of_purpose_placeholder.statement_of_purpose_placeholder_' . $language->id => ['nullable', 'string']]);
            $validationRule = array_merge($validationRule, ['statement_of_purpose_error.statement_of_purpose_error_' . $language->id => [$requiredVal, 'string']]);
            $validationRule = array_merge($validationRule, ['when_plan_to_start_label.when_plan_to_start_label_' . $language->id => [$requiredVal, 'string']]);
            $validationRule = array_merge($validationRule, ['when_plan_to_start_placeholder.when_plan_to_start_placeholder_' . $language->id => ['nullable', 'string']]);
            $validationRule = array_merge($validationRule, ['when_plan_to_start_error.when_plan_to_start_error_' . $language->id => [$requiredVal, 'string']]);
            $validationRule = array_merge($validationRule, ['intrested_in_label.intrested_in_label_' . $language->id => [$requiredVal, 'string']]);
            $validationRule = array_merge($validationRule, ['intrested_in_placeholder.intrested_in_placeholder_' . $language->id => ['nullable', 'string']]);
            $validationRule = array_merge($validationRule, ['intrested_in_error.intrested_in_error_' . $language->id => [$requiredVal, 'string']]);
            $validationRule = array_merge($validationRule, ['would_like_to_study_label.would_like_to_study_label_' . $language->id => [$requiredVal, 'string']]);
            $validationRule = array_merge($validationRule, ['would_like_to_study_placeholder.would_like_to_study_placeholder_' . $language->id => ['nullable', 'string']]);
            $validationRule = array_merge($validationRule, ['would_like_to_study_error.would_like_to_study_error_' . $language->id => [$requiredVal, 'string']]);
            $validationRule = array_merge($validationRule, ['tuition_funding_source_label.tuition_funding_source_label_' . $language->id => [$requiredVal, 'string']]);
            $validationRule = array_merge($validationRule, ['tuition_funding_source_placeholder.tuition_funding_source_placeholder_' . $language->id => ['nullable', 'string']]);
            $validationRule = array_merge($validationRule, ['tuition_funding_source_error.tuition_funding_source_error_' . $language->id => [$requiredVal, 'string']]);
            $validationRule = array_merge($validationRule, ['test_taken_label.test_taken_label_' . $language->id => [$requiredVal, 'string']]);
            $validationRule = array_merge($validationRule, ['test_taken_placeholder.test_taken_placeholder_' . $language->id => ['nullable', 'string']]);
            $validationRule = array_merge($validationRule, ['test_taken_error.test_taken_error_' . $language->id => [$requiredVal, 'string']]);
            $validationRule = array_merge($validationRule, ['additional_label.additional_label_' . $language->id => [$requiredVal, 'string']]);
            $validationRule = array_merge($validationRule, ['additional_placeholder.additional_placeholder_' . $language->id => ['nullable', 'string']]);
            $validationRule = array_merge($validationRule, ['additional_error.additional_error_' . $language->id => [$requiredVal, 'string']]);
            $validationRule = array_merge($validationRule, ['add_something_lable.add_something_lable_' . $language->id => [$requiredVal, 'string']]);
            $validationRule = array_merge($validationRule, ['add_something_placeholder.add_something_placeholder_' . $language->id => ['nullable', 'string']]);
            $validationRule = array_merge($validationRule, ['add_something_error.add_something_error_' . $language->id => [$requiredVal, 'string']]);
            $validationRule = array_merge($validationRule, ['currently_live_in_lable.currently_live_in_lable_' . $language->id => [$requiredVal, 'string']]);
            $validationRule = array_merge($validationRule, ['currently_live_in_placeholder.currently_live_in_placeholder_' . $language->id => ['nullable', 'string']]);
            $validationRule = array_merge($validationRule, ['currently_live_in_error.currently_live_in_error_' . $language->id => [$requiredVal, 'string']]);
            $validationRule = array_merge($validationRule, ['study_permet_lable.study_permet_lable_' . $language->id => [$requiredVal, 'string']]);
            $validationRule = array_merge($validationRule, ['study_permet_placeholder.study_permet_placeholder_' . $language->id => ['nullable', 'string']]);
            $validationRule = array_merge($validationRule, ['study_permet_error.study_permet_error_' . $language->id => [$requiredVal, 'string']]);
            $validationRule = array_merge($validationRule, ['send_copy_lable.send_copy_lable_' . $language->id => [$requiredVal, 'string']]);
            $validationRule = array_merge($validationRule, ['send_copy_placeholder.send_copy_placeholder_' . $language->id => ['nullable', 'string']]);
            $validationRule = array_merge($validationRule, ['button_text.button_text_' . $language->id => [$requiredVal, 'string']]);
            $validationRule = array_merge($validationRule, ['where_want_to_study_lable.where_want_to_study_lable_' . $language->id => [$requiredVal, 'string']]);
            $validationRule = array_merge($validationRule, ['where_want_to_study_placeholder.where_want_to_study_placeholder_' . $language->id => ['nullable', 'string']]);
            $validationRule = array_merge($validationRule, ['where_want_to_study_error.where_want_to_study_error_' . $language->id => [$requiredVal, 'string']]);
            $validationRule = array_merge($validationRule, ['high_school_city_lable.high_school_city_lable_' . $language->id => [$requiredVal, 'string']]);
            $validationRule = array_merge($validationRule, ['high_school_city_placeholder.high_school_city_placeholder_' . $language->id => ['nullable', 'string']]);
            $validationRule = array_merge($validationRule, ['high_school_city_error.high_school_city_error_' . $language->id => [$requiredVal, 'string']]);
            $validationRule = array_merge($validationRule, ['high_school_country_lable.high_school_country_lable_' . $language->id => [$requiredVal, 'string']]);
            $validationRule = array_merge($validationRule, ['high_school_country_placeholder.high_school_country_placeholder_' . $language->id => ['nullable', 'string']]);
            $validationRule = array_merge($validationRule, ['high_school_country_error.high_school_country_error_' . $language->id => [$requiredVal, 'string']]);
            $validationRule = array_merge($validationRule, ['student_type_lable.student_type_lable_' . $language->id => [$requiredVal, 'string']]);
            $validationRule = array_merge($validationRule, ['student_type_placeholder.student_type_placeholder_' . $language->id => ['nullable', 'string']]);
            $validationRule = array_merge($validationRule, ['student_type_error.student_type_error_' . $language->id => [$requiredVal, 'string']]);
            $validationRule = array_merge($validationRule, ['privacy_policy.privacy_policy_' . $language->id => [$requiredVal, 'string']]);
            $validationRule = array_merge($validationRule, ['high_school_cgpa_lable.high_school_cgpa_lable_' . $language->id => [$requiredVal, 'string']]);
            $validationRule = array_merge($validationRule, ['high_school_cgpa_placeholder.high_school_cgpa_placeholder_' . $language->id => ['nullable', 'string']]);
            $validationRule = array_merge($validationRule, ['high_school_cgpa_error.high_school_cgpa_error_' . $language->id => [$requiredVal, 'string']]);

            $validationRule = array_merge($validationRule, ['message_app_username_label.message_app_username_label_' . $language->id => [$requiredVal, 'string']]);
            $validationRule = array_merge($validationRule, ['message_app_username_placeholder.message_app_username_placeholder_' . $language->id => ['nullable', 'string']]);
            $validationRule = array_merge($validationRule, ['message_app_username_error.message_app_username_error_' . $language->id => [$requiredVal, 'string']]);

            $errorMessages = array_merge($errorMessages, ['where_want_to_study_lable.where_want_to_study_lable_' . $language->id . '.required' => 'This field is required.']);
            $errorMessages = array_merge($errorMessages, ['where_want_to_study_placeholder.where_want_to_study_placeholder_' . $language->id . '.nullable' => 'This field is required.']);
            $errorMessages = array_merge($errorMessages, ['where_want_to_study_error.where_want_to_study_error_' . $language->id . '.required' => 'This field is required.']);
            $errorMessages = array_merge($errorMessages, ['high_school_city_lable.high_school_city_lable_' . $language->id . '.required' => 'This field is required.']);
            $errorMessages = array_merge($errorMessages, ['high_school_city_placeholder.high_school_city_placeholder_' . $language->id . '.nullable' => 'This field is required.']);
            $errorMessages = array_merge($errorMessages, ['high_school_city_error.high_school_city_error_' . $language->id . '.required' => 'This field is required.']);
            $errorMessages = array_merge($errorMessages, ['high_school_country_lable.high_school_country_lable_' . $language->id . '.required' => 'This field is required.']);
            $errorMessages = array_merge($errorMessages, ['high_school_country_placeholder.high_school_country_placeholder_' . $language->id . '.nullable' => 'This field is required.']);
            $errorMessages = array_merge($errorMessages, ['high_school_country_error.high_school_country_error_' . $language->id . '.required' => 'This field is required.']);
            $errorMessages = array_merge($errorMessages, ['student_type_lable.student_type_lable_' . $language->id . '.required' => 'This field is required.']);
            $errorMessages = array_merge($errorMessages, ['student_type_placeholder.student_type_placeholder_' . $language->id . '.nullable' => 'This field is required.']);
            $errorMessages = array_merge($errorMessages, ['student_type_error.student_type_error_' . $language->id . '.required' => 'This field is required.']);
            $errorMessages = array_merge($errorMessages, ['privacy_policy.privacy_policy_' . $language->id . '.required' => 'This field is required.']);
            $errorMessages = array_merge($errorMessages, ['country_citzenship_label.country_citzenship_label_' . $language->id . '.required' => 'This field is required.']);
            $errorMessages = array_merge($errorMessages, ['country_citzenship_placeholder.country_citzenship_placeholder_' . $language->id . '.nullable' => 'This field is required.']);
            $errorMessages = array_merge($errorMessages, ['country_citzenship_error.country_citzenship_error_' . $language->id . '.required' => 'This field is required.']);
            $errorMessages = array_merge($errorMessages, ['live_in_country_citzenship_label.live_in_country_citzenship_label_' . $language->id . '.required' => 'This field is required.']);
            $errorMessages = array_merge($errorMessages, ['live_in_country_citzenship_placeholder.live_in_country_citzenship_placeholder_' . $language->id . '.nullable' => 'This field is required.']);
            $errorMessages = array_merge($errorMessages, ['live_in_country_citzenship_error.live_in_country_citzenship_error_' . $language->id . '.required' => 'This field is required.']);
            $errorMessages = array_merge($errorMessages, ['current_residence_label.current_residence_label_' . $language->id . '.required' => 'This field is required.']);
            $errorMessages = array_merge($errorMessages, ['current_residence_placeholder_' . $language->id . '.required' => 'This field is nullable.']);
            $errorMessages = array_merge($errorMessages, ['current_residence_error_' . $language->id . '.required' => 'This field is required.']);
            $errorMessages = array_merge($errorMessages, ['country_residence_status_label.country_residence_status_label_' . $language->id . '.required' => 'This field is required.']);
            $errorMessages = array_merge($errorMessages, ['country_residence_status_placeholder.country_residence_status_placeholder_' . $language->id . '.nullable' => 'This field is required.']);
            $errorMessages = array_merge($errorMessages, ['country_residence_status_error.country_residence_status_error_' . $language->id . '.required' => 'This field is required.']);
            $errorMessages = array_merge($errorMessages, ['mailing_address_label.mailing_address_label_' . $language->id . '.required' => 'This field is required.']);
            $errorMessages = array_merge($errorMessages, ['mailing_address_placeholder.mailing_address_placeholder_' . $language->id . '.nullable' => 'This field is required.']);
            $errorMessages = array_merge($errorMessages, ['mailing_address_error.mailing_address_error_' . $language->id . '.required' => 'This field is required.']);
            $errorMessages = array_merge($errorMessages, ['high_school_name_label.high_school_name_label_' . $language->id . '.required' => 'This field is required.']);
            $errorMessages = array_merge($errorMessages, ['high_school_name_placeholder.high_school_name_placeholder_' . $language->id . '.nullable' => 'This field is required.']);
            $errorMessages = array_merge($errorMessages, ['high_school_name_error.high_school_name_error_' . $language->id . '.required' => 'This field is required.']);
            $errorMessages = array_merge($errorMessages, ['letter_of_intent_label.letter_of_intent_label_' . $language->id . '.required' => 'This field is required.']);
            $errorMessages = array_merge($errorMessages, ['letter_of_intent_placeholder.letter_of_intent_placeholder_' . $language->id . '.nullable' => 'This field is required.']);
            $errorMessages = array_merge($errorMessages, ['letter_of_intent_error.letter_of_intent_error_' . $language->id . '.required' => 'This field is required.']);
            $errorMessages = array_merge($errorMessages, ['statement_of_purpose_label.statement_of_purpose_label_' . $language->id . '.required' => 'This field is required.']);
            $errorMessages = array_merge($errorMessages, ['statement_of_purpose_placeholder.statement_of_purpose_placeholder_' . $language->id . '.nullable' => 'This field is required.']);
            $errorMessages = array_merge($errorMessages, ['statement_of_purpose_error.statement_of_purpose_error_' . $language->id . '.required' => 'This field is required.']);
            $errorMessages = array_merge($errorMessages, ['when_plan_to_start_label.when_plan_to_start_label_' . $language->id . '.required' => 'This field is required.']);
            $errorMessages = array_merge($errorMessages, ['when_plan_to_start_placeholder.when_plan_to_start_placeholder_' . $language->id . '.nullable' => 'This field is required.']);
            $errorMessages = array_merge($errorMessages, ['when_plan_to_start_error.when_plan_to_start_error_' . $language->id . '.required' => 'This field is required.']);
            $errorMessages = array_merge($errorMessages, ['intrested_in_label.intrested_in_label_' . $language->id . '.required' => 'This field is required.']);
            $errorMessages = array_merge($errorMessages, ['intrested_in_placeholder.intrested_in_placeholder_' . $language->id . '.nullable' => 'This field is required.']);
            $errorMessages = array_merge($errorMessages, ['intrested_in_error.intrested_in_error_' . $language->id . '.required' => 'This field is required.']);
            $errorMessages = array_merge($errorMessages, ['would_like_to_study_label.would_like_to_study_label_' . $language->id . '.required' => 'This field is required.']);
            $errorMessages = array_merge($errorMessages, ['would_like_to_study_placeholder.would_like_to_study_placeholder_' . $language->id . '.nullable' => 'This field is required.']);
            $errorMessages = array_merge($errorMessages, ['would_like_to_study_error.would_like_to_study_error_' . $language->id . '.required' => 'This field is required.']);
            $errorMessages = array_merge($errorMessages, ['tuition_funding_source_label.tuition_funding_source_label_' . $language->id . '.required' => 'This field is required.']);
            $errorMessages = array_merge($errorMessages, ['tuition_funding_source_placeholder.tuition_funding_source_placeholder_' . $language->id . '.nullable' => 'This field is required.']);
            $errorMessages = array_merge($errorMessages, ['tuition_funding_source_error.tuition_funding_source_error_' . $language->id . '.required' => 'This field is required.']);
            $errorMessages = array_merge($errorMessages, ['test_taken_label.test_taken_label_' . $language->id . '.required' => 'This field is required.']);
            $errorMessages = array_merge($errorMessages, ['test_taken_placeholder.test_taken_placeholder_' . $language->id . '.nullable' => 'This field is required.']);
            $errorMessages = array_merge($errorMessages, ['test_taken_error.test_taken_error_' . $language->id . '.required' => 'This field is required.']);
            $errorMessages = array_merge($errorMessages, ['additional_label.additional_label_' . $language->id . '.required' => 'This field is required.']);
            $errorMessages = array_merge($errorMessages, ['additional_placeholder.additional_placeholder_' . $language->id . '.nullable' => 'This field is required.']);
            $errorMessages = array_merge($errorMessages, ['additional_error.additional_error_' . $language->id . '.required' => 'This field is required.']);
            $errorMessages = array_merge($errorMessages, ['add_something_lable.add_something_lable_' . $language->id . '.required' => 'This field is required.']);
            $errorMessages = array_merge($errorMessages, ['add_something_placeholder.add_something_placeholder_' . $language->id . '.nullable' => 'This field is required.']);
            $errorMessages = array_merge($errorMessages, ['add_something_error.add_something_error_' . $language->id . '.required' => 'This field is required.']);
            $errorMessages = array_merge($errorMessages, ['currently_live_in_lable.currently_live_in_lable_' . $language->id . '.required' => 'This field is required.']);
            $errorMessages = array_merge($errorMessages, ['currently_live_in_placeholder.currently_live_in_placeholder_' . $language->id . '.nullable' => 'This field is required.']);
            $errorMessages = array_merge($errorMessages, ['currently_live_in_error.currently_live_in_error_' . $language->id . '.required' => 'This field is required.']);
            $errorMessages = array_merge($errorMessages, ['study_permet_lable.study_permet_lable_' . $language->id . '.required' => 'This field is required.']);
            $errorMessages = array_merge($errorMessages, ['study_permet_placeholder.study_permet_placeholder_' . $language->id . '.nullable' => 'This field is required.']);
            $errorMessages = array_merge($errorMessages, ['study_permet_error.study_permet_error_' . $language->id . '.required' => 'This field is required.']);
            $errorMessages = array_merge($errorMessages, ['send_copy_lable.end_copy_lable_' . $language->id . '.required' => 'This field is required.']);
            $errorMessages = array_merge($errorMessages, ['send_copy_placeholder.send_copy_placeholder_' . $language->id . '.nullable' => 'This field is required.']);
            $errorMessages = array_merge($errorMessages, ['button_text.button_text_' . $language->id . '.required' => 'This field is required.']);
            $errorMessages = array_merge($errorMessages, ['high_school_cgpa_lable.high_school_cgpa_lable_' . $language->id . '.required' => 'This field is required.']);
            $errorMessages = array_merge($errorMessages, ['high_school_cgpa_placeholder.high_school_cgpa_placeholder_' . $language->id . '.nullable' => 'This field is required.']);
            $errorMessages = array_merge($errorMessages, ['high_school_cgpa_error.high_school_cgpa_error_' . $language->id . '.required' => 'This field is required.']);
            $errorMessages = array_merge($errorMessages, ['message_app_username_label.message_app_username_label_' . $language->id . '.required' => 'This field is required.']);
            $errorMessages = array_merge($errorMessages, ['message_app_username_placeholder.message_app_username_placeholder_' . $language->id . '.nullable' => 'This field is required.']);
            $errorMessages = array_merge($errorMessages, ['message_app_username_error.message_app_username_error_' . $language->id . '.required' => 'This field is required.']);
            
            $validationRule = array_merge($validationRule, ['school_lable.school_lable_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['school_lable.school_lable_' . $language->id . '.required' => 'This field is required.']);
            $validationRule = array_merge($validationRule, ['school_placeholder.school_placeholder_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['school_placeholder.school_placeholder_' . $language->id . '.nullable' => 'This field is required.']);
            $validationRule = array_merge($validationRule, ['school_error.school_error_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['school_error.school_error_' . $language->id . '.required' => 'This field is required.']);
        }

        $this->validate(
            $request,
            $validationRule,
            $errorMessages
        );

        $masterApplicationSetting = MasterApplicationSetting::first();
        $masterApplicationSetting->touch();
        foreach ($languages as $language) {
            $masterApplicationSettingDetail = MasterApplicationSettingDetail::whereLanguageId($language->id)->where('mas_app_stng_id', $masterApplicationSetting->id)->exists();

            $fields = [
                'page_title' => $request['page_title']['page_title_' . $language->id] ?? null,
                'first_name_error' => $request['first_name_error']['first_name_error_' . $language->id] ?? null,
                'last_name_label' => $request['last_name_label']['last_name_label_' . $language->id] ?? null,
                'last_name_placeholder' => $request['last_name_placeholder']['last_name_placeholder_' . $language->id] ?? null,
                'last_name_error' => $request['last_name_error']['last_name_error_' . $language->id] ?? null,
                'dob_label' => $request['dob_label']['dob_label_' . $language->id] ?? null,
                'dob_placeholder' => $request['dob_placeholder']['dob_placeholder_' . $language->id] ?? null,
                'description' => $request['description']['description_' . $language->id] ?? null,
                'first_name_label' => $request['first_name_label']['first_name_label_' . $language->id] ?? null,
                'first_name_placeholder' => $request['first_name_placeholder']['first_name_placeholder_' . $language->id] ?? null,
                'dob_error' => $request['dob_error']['dob_error_' . $language->id] ?? null,
                'gender_label' => $request['gender_label']['gender_label_' . $language->id] ?? null,
                'gender_placeholder' => $request['gender_placeholder']['gender_placeholder_' . $language->id] ?? null,
                'gender_error' => $request['gender_error']['gender_error_' . $language->id] ?? null,
                'email_label' => $request['email_label']['email_label_' . $language->id] ?? null,
                'email_placeholder' => $request['email_placeholder']['email_placeholder_' . $language->id] ?? null,
                'email_error' => $request['email_error']['email_error_' . $language->id] ?? null,
                'confirm_email_label' => $request['confirm_email_label']['confirm_email_label_' . $language->id] ?? null,
                'confirm_email_placeholder' => $request['confirm_email_placeholder']['confirm_email_placeholder_' . $language->id] ?? null,
                'confirm_email_error' => $request['confirm_email_error']['confirm_email_error_' . $language->id] ?? null,
                'phone_label' => $request['phone_label']['phone_label_' . $language->id] ?? null,
                'phone_placeholder' => $request['phone_placeholder']['phone_placeholder_' . $language->id] ?? null,
                'phone_error' => $request['phone_error']['phone_error_' . $language->id] ?? null,
                'can_school_text_label' => $request['can_school_text_label']['can_school_text_label_' . $language->id] ?? null,
                'can_school_text_placeholder' => $request['can_school_text_placeholder']['can_school_text_placeholder_' . $language->id] ?? null,
                'can_school_text_error' => $request['can_school_text_error']['can_school_text_error_' . $language->id] ?? null,
                'message_app_label' => $request['message_app_label']['message_app_label_' . $language->id] ?? null,
                'message_app_placeholder' => $request['message_app_placeholder']['message_app_placeholder_' . $language->id] ?? null,
                'message_app_error' => $request['message_app_error']['message_app_error_' . $language->id] ?? null,
                'currently_study_label' => $request['currently_study_label']['currently_study_label_' . $language->id] ?? null,
                'currently_study_placeholder' => $request['currently_study_placeholder']['currently_study_placeholder_' . $language->id] ?? null,
                'currently_study_error' => $request['currently_study_error']['currently_study_error_' . $language->id] ?? null,
                'country_citzenship_label' => $request['country_citzenship_label']['country_citzenship_label_' . $language->id] ?? null,
                'country_citzenship_placeholder' => $request['country_citzenship_placeholder']['country_citzenship_placeholder_' . $language->id] ?? null,
                'country_citzenship_error' => $request['country_citzenship_error']['country_citzenship_error_' . $language->id] ?? null,
                'live_in_country_citzenship_label' => $request['live_in_country_citzenship_label']['live_in_country_citzenship_label_' . $language->id] ?? null,
                'live_in_country_citzenship_placeholder' => $request['live_in_country_citzenship_placeholder']['live_in_country_citzenship_placeholder_' . $language->id] ?? null,
                'live_in_country_citzenship_error' => $request['live_in_country_citzenship_error']['live_in_country_citzenship_error_' . $language->id] ?? null,
                'current_residence_label' => $request['current_residence_label']['current_residence_label_' . $language->id] ?? null,
                'current_residence_placeholder' => $request['current_residence_placeholder']['current_residence_placeholder_' . $language->id] ?? null,
                'current_residence_error' => $request['current_residence_error']['current_residence_error_' . $language->id] ?? null,
                'country_residence_status_label' => $request['country_residence_status_label']['country_residence_status_label_' . $language->id] ?? null,
                'country_residence_status_placeholder' => $request['country_residence_status_placeholder']['country_residence_status_placeholder_' . $language->id] ?? null,
                'country_residence_status_error' => $request['country_residence_status_error']['country_residence_status_error_' . $language->id] ?? null,
                'mailing_address_label' => $request['mailing_address_label']['mailing_address_label_' . $language->id] ?? null,
                'mailing_address_placeholder' => $request['mailing_address_placeholder']['mailing_address_placeholder_' . $language->id] ?? null,
                'mailing_address_error' => $request['mailing_address_error']['mailing_address_error_' . $language->id] ?? null,
                'high_school_name_label' => $request['high_school_name_label']['high_school_name_label_' . $language->id] ?? null,
                'high_school_name_placeholder' => $request['high_school_name_placeholder']['high_school_name_placeholder_' . $language->id] ?? null,
                'high_school_name_error' => $request['high_school_name_error']['high_school_name_error_' . $language->id] ?? null,
                'letter_of_intent_label' => $request['letter_of_intent_label']['letter_of_intent_label_' . $language->id] ?? null,
                'letter_of_intent_placeholder' => $request['letter_of_intent_placeholder']['letter_of_intent_placeholder_' . $language->id] ?? null,
                'letter_of_intent_error' => $request['letter_of_intent_error']['letter_of_intent_error_' . $language->id] ?? null,
                'statement_of_purpose_label' => $request['statement_of_purpose_label']['statement_of_purpose_label_' . $language->id] ?? null,
                'statement_of_purpose_placeholder' => $request['statement_of_purpose_placeholder']['statement_of_purpose_placeholder_' . $language->id] ?? null,
                'statement_of_purpose_error' => $request['statement_of_purpose_error']['statement_of_purpose_error_' . $language->id] ?? null,
                'when_plan_to_start_label' => $request['when_plan_to_start_label']['when_plan_to_start_label_' . $language->id] ?? null,
                'when_plan_to_start_placeholder' => $request['when_plan_to_start_placeholder']['when_plan_to_start_placeholder_' . $language->id] ?? null,
                'when_plan_to_start_error' => $request['when_plan_to_start_error']['when_plan_to_start_error_' . $language->id] ?? null,
                'intrested_in_label' => $request['intrested_in_label']['intrested_in_label_' . $language->id] ?? null,
                'intrested_in_placeholder' => $request['intrested_in_placeholder']['intrested_in_placeholder_' . $language->id] ?? null,
                'intrested_in_error' => $request['intrested_in_error']['intrested_in_error_' . $language->id] ?? null,
                'would_like_to_study_label' => $request['would_like_to_study_label']['would_like_to_study_label_' . $language->id] ?? null,
                'would_like_to_study_placeholder' => $request['would_like_to_study_placeholder']['would_like_to_study_placeholder_' . $language->id] ?? null,
                'would_like_to_study_error' => $request['would_like_to_study_error']['would_like_to_study_error_' . $language->id] ?? null,
                'tuition_funding_source_label' => $request['tuition_funding_source_label']['tuition_funding_source_label_' . $language->id] ?? null,
                'tuition_funding_source_placeholder' => $request['tuition_funding_source_placeholder']['tuition_funding_source_placeholder_' . $language->id] ?? null,
                'tuition_funding_source_error' => $request['tuition_funding_source_error']['tuition_funding_source_error_' . $language->id] ?? null,
                'test_taken_label' => $request['test_taken_label']['test_taken_label_' . $language->id] ?? null,
                'test_taken_placeholder' => $request['test_taken_placeholder']['test_taken_placeholder_' . $language->id] ?? null,
                'test_taken_error' => $request['test_taken_error']['test_taken_error_' . $language->id] ?? null,
                'additional_label' => $request['additional_label']['additional_label_' . $language->id] ?? null,
                'additional_placeholder' => $request['additional_placeholder']['additional_placeholder_' . $language->id] ?? null,
                'additional_error' => $request['additional_error']['additional_error_' . $language->id] ?? null,
                'add_something_lable' => $request['add_something_lable']['add_something_lable_' . $language->id] ?? null,
                'add_something_placeholder' => $request['add_something_placeholder']['add_something_placeholder_' . $language->id] ?? null,
                'add_something_error' => $request['add_something_error']['add_something_error_' . $language->id] ?? null,
                'currently_live_in_lable' => $request['currently_live_in_lable']['currently_live_in_lable_' . $language->id] ?? null,
                'currently_live_in_placeholder' => $request['currently_live_in_placeholder']['currently_live_in_placeholder_' . $language->id] ?? null,
                'currently_live_in_error' => $request['currently_live_in_error']['currently_live_in_error_' . $language->id] ?? null,
                'study_permet_lable' => $request['study_permet_lable']['study_permet_lable_' . $language->id] ?? null,
                'study_permet_placeholder' => $request['study_permet_placeholder']['study_permet_placeholder_' . $language->id] ?? null,
                'study_permet_error' => $request['study_permet_error']['study_permet_error_' . $language->id] ?? null,
                'send_copy_lable' => $request['send_copy_lable']['send_copy_lable_' . $language->id] ?? null,
                'send_copy_placeholder' => $request['send_copy_placeholder']['send_copy_placeholder_' . $language->id] ?? null,
                'send_copy_error' => $request['send_copy_error']['send_copy_error_' . $language->id] ?? null,
                'button_text' => $request['button_text']['button_text_' . $language->id] ?? null,
                'where_want_to_study_lable' => $request['where_want_to_study_lable']['where_want_to_study_lable_' . $language->id] ?? null,
                'where_want_to_study_placeholder' => $request['where_want_to_study_placeholder']['where_want_to_study_placeholder_' . $language->id] ?? null,
                'where_want_to_study_error' => $request['where_want_to_study_error']['where_want_to_study_error_' . $language->id] ?? null,
                'high_school_city_lable' => $request['high_school_city_lable']['high_school_city_lable_' . $language->id] ?? null,
                'high_school_city_placeholder' => $request['high_school_city_placeholder']['high_school_city_placeholder_' . $language->id] ?? null,
                'high_school_city_error' => $request['high_school_city_error']['high_school_city_error_' . $language->id] ?? null,
                'high_school_country_lable' => $request['high_school_country_lable']['high_school_country_lable_' . $language->id] ?? null,
                'high_school_country_placeholder' => $request['high_school_country_placeholder']['high_school_country_placeholder_' . $language->id] ?? null,
                'high_school_country_error' => $request['high_school_country_error']['high_school_country_error_' . $language->id] ?? null,
                'student_type_lable' => $request['student_type_lable']['student_type_lable_' . $language->id] ?? null,
                'student_type_placeholder' => $request['student_type_placeholder']['student_type_placeholder_' . $language->id] ?? null,
                'student_type_error' => $request['student_type_error']['student_type_error_' . $language->id] ?? null,
                'privacy_policy' => $request['privacy_policy']['privacy_policy_' . $language->id] ?? null,
                'high_school_cgpa_lable' => $request['high_school_cgpa_lable']['high_school_cgpa_lable_' . $language->id] ?? null,
                'high_school_cgpa_placeholder' => $request['high_school_cgpa_placeholder']['high_school_cgpa_placeholder_' . $language->id] ?? null,
                'high_school_cgpa_error' => $request['high_school_cgpa_error']['high_school_cgpa_error_' . $language->id] ?? null,
                'message_app_username_label' => $request['message_app_username_label']['message_app_username_label_' . $language->id] ?? null,
                'message_app_username_placeholder' => $request['message_app_username_placeholder']['message_app_username_placeholder_' . $language->id] ?? null,
                'message_app_username_error' => $request['message_app_username_error']['message_app_username_error_' . $language->id] ?? null,
                'school_lable' => $request['school_lable']['school_lable_' . $language->id] ?? null,
                'school_placeholder' => $request['school_placeholder']['school_placeholder_' . $language->id] ?? null,
                'school_error' => $request['school_error']['school_error_' . $language->id] ?? null,
            ];
            if ($masterApplicationSettingDetail) {
                MasterApplicationSettingDetail::whereLanguageId($language->id)->where('mas_app_stng_id', $masterApplicationSetting->id)->update($fields);
            } else {
                $fields = array_merge($fields, ['mas_app_stng_id' => $masterApplicationSetting->id]);
                $fields = array_merge($fields, ['language_id' => $language->id]);
                MasterApplicationSettingDetail::create($fields);
            }
        }

        if ($masterApplicationSetting) {
            return $this->apiSuccessResponse(new MasterApplicationSettingResource($masterApplicationSetting), 'Your changes have been done successfully');
        }
        return $this->errorResponse();
    }
}
