<?php

namespace App\Http\Controllers\Api\Web;

use App\Http\Controllers\Controller;
use App\Http\Resources\Web\OverviewProgramResource;
use Illuminate\Support\Str;
use App\Models\OverviewProgram;
use App\Models\OverviewProgramDetail;
use App\Traits\StatusResponser;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;

class OverviewProgramController extends Controller
{
    use StatusResponser;
    use FileUploadTrait;

    public function __construct()
    {
        $this->middleware('password_confirm')->only('destroy');
    }

    public function index()
    {
        $overviewProgram = OverviewProgram::where('school_overviews_id',$_GET['school_overviews_id']);
        $overviewProgram = $this->whereClause($overviewProgram);
        $overviewProgram = $this->loadRelations($overviewProgram);
        $overviewProgram = $this->sortingAndLimit($overviewProgram);

        return $this->apiSuccessResponse(OverviewProgramResource::collection($overviewProgram), 'Data Get Successfully!');
    }

    public function show(OverviewProgram $OverviewProgram)
    {
        if (isset($_GET['withOverviewProgramDetail']) && $_GET['withOverviewProgramDetail'] == '1') {
            $OverviewProgram = $OverviewProgram->loadMissing('OverviewProgramDetail');
        }

        return $this->apiSuccessResponse(newOverviewProgramResource($OverviewProgram), 'Data Get Successfully!');
    }

    public function store(Request $request)
    {
        $validationRule = [];
        $errorMessages = [];
        $languages = getAllLanguages();
        foreach ($languages as $language) {
            if ($language->is_default == 1) {
                $validationRule = array_merge($validationRule, ['name.name_' . $language->abbreviation => ['required', 'string']]);
                $errorMessages = array_merge($errorMessages, ['name.name_' . $language->abbreviation . '.required' => 'Name is required.']);
            }
        }
        $validationRule = array_merge($validationRule, ['length' => ['required', 'string']]);
        $errorMessages = array_merge($errorMessages, ['length' . '.required' => 'This field is required']);
        $validationRule = array_merge($validationRule, ['tuition_inter_stu_fee' => ['required', 'string']]);
        $errorMessages = array_merge($errorMessages, ['tuition_inter_stu_fee' . '.required' => 'This field is required']);

        $validationRule = array_merge($validationRule, ['tuition_can_stu_fee' => ['required', 'string']]);
        $errorMessages = array_merge($errorMessages, ['tuition_can_stu_fee' . '.required' => 'This field is required']);
        $validationRule = array_merge($validationRule, ['tuition_prov_stu_fee' => ['required', 'string']]);
        $errorMessages = array_merge($errorMessages, ['tuition_prov_stu_fee' . '.required' => 'This field is required']);

        $this->validate($request, $validationRule, $errorMessages);

        $OverviewProgram = OverviewProgram::create([
            'length' => $request->length,
            'tuition_inter_stu_fee' => $request->tuition_inter_stu_fee,
            'tuition_can_stu_fee' => $request->tuition_can_stu_fee,
            'tuition_prov_stu_fee' => $request->tuition_prov_stu_fee,
            'school_overviews_id' => $request->school_overviews_id,
        ]);

        if ($OverviewProgram) {
            foreach ($request->languages as $language) {
                if (!empty($request['name']['name_' . $language['language_code']])) {
                    OverviewProgramDetail::create([
                        'overview_program_id' => $OverviewProgram->id,
                        'language_code' => $language['language_code'],
                        'name' => $request['name']['name_' . $language['language_code']],
                    ]);
                }
            }
            return $this->apiSuccessResponse(new OverviewProgramResource($OverviewProgram), 'Your changes have been done successfully');
        }
        return $this->errorResponse();
    }

