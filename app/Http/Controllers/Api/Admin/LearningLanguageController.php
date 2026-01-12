<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\LearningLanguageResource;
use Illuminate\Support\Str;
use App\Models\LearningLanguage;
use App\Models\LearningLanguageDetail;
use App\Models\Language;
use App\Rules\CheckCategorySlug;
use App\Traits\StatusResponser;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;

class LearningLanguageController extends Controller
{
    use StatusResponser;
    use FileUploadTrait;

    public function __construct()
    {
        $this->middleware('password_confirm')->only('destroy');
    }

    public function index()
    {
        $learningLanguages = LearningLanguage::query();

        $learningLanguages = $this->whereClause($learningLanguages);
        $learningLanguages = $this->loadRelations($learningLanguages);
        $learningLanguages = $this->sortingAndLimit($learningLanguages);
       
        return $this->apiSuccessResponse(LearningLanguageResource::collection($learningLanguages), 'Data Get Successfully!');
    }

    public function show(LearningLanguage $LearningLanguage)
    {
        if (isset($_GET['withLearningLanguageDetail']) && $_GET['withLearningLanguageDetail'] == '1') {
            $LearningLanguage = $LearningLanguage->loadMissing('learningLanguageDetail');
        }

        return $this->apiSuccessResponse(new LearningLanguageResource($LearningLanguage), 'Data Get Successfully!');
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
        $validationRule = array_merge($validationRule, ['status' => ['required']]);
        $errorMessages = array_merge($errorMessages, ['status.required' => 'Status is required']);
        $this->validate($request, $validationRule, $errorMessages);
        $LearningLanguage = LearningLanguage::create([
            'status' => $request->status,
        ]);

        if ($LearningLanguage) {
            foreach ($languages as $language) {
                LearningLanguageDetail::create([
                    'learning_language_id' => $LearningLanguage->id,
                    'language_id' => $language->id,
                    'name' => $request['name']['name_' . $language->id] ?? null,
                ]);
            }
            return $this->apiSuccessResponse(new LearningLanguageResource($LearningLanguage), 'Your changes have been done successfully');
        }
        return $this->errorResponse();
    }

    public function update(Request $request, LearningLanguage $LearningLanguage)
    {
        $validationRule = [];
        $errorMessages = [];
        $languages = getAllLanguages();
        foreach ($languages as $language) {
            $requiredVal = 'nullable';
            if ($language->is_default == '1') {
                $requiredVal = 'required';
            }
            $validationRule = array_merge($validationRule, ['name.name_' . $language->id => [$requiredVal, 'string', new CheckCategorySlug($language, $LearningLanguage->id)]]);
            $errorMessages = array_merge($errorMessages, ['name.name_' . $language->id . '.required' => 'Name is required.']);
        }
        $validationRule = array_merge($validationRule, ['status' => ['required']]);
        $errorMessages = array_merge($errorMessages, ['status.required' => 'this field is required.']);
        $this->validate($request, $validationRule, $errorMessages);

        $LearningLanguage->update([
            'status' => $request->status,
        ]);
        foreach ($languages as $language) {
            $LearningLanguageDetail = LearningLanguageDetail::whereLanguageId($language->id)
                ->whereLearningLanguageId($LearningLanguage->id)
                ->exists();
            if ($LearningLanguageDetail) {
                LearningLanguageDetail::whereLanguageId($language->id)
                    ->whereLearningLanguageId($LearningLanguage->id)
                    ->update([
                        'learning_language_id' => $LearningLanguage->id,
                        'language_id' => $language->id,
                        'name' => $request['name']['name_' . $language->id] ?? null,
                    ]);
            } else {
                LearningLanguageDetail::create([
                    'learning_language_id' => $LearningLanguage->id,
                    'language_id' => $language->id,
                    'name' => $request['name']['name_' . $language->id] ?? null,
                ]);
            }
        }

        if ($LearningLanguage) {
            return $this->apiSuccessResponse(new LearningLanguageResource($LearningLanguage), 'Your changes have been done successfully');
        }
        return $this->errorResponse();
    }

    public function destroy(Request $request, LearningLanguage $LearningLanguage)
    {
        if ($LearningLanguage->LearningLanguageDetail()->delete() && $LearningLanguage->delete()) {
            return $this->apiSuccessResponse(new LearningLanguageResource($LearningLanguage), 'The selected item has been deleted successfully');
        }
        return $this->errorResponse();
    }

    protected function loadRelations($learningLanguages)
    {
        $defaultLang = getDefaultLanguage();
        $learningLanguages = $learningLanguages->with([
            'learningLanguageDetail' => function ($q) use ($defaultLang) {
                $q->where('language_id', $defaultLang->id);
            },
        ]);
        if (isset($_GET['withLearningLanguageDetail']) && $_GET['withLearningLanguageDetail'] == '1') {
            $learningLanguages = $learningLanguages->with('learningLanguageDetail');
        }
        return $learningLanguages;
    }

    protected function sortingAndLimit($learningLanguages)
    {
        $sortType = ['ASC', 'asc', 'DESC', 'desc'];
        $sortBy = ['id', 'learning_language_name'];
        if (isset($_GET['sortBy']) && $_GET['sortBy'] != '' && isset($_GET['sortType']) && $_GET['sortType'] != '' && in_array($_GET['sortBy'], $sortBy) && in_array($_GET['sortType'], $sortType)) {
            $defaultLang = getDefaultLanguage();
            $learningLanguages = $learningLanguages->addSelect(['learning_language_name' => LearningLanguageDetail::whereColumn('learning_languages.id', 'learning_language_details.learning_language_id')->whereLanguageId($defaultLang->id)->select('name')->limit(1)]);

            $learningLanguages = $learningLanguages->OrderBy($_GET['sortBy'], $_GET['sortType']);
        }

        if (isset($_GET['limit']) && $_GET['limit'] != '') {
            $limit = $_GET['limit'];
        } else {
            $limit = 10;
        }

        return $learningLanguages->paginate($limit);
    }

    protected function whereClause($learningLanguages)
    {
        if (isset($_GET['searchParam']) && $_GET['searchParam'] != '') {
            $learningLanguages = $learningLanguages->whereHas('learningLanguageDetail', function ($q) {
                $q->where('name', 'LIKE', '%' . $_GET['searchParam'] . '%');
            });
        }
        return $learningLanguages;
    }

    public function saveDefaultLanguageLearningLanguage(Request $request){
        $language = getDefaultLanguage();
        $LearningLanguage = LearningLanguage::create([
            'status' => 0,
        ]);
        if ($LearningLanguage) {
            LearningLanguageDetail::create([
                'learning_language_id' => $LearningLanguage->id,
                'language_id' => $language->id,
                'name' => $request->name,
            ]);
            return $this->apiSuccessResponse(new LearningLanguageResource($LearningLanguage), 'Your changes have been done successfully');
        }
        return $this->errorResponse();
    }
    
}
