<?php

namespace App\Http\Controllers\Api\Web;

use App\Http\Controllers\Controller;
use App\Http\Resources\Web\MasterApplicationResource;
use App\Jobs\MasterApplicationEmailJob;
use Illuminate\Support\Str;
use App\Models\MasterApplication;
use App\Models\MasterApplicationMessagingApp;
use App\Models\MasterApplicationProgram;
use App\Models\MasterApplicationSetting;
use App\Models\School;
use App\Models\User;
use App\Models\MasterApplicationTest;
use App\Models\Setting;
use App\Services\FomSubmissionCountService;
use App\Traits\StatusResponser;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use App\Jobs\SendThresholdEmailJob;

class MasterApplicationController extends Controller
{
    use StatusResponser;
    use FileUploadTrait;

    public function index()
    {
        $customer = auth()
            ->guard('customers')
            ->user();
        $openDays = MasterApplication::whereCustomerId($customer->id);
        $openDays = $this->whereClause($openDays);
        $openDays = $this->loadRelations($openDays);
        $openDays = $this->sortingAndLimit($openDays);

        return $this->apiSuccessResponse(MasterApplicationResource::collection($openDays), 'Data Get Successfully!');
    }

    public function show(MasterApplication $MasterApplication)
    {

        return $this->apiSuccessResponse(new MasterApplicationResource($MasterApplication), 'Data Get Successfully!');
    }

    public function getMasterApplication($id)
    {
        $masterApplication = MasterApplication::where('customer_id', $id)->first();
        if ($masterApplication) {
            return $this->apiSuccessResponse(new MasterApplicationResource($masterApplication), 'Data retrieved successfully!');
        } else {
            return $this->apiErrorResponse('Master application not found for this customer.', 404);
        }
    }

    public function getMasterApplicationSchools($id)
    {
        $masterApplicationSchools = MasterApplication::where('customer_id', $id)->pluck('school_id');
        if ($masterApplicationSchools) {
            return response()->json([
                'status' => 'success',
                'data' => $masterApplicationSchools,
                'message' => 'Data retrieved successfully!'
            ]);
        } else {
            return $this->apiErrorResponse('Master application not found for this customer.', 404);
        }
    }

