<?php

namespace App\Http\Controllers\Api\Web;

use App\Http\Controllers\Controller;
use App\Http\Resources\Web\SchoolTeamResource;
use App\Models\SchoolTeam;
use App\Traits\StatusResponser;
use Illuminate\Http\Request;

class SchoolTeamController extends Controller
{
    use StatusResponser;

    public function __construct()
    {
        $this->middleware('password_confirm')->only('destroy');
    }

    public function index()
    {
        $school_team = SchoolTeam::query();
        $sortType = ['ASC', 'asc', 'DESC', 'desc'];
        $sortBy = ['id', 'name'];

        if (isset($_GET['sortBy']) && $_GET['sortBy'] != '' && isset($_GET['sortType']) && $_GET['sortType'] != '' && in_array($_GET['sortBy'], $sortBy) && in_array($_GET['sortType'], $sortType)) {
            $school_team = $school_team->OrderBy($_GET['sortBy'], $_GET['sortType']);
        }

        if (isset($_GET['is_admin'])) {
            $school_team = $school_team->where('school_id', $_GET['school_id'])
                ->get();
        } else {
            $customer = auth()
                ->guard('customers')
                ->user();
            $customerId = $customer->id;
            $school_team = $school_team->where('school_id', $_GET['school_id'])
                ->get();
        }

        return $this->successResponse(isset($school_team) ? SchoolTeamResource::collection($school_team) : null, 'Data get successfully.');
    }

    public function update(Request $request)
    {
        $validationRule = [];
        $errorMessages = [];
        $languages = getAllLanguages();
        $validationRule = array_merge($validationRule, ['name' => ['required', 'string']]);
        $validationRule = array_merge($validationRule, ['designation' => ['required', 'string']]);
        // $validationRule = array_merge($validationRule, ['summary' => ['required', 'string']]);
        $validationRule = array_merge($validationRule, [
            'summary' => [
                'required',
                'string',
                function ($attribute, $value, $fail) {
                    $plainText = trim(strip_tags(html_entity_decode($value)));
                    if (str_word_count($plainText) > 300) {
                        $fail('Only 300 words are allowed for the summary.');
                    }
                }
            ]
        ]);
        
        $errorMessages = array_merge($errorMessages, [
            'summary.required' => 'Summary is required.',
        ]);
        $validationRule = array_merge($validationRule, ['phone' => ['required', 'string']]);
        $validationRule = array_merge($validationRule, ['email' => ['required', 'string', 'email']]);

        $errorMessages = array_merge($errorMessages, [
            'phone.required' => 'This field is required.',
        ]);
        $this->validate($request, $validationRule, $errorMessages);
        $fields = [
            'school_id' => $request->school_id,
            'name' => $request->name,
            'designation' => $request->designation,
            'summary' => $request->summary,
            'phone' => $request->phone,
            'email' => $request->email,
            'image' => isset($request->image) && is_array($request->image) ? implode(',', $request->image) : null,
        ];
        if (isset($request->id)) {
            SchoolTeam::whereId($request->id)->update($fields);
            $school_team = SchoolTeam::whereId($request->id)->first();
        } else {
            $school_team = SchoolTeam::create($fields);
        }

        $school_team->touch();


        if ($school_team) {
            return $this->apiSuccessResponse(new SchoolTeamResource($school_team), 'Your changes have been done successfully');
        }
        return $this->errorResponse();
    }

    public function destroy(Request $request, $school_teamId)
    {
        $school_team = SchoolTeam::find($school_teamId);
        if ($school_team->delete()) {
            return $this->apiSuccessResponse(new SchoolTeamResource($school_team), 'The selected item has been deleted successfully');
        }
        return $this->errorResponse();
    }
}
