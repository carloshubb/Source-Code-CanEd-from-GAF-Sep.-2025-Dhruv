<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\SchoolResource;
use App\Models\Customer;
use Illuminate\Support\Str;
use App\Models\School;
use App\Models\SchoolDetail;
use App\Models\Language;
use App\Models\SchoolScholarship;
use App\Models\SchoolScholarshipDetail;
use App\Models\SchoolType;
use App\Models\SchoolTypeDetail;
use App\Rules\CheckCategorySlug;
use App\Rules\ValidUrl;
use App\Rules\YoutubeUrl;
use App\Traits\StatusResponser;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

class SchoolController extends Controller
{
    use StatusResponser;
    use FileUploadTrait;

    public function __construct()
    {
        $this->middleware('password_confirm')->only('destroy');
    }

    public function index()
    {
        $schools = School::query();

        $schools = $this->whereClause($schools);
        $schools = $this->loadRelations($schools);
        $schools = $this->sortingAndLimit($schools);

        return $this->apiSuccessResponse(SchoolResource::collection($schools), 'Data Get Successfully!');
    }

    public function show(School $school)
    {
        $school = $school->with('schoolDetail')->find($school->id);
        return $this->apiSuccessResponse(new SchoolResource($school), 'Data Get Successfully!');
    }

