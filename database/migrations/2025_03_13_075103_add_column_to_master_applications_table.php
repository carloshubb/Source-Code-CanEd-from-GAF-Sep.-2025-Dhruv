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
        Schema::table('master_applications', function (Blueprint $table) {
            $table->text('statement_of_purpose')->nullable();
            $table->text('letter_of_intent')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('master_applications', function (Blueprint $table) {
            $table->dropColumn('statement_of_purpose');
            $table->dropColumn('letter_of_intent');
        });
    }
};
