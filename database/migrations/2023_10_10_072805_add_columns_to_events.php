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
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn('contact_name');
            $table->dropColumn('contact_email');
            $table->dropColumn('contact_phone');
            $table->dropColumn('contact_designation');
            $table->text('state_province')->nullable();
            $table->text('city')->nullable();
            $table->text('country')->nullable();
            $table->text('street_name')->nullable();
            $table->text('veneue')->nullable();
            $table->text('product_search')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn('state_province');
            $table->dropColumn('city');
            $table->dropColumn('country');
            $table->dropColumn('street_name');
            $table->dropColumn('veneue');
            $table->dropColumn('product_search');
        });
    }
};
