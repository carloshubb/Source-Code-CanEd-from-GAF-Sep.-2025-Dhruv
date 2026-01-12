<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\ArticleCategoryResource;
use Illuminate\Support\Str;
use App\Models\ArticleCategory;
use App\Models\ArticleCategoryDetail;
use App\Models\Language;
use App\Rules\CheckCategorySlug;
use App\Traits\StatusResponser;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;

class ArticleCategoryController extends Controller
{
    use StatusResponser;
    use FileUploadTrait;

    public function __construct()
    {
        $this->middleware('password_confirm')->only('destroy');
    }


    public function index()
    {
        $article_categorys = ArticleCategory::query();

        $article_categorys = $this->whereClause($article_categorys);
        $article_categorys = $this->loadRelations($article_categorys);
        $article_categorys = $this->sortingAndLimit($article_categorys);

        return $this->apiSuccessResponse(ArticleCategoryResource::collection($article_categorys), 'Data Get Successfully!');
    }


    public function show(ArticleCategory $ArticleCategory)
    {
        if (isset($_GET['withArticleCategoryDetail']) && $_GET['withArticleCategoryDetail'] == '1') {
            $ArticleCategory = $ArticleCategory->loadMissing('ArticleCategoryDetail');
        }

        return $this->apiSuccessResponse(new ArticleCategoryResource($ArticleCategory), 'Data Get Successfully!');
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
        $validationRule = array_merge($validationRule, ['article_category_image' => ['required']]);
        $errorMessages = array_merge($errorMessages, ['article_category_image.required' => 'Image is required']);
        $validationRule = array_merge($validationRule, ['type' => ['required']]);
        $errorMessages = array_merge($errorMessages, ['type.required' => 'Type is required']);
        $this->validate(
            $request,
            $validationRule,
            $errorMessages
        );

        if (isset($request->article_category_image)) {
            $media = json_decode($request->article_category_image, true);

            if (is_array($media) && isset($media['media']) && !empty($media['media'])) {
                $files = $this->moveFile($media['media'], 'media/images', 'article_category_image');
            } else {
                return response()->json(['error' => 'Invalid media data'], 400);
            }
        } else {
            return response()->json(['error' => 'No article category image provided'], 400);
        }

        $ArticleCategory = ArticleCategory::create(['article_category_image' => isset($files, $files[0]) ? $files[0]->id : null, 'parent_id' => $request->parent_id, 'type' => $request->type]);


        if ($ArticleCategory) {
            foreach ($languages as $language) {
                ArticleCategoryDetail::create([
                    'article_category_id' => $ArticleCategory->id,
                    'language_id' => $language->id,
                    'name' => $request['name']['name_' . $language->id] ?? null,
                    'slug' => isset($request['name']['name_' . $language->id]) ? Str::slug($request['name']['name_' . $language->id]) : null,
                ]);
            }
            return $this->apiSuccessResponse(new ArticleCategoryResource($ArticleCategory), 'Your changes have been done successfully');
        }
        return $this->errorResponse();
    }


