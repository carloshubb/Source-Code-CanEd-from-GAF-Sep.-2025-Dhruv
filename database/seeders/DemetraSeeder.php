<?php

namespace Database\Seeders;

use App\Models\ComunityService;
use App\Models\ComunityServiceDetail;
use App\Models\Language;
use App\Models\LearningLanguage;
use App\Models\LearningLanguageDetail;
use App\Models\Sport;
use App\Models\SportDetail;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DemetraSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $languages = Language::all();
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Sport::truncate();
        SportDetail::truncate();
        $sport = Sport::create([
            'status' => 1,
        ]);
        foreach ($languages as $language) {
            SportDetail::create([
                'name' => 'other',
                'sport_id' => $sport->id,
                'language_id' => $language->id,
            ]);
        }

        LearningLanguage::truncate();
        LearningLanguageDetail::truncate();
        $LearningLanguage = LearningLanguage::create([
            'status' => 1,
        ]);
        foreach ($languages as $language) {
            LearningLanguageDetail::create([
                'name' => 'other',
                'learning_language_id' => $LearningLanguage->id,
                'language_id' => $language->id,
            ]);
        }

        $LearningLanguage = LearningLanguage::create([
            'status' => 1,
        ]);
        foreach ($languages as $language) {
            LearningLanguageDetail::create([
                'name' => 'English',
                'learning_language_id' => $LearningLanguage->id,
                'language_id' => $language->id,
            ]);
        }

        $LearningLanguage = LearningLanguage::create([
            'status' => 1,
        ]);
        foreach ($languages as $language) {
            LearningLanguageDetail::create([
                'name' => 'French',
                'learning_language_id' => $LearningLanguage->id,
                'language_id' => $language->id,
            ]);
        }
        ComunityService::truncate();
        $ComunityService = ComunityService::create([
            'status' => 1,
        ]);
        ComunityServiceDetail::truncate();
        foreach ($languages as $language) {
            ComunityServiceDetail::create([
                'name' => 'other',
                'comunity_service_id' => $ComunityService->id,
                'language_id' => $language->id,
            ]);
        }
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
