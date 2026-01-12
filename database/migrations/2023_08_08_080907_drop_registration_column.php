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
        Schema::table('schools', function (Blueprint $table) {
            $table->dropForeign(['registration_package_id']);
            $table->dropColumn('registration_package_id');
        });

        Schema::table('businesses', function (Blueprint $table) {
            $table->dropForeign(['registration_package_id']);
            $table->dropColumn('registration_package_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::table('schools', function (Blueprint $table) {
            $table->unsignedBigInteger('registration_package_id')->nullable();
            $table->foreign('registration_package_id')->references('id')->on('registration_packages');
        });

        Schema::table('businesses', function (Blueprint $table) {
            $table->unsignedBigInteger('registration_package_id')->nullable();
            $table->foreign('registration_package_id')->references('id')->on('registration_packages');
        });
    }
};
