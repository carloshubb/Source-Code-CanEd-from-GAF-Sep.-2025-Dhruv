<?php

namespace Database\Seeders;

use App\Models\Language;
use Illuminate\Database\Seeder;

class LanguageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Language::create([
            'name' => 'English',
            'abbreviation' => 'en',
            'native_name' => 'English',
            'is_default'=>1
        ]);

        Language::create([
            'name' => 'Arabic',
            'abbreviation' => 'ar',
            'native_name' => 'Arabic',
            'is_default'=>0
        ]);
    }
}
