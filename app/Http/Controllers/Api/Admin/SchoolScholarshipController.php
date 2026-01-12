<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\SchoolScholarshipResource;
use Illuminate\Support\Str;
use App\Models\SchoolScholarship;
use App\Models\SchoolScholarshipDetail;
use App\Models\Language;
use App\Models\SchoolScholarshipSchoolScholarship;
use App\Models\SchoolScholarshipSchoolScholarshipDetail;
use App\Models\SchoolScholarshipType;
use App\Models\SchoolScholarshipTypeDetail;
use App\Rules\CheckCategorySlug;
use App\Traits\StatusResponser;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

class SchoolScholarshipController extends Controller
{
    use StatusResponser;
    use FileUploadTrait;

    public function __construct()
    {
        $this->middleware('password_confirm')->only('destroy');
    }

    public function index()
    {
        $schoolScholarships = SchoolScholarship::query();

        $schoolScholarships = $this->whereClause($schoolScholarships);
        $schoolScholarships = $this->loadRelations($schoolScholarships);
        $schoolScholarships = $this->sortingAndLimit($schoolScholarships);

        return $this->apiSuccessResponse(SchoolScholarshipResource::collection($schoolScholarships), 'Data Get Successfully!');
    }

    public function show(SchoolScholarship $schoolScholarship)
    {
        $schoolScholarship = $schoolScholarship->with('schoolScholarshipDetail')->find($schoolScholarship->id);
        return $this->apiSuccessResponse(new SchoolScholarshipResource($schoolScholarship), 'Data Get Successfully!');
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
            $validationRule = array_merge($validationRule, ['name.name_' . $language->abbreviation => [$requiredVal, 'string', new CheckCategorySlug($language, null)]]);
            $errorMessages = array_merge($errorMessages, ['name.name_' . $language->abbreviation . '.required' => 'Scholarship Name is required.']);
            $validationRule = array_merge($validationRule, ['summary.summary_' . $language->abbreviation => [$requiredVal, 'string', new CheckCategorySlug($language, null)]]);
            $errorMessages = array_merge($errorMessages, ['summary.summary_' . $language->abbreviation . '.required' => 'Description is required.']);
            $validationRule = array_merge($validationRule, ['criteria.criteria_' . $language->abbreviation => [$requiredVal, 'string', new CheckCategorySlug($language, null)]]);
            $errorMessages = array_merge($errorMessages, ['criteria.criteria_' . $language->abbreviation . '.required' => 'Criteria is required.']);
        }
        $validationRule = array_merge($validationRule, ['province' => ['required', 'string']]);
        $errorMessages = array_merge($errorMessages, ['province' . '.required' => 'Department is required.']);
        $validationRule = array_merge($validationRule, ['award' => ['nullable', 'string']]);
        $errorMessages = array_merge($errorMessages, ['award' . '.required' => 'award is required.']);
        $validationRule = array_merge($validationRule, ['amount' => ['required', 'string']]);
        $errorMessages = array_merge($errorMessages, ['amount' . '.required' => 'amount is required.']);
        $validationRule = array_merge($validationRule, ['action' => ['required', 'string']]);
        $errorMessages = array_merge($errorMessages, ['action' . '.required' => 'action is required.']);
        $validationRule = array_merge($validationRule, ['date_posted' => ['required', 'string']]);
        $errorMessages = array_merge($errorMessages, ['date_posted' . '.required' => 'date_posted is required.']);
        $validationRule = array_merge($validationRule, ['deadline_date' => ['required', 'string']]);
        $errorMessages = array_merge($errorMessages, ['deadline_date' . '.required' => 'deadline_date is required.']);
        $validationRule = array_merge($validationRule, ['availability' => ['nullable', 'string']]);
        $errorMessages = array_merge($errorMessages, ['availability' . '.required' => 'availability is required.']);
        $validationRule = array_merge($validationRule, ['study_level' => ['nullable', 'string']]);
        $errorMessages = array_merge($errorMessages, ['study_level' . '.required' => 'study_level is required.']);
        $validationRule = array_merge($validationRule, ['duration' => ['nullable', 'string']]);
        $errorMessages = array_merge($errorMessages, ['duration' . '.required' => 'duration is required.']);
        $validationRule = array_merge($validationRule, ['link' => ['required', 'string']]);
        $errorMessages = array_merge($errorMessages, ['link' . '.required' => 'link is required.']);
        $validationRule = array_merge($validationRule, ['more_info_link' => ['required', 'string']]);
        $errorMessages = array_merge($errorMessages, ['more_info_link' . '.required' => 'more_info_link is required.']);
        $validationRule = array_merge($validationRule, ['featured' => ['required']]);
        $errorMessages = array_merge($errorMessages, ['featured' . '.required' => 'featured is required.']);

