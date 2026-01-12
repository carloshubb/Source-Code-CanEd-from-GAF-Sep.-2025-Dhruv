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
        Schema::create('bus_directory_setting_details', function (Blueprint $table) {
            $table->id();
            $table
                ->foreignId('bus_directory_setting_id')
                ->nullable()
                ->constrained('bus_directory_settings')
                ->onUpdate('cascade')
                ->onDelete('cascade');
                $table
                ->foreignId('language_id')
                ->nullable()
                ->constrained('languages')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->text('city_label');
            $table->text('city_placeholder');
            $table->text('city_error');
            $table->text('province_label');
            $table->text('province_placeholder');
            $table->text('province_error');
            $table->text('company_name_label');
            $table->text('company_name_placeholder');
            $table->text('company_name_error');
            $table->text('industry_label');
            $table->text('industry_placeholder');
            $table->text('industry_error');
            $table->text('button_text');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bus_directory_setting_details');
    }
};
