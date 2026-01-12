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
            $table->string('other_test_1_name')->nullable();
            $table->string('other_test_1_score')->nullable();
            $table->string('other_test_2_name')->nullable();
            $table->string('other_test_2_score')->nullable();
            $table->string('other_test_3_name')->nullable();
            $table->string('other_test_3_score')->nullable();
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
            //
        });
    }
};
