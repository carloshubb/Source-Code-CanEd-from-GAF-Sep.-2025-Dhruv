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
        Schema::table('registration_packages', function (Blueprint $table) {
            $table->enum('package_category',['school','student','business']);
            $table->string('images')->default(0);
            $table->string('ambassadors')->default(0);
            $table->string('webinars')->default(0);
            $table->string('articles')->default(0);
            $table->string('events')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('registration_packages', function (Blueprint $table) {
            //
        });
    }
};
