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
            $table->text('facebook')->nullable();
            $table->text('linkedin')->nullable();
            $table->text('insta')->nullable();
            $table->text('twitter')->nullable();
            $table->text('youtube')->nullable();
            $table->text('vk')->nullable();
            $table->text('main_button_link')->nullable();
            $table->text('other_button_link')->nullable();
            $table->boolean('quick_facts_status')->default(false);
            $table->boolean('overview_status')->default(false);
            $table->boolean('program_status')->default(false);
            $table->boolean('admission_status')->default(false);
            $table->boolean('financial_status')->default(false);
            $table->boolean('scholarship_status')->default(false);
            $table->boolean('contacts_status')->default(false);

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
            //
        });
    }
};
