<?php

namespace App\Http\Controllers\Api\Web;

use App\Http\Controllers\Controller;
use App\Http\Resources\Web\WebinarResource;
use App\Models\Customer;
use App\Models\SchoolAmbassador;
use Illuminate\Support\Str;
use App\Models\Webinar;
use App\Models\WebinarDetail;
use App\Models\WebinarParticepent;
use App\Services\ZohoService;
use App\Traits\StatusResponser;
use App\Traits\FileUploadTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;

class WebinarController extends Controller
{
    use StatusResponser;
    use FileUploadTrait;

    public function index()
    {
        $ambassador = auth()
            ->guard('school_ambassadors')
            ->user();
        $webinars = Webinar::where('ambassador_id', $ambassador->id);
        $webinars = $this->whereClause($webinars);
        $webinars = $this->loadRelations($webinars);
        $webinars = $this->sortingAndLimit($webinars);

        return $this->apiSuccessResponse(WebinarResource::collection($webinars), 'Data Get Successfully!');
    }

    public function show(Webinar $Webinar)
    {
        if (isset($_GET['withWebinarDetail']) && $_GET['withWebinarDetail'] == '1') {
            $Webinar = $Webinar->loadMissing('webinarDetail');
        }

        return $this->apiSuccessResponse(new WebinarResource($Webinar), 'Data Get Successfully!');
    }

    public function store(Request $request)
    {
        ini_set('max_execution_time', 1200);
        $ambassador = auth()
            ->guard('school_ambassadors')
            ->user();

        if (empty($ambassador->zoho_client_id) || empty($ambassador->zoho_client_secret)) {
            return $this->errorResponse('Please make sure you have added the zoho credentials client id and client secret');
        }
        $validationRule = [];
        $errorMessages = [];
        $languages = getAllLanguages();
        foreach ($languages as $language) {
            if ($language->is_default == 1) {
                $validationRule = array_merge($validationRule, ['agenda.agenda_' . $language->id => ['required', 'string']]);
                $errorMessages = array_merge($errorMessages, ['agenda.agenda_' . $language->id . '.required' => 'Agenda in ' . $language->name . ' is required.']);
                $validationRule = array_merge($validationRule, ['topic.topic_' . $language->id => ['required', 'string']]);
                $errorMessages = array_merge($errorMessages, ['topic.topic_' . $language->id . '.required' => 'Topic in ' . $language->name . ' is required.']);
            }
        }
        $validationRule = array_merge($validationRule, ['start_date' => ['required', 'string']]);
        $errorMessages = array_merge($errorMessages, ['start_date' . '.required' => 'Start date is required.']);
        $validationRule = array_merge($validationRule, ['timezone' => ['required', 'string']]);
        $errorMessages = array_merge($errorMessages, ['timezone' . '.required' => 'TimeZone is required.']);
        $validationRule = array_merge($validationRule, ['type' => ['required', 'string']]);
        $errorMessages = array_merge($errorMessages, ['type' . '.required' => 'Type is required.']);
        $validationRule = array_merge($validationRule, ['duration' => ['required', 'string']]);
        $errorMessages = array_merge($errorMessages, ['duration' . '.required' => 'Duration is required.']);
        $validationRule = array_merge($validationRule, ['image' => ['required', 'string']]);
        $errorMessages = array_merge($errorMessages, ['image' . '.required' => 'Image is required.']);
        if ($request->type == 'online') {
            $validationRule = array_merge($validationRule, ['particepents.*.email' => ['required', 'email']]);
        }
        $this->validate($request, $validationRule, $errorMessages);
        $ambassador = auth()
            ->guard('school_ambassadors')
            ->user();
        if (isset($ambassador->customer_id)) {
            $customer = Customer::where('id', $ambassador->customer_id)->first();
            if ($customer->user_type == 'school') {
                $count = Webinar::where('ambassador_id', $ambassador->id)->count();
                if ($customer->registrationPackage->webinars <= $count) {
                    return $this->errorResponse('Form submission limit exceeded. Please try again later.');
                }
            }
        }

        $carbonDateTime = Carbon::parse($request->start_date);
        $formattedDateTime = $carbonDateTime->format('M d, Y h:i A');
        $zohoWebinar = null;
        if ($request->type == 'online') {
            $zohoService = new ZohoService();
            $accessToken = $zohoService->refreshToken();
            if (!empty($accessToken)) {
                $zohoUser = $zohoService->fetchUser($accessToken);
                if (!empty($zohoUser['zsoid']) && !empty($zohoUser['zuid'])) {
                    $data = [
                        'zsoid' => $zohoUser['zsoid'],
                        'zuid' => $zohoUser['zuid'],
                        'accessToken' => $accessToken,
                        'start_date' => $formattedDateTime, // $request->start_date || D'ec 19, 2023 04:00 PM'
                        'duration' => ((int) $request->duration) * 60 * 1000,
                        'agenda' => $request['agenda']['agenda_1'],
                        'topic' => $request['topic']['topic_1'],
                        "isPastSession" => true,
                        "registrationRequire" => false
                    ];
                    if (isset($request->particepents)) {
                        foreach ($request->particepents as $particepent) {
                            $data['particepents'][] = ['email' => $particepent['email']];
                        }
                    }
                    $zohoWebinar = $zohoService->createWebinar((object) $data);
                }
            }
        }
        $Webinar = Webinar::create([
            'type' => $request->type,
            'start_date' => $request->start_date,
            'timezone' => $request->timezone,
            'type' => $request->type,
            'duration' => $request->duration,
            'webinar_link' => $request->webinar_link,
            'ambassador_id' => $request->ambassador_id,
            'zoho_webinar' => $request->type == 'online' ? json_encode($zohoWebinar) : '{}',
            'image' => $request->image,
        ]);

        if ($Webinar) {
            foreach ($request->languages as $language) {
                if (!empty($request['agenda']['agenda_' . $language['id']]) && !empty($request['topic']['topic_' . $language['id']])) {
                    WebinarDetail::create([
                        'webinar_id' => $Webinar->id,
                        'language_code' => $language['id'],
                        'agenda' => $request['agenda']['agenda_' . $language['id']],
                        'topic' => $request['topic']['topic_' . $language['id']],
                    ]);
                }
            }
            if ($request->type == 'online') {
                if (isset($request->particepents)) {
                    foreach ($request->particepents as $particepent) {
                        WebinarParticepent::create([
                            'webinar_id' => $Webinar->id,
                            'email' => $particepent['email'],
                        ]);
                    }
                }
            }
            return $this->apiSuccessResponse(new WebinarResource($Webinar), 'Your changes have been done successfully');
        }
        return $this->errorResponse();
    }

