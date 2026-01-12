<?php

namespace App\Http\Controllers\Api\Web;

use App\Http\Controllers\Controller;
use App\Http\Resources\Web\OpenDayResource;
use App\Jobs\NewRecordEmailJob;
use App\Jobs\OpenHouseCreatedEmailJob;
use Illuminate\Support\Str;
use App\Models\OpenDay;
use App\Models\OpenDayDetail;
use App\Traits\StatusResponser;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;

class OpenDayController extends Controller
{
    use StatusResponser;
    use FileUploadTrait;

    public function index()
    {
        $customer = auth()
            ->guard('customers')
            ->user();
        $openDays = OpenDay::whereCustomerId($customer->id);
        $openDays = $this->whereClause($openDays);
        $openDays = $this->loadRelations($openDays);
        $openDays = $this->sortingAndLimit($openDays);
        return $this->apiSuccessResponse(OpenDayResource::collection($openDays), 'Data Get Successfully!');
    }

    public function show(OpenDay $OpenDay)
    {
        if (isset($_GET['withOpenDayDetail']) && $_GET['withOpenDayDetail'] == '1') {
            $OpenDay = $OpenDay->loadMissing('openDayDetail');
        }

        return $this->apiSuccessResponse(new OpenDayResource($OpenDay), 'Data Get Successfully!');
    }

    public function store(Request $request)
    {
        $validationRule = [];
        $errorMessages = [];
        $languages = getAllLanguages();
        foreach ($languages as $language) {
            if ($language->is_default == 1) {
                $validationRule = array_merge($validationRule, ['title.title_' . $language->abbreviation => ['required', 'string']]);
                $errorMessages = array_merge($errorMessages, ['title.title_' . $language->abbreviation . '.required' => 'Title is required']);
                $validationRule = array_merge($validationRule, [
                    'description.description_' . $language->abbreviation => ['required', 'string', 'maxwords:300']
                ]);
                
                $errorMessages = array_merge($errorMessages, [
                    'description.description_' . $language->abbreviation . '.required' => 'Description is required',
                    'description.description_' . $language->abbreviation . '.maxwords' => 'Please limit your description to 300 words'
                ]);
                
            }
        }
        $validationRule = array_merge($validationRule, ['time' => ['required', 'string']]);
        $errorMessages = array_merge($errorMessages, ['time' . '.required' => 'Time is required']);
        $validationRule = array_merge($validationRule, ['date' => ['required', 'string']]);
        $errorMessages = array_merge($errorMessages, ['date' . '.required' => 'Date is required']);
        $validationRule = array_merge($validationRule, ['city' => ['required', 'string']]);
        $errorMessages = array_merge($errorMessages, ['city' . '.required' => 'City is required']);
        $validationRule = array_merge($validationRule, ['postal_code' => ['required', 'string']]);
        $errorMessages = array_merge($errorMessages, ['postal_code' . '.required' => 'ZIP Code / Postal Code field is required']);
        $validationRule = array_merge($validationRule, ['country' => ['required', 'string']]);
        $errorMessages = array_merge($errorMessages, ['country' . '.required' => 'Country is required']);
        $validationRule = array_merge($validationRule, ['address' => ['required', 'string']]);
        $errorMessages = array_merge($errorMessages, ['address' . '.required' => 'Address is required']);
        $validationRule = array_merge($validationRule, ['school_email' => ['required', 'string', 'email']]);
        $errorMessages = array_merge($errorMessages, ['school_email' . '.required' => 'School email is required']);
        $validationRule = array_merge($validationRule, ['school_phone' => ['required', 'string']]);
        $errorMessages = array_merge($errorMessages, [
            'school_phone' . '.required' => 'Phone number is required',
        ]);
        $request->validate([
            'open_day_url' => [
                'nullable',
                'regex:/^(https?:\/\/)?(www\.)?[a-zA-Z0-9-]+(\.[a-zA-Z]{2,})+(\/\S*)?$/'
            ]
        ], [
            'open_day_url.regex' => 'Please enter a valid URL (e.g., https://example.com)'
        ]);
        $validationRule = array_merge($validationRule, ['image' => ['required', 'string']]);
        $errorMessages = array_merge($errorMessages, ['image' . '.required' => 'Image is required']);
        if ($request->has('image')) {
            $imagePath = public_path(str_replace('/storage/', 'storage/', $request->image));
            
            // Check if file exists
            if (!file_exists($imagePath)) {
                return response()->json([
                    'errors' => ['image' => ['The uploaded image could not be found.']],
                ], 422);
            }
        
            // Check allowed extensions
            $allowedExtensions = ['jpg', 'jpeg', 'png'];
            $extension = strtolower(pathinfo($imagePath, PATHINFO_EXTENSION));
        
            if (!in_array($extension, $allowedExtensions)) {
                return response()->json([
                    'errors' => ['image' => ['Only JPG, JPEG, and PNG formats are allowed']],
                ], 422);
            }
        
            // Check file size
            if (filesize($imagePath) > 5 * 1024 * 1024) {
                return response()->json([
                    'errors' => ['image' => ['The image size must not exceed 5MB']],
                ], 422);
            }
        }
        
        $this->validate($request, $validationRule, $errorMessages);
        $OpenDay = OpenDay::create([
            'address' => $request->address,
            'city' => $request->city,
            'country' => $request->country,
            'date' => $request->date,
            'time' => $request->time,
            'school_email' => $request->school_email,
            'postal_code' => $request->postal_code,
            'school_phone' => $request->school_phone,
            'open_day_url' => $request->open_day_url,
            'image' => $request->image,
            'customer_id' => $request->customer_id,
            'school_id' => $request->school_id,
        ]);

        if ($OpenDay) {
            foreach ($request->languages as $language) {
                if (!empty($request['title']['title_' . $language['language_code']]) && !empty($request['description']['description_' . $language['language_code']])) {
                    OpenDayDetail::create([
                        'open_day_id' => $OpenDay->id,
                        'language_code' => $language['language_code'],
                        'title' => $request['title']['title_' . $language['language_code']],
                        'description' => $request['description']['description_' . $language['language_code']],
                    ]);
                }
            }
            $customer_name =
                auth()
                ->guard('customers')
                ->user()->first_name .
                ' ' .
                auth()
                ->guard('customers')
                ->user()->last_name;
                $defaultLang = getDefaultLanguage(1); // Assuming this function returns the default language
            $emailData = ['customer' => $customer_name, 'record' => $OpenDay, 'record_url' => 'open_days', 'record_type' => 'openhouse', 'record_type_string' => 'Open House', 'creator_email' => $OpenDay->school_email,
            // 'open_day_url' => $OpenDay->open_day_url, ];
            // 'open_day_url' => url("/en/open-house/{$OpenDay->id}") 
            'open_day_url' => url("/{$defaultLang['abbreviation']}/open-house/{$OpenDay->id}"),
        ];
            // dispatch(new NewRecordEmailJob($emailData));
            dispatch(new OpenHouseCreatedEmailJob($emailData));
            return $this->apiSuccessResponse(new OpenDayResource($OpenDay), 'Your changes have been done successfully');
        }
        return $this->errorResponse();
    }

