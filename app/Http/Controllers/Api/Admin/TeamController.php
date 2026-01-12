<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\TeamResource;
use Illuminate\Support\Str;
use App\Models\Team;
use App\Models\TeamDetail;
use App\Models\Language;
use App\Rules\CheckCategorySlug;
use App\Traits\StatusResponser;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TeamController extends Controller
{
    use StatusResponser;
    use FileUploadTrait;

    public function __construct()
    {
        $this->middleware('password_confirm')->only('destroy');
    }


    public function index()
    {
        $teams = Team::query();

        $teams = $this->whereClause($teams);
        $teams = $this->loadRelations($teams);
        $teams = $this->sortingAndLimit($teams);

        return $this->apiSuccessResponse(TeamResource::collection($teams), 'Data Get Successfully!');
    }


    public function show(Team $Team)
    {
        if (isset($_GET['withTeamDetail']) && $_GET['withTeamDetail'] == '1') {
            $Team = $Team->loadMissing('teamDetail');
        }

        return $this->apiSuccessResponse(new TeamResource($Team), 'Data Get Successfully!');
    }


    public function store(Request $request)
    {
        // dd($request->all());
        $validationRule = [];
        $errorMessages = [];
        $languages = getAllLanguages();
        foreach ($languages as $language) {
            $requiredVal = 'nullable';
            if ($language->is_default == '1') {
                $requiredVal = 'required';
            }
            $validationRule = array_merge($validationRule, ['title.title_' . $language->id => [$requiredVal, 'string', 
            function ($attribute, $value, $fail) {
                $plainText = trim(strip_tags(html_entity_decode($value)));
                if (str_word_count($plainText) > 30) {
                    $fail('Only 30 words are allowed for the summary.');
                }
            },new CheckCategorySlug($language, null)]]);
            $errorMessages = array_merge($errorMessages, ['title.title_' . $language->id . '.required' => 'Title is required']);
            $validationRule = array_merge($validationRule, ['name.name_' . $language->id => [$requiredVal, 'string', new CheckCategorySlug($language, null)]]);
            $errorMessages = array_merge($errorMessages, ['name.name_' . $language->id . '.required' => 'Name is required']);
        }
        $validationRule = array_merge($validationRule, ['image' => ['required']]);
        
        $validationRule = array_merge($validationRule, ['status' => ['required']]);
        $errorMessages = array_merge($errorMessages, ['status.required' => 'Status is required']);

        $this->validate(
            $request,
            $validationRule,
            $errorMessages
        );

        $media = json_decode($request->image, true);

        if (is_array($media) && isset($media['media']) && !empty($media['media'])) {
            $files = $this->moveFile($media['media'], 'media/images', 'team_image');
        } else {
            return response()->json(['error' => 'Invalid media data'], 400);
        }

        $Team = Team::create([
            'image' => $files[0]['id'] ?? null,
            'status' => $request->status,
        ]);

        // dd($Team);


        if ($Team) {
            foreach ($languages as $language) {
                TeamDetail::create([
                    'team_id' => $Team->id,
                    'language_id' => $language->id,
                    'title' => $request['title']['title_' . $language->id] ?? null,
                    'name' => $request['name']['name_' . $language->id] ?? null,
                    'slug' => isset($request['name']['name_' . $language->id]) ? Str::slug($request['name']['name_' . $language->id]) : null,
                ]);
            }
            return $this->apiSuccessResponse(new TeamResource($Team), 'Your changes have been done successfully');
        }
        return $this->errorResponse();
    }


    public function update(Request $request, Team $Team)
    {
        $validationRule = [];
        $errorMessages = [];
        $languages = getAllLanguages();
        foreach ($languages as $language) {
            $requiredVal = 'nullable';
            if ($language->is_default == '1') {
                $requiredVal = 'required';
            }
            $validationRule = array_merge($validationRule, ['title.title_' . $language->id => [$requiredVal, 'string', 
            function ($attribute, $value, $fail) {
                $plainText = trim(strip_tags(html_entity_decode($value)));
                if (str_word_count($plainText) > 30) {
                    $fail('Only 30 words are allowed for the summary.');
                }
            },new CheckCategorySlug($language, null)]]);
            $errorMessages = array_merge($errorMessages, ['title.title_' . $language->id . '.required' => 'Title is required']);
            $validationRule = array_merge($validationRule, ['name.name_' . $language->id => [$requiredVal, 'string', new CheckCategorySlug($language, null)]]);
            $errorMessages = array_merge($errorMessages, ['name.name_' . $language->id . '.required' => 'Name is required']);
        }
        $validationRule = array_merge($validationRule, ['image' => ['required']]);
        $validationRule = array_merge($validationRule, ['status' => ['required']]);
        $errorMessages = array_merge($errorMessages, ['status.required' => 'Status is required']);
        $this->validate(
            $request,
            $validationRule,
            $errorMessages
        );

        $files = null;

        if ($request->has('image') && !empty($request->image)) {
            $media = is_array($request->image)
                ? $request->image
                : json_decode($request->image, true);
        
            if ($media && is_array($media) && isset($media['media']) && !empty($media['media'])) {
                $files = $this->moveFile($media['media'], 'media/images', 'team_image');
        
                if (isset($existingImagePath) && !empty($existingImagePath)) {
                    $this->deleteFile($existingImagePath);
                }
            } else {
                $files = $existingImagePath ?? null;
            }
        } else {
            $files = $existingImagePath ?? null;
        }

        $Team->update([
            'image' => isset($files, $files[0]) ? $files[0]->id : $Team->image,
            'status' => $request->status,
        ]);
        foreach ($languages as $language) {
            $TeamDetail = TeamDetail::whereLanguageId($language->id)->whereTeamId($Team->id)->exists();
            if ($TeamDetail) {
                TeamDetail::whereLanguageId($language->id)->whereTeamId($Team->id)->update([
                    'team_id' => $Team->id,
                    'language_id' => $language->id,
                    'title' => $request['title']['title_' . $language->id] ?? null,
                    'name' => $request['name']['name_' . $language->id] ?? null,
                    'slug' => isset($request['name']['name_' . $language->id]) ? Str::slug($request['name']['name_' . $language->id]) : null,
                ]);
            } else {
                TeamDetail::create([
                    'team_id' => $Team->id,
                    'language_id' => $language->id,
                    'title' => $request['title']['title_' . $language->id] ?? null,
                    'name' => $request['name']['name_' . $language->id] ?? null,
                    'slug' => isset($request['name']['name_' . $language->id]) ? Str::slug($request['name']['name_' . $language->id]) : null,
                ]);
            }
        }

        if ($Team) {
            return $this->apiSuccessResponse(new TeamResource($Team), 'Your changes have been done successfully');
        }
        return $this->errorResponse();
    }

    protected function deleteFile($filePath)
    {
        if (\File::exists($filePath)) {
            \File::delete($filePath);
        }
    }

    public function destroy(Request $request, Team $Team)
    {
        if ($Team->TeamDetail()->delete() && $Team->delete()) {
            return $this->apiSuccessResponse(new TeamResource($Team), 'The selected item has been deleted successfully');
        }
        return $this->errorResponse();
    }

    protected function loadRelations($teams)
    {
        $defaultLang = getDefaultLanguage();
        $teams = $teams->with(['teamDetail' => function ($q) use ($defaultLang) {
            $q->where('language_id', $defaultLang->id);
        }]);
        if (isset($_GET['withTeamDetail']) && $_GET['withTeamDetail'] == '1') {
            $teams = $teams->with('teamDetail');
        }
        return $teams;
    }

    protected function sortingAndLimit($teams)
    {
        $sortType = ['ASC', 'asc', 'DESC', 'desc'];
        $sortBy = ['id', 'title', 'abbreviation', 'team_title'];
        if (isset($_GET['sortBy']) && $_GET['sortBy'] != '' && isset($_GET['sortType']) && $_GET['sortType'] != '' && in_array($_GET['sortBy'], $sortBy) && in_array($_GET['sortType'], $sortType)) {
            $defaultLang = getDefaultLanguage();
            $teams = $teams->addSelect(['team_title' => TeamDetail::whereColumn('teams.id', 'team_details.team_id')->whereLanguageId($defaultLang->id)->select('name')->limit(1)]);

            $teams = $teams->OrderBy($_GET['sortBy'], $_GET['sortType']);
        }

        if (isset($_GET['limit']) && $_GET['limit'] != '') {
            $limit = $_GET['limit'];
        } else {
            $limit = 10;
        }

        return $teams->paginate($limit);
    }

    protected function whereClause($teams)
    {
        if (isset($_GET['searchParam']) && $_GET['searchParam'] != '') {
            $teams = $teams->whereHas('teamDetail', function ($q) {
                $q->where('title', 'LIKE', '%' . $_GET['searchParam'] . '%');
            });
        }
        return $teams;
    }
}
