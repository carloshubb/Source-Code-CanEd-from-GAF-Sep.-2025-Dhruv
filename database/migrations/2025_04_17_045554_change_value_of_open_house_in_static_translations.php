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
            StaticTranslation::where('type', 'open_house')
            ->update(['type' => 'open_houses']);
            
            StaticTranslation::where('type', 'virtual_tour')
            ->update(['type' => 'virtual_tours']);
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
            StaticTranslation::where('type', 'open_houses')
            ->update(['type' => 'open_house']);

            StaticTranslation::where('type', 'virtual_tours')
            ->update(['type' => 'virtual_tour']);
        });
    }
};
