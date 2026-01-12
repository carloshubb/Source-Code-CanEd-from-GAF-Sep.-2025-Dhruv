<?php

namespace App\Http\Controllers\Api\Web;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\RegPageSettingResource;
use App\Jobs\BusinessInvitaionEmailJob;
use App\Jobs\BusinessInvitaionEmailJobCopy;
use App\Jobs\OpenhouseOrgnizerEmailJob;
use App\Jobs\OpenhouseOrgnizerEmailJobCopy;
use App\Jobs\SchoolContactEmailJob;
use App\Jobs\SchoolContactEmailJobCopy;
use App\Mail\BusinessInvitaionEmail;
use App\Models\Business;
use App\Models\BusinessCategory;
use App\Models\BusinessCategoryDetail;
use App\Models\Contact;
use App\Models\ContactPageSetting;
use App\Models\Favourite;
use App\Models\RegistrationPackage;
use App\Models\RegPageSetting;
use App\Models\School;
use App\Services\FomSubmissionCountService;
use App\Traits\StatusResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class HelperController extends Controller
{
    use StatusResponser;

    public function setSchoolLang($lang, $school_lang)
    {
        Session::put('school_lang', $school_lang);
        return redirect()->back();
    }
    public function getRegistrationPackages()
    {
        $defaultLang = getDefaultLanguage(1);
        $registrationPackages = RegistrationPackage::select('id', 'is_default')
            ->with([
                'registrationPackageDetail' => function ($q) use ($defaultLang) {
                    $q->select('id', 'registration_package_id', 'name')->where('language_id', $defaultLang->id);
                },
            ])
            ->get();
        return $this->successResponse($registrationPackages, 'Data Get Successfully!');
    }

    public function getBusinessCategories()
    {
        $defaultLang = getDefaultLanguage(1);
        $registrationPackages = BusinessCategory::select('id')
            ->addSelect([
                'category_name' => BusinessCategoryDetail::whereColumn('business_category_id', 'business_categories.id')
                    ->where('business_category_detail.language_id', $defaultLang->id)
                    ->select('name'),
            ])
            ->orderBy('category_name', 'asc')
            ->get();
        return $this->successResponse($registrationPackages, 'Data Get Successfully!');
    }

    public function checkCustomerEmail(Request $request)
    {
        $validationRule = [
            'email' => ['required', 'email', 'unique:App\Models\Customer,email'],
        ];

        $this->validate($request, $validationRule);

        return $this->successResponse([], 'Email is valid!');
    }

    public function setLanguage($language)
    {
        if (isset($_GET['url']) && $_GET['url'] != '') {
            $url = langBasedURL(null, $_GET['url'], $language);
            if (isset($_GET['url_params']) && $_GET['url_params'] != '') {
                $url = $url . '?reload=1';
                foreach ($_GET as $key => $param) {
                    if ($key != 'url' && $key == 'url_params') {
                        $url = $url . '&' . $param;
                    } elseif ($key != 'url') {
                        $url = $url . '&' . $key . '=' . $param;
                    }
                }
            }
            Session::put('webLanguage', $language);
            return Redirect::to($url);
        }
        Session::put('webLanguage', $language);
        return redirect()->back();
    }

    public function getRegPageSetting()
    {
        $defaultLang = getDefaultLanguage(true);
        $regPageSetting = RegPageSetting::with([
            'regPageSettingDetail' => function ($q) use ($defaultLang) {
                $q->where('language_id', $defaultLang->id);
            },
        ])->first();
        return $this->successResponse(new RegPageSettingResource($regPageSetting), 'Data Get Successfully!');
    }
    public function contactOpenHouseOrgnizer(Request $request)
    {
        $validationRule = [
            'name' => ['required', 'string'],
            'email' => ['required', 'email'],
            'message' => ['required'],
        ];
        $this->validate($request, $validationRule, []);
        $formSubmissionService = new FomSubmissionCountService();
        $result = $formSubmissionService->advertiserForm();
        if ($result['status'] == 'Error') {
            return $result;
        }
        // $defaultLang = getDefaultLanguage(1);
        if (isset($request->open_house)) {
            $contact = Contact::create([
                'name' => $request->name,
                'email' => $request->email,
                'message' => $request->message,
                'type' => 'open_house_contact_orgnizer',
            ]);
            $emailData = [
                'email' => $request->open_house['school_email'],
                'open_house' => isset($request->open_house['open_day_detail'][0]['title']) ? $request->open_house['open_day_detail'][0]['title'] : '',
                'visitor_name' => $request->name,
                'visitor_email' => $request->email,
                'visitor_message' => $request->message,
                'send_me_a_copy' => $request->send_me_a_copy,
            ];
            dispatch(new OpenhouseOrgnizerEmailJob($emailData));
            if ($request->send_me_a_copy) {
                dispatch(new OpenhouseOrgnizerEmailJobCopy($emailData));
            }
        }
        return $this->successResponse('', 'Thanks ! your request has been received successfully!');
    }
    public function contactBussiness(Request $request)
    {
        $validationRule = [
            'name' => ['required', 'string'],
            'email' => ['required', 'email'],
            'message' => ['required', 'maxwords:300'],
        ];
        $this->validate($request, $validationRule, []);
        $formSubmissionService = new FomSubmissionCountService();
        $result = $formSubmissionService->advertiserForm();
        if ($result['status'] == 'Error') {
            return $result;
        }
        $defaultLang = getDefaultLanguage(1);
        $business = Business::with('customer')
            ->with([
                'businessDetail' => function ($q) use ($defaultLang) {
                    $q->where('language_id', $defaultLang->id);
                },
            ])
            ->where('id', $request->business_id)
            ->first();
        if (isset($business->email)) {
            Contact::create([
                'name' => $request->name,
                'email' => $request->email,
                'message' => $request->message,
                'type' => 'contact_business',
            ]);
            $emailData = [
                'email' => $business->email,
                'business_owner_name' => isset($business->customer->first_name) && isset($business->customer->last_name) ? $business->customer->first_name . ' ' . $business->customer->last_name : '',
                'business_name' => isset($business->contact_name) ? $business->contact_name : '',
                'visitor_name' => $request->name,
                'visitor_email' => $request->email,
                'main_business_name' => optional($business->businessDetail->first())->business_name ?? '',
                'visitor_message' => $request->message,
                'send_me_a_copy' => $request->send_me_a_copy,
            ];
            // dd($emailData);
            // dispatch_sync(new BusinessInvitaionEmailJob($emailData));
            dispatch(new BusinessInvitaionEmailJob($emailData));
            if ($request->send_me_a_copy) {
                dispatch(new BusinessInvitaionEmailJobCopy($emailData));
            }
        }
        return $this->successResponse('', 'Thanks ! your request has been received successfully!');
    }

    // public function contactSchool(Request $request)
    // {
    //     $validationRule = [
    //         'name' => ['required', 'string'],
    //         'email' => ['required', 'email'],
    //         'message' => ['required', 'maxwords:300'],
    //     ];
    //     $this->validate($request, $validationRule, []);
    //     $this->validate($request, $validationRule, []);
    //     $formSubmissionService = new FomSubmissionCountService();
    //     $result = $formSubmissionService->advertiserForm();
    //     if ($result['status'] == 'Error') {
    //         return $result;
    //     }
    //     $defaultLang = getDefaultLanguage(1);
    //     $school = School::with('customer')
    //         ->with([
    //             'schoolDetail' => function ($q) use ($defaultLang) {
    //                 $q->where('language_code', $defaultLang->abbreviation);
    //             },
    //         ])
    //         ->where('id', $request->school_id)
    //         ->first();
    //     if (isset($school->email)) {
    //         Contact::create([
    //             'name' => $request->name,
    //             'email' => $request->email,
    //             'message' => $request->message,
    //             'type' => 'contact_school',
    //         ]);
    //         $emailData = [
    //             'email' => $school->email,
    //             'school_owner_name' => isset($school->customer->first_name) && isset($school->customer->last_name) ? $school->customer->first_name . ' ' . $school->customer->last_name : '',
    //             'school_name' => isset($school->schoolDetail[0]->school_name) ? $school->schoolDetail[0]->school_name : '',
    //             'visitor_name' => $request->name,
    //             'visitor_email' => $request->email,
    //             'visitor_message' => $request->message,
    //             'send_me_a_copy' => $request->send_me_a_copy,
    //         ];
    //         dispatch(new SchoolContactEmailJob($emailData));
    //         if ($request->send_me_a_copy) {
    //             dispatch(new SchoolContactEmailJobCopy($emailData));
    //         }
    //     }
    //     return $this->successResponse('', 'Thanks ! your request has been received successfully!');
    // }
    public function contactSchool(Request $request)
{
    // Fetch static translations
    $staticTranslations = getStaticTranslation('contact_school');

    // Define validation rules
    $validationRule = [
        'name' => ['required', 'string'],
        'email' => ['required', 'email'],
        'message' => [
            'required',
            'string',
            function ($attribute, $value, $fail) use ($staticTranslations) {
                $plainText = trim(strip_tags(html_entity_decode($value))); 
                if (str_word_count($plainText) > 300) {
                    $fail($staticTranslations['school_message_word_limit_error'] ?? 'Only 300 words are allowed for the message.');
                }
            }
        ],
    ];

    // Define custom error messages for each field
    $errorMessages = [
        // 'name.required' => $staticTranslations['school_name_error'] ?? 'Name is required.',
        // 'email.required' => $staticTranslations['school_email_error'] ?? 'Email is required.',
        // 'email.email' => 'Please enter a valid email address.',
        // 'message.required' => $staticTranslations['school_message_error'] ?? 'Message is required.',
    ];

    // Validate request using Laravel's built-in validate method
    $this->validate($request, $validationRule, $errorMessages);

    $formSubmissionService = new FomSubmissionCountService();
    $result = $formSubmissionService->advertiserForm();
    if ($result['status'] == 'Error') {
        return $result;
    }

    $defaultLang = getDefaultLanguage(1);
    $school = School::with('customer')
        ->with([
            'schoolDetail' => function ($q) use ($defaultLang) {
                $q->where('language_code', $defaultLang->abbreviation);
            },
        ])
        ->where('id', $request->school_id)
        ->first();

    if (isset($school->email)) {
        Contact::create([
            'name' => $request->name,
            'email' => $request->email,
            'message' => $request->message,
            'type' => 'contact_school',
        ]);

        $emailData = [
            'email' => $school->email,
            'school_owner_name' => isset($school->customer->first_name) && isset($school->customer->last_name)
                ? $school->customer->first_name . ' ' . $school->customer->last_name
                : '',
            'school_name' => $school->schoolDetail[0]->school_name ?? '',
            'visitor_name' => $request->name,
            'visitor_email' => $request->email,
            'visitor_message' => $request->message,
            'send_me_a_copy' => $request->send_me_a_copy,
        ];

        dispatch(new SchoolContactEmailJob($emailData));

        if ($request->send_me_a_copy) {
            dispatch(new SchoolContactEmailJobCopy($emailData));
        }
    }

    return $this->successResponse('', 'Thanks! Your request has been received successfully!');
}


    public function contactUS(Request $request)
    {
        $validationRule = [
            'name' => ['required', 'string'],
            'email' => ['required', 'email'],
            'message' => ['required'],
        ];
        $niceNames = [];
        $defaultLang = getDefaultLanguage(1);
        if ($defaultLang) {
            App::setLocale($defaultLang->abbreviation);
            // $defaultLang = getDefaultLanguage(1);
            $loginPageSetting = ContactPageSetting::with([
                'contactPageSettingDetail' => function ($q) use ($defaultLang) {
                    $q = $q->where('language_id', $defaultLang->id);
                },
            ])->first();
            $niceNames = [
                'name' => isset($loginPageSetting->loginPageSettingDetail[0]->name_input_error) ? $loginPageSetting->loginPageSettingDetail[0]->name_input_error : '',
                'email' => isset($loginPageSetting->loginPageSettingDetail[0]->email_input_error) ? $loginPageSetting->loginPageSettingDetail[0]->email_input_error : '',
                'message' => isset($loginPageSetting->loginPageSettingDetail[0]->message_input_error) ? $loginPageSetting->loginPageSettingDetail[0]->message_input_error : '',
            ];
        }
        $this->validate($request, $validationRule, []);
        $formSubmissionService = new FomSubmissionCountService();
        $result = $formSubmissionService->advertiserForm();
        if ($result['status'] == 'Error') {
            return $result;
        }
        $contact = Contact::create([
            'name' => $request->name,
            'email' => $request->email,
            'message' => $request->message,
            'type' => $request->type,
        ]);
        if ($contact) {
            return $this->successResponse('', 'Thanks, your request has been sent successfully');
        }
        return $this->errorResponse();
    }

    public function addToFav(Request $request)
    {
        if (!Auth::guard('customers')->check()) {
            return $this->errorResponse(getStaticTranslation('popup_error_messages')['error_faviourite_popup_message']);
        } else {
            $isExited = Favourite::where('record_id', $request->record_id)
                ->where('model', $request->model)
                ->where('customer_id', Auth::guard('customers')->user()->id)
                ->count();
            if ($isExited > 0) {
                Favourite::where('record_id', $request->record_id)
                    ->where('model', $request->model)
                    ->where('customer_id', Auth::guard('customers')->user()->id)
                    ->delete();
                return $this->successResponse('', getStaticTranslation('popup_error_messages')['discard_faviourite_popup_message']);
            }
            Favourite::create([
                'record_id' => $request->record_id,
                'model' => $request->model,
                'customer_id' => Auth::guard('customers')->user()->id,
            ]);
            return $this->successResponse('', getStaticTranslation('popup_error_messages')['add_faviourite_popup_message']);
        }
    }
}
