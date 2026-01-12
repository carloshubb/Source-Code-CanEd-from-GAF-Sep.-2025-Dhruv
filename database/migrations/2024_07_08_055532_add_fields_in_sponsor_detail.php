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
        Schema::table('sponsor_details', function (Blueprint $table) {
            $table->string('subsidiary')->nullable();
            $table->string('contact_person_name')->nullable();
            $table->longText('short_description')->nullable();
            $table->longText('description')->nullable();
            $table->string('service1_name')->nullable();
            $table->string('service1_url')->nullable();
            $table->string('service2_name')->nullable();
            $table->string('service2_url')->nullable();
            $table->string('service3_name')->nullable();
            $table->string('service3_url')->nullable();
            $table->string('service4_name')->nullable();
            $table->string('service4_url')->nullable();
            $table->string('service5_name')->nullable();
            $table->string('service5_url')->nullable();
        });
        Schema::table('sponsors', function (Blueprint $table) {
            $table->string('contact_person_phone')->nullable();
            $table->string('contact_person_email')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sponsor_details', function (Blueprint $table) {
            $table->dropColumn('subsidiary')->nullable();
            $table->dropColumn('contact_person_name')->nullable();
            $table->dropColumn('short_description')->nullable();
            $table->dropColumn('description')->nullable();
            $table->dropColumn('service1_name')->nullable();
            $table->dropColumn('service1_url')->nullable();
            $table->dropColumn('service2_name')->nullable();
            $table->dropColumn('service2_url')->nullable();
            $table->dropColumn('service3_name')->nullable();
            $table->dropColumn('service3_url')->nullable();
            $table->dropColumn('service4_name')->nullable();
            $table->dropColumn('service4_url')->nullable();
            $table->dropColumn('service5_name')->nullable();
            $table->dropColumn('service5_url')->nullable();
        });
    }
};
