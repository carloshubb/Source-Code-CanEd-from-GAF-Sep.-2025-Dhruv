<?php

use App\Models\StaticTranslation;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('static_translations', function (Blueprint $table) {
            StaticTranslation::where('type', 'business')
            ->update(['type' => 'businesses']);
            
            StaticTranslation::where('type', 'scholarship')
            ->update(['type' => 'scholarships']);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('static_translations', function (Blueprint $table) {
            StaticTranslation::where('type', 'businesses')
            ->update(['type' => 'business']);

            StaticTranslation::where('type', 'scholarships')
            ->update(['type' => 'scholarship']);
            
        });
    }
};
