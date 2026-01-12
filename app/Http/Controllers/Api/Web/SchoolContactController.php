<?php

namespace App\Http\Controllers\Api\Web;

use App\Http\Controllers\Controller;
use App\Http\Resources\Web\SchoolContactResource;
use Illuminate\Support\Str;
use App\Models\SchoolContact;
use App\Models\SchoolContactDetail;
use App\Traits\StatusResponser;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;

class SchoolContactController extends Controller
{
    use StatusResponser;
    use FileUploadTrait;

    public function __construct()
    {
        $this->middleware('password_confirm')->only('destroy');
    }

    public function index()
    {
        if (isset($_GET['is_admin'])) {
            $schoolContacts = SchoolContact::whereSchoolId($_GET['school_id']);
        } else {
            $customer = auth()
                ->guard('customers')
                ->user();
            $schoolContacts = SchoolContact::whereCustomerId($customer->id);
        }

        $schoolContacts = $this->whereClause($schoolContacts);
        $schoolContacts = $this->loadRelations($schoolContacts);
        $schoolContacts = $this->sortingAndLimit($schoolContacts);

        return $this->apiSuccessResponse(SchoolContactResource::collection($schoolContacts), 'Data Get Successfully!');
    }

    public function show(SchoolContact $SchoolContact)
    {
        if (isset($_GET['withSchoolContactDetail']) && $_GET['withSchoolContactDetail'] == '1') {
            $SchoolContact = $SchoolContact->loadMissing('schoolContactDetail');
        }

        return $this->apiSuccessResponse(new SchoolContactResource($SchoolContact), 'Data Get Successfully!');
    }

    public function store(Request $request)
    {
        $validationRule = [];
        $errorMessages = [];
        $languages = getAllLanguages();
        foreach ($languages as $language) {
            if ($language->is_default == 1) {
                $validationRule = array_merge($validationRule, ['name.name_' . $language->abbreviation => ['required', 'string']]);
                $errorMessages = array_merge($errorMessages, ['name.name_' . $language->abbreviation . '.required' => 'Name is required.']);
                $validationRule = array_merge($validationRule, [
                    'brief_descr.brief_descr_' . $language->abbreviation => [
                        'required',
                        'string',
                        function ($attribute, $value, $fail) {
                            $plainText = trim(strip_tags(html_entity_decode($value))); 
                            if (str_word_count($plainText) > 50) {
                                $fail('Only 50 words are allowed for the brief description.');
                            }
                        }
                    ]
                ]);
                
                $errorMessages = array_merge($errorMessages, [
                    'brief_descr.brief_descr_' . $language->abbreviation . '.required' => 'This field is required.'
                ]);
            }
        }
        $validationRule = array_merge($validationRule, ['department' => ['required', 'string']]);
        $errorMessages = array_merge($errorMessages, ['department' . '.required' => 'Department is required']);
        $validationRule = array_merge($validationRule, ['address' => ['required', 'string']]);
        $errorMessages = array_merge($errorMessages, ['address' . '.required' => 'Address is required']);
        $validationRule = array_merge($validationRule, ['city' => ['required', 'string']]);
        $errorMessages = array_merge($errorMessages, ['city' . '.required' => 'City is required']);
        $validationRule = array_merge($validationRule, ['country' => ['required', 'string']]);
        $errorMessages = array_merge($errorMessages, ['country' . '.required' => 'Country is required']);
        $validationRule = array_merge($validationRule, ['contact_linkedin' => ['nullable', 'string']]);
        $errorMessages = array_merge($errorMessages, ['contact_linkedin' . '.required' => 'linkedin is required']);
        $validationRule = array_merge($validationRule, ['contact_instagram' => ['nullable', 'string']]);
        $errorMessages = array_merge($errorMessages, ['contact_instagram' . '.required' => 'instagram is required']);
        $validationRule = array_merge($validationRule, ['contact_facebook' => ['nullable', 'string']]);
        $errorMessages = array_merge($errorMessages, ['contact_facebook' . '.required' => 'facebook is required']);
        $validationRule = array_merge($validationRule, ['phone' => ['required', 'string']]);
        $errorMessages = array_merge($errorMessages, [
            'phone' . '.required' => 'Phone is required',
        ]);
        $validationRule = array_merge($validationRule, ['direct_email' => ['required', 'string']]);
        $errorMessages = array_merge($errorMessages, ['direct_email' . '.required' => 'Direct email is required']);
        $validationRule = array_merge($validationRule, ['website_link' => ['required', 'string']]);
        $errorMessages = array_merge($errorMessages, ['website_link' . '.required' => 'Website link is required']);
        $validationRule = array_merge($validationRule, ['order' => ['required', 'string']]);
        $errorMessages = array_merge($errorMessages, ['order' . '.required' => 'Order is required']);
        $validationRule = array_merge($validationRule, ['image' => ['nullable', 'string']]);
        $errorMessages = array_merge($errorMessages, ['image' . '.required' => 'Image is required']);

        $this->validate($request, $validationRule, $errorMessages);
        $SchoolContact = SchoolContact::create([
            'department' => $request->department,
            'address' => $request->address,
            'city' => $request->city,
            'country' => $request->country,
            'phone' => $request->phone,
            'contact_linkedin' => $request->contact_linkedin,
            'contact_instagram' => $request->contact_instagram,
            'contact_facebook' => $request->contact_facebook,
            'fax' => $request->fax,
            'website_link' => $request->website_link,
            'direct_email' => $request->direct_email,
            'order' => $request->order,
            'image' => $request->image,
            'customer_id' => $request->customer_id,
            'school_id' => $request->school_id,
        ]);

        if ($SchoolContact) {
            foreach ($languages as $language) {
                $languageCode = (isset($language['language_code']) ? $language['language_code'] : isset($language['abbreviation'])) ? $language['abbreviation'] : '';
                if (!empty($request['name']['name_' . $languageCode])) {
                    SchoolContactDetail::create([
                        'school_contact_id' => $SchoolContact->id,
                        'language_code' => $languageCode,
                        'name' => $request['name']['name_' . $languageCode] ?? null,
                        'brief_descr' => $request['brief_descr']['brief_descr_' . $languageCode] ?? null,
                    ]);
                }
            }
            return $this->apiSuccessResponse(new SchoolContactResource($SchoolContact), 'SchoolContact has been added successfully.');
        }
        return $this->errorResponse();
    }