    public function update(Request $request, Webinar $Webinar)
    {
        $validationRule = [];
        $errorMessages = [];
        $languages = getAllLanguages();
        foreach ($languages as $language) {
            if ($language->is_default == 1) {
                $validationRule = array_merge($validationRule, ['agenda.agenda_' . $language->id => ['required', 'string']]);
                $errorMessages = array_merge($errorMessages, ['agenda.agenda_' . $language->id . '.required' => 'Agenda in ' . $language->name . ' is required.']);
                $validationRule = array_merge($validationRule, ['topic.topic_' . $language->id => ['required', 'string']]);
                $errorMessages = array_merge($errorMessages, ['topic.topic_' . $language->id . '.required' => 'Topic in ' . $language->name . ' is required.']);
            }
        }
        $validationRule = array_merge($validationRule, ['start_date' => ['required', 'string']]);
        $errorMessages = array_merge($errorMessages, ['start_date' . '.required' => 'Start date is required.']);
        $validationRule = array_merge($validationRule, ['timezone' => ['required', 'string']]);
        $errorMessages = array_merge($errorMessages, ['timezone' . '.required' => 'TimeZone is required.']);
        $validationRule = array_merge($validationRule, ['type' => ['required', 'string']]);
        $errorMessages = array_merge($errorMessages, ['type' . '.required' => 'Type is required.']);
        $validationRule = array_merge($validationRule, ['duration' => ['required', 'string']]);
        $errorMessages = array_merge($errorMessages, ['duration' . '.required' => 'Duration is required.']);
        $validationRule = array_merge($validationRule, ['image' => ['required', 'string']]);
        $errorMessages = array_merge($errorMessages, ['image' . '.required' => 'Image is required.']);
        $this->validate($request, $validationRule, $errorMessages);
        $carbonDateTime = Carbon::parse($request->start_date);
        $formattedDateTime = $carbonDateTime->format('M d, Y h:i A');
        $zohoWebinar = null;
        if (!empty($Webinar->zoho_webinar) && $Webinar->type == 'online' && $request->type == 'online') {
            $zohoService = new ZohoService();
            $accessToken = $zohoService->refreshToken();
            if (!empty($accessToken)) {
                $zohoUser = $zohoService->fetchUser($accessToken);
                $zoho_webinar = json_decode($Webinar->zoho_webinar);
                $data = [
                    'zsoid' => $zohoUser['zsoid'],
                    'zuid' => $zohoUser['zuid'],
                    'accessToken' => $accessToken,
                    'start_date' => $formattedDateTime, // $request->start_date || D'ec 19, 2023 04:00 PM'
                    'duration' => ((int) $request->duration) * 60 * 1000,
                    'agenda' => $request['agenda']['agenda_1'],
                    'topic' => $request['topic']['topic_1'],
                    'webinarKey' => $zoho_webinar->session->meetingKey,
                ];
                if (isset($request->particepents)) {
                    foreach ($request->particepents as $particepent) {
                        $data['particepents'][] = ['email' => $particepent['email']];
                    }
                }
                $zohoWebinar = $zohoService->updateWebinar((object) $data);
            }
        }
        if (!empty($Webinar->zoho_webinar) && $Webinar->type == 'online' && $request->type == 'offline') {
            $zohoService = new ZohoService();
            $accessToken = $zohoService->refreshToken();
            if (!empty($accessToken)) {
                $zohoUser = $zohoService->fetchUser($accessToken);
                $zoho_webinar = json_decode($Webinar->zoho_webinar);
                if (isset($zoho_webinar->session->meetingKey)) {
                    $data = (object) [
                        'zsoid' => $zohoUser['zsoid'],
                        'webinarKey' => $zoho_webinar->session->meetingKey,
                        'accessToken' => $accessToken,
                    ];
                    $zohoWebinar = $zohoService->deleteWebinar($data);
                }
            }
            $zohoWebinar = null;
        }

        if ($Webinar->type == 'offline' && $request->type == 'online') {
            $zohoService = new ZohoService();
            $accessToken = $zohoService->refreshToken();
            if (!empty($accessToken)) {
                $zohoUser = $zohoService->fetchUser($accessToken);
                // dd($zohoUser['zsoid'], $zohoUser['zuid']);
                $data = [
                    'zsoid' => $zohoUser['zsoid'],
                    'zuid' => $zohoUser['zuid'],
                    'accessToken' => $accessToken,
                    'start_date' => $formattedDateTime, // $request->start_date || D'ec 19, 2023 04:00 PM'
                    'duration' => ((int) $request->duration) * 60 * 1000,
                    'agenda' => $request['agenda']['agenda_1'],
                    'topic' => $request['topic']['topic_1'],
                ];
                if (isset($request->particepents)) {
                    foreach ($request->particepents as $particepent) {
                        $data['particepents'][] = ['email' => $particepent['email']];
                    }
                }
                $zohoWebinar = $zohoService->updateWebinar((object) $data);
            }
        }
        $Webinar->update([
            'type' => $request->type,
            'start_date' => $request->start_date,
            'timezone' => $request->timezone,
            'type' => $request->type,
            'duration' => $request->duration,
            'webinar_link' => $request->webinar_link,
            'image' => $request->image,
            'zoho_webinar' => $request->type == 'online' ? json_encode($zohoWebinar) : '{}',
        ]);
        foreach ($request->languages as $language) {
            if (!empty($request['agenda']['agenda_' . $language['id']]) && !empty($request['topic']['topic_' . $language['id']])) {
                $WebinarDetail = WebinarDetail::whereLanguageCode($language['id'])
                    ->whereWebinarId($Webinar->id)
                    ->exists();
                if ($WebinarDetail) {
                    WebinarDetail::whereLanguageCode($language['id'])
                        ->whereWebinarId($Webinar->id)
                        ->update([
                            'webinar_id' => $Webinar->id,
                            'language_code' => $language['id'],
                            'agenda' => $request['agenda']['agenda_' . $language['id']],
                            'topic' => $request['topic']['topic_' . $language['id']],
                        ]);
                } else {
                    WebinarDetail::create([
                        'webinar_id' => $Webinar->id,
                        'language_code' => $language['id'],
                        'agenda' => $request['agenda']['agenda_' . $language['id']],
                        'topic' => $request['topic']['topic_' . $language['id']],
                    ]);
                }
            }
            if ($request->type == 'online') {
                WebinarParticepent::where('webinar_id', $Webinar->id)->delete();
                if (isset($request->particepents)) {
                    foreach ($request->particepents as $particepent) {
                        WebinarParticepent::create([
                            'webinar_id' => $Webinar->id,
                            'email' => $particepent['email'],
                        ]);
                    }
                }
            }
        }

        if ($Webinar) {
            return $this->apiSuccessResponse(new WebinarResource($Webinar), 'Your changes have been done successfully');
        }
        return $this->errorResponse();
    }

