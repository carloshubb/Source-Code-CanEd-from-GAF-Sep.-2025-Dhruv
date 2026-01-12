<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\OpenDayResource;
use App\Jobs\StatusApprovelEmailJob;
use Illuminate\Support\Str;
use App\Models\OpenDay;
use App\Models\Language;
use App\Models\OpenDayDetail;
use App\Models\SchoolDetail;
use App\Rules\CheckCategorySlug;
use App\Traits\StatusResponser;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;

class OpenDayController extends Controller
{
    use StatusResponser;
    use FileUploadTrait;

    public function __construct()
    {
        $this->middleware('password_confirm')->only('destroy');
    }

    public function index()
    {
        $OpenDays = OpenDay::query();
        $OpenDays = $this->whereClause($OpenDays);
        $OpenDays = $this->loadRelations($OpenDays);
        $OpenDays = $this->sortingAndLimit($OpenDays);
        
        // dd($OpenDays);
        return $this->apiSuccessResponse(OpenDayResource::collection($OpenDays), 'Data Get Successfully!');
    }

    public function show(OpenDay $OpenDay)
    {
        $OpenDay->load('OpenDayDetail', 'school.schoolDetail');
        return $this->apiSuccessResponse(new OpenDayResource($OpenDay), 'Data Get Successfully!');
    }

    public function store(Request $request)
    {
        $OpenDay = OpenDay::create([
            'address' => $request->address,
            'city' => $request->city,
            'country' => $request->country,
            'postal_code' => $request->postal_code,
            'date' => $request->date,
            'time' => $request->time,
            'school_email' => $request->school_email,
            'school_phone' => $request->school_phone,
            'open_day_url' => $request->open_day_url,
            'image' => $request->image,
            'status' => $request->status,
        ]);

        if ($OpenDay) {
            return $this->apiSuccessResponse(new OpenDayResource($OpenDay), 'Your changes have been done successfully');
        }
        return $this->errorResponse();
    }

    public function update(Request $request, OpenDay $OpenDay)
    {
        $sendEmail = 0;
        if ($request->status != $OpenDay->status) {
            $sendEmail = 1;
        }
        $OpenDay->update([
            'address' => $request->address,
            'city' => $request->city,
            'country' => $request->country,
            'postal_code' => $request->postal_code,
            'date' => $request->date,
            'time' => $request->time,
            'school_email' => $request->school_email,
            'school_phone' => $request->school_phone,
            'open_day_url' => $request->open_day_url,
            'image' => $request->image,
            'status' => $request->status,
        ]);
        OpenDayDetail::whereOpenDayId($OpenDay->id)
        ->update([
            'title' => $request->title,
            'description' => $request->description,
        ]);
        if ($OpenDay) {
            if ($sendEmail && isset($OpenDay->school->customer)) {
                $customer = isset($OpenDay->school->customer) ? $OpenDay->school->customer->first_name . ' ' . $OpenDay->school->customer->last_name : '';
                $customer_email = isset($OpenDay->school->customer) ? $OpenDay->school->customer->email : '';
                
                $emailData = [
                    'customer' => $customer,
                    'record_type_string' => isset($OpenDay->openDayDetail[0]->title) ? $OpenDay->openDayDetail[0]->title : '',
                    'status' => $request->status,
                    'email' => $customer_email
                ];
                $emailData = dispatch(new StatusApprovelEmailJob($emailData));
            }
            return $this->apiSuccessResponse(new OpenDayResource($OpenDay), 'Your changes have been done successfully');
        }
        return $this->errorResponse();
    }

    public function destroy(Request $request, OpenDay $OpenDay)
    {
        if ($OpenDay->delete()) {
            return $this->apiSuccessResponse(new OpenDayResource($OpenDay), 'The selected item has been deleted successfully');
        }
        return $this->errorResponse();
    }

    protected function loadRelations($OpenDays)
    {
        $OpenDays=$OpenDays->with(['school.schoolDetail','OpenDayDetail']);
        return $OpenDays;
    }

    protected function sortingAndLimit($OpenDays)
    {
        $sortType = ['ASC', 'asc', 'DESC', 'desc'];
        $sortBy = ['id', 'city', 'country', 'province'];
        // if (isset($_GET['sortBy']) && $_GET['sortBy'] != '' && isset($_GET['sortType']) && $_GET['sortType'] != '' && in_array($_GET['sortBy'], $sortBy) && in_array($_GET['sortType'], $sortType)) {
        //     $OpenDays = $OpenDays->OrderBy($_GET['sortBy'], $_GET['sortType']);
        // }
        // if (isset($_GET['sortBy']) && $_GET['sortBy'] != '' && isset($_GET['sortType']) && $_GET['sortType'] != '' && in_array($_GET['sortBy'], $sortBy) && in_array($_GET['sortType'], $sortType)) {
            $OpenDays = $OpenDays->with(['school.schoolDetail'])  // Eager load school and school_details
            ->orderBy(SchoolDetail::select('school_name')->whereColumn('school_id', 'open_days.school_id')->limit(1), 'ASC');  // Order by school_name
        
        if (isset($_GET['limit']) && $_GET['limit'] != '') {
            $limit = $_GET['limit'];
        } else {
            $limit = 10;
        }

        return $OpenDays->paginate($limit);
    }

    protected function whereClause($OpenDays)
    {
        if (isset($_GET['searchParam']) && $_GET['searchParam'] != '') {
            $OpenDays = $OpenDays
                ->where('city', 'LIKE', '%' . $_GET['searchParam'] . '%')
                ->orWhere('country', 'LIKE', '%' . $_GET['searchParam'] . '%')
                ->orWhereHas('OpenDayDetail', function ($query) {
                    $query->where('title', 'LIKE', '%' . $_GET['searchParam'] . '%');
                })
                ->orWhereHas('school.schoolDetail', function ($query) {
                    $query->where('school_name', 'LIKE', '%' . $_GET['searchParam'] . '%');
                });
        }
        return $OpenDays;
    }
}
