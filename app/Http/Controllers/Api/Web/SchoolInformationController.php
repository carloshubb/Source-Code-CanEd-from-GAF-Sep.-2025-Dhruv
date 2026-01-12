<?php

namespace App\Http\Controllers\Api\Web;

use App\Http\Controllers\Controller;
use App\Http\Resources\Web\SchoolResource;
use App\Models\Customer;
use App\Models\School;
use App\Models\SchoolDetail;
use App\Models\SchoolMoreImage;
use App\Rules\FacebookUrl;
use App\Rules\InstagramUrl;
use App\Rules\LinkedInUrl;
use App\Rules\TwitterUrl;
use App\Rules\ValidUrl;
use App\Rules\VkUrl;
use App\Rules\YoutubeUrl;
use App\Traits\StatusResponser;
use Illuminate\Http\Request;

class SchoolInformationController extends Controller
{
    use StatusResponser;

    public function index()
    {
        $customer = auth()->guard('customers')->user();
        $school = School::where('customer_id', $customer->id)->with('schoolDetail')->first();
        return $this->successResponse(new SchoolResource($school), 'Data get successfully.');
    }

    public function update(Request $request)
    {
        // dd($request->all());
        $validationRule = [];
        $errorMessages = [];
        $languages = getAllLanguages();
        foreach ($languages as $language) {
            if ($language->is_default == 1) {
                $validationRule = array_merge($validationRule, ['school_name.school_name_' . $language->abbreviation => ['required', 'string']]);
                $errorMessages = array_merge($errorMessages, ['school_name.school_name_' . $language->abbreviation . '.required' => 'This field is required.']);//A
                $validationRule = array_merge($validationRule, ['description.description_' . $language->abbreviation => ['nullable', 'string']]);
                $errorMessages = array_merge($errorMessages, ['description.description_' . $language->abbreviation . '.required' => 'This field is required.']);
                $validationRule = array_merge($validationRule, ['more_button_title.more_button_title_' . $language->abbreviation => ['nullable', 'string']]);
                $errorMessages = array_merge($errorMessages, ['more_button_title.more_button_title_' . $language->abbreviation . '.required' => 'This field is required.']);
                $validationRule = array_merge($validationRule, ['more_button_sub_title.more_button_sub_title_' . $language->abbreviation => ['nullable', 'string']]);
                $errorMessages = array_merge($errorMessages, ['more_button_sub_title.more_button_sub_title_' . $language->abbreviation . '.required' => 'This field is required.']);
                $validationRule = array_merge($validationRule, ['other_button_title.other_button_title_' . $language->abbreviation => ['nullable', 'string']]);
                $errorMessages = array_merge($errorMessages, ['other_button_title.other_button_title_' . $language->abbreviation . '.required' => 'This field is required.']);
            }
        }
        $validationRule = array_merge($validationRule, ['website_url' => ['nullable', 'string', new ValidUrl()]]);
        $errorMessages = array_merge($errorMessages, ['website_url.required' => 'This field is required.']);
        $validationRule = array_merge($validationRule, ['email' => ['required', 'string', 'email']]);//A
        $errorMessages = array_merge($errorMessages, ['email.required' => 'This field is required.']);
        $validationRule = array_merge($validationRule, ['phone' => ['nullable', 'string']]);
        $errorMessages = array_merge($errorMessages, [
            'phone.required' => 'This field is required.',
        ]);
        $validationRule = array_merge($validationRule, ['time' => ['nullable', 'string']]);
        $errorMessages = array_merge($errorMessages, ['time.required' => 'This field is required.']);
        $validationRule = array_merge($validationRule, ['time_zone' => ['nullable', 'string']]);
        $errorMessages = array_merge($errorMessages, ['time_zone.required' => 'This field is required.']);
        $validationRule = array_merge($validationRule, ['province' => ['nullable', 'string']]);
        $errorMessages = array_merge($errorMessages, ['province.required' => 'This field is required.']);
        $validationRule = array_merge($validationRule, ['youtube_link' => ['nullable', new YoutubeUrl()]]);
        $validationRule = array_merge($validationRule, ['time_zone' => ['nullable', 'string']]);
        $errorMessages = array_merge($errorMessages, ['time_zone.required' => 'This field is required.']);
        $validationRule = array_merge($validationRule, ['province' => ['nullable', 'string']]);
        $errorMessages = array_merge($errorMessages, ['province.required' => 'This field is required.']);
        $validationRule = array_merge($validationRule, ['image' => ['required', 'string']]); //A 
        $validationRule = array_merge($validationRule, ['program_status' => ['nullable']]);
        $errorMessages = array_merge($errorMessages, ['program_status.required' => 'This field is required.']);
        $validationRule = array_merge($validationRule, ['financial_status' => ['nullable']]);
        $errorMessages = array_merge($errorMessages, ['financial_status.required' => 'This field is required.']);
        $validationRule = array_merge($validationRule, ['scholarship_status' => ['nullable']]);
        $errorMessages = array_merge($errorMessages, ['scholarship_status.required' => 'This field is required.']);
        $validationRule = array_merge($validationRule, ['contacts_status' => ['nullable']]);
        $errorMessages = array_merge($errorMessages, ['contacts_status.required' => 'This field is required.']);
        $validationRule = array_merge($validationRule, ['ambassador_status' => ['nullable']]);
        $errorMessages = array_merge($errorMessages, ['ambassador_status.required' => 'This field is required.']);
        $validationRule = array_merge($validationRule, ['quick_facts_status' => ['nullable']]);
        $errorMessages = array_merge($errorMessages, ['quick_facts_status.required' => 'This field is required.']);
        $validationRule = array_merge($validationRule, ['other_button_link' => ['nullable']]);
        $errorMessages = array_merge($errorMessages, ['other_button_link.required' => 'This field is required.']);
        $validationRule = array_merge($validationRule, ['main_button_link' => ['nullable']]);
        $errorMessages = array_merge($errorMessages, ['main_button_link.required' => 'This field is required.']);
        // $validationRule = array_merge($validationRule, ['degree_id' => ['required']]);
        // $errorMessages = array_merge($errorMessages, ['degree_id.required' => 'Degree is required']);
        // $validationRule = array_merge($validationRule, ['facebook' => ['nullable', new FacebookUrl()]]);
        // $validationRule = array_merge($validationRule, ['linkedin' => ['nullable', new LinkedInUrl()]]);
        // $validationRule = array_merge($validationRule, ['insta' => ['nullable', new InstagramUrl()]]);
        // $validationRule = array_merge($validationRule, ['twitter' => ['nullable', new TwitterUrl()]]);
        // $validationRule = array_merge($validationRule, ['youtube' => ['nullable', new YoutubeUrl()]]);
        // $validationRule = array_merge($validationRule, ['vk' => ['nullable', new VkUrl()]]);


        $this->validate(
            $request,
            $validationRule,
            $errorMessages
        );

        $school = School::whereId($request->id)->firstOrFail();
        $school->update([
            'customer_id' => $request->customer_id,
            'website_url' => $request->website_url,
            'email' => $request->email,
            'phone' => $request->phone,
            'time' => $request->time,
            'time_zone' => $request->time_zone,
            'province' => $request->province,
            'youtube_link' => $request->youtube_link,
            'youtube_iframe' => getVideoHtmlAttribute($request->youtube_link),
            'country' => $request->country,
            'image' => $request->image,
            'facebook' => $request->facebook,
            'linkedin' => $request->linkedin,
            'insta' => $request->insta,
            'twitter' => $request->twitter,
            'youtube' => $request->youtube,
            'vk' => $request->vk,
            'main_button_link' => $request->main_button_link,
            'other_button_link' => $request->other_button_link,
            'quick_facts_status' => $request->quick_facts_status,
            'overview_status' => $request->overview_status,
            'program_status' => $request->program_status,
            'admission_status' => $request->admission_status,
            'financial_status' => $request->financial_status,
            'scholarship_status' => $request->scholarship_status,
            'contacts_status' => $request->contacts_status,
            'ambassador_status' => $request->ambassador_status,
            // 'degree_id' => $request->degree_id,
        ]);
        $school->touch();

        if (isset($request->more_images)) {
            $customer = Customer::where('id', $request->customer_id)->first();
            if ($customer->user_type == 'school') {
                $count = count($request->more_images);
                if ($customer->registrationPackage->images < $count) {
                    return $this->errorResponse('You can upload upto ' . $customer->registrationPackage->images . ' images');
                }
            }
            SchoolMoreImage::whereSchoolId($school->id)->delete();
            foreach ($request->more_images as $image) {
                SchoolMoreImage::create([
                    'school_id' => $school->id,
                    'image' => $image
                ]);
            }
        }
        foreach ($languages as $language) {
            if (
                !empty($request['school_name']['school_name_' . $language->abbreviation])
            ) {

                $schoolDetail = SchoolDetail::whereLanguageCode($language->abbreviation)->whereSchoolId($school->id)->exists();
                $fields = [
                    'school_name' => $request['school_name']['school_name_' . $language->abbreviation],
                    'more_button_sub_title' => $request['more_button_sub_title']['more_button_sub_title_' . $language->abbreviation],
                    'other_button_title' => $request['other_button_title']['other_button_title_' . $language->abbreviation],
                    'description' => $request['description']['description_' . $language->abbreviation],
                    'more_button_title' => $request['more_button_title']['more_button_title_' . $language->abbreviation],
                ];
                if ($schoolDetail) {
                    SchoolDetail::whereLanguageCode($language->abbreviation)->whereSchoolId($school->id)->update($fields);
                } else {
                    $fields = array_merge($fields, ['school_id' => $school->id]);
                    $fields = array_merge($fields, ['language_code' => $language->abbreviation]);
                    SchoolDetail::create($fields);
                }
            }
        }

        if ($school) {
            return $this->apiSuccessResponse(new SchoolResource($school), 'Your changes have been done successfully');
        }
        return $this->errorResponse();
    }
}
