<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\ComunityServiceResource;
use Illuminate\Support\Str;
use App\Models\ComunityService;
use App\Models\ComunityServiceDetail;
use App\Models\Language;
use App\Rules\CheckCategorySlug;
use App\Traits\StatusResponser;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;

class ComunityServiceController extends Controller
{
    use StatusResponser;
    use FileUploadTrait;

    public function __construct()
    {
        $this->middleware('password_confirm')->only('destroy');
    }

    public function index()
    {
        $comunityServices = ComunityService::query();

        $comunityServices = $this->whereClause($comunityServices);
        $comunityServices = $this->loadRelations($comunityServices);
        $comunityServices = $this->sortingAndLimit($comunityServices);

        return $this->apiSuccessResponse(ComunityServiceResource::collection($comunityServices), 'Data Get Successfully!');
    }

    public function show(ComunityService $ComunityService)
    {
        if (isset($_GET['withComunityServiceDetail']) && $_GET['withComunityServiceDetail'] == '1') {
            $ComunityService = $ComunityService->loadMissing('comunityServiceDetail');
        }

        return $this->apiSuccessResponse(new ComunityServiceResource($ComunityService), 'Data Get Successfully!');
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
        $ComunityService = ComunityService::create([
            'status' => $request->status,
        ]);

        if ($ComunityService) {
            foreach ($languages as $language) {
                ComunityServiceDetail::create([
                    'comunity_service_id' => $ComunityService->id,
                    'language_id' => $language->id,
                    'name' => $request['name']['name_' . $language->id] ?? null,
                ]);
            }
            return $this->apiSuccessResponse(new ComunityServiceResource($ComunityService), 'Your changes have been done successfully');
        }
        return $this->errorResponse();
    }

    public function update(Request $request, ComunityService $ComunityService)
    {
        $validationRule = [];
        $errorMessages = [];
        $languages = getAllLanguages();
        foreach ($languages as $language) {
            $requiredVal = 'nullable';
            if ($language->is_default == '1') {
                $requiredVal = 'required';
            }
            $validationRule = array_merge($validationRule, ['name.name_' . $language->id => [$requiredVal, 'string', new CheckCategorySlug($language, $ComunityService->id)]]);
            $errorMessages = array_merge($errorMessages, ['name.name_' . $language->id . '.required' => 'Name is required']);
        }
        $validationRule = array_merge($validationRule, ['status' => ['required']]);
        $errorMessages = array_merge($errorMessages, ['status.required' => 'Status is required']);
        $this->validate($request, $validationRule, $errorMessages);

        $ComunityService->update([
            'status' => $request->status,
        ]);
        foreach ($languages as $language) {
            $ComunityServiceDetail = ComunityServiceDetail::whereLanguageId($language->id)
                ->whereComunityServiceId($ComunityService->id)
                ->exists();
            if ($ComunityServiceDetail) {
                ComunityServiceDetail::whereLanguageId($language->id)
                    ->whereComunityServiceId($ComunityService->id)
                    ->update([
                        'comunity_service_id' => $ComunityService->id,
                        'language_id' => $language->id,
                        'name' => $request['name']['name_' . $language->id] ?? null,
                    ]);
            } else {
                ComunityServiceDetail::create([
                    'comunity_service_id' => $ComunityService->id,
                    'language_id' => $language->id,
                    'name' => $request['name']['name_' . $language->id] ?? null,
                ]);
            }
        }

        if ($ComunityService) {
            return $this->apiSuccessResponse(new ComunityServiceResource($ComunityService), 'Your changes have been done successfully');
        }
        return $this->errorResponse();
    }

    public function destroy(Request $request, ComunityService $ComunityService)
    {
        if ($ComunityService->ComunityServiceDetail()->delete() && $ComunityService->delete()) {
            return $this->apiSuccessResponse(new ComunityServiceResource($ComunityService), 'The selected item has been deleted successfully');
        }
        return $this->errorResponse();
    }

    protected function loadRelations($comunityServices)
    {
        $defaultLang = getDefaultLanguage();
        $comunityServices = $comunityServices->with([
            'comunityServiceDetail' => function ($q) use ($defaultLang) {
                $q->where('language_id', $defaultLang->id);
            },
        ]);
        if (isset($_GET['withComunityServiceDetail']) && $_GET['withComunityServiceDetail'] == '1') {
            $comunityServices = $comunityServices->with('comunityServiceDetail');
        }
        return $comunityServices;
    }

    protected function sortingAndLimit($comunityServices)
    {
        $sortType = ['ASC', 'asc', 'DESC', 'desc'];
        $sortBy = ['id', 'comunity_service_name'];
        if (isset($_GET['sortBy']) && $_GET['sortBy'] != '' && isset($_GET['sortType']) && $_GET['sortType'] != '' && in_array($_GET['sortBy'], $sortBy) && in_array($_GET['sortType'], $sortType)) {
            $defaultLang = getDefaultLanguage();
            $comunityServices = $comunityServices->addSelect(['comunity_service_name' => ComunityServiceDetail::whereColumn('comunity_services.id', 'comunity_service_details.comunity_service_id')->whereLanguageId($defaultLang->id)->select('name')->limit(1)]);

            $comunityServices = $comunityServices->OrderBy($_GET['sortBy'], $_GET['sortType']);
        }

        if (isset($_GET['limit']) && $_GET['limit'] != '') {
            $limit = $_GET['limit'];
        } else {
            $limit = 10;
        }

        return $comunityServices->paginate($limit);
    }

    protected function whereClause($comunityServices)
    {
        if (isset($_GET['searchParam']) && $_GET['searchParam'] != '') {
            $comunityServices = $comunityServices->whereHas('comunityServiceDetail', function ($q) {
                $q->where('name', 'LIKE', '%' . $_GET['searchParam'] . '%');
            });
        }
        return $comunityServices;
    }

    public function saveDefaultLanguageComunityService(Request $request){
        $language = getDefaultLanguage();
        $ComunityService = ComunityService::create([
            'status' => 0,
        ]);
        if ($ComunityService) {
            ComunityServiceDetail::create([
                'comunity_service_id' => $ComunityService->id,
                'language_id' => $language->id,
                'name' => $request->name,
            ]);
            return $this->apiSuccessResponse(new ComunityServiceResource($ComunityService), 'Your changes have been done successfully');
        }
        return $this->errorResponse();
    }
    
}
