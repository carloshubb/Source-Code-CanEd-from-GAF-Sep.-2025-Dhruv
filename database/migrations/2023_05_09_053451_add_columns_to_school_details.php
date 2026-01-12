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
        Schema::table('school_details', function (Blueprint $table) {
            // $table->dropForeign(['language_id']);
            // $table->dropColumn('language_id');
            $table->text('language_code');
            $table->text('more_button_title')->nullable();
            $table->text('more_button_sub_title')->nullable();
            $table->text('other_button_title')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('school_details', function (Blueprint $table) {
            //
        });
    }
};
