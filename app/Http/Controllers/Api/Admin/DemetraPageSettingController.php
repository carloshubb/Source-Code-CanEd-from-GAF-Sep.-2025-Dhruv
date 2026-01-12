<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\DemetraPageSettingResource;
use App\Models\DemetraPageSetting;
use App\Models\DemetraPageSettingDetail;
use App\Traits\StatusResponser;
use Illuminate\Http\Request;

class DemetraPageSettingController extends Controller
{
    use StatusResponser;

    public function index()
    {
        $demetraPageSetting = DemetraPageSetting::with('demetraPageSettingDetail')->first();

        if (!$demetraPageSetting) {
            $demetraPageSetting = DemetraPageSetting::create([]);
            $languages = getAllLanguages();
            foreach ($languages as $language) {
                DemetraPageSettingDetail::create([
                    'demetra_page_setting_id' => $demetraPageSetting->id,
                    'language_id' => $language->id,
                ]);
            }
            $demetraPageSetting = $demetraPageSetting->loadMissing('demetraPageSettingDetail');
        }

        return $this->successResponse(new DemetraPageSettingResource($demetraPageSetting), 'Data get successfully.');
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
            $validationRule = array_merge($validationRule, ['min_cgpa_label.min_cgpa_label_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['min_cgpa_label.min_cgpa_label_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['min_cgpa_placeholder.min_cgpa_placeholder_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['min_cgpa_placeholder.min_cgpa_placeholder_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['min_cgpa_error.min_cgpa_error_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['min_cgpa_error.min_cgpa_error_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['demetra_sport_label.demetra_sport_label_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['demetra_sport_label.demetra_sport_label_' . $language->id . '.required' => 'This field is required.']);

            // first name
            $validationRule = array_merge($validationRule, ['demetra_sport_placeholder.demetra_sport_placeholder_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['demetra_sport_placeholder.demetra_sport_placeholder_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['demetra_sport_error.demetra_sport_error_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['demetra_sport_error.demetra_sport_error_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['demetra_comunity_service_label.demetra_comunity_service_label_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['demetra_comunity_service_label.demetra_comunity_service_label_' . $language->id . '.required' => 'This field is required.']);

            // last name
            $validationRule = array_merge($validationRule, ['demetra_comunity_service_placeholder.demetra_comunity_service_placeholder_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['demetra_comunity_service_placeholder.demetra_comunity_service_placeholder_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['demetra_comunity_service_error.demetra_comunity_service_error_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['demetra_comunity_service_error.demetra_comunity_service_error_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['max_cgpa_label.max_cgpa_label_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['max_cgpa_label.max_cgpa_label_' . $language->id . '.required' => 'This field is required.']);


            //password
            $validationRule = array_merge($validationRule, ['max_cgpa_placeholder.max_cgpa_placeholder_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['max_cgpa_placeholder.max_cgpa_placeholder_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['max_cgpa_error.max_cgpa_error_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['max_cgpa_error.max_cgpa_error_' . $language->id . '.required' => 'This field is required.']);


            $validationRule = array_merge($validationRule, ['conditional_acceptance_label.conditional_acceptance_label_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['conditional_acceptance_label.conditional_acceptance_label_' . $language->id . '.required' => 'This field is required.']);


            $validationRule = array_merge($validationRule, ['conditional_acceptance_placeholder.conditional_acceptance_placeholder_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['conditional_acceptance_placeholder.conditional_acceptance_placeholder_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['conditional_acceptance_error.conditional_acceptance_error_' . $language->id => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['conditional_acceptance_error.conditional_acceptance_error_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['demetra_button_text.demetra_button_text_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['demetra_button_text.demetra_button_text_' . $language->id . '.required' => 'This field is required.']);

            $validationRule['demetra_curricular_label.demetra_curricular_label_' . $language->id] = [$requiredVal, 'string'];
            $errorMessages['demetra_curricular_label.demetra_curricular_label_' . $language->id . '.required'] = 'This field is required.';

            $validationRule['demetra_entrepreneurship_label.demetra_entrepreneurship_label_' . $language->id] = [$requiredVal, 'string'];
            $errorMessages['demetra_entrepreneurship_label.demetra_entrepreneurship_label_' . $language->id . '.required'] = 'This field is required.';

            $validationRule['demetra_environmental_label.demetra_environmental_label_' . $language->id] = [$requiredVal, 'string'];
            $errorMessages['demetra_environmental_label.demetra_environmental_label_' . $language->id . '.required'] = 'This field is required.';

            $validationRule['demetra_extracurricular_label.demetra_extracurricular_label_' . $language->id] = [$requiredVal, 'string'];
            $errorMessages['demetra_extracurricular_label.demetra_extracurricular_label_' . $language->id . '.required'] = 'This field is required.';

            $validationRule['demetra_health_wellness_label.demetra_health_wellness_label_' . $language->id] = [$requiredVal, 'string'];
            $errorMessages['demetra_health_wellness_label.demetra_health_wellness_label_' . $language->id . '.required'] = 'This field is required.';

            $validationRule['demetra_leadership_label.demetra_leadership_label_' . $language->id] = [$requiredVal, 'string'];
            $errorMessages['demetra_leadership_label.demetra_leadership_label_' . $language->id . '.required'] = 'This field is required.';

            $validationRule['demetra_media_label.demetra_media_label_' . $language->id] = [$requiredVal, 'string'];
            $errorMessages['demetra_media_label.demetra_media_label_' . $language->id . '.required'] = 'This field is required.';

            $validationRule['demetra_music_performance_label.demetra_music_performance_label_' . $language->id] = [$requiredVal, 'string'];
            $errorMessages['demetra_music_performance_label.demetra_music_performance_label_' . $language->id . '.required'] = 'This field is required.';

            $validationRule['demetra_social_activism_label.demetra_social_activism_label_' . $language->id] = [$requiredVal, 'string'];
            $errorMessages['demetra_social_activism_label.demetra_social_activism_label_' . $language->id . '.required'] = 'This field is required.';

            $validationRule['demetra_stem_competitions_label.demetra_stem_competitions_label_' . $language->id] = [$requiredVal, 'string'];
            $errorMessages['demetra_stem_competitions_label.demetra_stem_competitions_label_' . $language->id . '.required'] = 'This field is required.';

            $validationRule['demetra_technology_label.demetra_technology_label_' . $language->id] = [$requiredVal, 'string'];
            $errorMessages['demetra_technology_label.demetra_technology_label_' . $language->id . '.required'] = 'This field is required.';
        }

        $this->validate(
            $request,
            $validationRule,
            $errorMessages
        );

        $demetraPageSetting = DemetraPageSetting::firstOrCreate();
        $demetraPageSetting->touch();
        foreach ($languages as $language) {
            $demetraPageSettingDetail = DemetraPageSettingDetail::whereLanguageId($language->id)->whereDemetraPageSettingId($demetraPageSetting->id)->exists();

            $fields = [
                'min_cgpa_label' => $request['min_cgpa_label']['min_cgpa_label_' . $language->id],
                'demetra_sport_placeholder' => $request['demetra_sport_placeholder']['demetra_sport_placeholder_' . $language->id],
                'demetra_sport_error' => $request['demetra_sport_error']['demetra_sport_error_' . $language->id],
                'demetra_comunity_service_label' => $request['demetra_comunity_service_label']['demetra_comunity_service_label_' . $language->id],
                'demetra_comunity_service_placeholder' => $request['demetra_comunity_service_placeholder']['demetra_comunity_service_placeholder_' . $language->id],
                'demetra_comunity_service_error' => $request['demetra_comunity_service_error']['demetra_comunity_service_error_' . $language->id],
                'max_cgpa_label' => $request['max_cgpa_label']['max_cgpa_label_' . $language->id],
                'min_cgpa_placeholder' => $request['min_cgpa_placeholder']['min_cgpa_placeholder_' . $language->id],
                'min_cgpa_error' => $request['min_cgpa_error']['min_cgpa_error_' . $language->id],
                'demetra_sport_label' => $request['demetra_sport_label']['demetra_sport_label_' . $language->id],
                'max_cgpa_placeholder' => $request['max_cgpa_placeholder']['max_cgpa_placeholder_' . $language->id],
                'max_cgpa_error' => $request['max_cgpa_error']['max_cgpa_error_' . $language->id],
                'conditional_acceptance_label' => $request['conditional_acceptance_label']['conditional_acceptance_label_' . $language->id],
                'conditional_acceptance_placeholder' => $request['conditional_acceptance_placeholder']['conditional_acceptance_placeholder_' . $language->id],
                'conditional_acceptance_error' => $request['conditional_acceptance_error']['conditional_acceptance_error_' . $language->id],
                'demetra_button_text' => $request['demetra_button_text']['demetra_button_text_' . $language->id],

                'demetra_curricular_label' => $request['demetra_curricular_label']['demetra_curricular_label_' . $language->id],
                'demetra_entrepreneurship_label' => $request['demetra_entrepreneurship_label']['demetra_entrepreneurship_label_' . $language->id],
                'demetra_environmental_label' => $request['demetra_environmental_label']['demetra_environmental_label_' . $language->id],
                'demetra_extracurricular_label' => $request['demetra_extracurricular_label']['demetra_extracurricular_label_' . $language->id],
                'demetra_health_wellness_label' => $request['demetra_health_wellness_label']['demetra_health_wellness_label_' . $language->id],
                'demetra_leadership_label' => $request['demetra_leadership_label']['demetra_leadership_label_' . $language->id],
                'demetra_media_label' => $request['demetra_media_label']['demetra_media_label_' . $language->id],
                'demetra_music_performance_label' => $request['demetra_music_performance_label']['demetra_music_performance_label_' . $language->id],
                'demetra_social_activism_label' => $request['demetra_social_activism_label']['demetra_social_activism_label_' . $language->id],
                'demetra_stem_competitions_label' => $request['demetra_stem_competitions_label']['demetra_stem_competitions_label_' . $language->id],
                'demetra_technology_label' => $request['demetra_technology_label']['demetra_technology_label_' . $language->id],
            ];
            if ($demetraPageSettingDetail) {
                DemetraPageSettingDetail::whereLanguageId($language->id)->whereDemetraPageSettingId($demetraPageSetting->id)->update($fields);
            } else {
                $fields = array_merge($fields, ['demetra_page_setting_id' => $demetraPageSetting->id]);
                $fields = array_merge($fields, ['language_id' => $language->id]);
                DemetraPageSettingDetail::create($fields);
            }
        }

        if ($demetraPageSetting) {
            return $this->apiSuccessResponse(new DemetraPageSettingResource($demetraPageSetting), 'Your changes have been done successfully');
        }
        return $this->errorResponse();
    }
}
