<?php

namespace App\Http\Controllers\Api\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CustomerRequest;
use App\Http\Resources\Admin\CustomerResource;
use App\Jobs\CredentialsSendEmailJob;
use App\Jobs\SchoolInvitaionEmailJob;
use App\Models\Business;
use App\Models\Customer;
use App\Models\CustomerLanguage;
use App\Models\DemetraCommunityService;
use App\Models\DemetraPageSetting;
use App\Models\DemetraSport;
use App\Models\MessagingAppDetail;
use App\Models\OpenDay;
use App\Models\Quote;
use App\Models\ScholarshipSetting;
use App\Models\School;
use App\Models\CustomerMessagingAppDetail;
use App\Models\DemetraActivity;
use App\Models\DemetraCurricularActivity;
use App\Models\SchoolDemetraSetting;
use App\Models\SchoolReverseSearchFilter;
use App\Models\SchoolScholarship;
use App\Models\VirtualTour;
use App\Traits\StatusResponser;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{
    use StatusResponser;
    use FileUploadTrait;

    public function index()
    {
        $customers = Customer::query();

        $customers = $this->whereClause($customers);
        $customers = $this->loadRelations($customers);
        $customers = $this->sortingAndLimit($customers);

        return $this->apiSuccessResponse(CustomerResource::collection($customers), 'Data Get Successfully!');
    }

    public function show(Customer $customer)
    {
        if (isset($_GET['withFlagIcon']) && $_GET['withFlagIcon'] == '1') {
            $customer = $customer->loadMissing('flagIcon');
        }

        return $this->apiSuccessResponse(new CustomerResource($customer), 'Data Get Successfully!');
    }

    public function updateProfile(CustomerRequest $request)
    {
        $customer = Customer::where('id', $request->id)->first();
        CustomerMessagingAppDetail::where('customer_id', $customer->id)->delete();
        if (isset($request->messagingAppDetail_id) && $request->messagingAppDetail_id !== ['[', ']']) {
            foreach ($request->messagingAppDetail_id as $appId) {
               
                    CustomerMessagingAppDetail::create([
                        'messaging_app_detail_id' => $appId,
                        'customer_id' => $customer->id
                    ]);
            }
        }
    
        $customer->update($request->except('messagingAppDetail_id'));
    
        if ($customer) {
            return $this->apiSuccessResponse(new CustomerResource($customer), 'Your changes have been done successfully');
        }
    
        return $this->errorResponse();
    }
    




    public function update(Request $request, Customer $customer)
    {
        $result = Customer::whereId($request->id)->update($request->all());

        if ($result) {
            return $this->apiSuccessResponse(new CustomerResource($customer), 'Your changes have been done successfully');
        }
        return $this->errorResponse();
    }

    public function destroy(Customer $customer)
    {
        $bcdExists = Customer::whereCustomerId($customer->id)->exists();
        if ($bcdExists) {
            return $this->errorResponse('Sorry, you can not delete this because its already used in business categories.');
        }
        if ($customer->is_default) {
            return $this->errorResponse('Sorry, you can not delete this because its default customer.');
        }
        if ($customer->delete()) {
            return $this->apiSuccessResponse(new CustomerResource($customer), 'The selected item has been deleted successfully');
        }
        return $this->errorResponse();
    }

    protected function removeDefaultCustomer($customer)
    {
        Customer::where('id', '!=', $customer->id)->update([
            'is_default' => 0,
        ]);
    }

    protected function loadRelations($customers)
    {
        if (isset($_GET['withFlagIcon']) && $_GET['withFlagIcon'] == '1') {
            $customers = $customers->with('flagIcon');
        }
        return $customers;
    }

    protected function sortingAndLimit($customers)
    {
        if (isset($_GET['getAll']) && $_GET['getAll'] == '1') {
            return $customers
                ->orderBy('is_default', 'desc')
                ->orderBy('name', 'asc')
                ->get();
        }

        $sortType = ['ASC', 'asc', 'DESC', 'desc'];
        $sortBy = ['id', 'name', 'abbreviation', 'native_name'];
        if (isset($_GET['sortBy']) && $_GET['sortBy'] != '' && isset($_GET['sortType']) && $_GET['sortType'] != '' && in_array($_GET['sortBy'], $sortBy) && in_array($_GET['sortType'], $sortType)) {
            $customers = $customers->OrderBy($_GET['sortBy'], $_GET['sortType']);
        }

        if (isset($_GET['limit']) && $_GET['limit'] != '') {
            $limit = $_GET['limit'];
        } else {
            $limit = 10;
        }

        return $customers->paginate($limit);
    }

    protected function whereClause($customers)
    {
        if (isset($_GET['searchParam']) && $_GET['searchParam'] != '') {
            $customers = $customers
                ->where('name', 'LIKE', '%' . $_GET['searchParam'] . '%')
                ->orWhere('abbreviation', 'LIKE', '%' . $_GET['searchParam'] . '%')
                ->orWhere('native_name', 'LIKE', '%' . $_GET['searchParam'] . '%');
        }
        return $customers;
    }

    public function VaidateCustomerEmail(Request $request)
    {
        $validationRule = [
            'email' => 'required|email|unique:customers,email',
        ];
        $request->validate($validationRule);

        if (Customer::whereEmail($request->email)->exists()) {
            return $this->errorResponse([], 'Email already exists');
        }

        return $this->errorResponse();
    }


    public function VaidateBusinessEmail(Request $request)
    {
        $validationRule = [
            'email' => 'required|email|unique:businesses,email|unique:customers,email',
        ];
        $request->validate($validationRule);

        if (Business::whereEmail($request->email)->exists()) {
            return $this->successResponse([], 'Email already exist');
        }
        return $this->errorResponse();
    }

    public function VaidateSchoolEmail(Request $request)
    {
        if (School::whereEmail($request->email)->exists()) {
            return $this->successResponse([], 'Email already exist');
        }
        return $this->errorResponse();
    }

    public function deleteAccount(Request $request)
    {
        if (Customer::whereId($request->customer_id)->delete()) {
            if (School::whereCustomerId($request->customer_id)->exists()) {
                School::whereCustomerId($request->customer_id)->delete();
            }
            if (Business::whereCustomerId($request->customer_id)->exists()) {
                Business::whereCustomerId($request->customer_id)->delete();
            }
            if (SchoolScholarship::whereCustomerId($request->customer_id)->exists()) {
                School::whereCustomerId($request->customer_id)->delete();
            }
            if (OpenDay::whereCustomerId($request->customer_id)->exists()) {
                OpenDay::whereCustomerId($request->customer_id)->delete();
            }
            if (VirtualTour::whereCustomerId($request->customer_id)->exists()) {
                Quote::whereCustomerId($request->customer_id)->delete();
            }
            if (CustomerLanguage::whereCustomerId($request->customer_id)->exists()) {
                CustomerLanguage::whereCustomerId($request->customer_id)->delete();
            }
            if (\Auth::guard('customers')->check()) {
                \Auth::guard('customers')->logout();
            }
            return $this->successResponse([], 'Customer has been deleted successfully.');
        }
        return $this->errorResponse();
    }

    public function updateStudent(Request $request)
    {
        $validationRule = [
            'first_name' => ['required', 'string'],
            'last_name' => ['required', 'string'],
            'email' => ['required', 'email'],
            'cgpa' => ['required'],
            'degree_id' => ['required'],
            'messagingAppDetail_id' => ['required'],
            'program_id' => ['required'],
            'area_of_excellence' => ['required', 'string'],
            'area_of_excellence_sub' => ['required', 'string'],
            'type_of_help' => ['required', 'string'],
            'preferred_location' => ['required', 'string'],
        ];
        $this->validate($request, $validationRule);
        $customer_id = \Auth::guard('customers')->user()->id;

        $customer = Customer::where('id', $customer_id)->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'cgpa' => $request->cgpa,
            'degree_id' => $request->degree_id,
            'program_id' => $request->program_id,
            'messagingAppDetail_id' => $request->messagingAppDetail_id,
            'area_of_excellence' => $request->area_of_excellence,
            'area_of_excellence_sub' => $request->area_of_excellence_sub,
            'type_of_help' => $request->type_of_help,
            'preferred_location' => $request->preferred_location,
            'whats_app_number' => $request->whats_app_number,
            'skype_id' => $request->skype_id,
            'we_chat_number' => $request->we_chat_number,
            'viber_number' => $request->viber_number,
            'imo_number' => $request->imo_number,
        ]);

        if ($customer) {
            return $this->successResponse([], 'Your changes have been done successfully');
        }
        return $this->errorResponse();
    }

    public function sendAnEmail(Request $request)
    {
        $customer = Customer::whereId($request->student)->first();
        if (dispatch(new SchoolInvitaionEmailJob($customer))) {
            return $this->successResponse([], 'Email has been sent successfully');
        }
        return $this->errorResponse();
    }

    public function sendAnEmailToAllStudents(Request $request)
    {
        if (isset($request->emails)) {
            foreach ($request->emails as $email) {
                $customer = Customer::whereEmail($email)->first();
                dispatch(new SchoolInvitaionEmailJob($customer));
            }
        }
        return $this->successResponse([], 'Email has been sent successfully');
    }

    public function searchStudent(Request $request)
    {
        $customer = Customer::query();
        if (isset($request->cgpa) && !empty($request->cgpa)) {
            $customer->where('cgpa', $request->cgpa);
        }

        if (isset($request->degree_id) && !empty($request->degree_id)) {
            $customer->where('degree_id', $request->degree_id);
        }

        if (isset($request->program_id) && !empty($request->program_id)) {
            $customer->where('program_id', $request->program_id);
        }

        if (isset($request->area_of_excellence) && !empty($request->area_of_excellence)) {
            $customer->where('area_of_excellence', $request->area_of_excellence);
        }

        if (isset($request->area_of_excellence_sub) && !empty($request->area_of_excellence_sub)) {
            $customer->where('area_of_excellence_sub', $request->area_of_excellence_sub);
        }
        if (isset($request->type_of_help) && !empty($request->type_of_help)) {
            $customer->where('type_of_help', $request->type_of_help);
        }
        if (isset($request->preferred_location) && !empty($request->preferred_location)) {
            $customer->where('preferred_location', $request->preferred_location);
        }

        $customer = $customer->with(['program', 'program.programDetail', 'degree', 'degree.degreeDetail'])->get();
        if ($customer) {
            if (isset($request->save_for_new_students) && $request->save_for_new_students == 1) {
                SchoolReverseSearchFilter::create([
                    'school_id' => $request->school_id,
                    'program_id' => $request->program_id,
                    'area_of_excellence' => $request->area_of_excellence,
                    'area_of_excellence_sub' => $request->area_of_excellence_sub,
                    'type_of_help' => $request->type_of_help,
                    'preferred_location' => $request->preferred_location,
                    'cgpa' => $request->cgpa,
                    'results' => $request->results,
                    'status' => $request->status,
                ]);
            }
            return $this->successResponse($customer, 'Your changes have been done successfully');
        }
        return $this->errorResponse();
    }

    public function schoolDemetraSetting(Request $request)
    {
        // dd($request->all());
        $validationRule = [
            // 'sport_id' => ['required'],
            'min_cgpa' => ['required'],
            // 'max_cgpa' => ['required'],
            // 'comunity_service_id' => ['required'],
            // 'conditional_acceptance' => ['required'],
        ];
        $defaulLang = getDefaultLanguage(1);
        if ($defaulLang) {
            App::setLocale($defaulLang->abbreviation);
            $loginPageSetting = DemetraPageSetting::with([
                'demetraPageSettingDetail' => function ($q) use ($defaulLang) {
                    $q = $q->where('language_id', $defaulLang->id);
                },
            ])->first();
            $niceNames = [
                // 'sport_id' => isset($loginPageSetting->loginPageSettingDetail[0]->demetra_sport_error) ? $loginPageSetting->loginPageSettingDetail[0]->demetra_sport_error : '',
                'min_cgpa' => isset($loginPageSetting->loginPageSettingDetail[0]->demetra_gpa_error) ? $loginPageSetting->loginPageSettingDetail[0]->demetra_gpa_error : '',
                'financial_help' => isset($loginPageSetting->loginPageSettingDetail[0]->demetra_comunity_service_error) ? $loginPageSetting->loginPageSettingDetail[0]->demetra_comunity_service_error : '',
            ];
        }
        $this->validate($request, $validationRule, [], $niceNames);
        $exist = SchoolDemetraSetting::whereSchoolId($request->school_id)->exists();
        if ($exist) {
            $demetraSetting = SchoolDemetraSetting::whereSchoolId($request->school_id)->first();
            $result =  $demetraSetting->update([
                'school_id' => $request->school_id,
                'min_cgpa' => $request->min_cgpa,
                // 'max_cgpa' => $request->max_cgpa,
                // 'conditional_acceptance' => $request->conditional_acceptance,
            ]);
        } else {
            $demetraSetting = SchoolDemetraSetting::create([
                'school_id' => $request->school_id,
                'min_cgpa' => $request->min_cgpa,
                // 'max_cgpa' => $request->max_cgpa,
                // 'community_service_id' => $request->community_service_id,
                // 'conditional_acceptance' => $request->conditional_acceptance,
            ]);
        }

        if ($demetraSetting) {
            DemetraSport::where('school_demetra_setting_id', $demetraSetting->id)->delete();
            foreach($request->sport_id as $sport){
                DemetraSport::create([
                    'school_demetra_setting_id' => $demetraSetting->id,
                    'sport_id' => $sport,
                ]);
            }

            DemetraCommunityService::where('school_demetra_setting_id', $demetraSetting->id)->delete();
            foreach($request->community_service as $community_service){
                DemetraCommunityService::create([
                    'school_demetra_setting_id' => $demetraSetting->id,
                    'comunity_service_id' => $community_service,
                ]);
            }
            if ($request->has('curricular_id')) {
                DemetraCurricularActivity::where('school_demetra_setting_id', $demetraSetting->id)->delete();
                foreach($request->curricular_id as $curricular) {
                    DemetraCurricularActivity::create([
                        'school_demetra_setting_id' => $demetraSetting->id,
                        'curricular_id' => $curricular,
                    ]);
                }
            }
            $activityTypes = [
                'extracurricular_ids' => 'extracurricular',
                'leadership_ids' => 'leadership',
                'media_ids' => 'media',
                'music_performance_ids' => 'music_performance',
                'technology_ids' => 'technology',
                'entrepreneurship_ids' => 'entrepreneurship',
                'stem_competitions_ids' => 'stem_competitions',
                'health_wellness_ids' => 'health_wellness',
                'environmental_ids' => 'environmental',
                'curricular_ids' => 'curricular',
                'social_activism_ids' => 'social_activism',
            ];

            DemetraActivity::where('school_demetra_setting_id', $demetraSetting->id)->delete();
            
            foreach ($activityTypes as $requestKey => $type) {
                if ($request->has($requestKey)) {
                    foreach ($request->$requestKey as $activityId) {
                        DemetraActivity::create([
                            'school_demetra_setting_id' => $demetraSetting->id,
                            'activity_id' => $activityId,
                            'type' => $type // Store the type for reference
                        ]);
                    }
                }
            }
            
            return $this->successResponse([$result], 'Email has been sent successfully');
        }
        return $this->errorResponse();
    }

    public function updatePassword(Request $request)
    {
        $validationRule = [
            'old_password' => ['required'],
            'new_password' => ['required'],
            // 'confirm_new_password' => ['required'],
        ];
        $this->validate($request, $validationRule, []);
        $user = \Auth::guard('customers')->user();
        $oldPassword = $request->input('old_password');
        $newPassword = $request->input('new_password');

        if (!Hash::check($oldPassword, $user->password)) {
            return $this->errorResponse('Incorrect old password');
        }
        // Update the password
        $user->password = Hash::make($newPassword);
        $user->save();
        if ($user) {
            return $this->successResponse([], 'Your changes have been done successfully');
        }
        
    }

}
