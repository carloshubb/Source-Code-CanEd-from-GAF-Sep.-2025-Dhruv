<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class DemetraPageSettingDetailResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'demetra_page_setting_id' => $this->demetra_page_setting_id,
            'language_id' => $this->language_id,
            'min_cgpa_label' => $this->min_cgpa_label,
            'min_cgpa_placeholder' => $this->min_cgpa_placeholder,
            'min_cgpa_error' => $this->min_cgpa_error,
            'demetra_sport_label' => $this->demetra_sport_label,
            'demetra_sport_placeholder' => $this->demetra_sport_placeholder,
            'demetra_sport_error' => $this->demetra_sport_error,
            'demetra_comunity_service_label' => $this->demetra_comunity_service_label,
            'demetra_comunity_service_placeholder' => $this->demetra_comunity_service_placeholder,
            'demetra_comunity_service_error' => $this->demetra_comunity_service_error,
            'max_cgpa_label' => $this->max_cgpa_label,
            'max_cgpa_placeholder' => $this->max_cgpa_placeholder,
            'max_cgpa_error' => $this->max_cgpa_error,
            'conditional_acceptance_label' => $this->conditional_acceptance_label,
            'conditional_acceptance_placeholder' => $this->conditional_acceptance_placeholder,
            'conditional_acceptance_error' => $this->conditional_acceptance_error,
            'demetra_button_text' => $this->demetra_button_text,
            'demetra_curricular_label' => $this->demetra_curricular_label,
            'demetra_entrepreneurship_label' => $this->demetra_entrepreneurship_label,
            'demetra_environmental_label' => $this->demetra_environmental_label,
            'demetra_extracurricular_label' => $this->demetra_extracurricular_label,
            'demetra_health_wellness_label' => $this->demetra_health_wellness_label,
            'demetra_leadership_label' => $this->demetra_leadership_label,
            'demetra_media_label' => $this->demetra_media_label,
            'demetra_music_performance_label' => $this->demetra_music_performance_label,
            'demetra_social_activism_label' => $this->demetra_social_activism_label,
            'demetra_stem_competitions_label' => $this->demetra_stem_competitions_label,
            'demetra_technology_label' => $this->demetra_technology_label,
            'demetra_page_setting' => new RegPageSettingResource($this->whenLoaded('demetraPageSetting')),
            'language' => new LanguageResource($this->whenLoaded('language')),
        ];
    }
}
