<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CustomerRequest;
use App\Http\Resources\Admin\CustomerResource;
use Illuminate\Support\Str;
use App\Jobs\AccountStatusEmailJob;
use App\Jobs\CredentialsSendEmailJob;
use App\Jobs\CredentialsSendForBusinessUserEmailJob;
use App\Models\CustomerCategoryDetail;
use App\Models\Customer;
use App\Traits\StatusResponser;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class CustomerController extends Controller
{
    use StatusResponser;
    use FileUploadTrait;

    public function __construct()
    {
        $this->middleware('password_confirm')->only('destroy');
    }

    public function index()
    {
        $Customers = Customer::query();

        $Customers = $this->whereClause($Customers);
        $Customers = $this->loadRelations($Customers);
        $Customers = $this->sortingAndLimit($Customers);

        return $this->apiSuccessResponse(CustomerResource::collection($Customers), 'Data Get Successfully!');
    }

    public function show(Customer $Customer)
    {
        if (isset($_GET['withFlagIcon']) && $_GET['withFlagIcon'] == '1') {
            $Customer = $Customer->loadMissing('flagIcon');
        }

        return $this->apiSuccessResponse(new CustomerResource($Customer), 'Data Get Successfully!');
    }

    public function store(CustomerRequest $request)
    {
        $media = json_decode($request->flag_icon, 1);
        $files = $this->moveFile($media, 'media/images', 'flag_icon');
        $lang = getDefaultCustomer();
        $Customer = Customer::create([
            'name' => $request->name,
            'abbreviation' => $request->abbreviation,
            'native_name' => $request->native_name,
            'is_default' => $request->is_default,
            'flag_icon' => isset($files, $files[0]) ? $files[0]->id : null,
        ]);

        if ($Customer) {
            return $this->apiSuccessResponse(new CustomerResource($Customer), 'Your changes have been done successfully');
        }
        return $this->errorResponse();
    }

    public function update(Request $request, Customer $Customer)
    {
        $rules = [
            'id' => ['required', 'exists:App\Models\Customer,id'],
            'name' => ['required', 'string', 'max:50'],
            'abbreviation' => ['required', 'string', 'max:10'],
            'native_name' => ['required', 'string', 'max:50'],
            'is_default' => ['required', 'boolean'],
            'flag_icon' => ['nullable'],
        ];
        $this->validate($request, $rules);
        if (isset($request->flag_icon) && !is_array($request->flag_icon)) {
            $media = json_decode($request->flag_icon, 1);
            $files = $this->moveFile($media, 'media/images', 'flag_icon');
        }
        $lang = getDefaultCustomer();
        $result = Customer::whereId($request->id)->update([
            'name' => $request->name,
            'abbreviation' => $request->abbreviation,
            'native_name' => $request->native_name,
            'is_default' => $request->is_default,
            'flag_icon' => !isset($request->flag_icon) ? null : (isset($files, $files[0]) ? $files[0]->id : $Customer->flag_icon),
        ]);

        if ($result) {
            if ($request->is_default == true) {
                $this->removeDefaultCustomer($Customer);
            }
            if (!file_exists(lang_path($request->abbreviation))) {
                File::makeDirectory(lang_path($request->abbreviation));
            }
            $abbreviation = !isset($lang->abbreviation) ? 'en' : $lang->abbreviation;
            foreach (glob(lang_path($abbreviation) . '/*.*') as $file) {
                $file_to_go = str_replace($abbreviation, $request->abbreviation, $file);
                if (!file_exists($file_to_go)) {
                    copy($file, $file_to_go);
                }
            }
            return $this->apiSuccessResponse(new CustomerResource($Customer), 'Your changes have been done successfully');
        }
        return $this->errorResponse();
    }

    public function destroy(Request $request, Customer $Customer)
    {
        if ($Customer->delete()) {
            return $this->apiSuccessResponse(new CustomerResource($Customer), 'The selected item has been deleted successfully');
        }
        return $this->errorResponse();
    }

    public function deactiveCustomer(Request $request)
    {
        $customer = Customer::whereId($request->id)->update(['deactive_account' => $request->type]);
        $customer = Customer::whereId($request->id)->first();
        if (!$request->type) {
            $emailData = ['id' => $customer->id, 'first_name' => $customer->first_name, 'last_name' => $customer->last_name, 'email' => $customer->email, 'type' => 'customer'];
            dispatch(new AccountStatusEmailJob($emailData));
        }

        return $this->successResponse('', 'Customer status update successfully.');
    }

    protected function removeDefaultCustomer($Customer)
    {
        Customer::where('id', '!=', $Customer->id)->update([
            'is_default' => 0,
        ]);
    }

    protected function loadRelations($Customers)
    {
        return $Customers;
    }

    protected function sortingAndLimit($Customers)
    {
        if (isset($_GET['getAll']) && $_GET['getAll'] == '1') {
            return $Customers->orderBy('first_name', 'asc')->get();
        }

        $sortType = ['ASC', 'asc', 'DESC', 'desc'];
        $sortBy = ['id', 'last_name', 'first_name', 'email'];
        if (isset($_GET['sortBy']) && $_GET['sortBy'] != '' && isset($_GET['sortType']) && $_GET['sortType'] != '' && in_array($_GET['sortBy'], $sortBy) && in_array($_GET['sortType'], $sortType)) {
            $Customers = $Customers->OrderBy($_GET['sortBy'], $_GET['sortType']);
        }

        if (isset($_GET['limit']) && $_GET['limit'] != '') {
            $limit = $_GET['limit'];
        } else {
            $limit = 10;
        }

        return $Customers->paginate($limit);
    }

    protected function whereClause($Customers)
    {
        if (isset($_GET['searchParam']) && $_GET['searchParam'] != '') {
            $Customers = $Customers
                ->where('last_name', 'LIKE', '%' . $_GET['searchParam'] . '%')
                ->orWhere('first_name', 'LIKE', '%' . $_GET['searchParam'] . '%')
                ->orWhere('email', 'LIKE', '%' . $_GET['searchParam'] . '%');
        }
        return $Customers;
    }
    // public function sendCredentialsEmail(Request $request, $customerId)
    // {
    //     $customer = Customer::findOrFail($customerId);
    //     $temporaryPassword = Str::random(10); 

    //     $customer->password = bcrypt($temporaryPassword);
    //     $customer->save();

    //     $emailData = [
    //         'email' => $customer->email,
    //         'password' => $temporaryPassword,
    //     ];
    //     CredentialsSendEmailJob::dispatch($emailData);

    //     return response()->json(['message' => 'Email sent successfully']);
    // }
    public function sendCredentialsEmail(Request $request, $customerId)
    {
        $customer = Customer::with(['school.schoolDetail'])->findOrFail($customerId);
        $temporaryPassword = Str::random(10);

        $customer->password = bcrypt($temporaryPassword);
        $customer->save();

        $emailData = [
            'email' => $customer->email,
            'password' => $temporaryPassword,
            'user_type' => $customer->user_type,
        ];

        // For school-type customers, use school name as first_name and last_name
        if ($customer->user_type === 'school' && $customer->school) {
            $schoolName = $customer->school->schoolDetail->first()->school_name ?? 'School Administrator';
            $emailData['first_name'] = $schoolName;
            $emailData['last_name'] = $schoolName;
            $emailData['school_name'] = $schoolName;
        } else {
            $emailData['first_name'] = $customer->first_name;
            $emailData['last_name'] = $customer->last_name;
        }

        CredentialsSendEmailJob::dispatch($emailData);

        return response()->json([
            'status' => 'Success',
            'message' => 'Credentials email sent successfully'
        ]);
    }

    public function sendBusinessCredentialsEmail(Request $request, $customerId)
    {
        $customer = Customer::with(['business.businessDetail'])->findOrFail($customerId);
        $temporaryPassword = Str::random(10);

        $customer->password = bcrypt($temporaryPassword);
        $customer->save();

        $emailData = [
            'email' => $customer->email,
            'password' => $temporaryPassword,
            'user_type' => $customer->user_type,
        ];

        // For business-type customers, use busienss name as first_name and last_name
        if ($customer->user_type === 'business' && $customer->business) {
            $businessName = $customer->business->businessDetail->first()->business_name ?? 'Buysiness Administrator';
            $emailData['first_name'] = $businessName;
            $emailData['last_name'] = $businessName;
            $emailData['business_name'] = $businessName;
        } else {
            $emailData['first_name'] = $customer->first_name;
            $emailData['last_name'] = $customer->last_name;
        }

        CredentialsSendForBusinessUserEmailJob::dispatch($emailData);

        return response()->json([
            'status' => 'Success',
            'message' => 'Credentials email sent successfully'
        ]);
    }
}
