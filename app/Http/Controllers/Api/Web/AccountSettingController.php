<?php

namespace App\Http\Controllers\Api\Web;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\CustomerProfile;
use App\Models\CustomerSocialMedia;
use App\Rules\ValidUrl;
use Illuminate\Http\Request;

class AccountSettingController extends Controller
{

    public function index()
    {
        $user = auth()->guard('customers')->user();
        return view('web.signup-account-setting.index',compact('user'));
    }

    public function updateAccountSetting(Request $request){
        $validationRule = [
            'name' => ['required', 'string'],
            'email' => ['required', 'email'],
        ];
        $errorMessages = ['customer_profile_address.required' => 'The address field is required.',
            'name.required' => 'The name field is required.',
            'email.email' => 'The email must be a valid email address.',
        ];
        $this->validate(
            $request,
            $validationRule,
            $errorMessages
        );
        $user = auth()->guard('customers')->user();
        $customer = Customer::where('id',$user->id)->update([
            'name'=> $request->name,
            'email'=>$request->email
        ]);
        return redirect()->back()->with('message', 'Account Setting Update!');
    }

    public function buissnessSettingView(){
        $user = auth()->guard('customers')->user();
        $customerProfile = CustomerProfile::where('customer_id',$user->id)->first();
        return view('web.signup-bussiness-setting.index',compact('user','customerProfile'));
    }

    public function updateBussiessSetting(Request $request){
        $validationRule = [
            'address' => ['required', 'string'],
            'company_email' => ['required', 'email'],
            'company_name' => ['required', 'string'],
            'description' => ['required', 'string'],
            'keywords' => ['required', 'string'],
            'phone' => ['required', 'string'],
            'short_description' => ['required', 'string'],
            'website' => ['required', new ValidUrl()],
        ];
        $errorMessages = ['customer_profile_address.required' => 'The address field is required.',
            'company_email.required' => 'The company email field is required.',
            'company_email.email' => 'The company email must be a valid email address.',
            'company_name.required' => 'The company name field is required.',
            'description.required' => 'The Description field is required.',
            'keywords.required' => 'The keyword field is required.',
            'phone.required' => 'The phone field is required.',
            'short_description.required' => 'The short description field is required.',
            'website.required' => 'The website field is required.',
            'website.url' => 'The website must be a valid URL.',
        ];
        $this->validate(
            $request,
            $validationRule,
            $errorMessages
        );
        $user = auth()->guard('customers')->user();
        $dataToUpdate = $request->only('company_name',
        'company_email',
        'short_description',
        'description',
        'phone',
        'website',
        'address');
        $dataToUpdate['keywords'] = json_decode($request->keywords,1);
        $customerProfile = CustomerProfile::where('customer_id',$user->id)->update($dataToUpdate);
        return redirect()->back()->with('message', 'Business Setting Update Successfully!');
    }

    public function socialMediaSettingView(){
        $user = auth()->guard('customers')->user();
        $customerSocialMedia = CustomerSocialMedia::where('customer_id',$user->id)->first();
        return view('web.signup-social-media-setting.index',compact('user','customerSocialMedia'));
    }

    public function updateSocialMediaSetting(Request $request){
        $user = auth()->guard('customers')->user();
        $dataToUpdate = $request->only('facebook',
        'google',
        'linked_in',
        'twitter',
        'youtube',
        'website',
        'address');
        if(CustomerSocialMedia::where('customer_id',$user->id)->count() > 0)
        $customerSocialMedia = CustomerSocialMedia::where('customer_id',$user->id)->update($dataToUpdate);
        else{
            $dataToUpdate['customer_id'] = $user->id;
            $customerSocialMedia = CustomerSocialMedia::create($dataToUpdate);
        }
        
        return redirect()->back()->with('message', 'Social Media Setting Update Successfully!');
    }
    
}
