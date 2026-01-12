<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\SocialServiceResource;
use Illuminate\Support\Str;
use App\Models\SocialService;
use App\Models\SocialServiceDetail;
use App\Models\Language;
use App\Rules\CheckCategorySlug;
use App\Traits\StatusResponser;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;

class SocialServiceController extends Controller
{
    use StatusResponser;
    use FileUploadTrait;

    public function __construct()
    {
        $this->middleware('password_confirm')->only('destroy');
    }

    public function index()
    {
        $socialServices = SocialService::query();

        $socialServices = $this->whereClause($socialServices);
        $socialServices = $this->loadRelations($socialServices);
        $socialServices = $this->sortingAndLimit($socialServices);

        return $this->apiSuccessResponse(SocialServiceResource::collection($socialServices), 'Data Get Successfully!');
    }

    public function show(SocialService $SocialService)
    {
        if (isset($_GET['withSocialServiceDetail']) && $_GET['withSocialServiceDetail'] == '1') {
            $SocialService = $SocialService->loadMissing('socialServiceDetail');
        }

        return $this->apiSuccessResponse(new SocialServiceResource($SocialService), 'Data Get Successfully!');
    }

    public function store(Request $request)
    {
        $validationRule = [];
        $errorMessages = [];
        $languages = getAllLanguages();
        foreach ($languages as $language) {
            $validationRule = array_merge($validationRule, ['name.name_' . $language->id => ['required', 'string', new CheckCategorySlug($language, null)]]);
            $errorMessages = array_merge($errorMessages, ['name.name_' . $language->id . '.required' => 'Title in ' . $language->name . ' is required.']);
        }

        $this->validate($request, $validationRule, $errorMessages);
        $SocialService = SocialService::create([
            'status' => $request->status,
        ]);

        if ($SocialService) {
            foreach ($languages as $language) {
                SocialServiceDetail::create([
                    'social_service_id' => $SocialService->id,
                    'language_id' => $language->id,
                    'name' => $request['name']['name_' . $language->id],
                ]);
            }
            return $this->apiSuccessResponse(new SocialServiceResource($SocialService), 'Your changes have been done successfully');
        }
        return $this->errorResponse();
    }

    public function update(Request $request, SocialService $SocialService)
    {
        $validationRule = [];
        $errorMessages = [];
        $languages = getAllLanguages();
        foreach ($languages as $language) {
            $validationRule = array_merge($validationRule, ['name.name_' . $language->id => ['required', 'string', new CheckCategorySlug($language, $SocialService->id)]]);
            $errorMessages = array_merge($errorMessages, ['name.name_' . $language->id . '.required' => 'Name in ' . $language->name . ' is required.']);
        }

        $this->validate($request, $validationRule, $errorMessages);

        $SocialService->update([
            'status' => $request->status,
        ]);
        foreach ($languages as $language) {
            $SocialServiceDetail = SocialServiceDetail::whereLanguageId($language->id)
                ->whereSocialServiceId($SocialService->id)
                ->exists();
            if ($SocialServiceDetail) {
                SocialServiceDetail::whereLanguageId($language->id)
                    ->whereSocialServiceId($SocialService->id)
                    ->update([
                        'social_service_id' => $SocialService->id,
                        'language_id' => $language->id,
                        'name' => $request['name']['name_' . $language->id],
                    ]);
            } else {
                SocialServiceDetail::create([
                    'social_service_id' => $SocialService->id,
                    'language_id' => $language->id,
                    'name' => $request['name']['name_' . $language->id],
                ]);
            }
        }

        if ($SocialService) {
            return $this->apiSuccessResponse(new SocialServiceResource($SocialService), 'Your changes have been done successfully');
        }
        return $this->errorResponse();
    }

    public function destroy(Request $request, SocialService $SocialService)
    {
        if ($SocialService->SocialServiceDetail()->delete() && $SocialService->delete()) {
            return $this->apiSuccessResponse(new SocialServiceResource($SocialService), 'The selected item has been deleted successfully');
        }
        return $this->errorResponse();
    }

    protected function loadRelations($socialServices)
    {
        $defaultLang = getDefaultLanguage();
        $socialServices = $socialServices->with([
            'socialServiceDetail' => function ($q) use ($defaultLang) {
                $q->where('language_id', $defaultLang->id);
            },
        ]);
        if (isset($_GET['withSocialServiceDetail']) && $_GET['withSocialServiceDetail'] == '1') {
            $socialServices = $socialServices->with('socialServiceDetail');
        }
        return $socialServices;
    }

    protected function sortingAndLimit($socialServices)
    {
        $sortType = ['ASC', 'asc', 'DESC', 'desc'];
        $sortBy = ['id', 'social_service_name'];
        if (isset($_GET['sortBy']) && $_GET['sortBy'] != '' && isset($_GET['sortType']) && $_GET['sortType'] != '' && in_array($_GET['sortBy'], $sortBy) && in_array($_GET['sortType'], $sortType)) {
            $defaultLang = getDefaultLanguage();
            $socialServices = $socialServices->addSelect(['social_service_name' => SocialServiceDetail::whereColumn('social_services.id', 'social_service_id.social_service_id')->whereLanguageId($defaultLang->id)->select('name')->limit(1)]);

            $socialServices = $socialServices->OrderBy($_GET['sortBy'], $_GET['sortType']);
        }

        if (isset($_GET['limit']) && $_GET['limit'] != '') {
            $limit = $_GET['limit'];
        } else {
            $limit = 10;
        }

        return $socialServices->paginate($limit);
    }

    protected function whereClause($socialServices)
    {
        if (isset($_GET['searchParam']) && $_GET['searchParam'] != '') {
            $socialServices = $socialServices->whereHas('socialServiceDetail', function ($q) {
                $q->where('name', 'LIKE', '%' . $_GET['searchParam'] . '%');
            });
        }
        return $socialServices;
    }
}
