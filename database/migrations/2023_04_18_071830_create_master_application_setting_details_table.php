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
        Schema::create('master_application_setting_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mas_app_stng_id')->nullable()->constrained('master_application_settings')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('language_id')->nullable()->constrained('languages')->onUpdate('cascade')->onDelete('cascade');
            $table->text('page_title',500)->nullable();
            $table->text('description')->nullable();
            $table->text('first_name_label', 500)->nullable();
            $table->text('first_name_placeholder', 500)->nullable();
            $table->text('first_name_error', 500)->nullable();
            $table->text('last_name_label', 500)->nullable();
            $table->text('last_name_placeholder', 500)->nullable();
            $table->text('last_name_error', 500)->nullable();
            $table->text('dob_label', 500)->nullable();
            $table->text('dob_placeholder', 500)->nullable();
            $table->text('dob_error', 500)->nullable();
            $table->text('gender_label', 500)->nullable();
            $table->text('gender_placeholder', 500)->nullable();
            $table->text('gender_error', 500)->nullable();
            $table->text('email_label', 500)->nullable();
            $table->text('email_placeholder', 500)->nullable();
            $table->text('email_error', 500)->nullable();
            $table->text('confirm_email_label', 500)->nullable();
            $table->text('confirm_email_placeholder', 500)->nullable();
            $table->text('confirm_email_error', 500)->nullable();
            $table->text('phone_label', 500)->nullable();
            $table->text('phone_placeholder', 500)->nullable();
            $table->text('phone_error', 500)->nullable();
            $table->text('can_school_text_label', 500)->nullable();
            $table->text('can_school_text_placeholder', 500)->nullable();
            $table->text('can_school_text_error', 500)->nullable();
            $table->text('message_app_label', 500)->nullable();
            $table->text('message_app_placeholder', 500)->nullable();
            $table->text('message_app_error', 500)->nullable();
            $table->text('message_app_username_label', 500)->nullable();
            $table->text('message_app_username_placeholder', 500)->nullable();
            $table->text('message_app_username_error', 500)->nullable();

            $table->text('currently_study_label', 500)->nullable();
            $table->text('currently_study_placeholder', 500)->nullable();
            $table->text('currently_study_error', 500)->nullable();
            $table->text('country_citzenship_label', 500)->nullable();
            $table->text('country_citzenship_placeholder', 500)->nullable();
            $table->text('country_citzenship_error', 500)->nullable();
            $table->text('live_in_country_citzenship_label', 500)->nullable();
            $table->text('live_in_country_citzenship_placeholder', 500)->nullable();
            $table->text('live_in_country_citzenship_error', 500)->nullable();
            $table->text('current_residence_label', 500)->nullable();
            $table->text('current_residence_placeholder', 500)->nullable();
            $table->text('current_residence_error', 500)->nullable();
            $table->text('country_residence_status_label', 500)->nullable();
            $table->text('country_residence_status_placeholder', 500)->nullable();
            $table->text('country_residence_status_error', 500)->nullable();
            $table->text('mailing_address_label', 500)->nullable();
            $table->text('mailing_address_placeholder', 500)->nullable();
            $table->text('mailing_address_error', 500)->nullable();
            $table->text('high_school_name_label', 500)->nullable();
            $table->text('high_school_name_placeholder', 500)->nullable();
            $table->text('high_school_name_error', 500)->nullable();
            $table->text('when_plan_to_start_label', 500)->nullable();
            $table->text('when_plan_to_start_placeholder', 500)->nullable();
            $table->text('when_plan_to_start_error', 500)->nullable();
            $table->text('intrested_in_label', 500)->nullable();
            $table->text('intrested_in_placeholder', 500)->nullable();
            $table->text('intrested_in_error', 500)->nullable();
            $table->text('would_like_to_study_label', 500)->nullable();
            $table->text('would_like_to_study_placeholder', 500)->nullable();
            $table->text('would_like_to_study_error', 500)->nullable();
            $table->text('tuition_funding_source_label', 500)->nullable();
            $table->text('tuition_funding_source_placeholder', 500)->nullable();
            $table->text('tuition_funding_source_error', 500)->nullable();
            $table->text('test_taken_label', 500)->nullable();
            $table->text('test_taken_placeholder', 500)->nullable();
            $table->text('test_taken_error', 500)->nullable();
            $table->text('additional_label', 500)->nullable();
            $table->text('additional_placeholder', 500)->nullable();
            $table->text('additional_error', 500)->nullable();
            $table->text('add_something_lable', 500)->nullable();
            $table->text('add_something_placeholder', 500)->nullable();
            $table->text('add_something_error', 500)->nullable();
            $table->text('currently_live_in_lable', 500)->nullable();
            $table->text('currently_live_in_placeholder', 500)->nullable();
            $table->text('currently_live_in_error', 500)->nullable();
            $table->text('study_permet_lable', 500)->nullable();
            $table->text('study_permet_placeholder', 500)->nullable();
            $table->text('study_permet_error', 500)->nullable();
            $table->text('send_copy_lable', 500)->nullable();
            $table->text('send_copy_placeholder', 500)->nullable();
            $table->text('send_copy_error', 500)->nullable();
            $table->text('where_want_to_study_lable', 500)->nullable();
            $table->text('where_want_to_study_placeholder', 500)->nullable();
            $table->text('where_want_to_study_error', 500)->nullable();
            $table->text('high_school_cgpa_lable', 500)->nullable();
            $table->text('high_school_cgpa_placeholder', 500)->nullable();
            $table->text('high_school_cgpa_error', 500)->nullable();
            $table->text('high_school_city_lable', 500)->nullable();
            $table->text('high_school_city_placeholder', 500)->nullable();
            $table->text('high_school_city_error', 500)->nullable();
            $table->text('high_school_country_lable', 500)->nullable();
            $table->text('high_school_country_placeholder', 500)->nullable();
            $table->text('high_school_country_error', 500)->nullable();
            $table->text('student_type_lable', 500)->nullable();
            $table->text('student_type_placeholder', 500)->nullable();
            $table->text('student_type_error', 500)->nullable();
            $table->text('button_text', 500)->nullable();
            $table->text('privacy_policy', 500)->nullable();
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
        Schema::dropIfExists('master_application_setting_details');
    }
};
