<?php

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
        Schema::table('school_overviews', function (Blueprint $table) {
            $table->string('school_overviews_blue_bar_button_title')->nullable();
            $table->string('school_overviews_blue_bar_button_link')->nullable();
            $table->string('school_overviews_red_bar_button_title')->nullable();
            $table->string('school_overviews_red_bar_button_link')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('school_overviews', function (Blueprint $table) {
            $table->dropColumn('school_overviews_blue_bar_button_title');
            $table->dropColumn('school_overviews_blue_bar_button_link');
            $table->dropColumn('school_overviews_red_bar_button_title');
            $table->dropColumn('school_overviews_red_bar_button_link');
        });
    }
};