    public function store(Request $request)
    {
        $validationRule = [];
        $errorMessages = [];
        $languages = getAllLanguages();
        foreach ($languages as $language) {
            $requiredVal = 'nullable';
            if ($language->is_default == '1') {
                $requiredVal = 'required';
            }
            $validationRule = array_merge($validationRule, ['school_name.school_name_' . $language->abbreviation => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['school_name.school_name_' . $language->abbreviation . '.required' => 'Name is required']);
            $validationRule = array_merge($validationRule, ['description.description_' . $language->abbreviation => [$requiredVal, 'string', new CheckCategorySlug($language, null)]]);
            $errorMessages = array_merge($errorMessages, ['description.description_' . $language->abbreviation . '.required' => 'Description is required']);
        }
        $validationRule = array_merge($validationRule, ['website_url' => ['required', new ValidUrl()]]);
        $errorMessages = array_merge($errorMessages, ['website_url.required' => 'Website URL is required']);
        $validationRule = array_merge($validationRule, ['email' => ['required', 'email']]);
        $errorMessages = array_merge($errorMessages, ['email.required' => 'Email is required']);
        $validationRule = array_merge($validationRule, ['phone' => ['required']]);
        $errorMessages = array_merge($errorMessages, [
            'phone.required' => 'Phone is required'
        ]);
        $validationRule = array_merge($validationRule, ['time' => ['nullable']]);
        $errorMessages = array_merge($errorMessages, ['time.required' => 'Time is required']);
        $validationRule = array_merge($validationRule, ['time_zone' => ['nullable']]);
        $errorMessages = array_merge($errorMessages, ['time_zone.required' => 'Time zone is required']);
        $validationRule = array_merge($validationRule, ['province' => ['nullable']]);
        $errorMessages = array_merge($errorMessages, ['province.required' => 'Province is required']);
        $validationRule = array_merge($validationRule, ['country' => ['required']]);
        $errorMessages = array_merge($errorMessages, ['country.required' => 'Country is required']);
        $validationRule = array_merge($validationRule, ['city' => ['nullable']]);
        $errorMessages = array_merge($errorMessages, ['city.required' => 'City is required']);
        $validationRule = array_merge($validationRule, ['youtube_link' => ['nullable', new YoutubeUrl()]]);
        $validationRule = array_merge($validationRule, ['degree_id' => ['required']]);
        $errorMessages = array_merge($errorMessages, ['degree_id.required' => 'Degree is required']);
        $validationRule = array_merge($validationRule, ['image' => ['required']]);
        // $errorMessages = array_merge($errorMessages, ['image.required' => 'Image is required']);

        $this->validate($request, $validationRule, $errorMessages);
        $School = School::create([
            'website_url' => $request->website_url,
            'email' => $request->email,
            'phone' => $request->phone,
            'time' => $request->time,
            'time_zone' => $request->time_zone,
            'province' => $request->province,
            'country' => $request->country,
            'city' => $request->city,
            'youtube_link' => $request->youtube_link,
            'youtube_iframe' => getVideoHtmlAttribute($request->youtube_link),
            'degree_id' => $request->degree_id,
            'image' => $request->image,
        ]);

        if ($School) {
            foreach ($languages as $language) {
                if (isset($request['school_name']['school_name_' . $language->abbreviation]) && isset($request['description']['description_' . $language->abbreviation])) {
                    SchoolDetail::create([
                        'school_id' => $School->id,
                        'language_code' => $language->abbreviation,
                        'school_name' => $request['school_name']['school_name_' . $language->abbreviation],
                        'description' => $request['description']['description_' . $language->abbreviation],
                    ]);
                }
            }
            return $this->apiSuccessResponse(new SchoolResource($School), 'Your changes have been done successfully');
        }
        return $this->errorResponse();
    }

    public function update(Request $request, School $School)
    {
        // dd($request->all());
        $validationRule = [];
        $errorMessages = [];
        $languages = getAllLanguages();
        foreach ($languages as $language) {
            $requiredVal = 'nullable';
            if ($language->is_default == '1') {
                $requiredVal = 'required';
            }
            $validationRule = array_merge($validationRule, ['school_name.school_name_' . $language->abbreviation => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['school_name.school_name_' . $language->abbreviation . '.required' => 'Name is required']);
            $validationRule = array_merge($validationRule, ['description.description_' . $language->abbreviation => [$requiredVal, 'string', new CheckCategorySlug($language, null)]]);
            $errorMessages = array_merge($errorMessages, ['description.description_' . $language->abbreviation . '.required' => 'Description is required']);
            // new
            // $validationRule = array_merge($validationRule, ['more_button_title.more_button_title_' . $language->abbreviation => [$requiredVal, 'string', new CheckCategorySlug($language, null)]]);
            // $errorMessages = array_merge($errorMessages, ['more_button_title.more_button_title_' . $language->abbreviation . '.required' => 'more_button_title is required']);

            $validationRule = array_merge($validationRule, ['more_button_title.more_button_title_' . $language->abbreviation => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['more_button_title.more_button_title_' . $language->abbreviation . '.required' => 'more_button_title is required']);
            $validationRule = array_merge($validationRule, ['more_button_sub_title.more_button_sub_title_' . $language->abbreviation => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['more_button_sub_title.more_button_sub_title_' . $language->abbreviation . '.required' => 'This field is required.']);
            $validationRule = array_merge($validationRule, ['other_button_title.other_button_title_' . $language->abbreviation => ['nullable', 'string']]);
            $errorMessages = array_merge($errorMessages, ['other_button_title.other_button_title_' . $language->abbreviation . '.required' => 'This field is required.']);
        }
        $validationRule = array_merge($validationRule, ['website_url' => ['required', new ValidUrl()]]);
        $errorMessages = array_merge($errorMessages, ['website_url.required' => 'Website URL is required']);
        $validationRule = array_merge($validationRule, ['email' => ['required', 'email']]);
        $errorMessages = array_merge($errorMessages, ['email.required' => 'Email is required']);
        $validationRule = array_merge($validationRule, ['phone' => ['required']]);
        $errorMessages = array_merge($errorMessages, ['phone.required' => 'Phone is required']);
        $validationRule = array_merge($validationRule, ['time' => ['nullable']]);
        $errorMessages = array_merge($errorMessages, ['time.required' => 'Time is required']);
        $validationRule = array_merge($validationRule, ['time_zone' => ['nullable']]);
        $errorMessages = array_merge($errorMessages, ['time_zone.required' => 'Time zone is required']);
        $validationRule = array_merge($validationRule, ['province' => ['nullable']]);
        $errorMessages = array_merge($errorMessages, ['province.required' => 'Province is required']);
        $validationRule = array_merge($validationRule, ['country' => ['required']]);
        $errorMessages = array_merge($errorMessages, ['country.required' => 'Country is required']);
        $validationRule = array_merge($validationRule, ['city' => ['nullable']]);
        $errorMessages = array_merge($errorMessages, ['city.required' => 'City is required']);
        $validationRule = array_merge($validationRule, ['youtube_link' => ['nullable', new YoutubeUrl()]]);
        $validationRule = array_merge($validationRule, ['degree_id' => ['required']]);
        $errorMessages = array_merge($errorMessages, ['degree_id.required' => 'Degree is required']);
        $validationRule = array_merge($validationRule, ['image' => ['required']]);
        // $errorMessages = array_merge($errorMessages, ['image.required' => 'Image is required']);
        $validationRule = array_merge($validationRule, ['program_status' => ['required']]);
        $errorMessages = array_merge($errorMessages, ['program_status.required' => 'This field is required.']);
        $validationRule = array_merge($validationRule, ['financial_status' => ['required']]);
        $errorMessages = array_merge($errorMessages, ['financial_status.required' => 'This field is required.']);
        $validationRule = array_merge($validationRule, ['scholarship_status' => ['required']]);
        $errorMessages = array_merge($errorMessages, ['scholarship_status.required' => 'This field is required.']);
        $validationRule = array_merge($validationRule, ['contacts_status' => ['required']]);
        $errorMessages = array_merge($errorMessages, ['contacts_status.required' => 'This field is required.']);
        $validationRule = array_merge($validationRule, ['ambassador_status' => ['required']]);
        $errorMessages = array_merge($errorMessages, ['ambassador_status.required' => 'This field is required.']);
        $validationRule = array_merge($validationRule, ['quick_facts_status' => ['required']]);
        $errorMessages = array_merge($errorMessages, ['quick_facts_status.required' => 'This field is required.']);
        $validationRule = array_merge($validationRule, ['other_button_link' => ['nullable']]);
        $errorMessages = array_merge($errorMessages, ['other_button_link.required' => 'This field is required.']);
        $this->validate($request, $validationRule, $errorMessages);

        $School->update([
            'website_url' => $request->website_url,
            'email' => $request->email,
            'phone' => $request->phone,
            'time' => $request->time,
            'time_zone' => $request->time_zone,
            'province' => $request->province,
            'country' => $request->country,
            'city' => $request->city,
            'youtube_link' => $request->youtube_link,
            'youtube_iframe' => getVideoHtmlAttribute($request->youtube_link),
            'degree_id' => $request->degree_id,
            'image' => $request->image,
            // new
            'other_button_link' => $request->other_button_link,
            'quick_facts_status' => $request->quick_facts_status,
            'overview_status' => $request->overview_status,
            'program_status' => $request->program_status,
            'admission_status' => $request->admission_status,
            'financial_status' => $request->financial_status,
            'scholarship_status' => $request->scholarship_status,
            'contacts_status' => $request->contacts_status,
            'ambassador_status' => $request->ambassador_status,
            'facebook' => $request->facebook,
            'linkedin' => $request->linkedin,
            'insta' => $request->insta,
            'twitter' => $request->twitter,
            'youtube' => $request->youtube,
            'vk' => $request->vk,
            'main_button_link' => $request->main_button_link,
        ]);
        foreach ($languages as $language) {
            if (isset($request['school_name']['school_name_' . $language->abbreviation]) && isset($request['description']['description_' . $language->abbreviation])) {
                $SchoolDetail = SchoolDetail::whereLanguageCode($language->abbreviation)
                    ->whereSchoolId($School->id)
                    ->exists();
                if ($SchoolDetail) {
                    SchoolDetail::whereLanguageCode($language->abbreviation)
                        ->whereSchoolId($School->id)
                        ->update([
                            'school_id' => $School->id,
                            'language_code' => $language->abbreviation,
                            'school_name' => $request['school_name']['school_name_' . $language->abbreviation],
                            'more_button_title' => $request['more_button_title']['more_button_title_' . $language->abbreviation],
                            'description' => $request['description']['description_' . $language->abbreviation],
                            'more_button_sub_title' => $request['more_button_sub_title']['more_button_sub_title_' . $language->abbreviation],
                            'other_button_title' => $request['other_button_title']['other_button_title_' . $language->abbreviation],
                            // 'more_button_title' => $request['more_button_title']['more_button_title_' . $language->abbreviation],
                        ]);
                } else {
                    SchoolDetail::create([
                        'school_id' => $School->id,
                        'language_code' => $language->abbreviation,
                        'school_name' => $request['school_name']['school_name_' . $language->abbreviation],
                        'description' => $request['description']['description_' . $language->abbreviation],
                        'more_button_sub_title' => $request['more_button_sub_title']['more_button_sub_title_' . $language->abbreviation],
                        'other_button_title' => $request['other_button_title']['other_button_title_' . $language->abbreviation],
                        'more_button_title' => $request['more_button_title']['more_button_title_' . $language->abbreviation],
                    ]);
                }
            }
        }

        if ($School) {
            return $this->apiSuccessResponse(new SchoolResource($School), 'Your changes have been done successfully');
        }
        return $this->errorResponse();
    }

    public function destroy(Request $request, School $School)
    {
        if ($School->delete()) {
            return $this->apiSuccessResponse(new SchoolResource($School), 'The selected item has been deleted successfully');
        }
        return $this->errorResponse();
    }

    public function deactiveSchool(Request $request)
    {
        $sql = School::whereId($request->id)->update(['deactive_account' => $request->type]);
        return $this->successResponse('', 'School status update successfully.');
    }

    protected function loadRelations($schools)
    {
        $defaultLang = getDefaultLanguage();
        $schools = $schools->with([
            'schoolDetail' => function ($q) use ($defaultLang) {
                $q->where('language_code', $defaultLang->abbreviation);
            },
        ]);
        return $schools;
    }

    protected function sortingAndLimit($schools)
    {
        // $sortType = ['ASC', 'asc', 'DESC', 'desc'];
        // $sortBy = ['id', 'school_name', 'abbreviation', 'school_name'];
        // if (isset($_GET['sortBy']) && $_GET['sortBy'] != '' && isset($_GET['sortType']) && $_GET['sortType'] != '' && in_array($_GET['sortBy'], $sortBy) && in_array($_GET['sortType'], $sortType)) {
        //     $defaultLang = getDefaultLanguage();
        //     $schools = $schools->addSelect(['school_name' => SchoolDetail::whereColumn('schools.id', 'school_details.school_id')->whereLanguageId($defaultLang->id)->select('school_name')->limit(1)]);

        //     $schools = $schools->OrderBy($_GET['sortBy'], $_GET['sortType']);
        // }
        $schools = $schools->addSelect([
            'school_name' => function ($query) {
                $query->select('school_name')
                    ->from('school_details')
                    ->whereColumn('school_details.school_id', 'schools.id')
                    ->limit(1);
            }
        ])->orderBy('school_name', 'ASC');

        if (isset($_GET['limit']) && $_GET['limit'] != '') {
            $limit = $_GET['limit'];
        } else {
            $limit = 10;
        }

        return $schools->paginate($limit);
    }

    protected function whereClause($schools)
    {
        if (isset($_GET['searchParam']) && $_GET['searchParam'] != '') {
            $schools = $schools
                ->whereHas('schoolDetail', function ($q) {
                    $q->where('school_name', 'LIKE', '%' . $_GET['searchParam'] . '%');
                })
                ->orWhere('email', $_GET['searchParam']);
        }
        return $schools;
    }

    public function uploadExcelFileSchoolType(Request $request)
    {
        $image = $request->file('excel_file');
        $name = time() . '.' . $image->getClientOriginalExtension();
        $destinationPath = public_path('/images');
        $image->move($destinationPath, $name);
        $reader = new Xlsx();
        $reader->setReadDataOnly(true);
        $spreadsheet = $reader->load($destinationPath . '/' . $name);
        $sheet = $spreadsheet->getSheet($spreadsheet->getFirstSheetIndex());
        $data = $sheet->toArray();
        $firstRowKeys = $data[0];
        $schoolTyps = [];
        foreach ($data as $key => $value) {
            if ($key != 0) {
                $localData = [];
                foreach ($firstRowKeys as $i => $firstRowKey) {
                    if (isset($value[$i])) {
                        $localData[$firstRowKey] = $value[$i];
                    }
                }

                $schoolTyps[] = $localData;
            }
        }
        $defaultLang = getDefaultLanguage(1);
        foreach ($schoolTyps as $schoolType) {
            if (isset($schoolType['name']) && !SchoolDetail::whereSchoolName($schoolType['name'])->exists()) {
                $schoolNew = SchoolType::create([]);
                if ($schoolNew) {
                    SchoolTypeDetail::create([
                        'language_id' => $defaultLang->id,
                        'name' => isset($schoolType['name']) ? $schoolType['name'] : '',
                        'school_type_id' => $schoolNew->id,
                    ]);
                }
            }
        }
        return redirect()->back();
    }

    public function uploadExcelFileScholarship(Request $request)
    {
        $image = $request->file('excel_file');
        $name = time() . '.' . $image->getClientOriginalExtension();
        $destinationPath = public_path('/images');
        $image->move($destinationPath, $name);
        $reader = new Xlsx();
        $reader->setReadDataOnly(true);
        $spreadsheet = $reader->load($destinationPath . '/' . $name);
        $sheet = $spreadsheet->getSheet($spreadsheet->getFirstSheetIndex());
        $data = $sheet->toArray();
        $firstRowKeys = $data[0];
        $scholarships = [];
        foreach ($data as $key => $value) {
            if ($key != 0) {
                $localData = [];
                foreach ($firstRowKeys as $i => $firstRowKey) {
                    if (isset($value[$i])) {
                        $localData[$firstRowKey] = $value[$i];
                    }
                }

                $scholarships[] = $localData;
            }
        }
        $defaultLang = getDefaultLanguage(1);
        foreach ($scholarships as $scholarship) {
            $schoolId = null;
            if (isset($scholarship['school_id'])) { // Assuming column is named 'school_name' in Excel
                $schoolDetail = SchoolDetail::where('school_name', 'LIKE', '%' . $scholarship['school_id'] . '%')->first();
                if ($schoolDetail) {
                    $schoolId = $schoolDetail->school_id;
                    echo "Matched School: " . $scholarship['school_id'] . " with ID: " . $schoolId . PHP_EOL;
                }
            }
            if (isset($scholarship['name']) && !SchoolDetail::whereSchoolName($scholarship['name'])->exists()) {
                $scholarshipNew = SchoolScholarship::create([
                    'province' => isset($scholarship['province']) ? $scholarship['province'] : '',
                    'award' => isset($scholarship['award']) ? $scholarship['award'] : '',
                    'amount' => isset($scholarship['scholarship_amount']) ? $scholarship['scholarship_amount'] : '',
                    'action' => isset($scholarship['action']) ? $scholarship['action'] : '',
                    'date_posted' => isset($scholarship['date_posted']) ? $scholarship['date_posted'] : '',
                    'expiry_date' => isset($scholarship['expiry_date']) ? $scholarship['expiry_date'] : '',
                    'deadline_date' => isset($scholarship['deadline']) ? $scholarship['deadline'] : '',
                    'availability' => isset($scholarship['availability']) ? $scholarship['availability'] : '',
                    'study_level' => isset($scholarship['level_of_study']) ? $scholarship['level_of_study'] : '',
                    'duration' => isset($scholarship['duration']) ? $scholarship['duration'] : '',
                    'link' => isset($scholarship['link']) ? $scholarship['link'] : '',
                    'more_info_link' => isset($scholarship['more_info_link']) ? $scholarship['more_info_link'] : '',
                    'image' => isset($scholarship['image']) ? $scholarship['image'] : '',
                    // 'school_id' => isset($scholarship['school_id']) && School::whereId($scholarship['school_id'])->exists() ? $scholarship['school_id'] : null,
                    'school_id' => $schoolId
                ]);
                if ($scholarshipNew) {
                    SchoolScholarshipDetail::create([
                        'language_code' => $defaultLang->abbreviation,
                        'name' => isset($scholarship['name']) ? $scholarship['name'] : '',
                        'summary' => isset($scholarship['summary']) ? $scholarship['summary'] : '',
                        'criteria' => isset($scholarship['criteria']) ? $scholarship['criteria'] : '',
                        'school_scholarship_id' => $scholarshipNew->id,
                    ]);
                }
            }
        }
        return redirect()->back();
    }

    public function updateMasterThreshold(Request $request)
    {
        $updateSchool = School::whereId($request->school_id)->update([
            'master_app_threshold' => $request->threshold,
        ]);

        if ($updateSchool) {
            return $this->successResponse('', 'School has been updated successfully.');
        }

        return $this->apiErrorResponse();
    }

    public function sendCredentials(Request $request, $schoolId)
    {
        $school = School::with(['schoolDetail', 'customer'])->findOrFail($schoolId);

        if (!$school->customer) {
            $customer = Customer::create([
                'first_name' => $school->schoolDetail->first()->school_name ?? 'School',
                'last_name' => $school->schoolDetail->first()->school_name ?? 'Admin',
                'email' => $school->email,
                'password' => bcrypt(Str::random(10)),
                'user_type' => 'school',
                'slug' => Str::slug($school->schoolDetail->first()->school_name ?? 'school-' . $school->id),
                'deactive_account' => 0,
            ]);

            $school->customer_id = $customer->id;
            $school->save();
        } else {
            $customer = $school->customer;
        }

        return app(CustomerController::class)->sendCredentialsEmail($request, $customer->id);
    }
}