    public function update(Request $request, OpenDay $OpenDay)
    {
        $validationRule = [];
        $errorMessages = [];
        $languages = getAllLanguages();
        foreach ($languages as $language) {
            if ($language->is_default == 1) {
                $validationRule = array_merge($validationRule, ['title.title_' . $language->abbreviation => ['required', 'string']]);
                $errorMessages = array_merge($errorMessages, ['title.title_' . $language->abbreviation . '.required' => 'Title is required']);
                $validationRule = array_merge($validationRule, ['description.description_' . $language->abbreviation => ['required', 'string']]);
                $errorMessages = array_merge($errorMessages, ['description.description_' . $language->abbreviation . '.required' => 'Description is required']);
            }
        }
        $validationRule = array_merge($validationRule, ['time' => ['required', 'string']]);
        $errorMessages = array_merge($errorMessages, ['time' . '.required' => 'Time is required']);
        $validationRule = array_merge($validationRule, ['date' => ['required', 'string']]);
        $errorMessages = array_merge($errorMessages, ['date' . '.required' => 'Date is required']);
        $validationRule = array_merge($validationRule, ['city' => ['required', 'string']]);
        $errorMessages = array_merge($errorMessages, ['city' . '.required' => 'City is required']);
        $validationRule = array_merge($validationRule, ['postal_code' => ['required', 'string']]);
        $errorMessages = array_merge($errorMessages, ['postal_code' . '.required' => 'ZIP Code / Postal Code field is required']);
        $validationRule = array_merge($validationRule, ['country' => ['required', 'string']]);
        $errorMessages = array_merge($errorMessages, ['country' . '.required' => 'Country is required']);
        $validationRule = array_merge($validationRule, ['address' => ['required', 'string']]);
        $errorMessages = array_merge($errorMessages, ['address' . '.required' => 'Address is required']);
        $validationRule = array_merge($validationRule, ['school_email' => ['required',  'email']]);
        // $errorMessages = array_merge($errorMessages, ['school_email' . '.required' => getGeneralTranslation()['verification_email_message_text']]);
        $validationRule = array_merge($validationRule, ['school_phone' => ['required', 'string']]);
        $errorMessages = array_merge($errorMessages, [
            'school_phone' . '.required' => 'Phone number is required',
        ]);
        $validationRule = array_merge($validationRule, ['image' => ['required', 'string']]);
        $errorMessages = array_merge($errorMessages, ['image' . '.required' => 'Image is required']);
        $this->validate($request, $validationRule, $errorMessages);

        $OpenDay->update([
            'address' => $request->address,
            'city' => $request->city,
            'country' => $request->country,
            'date' => $request->date,
            'time' => $request->time,
            'postal_code' => $request->postal_code,
            'school_email' => $request->school_email,
            'school_phone' => $request->school_phone,
            'open_day_url' => $request->open_day_url,
            'image' => $request->image,
            'school_id' => $request->school_id,
        ]);
        foreach ($request->languages as $language) {
            if (!empty($request['title']['title_' . $language['language_code']]) && !empty($request['description']['description_' . $language['language_code']])) {
                $OpenDayDetail = OpenDayDetail::whereLanguageCode($language['language_code'])
                    ->whereOpenDayId($OpenDay->id)
                    ->exists();
                if ($OpenDayDetail) {
                    OpenDayDetail::whereLanguageCode($language['language_code'])
                        ->whereOpenDayId($OpenDay->id)
                        ->update([
                            'open_day_id' => $OpenDay->id,
                            'language_code' => $language['language_code'],
                            'title' => $request['title']['title_' . $language['language_code']],
                            'description' => $request['description']['description_' . $language['language_code']],
                        ]);
                } else {
                    OpenDayDetail::create([
                        'open_day_id' => $OpenDay->id,
                        'language_code' => $language['language_code'],
                        'title' => $request['title']['title_' . $language['language_code']],
                        'description' => $request['description']['description_' . $language['language_code']],
                    ]);
                }
            }
        }

        if ($OpenDay) {
            return $this->apiSuccessResponse(new OpenDayResource($OpenDay), 'Your changes have been done successfully');
        }
        return $this->errorResponse();
    }

