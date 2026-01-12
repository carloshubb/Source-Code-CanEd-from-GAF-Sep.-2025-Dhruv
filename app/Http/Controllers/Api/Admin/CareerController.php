<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\CareerResource;
use Illuminate\Support\Str;
use App\Models\Career;
use App\Models\CareerDetail;
use App\Models\Language;
use App\Rules\CheckCategorySlug;
use App\Traits\StatusResponser;
use Illuminate\Http\Request;

class CareerController extends Controller
{
    use StatusResponser;

    public function __construct()
    {
        $this->middleware('password_confirm')->only('destroy');
    }


    public function index()
    {
        $article_categorys = Career::query();

        $article_categorys = $this->whereClause($article_categorys);
        $article_categorys = $this->loadRelations($article_categorys);
        $article_categorys = $this->sortingAndLimit($article_categorys);

        return $this->apiSuccessResponse(CareerResource::collection($article_categorys), 'Data Get Successfully!');
    }


    public function show(Career $Career)
    {
        if (isset($_GET['withCareerDetail']) && $_GET['withCareerDetail'] == '1') {
            $Career = $Career->loadMissing('careerDetail');
        }

        return $this->apiSuccessResponse(new CareerResource($Career), 'Data Get Successfully!');
    }


    // public function store(Request $request)
    // {

    //     $validationRule = [];
    //     $errorMessages = [];
    //     $languages = getAllLanguages();
    //     foreach ($languages as $language) {
    //         $requiredVal = 'nullable';
    //         if ($language->is_default == '1') {
    //             $requiredVal = 'required';
    //         }
    //         // $validationRule = array_merge($validationRule, ['level.level_' . $language->id => [$requiredVal, 'string', new CheckCategorySlug($language, null)]]);
    //         // $errorMessages = array_merge($errorMessages, ['level.level_' . $language->id . '.required' => 'Level is required.']);
    //         // $validationRule = array_merge($validationRule, ['h_structure.h_structure_' . $language->id => [$requiredVal, 'string', new CheckCategorySlug($language, null)]]);
    //         // $errorMessages = array_merge($errorMessages, ['h_structure.h_structure_' . $language->id . '.required' => 'herarchial Structure is required.']);
    //         // $validationRule = array_merge($validationRule, ['code.code_' . $language->id => [$requiredVal, 'string', new CheckCategorySlug($language, null)]]);
    //         // $errorMessages = array_merge($errorMessages, ['code.code_' . $language->id . '.required' => 'Code is required.']);
    //         $validationRule = array_merge($validationRule, ['class_name.class_name_' . $language->id => [$requiredVal, 'string', new CheckCategorySlug($language, null)]]);
    //         $errorMessages = array_merge($errorMessages, ['class_name.class_name_' . $language->id . '.required' => 'Class name is required']);
    //         $validationRule = array_merge($validationRule, ['class_definition.class_definition_' . $language->id => [$requiredVal, 'string', new CheckCategorySlug($language, null)]]);
    //         $errorMessages = array_merge($errorMessages, ['class_definition.class_definition_' . $language->id . '.required' => 'Class definition is required']);
    //     }

    //     $this->validate(
    //         $request,
    //         $validationRule,
    //         $errorMessages
    //     );

