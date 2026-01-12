<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\SchoolAmbassadorResource;
use App\Http\Resources\Admin\DegreeDetailResource;
use App\Models\DegreeDetail;
use App\Jobs\AmbassadorRegisterEmailJob;
use App\Models\AmbssadorMessagingApp;
use App\Models\SchoolAmbassador;
use App\Models\SchoolAmbassadorDetail;
use Illuminate\Support\Facades\Hash;
use App\Rules\CheckCategorySlug;
use App\Traits\StatusResponser;
use Illuminate\Support\Str;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;

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
        $ambassadors = SchoolAmbassador::query();

        $ambassadors = $this->whereClause($ambassadors);
        $ambassadors = $this->loadRelations($ambassadors);
        $ambassadors = $this->sortingAndLimit($ambassadors);

        return $this->apiSuccessResponse(SchoolAmbassadorResource::collection($ambassadors), 'Data Get Successfully!');
    }
    public function store(Request $request)
    {
        $messagingApps = $request->messaging_apps;

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
        // $validationRule = array_merge($validationRule, ['title' => ['nullable', 'string']]);
        // $errorMessages = array_merge($errorMessages, ['title' . '.required' => 'Title is required']);
        $validationRule = array_merge($validationRule, ['degree_level' => ['required', 'string']]);
        $errorMessages = array_merge($errorMessages, ['degree_level' . '.required' => 'I study at is required']);
        $validationRule = array_merge($validationRule, ['hobies_interests' => ['required', 'string']]);
        $errorMessages = array_merge($errorMessages, ['hobies_interests' . '.required' => 'Hobbies and interests is required']);
        $validationRule = array_merge($validationRule, ['mobile_number' => ['nullable', 'string', 'digits_between:1,15']]);
        $errorMessages = array_merge($errorMessages, [
            'mobile_number.digits_between' => 'Phone number cannot exceed 15 digits'
        ]);
        $validationRule = array_merge($validationRule, ['email' => ['required', 'string', 'email', 'unique:school_ambassadors,email']]);
        $validationRule = array_merge($validationRule, ['I_study_here' => ['required', 'string']]);
        $errorMessages = array_merge($errorMessages, ['I_study_here.required' => 'I study here is required']);
        $validationRule = array_merge($validationRule, ['password' => ['required', 'string']]);
        $errorMessages = array_merge($errorMessages, ['password' . '.required' => 'Password is required']);
        $validationRule = array_merge($validationRule, ['category' => ['required', 'string']]);
        $errorMessages = array_merge($errorMessages, ['category.required' => 'Program / Field of study is required']);
        $validationRule = array_merge($validationRule, ['status' => ['required', 'string']]);
        $errorMessages = array_merge($errorMessages, ['status.required' => 'Status is required']);
        $validationRule = array_merge($validationRule, ['region' => ['nullable', 'string']]);
        $errorMessages = array_merge($errorMessages, ['region.required' => 'I am from is required']);
        $validationRule = array_merge($validationRule, ['fav_module' => ['nullable', 'string']]);
        $errorMessages = array_merge($errorMessages, ['fav_module' . '.required' => 'favorite module is required.']);
        $this->validate($request, $validationRule, $errorMessages);
        // $customer = Customer::where('id', $request->customer_id)->first();
        // if ($customer->user_type == 'school') {
        //     $count = SchoolAmbassador::where('customer_id', $request->customer_id)->count();
        //     if ($customer->registrationPackage->ambassadors <= $count) {
        //         return $this->errorResponse('Form submission limit exceeded. Please try again later.');
        //     }
        // }
        $SchoolAmbassador = SchoolAmbassador::create([
            'image' => $request->image,
            'langs' => $request->langs,
            'degree_level' => $request->degree_level,
            'fav_module' => $request->fav_module,
            // 'title' => $request->title,
            'hobies_interests' => $request->hobies_interests,
            'region' => $request->region,
            'province' => $request->province,
            'I_study_here' => $request->I_study_here,
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
        if ($SchoolAmbassador) {
            foreach ($messagingApps as $messagingAppId => $username) {

                AmbssadorMessagingApp::create([
                    'ambassadors_id' => $SchoolAmbassador->id,
                    'messaging_app_id' => $messagingAppId,
                    'username' => $username
                ]);
            }
            foreach ($languages as $language) {
                if (!empty($request['name']['name_' . $language->abbreviation]) && !empty($request['about_me']['about_me_' . $language->abbreviation])) {
                    // dd($request->all());
                    SchoolAmbassadorDetail::create([
                        'school_ambassador_id' => $SchoolAmbassador->id,
                        'language_code' => $language->abbreviation,
                        'slug' => isset($request['name']['name_' . $language->abbreviation]) ? Str::slug($request['name']['name_' . $language->abbreviation]) : null,
                        'name' => $request['name']['name_' . $language->abbreviation],
                        'about_me' => $request['about_me']['about_me_' . $language->abbreviation],
                    ]);
                }
            }
            // $emailData = [
            //     'name' => $name, 
            //     'email' => $request->email, 
            //     'password' => $request->password // Be cautious with plaintext passwords!
            // ];

            // dispatch(new AmbassadorRegisterEmailJob($emailData));
            return $this->apiSuccessResponse(new SchoolAmbassadorResource($SchoolAmbassador), 'Your changes have been done successfully');
        }
        return $this->errorResponse();
    }

    public function show(SchoolAmbassador $ambassador)
    {
        // if (isset($_GET['withSchoolAmbassadorDetail']) && $_GET['withSchoolAmbassadorDetail'] == '1') {
        $ambassador = $ambassador->loadMissing('schoolAmbassadorDetail');
        $ambassador = $ambassador->loadMissing('messagingApp');

        // }
        return $this->apiSuccessResponse(new SchoolAmbassadorResource($ambassador), 'Data Get Successfully!');
    }

    public function update(Request $request, SchoolAmbassador $ambassador)
    {
        // dd($request->all());
        $validationRule = [];
        $errorMessages = [];
        $languages = getAllLanguages();
        foreach ($languages as $language) {
            if ($language->is_default == 1) {
                $validationRule = array_merge($validationRule, ['name.name_' . $language->abbreviation => ['nullable', 'string', new CheckCategorySlug($language, null)]]);
                $errorMessages = array_merge($errorMessages, ['name.name_' . $language->abbreviation . '.required' => 'Name is required']);
                $validationRule = array_merge($validationRule, ['about_me.about_me_' . $language->abbreviation => ['nullable', 'string']]);
                $errorMessages = array_merge($errorMessages, ['about_me.about_me_' . $language->abbreviation . '.required' => 'About me is required']);
            }
        }

        $validationRule = array_merge($validationRule, ['region' => ['nullable', 'string']]);
        $errorMessages = array_merge($errorMessages, ['region' . '.required' => 'Region is required.']);
        // $validationRule = array_merge($validationRule, ['title' => ['nullable', 'string']]);
        // $errorMessages = array_merge($errorMessages, ['title' . '.required' => 'Title is required']);
        $validationRule = array_merge($validationRule, ['langs' => ['required', 'string']]);
        $errorMessages = array_merge($errorMessages, ['langs' . '.required' => 'languages is required.']);
        $validationRule = array_merge($validationRule, ['degree_level' => ['required', 'string']]);
        $errorMessages = array_merge($errorMessages, ['degree_level' . '.required' => 'degree level in is required.']);
        $validationRule = array_merge($validationRule, ['fav_module' => ['nullable', 'string']]);
        $errorMessages = array_merge($errorMessages, ['fav_module' . '.required' => 'favorite module is required.']);
        $validationRule = array_merge($validationRule, ['hobies_interests' => ['required', 'string']]);
        $errorMessages = array_merge($errorMessages, ['hobies_interests' . '.required' => 'hobbies and interests is required.']);
        $validationRule = array_merge($validationRule, ['societies' => ['nullable', 'string']]);
        $errorMessages = array_merge($errorMessages, ['societies' . '.required' => 'Societies is required.']);
        $validationRule = array_merge($validationRule, ['email' => ['required', 'string', 'email']]);
        $errorMessages = array_merge($errorMessages, ['email' . '.required' => 'email is required.']);
        $validationRule = array_merge($validationRule, ['category' => ['required', 'string']]);
        $errorMessages = array_merge($errorMessages, ['category.required' => 'category is required.']);
        $validationRule = array_merge($validationRule, ['my_major' => ['nullable', 'string']]);
        $errorMessages = array_merge($errorMessages, ['my_major.required' => 'My major is required.']);
        $validationRule = array_merge($validationRule, ['I_study_here' => ['required', 'string']]);
        $errorMessages = array_merge($errorMessages, ['I_study_here.required' => 'I study here is required.']);
        $validationRule = array_merge($validationRule, ['my_minor' => ['nullable', 'string']]);
        $errorMessages = array_merge($errorMessages, ['my_minor.required' => 'My minor is required.']);
        $validationRule = array_merge($validationRule, ['status' => ['required', 'string']]);
        $errorMessages = array_merge($errorMessages, ['status.required' => 'status is required.']);
        $this->validate($request, $validationRule, $errorMessages);
        if ($request->has('messaging_apps')) {
            // Fetch existing messaging apps for the ambassador
            $existingMessagingApps = AmbssadorMessagingApp::where('ambassadors_id', $ambassador->id)
                ->pluck('id', 'messaging_app_id')
                ->toArray();

            // Get the messaging apps from the request
            $requestMessagingApps = $request->messaging_apps;

            // Delete apps that are not in the request
            foreach ($existingMessagingApps as $messagingAppId => $id) {
                if (!array_key_exists($messagingAppId, $requestMessagingApps)) {
                    AmbssadorMessagingApp::where('id', $id)->delete();
                }
            }
// dd($requestMessagingApps);
            // Add or update apps that are in the request
            foreach ($requestMessagingApps as $messagingAppId => $username) {
                AmbssadorMessagingApp::updateOrCreate(
                    [
                        'ambassadors_id' => $ambassador->id,
                        'messaging_app_id' => $messagingAppId,
                        'username' => $username,
                    ]
                );
            }
        } else {
            // If no messaging apps are provided, delete all existing ones
            AmbssadorMessagingApp::where('ambassadors_id', $ambassador->id)->delete();
        }
        $ambassador->update([
            'langs' => $request->langs,
            'degree_level' => $request->degree_level,
            'fav_module' => $request->fav_module,
            // 'title' => $request->title,
            'hobies_interests' => $request->hobies_interests,
            'region' => $request->region,
            'societies' => $request->societies,
            'category' => $request->category,
            'email' => $request->email,
            'whats_app_number' => isset($request->whats_app_number) ? $request->whats_app_number : '',
            'skype_id' => isset($request->skype_id) ? $request->skype_id : '',
            'we_chat_number' => isset($request->we_chat_number) ? $request->we_chat_number : '',
            'viber_number' => isset($request->viber_number) ? $request->viber_number : '',
            'imo_number' => isset($request->imo_number) ? $request->imo_number : '',
            'mobile_number' => isset($request->mobile_number) ? $request->mobile_number : '',
            'my_major' => $request->my_major,
            'I_study_here' => $request->I_study_here,
            'my_minor' => $request->my_minor,
            'status' => $request->status,
        ]);

        foreach ($languages as $language) {
            if (!empty($request['name']['name_' . $language->abbreviation]) && !empty($request['about_me']['about_me_' . $language->abbreviation])) {
                $SchoolAmbassadorDetail = SchoolAmbassadorDetail::whereLanguageCode($language->abbreviation)
                    ->whereSchoolAmbassadorId($ambassador->id)
                    ->exists();
                if ($SchoolAmbassadorDetail) {
                    SchoolAmbassadorDetail::whereLanguageCode($language->abbreviation)
                        ->whereSchoolAmbassadorId($ambassador->id)
                        ->update([
                            'school_ambassador_id' => $ambassador->id,
                            'language_code' => $language->abbreviation,
                            'slug' => isset($request['name']['name_' . $language->abbreviation]) ? Str::slug($request['name']['name_' . $language->abbreviation]) : null,
                            'name' => $request['name']['name_' . $language->abbreviation],
                            'about_me' => $request['about_me']['about_me_' . $language->abbreviation],
                        ]);
                } else {
                    SchoolAmbassadorDetail::create([
                        'school_ambassador_id' => $ambassador->id,
                        'language_code' => $language->abbreviation,
                        'slug' => isset($request['name']['name_' . $language->abbreviation]) ? Str::slug($request['name']['name_' . $language->abbreviation]) : null,
                        'name' => $request['name']['name_' . $language->abbreviation],
                        'about_me' => $request['about_me']['about_me_' . $language->abbreviation],
                    ]);
                }
            }
        }
        if ($ambassador) {
            return $this->apiSuccessResponse(new SchoolAmbassadorResource($ambassador), 'Your changes have been done successfully');
        }
        return $this->errorResponse();
    }

    protected function loadRelations($ambassadors)
    {
        $ambassadors = $ambassadors->with('schoolAmbassadorDetail');
        return $ambassadors;
    }

    protected function sortingAndLimit($ambassadors)
    {
        if (isset($_GET['limit']) && $_GET['limit'] != '') {
            $limit = $_GET['limit'];
        } else {
            $limit = 10;
        }

        $ambassadors = $ambassadors->addSelect([
            'name' => function ($query) {
                $query->select('name')
                    ->from('school_ambassador_details')
                    ->whereColumn('school_ambassador_details.school_ambassador_id', 'school_ambassadors.id')
                    ->limit(1);
            }
        ])->orderBy('name', 'ASC');

        return $ambassadors->paginate($limit);
        // return $ambassadors->orderBy('region', 'ASC')->paginate($limit);
    }

    protected function whereClause($ambassadors)
    {
        if (isset($_GET['searchParam']) && $_GET['searchParam'] != '') {
            $ambassadors = $ambassadors
                ->whereHas('schoolAmbassadorDetail', function ($q) {
                    $q->where('name', 'LIKE', '%' . $_GET['searchParam'] . '%');
                })
                ->orWhere('region', $_GET['searchParam']);
        }
        return $ambassadors;
    }
    public function DegreeLevels()
    {
        $activeTab = $_GET['lang']; // or use request()->get('activeTab') for better practice

        $ambassadors = DegreeDetail::with('language')
            ->whereHas('language', function ($query) use ($activeTab) {
                $query->where('abbreviation', $activeTab);
            })
            ->orderBy('name', 'ASC')->get();


        return $this->apiSuccessResponse(DegreeDetailResource::collection($ambassadors), 'Data Get Successfully!');
    }
}
