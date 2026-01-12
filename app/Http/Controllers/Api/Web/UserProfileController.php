<?php

namespace App\Http\Controllers\Api\Web;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\CustomerBusinessCategory;
use App\Models\CustomerMedia;
use App\Models\CustomerProfile;
use App\Models\CustomerSocialMedia;
use App\Traits\StatusResponser;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserProfileController extends Controller
{
    use StatusResponser;
    use FileUploadTrait;


    public function show()
    {
        $data = Customer::select('name','email')->whereId(Auth::guard('customers')->user()->id)->first();
        if($data){
            return $this->successResponse($data, 'Account Setting has been Update successfully!');
        }
        return $this->errorResponse('Something Went Wrong!');
        
    }
    public function store(Request $request)
    {
        $request['business_categories_id'] = json_decode($request->business_categories_id);
        $validationRule = [
            'name' => ['required', 'string'],
            'email' => ['required', 'email', 'unique:App\Models\Customer,email,'.Auth::guard('customers')->user()->id],
        ];

        $defaulLang = getDefaultLanguage(1);
        if($defaulLang){
            App::setLocale($defaulLang->abbreviation);
            $regPageSetting = getRegPageSetting();
            $regPageSettingDetail = $regPageSetting->regPageSettingDetail;
            $niceNames = [
                'name' => isset($regPageSettingDetail[0]->step_2_name_label) ? $regPageSettingDetail[0]->step_2_name_label : '',
                'email' => isset($regPageSettingDetail[0]->step_2_email_label) ? $regPageSettingDetail[0]->step_2_email_label : '',
            ]; 
        }
        $this->validate(
            $request,
            $validationRule,
            [],
            $niceNames
        );
        
        Customer::whereId(Auth::guard('customers')->user()->id)->update([
            "name" => $request->name,
            "email" => $request->email,
        ]);


        $data = [];
        return $this->successResponse($data, 'Account Setting has been Update successfully!');
    }

}
