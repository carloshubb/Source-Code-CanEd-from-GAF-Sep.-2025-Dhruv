<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

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
            $table->boolean('quick_facts_status')->default(true)->change();
            $table->boolean('overview_status')->default(true)->change();
            $table->boolean('program_status')->default(true)->change();
            $table->boolean('admission_status')->default(true)->change();
            $table->boolean('financial_status')->default(true)->change();
            $table->boolean('scholarship_status')->default(true)->change();
            $table->boolean('contacts_status')->default(true)->change();
            $table->boolean('ambassador_status')->default(true)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('schools', function (Blueprint $table) {
            $table->boolean('quick_facts_status')->default(false)->change();
            $table->boolean('overview_status')->default(false)->change();
            $table->boolean('program_status')->default(false)->change();
            $table->boolean('admission_status')->default(false)->change();
            $table->boolean('financial_status')->default(false)->change();
            $table->boolean('scholarship_status')->default(false)->change();
            $table->boolean('contacts_status')->default(false)->change();
            $table->boolean('ambassador_status')->default(false)->change();
        });
    }
};
