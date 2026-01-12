<?php
namespace App\Http\Controllers\Api\Web;

use App\Http\Controllers\Controller;
use App\Http\Resources\Web\SchoolProgramSettingResource;
use App\Models\SchoolProgramSetting;
use App\Models\SchoolProgramSettingDetail;
use App\Traits\StatusResponser;
use Illuminate\Http\Request;

class SchoolProgramSettingController extends Controller
{
    use StatusResponser;

    public function index()
    {
        if (isset($_GET['is_admin'])) {
            $school = SchoolProgramSetting::where('school_id',$_GET['school_id'])->with('schoolProgramSettingDetail')->first();
            return $this->successResponse(new SchoolProgramSettingResource($school), 'Data get successfully.');
        } else {
            $customer = auth()->guard('customers')->user();
            $school =SchoolProgramSetting::where('customer_id',$customer->id)->with('schoolProgramSettingDetail')->first();
            return $this->successResponse(new SchoolProgramSettingResource($school), 'Data get successfully.');
        }
        
    }

    public function update(Request $request)
    {
        $validationRule = [];
        $errorMessages = [];
        $languages = getAllLanguages();
        foreach ($languages as $language) {
                if($language->is_default == 1) {
                    $validationRule = array_merge($validationRule, ['title_1.title_1_' . $language->abbreviation => ['required', 'string']]);
                    $errorMessages = array_merge($errorMessages, ['title_1.title_1_' . $language->abbreviation . '.required' => 'This field is required.']);
                    $validationRule = array_merge($validationRule, ['title_1_paragraph.title_1_paragraph_' . $language->abbreviation => ['required', 'string']]);
                    $errorMessages = array_merge($errorMessages, ['title_1_paragraph.title_1_paragraph_' . $language->abbreviation . '.required' => 'This field is required.']);
            }
        }
        $this->validate(
            $request,
            $validationRule,
            $errorMessages
        );
       $fields = [
        'customer_id' => $request->customer_id,
        'school_program_apply_button_title' => $request->school_program_apply_button_title,
        'school_program_apply_button_link' => $request->school_program_apply_button_link,
        'school_program_blue_bar_button_title' => $request->school_program_blue_bar_button_title,
        'school_program_blue_bar_button_link' => $request->school_program_blue_bar_button_link,
        'school_program_red_bar_button_title' => $request->school_program_red_bar_button_title,
        'school_program_red_bar_button_link' => $request->school_program_red_bar_button_link,
        'school_id' => $request->school_id,
       ];
        $school = SchoolProgramSetting::whereCustomerId($request->customer_id)->first();
        if($school){
            $school->update($fields);
        }else{
            $school = SchoolProgramSetting::create($fields);
        }
        
        $school->touch();
        foreach ($languages as $language) {
            if(
                !empty( $request['title_1']['title_1_' . $language->abbreviation])
                && !empty( $request['title_1_paragraph']['title_1_paragraph_' . $language->abbreviation]) 
            ){
                
                $schoolDetail = SchoolProgramSettingDetail::whereLanguageCode($language->abbreviation)->whereSchoolProgramSettingId($school->id)->exists();
                $fields = [
                    'title_1' => $request['title_1']['title_1_' . $language->abbreviation],
                    'title_1_paragraph' => $request['title_1_paragraph']['title_1_paragraph_' . $language->abbreviation],

                ];
                if ($schoolDetail) {
                   SchoolProgramSettingDetail::whereLanguageCode($language->abbreviation)->whereSchoolProgramSettingId($school->id)->update($fields);
                } else {
                    $fields = array_merge($fields, ['school_program_setting_id' => $school->id]);
                    $fields = array_merge($fields, ['language_code' => $language->abbreviation]);
                   SchoolProgramSettingDetail::create($fields);
                }
            }
        }

        if ($school) {
            return $this->apiSuccessResponse(new SchoolProgramSettingResource($school), 'Your changes have been done successfully');
        }
        return $this->errorResponse();
    }
}
