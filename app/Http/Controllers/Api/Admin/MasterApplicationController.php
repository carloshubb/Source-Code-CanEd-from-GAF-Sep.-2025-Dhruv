<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\MasterApplicationResource;
use Illuminate\Support\Str;
use App\Models\MasterApplication;
use App\Models\MasterApplicationDetail;
use App\Models\Language;
use App\Models\SchoolDetail;
use App\Rules\CheckCategorySlug;
use App\Traits\StatusResponser;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MasterApplicationController extends Controller
{
    use StatusResponser;
    use FileUploadTrait;

    public function __construct()
    {
        $this->middleware('password_confirm')->only('destroy');
    }

    public function index()
    {
        $MasterApplications = MasterApplication::query();
        $MasterApplications = $this->whereClause($MasterApplications);
        if (isset($_GET['school']) && !empty($_GET['school'])) {
            $MasterApplications = $MasterApplications->where('school_id', $_GET['school']);
        }
        $MasterApplications = $this->loadRelations($MasterApplications);
        $MasterApplications = $this->sortingAndLimit($MasterApplications);

        return $this->apiSuccessResponse(MasterApplicationResource::collection($MasterApplications), 'Data Get Successfully!');
    }

    public function show(MasterApplication $MasterApplication)
    {
        return $this->apiSuccessResponse(new MasterApplicationResource($MasterApplication), 'Data Get Successfully!');
    }

    public function store(Request $request)
    {
    }

    public function destroy(Request $request, MasterApplication $MasterApplication)
    {
        if ($MasterApplication->delete()) {
            return $this->apiSuccessResponse(new MasterApplicationResource($MasterApplication), 'The selected item has been deleted successfully');
        }
        return $this->errorResponse();
    }

    protected function loadRelations($MasterApplications)
    {
        $defaultLang = getDefaultLanguage();
        return $MasterApplications;
    }

    protected function sortingAndLimit($MasterApplications)
    {
        if (isset($_GET['limit']) && $_GET['limit'] != '') {
            $limit = $_GET['limit'];
        } else {
            $limit = 10;
        }

        $MasterApplications = $MasterApplications->addSelect([
            'master_application_school_name' => function ($query) {
                $query->select('school_name')
                    ->from('school_details')
                    ->whereColumn('master_applications.school_id', 'school_details.school_id')
                    ->limit(1);
            }
        ])->orderByRaw('master_application_school_name ASC');
        
        return $MasterApplications->paginate($limit);
    }

    protected function whereClause($MasterApplications)
    {
        if (isset($_GET['searchParam']) && $_GET['searchParam'] != '') {
            $MasterApplications =
                $MasterApplications
                ->where('first_name', 'LIKE', '%' . $_GET['searchParam'] . '%')
                ->orWhere('last_name', 'LIKE', '%' . $_GET['searchParam'] . '%')
                ->orWhere('email', $_GET['searchParam'])
                ->orWhereHas('school', function ($q) {
                    $q->where('email', $_GET['searchParam']);
                    $q->orWhereHas('schoolDetail', function ($q) {
                        $q->where('school_name', 'LIKE', '%' . $_GET['searchParam'] . '%');
                    });
                });
            // ->orWhereHas('school', function ($q) {
            //     $q->Where('email',$_GET['searchParam']);
            //     $q->orWhereHas('schoolDetail', function ($q) {
            //         $q->whereHas('school_name', 'LIKE', '%' . $_GET['searchParam'] . '%');
            //     });
            // });
        }
        return $MasterApplications;
    }
}
