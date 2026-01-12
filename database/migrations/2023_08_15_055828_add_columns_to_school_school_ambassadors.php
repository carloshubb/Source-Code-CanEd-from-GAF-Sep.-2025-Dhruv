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
        Schema::table('school_ambassadors', function (Blueprint $table) {
            $table->string('whats_app_number')->nullable();
            $table->string('skype_id')->nullable();
            $table->string('we_chat_number')->nullable();
            $table->string('viber_number')->nullable();
            $table->string('imo_number')->nullable();
            $table->string('mobile_number')->nullable();
            $table->string('message_number')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('school_ambassadors', function (Blueprint $table) {
            $table->dropColumn('whats_app_number');
            $table->dropColumn('skype_id');
            $table->dropColumn('we_chat_number');
            $table->dropColumn('viber_number');
            $table->dropColumn('imo_number');
            $table->string('mobile_number')->nullable();
            $table->string('message_number')->nullable();
        });
    }
};
