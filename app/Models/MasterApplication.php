<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterApplication extends Model
{
    use HasFactory;
    protected $fillable = ['first_name', 'last_name', 'email', 'confirm_email', 'dob', 'gender', 'phone', 'can_school_text_you', 'messaging_app', 'messaging_app_username', 'where_want_to_study', 'country_of_citizenship', 'live_in_your_country_citizenship', 'current_residance', 'current_residance_status', 'mailing_address', 'high_school_name', 'high_school_cgpa', 'high_school_city', 'high_school_country', 'when_plan_to_start', 'interested_in', 'would_like_to_study', 'student_type', 'tuition_funding_source', 'addtional', 'add_anything', 'currently_living_in_canada','currently_student_anywhere', 'study_permit_candian_embassy', 'test_taken', 'send_me_a_copy', 'school_id', 'customer_id', 'other_test_1_name', 'other_test_1_score', 'other_test_2_name', 'other_test_2_score', 'other_test_3_name', 'other_test_3_score','other_test_4_name','other_test_4_score','other_test_5_name','other_test_5_score',
    'letter_of_intent',    
    'statement_of_purpose',    
    'for_demetra_or_master_app',    
    ];

    public function school()
    {
        return $this->belongsTo(School::class, 'school_id', 'id')->with('schoolDetail');
    }

    public function tests()
    {
        return $this->hasMany(MasterApplicationTest::class)->with(['test', 'test.testDetail']);
    }

    public function messagingApps()
    {
        return $this->hasMany(MasterApplicationMessagingApp::class)->with(['messagingApp', 'messagingApp.messagingAppDetail']);
    }

    public function degree()
    {
        return $this->belongsTo(Degree::class, 'interested_in', 'id')->with('degreeDetail');
    }

    public function programs()
    {
        return $this->hasMany(MasterApplicationProgram::class)->with(['program', 'program.programDetail']);
    }
}
