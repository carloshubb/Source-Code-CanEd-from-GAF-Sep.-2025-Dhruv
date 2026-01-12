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
        Schema::table('businesses', function (Blueprint $table) {
            $table->string('registration_package_duration')->nullable();
            $table->string('registration_package')->nullable()->after('registration_package_duration');
            $table->boolean('auto_renew')->default(0)->after('registration_package');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('businesses', function (Blueprint $table) {
            $table->dropColumn(['registration_package_duration', 'registration_package', 'auto_renew']);
        });
    }
};
