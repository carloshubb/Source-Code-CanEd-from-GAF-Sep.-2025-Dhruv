<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\PageResource;
use Illuminate\Support\Str;
use App\Models\Page;
use App\Models\PageDetail;
use App\Models\Language;
use App\Rules\CheckCategorySlug;
use App\Traits\StatusResponser;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;

class PageController extends Controller
{
    use StatusResponser;
    use FileUploadTrait;

    public function __construct()
    {
        $this->middleware('password_confirm')->only('destroy');
    }

    public function index()
    {
        $pages = Page::query();

        $pages = $this->whereClause($pages);
        $pages = $this->loadRelations($pages);
        $pages = $this->sortingAndLimit($pages);

        return $this->apiSuccessResponse(PageResource::collection($pages), 'Data Get Successfully!');
    }

    public function show(Page $Page)
    {
        if (isset($_GET['withPageDetail']) && $_GET['withPageDetail'] == '1') {
            $Page = $Page->loadMissing('PageDetail');
        }

        return $this->apiSuccessResponse(new PageResource($Page), 'Data Get Successfully!');
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $validationRule = [];
        $errorMessages = [];
        $languages = getAllLanguages();
        $defaultLanguage = getDefaultLanguage();
        foreach ($languages as $language) {
            $requiredVal = 'nullable';
            if ($language->is_default == '1') {
                $requiredVal = 'required';
            }
            $validationRule = array_merge($validationRule, ['name.name_' . $language->id => [$requiredVal, 'string', new CheckCategorySlug($language, null)]]);
            $errorMessages = array_merge($errorMessages, ['name.name_' . $language->id . '.required' => 'Name is required']);
            if (empty($request->template)) {
                $validationRule = array_merge($validationRule, ['description.description_' . $language->id => [$requiredVal, 'string', new CheckCategorySlug($language, null)]]);
                $errorMessages = array_merge($errorMessages, ['description.description_' . $language->id . '.required' => 'Description is required']);
            }
        }

        $this->validate($request, $validationRule, $errorMessages);

        $Page = Page::create([
            'template' => $request->template,
            'image' => $request->image,
            'slug' => Str::slug($request['name']['name_' . $defaultLanguage->id]),
            'set_as_home' => $request->set_as_home,
        ]);

        if ($Page) {
            foreach ($languages as $language) {
                PageDetail::create([
                    'page_id' => $Page->id,
                    'language_id' => $language->id,
                    'name' => $request['name']['name_' . $language->id] ?? null,
                    'description' => $request['description']['description_' . $language->id] != '' ? $request['description']['description_' . $language->id] : null,
                    'slug' => isset($request['name']['name_' . $language->id]) ? Str::slug($request['name']['name_' . $language->id]) : null,
                ]);
            }
            return $this->apiSuccessResponse(new PageResource($Page), 'Your changes have been done successfully');
        }
        return $this->errorResponse();
    }

    public function update(Request $request, Page $Page)
    {
        $validationRule = [];
        $errorMessages = [];
        $languages = getAllLanguages();
        $defaultLanguage = getDefaultLanguage();
        foreach ($languages as $language) {
            $requiredVal = 'nullable';
            if ($language->is_default == '1') {
                $requiredVal = 'required';
            }
            $validationRule = array_merge($validationRule, ['name.name_' . $language->id => [$requiredVal, 'string', new CheckCategorySlug($language, null)]]);
            $errorMessages = array_merge($errorMessages, ['name.name_' . $language->id . '.required' => 'Name is required']);
            if (empty($request->template)) {
                $validationRule = array_merge($validationRule, ['description.description_' . $language->id => [$requiredVal, 'string', new CheckCategorySlug($language, null)]]);
                $errorMessages = array_merge($errorMessages, ['description.description_' . $language->id . '.required' => 'Description is required']);
            }
        }

        $this->validate($request, $validationRule, $errorMessages);
        $Page->update([
            'template' => $request->template,
            'image' => $request->image,
            // 'slug' => Str::slug($request['name']['name_' . $defaultLanguage->id]),
            'set_as_home' => $request->set_as_home,
        ]);

        foreach ($languages as $language) {
            $PageDetail = PageDetail::whereLanguageId($language->id)
                ->wherePageId($Page->id)
                ->exists();
            if ($PageDetail) {
                PageDetail::whereLanguageId($language->id)
                    ->wherePageId($Page->id)
                    ->update([
                        'name' => $request['name']['name_' . $language->id] ?? null,
                        // 'slug' => isset($request['name']['name_' . $language->id]) ? Str::slug($request['name']['name_' . $language->id]) : null,
                        'description' => $request['description']['description_' . $language->id] != '' ? $request['description']['description_' . $language->id] : null,
                    ]);
            } else {
                PageDetail::create([
                    'page_id' => $Page->id,
                    'language_id' => $language->id,
                    'name' => $request['name']['name_' . $language->id] ?? null,
                    'slug' => isset($request['name']['name_' . $language->id]) ? Str::slug($request['name']['name_' . $language->id]) : null,
                    'description' => $request['description']['description_' . $language->id] != '' ? $request['description']['description_' . $language->id] : null,
                ]);
            }
        }

        if ($Page) {
            return $this->apiSuccessResponse(new PageResource($Page), 'Your changes have been done successfully');
        }
        return $this->errorResponse();
    }

    public function destroy(Request $request, Page $Page)
    {
        if ($Page->PageDetail()->delete() && $Page->delete()) {
            return $this->apiSuccessResponse(new PageResource($Page), 'The selected item has been deleted successfully');
        }
        return $this->errorResponse();
    }

    protected function loadRelations($pages)
    {
        $defaultLang = getDefaultLanguage();
        $pages = $pages->with([
            'PageDetail' => function ($q) use ($defaultLang) {
                $q->where('language_id', $defaultLang->id);
            },
        ]);
        if (isset($_GET['withPageDetail']) && $_GET['withPageDetail'] == '1') {
            $pages = $pages->with('PageDetail');
        }
        return $pages;
    }

    protected function sortingAndLimit($pages)
    {
        $sortType = ['ASC', 'asc', 'DESC', 'desc'];
        $sortBy = ['id', 'name', 'abbreviation', 'page_name'];
        if (isset($_GET['sortBy']) && $_GET['sortBy'] != '' && isset($_GET['sortType']) && $_GET['sortType'] != '' && in_array($_GET['sortBy'], $sortBy) && in_array($_GET['sortType'], $sortType)) {
            $defaultLang = getDefaultLanguage();
            $pages = $pages->addSelect(['page_name' => PageDetail::whereColumn('pages.id', 'page_details.page_id')->whereLanguageId($defaultLang->id)->select('name')->limit(1)]);

            
            $pages = $pages->OrderBy($_GET['sortBy'], $_GET['sortType']);
        }

        if (isset($_GET['limit']) && $_GET['limit'] != '') {
            $limit = $_GET['limit'];
        } else {
            $limit = 10;
        }

        return $pages->paginate($limit);
    }

    protected function whereClause($pages)
    {
        if (isset($_GET['searchParam']) && $_GET['searchParam'] != '') {
            $pages = $pages->whereHas('PageDetail', function ($q) {
                $q->where('name', 'LIKE', '%' . $_GET['searchParam'] . '%');
            });
        }
        return $pages;
    }
}
