<?php

namespace App\Http\Controllers\Api\Web;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\CustomerBusinessCategory;
use App\Models\CustomerMedia;
use App\Models\CustomerProfile;
use App\Models\CustomerSocialMedia;
use App\Rules\ValidUrl;
use App\Traits\StatusResponser;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class BussinessProfileController extends Controller
{
    use StatusResponser;
    use FileUploadTrait;


    public function show()
    {
        $data = CustomerProfile::whereCustomerId(Auth::guard('customers')->user()->id)->first();
        if($data){
            return $this->successResponse($data, 'Bussiness Profile has been Update successfully!');
        }
        return $this->errorResponse('Something Went Wrong!');
        
    }
    public function store(Request $request)
    {
        $request['business_categories_id'] = json_decode($request->business_categories_id);
        $validationRule = [
            'customer_profile_address' => ['required', 'string'],
            'customer_profile_company_email' => ['required', 'email'],
            'customer_profile_company_name' => ['required', 'string'],
            'customer_profile_description' => ['required', 'string'],
            'customer_profile_keywords' => ['required', 'string'],
            'customer_profile_phone' => ['required', 'string'],
            'customer_profile_short_description' => ['required', 'string'],
            'customer_profile_website' => ['required', new ValidUrl()],
        ];

        $defaulLang = getDefaultLanguage(1);
        if($defaulLang){
            App::setLocale($defaulLang->abbreviation);
            $regPageSetting = getRegPageSetting();
            $regPageSettingDetail = $regPageSetting->regPageSettingDetail;
            $niceNames = [
                'customer_profile_company_email' => isset($regPageSettingDetail[0]->step_4_email_label) ? $regPageSettingDetail[0]->step_4_email_label : '',
                'customer_profile_company_name' => isset($regPageSettingDetail[0]->step_4_name_label) ? $regPageSettingDetail[0]->step_4_name_label : '',
                'customer_profile_description' => isset($regPageSettingDetail[0]->step_4_description_label) ? $regPageSettingDetail[0]->step_4_description_label : '',
                'customer_profile_keywords' => isset($regPageSettingDetail[0]->step_4_keywords_label) ? $regPageSettingDetail[0]->step_4_keywords_label : '',
                'customer_profile_phone' => isset($regPageSettingDetail[0]->step_4_phone_label) ? $regPageSettingDetail[0]->step_4_phone_label : '',
                'customer_profile_short_description' => isset($regPageSettingDetail[0]->step_4_short_description_label) ? $regPageSettingDetail[0]->step_4_short_description_label : '',
                'customer_profile_website' => isset($regPageSettingDetail[0]->step_4_website_label) ? $regPageSettingDetail[0]->step_4_website_label : '',
                'customer_profile_address' => isset($regPageSettingDetail[0]->step_4_address_label) ? $regPageSettingDetail[0]->step_4_address_label : '',
            ]; 
        }
        $this->validate(
            $request,
            $validationRule,
            [],
            $niceNames
        );
        
        CustomerProfile::whereCustomerId(Auth::guard('customers')->user()->id)->update([
            'company_name' => $request->customer_profile_company_name,
            'company_email' => $request->customer_profile_company_email,
            'short_description' => $request->customer_profile_short_description,
            'description' => $request->customer_profile_description,
            'phone' => $request->customer_profile_phone,
            'website' => $request->customer_profile_website,
            'keywords' => json_decode($request->customer_profile_keywords, 1),
            'address' => $request->customer_profile_address,
        ]);


        $data = [];
        return $this->successResponse($data, 'Bussiness Profile has been Update successfully!');
    }

}
