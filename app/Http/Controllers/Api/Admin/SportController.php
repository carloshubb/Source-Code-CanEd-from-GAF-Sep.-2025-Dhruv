<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\SportResource;
use Illuminate\Support\Str;
use App\Models\Sport;
use App\Models\SportDetail;
use App\Models\Language;
use App\Rules\CheckCategorySlug;
use App\Traits\StatusResponser;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;

class SportController extends Controller
{
    use StatusResponser;
    use FileUploadTrait;

    public function __construct()
    {
        $this->middleware('password_confirm')->only('destroy');
    }

    public function index()
    {
        $sports = Sport::query();

        $sports = $this->whereClause($sports);
        $sports = $this->loadRelations($sports);
        $sports = $this->sortingAndLimit($sports);

        return $this->apiSuccessResponse(SportResource::collection($sports), 'Data Get Successfully!');
    }

    public function show(Sport $Sport)
    {
        if (isset($_GET['withSportDetail']) && $_GET['withSportDetail'] == '1') {
            $Sport = $Sport->loadMissing('sportDetail');
        }

        return $this->apiSuccessResponse(new SportResource($Sport), 'Data Get Successfully!');
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
        $Sport = Sport::create([
            'status' => $request->status,
        ]);

        if ($Sport) {
            foreach ($languages as $language) {
                SportDetail::create([
                    'sport_id' => $Sport->id,
                    'language_id' => $language->id,
                    'name' => $request['name']['name_' . $language->id] ?? null,
                ]);
            }
            return $this->apiSuccessResponse(new SportResource($Sport), 'Your changes have been done successfully');
        }
        return $this->errorResponse();
    }

    public function update(Request $request, Sport $Sport)
    {
        $validationRule = [];
        $errorMessages = [];
        $languages = getAllLanguages();
        foreach ($languages as $language) {
            $requiredVal = 'nullable';
            if ($language->is_default == '1') {
                $requiredVal = 'required';
            }
            $validationRule = array_merge($validationRule, ['name.name_' . $language->id => [$requiredVal, 'string', new CheckCategorySlug($language, $Sport->id)]]);
            $errorMessages = array_merge($errorMessages, ['name.name_' . $language->id . '.required' => 'Sport name is required']);
        }
        $validationRule = array_merge($validationRule, ['status' => ['required']]);
        $errorMessages = array_merge($errorMessages, ['status.required' => 'Status is required']);
        $this->validate($request, $validationRule, $errorMessages);

        $Sport->update([
            'status' => $request->status,
        ]);
        foreach ($languages as $language) {
            $SportDetail = SportDetail::whereLanguageId($language->id)
                ->whereSportId($Sport->id)
                ->exists();
            if ($SportDetail) {
                SportDetail::whereLanguageId($language->id)
                    ->whereSportId($Sport->id)
                    ->update([
                        'sport_id' => $Sport->id,
                        'language_id' => $language->id,
                        'name' => $request['name']['name_' . $language->id] ?? null,
                    ]);
            } else {
                SportDetail::create([
                    'sport_id' => $Sport->id,
                    'language_id' => $language->id,
                    'name' => $request['name']['name_' . $language->id] ?? null,
                ]);
            }
        }

        if ($Sport) {
            return $this->apiSuccessResponse(new SportResource($Sport), 'Your changes have been done successfully');
        }
        return $this->errorResponse();
    }

    public function destroy(Request $request, Sport $Sport)
    {
        if ($Sport->SportDetail()->delete() && $Sport->delete()) {
            return $this->apiSuccessResponse(new SportResource($Sport), 'The selected item has been deleted successfully');
        }
        return $this->errorResponse();
    }

    protected function loadRelations($sports)
    {
        $defaultLang = getDefaultLanguage();
        $sports = $sports->with([
            'sportDetail' => function ($q) use ($defaultLang) {
                $q->where('language_id', $defaultLang->id);
            },
        ]);
        if (isset($_GET['withSportDetail']) && $_GET['withSportDetail'] == '1') {
            $sports = $sports->with('sportDetail');
        }
        return $sports;
    }

    protected function sortingAndLimit($sports)
    {
        $sortType = ['ASC', 'asc', 'DESC', 'desc'];
        $sortBy = ['id', 'sport_name'];
        if (isset($_GET['sortBy']) && $_GET['sortBy'] != '' && isset($_GET['sortType']) && $_GET['sortType'] != '' && in_array($_GET['sortBy'], $sortBy) && in_array($_GET['sortType'], $sortType)) {
            $defaultLang = getDefaultLanguage();
            $sports = $sports->addSelect(['sport_name' => SportDetail::whereColumn('sports.id', 'sport_details.sport_id')->whereLanguageId($defaultLang->id)->select('name')->limit(1)]);

            $sports = $sports->OrderBy($_GET['sortBy'], $_GET['sortType']);
        }

        if (isset($_GET['limit']) && $_GET['limit'] != '') {
            $limit = $_GET['limit'];
        } else {
            $limit = 10;
        }

        return $sports->paginate($limit);
    }

    protected function whereClause($sports)
    {
        if (isset($_GET['searchParam']) && $_GET['searchParam'] != '') {
            $sports = $sports->whereHas('sportDetail', function ($q) {
                $q->where('name', 'LIKE', '%' . $_GET['searchParam'] . '%');
            });
        }
        return $sports;
    }

    public function saveDefaultLanguageSport(Request $request)
    {
        $language = getDefaultLanguage();
        $Sport = Sport::create([
            'status' => 0,
        ]);
        if ($Sport) {
            SportDetail::create([
                'sport_id' => $Sport->id,
                'language_id' => $language->id,
                'name' => $request->name,
            ]);
            return $this->apiSuccessResponse(new SportResource($Sport), 'Your changes have been done successfully');
        }
        return $this->errorResponse();
    }
}
