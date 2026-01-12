<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\MessagingAppResource;
use Illuminate\Support\Str;
use App\Models\MessagingApp;
use App\Models\MessagingAppDetail;
use App\Models\Language;
use App\Rules\CheckCategorySlug;
use App\Rules\CheckNameIsUnique;
use App\Traits\StatusResponser;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;

class MessagingAppController extends Controller
{
    use StatusResponser;
    use FileUploadTrait;

    public function __construct()
    {
        $this->middleware('password_confirm')->only('destroy');
    }

    public function index()
    {
        $MessagingApps = MessagingApp::query();
        $MessagingApps = $this->whereClause($MessagingApps);
        $MessagingApps = $this->loadRelations($MessagingApps);
        $MessagingApps = $this->sortingAndLimit($MessagingApps);
        
        return $this->apiSuccessResponse(MessagingAppResource::collection($MessagingApps), 'Data Get Successfully!');
    }
    public function allMessagingApps()
    {
        $MessagingApps = MessagingApp::query();
        $MessagingApps = $this->whereClause($MessagingApps);
        $MessagingApps = $this->loadRelations($MessagingApps);
        $MessagingApps = $MessagingApps->get();
        
        return $this->apiSuccessResponse(MessagingAppResource::collection($MessagingApps), 'Data Get Successfully!');
    }
    public function show(MessagingApp $MessagingApp)
    {
        if (isset($_GET['withMessagingAppDetail']) && $_GET['withMessagingAppDetail'] == '1') {
            $MessagingApp = $MessagingApp->loadMissing('messagingAppDetail');
        }

        return $this->apiSuccessResponse(new MessagingAppResource($MessagingApp), 'Data Get Successfully!');
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
            $validationRule = array_merge($validationRule, ['name.name_' . $language->id => [$requiredVal, 'string', new CheckNameIsUnique($language, null)]]);
            $errorMessages = array_merge($errorMessages, ['name.name_' . $language->id . '.required' => 'Name is required.']);
        }

        $this->validate($request, $validationRule, $errorMessages);
        $MessagingApp = MessagingApp::create([]);

        if ($MessagingApp) {
            foreach ($languages as $language) {
                MessagingAppDetail::create([
                    'messaging_app_id' => $MessagingApp->id,
                    'language_id' => $language->id,
                    'name' => $request['name']['name_' . $language->id],
                ]);
            }
            return $this->apiSuccessResponse(new MessagingAppResource($MessagingApp), 'Your changes have been done successfully');
        }
        return $this->errorResponse();
    }

    public function update(Request $request, MessagingApp $MessagingApp)
    {
        $validationRule = [];
        $errorMessages = [];
        $languages = getAllLanguages();
        foreach ($languages as $language) {
            $requiredVal = 'nullable';
            if ($language->is_default == '1') {
                $requiredVal = 'required';
            }
            $validationRule = array_merge($validationRule, ['name.name_' . $language->id => [$requiredVal, 'string', new CheckNameIsUnique($language, $MessagingApp->id)]]);
            $errorMessages = array_merge($errorMessages, ['name.name_' . $language->id . '.required' => 'Name in ' . $language->name . ' is required.']);
        }
        $this->validate($request, $validationRule, $errorMessages);
        foreach ($languages as $language) {
            $MessagingAppDetail = MessagingAppDetail::whereLanguageId($language->id)
                ->whereMessagingAppId($MessagingApp->id)
                ->exists();
            if ($MessagingAppDetail) {
                MessagingAppDetail::whereLanguageId($language->id)
                    ->whereMessagingAppId($MessagingApp->id)
                    ->update([
                        'name' => $request['name']['name_' . $language->id],
                    ]);
            } else {
                MessagingAppDetail::create([
                    'messaging_app_id' => $MessagingApp->id,
                    'language_id' => $language->id,
                    'name' => $request['name']['name_' . $language->id],
                ]);
            }
        }

        if ($MessagingApp) {
            return $this->apiSuccessResponse(new MessagingAppResource($MessagingApp), 'Your changes have been done successfully');
        }
        return $this->errorResponse();
    }

    public function destroy(Request $request, MessagingApp $MessagingApp)
    {
        if ($MessagingApp->MessagingAppDetail()->delete() && $MessagingApp->delete()) {
            return $this->apiSuccessResponse(new MessagingAppResource($MessagingApp), 'The selected item has been deleted successfully');
        }
        return $this->errorResponse();
    }

    protected function loadRelations($MessagingApps)
    {
        $defaultLang = getDefaultLanguage();
        $MessagingApps = $MessagingApps->with([
            'messagingAppDetail' => function ($q) use ($defaultLang) {
                $q->where('language_id', $defaultLang->id);
            },
        ]);
        if (isset($_GET['withMessagingAppDetail']) && $_GET['withMessagingAppDetail'] == '1') {
            $MessagingApps = $MessagingApps->with('messagingAppDetail');
        }
        return $MessagingApps;
    }

    protected function sortingAndLimit($MessagingApps)
    {
        $sortType = ['ASC', 'asc', 'DESC', 'desc'];
        $sortBy = ['id', 'name', 'abbreviation', 'messaging_app_name'];
        if (isset($_GET['sortBy']) && $_GET['sortBy'] != '' && isset($_GET['sortType']) && $_GET['sortType'] != '' && in_array($_GET['sortBy'], $sortBy) && in_array($_GET['sortType'], $sortType)) {
            $defaultLang = getDefaultLanguage();
            $MessagingApps = $MessagingApps->addSelect(['messaging_app_name' => MessagingAppDetail::whereColumn('messaging_apps.id', 'messaging_app_details.messaging_app_id')->whereLanguageId($defaultLang->id)->select('name')->limit(1)]);


            $MessagingApps = $MessagingApps->OrderBy($_GET['sortBy'], $_GET['sortType']);
        }

        if (isset($_GET['limit']) && $_GET['limit'] != '') {
            $limit = $_GET['limit'];
        } else {
            $limit = 10;
        }

        return $MessagingApps->paginate($limit);
    }

    protected function whereClause($MessagingApps)
    {
        if (isset($_GET['searchParam']) && $_GET['searchParam'] != '') {
            $MessagingApps = $MessagingApps->whereHas('messagingAppDetail', function ($q) {
                $q->where('name', 'LIKE', '%' . $_GET['searchParam'] . '%');
            });
        }
        return $MessagingApps;
    }

   

}
