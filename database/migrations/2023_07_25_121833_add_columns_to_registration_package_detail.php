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
            $table->text('package_type',500)->nullable();
            $table->text('package_validity',500)->nullable();
        });

        Schema::table('registration_package_detail', function (Blueprint $table) {
            $table->dropColumn('description');
            
        });
        Schema::table('registration_package_detail', function (Blueprint $table) {
            $table->longText('description')->nullable();
            
        });

        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('registration_package_detail', function (Blueprint $table) {
            //
        });
    }
};
