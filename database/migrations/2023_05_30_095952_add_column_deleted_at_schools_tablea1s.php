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
            $table->integer('deactive_account')->default(1)->comment('0 for active 1 for deactive');
            $table->softDeletes();
        });

        Schema::table('businesses', function (Blueprint $table) {
            $table->integer('deactive_account')->default(1)->comment('0 for active 1 for deactive');
            $table->softDeletes();
        });

        Schema::table('customers', function (Blueprint $table) {
            $table->integer('deactive_account')->default(1)->comment('0 for active 1 for deactive');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        
    }
};