    public function update(Request $request, SchoolContact $SchoolContact)
    {
        $validationRule = [];
        $errorMessages = [];
        $languages = getAllLanguages();
        foreach ($languages as $language) {
            if ($language->is_default == 1) {
                $validationRule = array_merge($validationRule, ['name.name_' . $language->abbreviation => ['required', 'string']]);
                $errorMessages = array_merge($errorMessages, ['name.name_' . $language->abbreviation . '.required' => 'Name is required']);
                $validationRule = array_merge($validationRule, [
                    'brief_descr.brief_descr_' . $language->abbreviation => [
                        'required',
                        'string',
                        function ($attribute, $value, $fail) {
                            $plainText = trim(strip_tags(html_entity_decode($value))); 
                            if (str_word_count($plainText) > 50) {
                                $fail('Only 50 words are allowed for the brief description.');
                            }
                        }
                    ]
                ]);
                
                $errorMessages = array_merge($errorMessages, [
                    'brief_descr.brief_descr_' . $language->abbreviation . '.required' => 'This field is required.'
                ]);
            }
        }
        $validationRule = array_merge($validationRule, ['department' => ['required', 'string']]);
        $errorMessages = array_merge($errorMessages, ['department' . '.required' => 'Department is required']);
        $validationRule = array_merge($validationRule, ['address' => ['required', 'string']]);
        $errorMessages = array_merge($errorMessages, ['address' . '.required' => 'Address is required']);
        $validationRule = array_merge($validationRule, ['city' => ['required', 'string']]);
        $errorMessages = array_merge($errorMessages, ['city' . '.required' => 'City is required']);
        $validationRule = array_merge($validationRule, ['country' => ['required', 'string']]);
        $errorMessages = array_merge($errorMessages, ['country' . '.required' => 'Country is required']);
        $validationRule = array_merge($validationRule, ['contact_linkedin' => ['nullable', 'string']]);
        $errorMessages = array_merge($errorMessages, ['contact_linkedin' . '.required' => 'linkedin is required']);
        $validationRule = array_merge($validationRule, ['contact_instagram' => ['nullable', 'string']]);
        $errorMessages = array_merge($errorMessages, ['contact_instagram' . '.required' => 'instagram is required']);
        $validationRule = array_merge($validationRule, ['contact_facebook' => ['nullable', 'string']]);
        $errorMessages = array_merge($errorMessages, ['contact_facebook' . '.required' => 'facebook is required']);
        $validationRule = array_merge($validationRule, ['phone' => ['required', 'string', 'digits_between:1,15']]);
        $errorMessages = array_merge($errorMessages, [
            'phone' . '.required' => 'Phone is required.',
            'phone.digits_between' => 'Phone number cannot exceed 15 digits'
        ]);
        $validationRule = array_merge($validationRule, ['direct_email' => ['required', 'string']]);
        $errorMessages = array_merge($errorMessages, ['direct_email' . '.required' => 'Direct email is required']);
        $validationRule = array_merge($validationRule, ['website_link' => ['required', 'string']]);
        $errorMessages = array_merge($errorMessages, ['website_link' . '.required' => 'Website link is required']);
        $validationRule = array_merge($validationRule, ['order' => ['required', 'string']]);
        $errorMessages = array_merge($errorMessages, ['order' . '.required' => 'Order is required']);
        $validationRule = array_merge($validationRule, ['image' => ['nullable', 'string']]);
        $errorMessages = array_merge($errorMessages, ['image' . '.required' => 'Image is required']);

        $this->validate($request, $validationRule, $errorMessages);

        $SchoolContact->update([
            'department' => $request->department,
            'address' => $request->address,
            'direct_email' => $request->direct_email,
            'contact_linkedin' => $request->contact_linkedin,
            'contact_instagram' => $request->contact_instagram,
            'contact_facebook' => $request->contact_facebook,
            'city' => $request->city,
            'country' => $request->country,
            'phone' => $request->phone,
            'fax' => $request->fax,
            'website_link' => $request->website_link,
            'order' => $request->order,
            'image' => $request->image,
        ]);
        foreach ($request->languages as $language) {
            // $languageCode = (isset($language['language_code']) ? $language['language_code'] : isset($language['abbreviation'])) ? $language['abbreviation'] : '';
            $languageCode = $language['language_code'] ?? ($language['abbreviation'] ?? '');

            if (!empty($request['name']['name_' . $languageCode])) {
                $SchoolContactDetail = SchoolContactDetail::whereLanguageCode($languageCode)
                    ->whereSchoolContactId($SchoolContact->id)
                    ->exists();
                if ($SchoolContactDetail) {
                    SchoolContactDetail::whereLanguageCode($languageCode)
                        ->whereSchoolContactId($SchoolContact->id)
                        ->update([
                            'school_contact_id' => $SchoolContact->id,
                            'language_code' => $languageCode,
                            'name' => $request['name']['name_' . $languageCode],
                            'brief_descr' => $request['brief_descr']['brief_descr_' . $languageCode],
                        ]);
                } else {
                    SchoolContactDetail::create([
                        'school_contact_id' => $SchoolContact->id,
                        'language_code' => $languageCode,
                        'name' => $request['name']['name_' . $languageCode],
                        'brief_descr' => $request['brief_descr']['brief_descr_' . $languageCode],
                    ]);
                }
            }
        }

        if ($SchoolContact) {
            return $this->apiSuccessResponse(new SchoolContactResource($SchoolContact), 'SchoolContact has been updated successfully.');
        }
        return $this->errorResponse();
    }

