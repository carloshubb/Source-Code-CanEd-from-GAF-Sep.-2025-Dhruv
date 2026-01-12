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

class SocialMediaController extends Controller
{
    use StatusResponser;
    use FileUploadTrait;


    public function show()
    {
        $data = CustomerSocialMedia::whereCustomerId(Auth::guard('customers')->user()->id)->first();
        if($data){
            return $this->successResponse($data, 'Social Media has been Update successfully!');
        }
        return $this->errorResponse('Something Went Wrong!');
        
    }
    public function store(Request $request)
    {
        $request['business_categories_id'] = json_decode($request->business_categories_id);
        $validationRule = [
            'customer_social_media_facebook' => ['nullable', new ValidUrl()],
            'customer_social_media_linked_in' => ['nullable', new ValidUrl()],
            'customer_social_media_twitter' => ['nullable', new ValidUrl()],
            'customer_social_media_youtube' => ['nullable', new ValidUrl()],
        ];

        $defaulLang = getDefaultLanguage(1);
        if($defaulLang){
            App::setLocale($defaulLang->abbreviation);
            $regPageSetting = getRegPageSetting();
            $regPageSettingDetail = $regPageSetting->regPageSettingDetail;
            $niceNames = [
                'customer_social_media_facebook' => isset($regPageSettingDetail[0]->step_6_facebook_label) ? $regPageSettingDetail[0]->step_6_facebook_label : '',
                'customer_social_media_linked_in' => isset($regPageSettingDetail[0]->step_6_linkedin_label) ? $regPageSettingDetail[0]->step_6_linkedin_label : '',
                'customer_social_media_twitter' => isset($regPageSettingDetail[0]->step_6_twitter_label) ? $regPageSettingDetail[0]->step_6_twitter_label : '',
                'customer_social_media_youtube' => isset($regPageSettingDetail[0]->step_6_youtube_label) ? $regPageSettingDetail[0]->step_6_youtube_label : '',
            ]; 
        }
        $this->validate(
            $request,
            $validationRule,
            [],
            $niceNames
        );
        
        CustomerSocialMedia::whereCustomerId(Auth::guard('customers')->user()->id)->update([
            "facebook" => $request->customer_social_media_facebook,
            "twitter" => $request->customer_social_media_twitter,
            "youtube" => $request->customer_social_media_youtube,
            "linked_in" => $request->customer_social_media_linked_in
        ]);


        $data = [];
        return $this->successResponse($data, 'Social Media has been Update successfully!');
    }

}
