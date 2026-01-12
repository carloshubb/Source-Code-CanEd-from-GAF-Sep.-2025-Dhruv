<?php

namespace App\Services;

use App\Models\EmailSetting;
use App\Models\RegistrationPackage;
use App\Models\Setting;
use App\Traits\StatusResponser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Request;

class FomSubmissionCountService
{
    use StatusResponser;

    public function canadianExportersForm()
    {
        $ipAddress = Request::ip();
        $cacheKey = 'form_submission_limit_' . $ipAddress;
        $setting = Setting::where('key', 'general_form_submission_per_day')->value('value');
        $emailLimit = $setting; // Number of emails allowed per 24 hours

        if (Cache::has($cacheKey)) {
            $emailCount = Cache::get($cacheKey);
            if ($emailCount >= $emailLimit) {
                return $this->errorResponse('Form submission limit exceeded. Please try again later.');
            }
        } else {
            $emailCount = 0;
        }

        // Increment the email count and store it in the cache for 24 hours
        $emailCount++;
        Cache::put($cacheKey, $emailCount, now()->addDay());
        return $this->successResponse([], 'Form submitted will be sent.');
    }

    public function advertiserForm()
    {
        $ipAddress = Request::ip();
        $cacheKey = '';
        $email_setting = null;
        if (Auth::guard('customers')->check()) {
            $cacheKey = 'logged_in_user_' . Auth::guard('customers')->user()->id;
            $package_id = Auth::guard('customers')->user()->registration_package_id;
            $email_setting = RegistrationPackage::where('id', $package_id)->first();
            if ($email_setting) {
                $emailLimit = $email_setting->form_submission_count;
            }
        }
        if (!$email_setting) {
            $cacheKey = 'visiting_user_' . $ipAddress;
            $setting = Setting::where('key', 'general_form_submission_per_day')->value('value');
            $emailLimit = $setting;
        }

        if (Cache::has($cacheKey)) {
            $emailCount = Cache::get($cacheKey);
            if ($emailCount >= $emailLimit) {
                return $this->errorResponse('Form submission limit exceeded. Please try again later.');
            }
        } else {
            $emailCount = 0;
        }

        // Increment the email count and store it in the cache for 24 hours
        $emailCount++;
        Cache::put($cacheKey, $emailCount, now()->addDay());
        return $this->successResponse([], 'Email will be sent.');
    }
}
