<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\CurricularActivityResource;
use Illuminate\Support\Str;
use App\Models\CurricularActivity;
use App\Models\CurricularActivityDetail;
use App\Models\Language;
use App\Rules\CheckCategorySlug;
use App\Traits\StatusResponser;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;

class CurricularActivityController extends Controller
{
    use StatusResponser;
    use FileUploadTrait;

    public function __construct()
    {
        $this->middleware('password_confirm')->only('destroy');
    }

    public function index()
    {
        $curricular = CurricularActivity::query();

        $curricular = $this->whereClause($curricular);
        $curricular = $this->loadRelations($curricular);
        $curricular = $this->sortingAndLimit($curricular);

        return $this->apiSuccessResponse(CurricularActivityResource::collection($curricular), 'Data Get Successfully!');
    }

    public function show(CurricularActivity $Curricular)
    {
        if (isset($_GET['withCurricularActivityDetail']) && $_GET['withCurricularActivityDetail'] == '1') {
            $Curricular = $Curricular->loadMissing('curricularActivityDetail');
        }

        return $this->apiSuccessResponse(new CurricularActivityResource($Curricular), 'Data Get Successfully!');
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
            $validationRule = array_merge($validationRule, ['name.name_' . $language->id => [$requiredVal, 'string', new CheckCategorySlug($language, null)]]);
            $errorMessages = array_merge($errorMessages, ['name.name_' . $language->id . '.required' => 'Sport name is required']);
        }
        $validationRule = array_merge($validationRule, ['status' => ['required']]);
        $errorMessages = array_merge($errorMessages, ['status.required' => 'Status is required']);
        $this->validate($request, $validationRule, $errorMessages);
        $Curricular = CurricularActivity::create([
            'status' => $request->status,
        ]);

        if ($Curricular) {
            foreach ($languages as $language) {
                CurricularActivityDetail::create([
                    'curricular_id' => $Curricular->id,
                    'language_id' => $language->id,
                    'name' => $request['name']['name_' . $language->id] ?? null,
                ]);
            }
            return $this->apiSuccessResponse(new CurricularActivityResource($Curricular), 'Your changes have been done successfully');
        }
        return $this->errorResponse();
    }

    public function update(Request $request, CurricularActivity $Curricular)
    {
        $validationRule = [];
        $errorMessages = [];
        $languages = getAllLanguages();
        foreach ($languages as $language) {
            $requiredVal = 'nullable';
            if ($language->is_default == '1') {
                $requiredVal = 'required';
            }
            $validationRule = array_merge($validationRule, ['name.name_' . $language->id => [$requiredVal, 'string', new CheckCategorySlug($language, $Curricular->id)]]);
            $errorMessages = array_merge($errorMessages, ['name.name_' . $language->id . '.required' => 'Sport name is required']);
        }
        $validationRule = array_merge($validationRule, ['status' => ['required']]);
        $errorMessages = array_merge($errorMessages, ['status.required' => 'Status is required']);
        $this->validate($request, $validationRule, $errorMessages);

        $Curricular->update([
            'status' => $request->status,
        ]);
        foreach ($languages as $language) {
            $CurricularDetail = CurricularActivityDetail::whereLanguageId($language->id)
                ->whereCurricularId($Curricular->id)
                ->exists();
            if ($CurricularDetail) {
                CurricularActivityDetail::whereLanguageId($language->id)
                    ->whereCurricularId($Curricular->id)
                    ->update([
                        'curricular_id' => $Curricular->id,
                        'language_id' => $language->id,
                        'name' => $request['name']['name_' . $language->id] ?? null,
                    ]);
            } else {
                CurricularActivityDetail::create([
                    'curricular_id' => $Curricular->id,
                    'language_id' => $language->id,
                    'name' => $request['name']['name_' . $language->id] ?? null,
                ]);
            }
        }

        if ($Curricular) {
            return $this->apiSuccessResponse(new CurricularActivityResource($Curricular), 'Your changes have been done successfully');
        }
        return $this->errorResponse();
    }

    public function destroy(Request $request, CurricularActivity $Curricular)
    {
        if ($Curricular->CurricularActivityDetail()->delete() && $Curricular->delete()) {
            return $this->apiSuccessResponse(new CurricularActivityResource($Curricular), 'The selected item has been deleted successfully');
        }
        return $this->errorResponse();
    }

    protected function loadRelations($curricular)
    {
        $defaultLang = getDefaultLanguage();
        $curricular = $curricular->with([
            'curricularActivityDetail' => function ($q) use ($defaultLang) {
                $q->where('language_id', $defaultLang->id);
            },
        ]);
        if (isset($_GET['withCurricularActivityDetail']) && $_GET['withCurricularActivityDetail'] == '1') {
            $curricular = $curricular->with('curricularActivityDetail');
        }
        return $curricular;
    }

    protected function sortingAndLimit($curricular)
    {
        $sortType = ['ASC', 'asc', 'DESC', 'desc'];
        $sortBy = ['id', 'activity_name'];
        if (isset($_GET['sortBy']) && $_GET['sortBy'] != '' && isset($_GET['sortType']) && $_GET['sortType'] != '' && in_array($_GET['sortBy'], $sortBy) && in_array($_GET['sortType'], $sortType)) {
            $defaultLang = getDefaultLanguage();
            $curricular = $curricular->addSelect(['activity_name' => CurricularActivityDetail::whereColumn('curricular_activities.id', 'curricular_activity_details.curricular_id')->whereLanguageId($defaultLang->id)->select('name')->limit(1)]);

            $curricular = $curricular->OrderBy($_GET['sortBy'], $_GET['sortType']);
        }

        if (isset($_GET['limit']) && $_GET['limit'] != '') {
            $limit = $_GET['limit'];
        } else {
            $limit = 10;
        }

        return $curricular->paginate($limit);
    }

    protected function whereClause($curricular)
    {
        if (isset($_GET['searchParam']) && $_GET['searchParam'] != '') {
            $curricular = $curricular->whereHas('curricularActivityDetail', function ($q) {
                $q->where('name', 'LIKE', '%' . $_GET['searchParam'] . '%');
            });
        }
        return $curricular;
    }

    public function saveDefaultLanguageCurriculum(Request $request)
    {
        $language = getDefaultLanguage();
        $Curricular = CurricularActivity::create([
            'status' => 0,
        ]);
        if ($Curricular) {
            CurricularActivityDetail::create([
                'curricular_id' => $Curricular->id,
                'language_id' => $language->id,
                'name' => $request->name,
            ]);
            return $this->apiSuccessResponse(new CurricularActivityResource($Curricular), 'Your changes have been done successfully');
        }
        return $this->errorResponse();
    }
}