    public function destroy(OpenDay $OpenDay)
    {
        if ($OpenDay->OpenDayDetail()->delete() && $OpenDay->delete()) {
            return $this->apiSuccessResponse(new OpenDayResource($OpenDay), 'The selected item has been deleted successfully');
        }
        return $this->errorResponse();
    }

    protected function loadRelations($openDays)
    {
        $defaultLang = getDefaultLanguage();
        $openDays = $openDays->with([
            'OpenDayDetail' => function ($q) use ($defaultLang) {
                $q->where('language_code', $defaultLang->abbreviation);
            },
        ]);
        if (isset($_GET['withOpenDayDetail']) && $_GET['withOpenDayDetail'] == '1') {
            $openDays = $openDays->with('OpenDayDetail');
        }
        return $openDays;
    }

    protected function sortingAndLimit($openDays)
    {
        $sortType = ['ASC', 'asc', 'DESC', 'desc'];
        $sortBy = ['id', 'city', 'country', 'date', 'time'];
        if (isset($_GET['sortBy']) && $_GET['sortBy'] != '' && isset($_GET['sortType']) && $_GET['sortType'] != '' && in_array($_GET['sortBy'], $sortBy) && in_array($_GET['sortType'], $sortType)) {
            $openDays = $openDays->OrderBy($_GET['sortBy'], $_GET['sortType']);
        }

        if (isset($_GET['limit']) && $_GET['limit'] != '') {
            $limit = $_GET['limit'];
        } else {
            $limit = 10;
        }

        return $openDays->paginate($limit);
    }

    protected function whereClause($openDays)
    {
        if (isset($_GET['searchParam']) && $_GET['searchParam'] != '') {
            $openDays = $openDays->whereHas('OpenDayDetail', function ($q) {
                $q->where('title', 'LIKE', '%' . $_GET['searchParam'] . '%');
            });
        }
        return $openDays;
    }
}
