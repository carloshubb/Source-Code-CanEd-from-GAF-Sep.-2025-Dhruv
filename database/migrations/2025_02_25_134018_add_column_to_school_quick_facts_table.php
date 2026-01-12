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
            $table->string('school_quick_facts_apply_button_title')->nullable();
            $table->string('school_quick_facts_apply_button_link')->nullable();
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
            $table->dropColumn('school_quick_facts_apply_button_title');
            $table->dropColumn('school_quick_facts_apply_button_link');
        });
    }
};
