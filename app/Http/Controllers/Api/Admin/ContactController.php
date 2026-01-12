<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ContactRequest;
use App\Http\Resources\Admin\ContactResource;
use App\Models\Contact;
use App\Traits\StatusResponser;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ContactController extends Controller
{
    use StatusResponser;
    use FileUploadTrait;

    public function __construct()
    {
        $this->middleware('password_confirm')->only('destroy');
    }


    public function index()
    {
        $Contacts = Contact::query();

        $Contacts = $this->whereClause($Contacts);
        $Contacts = $this->loadRelations($Contacts);
        $Contacts = $this->sortingAndLimit($Contacts);

        return $this->apiSuccessResponse(ContactResource::collection($Contacts), 'Data Get Successfully!');
    }


    public function show(Contact $Contact)
    {
        return $this->apiSuccessResponse(new ContactResource($Contact), 'Data Get Successfully!');
    }


    // public function store(Request $request)
    // {
    //     $Contact = Contact::create([
    //         'name' => $request->name,
    //         'email' => $request->email,
    //         'message' => $request->message,
    //         'type' => $request->type,
    //     ]);

    //     if ($Contact) {
    //         return $this->apiSuccessResponse(new ContactResource($Contact), 'Your changes have been done successfully');
    //     }
    //     return $this->errorResponse();
    // }
    public function store(Request $request)
    {
        $staticTranslations = getStaticTranslation('contact_school');

        $validationRule = [
            'name' => ['nullable', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'message' => ['required', 'string'],
            'type' => ['nullable', 'string'],
        ];

        $errorMessages = [
            'name.required' => $staticTranslations['school_name_error'] ?? 'Name is required.',
            'email.required' => $staticTranslations['school_email_error'] ?? 'Email is required.',
            'email.email' => 'Please enter a valid email address.',
            'message.required' => $staticTranslations['school_message_error'] ?? 'Message is required.',
        ];

        $this->validate($request, $validationRule, $errorMessages);

        $Contact = Contact::create($request->only(['name', 'email', 'message', 'type']));

        if ($Contact) {
            return $this->apiSuccessResponse(
                new ContactResource($Contact),
                'Your changes have been done successfully'
            );
        }

        return $this->errorResponse();
    }



    public function update(Request $request, Contact $Contact)
    {
        $rules = [
            'id' => ['required', 'exists:App\Models\Contact,id'],
            'name' => ['required', 'string'],
            'email' => ['required', 'string', 'email'],
            'message' => ['required', 'string'],
        ];
        $this->validate($request, $rules);
        $result = Contact::whereId($request->id)->update([
            'name' => $request->name,
            'email' => $request->email,
            'message' => $request->message,
            'type' => $request->type,
        ]);

        if ($result) {
            return $this->apiSuccessResponse(new ContactResource($Contact), 'Your changes have been done successfully');
        }
        return $this->errorResponse();
    }

    public function destroy(Request $request, Contact $Contact)
    {
        if ($Contact->delete()) {
            return $this->apiSuccessResponse(new ContactResource($Contact), 'The selected item has been deleted successfully');
        }
        return $this->errorResponse();
    }

    public function deactiveContact(Request $request)
    {
        $sql = Contact::whereId($request->id)->update(['deactive_account' => $request->type]);
        return $this->successResponse('', 'Contact status update successfully.');
    }

    protected function removeDefaultContact($Contact)
    {
        Contact::where('id', '!=', $Contact->id)->update([
            'is_default' => 0
        ]);
    }

    protected function loadRelations($Contacts)
    {
        return $Contacts;
    }

    protected function sortingAndLimit($Contacts)
    {
        if (isset($_GET['getAll']) && $_GET['getAll'] == '1') {
            return $Contacts->orderBy('first_name', 'asc')->get();
        }

        $sortType = ['ASC', 'asc', 'DESC', 'desc'];
        $sortBy = ['id', 'name', 'message', 'email', 'department'];
        if (isset($_GET['sortBy']) && $_GET['sortBy'] != '' && isset($_GET['sortType']) && $_GET['sortType'] != '' && in_array($_GET['sortBy'], $sortBy) && in_array($_GET['sortType'], $sortType)) {
            $Contacts = $Contacts->OrderBy($_GET['sortBy'], $_GET['sortType']);
        }


        if (isset($_GET['limit']) && $_GET['limit'] != '') {
            $limit = $_GET['limit'];
        } else {
            $limit = 10;
        }

        return $Contacts->paginate($limit);
    }

    protected function whereClause($Contacts)
    {
        if (isset($_GET['searchParam']) && $_GET['searchParam'] != '') {
            $Contacts = $Contacts->where('name', 'LIKE', '%' . $_GET['searchParam'] . '%')->orWhere('email', $_GET['searchParam']);
        }
        return $Contacts;
    }
}
