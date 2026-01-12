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
            $table->longText('program_type_greduates')->nullable();
            $table->longText('program_type_undergreduates')->nullable();
            $table->longText('years_before_elegible_for_pr')->nullable();
            $table->longText('work_off_campus')->nullable();
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
    }
};