    public function store(Request $request)
    {
        // dd($request->all());
        // dd($request->other_name_5);
        // dd(gettype($request->would_like_to_study));
        $wouldLikeToStudyArray = $request->would_like_to_study;

        $validationRule = [
            'first_name' => ['required'],
            'last_name' => ['required'],
            'email' => ['required', 'email'],
            'confirm_email' => ['required', 'email', 'same:email'],
            'dob' => ['required'],
            'gender' => ['required'],
            'phone' => ['nullable'],
            'can_school_text_you' => ['nullable'],
            'where_want_to_study' => ['required'],
            'country_of_citizenship' => ['required'],
            'live_in_your_country_citizenship' => ['required'],
            'mailing_address' => ['required'],
            'high_school_name' => ['required'],
            'high_school_cgpa' => ['required'],
            'high_school_city' => ['required'],
            'high_school_country' => ['required'],
            'when_plan_to_start' => ['required'],
            'interested_in' => ['required'],
            'would_like_to_study' => ['required'],
            'student_type' => ['required'],
            'tuition_funding_source' => ['required'],
            'addtional' => ['required'],
            'add_anything' => ['required'],
            'study_permit_candian_embassy' => ['required'],
            'test_taken' => ['array', 'required'],
            'test_taken.*.test' => ['required'],
            'test_taken.*.score' => ['required'],
            'send_me_a_copy' => ['required'],
            'for_demetra_or_master_app' => ['required'],
            // 'school_id' => ['array', 'required'],
        ];

        if ($request->statement_of_purpose) {
            $validationRule['statement_of_purpose'] = ['url'];
        }

        if ($request->letter_of_intent) {
            $validationRule['letter_of_intent'] = ['url'];
        }

        if ($request->input('for_demetra_or_master_app') !== 'reverse_admissions') {
            $validationRule['school_id'] = ['array', 'required'];
        } else {
            $validationRule['school_id'] = ['nullable'];  // Allow school_id to be null when reverse_admissions
        }



        // Check if 'can_school_text_you' is 'yes'
        if ($request->input('can_school_text_you') === 'yes') {
            $validationRule['messaging_app'] = ['nullable'];
            $validationRule['messaging_app.*'] = ['nullable'];
        }

        if ($request->input('live_in_your_country_citizenship') === 'no') {
            $validationRule['current_residance'] = ['required'];
            $validationRule['current_residance_status'] = ['required'];
        }


        $niceNames = [];
        $defaultLang = getDefaultLanguage(1);
        if ($defaultLang) {
            App::setLocale($defaultLang->abbreviation);
            // $defaultLang = getDefaultLanguage(1);
            $masterApplicationSetting = MasterApplicationSetting::with([
                'masterApplicationSettingDetail' => function ($q) use ($defaultLang) {
                    $q = $q->where('language_id', $defaultLang->id);
                },
            ])->first();
            $niceNames = [
                'first_name' => isset($masterApplicationSetting->masterApplicationSettingDetail[0]->first_name_error) ? $masterApplicationSetting->masterApplicationSettingDetail[0]->first_name_error : '',
                'last_name' => isset($masterApplicationSetting->masterApplicationSettingDetail[0]->last_name_error) ? $masterApplicationSetting->masterApplicationSettingDetail[0]->last_name_error : '',
                'email' => isset($masterApplicationSetting->masterApplicationSettingDetail[0]->email_error) ? $masterApplicationSetting->masterApplicationSettingDetail[0]->email_error : '',
                'confirm_email' => isset($masterApplicationSetting->masterApplicationSettingDetail[0]->confirm_email_error) ? $masterApplicationSetting->masterApplicationSettingDetail[0]->confirm_email_error : '',
                'dob' => isset($masterApplicationSetting->masterApplicationSettingDetail[0]->dob_error) ? $masterApplicationSetting->masterApplicationSettingDetail[0]->dob_error : '',
                'gender' => isset($masterApplicationSetting->masterApplicationSettingDetail[0]->gender_error) ? $masterApplicationSetting->masterApplicationSettingDetail[0]->gender_error : '',
                'phone' => isset($masterApplicationSetting->masterApplicationSettingDetail[0]->phone_error) ? $masterApplicationSetting->masterApplicationSettingDetail[0]->phone_error : '',
                'can_school_text_you' => isset($masterApplicationSetting->masterApplicationSettingDetail[0]->can_school_text_error) ? $masterApplicationSetting->masterApplicationSettingDetail[0]->can_school_text_error : '',
                'messaging_app' => isset($masterApplicationSetting->masterApplicationSettingDetail[0]->message_app_error) ? $masterApplicationSetting->masterApplicationSettingDetail[0]->message_app_error : '',
                'where_want_to_study' => isset($masterApplicationSetting->masterApplicationSettingDetail[0]->currently_study_error) ? $masterApplicationSetting->masterApplicationSettingDetail[0]->currently_study_error : '',
                'country_of_citizenship' => isset($masterApplicationSetting->masterApplicationSettingDetail[0]->country_citzenship_error) ? $masterApplicationSetting->masterApplicationSettingDetail[0]->country_citzenship_error : '',
                'live_in_your_country_citizenship' => isset($masterApplicationSetting->masterApplicationSettingDetail[0]->live_in_country_citzenship_error) ? $masterApplicationSetting->masterApplicationSettingDetail[0]->live_in_country_citzenship_error : '',
                'mailing_address' => isset($masterApplicationSetting->masterApplicationSettingDetail[0]->mailing_address_error) ? $masterApplicationSetting->masterApplicationSettingDetail[0]->mailing_address_error : '',
                'high_school_name' => isset($masterApplicationSetting->masterApplicationSettingDetail[0]->high_school_name_error) ? $masterApplicationSetting->masterApplicationSettingDetail[0]->high_school_name_error : '',
                'high_school_cgpa' => isset($masterApplicationSetting->masterApplicationSettingDetail[0]->high_school_cgpa_error) ? $masterApplicationSetting->masterApplicationSettingDetail[0]->high_school_cgpa_error : '',
                'high_school_city' => isset($masterApplicationSetting->masterApplicationSettingDetail[0]->high_school_city_error) ? $masterApplicationSetting->masterApplicationSettingDetail[0]->high_school_city_error : '',
                'high_school_country' => isset($masterApplicationSetting->masterApplicationSettingDetail[0]->high_school_country_error) ? $masterApplicationSetting->masterApplicationSettingDetail[0]->high_school_country_error : '',
                'when_plan_to_start' => isset($masterApplicationSetting->masterApplicationSettingDetail[0]->where_want_to_study_error) ? $masterApplicationSetting->masterApplicationSettingDetail[0]->where_want_to_study_error : '',
                'interested_in' => isset($masterApplicationSetting->masterApplicationSettingDetail[0]->intrested_in_error) ? $masterApplicationSetting->masterApplicationSettingDetail[0]->intrested_in_error : '',
                'would_like_to_study' => isset($masterApplicationSetting->masterApplicationSettingDetail[0]->would_like_to_study_error) ? $masterApplicationSetting->masterApplicationSettingDetail[0]->would_like_to_study_error : '',
                'student_type' => isset($masterApplicationSetting->masterApplicationSettingDetail[0]->student_type_error) ? $masterApplicationSetting->masterApplicationSettingDetail[0]->student_type_error : '',
                'tuition_funding_source' => isset($masterApplicationSetting->masterApplicationSettingDetail[0]->tuition_funding_source_error) ? $masterApplicationSetting->masterApplicationSettingDetail[0]->tuition_funding_source_error : '',
                'addtional' => isset($masterApplicationSetting->masterApplicationSettingDetail[0]->additional_error) ? $masterApplicationSetting->masterApplicationSettingDetail[0]->additional_error : '',
                'add_anything' => isset($masterApplicationSetting->masterApplicationSettingDetail[0]->add_something_error) ? $masterApplicationSetting->masterApplicationSettingDetail[0]->add_something_error : '',
                'study_permit_candian_embassy' => isset($masterApplicationSetting->masterApplicationSettingDetail[0]->study_permet_error) ? $masterApplicationSetting->masterApplicationSettingDetail[0]->study_permet_error : '',
                'test_taken' => isset($masterApplicationSetting->masterApplicationSettingDetail[0]->test_taken_error) ? $masterApplicationSetting->masterApplicationSettingDetail[0]->test_taken_error : '',
                'send_me_a_copy' => isset($masterApplicationSetting->masterApplicationSettingDetail[0]->send_copy_error) ? $masterApplicationSetting->masterApplicationSettingDetail[0]->send_copy_error : '',
                'school_id' => isset($masterApplicationSetting->masterApplicationSettingDetail[0]->school_error) ? $masterApplicationSetting->masterApplicationSettingDetail[0]->school_error : '',
                'for_demetra_or_master_app' => isset($masterApplicationSetting->masterApplicationSettingDetail[0]->school_error) ? $masterApplicationSetting->masterApplicationSettingDetail[0]->school_error : '',

            ];
        }
        $this->validate($request, $validationRule, $niceNames);
        $master_application_school_count = Setting::where('key', 'master_application_school_count')->value('value');
        if ($master_application_school_count < count($request->school_id)) {
            return response()->json(['error' => 'You can select schools up to ' . $master_application_school_count], 400);
        }
        $formSubmissionService = new FomSubmissionCountService();
        $result = $formSubmissionService->advertiserForm();
        if ($result['status'] == 'Error') {
            return $result;
        }
        
        $customer = isset(
            auth()
            ->guard('customers')
            ->user()->id,
            )
            ? auth()
            ->guard('customers')
            ->user()->id
            : null;
            
            $schools = isset($request->school_id) ? $request->school_id : [];
            $MasterApplication = null;
            if (empty($schools)) {
                // dd($request->would_like_to_study);
                $MasterApplication = MasterApplication::where('customer_id', $request->customer_id)->first();
                if (isset($MasterApplication) && !is_null($MasterApplication)) {
                    
                $MasterApplication->school_id = null;
                $MasterApplication->first_name = $request->first_name;
                $MasterApplication->last_name = $request->last_name;
                $MasterApplication->email = $request->email;
                $MasterApplication->confirm_email = $request->confirm_email;
                $MasterApplication->would_like_to_study = $request->would_like_to_study;
                $MasterApplication->dob = $request->dob;
                $MasterApplication->gender = $request->gender;
                $MasterApplication->phone = $request->phone;
                $MasterApplication->can_school_text_you = $request->can_school_text_you;
                $MasterApplication->where_want_to_study = json_encode($request->where_want_to_study);
                $MasterApplication->country_of_citizenship = $request->country_of_citizenship;
                $MasterApplication->live_in_your_country_citizenship = $request->live_in_your_country_citizenship;
                $MasterApplication->current_residance = $request->current_residance;
                $MasterApplication->current_residance_status = $request->current_residance_status;
                $MasterApplication->mailing_address = $request->mailing_address;
                $MasterApplication->high_school_name = $request->high_school_name;
                $MasterApplication->high_school_cgpa = $request->high_school_cgpa;
                $MasterApplication->high_school_city = $request->high_school_city;
                $MasterApplication->high_school_country = $request->high_school_country;
                $MasterApplication->currently_living_in_canada = $request->currently_living_in_canada;
                $MasterApplication->currently_student_anywhere = $request->currently_student_anywhere;
                $MasterApplication->when_plan_to_start = $request->when_plan_to_start;
                $MasterApplication->interested_in = $request->interested_in;
                $MasterApplication->student_type = $request->student_type;
                $MasterApplication->tuition_funding_source = json_encode($request->tuition_funding_source);
                $MasterApplication->addtional = $request->addtional;
                $MasterApplication->add_anything = $request->add_anything;
                $MasterApplication->study_permit_candian_embassy = $request->study_permit_candian_embassy;
                $MasterApplication->send_me_a_copy = $request->send_me_a_copy;
                $MasterApplication->for_demetra_or_master_app = $request->for_demetra_or_master_app;
                $MasterApplication->customer_id = $customer;
                $MasterApplication->letter_of_intent = $request->letter_of_intent;
                $MasterApplication->statement_of_purpose = $request->statement_of_purpose;
                $MasterApplication->other_test_1_name = $request->other_name_1;
                $MasterApplication->other_test_1_score = $request->other_score_1;
                $MasterApplication->other_test_2_name = $request->other_name_2;
                $MasterApplication->other_test_2_score = $request->other_score_2;
                $MasterApplication->other_test_3_name = $request->other_name_3;
                $MasterApplication->other_test_3_score = $request->other_score_3;
                $MasterApplication->other_test_4_name = $request->other_name_4;
                $MasterApplication->other_test_4_score = $request->other_score_4;
                $MasterApplication->other_test_5_name = $request->other_name_5;
                $MasterApplication->other_test_5_score = $request->other_score_5;
                $MasterApplication->save();
            } else {
                $MasterApplication = MasterApplication::create([
                    'school_id' => null,
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'email' => $request->email,
                    'confirm_email' => $request->confirm_email,
                    'would_like_to_study' => $request->would_like_to_study,
                    'dob' => $request->dob,
                    'gender' => $request->gender,
                    'phone' => $request->phone,
                    'can_school_text_you' => $request->can_school_text_you,
                    'where_want_to_study' => json_encode($request->where_want_to_study),
                    'country_of_citizenship' => $request->country_of_citizenship,
                    'live_in_your_country_citizenship' => $request->live_in_your_country_citizenship,
                    'current_residance' => $request->current_residance,
                    'current_residance_status' => $request->current_residance_status,
                    'mailing_address' => $request->mailing_address,
                    'high_school_name' => $request->high_school_name,
                    'high_school_cgpa' => $request->high_school_cgpa,
                    'high_school_city' => $request->high_school_city,
                    'high_school_country' => $request->high_school_country,
                    'currently_living_in_canada' => $request->currently_living_in_canada,
                    'currently_student_anywhere' => $request->currently_student_anywhere,
                    'when_plan_to_start' => $request->when_plan_to_start,
                    'interested_in' => $request->interested_in,
                    'student_type' => $request->student_type,
                    'tuition_funding_source' => json_encode($request->tuition_funding_source),
                    'addtional' => $request->addtional,
                    'add_anything' => $request->add_anything,
                    'study_permit_candian_embassy' => $request->study_permit_candian_embassy,
                    'send_me_a_copy' => $request->send_me_a_copy,
                    'for_demetra_or_master_app' => $request->for_demetra_or_master_app,
                    'letter_of_intent' => $request->letter_of_intent,
                    'statement_of_purpose' => $request->statement_of_purpose,
                    'customer_id' => $customer,
                    'other_test_1_name' => $request->other_name_1,
                    'other_test_1_score' => $request->other_score_1,
                    'other_test_2_name' => $request->other_name_2,
                    'other_test_2_score' => $request->other_score_2,
                    'other_test_3_name' => $request->other_name_3,
                    'other_test_3_score' => $request->other_score_3,
                    'other_test_4_name' => $request->other_name_4,
                    'other_test_4_score' => $request->other_score_4,
                    'other_test_5_name' => $request->other_name_5,
                    'other_test_5_score' => $request->other_score_5,

                ]);
            }


            if (isset($MasterApplication) && !empty($MasterApplication)) {
                MasterApplicationTest::where('master_application_id', $MasterApplication->id)->delete();
                if (is_array($request->test_taken)) {
                    foreach ($request->test_taken as $testTaken) {
                        MasterApplicationTest::create([
                            'master_application_id' => $MasterApplication->id,
                            'test_id' => $testTaken['test'],
                            'score' => $testTaken['score'],
                        ]);
                    }
                }
                MasterApplicationProgram::where('master_application_id', $MasterApplication->id)->delete();
                if (is_array($wouldLikeToStudyArray)) {
                    foreach ($wouldLikeToStudyArray as $program) {
                        MasterApplicationProgram::create([
                            'master_application_id' => $MasterApplication->id,
                            'program_id' => $program,
                        ]);
                    }
                }
                MasterApplicationMessagingApp::where('master_application_id', $MasterApplication->id)->delete();
                if (is_array($request->messaging_app)) {
                    foreach ($request->messaging_app as $key => $messaging_app) {
                        MasterApplicationMessagingApp::create([
                            'master_application_id' => $MasterApplication->id,
                            'messaging_app_id' => $messaging_app,
                            'user_name' => isset($request->messaging_app_username[$key]) ? $request->messaging_app_username[$key] : null,
                        ]);
                    }
                }
                // Normalize the messaging_app input to always be an array
                $messaging_apps = is_array($request->messaging_app) ? $request->messaging_app : [$request->messaging_app];

                // Normalize the messaging_app_username input to match the messaging_apps
                $messaging_app_usernames = is_array($request->messaging_app_username) ? $request->messaging_app_username : [$request->messaging_app_username];

                // Check if both arrays have the same length
                $maxLength = max(count($messaging_apps), count($messaging_app_usernames));

                for ($i = 0; $i < $maxLength; $i++) {
                    // Get the current messaging app and username, defaulting to null if not available
                    $messaging_app = isset($messaging_apps[$i]) ? $messaging_apps[$i] : null;
                    $user_name = isset($messaging_app_usernames[$i]) ? $messaging_app_usernames[$i] : null;

                    // Only create a record if the messaging_app is not null
                    if ($messaging_app) {
                        MasterApplicationMessagingApp::create([
                            'master_application_id' => $MasterApplication->id,
                            'messaging_app_id' => $messaging_app,
                            'user_name' => $user_name,
                        ]);
                    }
                }

                dispatch(new MasterApplicationEmailJob($request->all()));
            }
        } else {

            foreach ($schools as $school_id) {
                $MasterApplication = MasterApplication::where('customer_id', $request->customer_id)->where('school_id', $school_id)->first();
                if (isset($MasterApplication) && !is_null($MasterApplication)) {
                    $MasterApplication->school_id = $school_id;

                    $MasterApplication->first_name = $request->first_name;
                    $MasterApplication->would_like_to_study  = $request->would_like_to_study;
                    $MasterApplication->last_name = $request->last_name;
                    $MasterApplication->email = $request->email;
                    $MasterApplication->confirm_email = $request->confirm_email;
                    $MasterApplication->dob = $request->dob;
                    $MasterApplication->gender = $request->gender;
                    $MasterApplication->phone = $request->phone;
                    $MasterApplication->can_school_text_you = $request->can_school_text_you;
                    $MasterApplication->where_want_to_study = json_encode($request->where_want_to_study);
                    $MasterApplication->country_of_citizenship = $request->country_of_citizenship;
                    $MasterApplication->live_in_your_country_citizenship = $request->live_in_your_country_citizenship;
                    $MasterApplication->current_residance = $request->current_residance;
                    $MasterApplication->current_residance_status = $request->current_residance_status;
                    $MasterApplication->mailing_address = $request->mailing_address;
                    $MasterApplication->high_school_name = $request->high_school_name;
                    $MasterApplication->high_school_cgpa = $request->high_school_cgpa;
                    $MasterApplication->high_school_city = $request->high_school_city;
                    $MasterApplication->high_school_country = $request->high_school_country;
                    $MasterApplication->currently_living_in_canada = $request->currently_living_in_canada;
                    $MasterApplication->currently_student_anywhere = $request->currently_student_anywhere;
                    $MasterApplication->when_plan_to_start = $request->when_plan_to_start;
                    $MasterApplication->interested_in = $request->interested_in;
                    $MasterApplication->student_type = $request->student_type;
                    $MasterApplication->tuition_funding_source = json_encode($request->tuition_funding_source);
                    $MasterApplication->addtional = $request->addtional;
                    $MasterApplication->add_anything = $request->add_anything;
                    $MasterApplication->study_permit_candian_embassy = $request->study_permit_candian_embassy;
                    $MasterApplication->send_me_a_copy = $request->send_me_a_copy;
                    $MasterApplication->for_demetra_or_master_app = $request->for_demetra_or_master_app;
                    $MasterApplication->customer_id = $customer;
                    $MasterApplication->letter_of_intent = $request->letter_of_intent;
                    $MasterApplication->statement_of_purpose = $request->statement_of_purpose;
                    $MasterApplication->other_test_1_name = $request->other_name_1;
                    $MasterApplication->other_test_1_score = $request->other_score_1;
                    $MasterApplication->other_test_2_name = $request->other_name_2;
                    $MasterApplication->other_test_2_score = $request->other_score_2;
                    $MasterApplication->other_test_3_name = $request->other_name_3;
                    $MasterApplication->other_test_3_score = $request->other_score_3;
                    $MasterApplication->other_test_4_name = $request->other_name_4;
                    $MasterApplication->other_test_4_score = $request->other_score_4;
                    $MasterApplication->other_test_5_name = $request->other_name_5;
                    $MasterApplication->other_test_5_score = $request->other_score_5;
                    $MasterApplication->save();
                } else {
                    $MasterApplication = MasterApplication::create([
                        'school_id' => $school_id,
                        'first_name' => $request->first_name,
                        'last_name' => $request->last_name,
                        'email' => $request->email,
                        'confirm_email' => $request->confirm_email,
                        'dob' => $request->dob,
                        'gender' => $request->gender,
                        'phone' => $request->phone,
                        'can_school_text_you' => $request->can_school_text_you,
                        'where_want_to_study' => json_encode($request->where_want_to_study),
                        'country_of_citizenship' => $request->country_of_citizenship,
                        'live_in_your_country_citizenship' => $request->live_in_your_country_citizenship,
                        'current_residance' => $request->current_residance,
                        'current_residance_status' => $request->current_residance_status,
                        'mailing_address' => $request->mailing_address,
                        'high_school_name' => $request->high_school_name,
                        'high_school_cgpa' => $request->high_school_cgpa,
                        'high_school_city' => $request->high_school_city,
                        'high_school_country' => $request->high_school_country,
                        'currently_living_in_canada' => $request->currently_living_in_canada,
                        'currently_student_anywhere' => $request->currently_student_anywhere,
                        'when_plan_to_start' => $request->when_plan_to_start,
                        'interested_in' => $request->interested_in,
                        'student_type' => $request->student_type,
                        'tuition_funding_source' => json_encode($request->tuition_funding_source),
                        'addtional' => $request->addtional,
                        'add_anything' => $request->add_anything,
                        'study_permit_candian_embassy' => $request->study_permit_candian_embassy,
                        'send_me_a_copy' => $request->send_me_a_copy,
                        'for_demetra_or_master_app' => $request->for_demetra_or_master_app,
                        'letter_of_intent' => $request->letter_of_intent,
                        'statement_of_purpose' => $request->statement_of_purpose,
                        'customer_id' => $customer,
                        'other_test_1_name' => $request->other_name_1,
                        'other_test_1_score' => $request->other_score_1,
                        'other_test_2_name' => $request->other_name_2,
                        'other_test_2_score' => $request->other_score_2,
                        'other_test_3_name' => $request->other_name_3,
                        'other_test_3_score' => $request->other_score_3,
                        'other_test_4_name' => $request->other_name_4,
                        'other_test_4_score' => $request->other_score_4,
                        'other_test_5_name' => $request->other_name_5,
                        'other_test_5_score' => $request->other_score_5,

                    ]);


                    $AppCount = MasterApplication::where('school_id', $school_id)->count();
                    $school = School::where('id', $school_id)->first();
                    if ($AppCount >= $school->master_app_threshold) {
                        $adminEmail = User::first()->email;
                        $emailData = [
                            'school_name' => $school->schoolDetail[0]->school_name,
                            'threshold' => $school->master_app_threshold,
                            'current_count' => $AppCount,
                            'email' => $adminEmail,
                        ];

                        dispatch(new SendThresholdEmailJob($emailData));
                    }
                }


                if (isset($MasterApplication) && !empty($MasterApplication)) {
                    MasterApplicationTest::where('master_application_id', $MasterApplication->id)->delete();
                    if (is_array($request->test_taken)) {
                        foreach ($request->test_taken as $testTaken) {
                            MasterApplicationTest::create([
                                'master_application_id' => $MasterApplication->id,
                                'test_id' => $testTaken['test'],
                                'score' => $testTaken['score'],
                            ]);
                        }
                    }

                    MasterApplicationProgram::where('master_application_id', $MasterApplication->id)->delete();
                    if (is_array($wouldLikeToStudyArray)) {
                        foreach ($wouldLikeToStudyArray as $program) {
                            MasterApplicationProgram::create([
                                'master_application_id' => $MasterApplication->id,
                                'program_id' => $program,
                            ]);
                        }
                    }
                    MasterApplicationMessagingApp::where('master_application_id', $MasterApplication->id)->delete();
                    // if (is_array($request->messaging_app)) {
                    //     foreach ($request->messaging_app as $key => $messaging_app) {
                    //         MasterApplicationMessagingApp::create([
                    //             'master_application_id' => $MasterApplication->id,
                    //             'messaging_app_id' => $messaging_app,
                    //             'user_name' => isset($request->messaging_app_username[$key]) ? $request->messaging_app_username[$key] : null,
                    //         ]);
                    //     }
                    // }
                    // Normalize the messaging_app input to always be an array
                    $messaging_apps = is_array($request->messaging_app) ? $request->messaging_app : [$request->messaging_app];

                    $messaging_app_usernames = is_array($request->messaging_app_username) ? $request->messaging_app_username : [$request->messaging_app_username];

                    $maxLength = max(count($messaging_apps), count($messaging_app_usernames));

                    for ($i = 0; $i < $maxLength; $i++) {
                        // Get the current messaging app and username, defaulting to null if not available
                        $messaging_app = isset($messaging_apps[$i]) ? $messaging_apps[$i] : null;
                        $user_name = isset($messaging_app_usernames[$i]) ? $messaging_app_usernames[$i] : null;

                        // Only create a record if the messaging_app is not null
                        if ($messaging_app) {
                            MasterApplicationMessagingApp::create([
                                'master_application_id' => $MasterApplication->id,
                                'messaging_app_id' => $messaging_app,
                                'user_name' => $user_name,
                            ]);
                        }
                    }

                    dispatch(new MasterApplicationEmailJob($request->all()));
                }
            }
        }

        return $this->apiSuccessResponse(new MasterApplicationResource($MasterApplication), 'Your changes have been done successfully');
        // return $this->errorResponse();
    }


