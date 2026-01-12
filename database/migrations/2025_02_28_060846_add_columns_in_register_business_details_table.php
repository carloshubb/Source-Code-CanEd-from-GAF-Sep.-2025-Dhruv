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
        Schema::table('register_business_details', function (Blueprint $table) {
            $table->text('detail_description_lable')->nullable();
            $table->text('detail_description_placeholder')->nullable();
            $table->text('detail_description_error')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('register_business_details', function (Blueprint $table) {
            $table->dropColumn(['detail_description_error', 'detail_description_placeholder', 'detail_description_lable']);
        });
    }
};
