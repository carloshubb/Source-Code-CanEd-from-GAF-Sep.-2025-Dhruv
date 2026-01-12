<?php

namespace App\Http\Controllers\Api\Web;

use App\Http\Controllers\Controller;
use App\Jobs\RegistrationEmailJob;
use App\Models\CustomerLanguage;
use App\Models\Language;
use App\Models\School;
use App\Models\SchoolDetail;
use App\Models\SchoolRequestSetting;
use App\Rules\ValidUrl;
use App\Traits\StatusResponser;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SchoolProfileController extends Controller
{
    use StatusResponser;
    use FileUploadTrait;


    public function show()
    {
        $data = School::whereCustomerId(Auth::guard('customers')->user()->id)->first();
        if ($data) {
            return $this->successResponse($data, 'School Profile has been Update successfully!');
        }
        return $this->errorResponse('Something Went Wrong!');
    }
    public function store(Request $request)
    {

        $languageCount = Language::whereIsDefault('1')->count();
        $validationRule = [
            'image' => ['required'],
            'customer_id' => ['required'],
            'country' => ['required'],
            'province' => ['required'],
            'time' => ['required'],
            'time_zone' => ['required'],
            'email' => ['required', 'email'],
            'phone' => ['required'],
            'website_url' => ['required', new ValidUrl()],
            'city' => ['required'],
            'degree_id' => ['required'],       
            "school_name.". ($languageCount-1) => 'required',
            "school_name"    => "required|array|min:" . $languageCount,
            "description.". ($languageCount-1) => 'required',
            "description"    => "required|array|min:" . $languageCount,
        ];

        $niceNames = [];
        $defaultLang = getDefaultLanguage(1);
        if ($defaultLang) {
            App::setLocale($defaultLang->abbreviation);
            // $defaultLang = getDefaultLanguage(1);
            $schoolRequestSetting = SchoolRequestSetting::with([
                'schoolRequestSettingDetail' => function ($q) use ($defaultLang) {
                    $q = $q->where('language_id', $defaultLang->id);
                },
            ])->first();
            $niceNames = [
                'country' => isset($schoolRequestSetting->schoolRequestSettingDetail[0]->country_error) ? $schoolRequestSetting->schoolRequestSettingDetail[0]->country_error : '',
                'province' => isset($schoolRequestSetting->schoolRequestSettingDetail[0]->province_error) ? $schoolRequestSetting->schoolRequestSettingDetail[0]->province_error : '',
                'time' => isset($schoolRequestSetting->schoolRequestSettingDetail[0]->time_error) ? $schoolRequestSetting->schoolRequestSettingDetail[0]->time_error : '',
                'time_zone' => isset($schoolRequestSetting->schoolRequestSettingDetail[0]->time_zone_error) ? $schoolRequestSetting->schoolRequestSettingDetail[0]->time_zone_error : '',
                'email' => isset($schoolRequestSetting->schoolRequestSettingDetail[0]->email_error) ? $schoolRequestSetting->schoolRequestSettingDetail[0]->email_error : '',
                'phone' => isset($schoolRequestSetting->schoolRequestSettingDetail[0]->phone_error) ? $schoolRequestSetting->schoolRequestSettingDetail[0]->phone_error : '',
                'website_url' => isset($schoolRequestSetting->schoolRequestSettingDetail[0]->website_error) ? $schoolRequestSetting->schoolRequestSettingDetail[0]->website_error : '',
                'city' => isset($schoolRequestSetting->schoolRequestSettingDetail[0]->city_error) ? $schoolRequestSetting->schoolRequestSettingDetail[0]->city_error : '',
                'school_name' => isset($schoolRequestSetting->schoolRequestSettingDetail[0]->name_error) ? $schoolRequestSetting->schoolRequestSettingDetail[0]->name_error : '',
                'description' => isset($schoolRequestSetting->schoolRequestSettingDetail[0]->description_error) ? $schoolRequestSetting->schoolRequestSettingDetail[0]->description_error : '',
             ];
        }
        $this->validate(
            $request,
            $validationRule,
            [],
            $niceNames
        );

        $school = School::create([
            'customer_id' => $request->customer_id,
            'website_url' => $request->website_url,
            'email' => $request->email,
            'phone' => $request->phone,
            'time' => $request->time,
            'time_zone' => $request->time_zone,
            'province' => $request->province,
            'country' => $request->country,
            'image' => $request->image,
            'city' => $request->city,
            'degree_id' => $request->degree_id,
        ]);
        if ($school) {
            foreach ($request->language_id as $key => $lang) {
                if (isset($request->school_name[$key]) && isset($request->description[$key])) {
                    SchoolDetail::create([
                        'school_id' => $school->id,
                        'language_code' => $lang,
                        'school_name' => $request->school_name[$key],
                        'description' => $request->description[$key],
                    ]);
                }
            }
        }
        $emailData = ['id' => $school->id,'email' => $school->email, 'type' => 'register_school'];
        dispatch(new RegistrationEmailJob($emailData));
        return $this->successResponse($school, 'School has been Created successfully!');
    }

    public function update(Request $request,School $school)
    {

        $languageCount = Language::whereIsDefault('1')->count();
        $validationRule = [
            'image' => ['required'],
            'customer_id' => ['required'],
            'country' => ['required'],
            'province' => ['required'],
            'time' => ['required'],
            'time_zone' => ['required'],
            'email' => ['required', 'email'],
            'phone' => ['required'],
            'website_url' => ['required', new ValidUrl()],
            "school_name.". ($languageCount-1) => 'required',
            "school_name"    => "required|array|min:" . $languageCount,
            "description.". ($languageCount-1) => 'required',
            "description"    => "required|array|min:" . $languageCount,
        ];

        // $defaulLang = getDefaultLanguage(1);
        // if($defaulLang){
        //     App::setLocale($defaulLang->abbreviation);
        //     $regPageSetting = getRegPageSetting();
        //     $regPageSettingDetail = $regPageSetting->regPageSettingDetail;
        //     $niceNames = [
        //         'customer_profile_company_email' => isset($regPageSettingDetail[0]->step_4_email_label) ? $regPageSettingDetail[0]->step_4_email_label : '',
        //         'customer_profile_company_name' => isset($regPageSettingDetail[0]->step_4_name_label) ? $regPageSettingDetail[0]->step_4_name_label : '',
        //         'customer_profile_description' => isset($regPageSettingDetail[0]->step_4_description_label) ? $regPageSettingDetail[0]->step_4_description_label : '',
        //         'customer_profile_keywords' => isset($regPageSettingDetail[0]->step_4_keywords_label) ? $regPageSettingDetail[0]->step_4_keywords_label : '',
        //         'customer_profile_phone' => isset($regPageSettingDetail[0]->step_4_phone_label) ? $regPageSettingDetail[0]->step_4_phone_label : '',
        //         'customer_profile_short_description' => isset($regPageSettingDetail[0]->step_4_short_description_label) ? $regPageSettingDetail[0]->step_4_short_description_label : '',
        //         'customer_profile_website' => isset($regPageSettingDetail[0]->step_4_website_label) ? $regPageSettingDetail[0]->step_4_website_label : '',
        //         'customer_profile_address' => isset($regPageSettingDetail[0]->step_4_address_label) ? $regPageSettingDetail[0]->step_4_address_label : '',
        //     ]; 
        // }
        $this->validate(
            $request,
            $validationRule,
            []
        );

         $school->update([
            'customer_id' => $request->customer_id,
            'website_url' => $request->website_url,
            'email' => $request->email,
            'phone' => $request->phone,
            'time' => $request->time,
            'time_zone' => $request->time_zone,
            'province' => $request->province,
            'country' => $request->country,
            'image' => $request->image,
            'city' => $request->city,
            'degree_id' => $request->degree_id,
        ]);
        if ($school) {
            foreach ($request->language_id as $key => $lang) {
                if (isset($request->school_name[$key]) && isset($request->description[$key])) {
                    SchoolDetail::create([
                        'school_id' => $school->id,
                        'language_code' => $lang,
                        'school_name' => $request->school_name[$key],
                        'description' => $request->description[$key],
                    ]);
                }
            }
        }
        return $this->successResponse($school, 'School has been Created successfully!');
    }
    public function customerLanguage(Request $request)
    {
        CustomerLanguage::whereCustomerId($request->customer_id)->delete();
        $customerLang = null;
        foreach ($request->selectedLangs as $lang) {
            $customerLang = CustomerLanguage::create([
                'language_code' => $lang,
                'customer_id' => $request->customer_id
            ]);
        }
        return $this->successResponse($customerLang, 'Customer languages updated successfully!');
    }


    public function customerLanguages(Request $request)
    {
        $customer_id = isset($request->customer_id) && !empty($request->customer_id) ? $request->customer_id : Auth::guard('customers')->user()->id;
        $customerLangs = CustomerLanguage::whereCustomerId($customer_id)->orderBy('id','desc')->get();
        return $this->successResponse($customerLangs, 'data fetched successfully!');
    }
}
