<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\LeadershipSkillResource;
use Illuminate\Support\Str;
use App\Models\LeadershipSkill;
use App\Models\LeadershipSkillDetail;
use App\Models\Language;
use App\Rules\CheckCategorySlug;
use App\Traits\StatusResponser;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;

class LeadershipSkillController extends Controller
{
    use StatusResponser;
    use FileUploadTrait;

    public function __construct()
    {
        $this->middleware('password_confirm')->only('destroy');
    }

    public function index()
    {
        $leadershipSkill = LeadershipSkill::query();

        $leadershipSkill = $this->whereClause($leadershipSkill);
        $leadershipSkill = $this->loadRelations($leadershipSkill);
        $leadershipSkill = $this->sortingAndLimit($leadershipSkill);

        return $this->apiSuccessResponse(LeadershipSkillResource::collection($leadershipSkill), 'Data Get Successfully!');
    }

    public function show(LeadershipSkill $LeadershipSkill)
    {
        if (isset($_GET['withLeadershipSkillDetail']) && $_GET['withLeadershipSkillDetail'] == '1') {
            $LeadershipSkill = $LeadershipSkill->loadMissing('leadershipSkillDetail');
        }

        return $this->apiSuccessResponse(new LeadershipSkillResource($LeadershipSkill), 'Data Get Successfully!');
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
        $LeadershipSkill = LeadershipSkill::create([
            'status' => $request->status,
        ]);

        if ($LeadershipSkill) {
            foreach ($languages as $language) {
                LeadershipSkillDetail::create([
                    'leadership_skill_id' => $LeadershipSkill->id,
                    'language_id' => $language->id,
                    'name' => $request['name']['name_' . $language->id],
                ]);
            }
            return $this->apiSuccessResponse(new LeadershipSkillResource($LeadershipSkill), 'Your changes have been done successfully');
        }
        return $this->errorResponse();
    }

    public function update(Request $request, LeadershipSkill $LeadershipSkill)
    {
        $validationRule = [];
        $errorMessages = [];
        $languages = getAllLanguages();
        foreach ($languages as $language) {
            $validationRule = array_merge($validationRule, ['name.name_' . $language->id => ['required', 'string', new CheckCategorySlug($language, $LeadershipSkill->id)]]);
            $errorMessages = array_merge($errorMessages, ['name.name_' . $language->id . '.required' => 'Name in ' . $language->name . ' is required.']);
        }

        $this->validate($request, $validationRule, $errorMessages);

        $LeadershipSkill->update([
            'status' => $request->status,
        ]);
        foreach ($languages as $language) {
            $LeadershipSkillDetail = LeadershipSkillDetail::whereLanguageId($language->id)
                ->whereLeadershipSkillId($LeadershipSkill->id)
                ->exists();
            if ($LeadershipSkillDetail) {
                LeadershipSkillDetail::whereLanguageId($language->id)
                    ->whereLeadershipSkillId($LeadershipSkill->id)
                    ->update([
                        'leadership_skill_id' => $LeadershipSkill->id,
                        'language_id' => $language->id,
                        'name' => $request['name']['name_' . $language->id],
                    ]);
            } else {
                LeadershipSkillDetail::create([
                    'leadership_skill_id' => $LeadershipSkill->id,
                    'language_id' => $language->id,
                    'name' => $request['name']['name_' . $language->id],
                ]);
            }
        }

        if ($LeadershipSkill) {
            return $this->apiSuccessResponse(new LeadershipSkillResource($LeadershipSkill), 'Your changes have been done successfully');
        }
        return $this->errorResponse();
    }

    public function destroy(Request $request, LeadershipSkill $LeadershipSkill)
    {
        if ($LeadershipSkill->LeadershipSkillDetail()->delete() && $LeadershipSkill->delete()) {
            return $this->apiSuccessResponse(new LeadershipSkillResource($LeadershipSkill), 'The selected item has been deleted successfully');
        }
        return $this->errorResponse();
    }

    protected function loadRelations($leadershipSkill)
    {
        $defaultLang = getDefaultLanguage();
        $leadershipSkill = $leadershipSkill->with([
            'leadershipSkillDetail' => function ($q) use ($defaultLang) {
                $q->where('language_id', $defaultLang->id);
            },
        ]);
        if (isset($_GET['withLeadershipSkillDetail']) && $_GET['withLeadershipSkillDetail'] == '1') {
            $leadershipSkill = $leadershipSkill->with('leadershipSkillDetail');
        }
        return $leadershipSkill;
    }

    protected function sortingAndLimit($leadershipSkill)
    {
        $sortType = ['ASC', 'asc', 'DESC', 'desc'];
        $sortBy = ['id', 'leadership_skill_name'];
        if (isset($_GET['sortBy']) && $_GET['sortBy'] != '' && isset($_GET['sortType']) && $_GET['sortType'] != '' && in_array($_GET['sortBy'], $sortBy) && in_array($_GET['sortType'], $sortType)) {
            $defaultLang = getDefaultLanguage();
            $leadershipSkill = $leadershipSkill->addSelect(['leadership_skill_name' => LeadershipSkillDetail::whereColumn('leadership_skills.id', 'leadership_skill_details.leadership_skill_id')->whereLanguageId($defaultLang->id)->select('name')->limit(1)]);

            $leadershipSkill = $leadershipSkill->OrderBy($_GET['sortBy'], $_GET['sortType']);
        }

        if (isset($_GET['limit']) && $_GET['limit'] != '') {
            $limit = $_GET['limit'];
        } else {
            $limit = 10;
        }

        return $leadershipSkill->paginate($limit);
    }

    protected function whereClause($leadershipSkill)
    {
        if (isset($_GET['searchParam']) && $_GET['searchParam'] != '') {
            $leadershipSkill = $leadershipSkill->whereHas('leadershipSkillDetail', function ($q) {
                $q->where('name', 'LIKE', '%' . $_GET['searchParam'] . '%');
            });
        }
        return $leadershipSkill;
    }
}
