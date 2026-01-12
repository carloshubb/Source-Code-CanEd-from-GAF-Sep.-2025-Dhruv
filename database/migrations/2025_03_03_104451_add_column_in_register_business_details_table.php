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
        Schema::table('register_business_details', function (Blueprint $table) {
            $table->text('media_title_label')->nullable();
            $table->text('media_title_placeholder')->nullable();
            $table->text('media_title_error')->nullable();
            $table->text('media_description_label')->nullable();
            $table->text('media_description_placeholder')->nullable();
            $table->text('media_description_error')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('register_business_details', function (Blueprint $table) {
            $table->dropColumn(['media_title_error', 'media_title_placeholder', 'media_title_label',
                'media_description_error', 'media_description_placeholder', 'media_description_label'
            ]);
        });
    }
};