    //     $Career = Career::create(['hot' => $request->hot]);
    //     if ($Career) {
    //         foreach ($languages as $language) {
    //             CareerDetail::create([
    //                 'career_id' => $Career->id,
    //                 'language_id' => $language->id,
    //                 // 'level'  => $request['level']['level_' . $language->id] ?? null,
    //                 // 'h_structure'  => $request['h_structure']['h_structure_' . $language->id] ?? null,
    //                 // 'code'  => $request['code']['code_' . $language->id] ?? null,
    //                 'class_name'  => $request['class_name']['class_name_' . $language->id] ?? null,
    //                 'class_definition'  => $request['class_definition']['class_definition_' . $language->id] ?? null
    //             ]);
    //         }
    //         return $this->apiSuccessResponse(new CareerResource($Career), 'Your changes have been done successfully');
    //     }
    //     return $this->errorResponse();
    // }
    public function store(Request $request)
    {

        $validationRule = [];
        $errorMessages = [];
        $languages = getAllLanguages();
        $defaultLang = getDefaultLanguage(1);

        if (isset($request->is_web) && $request->is_web == 1) {
            $validationRule = array_merge($validationRule, ['class_name.class_name_' . $defaultLang->id => ['required', 'string']]);
            $errorMessages = array_merge($errorMessages, ['class_name.class_name_' . $defaultLang->id . '.required' => 'Class name is required']);
            $validationRule = array_merge($validationRule, ['class_definition.class_definition_' . $defaultLang->id => ['required', 'string']]);
            $errorMessages = array_merge($errorMessages, ['class_definition.class_definition_' . $defaultLang->id . '.required' => 'Class definition is required']);
        } else {

            foreach ($languages as $language) {
                $requiredVal = 'nullable';
                if ($language->is_default == '1') {
                    $requiredVal = 'required';
                }
                // $validationRule = array_merge($validationRule, ['level.level_' . $language->id => [$requiredVal, 'string', new CheckCategorySlug($language, null)]]);
                // $errorMessages = array_merge($errorMessages, ['level.level_' . $language->id . '.required' => 'Level is required.']);
                // $validationRule = array_merge($validationRule, ['h_structure.h_structure_' . $language->id => [$requiredVal, 'string', new CheckCategorySlug($language, null)]]);
                // $errorMessages = array_merge($errorMessages, ['h_structure.h_structure_' . $language->id . '.required' => 'herarchial Structure is required.']);
                // $validationRule = array_merge($validationRule, ['code.code_' . $language->id => [$requiredVal, 'string', new CheckCategorySlug($language, null)]]);
                // $errorMessages = array_merge($errorMessages, ['code.code_' . $language->id . '.required' => 'Code is required.']);
                $validationRule = array_merge($validationRule, ['class_name.class_name_' . $language->id => [$requiredVal, 'string', new CheckCategorySlug($language, null)]]);
                $errorMessages = array_merge($errorMessages, ['class_name.class_name_' . $language->id . '.required' => 'Class name is required']);
                $validationRule = array_merge($validationRule, ['class_definition.class_definition_' . $language->id => [$requiredVal, 'string', new CheckCategorySlug($language, null)]]);
                $errorMessages = array_merge($errorMessages, ['class_definition.class_definition_' . $language->id . '.required' => 'Class definition is required']);
            }
        }

        $this->validate(
            $request,
            $validationRule,
            $errorMessages
        );

        $Career = Career::create(['hot' => $request->hot]);
        if ($Career) {
            // foreach ($languages as $language) {
                $language = getAllLanguages()->first();
                CareerDetail::create([
                    'career_id' => $Career->id,
                    'language_id' => $language->id,
                    // 'level'  => $request['level']['level_' . $language->id] ?? null,
                    // 'h_structure'  => $request['h_structure']['h_structure_' . $language->id] ?? null,
                    // 'code'  => $request['code']['code_' . $language->id] ?? null,
                    'class_name'  => $request['class_name']['class_name_' . $language->id] ?? null,
                    'class_definition'  => $request['class_definition']['class_definition_' . $language->id] ?? null
                ]);
            // }
            return $this->apiSuccessResponse(new CareerResource($Career), 'Your changes have been done successfully');
        }
        return $this->errorResponse();
    }


