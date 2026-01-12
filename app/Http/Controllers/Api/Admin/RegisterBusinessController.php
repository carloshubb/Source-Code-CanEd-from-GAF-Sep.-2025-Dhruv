<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\RegisterBusinessResource;
use App\Models\RegisterBusiness;
use App\Models\RegisterBusinessDetail;
use App\Traits\StatusResponser;
use Illuminate\Http\Request;

class RegisterBusinessController extends Controller
{
    use StatusResponser;

    public function index()
    {
        $registerBusiness = RegisterBusiness::with('registerBusinessDetail')->first();
        if (!$registerBusiness) {
            $registerBusiness = RegisterBusiness::create([]);
            $languages = getAllLanguages();
            foreach ($languages as $language) {
                RegisterBusinessDetail::create([
                    'register_business_setting_id' => $registerBusiness->id,
                    'language_id' => $language->id,
                ]);
            }
            $registerBusiness = $registerBusiness->loadMissing('registerBusinessDetail');
        }

        return $this->successResponse(new RegisterBusinessResource($registerBusiness), 'Data get successfully.');
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
            $validationRule = array_merge($validationRule, ['package_section_title.package_section_title_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['package_section_title.package_section_title_' . $language->id . '.required' => 'This field is required.']);
            $validationRule = array_merge($validationRule, ['business_category_text.business_category_text_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['business_category_text.business_category_text_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['business_category_1_lable.business_category_1_lable_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['business_category_1_lable.business_category_1_lable_' . $language->id . '.required' => 'This field is required.']);

            // $validationRule = array_merge($validationRule, ['business_category_1_placeholder.business_category_1_placeholder_' . $language->id => [$requiredVal, 'string']]);
            // $errorMessages = array_merge($errorMessages, ['business_category_1_placeholder.business_category_1_placeholder_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['business_category_1_error.business_category_1_error_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['business_category_1_error.business_category_1_error_' . $language->id . '.required' => 'This field is required.']);

            // first name
            $validationRule = array_merge($validationRule, ['business_category_2_lable.business_category_2_lable_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['business_category_2_lable.business_category_2_lable_' . $language->id . '.required' => 'This field is required.']);

            // $validationRule = array_merge($validationRule, ['business_category_2_placeholder.business_category_2_placeholder_' . $language->id => [$requiredVal, 'string']]);
            // $errorMessages = array_merge($errorMessages, ['business_category_2_placeholder.business_category_2_placeholder_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['business_category_2_error.business_category_2_error_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['business_category_2_error.business_category_2_error_' . $language->id . '.required' => 'This field is required.']);

            // last name
            $validationRule = array_merge($validationRule, ['business_category_3_lable.business_category_3_lable_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['business_category_3_lable.business_category_3_lable_' . $language->id . '.required' => 'This field is required.']);

            // $validationRule = array_merge($validationRule, ['business_category_3_placeholder.business_category_3_placeholder_' . $language->id => [$requiredVal, 'string']]);
            // $errorMessages = array_merge($errorMessages, ['business_category_3_placeholder.business_category_3_placeholder_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['business_category_3_error.business_category_3_error_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['business_category_3_error.business_category_3_error_' . $language->id . '.required' => 'This field is required.']);

            //password
            $validationRule = array_merge($validationRule, ['name_lable.name_lable_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['name_lable.name_lable_' . $language->id . '.required' => 'This field is required.']);

            // $validationRule = array_merge($validationRule, ['name_placeholder.name_placeholder_' . $language->id => [$requiredVal, 'string']]);
            // $errorMessages = array_merge($errorMessages, ['name_placeholder.name_placeholder_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['name_error.name_error_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['name_error.name_error_' . $language->id . '.required' => 'This field is required.']);
            //password
            $validationRule = array_merge($validationRule, ['website_url_lable.website_url_lable_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['website_url_lable.website_url_lable_' . $language->id . '.required' => 'This field is required.']);

            // $validationRule = array_merge($validationRule, ['website_url_placeholder.website_url_placeholder_' . $language->id => [$requiredVal, 'string']]);
            // $errorMessages = array_merge($errorMessages, ['website_url_placeholder.website_url_placeholder_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['website_url_error.website_url_error_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['website_url_error.website_url_error_' . $language->id . '.required' => 'This field is required.']);

            //password
            $validationRule = array_merge($validationRule, ['description_lable.description_lable_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['description_lable.description_lable_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['detail_description_lable.detail_description_lable_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['detail_description_lable.detail_description_lable_' . $language->id . '.required' => 'This field is required.']);

            // $validationRule = array_merge($validationRule, ['description_placeholder.description_placeholder_' . $language->id => [$requiredVal, 'string']]);
            // $errorMessages = array_merge($errorMessages, ['description_placeholder.description_placeholder_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['description_error.description_error_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['description_error.description_error_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['detail_description_error.detail_description_error_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['detail_description_error.detail_description_error_' . $language->id . '.required' => 'This field is required.']);

            //confirm password
            $validationRule = array_merge($validationRule, ['contact_lable.contact_lable_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['contact_lable.contact_lable_' . $language->id . '.required' => 'This field is required.']);

            // $validationRule = array_merge($validationRule, ['contact_placeholder.contact_placeholder_' . $language->id => [$requiredVal, 'string']]);
            // $errorMessages = array_merge($errorMessages, ['contact_placeholder.contact_placeholder_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['contact_error.contact_error_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['contact_error.contact_error_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['email_lable.email_lable_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['email_lable.email_lable_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['email_placeholder.email_placeholder_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['email_placeholder.email_placeholder_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['email_error.email_error_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['email_error.email_error_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['phone_lable.phone_lable_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['phone_lable.phone_lable_' . $language->id . '.required' => 'This field is required.']);

            // $validationRule = array_merge($validationRule, ['phone_placeholder.phone_placeholder_' . $language->id => [$requiredVal, 'string']]);
            // $errorMessages = array_merge($errorMessages, ['phone_placeholder.phone_placeholder_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['phone_error.phone_error_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['phone_error.phone_error_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['address_lable.address_lable_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['address_lable.address_lable_' . $language->id . '.required' => 'This field is required.']);

            // $validationRule = array_merge($validationRule, ['address_placeholder.address_placeholder_' . $language->id => [$requiredVal, 'string']]);
            // $errorMessages = array_merge($errorMessages, ['address_placeholder.address_placeholder_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['address_error.address_error_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['address_error.address_error_' . $language->id . '.required' => 'This field is required.']);


            $validationRule = array_merge($validationRule, ['logo_lable.logo_lable_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['logo_lable.logo_lable_' . $language->id . '.required' => 'This field is required.']);

            // $validationRule = array_merge($validationRule, ['logo_placeholder.logo_placeholder_' . $language->id => [$requiredVal, 'string']]);
            // $errorMessages = array_merge($errorMessages, ['logo_placeholder.logo_placeholder_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['logo_error.logo_error_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['logo_error.logo_error_' . $language->id . '.required' => 'This field is required.']);



            $validationRule = array_merge($validationRule, ['media_title.media_title_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['media_title.media_title_' . $language->id . '.required' => 'This field is required.']);
            $validationRule = array_merge($validationRule, ['media_title_label.media_title_label_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['media_title_label.media_title_label_' . $language->id . '.required' => 'This field is required.']);
            $validationRule = array_merge($validationRule, ['media_title_error.media_title_error_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['media_title_error.media_title_error_' . $language->id . '.required' => 'This field is required.']);
            $validationRule = array_merge($validationRule, ['media_title_placeholder.media_title_placeholder_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['media_title_placeholder.media_title_placeholder_' . $language->id . '.required' => 'This field is required.']);
            $validationRule = array_merge($validationRule, ['media_description_label.media_description_label_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['media_description_label.media_description_label_' . $language->id . '.required' => 'This field is required.']);
            $validationRule = array_merge($validationRule, ['media_description_error.media_description_error_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['media_description_error.media_description_error_' . $language->id . '.required' => 'This field is required.']);
            $validationRule = array_merge($validationRule, ['media_description_placeholder.media_description_placeholder_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['media_description_placeholder.media_description_placeholder_' . $language->id . '.required' => 'This field is required.']);
            $validationRule = array_merge($validationRule, ['welcome_video_label.welcome_video_label_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['welcome_video_label.welcome_video_label_' . $language->id . '.required' => 'This field is required.']);
            $validationRule = array_merge($validationRule, ['welcome_video_error.welcome_video_error_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['welcome_video_error.welcome_video_error_' . $language->id . '.required' => 'This field is required.']);
            $validationRule = array_merge($validationRule, ['welcome_video_placeholder.welcome_video_placeholder_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['welcome_video_placeholder.welcome_video_placeholder_' . $language->id . '.required' => 'This field is required.']);
            $validationRule = array_merge($validationRule, ['keywords_label.keywords_label_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['keywords_label.keywords_label_' . $language->id . '.required' => 'This field is required.']);
            $validationRule = array_merge($validationRule, ['keywords_error.keywords_error_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['keywords_error.keywords_error_' . $language->id . '.required' => 'This field is required.']);
            $validationRule = array_merge($validationRule, ['keywords_placeholder.keywords_placeholder_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['keywords_placeholder.keywords_placeholder_' . $language->id . '.required' => 'This field is required.']);
            $validationRule = array_merge($validationRule, ['password_label.password_label_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['password_label.password_label_' . $language->id . '.required' => 'This field is required.']);
            $validationRule = array_merge($validationRule, ['password_error.password_error_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['password_error.password_error_' . $language->id . '.required' => 'This field is required.']);
            $validationRule = array_merge($validationRule, ['password_placeholder.password_placeholder_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['password_placeholder.password_placeholder_' . $language->id . '.required' => 'This field is required.']);
            $validationRule = array_merge($validationRule, ['confirm_password_label.confirm_password_label_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['confirm_password_label.confirm_password_label_' . $language->id . '.required' => 'This field is required.']);
            $validationRule = array_merge($validationRule, ['confirm_password_error.confirm_password_error_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['confirm_password_error.confirm_password_error_' . $language->id . '.required' => 'This field is required.']);
            $validationRule = array_merge($validationRule, ['confirm_password_placeholder.confirm_password_placeholder_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['confirm_password_placeholder.confirm_password_placeholder_' . $language->id . '.required' => 'This field is required.']);
            $validationRule = array_merge($validationRule, ['file_lable.file_lable_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['file_lable.file_lable_' . $language->id . '.required' => 'This field is required.']);

            // $validationRule = array_merge($validationRule, ['file_placeholder.file_placeholder_' . $language->id => [$requiredVal, 'string']]);
            // $errorMessages = array_merge($errorMessages, ['file_placeholder.file_placeholder_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['file_error.file_error_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['file_error.file_error_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['facebook_lable.facebook_lable_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['facebook_lable.facebook_lable_' . $language->id . '.required' => 'This field is required.']);

            // $validationRule = array_merge($validationRule, ['facebook_placeholder.facebook_placeholder_' . $language->id => [$requiredVal, 'string']]);
            // $errorMessages = array_merge($errorMessages, ['facebook_placeholder.facebook_placeholder_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['facebook_error.facebook_error_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['facebook_error.facebook_error_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['twitter_lable.twitter_lable_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['twitter_lable.twitter_lable_' . $language->id . '.required' => 'This field is required.']);

            // $validationRule = array_merge($validationRule, ['twitter_placeholder.twitter_placeholder_' . $language->id => [$requiredVal, 'string']]);
            // $errorMessages = array_merge($errorMessages, ['twitter_placeholder.twitter_placeholder_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['twitter_error.twitter_error_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['twitter_error.twitter_error_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['youtube_lable.youtube_lable_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['youtube_lable.youtube_lable_' . $language->id . '.required' => 'This field is required.']);

            // $validationRule = array_merge($validationRule, ['youtube_placeholder.youtube_placeholder_' . $language->id => [$requiredVal, 'string']]);
            // $errorMessages = array_merge($errorMessages, ['youtube_placeholder.youtube_placeholder_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['youtube_error.youtube_error_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['youtube_error.youtube_error_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['linkedin_lable.linkedin_lable_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['linkedin_lable.linkedin_lable_' . $language->id . '.required' => 'This field is required.']);

            // $validationRule = array_merge($validationRule, ['linkedin_placeholder.linkedin_placeholder_' . $language->id => [$requiredVal, 'string']]);
            // $errorMessages = array_merge($errorMessages, ['linkedin_placeholder.linkedin_placeholder_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['linkedin_error.linkedin_error_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['linkedin_error.linkedin_error_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['privacy_text_1.privacy_text_1_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['privacy_text_1.privacy_text_1_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['privacy_text_2.privacy_text_2_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['privacy_text_2.privacy_text_2_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['proceed_button_text.proceed_button_text_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['proceed_button_text.proceed_button_text_' . $language->id . '.required' => 'This field is required.']);
            $validationRule = array_merge($validationRule, ['social_media_title.social_media_title_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['social_media_title.social_media_title_' . $language->id . '.required' => 'This field is required.']);
            $validationRule = array_merge($validationRule, ['social_media_heading_text.social_media_heading_text_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['social_media_heading_text.social_media_heading_text_' . $language->id . '.required' => 'This field is required.']);
            $validationRule = array_merge($validationRule, ['media_heading_text.media_heading_text_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['media_heading_text.media_heading_text_' . $language->id . '.required' => 'This field is required.']);
            $validationRule = array_merge($validationRule, ['business_category_heading_text.business_category_heading_text_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['business_category_heading_text.business_category_heading_text_' . $language->id . '.required' => 'This field is required.']);
            $validationRule = array_merge($validationRule, ['business_profile_heading_text.business_profile_heading_text_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['business_profile_heading_text.business_profile_heading_text_' . $language->id . '.required' => 'This field is required.']);
            $validationRule = array_merge($validationRule, ['registration_package_heading_text.registration_package_heading_text_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['registration_package_heading_text.registration_package_heading_text_' . $language->id . '.required' => 'This field is required.']);
        }

        $this->validate($request, $validationRule, $errorMessages);

        $registerBusiness = RegisterBusiness::firstOrCreate();
        $registerBusiness->touch();
        foreach ($languages as $language) {
            $registerBusinessDetail = RegisterBusinessDetail::whereLanguageId($language->id)
                ->whereRegisterBusinessId($registerBusiness->id)
                ->exists();

            $fields = [
                'page_title' => $request['page_title']['page_title_' . $language->id],
                'package_section_title' => $request['package_section_title']['package_section_title_' . $language->id] ?? null,
                'business_category_text' => $request['business_category_text']['business_category_text_' . $language->id] ?? null,
                'business_category_2_lable' => $request['business_category_2_lable']['business_category_2_lable_' . $language->id],
                'business_category_2_placeholder' => $request['business_category_2_placeholder']['business_category_2_placeholder_' . $language->id],
                'business_category_2_error' => $request['business_category_2_error']['business_category_2_error_' . $language->id],
                'business_category_3_lable' => $request['business_category_3_lable']['business_category_3_lable_' . $language->id],
                'business_category_3_placeholder' => $request['business_category_3_placeholder']['business_category_3_placeholder_' . $language->id],
                'business_category_3_error' => $request['business_category_3_error']['business_category_3_error_' . $language->id],
                'business_category_1_lable' => $request['business_category_1_lable']['business_category_1_lable_' . $language->id],
                'business_category_1_placeholder' => $request['business_category_1_placeholder']['business_category_1_placeholder_' . $language->id],
                'business_category_1_error' => $request['business_category_1_error']['business_category_1_error_' . $language->id],
                'description_lable' => $request['description_lable']['description_lable_' . $language->id],
                'description_placeholder' => $request['description_placeholder']['description_placeholder_' . $language->id],
                'description_error' => $request['description_error']['description_error_' . $language->id],
                'detail_description_lable' => $request['detail_description_lable']['detail_description_lable_' . $language->id] ?? null,
                'detail_description_placeholder' => $request['detail_description_placeholder']['detail_description_placeholder_' . $language->id] ?? null,
                'detail_description_error' => $request['detail_description_error']['detail_description_error_' . $language->id] ?? null,
                'name_lable' => $request['name_lable']['name_lable_' . $language->id],
                'name_placeholder' => $request['name_placeholder']['name_placeholder_' . $language->id],
                'name_error' => $request['name_error']['name_error_' . $language->id],
                'website_url_lable' => $request['website_url_lable']['website_url_lable_' . $language->id],
                'website_url_placeholder' => $request['website_url_placeholder']['website_url_placeholder_' . $language->id],
                'website_url_error' => $request['website_url_error']['website_url_error_' . $language->id],

                'contact_lable' => $request['contact_lable']['contact_lable_' . $language->id],
                'contact_placeholder' => $request['contact_placeholder']['contact_placeholder_' . $language->id],
                'contact_error' => $request['contact_error']['contact_error_' . $language->id],

                'email_lable' => $request['email_lable']['email_lable_' . $language->id],
                'email_placeholder' => $request['email_placeholder']['email_placeholder_' . $language->id],
                'email_error' => $request['email_error']['email_error_' . $language->id],
                'phone_lable' => $request['phone_lable']['phone_lable_' . $language->id],
                'phone_placeholder' => $request['phone_placeholder']['phone_placeholder_' . $language->id],
                'phone_error' => $request['phone_error']['phone_error_' . $language->id],
                'address_lable' => $request['address_lable']['address_lable_' . $language->id],
                'address_placeholder' => $request['address_placeholder']['address_placeholder_' . $language->id],
                'address_error' => $request['address_error']['address_error_' . $language->id],
                'logo_lable' => $request['logo_lable']['logo_lable_' . $language->id],
                'logo_placeholder' => $request['logo_placeholder']['logo_placeholder_' . $language->id],
                'logo_error' => $request['logo_error']['logo_error_' . $language->id],
                'media_title' => $request['media_title']['media_title_' . $language->id],
                'file_lable' => $request['file_lable']['file_lable_' . $language->id],
                'media_title_label' => $request['media_title_label']['media_title_label_' . $language->id],
                'media_title_placeholder' => $request['media_title_placeholder']['media_title_placeholder_' . $language->id],
                'media_title_error' => $request['media_title_error']['media_title_error_' . $language->id],
                'media_description_label' => $request['media_description_label']['media_description_label_' . $language->id],
                'media_description_placeholder' => $request['media_description_placeholder']['media_description_placeholder_' . $language->id],
                'media_description_error' => $request['media_description_error']['media_description_error_' . $language->id],
                'welcome_video_label' => $request['welcome_video_label']['welcome_video_label_' . $language->id] ?? null,
                'welcome_video_placeholder' => $request['welcome_video_placeholder']['welcome_video_placeholder_' . $language->id] ?? null,
                'welcome_video_error' => $request['welcome_video_error']['welcome_video_error_' . $language->id] ?? null,
                'keywords_label' => $request['keywords_label']['keywords_label_' . $language->id] ?? null,
                'keywords_placeholder' => $request['keywords_placeholder']['keywords_placeholder_' . $language->id] ?? null,
                'keywords_error' => $request['keywords_error']['keywords_error_' . $language->id] ?? null,
                'password_label' => $request['password_label']['password_label_' . $language->id] ?? null,
                'password_placeholder' => $request['password_placeholder']['password_placeholder_' . $language->id] ?? null,
                'password_error' => $request['password_error']['password_error_' . $language->id] ?? null,
                'confirm_password_label' => $request['confirm_password_label']['confirm_password_label_' . $language->id] ?? null,
                'confirm_password_placeholder' => $request['confirm_password_placeholder']['confirm_password_placeholder_' . $language->id] ?? null,
                'confirm_password_error' => $request['confirm_password_error']['confirm_password_error_' . $language->id] ?? null,
                'file_placeholder' => $request['file_placeholder']['file_placeholder_' . $language->id],
                'file_error' => $request['file_error']['file_error_' . $language->id],
                'facebook_lable' => $request['facebook_lable']['facebook_lable_' . $language->id],
                'facebook_placeholder' => $request['facebook_placeholder']['facebook_placeholder_' . $language->id],
                'facebook_error' => $request['facebook_error']['facebook_error_' . $language->id],
                'twitter_lable' => $request['twitter_lable']['twitter_lable_' . $language->id],
                'twitter_placeholder' => $request['twitter_placeholder']['twitter_placeholder_' . $language->id],
                'twitter_error' => $request['twitter_error']['twitter_error_' . $language->id],
                'youtube_lable' => $request['youtube_lable']['youtube_lable_' . $language->id],
                'youtube_placeholder' => $request['youtube_placeholder']['youtube_placeholder_' . $language->id],
                'youtube_error' => $request['youtube_error']['youtube_error_' . $language->id],
                'linkedin_lable' => $request['linkedin_lable']['linkedin_lable_' . $language->id],
                'linkedin_placeholder' => $request['linkedin_placeholder']['linkedin_placeholder_' . $language->id],
                'linkedin_error' => $request['linkedin_error']['linkedin_error_' . $language->id],
                'privacy_text_1' => $request['privacy_text_1']['privacy_text_1_' . $language->id],
                'privacy_text_2' => $request['privacy_text_2']['privacy_text_2_' . $language->id],
                'proceed_button_text' => $request['proceed_button_text']['proceed_button_text_' . $language->id] ?? null,
                'social_media_title' => $request['social_media_title']['social_media_title_' . $language->id] ?? null,
                'social_media_heading_text' => $request['social_media_heading_text']['social_media_heading_text_' . $language->id] ?? null,
                'media_heading_text' => $request['media_heading_text']['media_heading_text_' . $language->id] ?? null,
                'business_category_heading_text' => $request['business_category_heading_text']['business_category_heading_text_' . $language->id] ?? null,
                'business_profile_heading_text' => $request['business_profile_heading_text']['business_profile_heading_text_' . $language->id] ?? null,
                'registration_package_heading_text' => $request['registration_package_heading_text']['registration_package_heading_text_' . $language->id] ?? null,

            ];
            if ($registerBusinessDetail) {
                RegisterBusinessDetail::whereLanguageId($language->id)
                    ->whereRegisterBusinessId($registerBusiness->id)
                    ->update($fields);
            } else {
                $fields = array_merge($fields, ['register_business_id' => $registerBusiness->id]);
                $fields = array_merge($fields, ['language_id' => $language->id]);
                RegisterBusinessDetail::create($fields);
            }
        }

        if ($registerBusiness) {
            return $this->apiSuccessResponse(new RegisterBusinessResource($registerBusiness), 'Your changes have been done successfully');
        }
        return $this->errorResponse();
    }
}
