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
            StaticTranslation::where('type', 'ambassador')
            ->update(['type' => 'ambassadors']);
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
            StaticTranslation::where('type', 'ambassadors')
            ->update(['type' => 'ambassador']);
        });
    }
};
