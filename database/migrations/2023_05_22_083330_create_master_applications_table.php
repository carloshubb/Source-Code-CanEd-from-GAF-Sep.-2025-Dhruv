<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_applications', function (Blueprint $table) {
            $table->id();
            $table->text('first_name')->nullable();
            $table->text('last_name')->nullable();
            $table->text('email')->nullable();
            $table->text('confirm_email')->nullable();
            $table->text('dob')->nullable();
            $table->text('gender')->nullable();
            $table->text('phone')->nullable();
            $table->text('can_school_text_you')->nullable();
            $table->text('messaging_app')->nullable();
            $table->text('messaging_app_username')->nullable();
            $table->text('where_want_to_study')->nullable();
            $table->text('country_of_citizenship')->nullable();
            $table->text('live_in_your_country_citizenship')->nullable();
            $table->text('current_residance')->nullable();
            $table->text('current_residance_status')->nullable();
            $table->text('mailing_address')->nullable();
            $table->text('high_school_name')->nullable();
            $table->text('high_school_cgpa')->nullable();
            $table->text('high_school_city')->nullable();
            $table->text('high_school_country')->nullable();
            $table->text('when_plan_to_start')->nullable();
            $table->text('interested_in')->nullable();
            $table->text('would_like_to_study')->nullable();
            $table->text('student_type')->nullable();
            $table->text('tuition_funding_source')->nullable();
            $table->text('test_taken')->nullable();
            $table->text('addtional')->nullable();
            $table->text('add_anything')->nullable();
            $table->text('currently_living_in_canada')->nullable();
            $table->text('study_permit_candian_embassy')->nullable();
            $table->text('send_me_a_copy')->nullable();
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
        Schema::dropIfExists('master_applications');
    }
};
