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
        Schema::table('school_quick_facts', function (Blueprint $table) {
            $table->longText('financial_aid_programs_for_province_students')->nullable()->after('financial_aid_programs_for_domastic_students');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('school_quick_facts', function (Blueprint $table) {
            $table->dropColumn('financial_aid_programs_for_province_students');
        });
    }
};