    public function destroy(Request $request, SchoolContact $SchoolContact)
    {
        if ($SchoolContact->SchoolContactDetail()->delete() && $SchoolContact->delete()) {
            return $this->apiSuccessResponse(new SchoolContactResource($SchoolContact), 'The selected item has been deleted successfully');
        }
        return $this->errorResponse();
    }

    protected function loadRelations($schoolContacts)
    {
        $defaultLang = getDefaultLanguage();
        $schoolContacts = $schoolContacts->with([
            'schoolContactDetail' => function ($q) use ($defaultLang) {
                $q->where('language_code', $defaultLang->abbreviation);
            },
        ]);
        if (isset($_GET['withSchoolContactDetail']) && $_GET['withSchoolContactDetail'] == '1') {
            $schoolContacts = $schoolContacts->with('schoolContactDetail');
        }
        return $schoolContacts;
    }

    protected function sortingAndLimit($schoolContacts)
    {
        $sortType = ['ASC', 'asc', 'DESC', 'desc'];
        $sortBy = ['id', 'name', 'abbreviation', 'School_contact_name'];
        if (isset($_GET['sortBy']) && $_GET['sortBy'] != '' && isset($_GET['sortType']) && $_GET['sortType'] != '' && in_array($_GET['sortBy'], $sortBy) && in_array($_GET['sortType'], $sortType)) {
            $schoolContacts = $schoolContacts->OrderBy($_GET['sortBy'], $_GET['sortType']);
        }

        if (isset($_GET['limit']) && $_GET['limit'] != '') {
            $limit = $_GET['limit'];
        } else {
            $limit = 10;
        }

        return $schoolContacts->paginate($limit);
    }

    protected function whereClause($schoolContacts)
    {
        if (isset($_GET['searchParam']) && $_GET['searchParam'] != '') {
            $schoolContacts = $schoolContacts->whereHas('schoolContactDetail', function ($q) {
                $q->where('name', 'LIKE', '%' . $_GET['searchParam'] . '%');
            });
        }
        return $schoolContacts;
    }
}
