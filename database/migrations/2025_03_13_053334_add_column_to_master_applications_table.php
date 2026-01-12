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
            $table->string('other_test_4_name')->nullable();
            $table->string('other_test_4_score')->nullable();
            $table->string('other_test_5_name')->nullable();
            $table->string('other_test_5_score')->nullable();
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
            $table->dropColumn('other_test_4_name');
            $table->dropColumn('other_test_4_score');
            $table->dropColumn('other_test_5_name');
            $table->dropColumn('other_test_5_score');
        });
    }
};
