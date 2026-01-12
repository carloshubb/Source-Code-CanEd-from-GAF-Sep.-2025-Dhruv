<?php

namespace App\Http\Controllers\Api\Web;

use App\Http\Controllers\Controller;
use App\Http\Resources\Web\SchoolScholarshipResource;
use Illuminate\Support\Str;
use App\Models\SchoolScholarship;
use App\Models\SchoolScholarshipDetail;
use App\Traits\StatusResponser;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;

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
        $customer = auth()
            ->guard('customers')
            ->user();
        if (isset($_GET['is_admin'])) {
            $schoolScholarships = SchoolScholarship::query();
        } else {
            $schoolScholarships = SchoolScholarship::where('customer_id', $customer->id);
        }
        $schoolScholarships = $this->whereClause($schoolScholarships);
        $schoolScholarships = $this->loadRelations($schoolScholarships);
        $schoolScholarships = $this->sortingAndLimit($schoolScholarships);

        return $this->apiSuccessResponse(SchoolScholarshipResource::collection($schoolScholarships), 'Data Get Successfully!');
    }


    public function show(SchoolScholarship $SchoolScholarship)
    {
        if (isset($_GET['withSchoolScholarshipDetail']) && $_GET['withSchoolScholarshipDetail'] == '1') {
            $SchoolScholarship = $SchoolScholarship->loadMissing('schoolScholarshipDetail');
        }

        return $this->apiSuccessResponse(new SchoolScholarshipResource($SchoolScholarship), 'Data Get Successfully!');
    }


    public function store(Request $request)
    {
        $validationRule = [];
        $errorMessages = [];
        $languages = getAllLanguages();
        foreach ($languages as $language) {
            if ($language->is_default == 1) {
                $validationRule = array_merge($validationRule, ['name.name_' . $language->abbreviation => ['required', 'string']]);
                $errorMessages = array_merge($errorMessages, ['name.name_' . $language->abbreviation . '.required' => 'Name is required']);
                $validationRule = array_merge($validationRule, ['summary.summary_' . $language->abbreviation => ['required', 'string']]);
                $errorMessages = array_merge($errorMessages, ['summary.summary_' . $language->abbreviation . '.required' => 'Summary is required']);
                $validationRule = array_merge($validationRule, ['summary.summary_' . $language->abbreviation => ['required', 'string']]);
                $errorMessages = array_merge($errorMessages, ['criteria.criteria_' . $language->abbreviation . '.required' => 'Criteria is required']);
            }
        }
        $validationRule = array_merge($validationRule, ['province' => ['required', 'string']]);
        $errorMessages = array_merge($errorMessages, ['province' . '.required' => 'Department is required']);
        $validationRule = array_merge($validationRule, ['award' => ['nullable', 'string']]);
        $errorMessages = array_merge($errorMessages, ['award' . '.required' => 'Award is required']);
        $validationRule = array_merge($validationRule, ['amount' => ['required', 'string']]);
        $errorMessages = array_merge($errorMessages, ['amount' . '.required' => 'Amount is required']);
        $validationRule = array_merge($validationRule, ['action' => ['required', 'string']]);
        $errorMessages = array_merge($errorMessages, ['action' . '.required' => 'Action is required']);
        $validationRule = array_merge($validationRule, ['date_posted' => ['nullable', 'string']]);
        $errorMessages = array_merge($errorMessages, ['date_posted' . '.required' => 'Posted date is required']);
        $validationRule = array_merge($validationRule, ['expiry_date' => ['nullable', 'string']]);
        $errorMessages = array_merge($errorMessages, ['expiry_date' . '.required' => 'Expiry date is required']);
        $validationRule = array_merge($validationRule, ['deadline_date' => ['nullable', 'string']]);
        $errorMessages = array_merge($errorMessages, ['deadline_date' . '.required' => 'Deadline date is required']);
        $validationRule = array_merge($validationRule, ['availability' => ['nullable', 'string']]);
        $errorMessages = array_merge($errorMessages, ['availability' . '.required' => 'Availability is required']);
        $validationRule = array_merge($validationRule, ['study_level' => ['nullable', 'string']]);
        $errorMessages = array_merge($errorMessages, ['study_level' . '.required' => 'Study level is required']);
        $validationRule = array_merge($validationRule, ['duration' => ['nullable', 'string']]);
        $errorMessages = array_merge($errorMessages, ['duration' . '.required' => 'Duration is required']);
        $validationRule = array_merge($validationRule, ['link' => ['required', 'string']]);
        $errorMessages = array_merge($errorMessages, ['link' . '.required' => 'Link is required']);
        $validationRule = array_merge($validationRule, ['more_info_link' => ['required', 'string']]);
        $errorMessages = array_merge($errorMessages, ['more_info_link' . '.required' => 'Info link is required']);
        $validationRule = array_merge($validationRule, ['featured' => ['required']]);
        $errorMessages = array_merge($errorMessages, ['featured' . '.required' => 'Featured is required']);

        $this->validate(
            $request,
            $validationRule,
            $errorMessages
        );
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
            'customer_id' => $request->customer_id,
            'school_id' => $request->school_id,
        ]);


        if ($SchoolScholarship) {
            foreach ($request->languages as $language) {
                if (
                    !empty($request['name']['name_' . $language['language_code']])
                    && !empty($request['summary']['summary_' . $language['language_code']])
                    && !empty($request['criteria']['criteria_' . $language['language_code']])
                ) {
                    SchoolScholarshipDetail::create([
                        'school_scholarship_id' => $SchoolScholarship->id,
                        'language_code' => $language['language_code'],
                        'name' => $request['name']['name_' . $language['language_code']],
                        'summary' => $request['summary']['summary_' . $language['language_code']],
                        'criteria' => $request['criteria']['criteria_' . $language['language_code']]
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
            if ($language->is_default == 1) {
                $validationRule = array_merge($validationRule, ['name.name_' . $language->abbreviation => ['required', 'string']]);
                $errorMessages = array_merge($errorMessages, ['name.name_' . $language->abbreviation . '.required' => 'Name is required']);
                $validationRule = array_merge($validationRule, ['summary.summary_' . $language->abbreviation => ['required', 'string']]);
                $errorMessages = array_merge($errorMessages, ['summary.summary_' . $language->abbreviation . '.required' => 'Summary is required']);
                $validationRule = array_merge($validationRule, ['summary.summary_' . $language->abbreviation => ['required', 'string']]);
                $errorMessages = array_merge($errorMessages, ['criteria.criteria_' . $language->abbreviation . '.required' => 'Criteria is required']);
            }
        }
        $validationRule = array_merge($validationRule, ['province' => ['required', 'string']]);
        $errorMessages = array_merge($errorMessages, ['province' . '.required' => 'Department is required']);
        $validationRule = array_merge($validationRule, ['award' => ['required', 'string']]);
        $errorMessages = array_merge($errorMessages, ['award' . '.required' => 'Award is required']);
        $validationRule = array_merge($validationRule, ['amount' => ['required', 'string']]);
        $errorMessages = array_merge($errorMessages, ['amount' . '.required' => 'Amount is required']);
        $validationRule = array_merge($validationRule, ['action' => ['required', 'string']]);
        $errorMessages = array_merge($errorMessages, ['action' . '.required' => 'Action is required']);
        $validationRule = array_merge($validationRule, ['date_posted' => ['nullable', 'string']]);
        $errorMessages = array_merge($errorMessages, ['date_posted' . '.required' => 'Posted date is required']);
        $validationRule = array_merge($validationRule, ['expiry_date' => ['nullable', 'string']]);
        $errorMessages = array_merge($errorMessages, ['expiry_date' . '.required' => 'Expiry date is required']);
        $validationRule = array_merge($validationRule, ['deadline_date' => ['nullable', 'string']]);
        $errorMessages = array_merge($errorMessages, ['deadline_date' . '.required' => 'Deadline date is required']);
        $validationRule = array_merge($validationRule, ['availability' => ['required', 'string']]);
        $errorMessages = array_merge($errorMessages, ['availability' . '.required' => 'Availability is required']);
        $validationRule = array_merge($validationRule, ['study_level' => ['required', 'string']]);
        $errorMessages = array_merge($errorMessages, ['study_level' . '.required' => 'Study level is required']);
        $validationRule = array_merge($validationRule, ['duration' => ['required', 'string']]);
        $errorMessages = array_merge($errorMessages, ['duration' . '.required' => 'Duration is required']);
        $validationRule = array_merge($validationRule, ['link' => ['required', 'string']]);
        $errorMessages = array_merge($errorMessages, ['link' . '.required' => 'Link is required']);
        $validationRule = array_merge($validationRule, ['more_info_link' => ['required', 'string']]);
        $errorMessages = array_merge($errorMessages, ['more_info_link' . '.required' => 'Info link is required']);
        $validationRule = array_merge($validationRule, ['featured' => ['required']]);
        $errorMessages = array_merge($errorMessages, ['featured' . '.required' => 'Featured is required']);

        $this->validate(
            $request,
            $validationRule,
            $errorMessages
        );

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
            'customer_id' => $request->customer_id,
            'school_id' => $request->school_id,
        ]);
        foreach ($request->languages as $language) {
            if (
                !empty($request['name']['name_' . $language['language_code']])
            ) {
                $SchoolScholarshipDetail = SchoolScholarshipDetail::whereLanguageCode($language['language_code'])->whereSchoolScholarshipId($SchoolScholarship->id)->exists();
                if ($SchoolScholarshipDetail) {
                    SchoolScholarshipDetail::whereLanguageCode($language['language_code'])->whereSchoolScholarshipId($SchoolScholarship->id)->update([
                        'school_scholarship_id' => $SchoolScholarship->id,
                        'language_code' => $language['language_code'],
                        'name' => $request['name']['name_' . $language['language_code']],
                        'summary' => $request['summary']['summary_' . $language['language_code']],
                        'criteria' => $request['criteria']['criteria_' . $language['language_code']]
                    ]);
                } else {
                    SchoolScholarshipDetail::create([
                        'school_scholarship_id' => $SchoolScholarship->id,
                        'language_code' => $language['language_code'],
                        'name' => $request['name']['name_' . $language['language_code']],
                        'summary' => $request['summary']['summary_' . $language['language_code']],
                        'criteria' => $request['criteria']['criteria_' . $language['language_code']]
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
        if ($SchoolScholarship->SchoolScholarshipDetail()->delete() && $SchoolScholarship->delete()) {
            return $this->apiSuccessResponse(new SchoolScholarshipResource($SchoolScholarship), 'The selected item has been deleted successfully');
        }
        return $this->errorResponse();
    }

    protected function loadRelations($schoolScholarships)
    {
        $defaultLang = getDefaultLanguage();
        $schoolScholarships = $schoolScholarships->with(['schoolScholarshipDetail' => function ($q) use ($defaultLang) {
            $q->where('language_code', $defaultLang->abbreviation);
        }]);
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
            $schoolScholarships = $schoolScholarships->whereHas('schoolScholarshipDetail', function ($q) {
                $q->where('name', 'LIKE', '%' . $_GET['searchParam'] . '%');
            });
        }
        return $schoolScholarships;
    }
}