        $this->validate($request, $validationRule, $errorMessages);
        $SchoolScholarship = SchoolScholarship::create([
            'province' => $request->province,
            'award' => $request->award,
            'amount' => $request->amount,
            'action' => $request->action,
            'date_posted' => $request->date_posted,
            'expiry_date' => $request->expiry_date,
            'deadline_date' => $request->deadline_date,
            'availability' => $request->availability,
            'study_level' => $request->study_level,
            'duration' => $request->duration,
            'link' => $request->link,
            'more_info_link' => $request->more_info_link,
            'featured' => $request->featured,
            'image' => $request->image,
            'school_id' => $request->school_id,
        ]);

        if ($SchoolScholarship) {
            foreach ($languages as $language) {
                if (isset($request['name']['name_' . $language->abbreviation]) && isset($request['summary']['summary_' . $language->abbreviation])) {
                    SchoolScholarshipDetail::create([
                        'school_scholarship_id' => $SchoolScholarship->id,
                        'language_code' => $language->abbreviation,
                        'name' => $request['name']['name_' . $language->abbreviation],
                        'summary' => $request['summary']['summary_' . $language->abbreviation],
                        'criteria' => $request['criteria']['criteria_' . $language->abbreviation],
                    ]);
                }
            }
            return $this->apiSuccessResponse(new SchoolScholarshipResource($SchoolScholarship), 'Your changes have been done successfully');
        }
        return $this->errorResponse();
    }

    public function update(Request $request, SchoolScholarship $SchoolScholarship)
    {
        $validationRule = [];
        $errorMessages = [];
        $languages = getAllLanguages();
        foreach ($languages as $language) {
            $requiredVal = 'nullable';
            if ($language->is_default == '1') {
                $requiredVal = 'required';
            }
            $validationRule = array_merge($validationRule, ['name.name_' . $language->abbreviation => [$requiredVal, 'string', new CheckCategorySlug($language, null)]]);
            $errorMessages = array_merge($errorMessages, ['name.name_' . $language->abbreviation . '.required' => 'Scholarship Name is required.']);
            $validationRule = array_merge($validationRule, ['summary.summary_' . $language->abbreviation => [$requiredVal, 'string', new CheckCategorySlug($language, null)]]);
            $errorMessages = array_merge($errorMessages, ['summary.summary_' . $language->abbreviation . '.required' => 'Description is required.']);
            $validationRule = array_merge($validationRule, ['criteria.criteria_' . $language->abbreviation => [$requiredVal, 'string', new CheckCategorySlug($language, null)]]);
            $errorMessages = array_merge($errorMessages, ['criteria.criteria_' . $language->abbreviation . '.required' => 'Criteria is required.']);
        }
        $validationRule = array_merge($validationRule, ['province' => ['required', 'string']]);
        $errorMessages = array_merge($errorMessages, ['province' . '.required' => 'Department is required.']);
        $validationRule = array_merge($validationRule, ['award' => ['required', 'string']]);
        $errorMessages = array_merge($errorMessages, ['award' . '.required' => 'award is required.']);
        $validationRule = array_merge($validationRule, ['amount' => ['required', 'string']]);
        $errorMessages = array_merge($errorMessages, ['amount' . '.required' => 'amount is required.']);
        $validationRule = array_merge($validationRule, ['action' => ['required', 'string']]);
        $errorMessages = array_merge($errorMessages, ['action' . '.required' => 'action is required.']);
        $validationRule = array_merge($validationRule, ['date_posted' => ['required', 'string']]);
        $errorMessages = array_merge($errorMessages, ['date_posted' . '.required' => 'date_posted is required.']);
        $validationRule = array_merge($validationRule, ['deadline_date' => ['required', 'string']]);
        $errorMessages = array_merge($errorMessages, ['deadline_date' . '.required' => 'deadline_date is required.']);
        $validationRule = array_merge($validationRule, ['availability' => ['required', 'string']]);
        $errorMessages = array_merge($errorMessages, ['availability' . '.required' => 'availability is required.']);
        $validationRule = array_merge($validationRule, ['study_level' => ['required', 'string']]);
        $errorMessages = array_merge($errorMessages, ['study_level' . '.required' => 'study_level is required.']);
        $validationRule = array_merge($validationRule, ['duration' => ['required', 'string']]);
        $errorMessages = array_merge($errorMessages, ['duration' . '.required' => 'duration is required.']);
        $validationRule = array_merge($validationRule, ['link' => ['required', 'string']]);
        $errorMessages = array_merge($errorMessages, ['link' . '.required' => 'link is required.']);
        $validationRule = array_merge($validationRule, ['more_info_link' => ['required', 'string']]);
        $errorMessages = array_merge($errorMessages, ['more_info_link' . '.required' => 'more_info_link is required.']);
        $validationRule = array_merge($validationRule, ['featured' => ['required']]);
        $errorMessages = array_merge($errorMessages, ['featured' . '.required' => 'featured is required.']);
        $this->validate($request, $validationRule, $errorMessages);

        $SchoolScholarship->update([
            'province' => $request->province,
            'award' => $request->award,
            'amount' => $request->amount,
            'action' => $request->action,
            'date_posted' => $request->date_posted,
            'expiry_date' => $request->expiry_date,
            'deadline_date' => $request->deadline_date,
            'availability' => $request->availability,
            'study_level' => $request->study_level,
            'duration' => $request->duration,
            'link' => $request->link,
            'more_info_link' => $request->more_info_link,
            'featured' => $request->featured,
            'image' => $request->image,
            'school_id' => $request->school_id,
        ]);
        foreach ($languages as $language) {
            if (isset($request['name']['name_' . $language->abbreviation]) && isset($request['summary']['summary_' . $language->abbreviation])) {
                $SchoolScholarshipDetail = SchoolScholarshipDetail::whereLanguageCode($language->abbreviation)
                    ->whereSchoolScholarshipId($SchoolScholarship->id)
                    ->exists();
                if ($SchoolScholarshipDetail) {
                    SchoolScholarshipDetail::whereLanguageCode($language->abbreviation)
                        ->whereSchoolScholarshipId($SchoolScholarship->id)
                        ->update([
                            'school_scholarship_id' => $SchoolScholarship->id,
                            'language_code' => $language->abbreviation,
                            'name' => $request['name']['name_' . $language->abbreviation],
                            'summary' => $request['summary']['summary_' . $language->abbreviation],
                            'criteria' => $request['criteria']['criteria_' . $language->abbreviation],
                        ]);
                } else {
                    SchoolScholarshipDetail::create([
                        'school_scholarship_id' => $SchoolScholarship->id,
                        'language_code' => $language->abbreviation,
                        'name' => $request['name']['name_' . $language->abbreviation],
                        'summary' => $request['summary']['summary_' . $language->abbreviation],
                        'criteria' => $request['criteria']['criteria_' . $language->abbreviation],
                    ]);
                }
            }
        }

        if ($SchoolScholarship) {
            return $this->apiSuccessResponse(new SchoolScholarshipResource($SchoolScholarship), 'Your changes have been done successfully');
        }
        return $this->errorResponse();
    }

    public function destroy(Request $request, SchoolScholarship $SchoolScholarship)
    {
        if ($SchoolScholarship->delete()) {
            return $this->apiSuccessResponse(new SchoolScholarshipResource($SchoolScholarship), 'The selected item has been deleted successfully');
        }
        return $this->errorResponse();
    }

    public function deactiveSchoolScholarship(Request $request)
    {
        $sql = SchoolScholarship::whereId($request->id)->update(['deactive_account' => $request->type]);
        return $this->successResponse('', 'SchoolScholarship status update successfully.');
    }

    protected function loadRelations($schoolScholarships)
    {
        $defaultLang = getDefaultLanguage();
        $schoolScholarships = $schoolScholarships->with([
            'schoolScholarshipDetail' => function ($q) use ($defaultLang) {
                $q->where('language_code', $defaultLang->abbreviation);
            },
        ]);
        if (isset($_GET['withSchoolScholarshipDetail']) && $_GET['withSchoolScholarshipDetail'] == '1') {
            $schoolScholarships = $schoolScholarships->with('schoolScholarshipDetail');
        }
        return $schoolScholarships;
    }

    protected function sortingAndLimit($schoolScholarships)
    {
        $sortType = ['ASC', 'asc', 'DESC', 'desc'];
        $sortBy = ['id', 'name', 'abbreviation', 'school_scholarship_name'];
        if (isset($_GET['sortBy']) && $_GET['sortBy'] != '' && isset($_GET['sortType']) && $_GET['sortType'] != '' && in_array($_GET['sortBy'], $sortBy) && in_array($_GET['sortType'], $sortType)) {
            $defaultLang = getDefaultLanguage();
            $schoolScholarships = $schoolScholarships->addSelect(['school_scholarship_name' => SchoolScholarshipDetail::whereColumn('school_scholarships.id', 'school_scholarship_details.school_scholarship_id')->whereLanguageCode($defaultLang->abbreviation)->select('name')->limit(1)]);

            $schoolScholarships = $schoolScholarships->OrderBy($_GET['sortBy'], $_GET['sortType']);
        }

        if (isset($_GET['limit']) && $_GET['limit'] != '') {
            $limit = $_GET['limit'];
        } else {
            $limit = 10;
        }

        return $schoolScholarships->paginate($limit);
    }

    protected function whereClause($schoolScholarships)
    {
        if (isset($_GET['searchParam']) && $_GET['searchParam'] != '') {
            $schoolScholarships = $schoolScholarships->whereHas('SchoolScholarshipDetail', function ($q) {
                $q->where('name', 'LIKE', '%' . $_GET['searchParam'] . '%');
            });
        }
        return $schoolScholarships;
    }
}