    public function update(Request $request, OverviewProgram $OverviewProgram)
    {
        $validationRule = [];
        $errorMessages = [];
        $languages = getAllLanguages();
        foreach ($languages as $language) {
            if ($language->is_default == 1) {
                $validationRule = array_merge($validationRule, ['name.name_' . $language->abbreviation => ['required', 'string']]);
                $errorMessages = array_merge($errorMessages, ['name.name_' . $language->abbreviation . '.required' => 'Name is required']);
            }
        }
        $validationRule = array_merge($validationRule, ['length' => ['required', 'string']]);
        $errorMessages = array_merge($errorMessages, ['length' . '.required' => 'This field is required']);
        $validationRule = array_merge($validationRule, ['tuition_inter_stu_fee' => ['required', 'string']]);
        $errorMessages = array_merge($errorMessages, ['tuition_inter_stu_fee' . '.required' => 'This field is required']);

        $validationRule = array_merge($validationRule, ['tuition_can_stu_fee' => ['required', 'string']]);
        $errorMessages = array_merge($errorMessages, ['tuition_can_stu_fee' . '.required' => 'This field is required']);
        $validationRule = array_merge($validationRule, ['tuition_prov_stu_fee' => ['required', 'string']]);
        $errorMessages = array_merge($errorMessages, ['tuition_prov_stu_fee' . '.required' => 'This field is required']);

        $this->validate($request, $validationRule, $errorMessages);

        $OverviewProgram->update([
            'length' => $request->length,
            'tuition_inter_stu_fee' => $request->tuition_inter_stu_fee,
            'tuition_can_stu_fee' => $request->tuition_can_stu_fee,
            'tuition_prov_stu_fee' => $request->tuition_prov_stu_fee,
            'school_overviews_id' => $request->school_overviews_id,
        ]);
        foreach ($request->languages as $language) {
            if (!empty($request['name']['name_' . $language['language_code']])) {
                $OverviewProgramDetail = OverviewProgramDetail::whereLanguageCode($language['language_code'])
                    ->whereOverviewProgramId($OverviewProgram->id)
                    ->exists();
                if ($OverviewProgramDetail) {
                    OverviewProgramDetail::whereLanguageCode($language['language_code'])
                        ->whereOverviewProgramId($OverviewProgram->id)
                        ->update([
                            'overview_program_id' => $OverviewProgram->id,
                            'language_code' => $language['language_code'],
                            'name' => $request['name']['name_' . $language['language_code']],
                        ]);
                } else {
                    OverviewProgramDetail::create([
                        'overview_program_id' => $OverviewProgram->id,
                        'language_code' => $language['language_code'],
                        'name' => $request['name']['name_' . $language['language_code']],
                    ]);
                }
            }
        }

        if ($OverviewProgram) {
            return $this->apiSuccessResponse(new OverviewProgramResource($OverviewProgram), 'Your changes have been done successfully');
        }
        return $this->errorResponse();
    }

    public function destroy(Request $request, OverviewProgram $OverviewProgram)
    {
        if ($OverviewProgram->OverviewProgramDetail()->delete() && $OverviewProgram->delete()) {
            return $this->apiSuccessResponse(new OverviewProgramResource($OverviewProgram), 'The selected item has been deleted successfully');
        }
        return $this->errorResponse();
    }

    protected function loadRelations($overviewProgram)
    {
        $defaultLang = getDefaultLanguage();
        $overviewProgram = $overviewProgram->with([
            'overviewProgramDetail' => function ($q) use ($defaultLang) {
                $q->where('language_code', $defaultLang->abbreviation);
            },
        ]);
        if (isset($_GET['withOverviewProgramDetail']) && $_GET['withOverviewProgramDetail'] == '1') {
            $overviewProgram = $overviewProgram->with('OverviewProgramDetail');
        }
        return $overviewProgram;
    }

    protected function sortingAndLimit($overviewProgram)
    {
        $sortType = ['ASC', 'asc', 'DESC', 'desc'];
        $sortBy = ['id'];
        if (isset($_GET['sortBy']) && $_GET['sortBy'] != '' && isset($_GET['sortType']) && $_GET['sortType'] != '' && in_array($_GET['sortBy'], $sortBy) && in_array($_GET['sortType'], $sortType)) {
            $overviewProgram = $overviewProgram->OrderBy($_GET['sortBy'], $_GET['sortType']);
        }

        if (isset($_GET['limit']) && $_GET['limit'] != '') {
            $limit = $_GET['limit'];
        } else {
            $limit = 10;
        }

        return $overviewProgram->paginate($limit);
    }

    protected function whereClause($overviewProgram)
    {
        if (isset($_GET['searchParam']) && $_GET['searchParam'] != '') {
            $overviewProgram = $overviewProgram->whereHas('overviewProgramDetail', function ($q) {
                $q->where('name', 'LIKE', '%' . $_GET['searchParam'] . '%');
            });
        }
        return $overviewProgram;
    }
}
