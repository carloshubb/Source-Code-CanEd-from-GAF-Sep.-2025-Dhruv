<?php

namespace App\Http\Controllers\Api\Web;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\DegreeDetailResource;
use App\Http\Resources\Web\SchoolAmbassadorResource;
use App\Jobs\AmbassadorRegisterEmailJob;
use App\Models\AmbssadorMessagingApp;
use App\Rules\CheckCategorySlug;
use App\Models\Customer;
use App\Models\DegreeDetail;
use Illuminate\Support\Str;
use App\Models\SchoolAmbassador;
use App\Models\SchoolAmbassadorDetail;
use App\Models\Language;
use App\Models\SchoolDetail;
use App\Traits\StatusResponser;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SchoolAmbassadorController extends Controller
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
        $faqs = SchoolAmbassador::whereCustomerId($customer->id);
        $faqs = $this->whereClause($faqs);
        $faqs = $this->loadRelations($faqs);
        $faqs = $this->sortingAndLimit($faqs);

        return $this->apiSuccessResponse(SchoolAmbassadorResource::collection($faqs), 'Data Get Successfully!');
    }

    public function show(SchoolAmbassador $SchoolAmbassador)
    {
        if (isset($_GET['withSchoolAmbassadorDetail']) && $_GET['withSchoolAmbassadorDetail'] == '1') {
            $SchoolAmbassador = $SchoolAmbassador->loadMissing('schoolAmbassadorDetail');
            $SchoolAmbassador = $SchoolAmbassador->loadMissing('messagingApp');
        }

        return $this->apiSuccessResponse(new SchoolAmbassadorResource($SchoolAmbassador), 'Data Get Successfully!');
    }

    public function store(Request $request)
    {
         $messagingApps= $request->messaging_apps;
        $validationRule = [];
        $errorMessages = [];
        $languages = getAllLanguages();
        foreach ($languages as $language) {
            if ($language->is_default == 1) {
                $validationRule = array_merge($validationRule, ['name.name_' . $language->abbreviation => ['required', 'string', new CheckCategorySlug($language, null)]]);
                $errorMessages = array_merge($errorMessages, ['name.name_' . $language->abbreviation . '.required' => 'Name is required']);
                $validationRule = array_merge($validationRule, ['about_me.about_me_' . $language->abbreviation => ['required', 'string']]);
                $errorMessages = array_merge($errorMessages, ['about_me.about_me_' . $language->abbreviation . '.required' => 'About me is required']);
            }
        }
        $validationRule = array_merge($validationRule, ['image' => ['required', 'string']]);
        $errorMessages = array_merge($errorMessages, ['image' . '.required' => 'Image is required']);
        $validationRule = array_merge($validationRule, ['langs' => ['required', 'string']]);
        $errorMessages = array_merge($errorMessages, ['langs' . '.required' => 'Languages is required']);
        $validationRule = array_merge($validationRule, ['degree_level' => ['required', 'string']]);
        $errorMessages = array_merge($errorMessages, ['degree_level' . '.required' => 'I study at is required']);
        $validationRule = array_merge($validationRule, ['hobies_interests' => ['required', 'string']]);
        $errorMessages = array_merge($errorMessages, ['hobies_interests' . '.required' => 'Hobbies and interests is required']);
        $validationRule = array_merge($validationRule, ['is_checked' => ['required', 'string']]);
        $errorMessages = array_merge($errorMessages, ['is_checked' . '.required' => 'Is checked is required']);
        $validationRule = array_merge($validationRule, ['mobile_number' => ['nullable', 'string', 'digits_between:1,15']]);
        $errorMessages = array_merge($errorMessages, [
            'mobile_number.digits_between' => 'Phone number cannot exceed 15 digits'
        ]);
        $validationRule = array_merge($validationRule, ['email' => ['required', 'string', 'email', 'unique:school_ambassadors,email']]);
        $validationRule = array_merge($validationRule, ['I_study_here' => ['required', 'string']]);
        $errorMessages = array_merge($errorMessages, ['I_study_here.required' => 'I study here is required.']);
        $validationRule = array_merge($validationRule, ['title' => ['required', 'string']]);
        $errorMessages = array_merge($errorMessages, ['title.required' => 'Title is required.']);
        $validationRule = array_merge($validationRule, ['region' => ['required', 'string']]);
        $errorMessages = array_merge($errorMessages, ['region.required' => 'I am from is required.']);
        $validationRule = array_merge($validationRule, ['city' => ['required', 'string']]);
        $errorMessages = array_merge($errorMessages, ['city.required' => 'City is required']);
        $validationRule = array_merge($validationRule, ['province' => ['required', 'string']]);
        $errorMessages = array_merge($errorMessages, ['province.required' => 'State/Province is required']);
        $validationRule = array_merge($validationRule, ['password' => ['required', 'string']]);
        $errorMessages = array_merge($errorMessages, ['password' . '.required' => 'Password is required']);
        $validationRule = array_merge($validationRule, ['category' => ['required', 'string']]);
        $errorMessages = array_merge($errorMessages, ['category.required' => 'Program / Field of study is required']);
        $validationRule = array_merge($validationRule, ['status' => ['required', 'string']]);
        $errorMessages = array_merge($errorMessages, ['status.required' => 'Status is required']);
        $validationRule = array_merge($validationRule, ['fav_module' => ['nullable', 'string']]);
        $errorMessages = array_merge($errorMessages, ['fav_module.required' => 'Fav module is required']);
        $this->validate($request, $validationRule, $errorMessages);
        $customer = Customer::where('id', $request->customer_id)->first();
        if ($customer->user_type == 'school') {
            $count = SchoolAmbassador::where('customer_id', $request->customer_id)->count();
            if ($customer->registrationPackage->ambassadors <= $count) {
                return $this->errorResponse("You've reached your package limit. Upgrade your package to continue creating more");
            }
        }
        $SchoolAmbassador = SchoolAmbassador::create([
            'image' => $request->image,
            'langs' => $request->langs,
            'degree_level' => $request->degree_level,
            'fav_module' => $request->fav_module,
            'hobies_interests' => $request->hobies_interests,
            'region' => $request->region,
            'province' => $request->province,
            'is_checked' => $request->is_checked,
            'I_study_here' => $request->I_study_here,
            'title' => $request->title,
            'city' => $request->city,
            'societies' => $request->societies,
            'category' => $request->category,
            'school_id' => $request->school_id,
            'customer_id' => $request->customer_id,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'whats_app_number' => isset($request->whats_app_number) ? $request->whats_app_number : '',
            'skype_id' => isset($request->skype_id) ? $request->skype_id : '',
            'we_chat_number' => isset($request->we_chat_number) ? $request->we_chat_number : '',
            'viber_number' => isset($request->viber_number) ? $request->viber_number : '',
            'imo_number' => isset($request->imo_number) ? $request->imo_number : '',
            'mobile_number' => isset($request->mobile_number) ? $request->mobile_number : '',
            'message_number' => isset($request->message_number) ? $request->message_number : '',
            'my_major' => $request->my_major,
            'my_minor' => $request->my_minor,
            'status' => $request->status,
        ]);
       

        $name = '';
        if ($SchoolAmbassador) {
            foreach ($messagingApps as $messagingAppId => $username) {

                AmbssadorMessagingApp::create([
                    'ambassadors_id' => $SchoolAmbassador->id,
                    'messaging_app_id' => $messagingAppId, 
                    'username' => $username 
                ]);
            }
            foreach ($request->languages as $key => $language) {
                if (!empty($request['name']['name_' . $language['language_code']]) && !empty($request['about_me']['about_me_' . $language['language_code']])) {
                    SchoolAmbassadorDetail::create([
                        'school_ambassador_id' => $SchoolAmbassador->id,
                        'language_code' => $language['language_code'],
                        'slug' => isset($request['name']['name_' . $language['language_code']]) ? Str::slug($request['name']['name_' . $language['language_code']]) : null,
                        'name' => $request['name']['name_' . $language['language_code']],
                        'about_me' => $request['about_me']['about_me_' . $language['language_code']],
                    ]);
                }
                if ($key == 0) {
                    $name = $request['name']['name_' . $language['language_code']];
                }
            }
            $schoolName = SchoolDetail::where('school_id', $request->school_id)->first();
            $emailData = ['name' => $name, 'email' => $request->email, 'password' => $request->password, 'school_name' => $schoolName->school_name];
            dispatch(new AmbassadorRegisterEmailJob($emailData));
            return $this->apiSuccessResponse(new SchoolAmbassadorResource($SchoolAmbassador), 'Your changes have been done successfully');
        }
      
        return $this->errorResponse();
    }

    public function update(Request $request, SchoolAmbassador $SchoolAmbassador)
    {
        $validationRule = [];
        $errorMessages = [];
        $languages = getAllLanguages();
        foreach ($languages as $language) {
            if ($language->is_default == 1) {
                $validationRule = array_merge($validationRule, ['name.name_' . $language->abbreviation => ['required', 'string', new CheckCategorySlug($language, null)]]);
                $errorMessages = array_merge($errorMessages, ['name.name_' . $language->abbreviation . '.required' => 'Name is required.']);
                $validationRule = array_merge($validationRule, ['about_me.about_me_' . $language->abbreviation => ['required', 'string']]);
                $errorMessages = array_merge($errorMessages, ['about_me.about_me_' . $language->abbreviation . '.required' => 'About me is required.']);
            }
        }
        $validationRule = array_merge($validationRule, ['region' => ['required', 'string']]);
        $errorMessages = array_merge($errorMessages, ['region.required' => 'I am from is required.']);
        $validationRule = array_merge($validationRule, ['image' => ['required', 'string']]);
        $errorMessages = array_merge($errorMessages, ['image' . '.required' => 'image is required.']);
        $validationRule = array_merge($validationRule, ['province' => ['required', 'string']]);
        $errorMessages = array_merge($errorMessages, ['province.required' => 'State/Province is required']);
        $validationRule = array_merge($validationRule, ['city' => ['required', 'string']]);
        $errorMessages = array_merge($errorMessages, ['city.required' => 'City is required']);
        $validationRule = array_merge($validationRule, ['title' => ['required', 'string']]);
        $errorMessages = array_merge($errorMessages, ['title.required' => 'Title is required.']);
        $validationRule = array_merge($validationRule, ['langs' => ['required', 'string']]);
        $errorMessages = array_merge($errorMessages, ['langs' . '.required' => 'languages is required.']);
        $validationRule = array_merge($validationRule, ['degree_level' => ['required', 'string']]);
        $errorMessages = array_merge($errorMessages, ['degree_level' . '.required' => 'degree level is required.']);
        $validationRule = array_merge($validationRule, ['fav_module' => ['nullable', 'string']]);
        $errorMessages = array_merge($errorMessages, ['fav_module' . '.required' => 'favourite module is required.']);
        $validationRule = array_merge($validationRule, ['hobies_interests' => ['required', 'string']]);
        $errorMessages = array_merge($errorMessages, ['hobies_interests' . '.required' => 'hobbies and interests module is required.']);
        $validationRule = array_merge($validationRule, ['societies' => ['nullable', 'string']]);
        $errorMessages = array_merge($errorMessages, ['societies' . '.required' => 'societies module is required.']);
        $validationRule = array_merge($validationRule, ['email' => ['required', 'string', 'email']]);
        $errorMessages = array_merge($errorMessages, ['email.required' => 'email is required.']);
        $validationRule = array_merge($validationRule, ['is_checked' => ['required', 'string']]);
        $errorMessages = array_merge($errorMessages, ['is_checked' . '.required' => 'is_checked is required.']);
        $validationRule = array_merge($validationRule, ['category' => ['required', 'string']]);
        $errorMessages = array_merge($errorMessages, ['category.required' => 'category is required.']);
        $validationRule = array_merge($validationRule, ['my_major' => ['nullable', 'string']]);
        $errorMessages = array_merge($errorMessages, ['my_major.required' => 'my_major is required.']);
        $validationRule = array_merge($validationRule, ['my_minor' => ['nullable', 'string']]);
        $errorMessages = array_merge($errorMessages, ['my_minor.required' => 'my_minor is required.']);
        $validationRule = array_merge($validationRule, ['I_study_here' => ['required', 'string']]);
        $errorMessages = array_merge($errorMessages, ['I_study_here.required' => 'I study here is required']);
        $validationRule = array_merge($validationRule, ['status' => ['required', 'string']]);
        $errorMessages = array_merge($errorMessages, ['status.required' => 'status is required.']);
        $validationRule = array_merge($validationRule, ['mobile_number' => ['required', 'string', 'digits_between:1,15']]);
        $errorMessages = array_merge($errorMessages, [
            'mobile_number' . '.required' => 'Mobile number is required.',
            'mobile_number.digits_between' => 'Phone number cannot exceed 15 digits'
        ]);

        $this->validate($request, $validationRule, $errorMessages);
        if (!empty($request->password)) {
            $SchoolAmbassador->update([
                'image' => $request->image,
                'langs' => $request->langs,
                'degree_level' => $request->degree_level,
                'fav_module' => $request->fav_module,
                'hobies_interests' => $request->hobies_interests,
                'societies' => $request->societies,
                'title' => $request->title,
                'category' => $request->category,
                'school_id' => $request->school_id,
                'customer_id' => $request->customer_id,
                'region' => $request->region,
                'province' => $request->province,
                'is_checked' => $request->is_checked,
                'I_study_here' => $request->I_study_here,
                'city' => $request->city,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'whats_app_number' => isset($request->whats_app_number) ? $request->whats_app_number : '',
                'skype_id' => isset($request->skype_id) ? $request->skype_id : '',
                'we_chat_number' => isset($request->we_chat_number) ? $request->we_chat_number : '',
                'viber_number' => isset($request->viber_number) ? $request->viber_number : '',
                'imo_number' => isset($request->imo_number) ? $request->imo_number : '',
                'mobile_number' => isset($request->mobile_number) ? $request->mobile_number : '',
                'message_number' => isset($request->message_number) ? $request->message_number : '',
                'my_major' => $request->my_major,
                'my_minor' => $request->my_minor,
                'status' => $request->status,
            ]);
        } else {
            $SchoolAmbassador->update([
                'image' => $request->image,
                'langs' => $request->langs,
                'degree_level' => $request->degree_level,
                'fav_module' => $request->fav_module,
                'hobies_interests' => $request->hobies_interests,
                'societies' => $request->societies,
                'category' => $request->category,
                'school_id' => $request->school_id,
                'customer_id' => $request->customer_id,
                'region' => $request->region,
                'province' => $request->province,
                'I_study_here' => $request->I_study_here,
                'city' => $request->city,
                'email' => $request->email,
                'whats_app_number' => isset($request->whats_app_number) ? $request->whats_app_number : '',
                'skype_id' => isset($request->skype_id) ? $request->skype_id : '',
                'we_chat_number' => isset($request->we_chat_number) ? $request->we_chat_number : '',
                'viber_number' => isset($request->viber_number) ? $request->viber_number : '',
                'imo_number' => isset($request->imo_number) ? $request->imo_number : '',
                'mobile_number' => isset($request->mobile_number) ? $request->mobile_number : '',
                'message_number' => isset($request->message_number) ? $request->message_number : '',
                'my_major' => $request->my_major,
                'my_minor' => $request->my_minor,
                'status' => $request->status,
            ]);
        }

        foreach ($request->languages as $language) {
            if (!empty($request['name']['name_' . $language['language_code']]) && !empty($request['about_me']['about_me_' . $language['language_code']])) {
                $SchoolAmbassadorDetail = SchoolAmbassadorDetail::whereLanguageCode($language['language_code'])
                    ->whereSchoolAmbassadorId($SchoolAmbassador->id)
                    ->exists();
                if ($SchoolAmbassadorDetail) {
                    SchoolAmbassadorDetail::whereLanguageCode($language['language_code'])
                        ->whereSchoolAmbassadorId($SchoolAmbassador->id)
                        ->update([
                            'school_ambassador_id' => $SchoolAmbassador->id,
                            'language_code' => $language['language_code'],
                            'slug' => isset($request['name']['name_' . $language['language_code']]) ? Str::slug($request['name']['name_' . $language['language_code']]) : null,
                            'name' => $request['name']['name_' . $language['language_code']],
                            'about_me' => $request['about_me']['about_me_' . $language['language_code']],
                        ]);
                } else {
                    SchoolAmbassadorDetail::create([
                        'school_ambassador_id' => $SchoolAmbassador->id,
                        'language_code' => $language['language_code'],
                        'slug' => isset($request['name']['name_' . $language['language_code']]) ? Str::slug($request['name']['name_' . $language['language_code']]) : null,
                        'name' => $request['name']['name_' . $language['language_code']],
                        'about_me' => $request['about_me']['about_me_' . $language['language_code']],
                    ]);
                }
            }
        }

        if ($SchoolAmbassador) {
            return $this->apiSuccessResponse(new SchoolAmbassadorResource($SchoolAmbassador), 'Your changes have been done successfully');
        }
        return $this->errorResponse();
    }

    public function destroy(Request $request, SchoolAmbassador $SchoolAmbassador)
    {
        if ($SchoolAmbassador->SchoolAmbassadorDetail()->delete() && $SchoolAmbassador->delete()) {
            return $this->apiSuccessResponse(new SchoolAmbassadorResource($SchoolAmbassador), 'The selected item has been deleted successfully');
        }
        return $this->errorResponse();
    }

    protected function loadRelations($faqs)
    {
        $defaultLang = getDefaultLanguage();
        $faqs = $faqs->with([
            'SchoolAmbassadorDetail' => function ($q) use ($defaultLang) {
                $q->where('language_code', $defaultLang->abbreviation);
            },
        ]);
        if (isset($_GET['withSchoolAmbassadorDetail']) && $_GET['withSchoolAmbassadorDetail'] == '1') {
            $faqs = $faqs->with('schoolAmbassadorDetail');
        }
        $faqs = $faqs->with('degree_detail');
        return $faqs;
    }

    protected function sortingAndLimit($faqs)
    {
        $sortType = ['ASC', 'asc', 'DESC', 'desc'];
        $sortBy = ['id', 'name', 'abbreviation', 'SchoolAmbassador_name'];
        if (isset($_GET['sortBy']) && $_GET['sortBy'] != '' && isset($_GET['sortType']) && $_GET['sortType'] != '' && in_array($_GET['sortBy'], $sortBy) && in_array($_GET['sortType'], $sortType)) {
            $faqs = $faqs->OrderBy($_GET['sortBy'], $_GET['sortType']);
        }

        if (isset($_GET['limit']) && $_GET['limit'] != '') {
            $limit = $_GET['limit'];
        } else {
            $limit = 10;
        }

        return $faqs->paginate($limit);
    }

    protected function whereClause($faqs)
    {
        if (isset($_GET['searchParam']) && $_GET['searchParam'] != '') {
            $faqs = $faqs->whereHas('SchoolAmbassadorDetail', function ($q) {
                $q->where('name', 'LIKE', '%' . $_GET['searchParam'] . '%');
            });
        }
        if (isset($_GET['type']) && $_GET['type'] != '') {
            $faqs = $faqs->where('type', $_GET['type']);
        }
        return $faqs;
    }

    public function saveZohoCredentials(Request $request)
    {
        $errorMessages = [];
        $validationRule = [];
        $validationRule = array_merge($validationRule, ['client_id' => ['required', 'string']]);
        $errorMessages = array_merge($errorMessages, ['client_id.required' => 'Zoho client id is required.']);
        $validationRule = array_merge($validationRule, ['client_secret' => ['required', 'string']]);
        $errorMessages = array_merge($errorMessages, ['client_secret.required' => 'Zoho client Secret is required.']);
        $this->validate($request, $validationRule, $errorMessages);
        $schoolAmbassador = SchoolAmbassador::where('id', $request->school_ambassador_id)->first();
        $schoolAmbassador->update([
            'zoho_client_id' => $request->client_id,
            'zoho_client_secret' => $request->client_secret,
        ]);
        return $this->apiSuccessResponse(new SchoolAmbassadorResource($schoolAmbassador), 'information saved successfully.');
    }
    public function DegreeLevels()
    {
        $activeTab = $_GET['lang']; // or use request()->get('activeTab') for better practice

        $ambassadors = DegreeDetail::with('language')
            ->whereHas('language', function($query) use ($activeTab) {
                $query->where('abbreviation', $activeTab);
            })
            ->orderBy('name','ASC')->get();
        

        return $this->apiSuccessResponse(DegreeDetailResource::collection($ambassadors), 'Data Get Successfully!');
    }
}
