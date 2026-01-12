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
        Schema::table('master_application_setting_details', function (Blueprint $table) {
            $table->text('statement_of_purpose_label', 500)->nullable();
            $table->text('statement_of_purpose_placeholder', 500)->nullable();
            $table->text('statement_of_purpose_error', 500)->nullable();
            $table->text('letter_of_intent_label', 500)->nullable();
            $table->text('letter_of_intent_placeholder', 500)->nullable();
            $table->text('letter_of_intent_error', 500)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('master_application_setting_details', function (Blueprint $table) {
            $table->dropColumn('statement_of_purpose_label');
            $table->dropColumn('statement_of_purpose_placeholder');
            $table->dropColumn('statement_of_purpose_error');
            $table->dropColumn('letter_of_intent_label');
            $table->dropColumn('letter_of_intent_placeholder');
            $table->dropColumn('letter_of_intent_error');
        });
    }
};
