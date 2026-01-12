<?php

namespace App\Http\Controllers\Api\Web;

use App\Http\Controllers\Controller;
use App\Http\Resources\Web\SchoolEmployeeResource;
use Illuminate\Support\Str;
use App\Models\SchoolEmployee;
use App\Models\SchoolEmployeeDetail;
use App\Traits\StatusResponser;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;

class SchoolEmployeeController extends Controller
{
    use StatusResponser;
    use FileUploadTrait;

    public function __construct()
    {
        $this->middleware('password_confirm')->only('destroy');
    }

    public function index()
    {
        $customer = auth()
            ->guard('customers')
            ->user();
        $schoolEmployees = SchoolEmployee::whereCustomerId($customer->id);

        $schoolEmployees = $this->whereClause($schoolEmployees);
        $schoolEmployees = $this->loadRelations($schoolEmployees);
        $schoolEmployees = $this->sortingAndLimit($schoolEmployees);
        return $this->apiSuccessResponse(SchoolEmployeeResource::collection($schoolEmployees), 'Data Get Successfully!');
    }

    public function show(SchoolEmployee $SchoolEmployee)
    {
        if (isset($_GET['withSchoolEmployeeDetail']) && $_GET['withSchoolEmployeeDetail'] == '1') {
            $SchoolEmployee = $SchoolEmployee->loadMissing('schoolEmployeeDetail');
        }

        return $this->apiSuccessResponse(new SchoolEmployeeResource($SchoolEmployee), 'Data Get Successfully!');
    }

    public function store(Request $request)
    {
        $validationRule = [];
        $errorMessages = [];
        $languages = getAllLanguages();
        foreach ($languages as $language) {
            if ($language->is_default == 1) {
                $validationRule = array_merge($validationRule, ['name.name_' . $language->abbreviation => ['required', 'string']]);
                $errorMessages = array_merge($errorMessages, ['name.name_' . $language->abbreviation . '.required' => 'Name is required']);
                $validationRule = array_merge($validationRule, ['description.description_' . $language->abbreviation => ['required', 'string']]);
                $errorMessages = array_merge($errorMessages, ['description.description_' . $language->abbreviation . '.required' => 'Description is required']);
            }
        }
        $validationRule = array_merge($validationRule, ['position' => ['required', 'string']]);
        $errorMessages = array_merge($errorMessages, ['position' . '.required' => 'Position is required']);
        // $validationRule = array_merge($validationRule, ['telephone' => ['required', 'string', 'regex:/^[\+\-\(\)\d]{1,15}$/']]);
        $validationRule = array_merge($validationRule, [
            'telephone' => 'required|string',
            'telephone.*' => 'required|regex:/^[\+\-\(\)\d]{1,15}$/',
            
        ]);
        $errorMessages = array_merge($errorMessages, [
            'telephone' . '.required' => 'Telephone is required',
            'telephone.*.regex' => 'Phone number cannot exceed 15 digits'
        ]);
        $validationRule = array_merge($validationRule, ['more_1' => ['required', 'string']]);
        $errorMessages = array_merge($errorMessages, ['more_1' . '.required' => 'more_1 is required.']);
        $validationRule = array_merge($validationRule, ['email' => ['required', 'string', 'email']]);
        $errorMessages = array_merge($errorMessages, ['email' . '.required' => 'Email is required']);
        $validationRule = array_merge($validationRule, ['more_2' => ['required', 'string']]);
        $errorMessages = array_merge($errorMessages, ['more_2' . '.required' => 'more_2 is required']);
        $validationRule = array_merge($validationRule, ['order' => ['required', 'string']]);
        $errorMessages = array_merge($errorMessages, ['order' . '.required' => 'Order is required']);
        $validationRule = array_merge($validationRule, ['image' => ['required', 'string']]);
        $errorMessages = array_merge($errorMessages, ['image' . '.required' => 'Image is required']);

        $this->validate($request, $validationRule, $errorMessages);
        $SchoolEmployee = SchoolEmployee::create([
            'position' => $request->position,
            'telephone' => $request->telephone,
            'more_1' => $request->more_1,
            'email' => $request->email,
            'more_2' => $request->more_2,
            'order' => $request->order,
            'image' => $request->image,
            'customer_id' => $request->customer_id,
            'school_id' => $request->school_id,
        ]);

        if ($SchoolEmployee) {
            foreach ($request->languages as $language) {
                if (!empty($request['name']['name_' . $language['language_code']]) && !empty($request['description']['description_' . $language['language_code']])) {
                    SchoolEmployeeDetail::create([
                        'school_employee_id' => $SchoolEmployee->id,
                        'language_code' => $language['language_code'],
                        'name' => $request['name']['name_' . $language['language_code']],
                        'description' => $request['description']['description_' . $language['language_code']],
                    ]);
                }
            }
            return $this->apiSuccessResponse(new SchoolEmployeeResource($SchoolEmployee), 'Your changes have been done successfully');
        }
        return $this->errorResponse();
    }