    public function update(Request $request, Career $Career)
    {
        $validationRule = [];
        $errorMessages = [];
        $languages = getAllLanguages();
        foreach ($languages as $language) {
            $requiredVal = 'nullable';
            if ($language->is_default == '1') {
                $requiredVal = 'required';
            }
            // $validationRule = array_merge($validationRule, ['level.level_' . $language->id => [$requiredVal, 'string', new CheckCategorySlug($language, null)]]);
            // $errorMessages = array_merge($errorMessages, ['level.level_' . $language->id . '.required' => 'Level is required.']);
            // $validationRule = array_merge($validationRule, ['h_structure.h_structure_' . $language->id => [$requiredVal, 'string', new CheckCategorySlug($language, null)]]);
            // $errorMessages = array_merge($errorMessages, ['h_structure.h_structure_' . $language->id . '.required' => 'herarchial Structure is required.']);
            // $validationRule = array_merge($validationRule, ['code.code_' . $language->id => [$requiredVal, 'string', new CheckCategorySlug($language, null)]]);
            // $errorMessages = array_merge($errorMessages, ['code.code_' . $language->id . '.required' => 'Code is required.']);
            $validationRule = array_merge($validationRule, ['class_name.class_name_' . $language->id => [$requiredVal, 'string', new CheckCategorySlug($language, null)]]);
            $errorMessages = array_merge($errorMessages, ['class_name.class_name_' . $language->id . '.required' => 'Class name is required']);
            $validationRule = array_merge($validationRule, ['class_definition.class_definition_' . $language->id => [$requiredVal, 'string', new CheckCategorySlug($language, null)]]);
            $errorMessages = array_merge($errorMessages, ['class_definition.class_definition_' . $language->id . '.required' => 'Class definition is required']);
        }

        $this->validate(
            $request,
            $validationRule,
            $errorMessages
        );

        $Career->update([
            'hot' => $request->hot,
            'article_category_image' => !isset($request->article_category_image) ? null : (isset($files, $files[0]) ? $files[0]->id : $Career->article_category_image),
        ]);
        foreach ($languages as $language) {
            $CareerDetail = CareerDetail::whereLanguageId($language->id)->whereCareerId($Career->id)->exists();
            if ($CareerDetail) {
                CareerDetail::whereLanguageId($language->id)->whereCareerId($Career->id)->update([
                    // 'level'  => $request['level']['level_' . $language->id] ?? null,
                    // 'h_structure'  => $request['h_structure']['h_structure_' . $language->id] ?? null,
                    // 'code'  => $request['code']['code_' . $language->id] ?? null,
                    'class_name'  => $request['class_name']['class_name_' . $language->id] ?? null,
                    'class_definition'  => $request['class_definition']['class_definition_' . $language->id] ?? null
                ]);
            } else {
                // CareerDetail::create([
                //     'career_id' => $Career->id,
                //     'language_id' => $language->id,
                //     // 'level'  => $request['level']['level_' . $language->id] ?? null,
                //     // 'h_structure'  => $request['h_structure']['h_structure_' . $language->id] ?? null,
                //     // 'code'  => $request['code']['code_' . $language->id] ?? null,
                //     'class_name'  => $request['class_name']['class_name_' . $language->id] ?? null,
                //     'class_definition'  => $request['class_definition']['class_definition_' . $language->id] ?? null
                // ]);
            }
        }

        if ($Career) {
            return $this->apiSuccessResponse(new CareerResource($Career), 'Your changes have been done successfully');
        }
        return $this->errorResponse();
    }


    public function destroy(Request $request, Career $Career)
    {
        if ($Career->CareerDetail()->delete() && $Career->delete()) {
            return $this->apiSuccessResponse(new CareerResource($Career), 'The selected item has been deleted successfully');
        }
        return $this->errorResponse();
    }

    protected function loadRelations($article_categorys)
    {
        $defaultLang = getDefaultLanguage();
        $article_categorys = $article_categorys->with(['careerDetail' => function ($q) use ($defaultLang) {
            $q->where('language_id', $defaultLang->id);
        }]);
        if (isset($_GET['withCareerDetail']) && $_GET['withCareerDetail'] == '1') {
            $article_categorys = $article_categorys->with('careerDetail');
        }
        return $article_categorys;
    }

    protected function sortingAndLimit($article_categorys)
    {
        $sortType = ['ASC', 'asc', 'DESC', 'desc'];
        $sortBy = ['id', 'name', 'abbreviation', 'career_detail_name'];
        if (isset($_GET['sortBy']) && $_GET['sortBy'] != '' && isset($_GET['sortType']) && $_GET['sortType'] != '' && in_array($_GET['sortBy'], $sortBy) && in_array($_GET['sortType'], $sortType)) {
            $defaultLang = getDefaultLanguage();
            $article_categorys = $article_categorys->addSelect(['career_detail_name' => CareerDetail::whereColumn('careers.id', 'career_details.career_id')->whereLanguageId($defaultLang->id)->select('class_name')->limit(1)]);


            $article_categorys = $article_categorys->OrderBy($_GET['sortBy'], $_GET['sortType']);
        }

        if (isset($_GET['limit']) && $_GET['limit'] != '') {
            $limit = $_GET['limit'];
        } else {
            $limit = 10;
        }

        return $article_categorys->paginate($limit);
    }

    protected function whereClause($article_categorys)
    {
        if (isset($_GET['searchParam']) && $_GET['searchParam'] != '') {
            $article_categorys = $article_categorys->whereHas('CareerDetail', function ($q) {
                $q->where('name', 'LIKE', '%' . $_GET['searchParam'] . '%');
            });
        }
        return $article_categorys;
    }
}