    public function update(Request $request, MasterApplication $MasterApplication)
    {
        // dd($request->all());
        $validationRule = [];
        $errorMessages = [];
        $validationRule = array_merge($validationRule, ['first_name' => ['required', 'string']]);
        $errorMessages = array_merge($errorMessages, ['first_name' . '.required' => 'City is required.']);
        $validationRule = array_merge($validationRule, ['last_name' => ['required', 'string']]);
        $errorMessages = array_merge($errorMessages, ['last_name' . '.required' => 'Country is required.']);
        $validationRule = array_merge($validationRule, ['email' => ['required', 'string']]);
        $errorMessages = array_merge($errorMessages, ['email' . '.required' => 'Address is required.']);
        $validationRule = array_merge($validationRule, ['confirm_email' => ['required', 'string']]);
        $errorMessages = array_merge($errorMessages, ['confirm_email' . '.required' => 'School email is required.']);
        $validationRule = array_merge($validationRule, ['dob' => ['required', 'string']]);
        $errorMessages = array_merge($errorMessages, ['dob' . '.required' => 'School phone is required.']);
        $validationRule = array_merge($validationRule, ['gender' => ['required', 'string']]);
        $errorMessages = array_merge($errorMessages, ['gender' . '.required' => 'Image is required.']);
        $validationRule = array_merge($validationRule, ['phone' => ['required']]);
        $errorMessages = array_merge($errorMessages, ['gender' . '.required' => 'Image is required.']);
        $validationRule = array_merge($validationRule, ['can_school_text_you' => ['required']]);
        $errorMessages = array_merge($errorMessages, ['gender' . '.required' => 'Image is required.']);
        $validationRule = array_merge($validationRule, ['messaging_app' => ['required']]);
        $errorMessages = array_merge($errorMessages, ['gender' . '.required' => 'Image is required.']);
        $errorMessages = array_merge($errorMessages, ['gender' . '.required' => 'Image is required.']);
        $validationRule = array_merge($validationRule, ['where_want_to_study' => ['required']]);
        $errorMessages = array_merge($errorMessages, ['gender' . '.required' => 'Image is required.']);
        $validationRule = array_merge($validationRule, ['country_of_citizenship' => ['required']]);
        $errorMessages = array_merge($errorMessages, ['gender' . '.required' => 'Image is required.']);
        $validationRule = array_merge($validationRule, ['live_in_your_country_citizenship' => ['required']]);
        $errorMessages = array_merge($errorMessages, ['live_in_your_country_citizenship' . '.required' => 'Live in your country citizenship is required.']);
        $validationRule = array_merge($validationRule, ['mailing_address' => ['required']]);
        $errorMessages = array_merge($errorMessages, ['mailing_address' . '.required' => 'Mailing address is required.']);
        $validationRule = array_merge($validationRule, ['high_school_name' => ['required']]);
        $errorMessages = array_merge($errorMessages, ['high_school_name' . '.required' => 'High school name is required.']);
        $validationRule = array_merge($validationRule, ['high_school_cgpa' => ['required']]);
        $errorMessages = array_merge($errorMessages, ['high_school_cgpa' . '.required' => 'High school cgpa is required.']);
        $validationRule = array_merge($validationRule, ['high_school_city' => ['required']]);
        $errorMessages = array_merge($errorMessages, ['high_school_city' . '.required' => 'Hight school city is required.']);
        $validationRule = array_merge($validationRule, ['high_school_country' => ['required']]);
        $errorMessages = array_merge($errorMessages, ['high_school_country' . '.required' => 'High school country is required.']);
        $validationRule = array_merge($validationRule, ['when_plan_to_start' => ['required']]);
        $errorMessages = array_merge($errorMessages, ['when_plan_to_start' . '.required' => 'When plan to start is required.']);
        $validationRule = array_merge($validationRule, ['interested_in' => ['required']]);
        $errorMessages = array_merge($errorMessages, ['interested_in' . '.required' => 'Interested in is required.']);
        $validationRule = array_merge($validationRule, ['would_like_to_study' => ['required']]);
        $errorMessages = array_merge($errorMessages, ['would_like_to_study' . '.required' => 'Would like to study is required.']);
        $validationRule = array_merge($validationRule, ['student_type' => ['required']]);
        $errorMessages = array_merge($errorMessages, ['student_type' . '.required' => 'Student type is required.']);
        $validationRule = array_merge($validationRule, ['tuition_funding_source' => ['required']]);
        $errorMessages = array_merge($errorMessages, ['tuition_funding_source' . '.required' => 'Tuition funding source is required.']);
        $validationRule = array_merge($validationRule, ['test_taken' => ['required']]);
        $errorMessages = array_merge($errorMessages, ['test_taken' . '.required' => 'Tasks taken is required.']);
        $validationRule = array_merge($validationRule, ['addtional' => ['required']]);
        $errorMessages = array_merge($errorMessages, ['addtional' . '.required' => 'Addtional is required.']);
        $validationRule = array_merge($validationRule, ['add_anything' => ['required']]);
        $errorMessages = array_merge($errorMessages, ['add_anything' . '.required' => 'Add anything is required.']);
        $validationRule = array_merge($validationRule, ['study_permit_candian_embassy' => ['required']]);
        $errorMessages = array_merge($errorMessages, ['study_permit_candian_embassy' . '.required' => 'Study permit candian embassy is required.']);
        $validationRule = array_merge($validationRule, ['test_taken' => ['required']]);
        $errorMessages = array_merge($errorMessages, ['test_taken' . '.required' => 'Test taken is required.']);
        $validationRule = array_merge($validationRule, ['send_me_a_copy' => ['required']]);
        $errorMessages = array_merge($errorMessages, ['send_me_a_copy' . '.requfor_demetra_or_master_appired' => 'Send me a copy is required.']);
        $validationRule = array_merge($validationRule, ['' => ['required']]);
        $errorMessages = array_merge($errorMessages, ['for_demetra_or_master_app' . '.required' => 'Pick one of them.']);
        $this->validate($request, $validationRule, $errorMessages);

        $MasterApplication->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'confirm_email' => $request->confirm_email,
            'dob' => $request->dob,
            'gender' => $request->gender,
            'phone' => $request->phone,
            'can_school_text_you' => $request->can_school_text_you,
            'messaging_app' => $request->messaging_app,
            'messaging_app_username' => $request->messaging_app_username,
            'where_want_to_study' => $request->where_want_to_study,
            'country_of_citizenship' => $request->country_of_citizenship,
            'live_in_your_country_citizenship' => $request->live_in_your_country_citizenship,
            'current_residance' => $request->current_residance,
            'current_residance_status' => $request->current_residance_status,
            'mailing_address' => $request->mailing_address,
            'high_school_name' => $request->high_school_name,
            'high_school_cgpa' => $request->high_school_cgpa,
            'high_school_city' => $request->high_school_city,
            'high_school_country' => $request->high_school_country,
            'when_plan_to_start' => $request->when_plan_to_start,
            'interested_in' => $request->interested_in,
            'would_like_to_study' => $request->would_like_to_study,
            'student_type' => $request->student_type,
            'tuition_funding_source' => $request->tuition_funding_source,
            'test_taken' => $request->test_taken,
            'addtional' => $request->addtional,
            'add_anything' => $request->add_anything,
            'currently_living_in_canada' => $request->currently_living_in_canada,
            'currently_student_anywhere' => $request->currently_student_anywhere,
            'study_permit_candian_embassy' => $request->study_permit_candian_embassy,
            'test_taken' => $request->test_taken,
            'send_me_a_copy' => $request->send_me_a_copy,
            'for_demetra_or_master_app' => $request->for_demetra_or_master_app,
        ]);

        if ($MasterApplication) {
            return $this->apiSuccessResponse(new MasterApplicationResource($MasterApplication), 'Your changes have been done successfully');
        }
        return $this->errorResponse();
    }

    public function destroy(MasterApplication $MasterApplication)
    {
        if ($MasterApplication->delete()) {
            return $this->apiSuccessResponse(new MasterApplicationResource($MasterApplication), 'The selected item has been deleted successfully');
        }
        return $this->errorResponse();
    }

    protected function loadRelations($openDays)
    {
        return $openDays;
    }

    protected function sortingAndLimit($openDays)
    {
        $sortType = ['ASC', 'asc', 'DESC', 'desc'];
        $sortBy = ['id', 'first_name', 'last_name', 'date', 'time'];
        if (isset($_GET['sortBy']) && $_GET['sortBy'] != '' && isset($_GET['sortType']) && $_GET['sortType'] != '' && in_array($_GET['sortBy'], $sortBy) && in_array($_GET['sortType'], $sortType)) {
            $openDays = $openDays->OrderBy($_GET['sortBy'], $_GET['sortType']);
        }

        if (isset($_GET['limit']) && $_GET['limit'] != '') {
            $limit = $_GET['limit'];
        } else {
            $limit = 10;
        }

        return $openDays->paginate($limit);
    }

    protected function whereClause($openDays)
    {
        if (isset($_GET['searchParam']) && $_GET['searchParam'] != '') {
            $openDays = $openDays->where('first_name', 'LIKE', '%' . $_GET['searchParam'] . '%');
        }
        return $openDays;
    }
}
