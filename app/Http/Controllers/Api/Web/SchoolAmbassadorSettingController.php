<?php

namespace App\Http\Controllers\Api\Web;

use App\Http\Controllers\Controller;
use App\Http\Resources\Web\SchoolAmbassadorSettingResource;
use App\Models\SchoolAmbassadorSetting;
use App\Models\SchoolAmbassadorSettingDetail;
use App\Traits\StatusResponser;
use Illuminate\Http\Request;

class SchoolAmbassadorSettingController extends Controller
{
    use StatusResponser;

    public function index()
    {
        if (isset($_GET['is_admin'])) {
            $school = SchoolAmbassadorSetting::where('school_id', $_GET['school_id'])->with('schoolAmbassadorSettingDetail')->first();
            // dd($school);
        } else {
            $customer = auth()->guard('customers')->user();
            $customerId = $customer->id ?? null;
            $school = SchoolAmbassadorSetting::where('customer_id', $customerId)->with('schoolAmbassadorSettingDetail')->first();
        }
        return $this->successResponse(new SchoolAmbassadorSettingResource($school), 'Data get successfully.');
    }

    public function update(Request $request)
    {
        $validationRule = [];
        $errorMessages = [];
        $languages = getAllLanguages();
        foreach ($languages as $language) {
            if ($language->is_default == 1) {
                $validationRule = array_merge($validationRule, ['top_paragraph.top_paragraph_' . $language->abbreviation => ['nullable', 'string']]);
                $errorMessages = array_merge($errorMessages, ['top_paragraph.top_paragraph_' . $language->abbreviation . '.required' => 'This field is required.']);
                
            }
        }
        $this->validate(
            $request,
            $validationRule,
            $errorMessages
        );
        $fields = [
            'customer_id' => $request->customer_id,
            'school_id' => $request->school_id,
            'heading_text' => $request->heading_text,
            'main_photo' => $request->main_photo,
        ];
        $school = SchoolAmbassadorSetting::whereCustomerId($request->customer_id)->first();
        if ($school) {
            $school->update($fields);
            // dd($school);
        } else {
            $school = SchoolAmbassadorSetting::create($fields);
        }

        $school->touch();
        foreach ($languages as $language) {
            if (
                !empty($request['top_paragraph']['top_paragraph_' . $language->abbreviation])
                // !empty($request['main_paragraph']['main_paragraph_' . $language->abbreviation])
                // && !empty($request['brief_description']['brief_description_' . $language->abbreviation])

            ) {

                $schoolDetail = SchoolAmbassadorSettingDetail::whereLanguageCode($language->abbreviation)->whereAmbassadorSettingId($school->id)->exists();
                // dd($schoolDetail);
                $fields = [
                    'top_paragraph' => $request['top_paragraph']['top_paragraph_' . $language->abbreviation],
                ];
                if ($schoolDetail) {
                    SchoolAmbassadorSettingDetail::whereLanguageCode($language->abbreviation)->whereAmbassadorSettingId($school->id)->update($fields);
                } else {
                    $fields = array_merge($fields, ['ambassador_setting_id' => $school->id]);
                    $fields = array_merge($fields, ['language_code' => $language->abbreviation]);
                    SchoolAmbassadorSettingDetail::create($fields);
                }
            }
        }

        if ($school) {
            return $this->apiSuccessResponse(new SchoolAmbassadorSettingResource($school), 'Your changes have been done successfully');
        }
        return $this->errorResponse();
    }
}