    public function update(Request $request, ArticleCategory $ArticleCategory)
    {
        $validationRule = [];
        $errorMessages = [];
        $languages = getAllLanguages();
        foreach ($languages as $language) {
            $requiredVal = 'nullable';
            if ($language->is_default == '1') {
                $requiredVal = 'required';
            }
            $validationRule = array_merge($validationRule, ['name.name_' . $language->id => [$requiredVal, 'string', new CheckCategorySlug($language, $ArticleCategory->id)]]);
            $errorMessages = array_merge($errorMessages, ['name.name_' . $language->id . '.required' => 'Name is required']);
        }
        $validationRule = array_merge($validationRule, ['article_category_image' => ['required']]);
        $errorMessages = array_merge($errorMessages, ['article_category_image.required' => 'Image is required']);
        $validationRule = array_merge($validationRule, ['type' => ['required']]);
        $errorMessages = array_merge($errorMessages, ['type.required' => 'Type is required']);

        $this->validate(
            $request,
            $validationRule,
            $errorMessages
        );

        if ($request->has('article_category_image') && !empty($request->article_category_image)) {
            $media = is_array($request->article_category_image)
                ? $request->article_category_image
                : json_decode($request->article_category_image, true);
        
            if ($media && is_array($media) && isset($media['media']) && !empty($media['media'])) {
                $files = $this->moveFile($media['media'], 'media/images', 'article_category_image');
        
                if (isset($existingImagePath) && !empty($existingImagePath)) {
                    $this->deleteFile($existingImagePath);
                }
            } else {
                $files = $existingImagePath ?? null;
            }
        } else {
            $files = $existingImagePath ?? null;
        }

        $ArticleCategory->update([
            'parent_id' => $request->parent_id,
            'article_category_image' => !isset($request->article_category_image) ? null : (isset($files, $files[0]) ? $files[0]->id : $ArticleCategory->article_category_image),
            'type' => $request->type,
        ]);
        foreach ($languages as $language) {
            $ArticleCategoryDetail = ArticleCategoryDetail::whereLanguageId($language->id)->whereArticleCategoryId($ArticleCategory->id)->exists();
            if ($ArticleCategoryDetail) {
                ArticleCategoryDetail::whereLanguageId($language->id)->whereArticleCategoryId($ArticleCategory->id)->update([
                    'name' => $request['name']['name_' . $language->id] ?? null,
                    'slug' => isset($request['name']['name_' . $language->id]) ? Str::slug($request['name']['name_' . $language->id]) : null,
                ]);
            } else {
                ArticleCategoryDetail::create([
                    'article_category_id' => $ArticleCategory->id,
                    'language_id' => $language->id,
                    'name' => $request['name']['name_' . $language->id] ?? null,
                    'slug' => isset($request['name']['name_' . $language->id]) ? Str::slug($request['name']['name_' . $language->id]) : null,
                ]);
            }
        }

        if ($ArticleCategory) {
            return $this->apiSuccessResponse(new ArticleCategoryResource($ArticleCategory), 'Your changes have been done successfully');
        }
        return $this->errorResponse();
    }

    protected function deleteFile($filePath)
    {
        if (\File::exists($filePath)) {
            \File::delete($filePath);
        }
    }

    public function destroy(Request $request, ArticleCategory $ArticleCategory)
    {
        if ($ArticleCategory->ArticleCategoryDetail()->delete() && $ArticleCategory->delete()) {
            return $this->apiSuccessResponse(new ArticleCategoryResource($ArticleCategory), 'The selected item has been deleted successfully');
        }
        return $this->errorResponse();
    }

    protected function loadRelations($article_categorys)
    {
        $defaultLang = getDefaultLanguage();
        $article_categorys = $article_categorys->with(['ArticleCategoryDetail' => function ($q) use ($defaultLang) {
            $q->where('language_id', $defaultLang->id);
        }]);
        if (isset($_GET['withArticleCategoryDetail']) && $_GET['withArticleCategoryDetail'] == '1') {
            $article_categorys = $article_categorys->with('ArticleCategoryDetail');
        }
        return $article_categorys;
    }

    protected function sortingAndLimit($article_categorys)
    {
        $sortType = ['ASC', 'asc', 'DESC', 'desc'];
        $sortBy = ['id', 'name', 'abbreviation', 'article_name'];
        if (isset($_GET['sortBy']) && $_GET['sortBy'] != '' && isset($_GET['sortType']) && $_GET['sortType'] != '' && in_array($_GET['sortBy'], $sortBy) && in_array($_GET['sortType'], $sortType)) {
            $defaultLang = getDefaultLanguage();
            $article_categorys = $article_categorys->addSelect(['article_name' => ArticleCategoryDetail::whereColumn('article_categories.id', 'article_category_details.article_category_id')->whereLanguageId($defaultLang->id)->select('name')->limit(1)]);

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
        if (isset($_GET['type']) && $_GET['type'] != '') {
            $article_categorys = $article_categorys->where('type', $_GET['type']);
        }
        if (isset($_GET['searchParam']) && $_GET['searchParam'] != '') {
            $article_categorys = $article_categorys->whereHas('ArticleCategoryDetail', function ($q) {
                $q->where('name', 'LIKE', '%' . $_GET['searchParam'] . '%');
            });
        }
        return $article_categorys;
    }
}
