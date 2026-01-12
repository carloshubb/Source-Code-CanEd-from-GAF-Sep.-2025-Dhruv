<?php

namespace Database\Seeders;

use App\Models\StaticTranslation;
use App\Models\StaticTranslationDetail;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class StaticTranslationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Schema::disableForeignKeyConstraints();
        // StaticTranslationDetail::truncate();
        // StaticTranslation::truncate();
        // Schema::enableForeignKeyConstraints();
        $lang = getDefaultLanguage();
        // // General Settings
        $result = StaticTranslation::where('type', 'general')->first();
        if(!$result){
            $result = StaticTranslation::create([
                'display_text' => 'Static translations',
                'type' => 'general',
            ]);
        }
        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'add_to_favorites_text')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'add_to_favorites_text',
                'display_text' => 'Add to favorites',
            ]);
        }
        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'indicate_required_field_text')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'indicate_required_field_text',
                'display_text' => 'Indicate Required Fields Text',
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'search_yield_error_text')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'search_yield_error_text',
                'display_text' => 'Search Yield Error Text',
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'language_switch_modal_title')->first();
        if (!$staticTranslationDetail) {
            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'language_switch_modal_title',
                'display_text' => 'Language switch modal title',
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'account_profile_menu_text')->first();
        if (!$staticTranslationDetail) {
            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'account_profile_menu_text',
                'display_text' => 'Account Profile Menu Text',
            ]);
        }
        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'login_menu_text')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'login_menu_text',
                'display_text' => 'Login Menu Text',
            ]);
        }
        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'logout_menu_text')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'logout_menu_text',
                'display_text' => 'Logout Menu Text',
            ]);
        }
        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'add_master_application_text')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'add_master_application_text',
                'display_text' => 'Add Master Application Text',
            ]);
        }
        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'upgrade_plan_menu_text')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'upgrade_plan_menu_text',
                'display_text' => 'Upgrade Plan menu text',
            ]);
        }
        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'register_user_message_text')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'register_user_message_text',
                'display_text' => 'Register user successs popup text',
            ]);
        }
        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'verification_email_message_text')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'verification_email_message_text',
                'display_text' => 'Verification email successs popup text',
            ]);
        }
        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'ambassador_chat_menu_text')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'ambassador_chat_menu_text',
                'display_text' => 'Ambassador Chat Menu Text',
            ]);
        }
        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'student_chat_menu_text')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'student_chat_menu_text',
                'display_text' => 'Student Chat Menu Text',
            ]);
        }
        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'advance_search_button_text')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'advance_search_button_text',
                'display_text' => 'Advance Search Button Text',
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'advance_search_input_text')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'advance_search_input_text',
                'display_text' => 'Advance Search input Placeholder',
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'more_articles_text')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'more_articles_text',
                'display_text' => 'More Articles Text',
            ]);
        }
        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'help_full_articles_text')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'help_full_articles_text',
                'display_text' => 'Helpfull Articles Text',
            ]);
        }

        
        //Virtual Tour

        $result = StaticTranslation::where('type', 'virtual_tours')->first();
        if(!$result){
            $result = StaticTranslation::create([
                'display_text' => 'Virtual tour static translations',
                'type' => 'virtual_tours',
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'post_your_virtual_tour_text')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'post_your_virtual_tour_text',
                'display_text' => 'Post Virtual Tour Text',
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'virtual_tour_hover_text')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'virtual_tour_hover_text',
                'display_text' => 'Virtual tour hover text',
            ]);
        }

        // Add Network
        $translationsToCreate = [
            'submit_banner_button_text' => 'Submit banner text button',
            'modal_title' => 'Modal Title',
            'note_text' => 'Note Text',
            'point_1_text' => 'Point 1 text',
            'banner_location' => 'Banner Location',
            'point_2_text' => 'Point 2 text',
            'full_name_label'=> 'Full Name',
            'description_label' => 'Description',
            'state_province_label' => 'State / province',
            'phone_number_label' => 'Phone number',
            'email_label' => 'Email',
            'country_label' => 'Country',
            'banner_url_label' => 'Banner Url',
            'image_label' => 'Image Label',
            'submit_button_text' => 'Submit Button Text',
        ];
        $result = StaticTranslation::where('type', 'network')->first();
        if(!$result){
            $result = StaticTranslation::create([
                'display_text' => 'Network static translations',
                'type' => 'network',
            ]);
        }
        foreach ($translationsToCreate as $key => $displayText) {
            $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)
                ->where('static_translation_id', $result->id)
                ->where('key', $key)
                ->first();
        
            if (!$staticTranslationDetail) {
                StaticTranslationDetail::create([
                    'language_id' => $lang->id,
                    'static_translation_id' => $result->id,
                    'key' => $key,
                    'display_text' => $displayText,
                ]);
            }
        }

        // business detail
        $result = StaticTranslation::where('type', 'businesses')->first();
        if (!$result) {
            $result = StaticTranslation::create([
                'display_text' => 'Business static translations',
                'type' => 'business',
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)
            ->where('static_translation_id', $result->id)
            ->where('key', 'contact_heading')
            ->first();
        if (!$staticTranslationDetail) {
            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'contact_heading',
                'display_text' => 'Contact Heading',
            ]);
        }
        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)
        ->where('static_translation_id', $result->id)
        ->where('key', 'company_name_text')
        ->first();
    if (!$staticTranslationDetail) {
        StaticTranslationDetail::create([
            'language_id' => $lang->id,
            'static_translation_id' => $result->id,
            'key' => 'company_name_text',
            'display_text' => 'Company Name Text',
        ]);
    }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)
            ->where('static_translation_id', $result->id)
            ->where('key', 'quick_fact_heading')
            ->first();
        if (!$staticTranslationDetail) {
            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'quick_fact_heading',
                'display_text' => 'Quick Fact Heading',
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)
            ->where('static_translation_id', $result->id)
            ->where('key', 'business_category_heading')
            ->first();
        if (!$staticTranslationDetail) {
            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'business_category_heading',
                'display_text' => 'Business Category',
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)
        ->where('static_translation_id', $result->id)
        ->where('key', 'register_business_button_text')
        ->first();
    if (!$staticTranslationDetail) {
        StaticTranslationDetail::create([
            'language_id' => $lang->id,
            'static_translation_id' => $result->id,
            'key' => 'register_business_button_text',
            'display_text' => 'Register Business Button text',
        ]);
    }

    $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)
    ->where('static_translation_id', $result->id)
    ->where('key', 'register_business_search_placeholder_text')
    ->first();
