<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\ActivityResource;
use App\Models\Activity;
use App\Models\ActivityDetail;
use App\Models\Language;
use App\Traits\StatusResponser;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    use StatusResponser;

    public function __construct()
    {
        $this->middleware('password_confirm')->only('destroy');
    }

    public function index(Request $request)
    {
        $activities = Activity::query();

        // Filter by type if specified
        if ($request->has('type')) {
            $activities->where('type', $request->type);
        }

        $activities = $this->whereClause($activities);
        $activities = $this->loadRelations($activities);
        $activities = $this->sortingAndLimit($activities);

        return $this->apiSuccessResponse(ActivityResource::collection($activities), 'Data fetched successfully');
    }

    public function show(Activity $activity)
    {
        if (isset($_GET['withDetails']) && $_GET['withDetails'] == '1') {
            $activity = $activity->loadMissing('details');
        }

        return $this->apiSuccessResponse(new ActivityResource($activity));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $validationRule = [
            'type' => 'required|in:' . implode(',', array_keys(Activity::getTypes())),
            'status' => 'required|boolean',
        ];

        $errorMessages = [
            'type.required' => 'Activity type is required',
            'status.required' => 'Status is required',
        ];

        $languages = getAllLanguages();
        foreach ($languages as $language) {
            $requiredVal = $language->is_default ? 'required' : 'nullable';
            $validationRule['name.name_' . $language->id] = [$requiredVal, 'string'];
            $errorMessages['name.name_' . $language->id . '.required'] = 'Name is required for default language';
        }

        $this->validate($request, $validationRule, $errorMessages);

        $activity = Activity::create([
            'type' => $request->type,
            'status' => $request->status,
        ]);

        foreach ($languages as $language) {
            ActivityDetail::create([
                'activity_id' => $activity->id,
                'language_id' => $language->id,
                'name' => $request['name']['name_' . $language->id] ?? null,
            ]);
        }

        return $this->apiSuccessResponse(new ActivityResource($activity), 'Activity created successfully');
    }

    public function update(Request $request, Activity $activity)
    {
        $validationRule = [
            'status' => 'required|boolean',
        ];

        $errorMessages = [
            'status.required' => 'Status is required',
        ];

        $languages = getAllLanguages();
        foreach ($languages as $language) {
            $requiredVal = $language->is_default ? 'required' : 'nullable';
            $validationRule['name.name_' . $language->id] = [$requiredVal, 'string'];
            $errorMessages['name.name_' . $language->id . '.required'] = 'Name is required for default language';
        }

        $this->validate($request, $validationRule, $errorMessages);

        $activity->update([
            'status' => $request->status,
        ]);

        foreach ($languages as $language) {
            ActivityDetail::updateOrCreate(
                ['activity_id' => $activity->id, 'language_id' => $language->id],
                ['name' => $request['name']['name_' . $language->id] ?? null]
            );
        }

        return $this->apiSuccessResponse(new ActivityResource($activity), 'Activity updated successfully');
    }

    public function destroy(Activity $activity)
    {
        $activity->details()->delete();
        $activity->delete();

        return $this->apiSuccessResponse([], 'Activity deleted successfully');
    }

    protected function loadRelations($query)
    {
        $defaultLang = getDefaultLanguage();
        $query = $query->with([
            'details' => function ($q) use ($defaultLang) {
                $q->where('language_id', $defaultLang->id);
            },
        ]);

        if (isset($_GET['withDetails']) && $_GET['withDetails'] == '1') {
            $query = $query->with('details');
        }

        return $query;
    }

    protected function sortingAndLimit($query)
    {
        $sortBy = request('sortBy', 'id');
        $sortType = request('sortType', 'desc');
        $limit = request('limit', 10);

        if (in_array($sortBy, ['id', 'name']) && in_array($sortType, ['asc', 'desc'])) {
            if ($sortBy === 'name') {
                $defaultLang = getDefaultLanguage();
                $query = $query->addSelect([
                    'name' => ActivityDetail::whereColumn('activities.id', 'activity_details.activity_id')
                        ->where('language_id', $defaultLang->id)
                        ->select('name')
                        ->limit(1)
                ])->orderBy('name', $sortType);
            } else {
                $query = $query->orderBy($sortBy, $sortType);
            }
        }

        return $query->paginate($limit);
    }

    protected function whereClause($query)
    {
        if (request('searchParam')) {
            $query = $query->whereHas('details', function ($q) {
                $q->where('name', 'LIKE', '%' . request('searchParam') . '%');
            });
        }

        return $query;
    }
    public function saveDefaultLanguageActivity(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string',
            'type' => 'required|in:sport,curricular,extracurricular,leadership,media,music_performance,social_activism,technology,entrepreneurship,environmental,health_wellness,stem_competitions'
        ]);

        $language = getDefaultLanguage();
        $activity = Activity::create([
            'type' => $request->type,
            'status' => 0,
        ]);

        if ($activity) {
            ActivityDetail::create([
                'activity_id' => $activity->id,
                'language_id' => $language->id,
                'name' => $request->name,
            ]);
            return $this->apiSuccessResponse(new ActivityResource($activity), 'Activity created successfully');
        }

        return $this->errorResponse();
    }
}
