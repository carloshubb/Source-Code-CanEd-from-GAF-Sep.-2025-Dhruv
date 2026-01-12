<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\SchoolTypeResource;
use Illuminate\Support\Str;
use App\Models\SchoolType;
use App\Models\SchoolTypeDetail;
use App\Models\Language;
use App\Rules\CheckCategorySlug;
use App\Traits\StatusResponser;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;

class SchoolTypeController extends Controller
{
    use StatusResponser;
    use FileUploadTrait;

    public function __construct()
    {
        $this->middleware('password_confirm')->only('destroy');
    }


    public function index()
    {
        $school_types = SchoolType::query();

        $school_types = $this->whereClause($school_types);
        $school_types = $this->loadRelations($school_types);
        $school_types = $this->sortingAndLimit($school_types);

        return $this->apiSuccessResponse(SchoolTypeResource::collection($school_types), 'Data Get Successfully!');
    }


    public function show(SchoolType $SchoolType)
    {
        if (isset($_GET['withSchoolTypeDetail']) && $_GET['withSchoolTypeDetail'] == '1') {
            $SchoolType = $SchoolType->loadMissing('SchoolTypeDetail');
        }

        return $this->apiSuccessResponse(new SchoolTypeResource($SchoolType), 'Data Get Successfully!');
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
            $errorMessages = array_merge($errorMessages, ['name.name_' . $language->id . '.required' => 'Name is required.']);
        }

        $this->validate(
            $request,
            $validationRule,
            $errorMessages
        );
        $SchoolType = SchoolType::create([]);


        if ($SchoolType) {
            foreach ($languages as $language) {
                SchoolTypeDetail::create([
                    'school_type_id' => $SchoolType->id,
                    'language_id' => $language->id,
                    'name' => $request['name']['name_' . $language->id],
                    'slug' => Str::slug($request['name']['name_' . $language->id]),
                ]);
            }
            return $this->apiSuccessResponse(new SchoolTypeResource($SchoolType), 'Your changes have been done successfully');
        }
        return $this->errorResponse();
    }


    public function update(Request $request, SchoolType $SchoolType)
    {
        $validationRule = [];
        $errorMessages = [];
        $languages = getAllLanguages();
        foreach ($languages as $language) {
            $requiredVal = 'nullable';
            if ($language->is_default == '1') {
                $requiredVal = 'required';
            }
            $validationRule = array_merge($validationRule, ['name.name_' . $language->id => [$requiredVal, 'string', new CheckCategorySlug($language, $SchoolType->id)]]);
            $errorMessages = array_merge($errorMessages, ['name.name_' . $language->id . '.required' => 'Name in ' . $language->name . ' is required.']);
        }

        $this->validate(
            $request,
            $validationRule,
            $errorMessages
        );
        $SchoolType->update([]);
        foreach ($languages as $language) {
            $SchoolTypeDetail = SchoolTypeDetail::whereLanguageId($language->id)->whereSchoolTypeId($SchoolType->id)->exists();
            if ($SchoolTypeDetail) {
                SchoolTypeDetail::whereLanguageId($language->id)->whereSchoolTypeId($SchoolType->id)->update([
                    'name' => $request['name']['name_' . $language->id],
                    'slug' => Str::slug($request['name']['name_' . $language->id]),
                ]);
            } else {
                SchoolTypeDetail::create([
                    'school_type_id' => $SchoolType->id,
                    'language_id' => $language->id,
                    'name' => $request['name']['name_' . $language->id],
                    'slug' => Str::slug($request['name']['name_' . $language->id]),
                ]);
            }
        }

        if ($SchoolType) {
            return $this->apiSuccessResponse(new SchoolTypeResource($SchoolType), 'Your changes have been done successfully');
        }
        return $this->errorResponse();
    }


    public function destroy(Request $request, SchoolType $SchoolType)
    {
        if ($SchoolType->SchoolTypeDetail()->delete() && $SchoolType->delete()) {
            return $this->apiSuccessResponse(new SchoolTypeResource($SchoolType), 'The selected item has been deleted successfully');
        }
        return $this->errorResponse();
    }

    protected function loadRelations($school_types)
    {
        $defaultLang = getDefaultLanguage();
        $school_types = $school_types->with(['SchoolTypeDetail' => function ($q) use ($defaultLang) {
            $q->where('language_id', $defaultLang->id);
        }]);
        if (isset($_GET['withSchoolTypeDetail']) && $_GET['withSchoolTypeDetail'] == '1') {
            $school_types = $school_types->with('SchoolTypeDetail');
        }
        return $school_types;
    }

    protected function sortingAndLimit($school_types)
    {
        $sortType = ['ASC', 'asc', 'DESC', 'desc'];
        $sortBy = ['id', 'school_type_name'];
        if (isset($_GET['sortBy']) && $_GET['sortBy'] != '' && isset($_GET['sortType']) && $_GET['sortType'] != '' && in_array($_GET['sortBy'], $sortBy) && in_array($_GET['sortType'], $sortType)) {
            $defaultLang = getDefaultLanguage();
            $school_types = $school_types->addSelect(['school_type_name' => SchoolTypeDetail::whereColumn('school_types.id', 'school_type_details.school_type_id')->whereLanguageId($defaultLang->id)->select('name')->limit(1)]);


            $school_types = $school_types->OrderBy($_GET['sortBy'], $_GET['sortType']);
        }

        if (isset($_GET['limit']) && $_GET['limit'] != '') {
            $limit = $_GET['limit'];
        } else {
            $limit = 10;
        }

        return $school_types->paginate($limit);
    }

    protected function whereClause($school_types)
    {
        if (isset($_GET['searchParam']) && $_GET['searchParam'] != '') {
            $school_types = $school_types->whereHas('SchoolTypeDetail', function ($q) {
                $q->where('name', 'LIKE', '%' . $_GET['searchParam'] . '%');
            });
        }
        return $school_types;
    }
}
