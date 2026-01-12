<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\TestResource;
use Illuminate\Support\Str;
use App\Models\Test;
use App\Models\TestDetail;
use App\Models\Language;
use App\Rules\CheckCategorySlug;
use App\Traits\StatusResponser;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;

class TestController extends Controller
{
    use StatusResponser;
    use FileUploadTrait;

    public function __construct()
    {
        $this->middleware('password_confirm')->only('destroy');
    }

    public function index()
    {
        $Tests = Test::query();

        $Tests = $this->whereClause($Tests);
        $Tests = $this->loadRelations($Tests);
        $Tests = $this->sortingAndLimit($Tests);

        return $this->apiSuccessResponse(TestResource::collection($Tests), 'Data Get Successfully!');
    }

    public function show(Test $Test)
    {
        if (isset($_GET['withTestDetail']) && $_GET['withTestDetail'] == '1') {
            $Test = $Test->loadMissing('testDetail');
        }

        return $this->apiSuccessResponse(new TestResource($Test), 'Data Get Successfully!');
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
            $errorMessages = array_merge($errorMessages, ['name.name_' . $language->id . '.required' => 'Name is required']);
        }

        $this->validate($request, $validationRule, $errorMessages);
        $Test = Test::create([]);

        if ($Test) {
            foreach ($languages as $language) {
                TestDetail::create([
                    'test_id' => $Test->id,
                    'language_id' => $language->id,
                    'name' => $request['name']['name_' . $language->id],
                ]);
            }
            return $this->apiSuccessResponse(new TestResource($Test), 'Your changes have been done successfully');
        }
        return $this->errorResponse();
    }

    public function update(Request $request, Test $Test)
    {
        $validationRule = [];
        $errorMessages = [];
        $languages = getAllLanguages();
        foreach ($languages as $language) {
            $requiredVal = 'nullable';
            if ($language->is_default == '1') {
                $requiredVal = 'required';
            }
            $validationRule = array_merge($validationRule, ['name.name_' . $language->id => [$requiredVal, 'string', new CheckCategorySlug($language, $Test->id)]]);
            $errorMessages = array_merge($errorMessages, ['name.name_' . $language->id . '.required' => 'Name is required']);
        }
        $this->validate($request, $validationRule, $errorMessages);
        foreach ($languages as $language) {
            $TestDetail = TestDetail::whereLanguageId($language->id)
                ->whereTestId($Test->id)
                ->exists();
            if ($TestDetail) {
                TestDetail::whereLanguageId($language->id)
                    ->whereTestId($Test->id)
                    ->update([
                        'name' => $request['name']['name_' . $language->id],
                    ]);
            } else {
                TestDetail::create([
                    'test_id' => $Test->id,
                    'language_id' => $language->id,
                    'name' => $request['name']['name_' . $language->id],
                ]);
            }
        }

        if ($Test) {
            return $this->apiSuccessResponse(new TestResource($Test), 'Your changes have been done successfully');
        }
        return $this->errorResponse();
    }

    public function destroy(Request $request, Test $Test)
    {
        if ($Test->TestDetail()->delete() && $Test->delete()) {
            return $this->apiSuccessResponse(new TestResource($Test), 'The selected item has been deleted successfully');
        }
        return $this->errorResponse();
    }

    protected function loadRelations($Tests)
    {
        $defaultLang = getDefaultLanguage();
        $Tests = $Tests->with([
            'testDetail' => function ($q) use ($defaultLang) {
                $q->where('language_id', $defaultLang->id);
            },
        ]);
        if (isset($_GET['withTestDetail']) && $_GET['withTestDetail'] == '1') {
            $Tests = $Tests->with('testDetail');
        }
        return $Tests;
    }

    protected function sortingAndLimit($Tests)
    {
        $sortType = ['ASC', 'asc', 'DESC', 'desc'];
        $sortBy = ['id', 'name', 'abbreviation', 'test_name'];
        if (isset($_GET['sortBy']) && $_GET['sortBy'] != '' && isset($_GET['sortType']) && $_GET['sortType'] != '' && in_array($_GET['sortBy'], $sortBy) && in_array($_GET['sortType'], $sortType)) {
            $defaultLang = getDefaultLanguage();
            $Tests = $Tests->addSelect(['test_name' => TestDetail::whereColumn('tests.id', 'test_details.test_id')->whereLanguageId($defaultLang->id)->select('name')->limit(1)]);


            $Tests = $Tests->OrderBy($_GET['sortBy'], $_GET['sortType']);
        }

        if (isset($_GET['limit']) && $_GET['limit'] != '') {
            $limit = $_GET['limit'];
        } else {
            $limit = 10;
        }

        return $Tests->paginate($limit);
    }

    protected function whereClause($Tests)
    {
        if (isset($_GET['searchParam']) && $_GET['searchParam'] != '') {
            $Tests = $Tests->whereHas('testDetail', function ($q) {
                $q->where('name', 'LIKE', '%' . $_GET['searchParam'] . '%');
            });
        }
        return $Tests;
    }
}