    public function destroy(Webinar $Webinar)
    {
        if ($Webinar->type == 'online') {
            $zohoService = new ZohoService();
            $accessToken = $zohoService->refreshToken();
            if (!empty($Webinar->zoho_webinar) && !empty($accessToken)) {
                $zohoUser = $zohoService->fetchUser($accessToken);
                $zoho_webinar = json_decode($Webinar->zoho_webinar);
                if (isset($zoho_webinar->session->meetingKey)) {
                    $data = (object) [
                        'zsoid' => $zohoUser['zsoid'],
                        'webinarKey' => $zoho_webinar->session->meetingKey,
                        'accessToken' => $accessToken,
                    ];
                    $zohoWebinar = $zohoService->deleteWebinar($data);
                }
            }
        }

        if ($Webinar->WebinarDetail()->delete() && $Webinar->delete()) {
            return $this->apiSuccessResponse(new WebinarResource($Webinar), 'The selected item has been deleted successfully');
        }
        return $this->errorResponse();
    }
    public function synchWebinars()
    {
        $zohoService = new ZohoService();
        $zohoService->sycnhSingleWebinar();
        sleep(1);
        return $this->successResponse('', 'Webinars has been synchronized successfully.');
    }
    protected function loadRelations($webinars)
    {
        $defaultLang = getDefaultLanguage();
        $webinars = $webinars->with([
            'WebinarDetail' => function ($q) use ($defaultLang) {
                $q->where('language_code', $defaultLang->id);
            },
        ]);
        if (isset($_GET['withWebinarDetail']) && $_GET['withWebinarDetail'] == '1') {
            $webinars = $webinars->with('WebinarDetail');
        }
        return $webinars;
    }

    protected function sortingAndLimit($webinars)
    {
        $sortType = ['ASC', 'asc', 'DESC', 'desc'];
        $sortBy = ['id'];
        if (isset($_GET['sortBy']) && $_GET['sortBy'] != '' && isset($_GET['sortType']) && $_GET['sortType'] != '' && in_array($_GET['sortBy'], $sortBy) && in_array($_GET['sortType'], $sortType)) {
            $webinars = $webinars->OrderBy($_GET['sortBy'], $_GET['sortType']);
        } else {
            $webinars = $webinars->OrderBy('id', 'desc');
        }

        if (isset($_GET['limit']) && $_GET['limit'] != '') {
            $limit = $_GET['limit'];
        } else {
            $limit = 10;
        }

        return $webinars->paginate($limit);
    }

    protected function whereClause($webinars)
    {
        if (isset($_GET['searchParam']) && $_GET['searchParam'] != '') {
            $webinars = $webinars->whereHas('WebinarDetail', function ($q) {
                $q->where('agenda', 'LIKE', '%' . $_GET['searchParam'] . '%');
            });
        }
        return $webinars;
    }
}
