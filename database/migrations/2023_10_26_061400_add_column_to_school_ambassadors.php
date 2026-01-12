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
            $table->dropColumn('currently_in');
            $table->string('degree_level');
            $table->string('my_major');
            $table->string('my_minor');
            $table->enum('status',['active','inactive'])->default('active');

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
            //
        });
    }
};
