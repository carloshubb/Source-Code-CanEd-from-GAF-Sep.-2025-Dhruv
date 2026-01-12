<?php

namespace Database\Seeders;

use App\Models\StaticTranslation;
use App\Models\StaticTranslationDetail;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SponsorFormSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $lang = getDefaultLanguage();

        $keys = [
            'page_title',
            'business_name_label',
            'business_name_placeholder',
            'business_name_error',
            'subsidiary_label',
            'subsidiary_placeholder',
            'subsidiary_error',
            'short_description_label',
            'short_description_placeholder',
            'short_description_error',
            'description_label',
            'description_placeholder',
            'description_error',
            'service_1_name_label',
            'service_1_name_placeholder',
            'service_1_name_error',
            'service_1_url_label',
            'service_1_url_placeholder',
            'service_1_url_error',
            'service_2_name_label',
            'service_2_name_placeholder',
            'service_2_name_error',
            'service_2_url_label',
            'service_2_url_placeholder',
            'service_2_url_error',
            'service_3_name_label',
            'service_3_name_placeholder',
            'service_3_name_error',
            'service_3_url_label',
            'service_3_url_placeholder',
            'service_3_url_error',
            'service_4_name_label',
            'service_4_name_placeholder',
            'service_4_name_error',
            'service_4_url_label',
            'service_4_url_placeholder',
            'service_4_url_error',
            'service_5_name_label',
            'service_5_name_placeholder',
            'service_5_name_error',
            'service_5_url_label',
            'service_5_url_placeholder',
            'service_5_url_error',
            'contact_person_image_label',
            'contact_person_name_label',
            'contact_person_name_placeholder',
            'contact_person_name_error',
            'contact_person_phone_label',
            'contact_person_phone_placeholder',
            'contact_person_phone_error',
            'contact_person_email_label',
            'contact_person_email_placeholder',
            'contact_person_email_error',
            'location_label',
            'location_placeholder',
            'location_error',
            'website_label',
            'website_placeholder',
            'website_error',
            'logo_label',
            'logo_placeholder',
            'logo_error',
            'submit_button_text',

        ];

        // Find or create a StaticTranslation record for the "ambassador" type
        $result = StaticTranslation::where('type', 'become_sponsor_page')->first();
        if (!$result) {
            $result = StaticTranslation::create([
                'display_text' => 'Become sponsor page',
                'type' => 'become_sponsor_page',
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
                    'display_text' => ucfirst(str_replace('_', ' ', $key)),
                ]);
            } else {
                $staticTranslationDetail->update([
                    'language_id' => $lang->id,
                    'display_text' => ucfirst(str_replace('_', ' ', $key)),
                ]);
            }
        }
    }
}
