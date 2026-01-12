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
           $table->string('live_strom_user_id')->nullable();
           $table->string('live_strom_token')->nullable();
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
            $table->dropColumn('live_strom_user_id');
            $table->dropColumn('live_strom_token');
        });
    }
};
