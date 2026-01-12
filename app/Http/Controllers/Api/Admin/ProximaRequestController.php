<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProximaRequestRequest;
use App\Http\Resources\Admin\ProximaRequestResource;
use App\Jobs\ProximatchJob;
use App\Jobs\RegistrationEmailJob;
use App\Models\Customer;
use App\Models\CustomerLanguage;
use App\Models\ProximaRequest;
use App\Models\RegistrationPackage;
use App\Services\FomSubmissionCountService;
use App\Traits\StatusResponser;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProximaRequestController extends Controller
{
    use StatusResponser;
    use FileUploadTrait;

    public function __construct()
    {
        $this->middleware('password_confirm')->only('destroy');
    }

    public function index()
    {
        $proximaRequests = ProximaRequest::query();

        $proximaRequests = $this->whereClause($proximaRequests);
        $proximaRequests = $this->loadRelations($proximaRequests);
        $proximaRequests = $this->sortingAndLimit($proximaRequests);

        return $this->apiSuccessResponse(ProximaRequestResource::collection($proximaRequests), 'Data Get Successfully!');
    }

    public function show(ProximaRequest $proximaRequest)
    {
        return $this->apiSuccessResponse(new ProximaRequestResource($proximaRequest), 'Data Get Successfully!');
    }

    public function store(ProximaRequestRequest $request)
    {
        $proximaRequest = ProximaRequest::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'inquiry' => $request->inquiry,
            'customer_id' => \Auth::guard('customers')->check() ? \Auth::guard('customers')->user()->id : null,
        ]);
        $formSubmissionService = new FomSubmissionCountService();
        $result = $formSubmissionService->advertiserForm();
        if ($result['status'] == 'Error') {
            return $result;
        }
        if ($proximaRequest) {
            dispatch(
                new ProximatchJob([
                    'name' => $request->name,
                    'phone' => $request->phone,
                    'email' => $request->email,
                    'inquiry' => $request->inquiry,
                    'type' => 'form_request',
                    'send_me_a_copy' => $request->send_me_a_copy,
                ]),
            );
            return $this->apiSuccessResponse(new ProximaRequestResource($proximaRequest), 'Your changes have been done successfully');
        }
        return $this->errorResponse();
    }

    public function update(Request $request, ProximaRequest $proximaRequest)
    {
        $rules = [
            'id' => ['required', 'exists:App\Models\ProximaRequest,id'],
            'quotation_amount' => ['required'],
            'quotation_detail' => ['nullable'],
        ];
        $this->validate($request, $rules);
        $oldAmount = $proximaRequest->quotation_amount;
        $result = ProximaRequest::whereId($request->id)->update([
            'quotation_amount' => $request->quotation_amount,
            'quotation_detail' => $request->quotation_detail,
            'status' => $request->status,
        ]);
        if ($result) {
            if ($oldAmount == '') {
                dispatch(
                    new ProximatchJob([
                        'name' => $proximaRequest->name,
                        'phone' => $proximaRequest->phone,
                        'email' => $proximaRequest->email,
                        'inquiry' => $proximaRequest->inquiry,
                        'quotation_amount' => $request->quotation_amount,
                        'quotation_detail' => $request->quotation_detail,
                        'type' => 'qoutation',
                    ]),
                );
            }
            if (!isset($proximaRequest->customer_id) || empty($proximaRequest->customer_id)) {
                $defaulLang = getDefaultLanguage(1);
                $package = RegistrationPackage::where('type', 'student')
                    ->where('package_type', 'free')
                    ->first();
                if (isset($package->id)) {
                    $packagePrice = isset($package, $package->discount_price) ? $package->discount_price : (isset($package) ? $package->price : 0);
                    $package_validity = date('Y-m-d', strtotime('+' . (isset($package) ? $package->package_validity_months : 0) . ' months'));
                    $isExistedCustomer = Customer::where('email', $proximaRequest->email)->exists();
                    if (!$isExistedCustomer) {
                        $customer = Customer::create([
                            'first_name' => $proximaRequest->name,
                            'last_name' => $proximaRequest->name,
                            'email' => $proximaRequest->email,
                            'password' => Hash::make('secret'),
                            'registration_package_id' => $package->id,
                            'package_price' => $packagePrice,
                            'free_subscription_days' => isset($package) ? $package->free_subscription_days : null,
                            'package_subscribed_date' => date('Y-m-d'),
                            'package_expiry_date' => $package_validity,
                            'is_package_amount_paid' => $packagePrice <= 0 ? 1 : 0,
                            'deactive_account' => $packagePrice <= 0 ? 1 : 0,
                            'is_auto_renew' => 0,
                            'user_type' => 'student',
                        ]);
                        CustomerLanguage::create([
                            'customer_id' => $customer->id,
                            'language_code' => $defaulLang->abbreviation,
                        ]);
                        $emailData = ['id' => $customer->id, 'first_name' => $request->first_name, 'last_name' => $request->last_name, 'email' => $request->email, 'password' => 'secret', 'type' => 'register_customer'];
                        dispatch(new RegistrationEmailJob($emailData));
                        $proximaRequest->customer_id = $customer->id;
                        $proximaRequest->save();
                    } else {
                        $customer = Customer::where('email', $proximaRequest->email)->first();
                        $proximaRequest->customer_id = $customer->id;
                        $proximaRequest->save();
                    }
                }
            }
            return $this->apiSuccessResponse(new ProximaRequestResource($proximaRequest), 'Your changes have been done successfully');
        }
        return $this->errorResponse();
    }

    public function destroy(Request $request, ProximaRequest $proximaRequest)
    {
        if ($proximaRequest->delete()) {
            return $this->apiSuccessResponse(new ProximaRequestResource($proximaRequest), 'The selected item has been deleted successfully');
        }
        return $this->errorResponse();
    }

    protected function loadRelations($proximaRequests)
    {
        return $proximaRequests;
    }

    protected function sortingAndLimit($proximaRequests)
    {
        if (isset($_GET['getAll']) && $_GET['getAll'] == '1') {
            return $proximaRequests
                ->orderBy('is_default', 'desc')
                ->orderBy('name', 'asc')
                ->get();
        }

        $sortType = ['ASC', 'asc', 'DESC', 'desc'];
        $sortBy = ['id', 'name', 'abbreviation', 'native_name'];
        if (isset($_GET['sortBy']) && $_GET['sortBy'] != '' && isset($_GET['sortType']) && $_GET['sortType'] != '' && in_array($_GET['sortBy'], $sortBy) && in_array($_GET['sortType'], $sortType)) {
            $proximaRequests = $proximaRequests->OrderBy($_GET['sortBy'], $_GET['sortType']);
        }

        if (isset($_GET['limit']) && $_GET['limit'] != '') {
            $limit = $_GET['limit'];
        } else {
            $limit = 10;
        }

        return $proximaRequests->paginate($limit);
    }

    protected function whereClause($proximaRequests)
    {
        if (isset($_GET['searchParam']) && $_GET['searchParam'] != '') {
            $proximaRequests = $proximaRequests
                ->where('name', 'LIKE', '%' . $_GET['searchParam'] . '%')
                ->orWhere('abbreviation', 'LIKE', '%' . $_GET['searchParam'] . '%')
                ->orWhere('native_name', 'LIKE', '%' . $_GET['searchParam'] . '%');
        }
        return $proximaRequests;
    }
}