    public function update(Request $request, SchoolEmployee $SchoolEmployee)
    {
        $validationRule = [];
        $errorMessages = [];
        $languages = getAllLanguages();
        foreach ($languages as $language) {
            if ($language->is_default == 1) {
                $validationRule = array_merge($validationRule, ['name.name_' . $language->abbreviation => ['required', 'string']]);
                $errorMessages = array_merge($errorMessages, ['name.name_' . $language->abbreviation . '.required' => 'Name is required']);
                $validationRule = array_merge($validationRule, ['description.description_' . $language->abbreviation => ['required', 'string']]);
                $errorMessages = array_merge($errorMessages, ['description.description_' . $language->abbreviation . '.required' => 'Description is required']);
            }
        }
        $validationRule = array_merge($validationRule, ['position' => ['required', 'string']]);
        $errorMessages = array_merge($errorMessages, ['position' . '.required' => 'Department is required']);
        $validationRule = array_merge($validationRule, ['telephone' => ['required', 'string', 'digits_between:1,15']]);
        $errorMessages = array_merge($errorMessages, [
            'telephone' . '.required' => 'Telephone is required',
            'telephone.digits_between' => 'Phone number cannot exceed 15 digits'
        ]);
        $validationRule = array_merge($validationRule, ['more_1' => ['required', 'string']]);
        $errorMessages = array_merge($errorMessages, ['more_1' . '.required' => 'more_1 is required']);
        $validationRule = array_merge($validationRule, ['email' => ['required', 'string', 'email']]);
        $errorMessages = array_merge($errorMessages, ['email' . '.required' => 'Email is required']);
        $validationRule = array_merge($validationRule, ['more_2' => ['required', 'string']]);
        $errorMessages = array_merge($errorMessages, ['more_2' . '.required' => 'more_2 is required']);
        $validationRule = array_merge($validationRule, ['order' => ['required', 'string']]);
        $errorMessages = array_merge($errorMessages, ['order' . '.required' => 'Order is required']);
        $validationRule = array_merge($validationRule, ['image' => ['required', 'string']]);
        $errorMessages = array_merge($errorMessages, ['image' . '.required' => 'Image is required.']);

        $this->validate($request, $validationRule, $errorMessages);

        $SchoolEmployee->update([
            'position' => $request->position,
            'telephone' => $request->telephone,
            'more_1' => $request->more_1,
            'email' => $request->email,
            'more_2' => $request->more_2,
            'order' => $request->order,
            'image' => $request->image,
            'customer_id' => $request->customer_id,
            'school_id' => $request->school_id,
        ]);
        foreach ($request->languages as $language) {
            if (!empty($request['name']['name_' . $language['language_code']]) && !empty($request['description']['description_' . $language['language_code']])) {
                $SchoolEmployeeDetail = SchoolEmployeeDetail::whereLanguageCode($language['language_code'])
                    ->whereSchoolEmployeeId($SchoolEmployee->id)
                    ->exists();
                if ($SchoolEmployeeDetail) {
                    SchoolEmployeeDetail::whereLanguageCode($language['language_code'])
                        ->whereSchoolEmployeeId($SchoolEmployee->id)
                        ->update([
                            'school_employee_id' => $SchoolEmployee->id,
                            'language_code' => $language['language_code'],
                            'name' => $request['name']['name_' . $language['language_code']],
                            'description' => $request['description']['description_' . $language['language_code']],
                        ]);
                } else {
                    SchoolEmployeeDetail::create([
                        'school_employee_id' => $SchoolEmployee->id,
                        'language_code' => $language['language_code'],
                        'name' => $request['name']['name_' . $language['language_code']],
                        'description' => $request['description']['description_' . $language['language_code']],
                    ]);
                }
            }
        }

        if ($SchoolEmployee) {
            return $this->apiSuccessResponse(new SchoolEmployeeResource($SchoolEmployee), 'Your changes have been done successfully');
        }
        return $this->errorResponse();
    }

    public function destroy(Request $request, SchoolEmployee $SchoolEmployee)
    {
        if ($SchoolEmployee->SchoolEmployeeDetail()->delete() && $SchoolEmployee->delete()) {
            return $this->apiSuccessResponse(new SchoolEmployeeResource($SchoolEmployee), 'The selected item has been deleted successfully');
        }
        return $this->errorResponse();
    }

    protected function loadRelations($schoolEmployees)
    {
        $defaultLang = getDefaultLanguage();
        $schoolEmployees = $schoolEmployees->with([
            'schoolEmployeeDetail' => function ($q) use ($defaultLang) {
                $q->where('language_code', $defaultLang->abbreviation);
            },
        ]);
        if (isset($_GET['withSchoolEmployeeDetail']) && $_GET['withSchoolEmployeeDetail'] == '1') {
            $schoolEmployees = $schoolEmployees->with('schoolEmployeeDetail');
        }
        return $schoolEmployees;
    }

    protected function sortingAndLimit($schoolEmployees)
    {
        $sortType = ['ASC', 'asc', 'DESC', 'desc'];
        $sortBy = ['id', 'name', 'abbreviation', 'school_employee_name'];
        if (isset($_GET['sortBy']) && $_GET['sortBy'] != '' && isset($_GET['sortType']) && $_GET['sortType'] != '' && in_array($_GET['sortBy'], $sortBy) && in_array($_GET['sortType'], $sortType)) {
            $defaultLang = getDefaultLanguage();
            $schoolEmployees = $schoolEmployees->addSelect(['school_employee_name' => SchoolEmployeeDetail::whereColumn('school_employees.id', 'school_employee_details.school_employee_id')->whereLanguageCode($defaultLang->abbreviation)->select('name')->limit(1)]);


            $schoolEmployees = $schoolEmployees->OrderBy($_GET['sortBy'], $_GET['sortType']);
        }

        if (isset($_GET['limit']) && $_GET['limit'] != '') {
            $limit = $_GET['limit'];
        } else {
            $limit = 10;
        }

        return $schoolEmployees->paginate($limit);
    }

    protected function whereClause($schoolEmployees)
    {
        if (isset($_GET['searchParam']) && $_GET['searchParam'] != '') {
            $schoolEmployees = $schoolEmployees->whereHas('schoolEmployeeDetail', function ($q) {
                $q->where('name', 'LIKE', '%' . $_GET['searchParam'] . '%');
            });
        }
        return $schoolEmployees;
    }
}