if (!$staticTranslationDetail) {
    StaticTranslationDetail::create([
        'language_id' => $lang->id,
        'static_translation_id' => $result->id,
        'key' => 'register_business_search_placeholder_text',
        'display_text' => 'Register Business Placeholder text',
    ]);
}

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)
            ->where('static_translation_id', $result->id)
            ->where('key', 'description_heading')
            ->first();
        if (!$staticTranslationDetail) {
            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'description_heading',
                'display_text' => 'Description Heading',
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)
            ->where('static_translation_id', $result->id)
            ->where('key', 'contact_person_heading')
            ->first();
        if (!$staticTranslationDetail) {
            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'contact_person_heading',
                'display_text' => 'Contact PErson Heading',
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)
            ->where('static_translation_id', $result->id)
            ->where('key', 'email_heading')
            ->first();
        if (!$staticTranslationDetail) {
            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'email_heading',
                'display_text' => 'Email Heading',
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)
            ->where('static_translation_id', $result->id)
            ->where('key', 'phone_heading')
            ->first();
        if (!$staticTranslationDetail) {
            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'phone_heading',
                'display_text' => 'Phone heading',
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)
            ->where('static_translation_id', $result->id)
            ->where('key', 'address_heading')
            ->first();
        if (!$staticTranslationDetail) {
            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'address_heading',
                'display_text' => 'Address heading',
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)
            ->where('static_translation_id', $result->id)
            ->where('key', 'related_business_heading')
            ->first();
        if (!$staticTranslationDetail) {
            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'related_business_heading',
                'display_text' => 'Related business heading',
            ]);
        }

        //scholarship

        $result = StaticTranslation::where('type', 'scholarships')->first();
        if (!$result) {
            $result = StaticTranslation::create([
                'display_text' => 'Scholarship translations',
                'type' => 'scholarship',
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)
            ->where('static_translation_id', $result->id)
            ->where('key', 'name_text')
            ->first();
        if (!$staticTranslationDetail) {
            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'name_text',
                'display_text' => 'Name Text',
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)
            ->where('static_translation_id', $result->id)
            ->where('key', 'summary_text')
            ->first();
        if (!$staticTranslationDetail) {
            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'summary_text',
                'display_text' => 'Summary Text',
            ]);
        }
        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)
            ->where('static_translation_id', $result->id)
            ->where('key', 'add_scholarship_button_text')
            ->first();
        if (!$staticTranslationDetail) {
            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'add_scholarship_button_text',
                'display_text' => 'Add Scholarship button Text',
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)
            ->where('static_translation_id', $result->id)
            ->where('key', 'learn_more_button_text')
            ->first();
        if (!$staticTranslationDetail) {
            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'learn_more_button_text',
                'display_text' => 'Learn more button text',
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)
            ->where('static_translation_id', $result->id)
            ->where('key', 'apply_now_button_text')
            ->first();
        if (!$staticTranslationDetail) {
            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'apply_now_button_text',
                'display_text' => 'Apply now button text',
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)
            ->where('static_translation_id', $result->id)
            ->where('key', 'more_scholarship_text')
            ->first();
        if (!$staticTranslationDetail) {
            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'more_scholarship_text',
                'display_text' => 'More Scholarship Text',
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)
            ->where('static_translation_id', $result->id)
            ->where('key', 'school_text')
            ->first();
        if (!$staticTranslationDetail) {
            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'school_text',
                'display_text' => 'School Label Text',
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)
            ->where('static_translation_id', $result->id)
            ->where('key', 'province_text')
            ->first();
        if (!$staticTranslationDetail) {
            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'province_text',
                'display_text' => 'Province Label Text',
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)
            ->where('static_translation_id', $result->id)
            ->where('key', 'amount_text')
            ->first();
        if (!$staticTranslationDetail) {
            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'amount_text',
                'display_text' => 'Amount Label Text',
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)
            ->where('static_translation_id', $result->id)
            ->where('key', 'award_text')
            ->first();
        if (!$staticTranslationDetail) {
            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'award_text',
                'display_text' => 'Award Label Text',
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)
            ->where('static_translation_id', $result->id)
            ->where('key', 'action_text')
            ->first();
        if (!$staticTranslationDetail) {
            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'action_text',
                'display_text' => 'Action label text',
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)
            ->where('static_translation_id', $result->id)
            ->where('key', 'duration_text')
            ->first();
        if (!$staticTranslationDetail) {
            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'duration_text',
                'display_text' => 'Duration text',
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)
            ->where('static_translation_id', $result->id)
            ->where('key', 'date_posted_text')
            ->first();
        if (!$staticTranslationDetail) {
            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'date_posted_text',
                'display_text' => 'Date Posted text',
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)
            ->where('static_translation_id', $result->id)
            ->where('key', 'deadline_text')
            ->first();
        if (!$staticTranslationDetail) {
            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'deadline_text',
                'display_text' => 'Deadline Text',
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)
            ->where('static_translation_id', $result->id)
            ->where('key', 'expiry_date_text')
            ->first();
        if (!$staticTranslationDetail) {
            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'expiry_date_text',
                'display_text' => 'Expiry Date Text',
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)
            ->where('static_translation_id', $result->id)
            ->where('key', 'level_of_study_text')
            ->first();
        if (!$staticTranslationDetail) {
            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'level_of_study_text',
                'display_text' => 'Level of study text',
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)
            ->where('static_translation_id', $result->id)
            ->where('key', 'availability_text')
            ->first();
        if (!$staticTranslationDetail) {
            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'availability_text',
                'display_text' => 'Availability Text',
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)
            ->where('static_translation_id', $result->id)
            ->where('key', 'email_text')
            ->first();
        if (!$staticTranslationDetail) {
            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'email_text',
                'display_text' => 'Email Text',
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)
            ->where('static_translation_id', $result->id)
            ->where('key', 'phone_text')
            ->first();
        if (!$staticTranslationDetail) {
            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'phone_text',
                'display_text' => 'Phone Text',
            ]);
        }

        // proximatch
        $result = StaticTranslation::where('type', 'proximatch')->first();
        if (!$result) {
            $result = StaticTranslation::create([
                'display_text' => 'Proximatch modal translations',
                'type' => 'proximatch',
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'open_modal_button_text')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'open_modal_button_text',
                'display_text' => 'Call to action button text',
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'modal_title')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'modal_title',
                'display_text' => 'Modal Title',
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'close_modal_button_text')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'close_modal_button_text',
                'display_text' => 'Close Modal Button Text',
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'name_input_label')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'name_input_label',
                'display_text' => 'Name input field label',
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'name_input_placeholder')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'name_input_placeholder',
                'display_text' => 'Name input field placeholder',
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'phone_input_label')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'phone_input_label',
                'display_text' => 'Phone input field label',
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'phone_input_placeholder')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'phone_input_placeholder',
                'display_text' => 'Phone input field placeholder',
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'email_input_label')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'email_input_label',
                'display_text' => 'Email input field label',
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'email_input_placeholder')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'email_input_placeholder',
                'display_text' => 'Email input field placeholder',
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'inquiry_input_label')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'inquiry_input_label',
                'display_text' => 'Inquiry input field label',
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'inquiry_input_placeholder')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'inquiry_input_placeholder',
                'display_text' => 'Inquiry input field placeholder',
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'submit_button_text')->first();
        if (!$staticTranslationDetail) {
            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'submit_button_text',
                'display_text' => 'Submit Button Text',
            ]);
        }

        
        // payment and profile

        $result = StaticTranslation::where('type', 'payment_profile')->first();
        if (!$result) {
            $result = StaticTranslation::create([
                'display_text' => 'Payment profiel and upgrad plan translations',
                'type' => 'payment_profile',
            ]);
        }
        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'title')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'title',
                'display_text' => 'Page Title',
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'review_page_title')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'review_page_title',
                'display_text' => 'Review & Confirm Page Title',
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'description')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'description',
                'display_text' => 'Page Description',
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'member_ship_description')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'member_ship_description',
                'display_text' => 'MemberShip Page Description',
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'package_title')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'package_title',
                'display_text' => 'Registration Package Title',
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'subscription_day_text')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'subscription_day_text',
                'display_text' => 'Subscription days text',
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'subscription_day_fee_text')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'subscription_day_fee_text',
                'display_text' => 'Subscription days fee text',
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'stripe_payment_radio_title')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'stripe_payment_radio_title',
                'display_text' => 'Stripe Radio box text',
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'card_holder_name_label')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'card_holder_name_label',
                'display_text' => 'Card holder Name input field label',
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'card_holder_name_placeholder')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'card_holder_name_placeholder',
                'display_text' => 'Card holder Name input field placeholder',
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'card_no_input_label')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'card_no_input_label',
                'display_text' => 'Card no input field label',
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'card_no_input_placeholder')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'card_no_input_placeholder',
                'display_text' => 'Card no input field placeholder',
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'cvc_input_label')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'cvc_input_label',
                'display_text' => 'CVC input field label',
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'cvc_input_placeholder')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'cvc_input_placeholder',
                'display_text' => 'CVC input field placeholder',
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'expiry_year_input_label')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'expiry_year_input_label',
                'display_text' => 'Expiry Year input field label',
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'expiry_year_input_placeholder')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'expiry_year_input_placeholder',
                'display_text' => 'Expiry Year input field placeholder',
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'expiry_month_input_label')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'expiry_month_input_label',
                'display_text' => 'Expiry Month input field label',
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'expiry_month_input_placeholder')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'expiry_month_input_placeholder',
                'display_text' => 'Expiry Month input field placeholder',
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'paypal_payment_radio_title')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'paypal_payment_radio_title',
                'display_text' => 'Paypal Radio box text',
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'paypal_description_title')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'paypal_description_title',
                'display_text' => 'Paypal Description Title',
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'paypal_description')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'paypal_description',
                'display_text' => 'Paypal Description',
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'confirm_button_text')->first();
        if (!$staticTranslationDetail) {
            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'confirm_button_text',
                'display_text' => 'Confirm Button Text',
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'resume_auto_renew_button_text')->first();
        if (!$staticTranslationDetail) {
            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'resume_auto_renew_button_text',
                'display_text' => 'Resume Auto Renew button text',
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'cancel_auto_renew_text')->first();
        if (!$staticTranslationDetail) {
            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'cancel_auto_renew_text',
                'display_text' => 'Cancel Auto Renew button text',
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'choose_from_existing_card')->first();
        if (!$staticTranslationDetail) {
            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'choose_from_existing_card',
                'display_text' => 'Choose From Existing card Text',
            ]);
        }

        // Business Directory page

        $result = StaticTranslation::where('type', 'business_directory_search')->first();
        if (!$result) {
            $result = StaticTranslation::create([
                'display_text' => 'Business directory search page',
                'type' => 'business_directory_search',
            ]);
        }
        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'title')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'title',
                'display_text' => 'Page Title',
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'name_label_text')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'name_label_text',
                'display_text' => 'Name Label Text',
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'province_label_text')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'province_label_text',
                'display_text' => 'Province Label Text',
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'city_label_text')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'city_label_text',
                'display_text' => 'City Label Text',
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'industry_label_text')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'industry_label_text',
                'display_text' => 'Industry Label Text',
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'postal_code_label_text')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'postal_code_label_text',
                'display_text' => 'Postal code Label Text',
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'phone_label_text')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'phone_label_text',
                'display_text' => 'phone Label Text',
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'address_label_text')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'address_label_text',
                'display_text' => 'Address Label Text',
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'fax_label_text')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'fax_label_text',
                'display_text' => 'Fax Label Text',
            ]);
        }
        //scholarship advance search modal
        $result = StaticTranslation::where('type', 'scholarship_modal')->first();
        if (!$result) {
            $result = StaticTranslation::create([
                'display_text' => 'Scholarship modal static translations',
                'type' => 'scholarship_modal',
            ]);
        }

        $translationsToCreate = [
            'open_modal_text' => 'Advance Search button modal',
            'modal_title' => 'Modal Title',
            'school_name_input_label' => 'School Name input field label',
            'school_input_label' => 'School input field label',
            'province_input_label' => 'Province input field label',
            'award_input_label' => 'Award input field label',
            'action_input_label' => 'Action input field label',
            'availability_input_label' => 'Availability input field label',
            'level_of_study_input_label' => 'Level of study input field label',
            'duration_input_label' => 'Duration input field label',
            'submit_button_text' => 'Submit Button Text',
        ];

        foreach ($translationsToCreate as $key => $displayText) {
            $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)
                ->where('static_translation_id', $result->id)
                ->where('key', $key)
                ->first();

            if (!$staticTranslationDetail) {
                StaticTranslationDetail::create([
                    'language_id' => $lang->id,
                    'static_translation_id' => $result->id,
                    'key' => $key,
                    'display_text' => $displayText,
                ]);
            }
        }
        //career
    
         $result = StaticTranslation::where('type', 'career_page')->first();
        if(!$result){
            $result = StaticTranslation::create([
                'display_text' => 'Career page static translations',
                'type' => 'career_page',
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'title_label_text')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'title_label_text',
                'display_text' => 'Title label text',
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'definition_label_text')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'definition_label_text',
                'display_text' => 'Definition label text',
            ]);
        }

        // $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'h_structure_label_text')->first();
        // if (!$staticTranslationDetail) {

        //     StaticTranslationDetail::create([
        //         'language_id' => $lang->id,
        //         'static_translation_id' => $result->id,
        //         'key' => 'h_structure_label_text',
        //         'display_text' => 'Hierarchical label text',
        //     ]);
        // }

        // $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'level_label_text')->first();
        // if (!$staticTranslationDetail) {

        //     StaticTranslationDetail::create([
        //         'language_id' => $lang->id,
        //         'static_translation_id' => $result->id,
        //         'key' => 'level_label_text',
        //         'display_text' => 'Level label text',
        //     ]);
        // }

        // $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'code_label_text')->first();
        // if (!$staticTranslationDetail) {

        //     StaticTranslationDetail::create([
        //         'language_id' => $lang->id,
        //         'static_translation_id' => $result->id,
        //         'key' => 'code_label_text',
        //         'display_text' => 'Code label text',
        //     ]);
        // }
        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'career_search_placeholder_text')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'career_search_placeholder_text',
                'display_text' => 'Career search placeholder text',
            ]);
        }

        $result = StaticTranslation::where('type', 'webinar_page')->first();
        if(!$result){
            $result = StaticTranslation::create([
                'display_text' => 'Webinar page static translations',
                'type' => 'webinar_page',
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'more_heading_text')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'more_heading_text',
                'display_text' => 'More heading text',
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'start_date_label_text')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'start_date_label_text',
                'display_text' => 'Start date label text',
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'timezone_label_text')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'timezone_label_text',
                'display_text' => 'Time zone label text',
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'duration_label_text')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'duration_label_text',
                'display_text' => 'Duration label text',
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'join_webinar_button_text')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'join_webinar_button_text',
                'display_text' => 'Join webinar button text',
            ]);
        }

        $result = StaticTranslation::where('type', 'advance_search')->first();
        if(!$result){
            $result = StaticTranslation::create([
                'display_text' => 'Advance search static translations',
                'type' => 'advance_search',
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'page_title')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'page_title',
                'display_text' => 'Page title',
            ]);
        }
        
        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'page_sub_title')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'page_sub_title',
                'display_text' => 'Page subtitle',
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'degree_level_input_label')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'degree_level_input_label',
                'display_text' => 'Degree Level input label',
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'field_of_study_input_label')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'field_of_study_input_label',
                'display_text' => 'Field of study input label',
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'planning_input_label')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'planning_input_label',
                'display_text' => 'When you are Planning to start input label',
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'where_want_to_study_input_label')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'where_want_to_study_input_label',
                'display_text' => 'Where you want  to study  input label',
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'online_offline_input_label')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'online_offline_input_label',
                'display_text' => 'online / distance  input label',
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'i_want_to_become_input_label')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'i_want_to_become_input_label',
                'display_text' => 'i want to become  input label',
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'i_want_to_become_placehoder_text')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'i_want_to_become_placehoder_text',
                'display_text' => 'i want to become  placeholder text',
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'i_want_to_become_input_balloon')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'i_want_to_become_input_balloon',
                'display_text' => 'i want to become  input balloon',
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'school_type_input_label')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'school_type_input_label',
                'display_text' => 'school type  input label',
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'min_cgpa_input_label')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'min_cgpa_input_label',
                'display_text' => 'Min cgpa  input label',
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'conditional_admission_input_label')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'conditional_admission_input_label',
                'display_text' => 'Conditional admission availabel  input label',
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'program_type_graduation_input_label')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'program_type_graduation_input_label',
                'display_text' => 'Program type graduate  input label',
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'program_type_undergraduation_input_label')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'program_type_undergraduation_input_label',
                'display_text' => 'Program type undergraduate  input label',
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'program_type_undergraduation_input_balloon')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'program_type_undergraduation_input_balloon',
                'display_text' => 'Program type Undergraduate  input balloon',
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'im_interested_in_input_label')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'im_interested_in_input_label',
                'display_text' => 'i am interested in  input label',
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'delivery_mode_input_label')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'delivery_mode_input_label',
                'display_text' => 'Delivery mode in  input label',
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'housing_accomodation_input_label')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'housing_accomodation_input_label',
                'display_text' => 'Housing Accomodation in  input label',
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'work_study_program_input_label')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'work_study_program_input_label',
                'display_text' => 'Work Study Program in  input label',
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'work_study_program_input_balloon')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'work_study_program_input_balloon',
                'display_text' => 'Work Study Program in input balloon',
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'work_during_holidays_input_label')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'work_during_holidays_input_label',
                'display_text' => 'Work during holiday in  input label',
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'internship_input_label')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'internship_input_label',
                'display_text' => 'Internship in  input label',
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'internship_input_balloon')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'internship_input_balloon',
                'display_text' => 'Internship in input balloon',
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'coeducation_input_label')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'coeducation_input_label',
                'display_text' => 'Co education  input label',
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'coeducation_input_balloon')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'coeducation_input_balloon',
                'display_text' => 'Co education input balloon',
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'job_placement_input_label')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'job_placement_input_label',
                'display_text' => 'Job placement  input label',
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'job_placement_input_balloon')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'job_placement_input_balloon',
                'display_text' => 'Job placement input balloon',
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'financial_aid_program_domastic_input_label')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'financial_aid_program_domastic_input_label',
                'display_text' => 'Financial aid program domestic  input label',
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'financial_aid_programs_for_province_students')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'financial_aid_programs_for_province_students',
                'display_text' => 'Financial aid program province input label',
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'financial_aid_program_international_input_label')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'financial_aid_program_international_input_label',
                'display_text' => 'Financial aid program Internation  input label',
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'teaching_language_input_label')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'teaching_language_input_label',
                'display_text' => 'Teaching language program  input label',
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'research_dissertation_input_label')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'research_dissertation_input_label',
                'display_text' => 'Research and dissertation  input label',
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'exchange_programs_input_label')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'exchange_programs_input_label',
                'display_text' => 'Exchange program  input label',
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'degree_modifier_input_label')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'degree_modifier_input_label',
                'display_text' => 'Degree Modifier  input label',
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'day_care_for_students_kids_input_label')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'day_care_for_students_kids_input_label',
                'display_text' => 'Day care for students and kids  input label',
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'elementry_school_for_students_kids_input_label')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'elementry_school_for_students_kids_input_label',
                'display_text' => 'Elementry school for students and kids  input label',
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'immigration_office_on_campus_input_label')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'immigration_office_on_campus_input_label',
                'display_text' => 'Immigration office on campus  input label',
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'immigration_office_on_campus_input_balloon')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'immigration_office_on_campus_input_balloon',
                'display_text' => 'Immigration office on campus input balloon',
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'career_planning_input_label')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'career_planning_input_label',
                'display_text' => 'Career planning and development services  input label',
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'career_planning_input_balloon')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'career_planning_input_balloon',
                'display_text' => 'Career planning and development services input balloon',
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'pathway_programs_input_label')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'pathway_programs_input_label',
                'display_text' => 'Pathway programs  input label',
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'pathway_programs_input_balloon')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'pathway_programs_input_balloon',
                'display_text' => 'Pathway programs input balloon',
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'employeement_rates_input_label')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'employeement_rates_input_label',
                'display_text' => 'Employeement Rates  input label',
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'class_size_undergraduate_input_label')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'class_size_undergraduate_input_label',
                'display_text' => 'Class size undergraduates  input label',
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'class_size_graduate_input_label')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'class_size_graduate_input_label',
                'display_text' => 'class size graduates  input label',
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'class_size_master_input_label')->delete();
        // $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'class_size_master_input_label')->first();
        // if (!$staticTranslationDetail) {

        //     StaticTranslationDetail::create([
        //         'language_id' => $lang->id,
        //         'static_translation_id' => $result->id,
        //         'key' => 'class_size_master_input_label',
        //         'display_text' => 'class size master  input label',
        //     ]);
        // }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'service_and_guidance_to_new_students_input_label')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'service_and_guidance_to_new_students_input_label',
                'display_text' => 'Service and guidance to new students  input label',
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'service_and_guidance_to_new_arrivals_input_label')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'service_and_guidance_to_new_arrivals_input_label',
                'display_text' => 'Service and guidance to new arrivals in Canada  input label',
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'how_many_years_before_im_eligible_to_apply_for_pr_input_label')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'how_many_years_before_im_eligible_to_apply_for_pr_input_label',
                'display_text' => 'How many years before i become eligible to apply for pr input label',
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'work_while_study_off_campus_input_label')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'work_while_study_off_campus_input_label',
                'display_text' => 'Work while studying, off-campus input label',
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'city_input_label')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'city_input_label',
                'display_text' => 'city input label',
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'search_button_text')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'search_button_text',
                'display_text' => 'Search button text balloon',
            ]);
        }

        $result = StaticTranslation::where('type', 'forget_password')->first();
        if(!$result){
            $result = StaticTranslation::create([
                'display_text' => 'Forgot / Reset password',
                'type' => 'forget_password',
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'page_title')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'page_title',
                'display_text' => 'Forget password Page title',
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'forget_page_description')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'forget_page_description',
                'display_text' => 'Forget Page Description',
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'forget_email_label')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'forget_email_label',
                'display_text' => 'Forget Email label',
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'forget_email_placeholder')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'forget_email_placeholder',
                'display_text' => 'Forget Email placeholder',
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'forget_email_error')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'forget_email_error',
                'display_text' => 'Forget Email error',
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'forget_button_text')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'forget_button_text',
                'display_text' => 'Forget button text',
            ]);
        }


        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'forget_password_success_message_text')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'forget_password_success_message_text',
                'display_text' => 'Forget password success message text',
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'reset_page_title')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'reset_page_title',
                'display_text' => 'Reset page title',
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'reset_email_text')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'reset_email_text',
                'display_text' => 'Reset page email label',
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'reset_email_placeholder')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'reset_email_placeholder',
                'display_text' => 'Reset page email placeholder',
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'reset_password_text')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'reset_password_text',
                'display_text' => 'Reset page password label',
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'reset_password_placeholder')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'reset_password_placeholder',
                'display_text' => 'Reset page password placeholder',
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'reset_confirm_password_text')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'reset_confirm_password_text',
                'display_text' => 'Reset page confirm password label',
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'reset_confirm_password_placeholder')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'reset_confirm_password_placeholder',
                'display_text' => 'Reset page confirm password placeholder',
            ]);
        }

        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)->where('static_translation_id', $result->id)->where('key', 'reset_button_text')->first();
        if (!$staticTranslationDetail) {

            StaticTranslationDetail::create([
                'language_id' => $lang->id,
                'static_translation_id' => $result->id,
                'key' => 'reset_button_text',
                'display_text' => 'Reset button text',
            ]);
        }

        // Define the keys for the "contact_business" type
        $keys = [
            'open_modal_button_text',
            'modal_title',
            'business_name_input_placeholder',
            'business_email_input_placeholder',
            'business_message_input_placeholder',
            'business_name_input_label',
            'business_email_input_label',
            'business_message_input_label',
            'business_send_me_a_copy_text',
            'business_submit_button_text',
            'business_close_modal_button_text'
        ];

        // Find or create a StaticTranslation record for the "contact_business" type
        $result = StaticTranslation::where('type', 'contact_business')->first();
        if (!$result) {
            $result = StaticTranslation::create([
                'display_text' => 'Contact business static translations',
                'type' => 'contact_business',
            ]);
        }

        // Loop through the keys and create or update StaticTranslationDetail records
        foreach ($keys as $key) {
            $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)
                ->where('static_translation_id', $result->id)
                ->where('key', $key)
                ->first();

            if (!$staticTranslationDetail) {
                StaticTranslationDetail::create([
                    'language_id' => $lang->id,
                    'static_translation_id' => $result->id,
                    'key' => $key,
                    'display_text' => ucfirst(str_replace('_', ' ', $key)), // Convert snake_case to Title Case
                ]);
            }
        }

        
        // // Define the keys for the "contact_school" type
        $keys = [
            'open_modal_button_text',
            'modal_title',
            'school_name_input_placeholder',
            'school_email_input_placeholder',
            'school_message_input_placeholder',
            'school_name_input_label',
            'school_email_input_label',
            'school_message_input_label',
            'school_email_error',
            'school_message_error',
            'school_message_word_limit_error',
            'school_name_error',
            'school_send_me_a_copy_text',
            'school_submit_button_text',
            'school_close_modal_button_text',
            'register_button_text',
            'login_button_text',
            'main_heading_text',

        ];

        // Find or create a StaticTranslation record for the "contact_school" type
        $result = StaticTranslation::where('type', 'contact_school')->first();
        if (!$result) {
            $result = StaticTranslation::create([
                'display_text' => 'Contact school static translations',
                'type' => 'contact_school',
            ]);
        }

        // Loop through the keys and create or update StaticTranslationDetail records
        foreach ($keys as $key) {
            $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)
                ->where('static_translation_id', $result->id)
                ->where('key', $key)
                ->first();

            if (!$staticTranslationDetail) {
                StaticTranslationDetail::create([
                    'language_id' => $lang->id,
                    'static_translation_id' => $result->id,
                    'key' => $key,
                    'display_text' => ucfirst(str_replace('_', ' ', $key)), // Convert snake_case to Title Case
                ]);
            }
        }

        // Define the keys for the "open_house" type
        $keys = [
            'post_your_open_house_text',
            'more_open_house_text',
            'school_label_text',
            'address_label_text',
            'date_and_time_label_text',
            'open_house_location_text',
            'visit_website_button_text',
            'contact_orgnizer_button_text',
            'add_your_open_house_button_text',
            'open_house_orgnizer_modal_title',
            'open_house_name_input_placeholder',
            'open_house_name_label_text',
            'open_house_email_input_placeholder',
            'open_house_email_label_text',
            'open_house_message_input_placeholder',
            'open_house_message_label_text',
            'open_house_send_me_a_copy_text',
            'open_house_submit_button_text'
        ];

        // Find or create a StaticTranslation record for the "open_house" type
        $result = StaticTranslation::where('type', 'open_houses')->first();
        if (!$result) {
            $result = StaticTranslation::create([
                'display_text' => 'Open house static translations',
                'type' => 'open_houses',
            ]);
        }

        // Loop through the keys and create or update StaticTranslationDetail records
        foreach ($keys as $key) {
            $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)
                ->where('static_translation_id', $result->id)
                ->where('key', $key)
                ->first();

            if (!$staticTranslationDetail) {
                StaticTranslationDetail::create([
                    'language_id' => $lang->id,
                    'static_translation_id' => $result->id,
                    'key' => $key,
                    'display_text' => ucfirst(str_replace('_', ' ', $key)), // Convert snake_case to Title Case
                ]);
            }
        }

        // Define the keys for the "program" type
        $keys = [
            'modal_title',
            'close_modal_button_text',
            'name_input_label',
            'name_input_placeholder',
            'description_input_label',
            'description_input_placeholder',
            'degree_input_label',
            'degree_input_placeholder',
            'submit_button_text',
            'program_search_page_title',
            'program_school_page_title',
            'program_school_page_contact_us_button_text',
            'program_school_page_apply_now_button_text',
            'program_school_page_continue_reading_button_text',
            'keyword_search_input_placeholder',
            'degree_search_input_placeholder',
            'location_search_input_placeholder',
            'search_button_text',



        ];

        // Find or create a StaticTranslation record for the "program" type
        $result = StaticTranslation::where('type', 'program')->first();
        if (!$result) {
            $result = StaticTranslation::create([
                'display_text' => 'Program modal|Page static translations',
                'type' => 'program',
            ]);
        }

        // Loop through the keys and create or update StaticTranslationDetail records
        foreach ($keys as $key) {
            $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)
                ->where('static_translation_id', $result->id)
                ->where('key', $key)
                ->first();

            if (!$staticTranslationDetail) {
                StaticTranslationDetail::create([
                    'language_id' => $lang->id,
                    'static_translation_id' => $result->id,
                    'key' => $key,
                    'display_text' => ucfirst(str_replace('_', ' ', $key)), // Convert snake_case to Title Case
                ]);
            }
        }


        // Define the keys for the "ambassador" type
        $keys = [
            'about_me_label_text',
            'read_more_link_text',
            'chat_button_text',
            'profile_label_text',
            'i_came_from_label_text',
            'messaging_app_text',
            'city_label_text',
            'province_label_text',
            'i_speak_label_text',
            'degree_level_label_text',
            'favorite_module_label_text',
            'hobby_and_interest_label_text',
            'societies_label_text',
            'my_major_label_text',
            'my_minor_label_text',
            'category_label_text',
            'fav_module_label_text',
            'study_here_label_text',

        ];

        // Find or create a StaticTranslation record for the "ambassador" type
        $result = StaticTranslation::where('type', 'ambassador')->first();
        if (!$result) {
            $result = StaticTranslation::create([
                'display_text' => 'Ambassador static translations',
                'type' => 'ambassador',
            ]);
        }

        // Loop through the keys and create or update StaticTranslationDetail records
        foreach ($keys as $key) {
            $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)
                ->where('static_translation_id', $result->id)
                ->where('key', $key)
                ->first();

            if (!$staticTranslationDetail) {
                StaticTranslationDetail::create([
                    'language_id' => $lang->id,
                    'static_translation_id' => $result->id,
                    'key' => $key,
                    'display_text' => ucfirst(str_replace('_', ' ', $key)), // Convert snake_case to Title Case
                ]);
            }
        }



        // Define the keys for the "ambassador" type
        $keys = [
            'advance_search_scholarship_item_text',
            'advance_search_school_item_text',
            'advance_search_article_item_text',
            'advance_search_program_item_text',
            'advance_search_business_item_text',
        ];

        // Find or create a StaticTranslation record for the "ambassador" type
        $result = StaticTranslation::where('type', 'general')->first();
        if (!$result) {
            $result = StaticTranslation::create([
                'display_text' => 'Static translations',
                'type' => 'general',
            ]);
        }

        // Loop through the keys and create or update StaticTranslationDetail records
        foreach ($keys as $key) {
            $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)
                ->where('static_translation_id', $result->id)
                ->where('key', $key)
                ->first();

            if (!$staticTranslationDetail) {
                StaticTranslationDetail::create([
                    'language_id' => $lang->id,
                    'static_translation_id' => $result->id,
                    'key' => $key,
                    'display_text' => ucfirst(str_replace('_', ' ', $key)), // Convert snake_case to Title Case
                ]);
            }
        }



        


        $keys = [
            'modal_description',
            'button_text',
        ];

        // Find or create a StaticTranslation record for the "already_have_school_modal" type
        $result = StaticTranslation::where('type', 'already_have_school_modal')->first();
        if (!$result) {
            $result = StaticTranslation::create([
                'display_text' => 'Already have school modal',
                'type' => 'already_have_school_modal',
            ]);
        }

        // Loop through the keys and create or update StaticTranslationDetail records
        foreach ($keys as $key) {
            $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)
                ->where('static_translation_id', $result->id)
                ->where('key', $key)
                ->first();

            if (!$staticTranslationDetail) {
                StaticTranslationDetail::create([
                    'language_id' => $lang->id,
                    'static_translation_id' => $result->id,
                    'key' => $key,
                    'display_text' => ucfirst(str_replace('_', ' ', $key)), // Convert snake_case to Title Case
                ]);
            }
        }


        $keys = [
            'register_student_success_message',
            'register_business_success_message',
            'register_school_success_message',
            'program_add_success_message',
            'netowrk_add_success_message',
            'proximatch_request_success_message',
            'contact_business_success_message',
            'contact_business_success_message',
            'event_add_success_message',
            'master_application_submit_success_message',
            'suggession_feedback_submit_success_message',
            'contact_us_submit_success_message',
            'quotes_add_success_message',
            'payment_processed_success_message',
            'payment_already_selected_package_error_message',
            'form_submission_limit_error_message',
            'form_submission_limit_error_message',
            'add_to_fav_success_message',
            'add_to_fav_error_message',
            'sponsorship_add_success_message',
            'open_day_add_success_message',
            'story_add_success_message',
            'contact_organizer_success_message',
        ];

        // Find or create a StaticTranslation record for the "already_have_school_popup" type
        $result = StaticTranslation::where('type', 'toaster_messages')->first();
        if (!$result) {
            $result = StaticTranslation::create([
                'display_text' => 'Toaster messages',
                'type' => 'toaster_messages',
            ]);
        }

        // Loop through the keys and create or update StaticTranslationDetail records
        foreach ($keys as $key) {
            $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)
                ->where('static_translation_id', $result->id)
                ->where('key', $key)
                ->first();

            if (!$staticTranslationDetail) {
                StaticTranslationDetail::create([
                    'language_id' => $lang->id,
                    'static_translation_id' => $result->id,
                    'key' => $key,
                    'display_text' => ucfirst(str_replace('_', ' ', $key)), // Convert snake_case to Title Case
                ]);
            }
        }



        // Define an array of translation keys and display text values
        $translations = [
            'post_your_qoute_text' => 'Post Quote Text',
            'modal_title' => 'Modal Title',
            'quote_label_text' => 'quote label text',
            'quote_input_placeholder' => 'Quote input field placeholder',
            'quote_error_text' => 'Quote Error Text',
            'quote_word_limit_error_text' => 'Quote word limit error text',
            'location_label_text' => 'location label text',
            'location_input_placeholder' => 'Location input field placeholder',
            'location_error_text' => 'Location Error Text',
            'name_label_text' => 'name label text',
            'name_input_placeholder' => 'Name input field placeholder',
            'name_error_text' => 'Name Error Text',
            'image_upload_label_text' => 'Image upload text',
            'submit_button_text' => 'Submit Button Text',
            'success_popup_text' => 'Success Popup Text',
        ];

        // Find or create the StaticTranslation record
        $result = StaticTranslation::where('type', 'quote')->first();
        if (!$result) {
            $result = StaticTranslation::create([
                'display_text' => 'Quote static translations',
                'type' => 'quote',
            ]);
        }

        // Iterate over the translations array and create/update StaticTranslationDetail records
        foreach ($translations as $key => $displayText) {
            $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)
                ->where('static_translation_id', $result->id)
                ->where('key', $key)
                ->first();

            if (!$staticTranslationDetail) {
                StaticTranslationDetail::create([
                    'language_id' => $lang->id,
                    'static_translation_id' => $result->id,
                    'key' => $key,
                    'display_text' => $displayText,
                ]);
            }
        }


        // Define an array of translation keys and display texts
        $translations = [
            'title_label_text' => 'Title label text',
            'start_date_label_text' => 'Start date label text',
            'end_date_label_text' => 'End date label text',
            'read_more_label_text' => 'Read more Button Text',
            'network_label_text' => 'Network label Text',
            'venue_label_text' => 'Venue label Text',
            'subsidiary_label_text' => 'Subsidiary label Text',
            'location_label_text' => 'Location label Text',
            'social_icons_text' => 'Social icons text',
            'photos_label_text' => 'Photos heading text',
            'event_detail_heading_text' => 'Event Detail Heading Text',
            'open_modal_button_text'=>'Open Modal Button Text',
            'contact_tab_text'=>'Contact Tab Text',
            'where_when_tab_text'=>'Where When Tab text',
            'visit_website_button_text'=>'Visit Website Button Text '
        ];

        // Event
        $result = StaticTranslation::where('type', 'event')->first();

        if (!$result) {
            $result = StaticTranslation::create([
                'display_text' => 'Event page translations',
                'type' => 'event',
            ]);
        }

        foreach ($translations as $key => $displayText) {
            $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)
                ->where('static_translation_id', $result->id)
                ->where('key', $key)
                ->first();

            if (!$staticTranslationDetail) {
                StaticTranslationDetail::create([
                    'language_id' => $lang->id,
                    'static_translation_id' => $result->id,
                    'key' => $key,
                    'display_text' => $displayText,
                ]);
            }
        }

        $keys = [
            'page_title',
            'title_label',
            'country_label',
            'state_province_label',
            'city_label',
            'street_name_label',
            'veneue_label',
            'product_search_label',
            'description_label',
            'short_description_label',
            'start_date_label',
            'end_date_label',
            'event_website_label',
            'location_label',
            'exibitor_url_label',
            'visitor_url_label',
            'press_url_label',
            'video_url_label',
            'video_url_placholder',
            'facebook_url_label',
            'insta_url_label',
            'linkedin_url_label',
            'youtube_url_label',
            'pintrest_url_label',
            'snapchat_url_label',
            'twitter_url_label',
            'contact_name_label',
            'contact_email_label',
            'contact_phone_label',
            'contact_photo_label',
            'contact_title_label',
            'image_upload_label',
            'more_images_upload_label',
            'submit_button_text',
            'add_more_contacts_button_text',
            'add_more_section_text',

        ];

        // Find or create a StaticTranslation record for the "ambassador" type
        $result = StaticTranslation::where('type', 'event_create_page')->first();
        if (!$result) {
            $result = StaticTranslation::create([
                'display_text' => 'Event create page',
                'type' => 'event_create_page',
            ]);
        }

        // Loop through the keys and create or update StaticTranslationDetail records
        foreach ($keys as $key) {
            $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)
                ->where('static_translation_id', $result->id)
                ->where('key', $key)
                ->first();

            if (!$staticTranslationDetail) {
                StaticTranslationDetail::create([
                    'language_id' => $lang->id,
                    'static_translation_id' => $result->id,
                    'key' => $key,
                    'display_text' => ucfirst(str_replace('_', ' ', $key)), // Convert snake_case to Title Case
                ]);
            }
        }


        // for careers
        $keys = [
            'career_submit_button_text',
            'career_page_title',
            'hot_listing_checkbox_label',
            'class_name_label',
            'class_name_placeholder',
            'class_name_definition_label',
            'class_name_definition_placeholder',

        ];

        // Find or create a StaticTranslation record for the "ambassador" type (for careers)
        $result = StaticTranslation::where('type', 'career_create_page')->first();
        if (!$result) {
            $result = StaticTranslation::create([
                'display_text' => 'Career create page',
                'type' => 'career_create_page',
            ]);
        }

        // Loop through the keys and create or update StaticTranslationDetail records (for careers)
        foreach ($keys as $key) {
            $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)
                ->where('static_translation_id', $result->id)
                ->where('key', $key)
                ->first();

            if (!$staticTranslationDetail) {
                StaticTranslationDetail::create([
                    'language_id' => $lang->id,
                    'static_translation_id' => $result->id,
                    'key' => $key,
                    'display_text' => ucfirst(str_replace('_', ' ', $key)), // Convert snake_case to Title Case
                ]);
            }
        }

           // for registration modal 
           $keys = [
            'you_are_registering_as_title',
            'school_register_button_title',
            'business_register_button_title',
            'student_register_button_title',
        ];

        // Find or create a StaticTranslation record for the "ambassador" type (for careers)
        $result = StaticTranslation::where('type', 'register_modal_fields_page')->first();
        if (!$result) {
            $result = StaticTranslation::create([
                'display_text' => 'Register modal fields',
                'type' => 'register_modal_fields_page',
            ]);
        }

        // Loop through the keys and create or update StaticTranslationDetail records (for careers)
        foreach ($keys as $key) {
            $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)
                ->where('static_translation_id', $result->id)
                ->where('key', $key)
                ->first();

            if (!$staticTranslationDetail) {
                StaticTranslationDetail::create([
                    'language_id' => $lang->id,
                    'static_translation_id' => $result->id,
                    'key' => $key,
                    'display_text' => ucfirst(str_replace('_', ' ', $key)), // Convert snake_case to Title Case
                ]);
            }
        }
     



        // for stories 
        $keys = [
            'story_submit_button_text',
            'story_page_title',
            'student_name_label',
            'student_name_placeholder',
            'email_label',
            'email_placeholder',
            'location_label',
            'location_placeholder',
            'story_label',
            'story_placeholder',
            'title_label',
            'title_placeholder',
            'image_label',
            'open_modal_button_text',
            'logged_in_user_modal_text',
        ];

        // Find or create a StaticTranslation record for the  type (for stories)
        $result = StaticTranslation::where('type', 'story_create_page')->first();
        if (!$result) {
            $result = StaticTranslation::create([
                'display_text' => 'Stories create page',
                'type' => 'story_create_page',
            ]);
        }

        // Loop through the keys and create or update StaticTranslationDetail records (for careers)
        foreach ($keys as $key) {
            $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)
                ->where('static_translation_id', $result->id)
                ->where('key', $key)
                ->first();

            if (!$staticTranslationDetail) {
                StaticTranslationDetail::create([
                    'language_id' => $lang->id,
                    'static_translation_id' => $result->id,
                    'key' => $key,
                    'display_text' => ucfirst(str_replace('_', ' ', $key)), // Convert snake_case to Title Case
                ]);
            }
        }



        // for stories 
        $keys = [
            'discard_faviourite_popup_message',
            'add_faviourite_popup_message',
            'error_faviourite_popup_message',
            'suggest_article_success_message',
            'suggest_article_error_message',
            'suggest_your_article_popup_message',
        ];

        // Find or create a StaticTranslation record for the  type (for stories)
        $result = StaticTranslation::where('type', 'popup_error_messages')->first();
        if (!$result) {
            $result = StaticTranslation::create([
                'display_text' => 'Popup Error Messages',
                'type' => 'popup_error_messages',
            ]);
        }

        // Loop through the keys and create or update StaticTranslationDetail records (for careers)
        foreach ($keys as $key) {
            $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)
                ->where('static_translation_id', $result->id)
                ->where('key', $key)
                ->first();

            if (!$staticTranslationDetail) {
                StaticTranslationDetail::create([
                    'language_id' => $lang->id,
                    'static_translation_id' => $result->id,
                    'key' => $key,
                    'display_text' => ucfirst(str_replace('_', ' ', $key)), // Convert snake_case to Title Case
                ]);
            }
        }


         // for master applicaiton pop ups 
         $keys = [
            'login_button_text',
            'register_button_text',
            'login_button_heading_text',
            'register_button_heading_text',
            'close_button_text',
            'main_text',
        ];

        // Find or create a StaticTranslation record for the  type (for stories)
        $result = StaticTranslation::where('type', 'master_application_pop_up_page')->first();
        if (!$result) {
            $result = StaticTranslation::create([
                'display_text' => 'Master Application Pop up Page',
                'type' => 'master_application_pop_up_page',
            ]);
        }

        // Loop through the keys and create or update StaticTranslationDetail records (for careers)
        foreach ($keys as $key) {
            $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)
                ->where('static_translation_id', $result->id)
                ->where('key', $key)
                ->first();

            if (!$staticTranslationDetail) {
                StaticTranslationDetail::create([
                    'language_id' => $lang->id,
                    'static_translation_id' => $result->id,
                    'key' => $key,
                    'display_text' => ucfirst(str_replace('_', ' ', $key)), // Convert snake_case to Title Case
                ]);
            }
        }

            // for school search buttons 
            $keys = [
                'apply_now',
                'view_profile',
                'view_profile_button_2',
                'visit_website',
                'visit_website_button_2',
                'language_availability_text',
            ];
    
            // Find or create a StaticTranslation record for the  type (for stories)
            $result = StaticTranslation::where('type', 'school_search_buttons')->first();
            if (!$result) {
                $result = StaticTranslation::create([
                    'display_text' => 'School Search Buttons Page',
                    'type' => 'school_search_buttons',
                ]);
            }
    
            // Loop through the keys and create or update StaticTranslationDetail records (for careers)
            foreach ($keys as $key) {
                $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)
                    ->where('static_translation_id', $result->id)
                    ->where('key', $key)
                    ->first();
    
                if (!$staticTranslationDetail) {
                    StaticTranslationDetail::create([
                        'language_id' => $lang->id,
                        'static_translation_id' => $result->id,
                        'key' => $key,
                        'display_text' => ucfirst(str_replace('_', ' ', $key)), // Convert snake_case to Title Case
                    ]);
                }
            }


               // for Post article modal
        $keys = [
            'suggest_article_success_message',
            'suggest_article_error_message',
            'premimum_and_featured_popup_message',
            'proxima_study_member_popup_message',
            'suggest_your_article_popup_message',
            'close_button_text',
            'open_modal_button_text',
            'submit_button_text',
        ];

        // Find or create a StaticTranslation record for the  type (for stories)
        $result = StaticTranslation::where('type', 'post_article_modal')->first();
        if (!$result) {
            $result = StaticTranslation::create([
                'display_text' => 'Post article modal setting',
                'type' => 'post_article_modal',
            ]);
        }

        // Loop through the keys and create or update StaticTranslationDetail records (for careers)
        foreach ($keys as $key) {
            $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)
                ->where('static_translation_id', $result->id)
                ->where('key', $key)
                ->first();

            if (!$staticTranslationDetail) {
                StaticTranslationDetail::create([
                    'language_id' => $lang->id,
                    'static_translation_id' => $result->id,
                    'key' => $key,
                    'display_text' => ucfirst(str_replace('_', ' ', $key)), // Convert snake_case to Title Case
                ]);
            }
        }



        $keys = [
            'bullet_points',
            'language_selection_text',
            'Keywords_label',
            'Keywords_placeholder',
            'Keywords_error',
        ];

        // Find or create a StaticTranslation record for the  type (for stories)
        $result = StaticTranslation::where('type', 'become_sponsor_page')->first();

        // Loop through the keys and create or update StaticTranslationDetail records (for careers)
        foreach ($keys as $key) {
            $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)
                ->where('static_translation_id', $result->id)
                ->where('key', $key)
                ->first();

            if (!$staticTranslationDetail) {
                StaticTranslationDetail::create([
                    'language_id' => $lang->id,
                    'static_translation_id' => $result->id,
                    'key' => $key,
                    'display_text' => ucfirst(str_replace('_', ' ', $key)), // Convert snake_case to Title Case
                ]);
            }
        }



                 // for Virtual tour popup dynamic texts
                 $keys = [
                    'feature_availability_text',
                    'sign_up_text',
                    'close_button_text',
                    'school_button_text',
                    'business_button_text',
                    'sponsor_button_text',
                    'already_member_text',
                    'click_here_text',
                    'upgrade_membership_text',
                ];
        
                // Find or create a StaticTranslation record for the  type (for stories)
                $result = StaticTranslation::where('type', 'virtual_tour_popup')->first();
                if (!$result) {
                    $result = StaticTranslation::create([
                        'display_text' => 'Virtual tour popup',
                        'type' => 'virtual_tour_popup',
                    ]);
                }
        
                // Loop through the keys and create or update StaticTranslationDetail records (for careers)
                foreach ($keys as $key) {
                    $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)
                        ->where('static_translation_id', $result->id)
                        ->where('key', $key)
                        ->first();
        
                    if (!$staticTranslationDetail) {
                        StaticTranslationDetail::create([
                            'language_id' => $lang->id,
                            'static_translation_id' => $result->id,
                            'key' => $key,
                            'display_text' => ucfirst(str_replace('_', ' ', $key)), // Convert snake_case to Title Case
                        ]);
                    }
                }




                  // for scholarship pop up dybnamic texts
                  $keys = [
                    'feature_availability_text',
                    'close_button_text',
                ];
        
                // Find or create a StaticTranslation record for the  type (for stories)
                $result = StaticTranslation::where('type', 'scholarship_popup')->first();
                if (!$result) {
                    $result = StaticTranslation::create([
                        'display_text' => 'Scholarship popup',
                        'type' => 'scholarship_popup',
                    ]);
                }
        
                // Loop through the keys and create or update StaticTranslationDetail records (for careers)
                foreach ($keys as $key) {
                    $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)
                        ->where('static_translation_id', $result->id)
                        ->where('key', $key)
                        ->first();
        
                    if (!$staticTranslationDetail) {
                        StaticTranslationDetail::create([
                            'language_id' => $lang->id,
                            'static_translation_id' => $result->id,
                            'key' => $key,
                            'display_text' => ucfirst(str_replace('_', ' ', $key)), // Convert snake_case to Title Case
                        ]);
                    }
                }


                    // for open house days popup dynamic texts
                    $keys = [
                        'feature_availability_text',
                        'close_button_text',
                        'click_here_text',
                        'upgrade_membership_text',
                    ];
            
                    // Find or create a StaticTranslation record for the  type (for stories)
                    $result = StaticTranslation::where('type', 'open_house_day_popup')->first();
                    if (!$result) {
                        $result = StaticTranslation::create([
                            'display_text' => 'Open day popup',
                            'type' => 'open_house_day_popup',
                        ]);
                    }
            
                    // Loop through the keys and create or update StaticTranslationDetail records (for careers)
                    foreach ($keys as $key) {
                        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)
                            ->where('static_translation_id', $result->id)
                            ->where('key', $key)
                            ->first();
            
                        if (!$staticTranslationDetail) {
                            StaticTranslationDetail::create([
                                'language_id' => $lang->id,
                                'static_translation_id' => $result->id,
                                'key' => $key,
                                'display_text' => ucfirst(str_replace('_', ' ', $key)), // Convert snake_case to Title Case
                            ]);
                        }
                    }


                       // for event popup dynamic texts
                       $keys = [
                        'feature_availability_text',
                        'close_button_text',
                    ];
            
                    // Find or create a StaticTranslation record for the  type (for stories)
                    $result = StaticTranslation::where('type', 'event_popup')->first();
                    if (!$result) {
                        $result = StaticTranslation::create([
                            'display_text' => 'Event popup',
                            'type' => 'event_popup',
                        ]);
                    }
            
                    // Loop through the keys and create or update StaticTranslationDetail records (for careers)
                    foreach ($keys as $key) {
                        $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)
                            ->where('static_translation_id', $result->id)
                            ->where('key', $key)
                            ->first();
            
                        if (!$staticTranslationDetail) {
                            StaticTranslationDetail::create([
                                'language_id' => $lang->id,
                                'static_translation_id' => $result->id,
                                'key' => $key,
                                'display_text' => ucfirst(str_replace('_', ' ', $key)), // Convert snake_case to Title Case
                            ]);
                        }
                    }


                         // for ambassadors popup dynamic texts
                         $keys = [
                            'feature_availability_text',
                            'close_button_text',
                            'add_ambassador_button_text',
                        ];
                
                        // Find or create a StaticTranslation record for the  type (for stories)
                        $result = StaticTranslation::where('type', 'ambassador_popup')->first();
                        if (!$result) {
                            $result = StaticTranslation::create([
                                'display_text' => 'Ambassador popup',
                                'type' => 'ambassador_popup',
                            ]);
                        }
                
                        // Loop through the keys and create or update StaticTranslationDetail records (for careers)
                        foreach ($keys as $key) {
                            $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)
                                ->where('static_translation_id', $result->id)
                                ->where('key', $key)
                                ->first();
                
                            if (!$staticTranslationDetail) {
                                StaticTranslationDetail::create([
                                    'language_id' => $lang->id,
                                    'static_translation_id' => $result->id,
                                    'key' => $key,
                                    'display_text' => ucfirst(str_replace('_', ' ', $key)), // Convert snake_case to Title Case
                                ]);
                            }
                        }


                            // for Article page setting
                            $keys = [
                                'article_topic_text',
                                'article_heading_text',
                                'article_description_text',
                                'show_all_button_text',
                            ];
                    
                            // Find or create a StaticTranslation record for the  type (for stories)
                            $result = StaticTranslation::where('type', 'article_page_setting')->first();
                            if (!$result) {
                                $result = StaticTranslation::create([
                                    'display_text' => 'Article page setting',
                                    'type' => 'article_page_setting',
                                ]);
                            }
                    
                            // Loop through the keys and create or update StaticTranslationDetail records (for careers)
                            foreach ($keys as $key) {
                                $staticTranslationDetail = StaticTranslationDetail::where('language_id', $lang->id)
                                    ->where('static_translation_id', $result->id)
                                    ->where('key', $key)
                                    ->first();
                    
                                if (!$staticTranslationDetail) {
                                    StaticTranslationDetail::create([
                                        'language_id' => $lang->id,
                                        'static_translation_id' => $result->id,
                                        'key' => $key,
                                        'display_text' => ucfirst(str_replace('_', ' ', $key)), // Convert snake_case to Title Case
                                    ]);
                                }
                            }

    }
}
