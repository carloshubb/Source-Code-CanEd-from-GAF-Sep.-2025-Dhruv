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
use App\Services\LiveStromService;
use App\Traits\StatusResponser;
use App\Traits\FileUploadTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WebinarController extends Controller
{
    use StatusResponser;
    use FileUploadTrait;

    public function index()
    {
        $ambassador = auth()
            ->guard('school_ambassadors')
            ->user();
        $webinars = Webinar::where('school_ambassador_id', $ambassador->id);
        $webinars = $this->whereClause($webinars);
        $webinars = $this->loadRelations($webinars);
        $webinars = $this->sortingAndLimit($webinars);

        return $this->apiSuccessResponse(WebinarResource::collection($webinars), 'Data Get Successfully!');
    }

    public function show(Webinar $Webinar)
    {
        return $this->apiSuccessResponse(new WebinarResource($Webinar), 'Data Get Successfully!');
    }

    public function store(Request $request)
    {
        ini_set('max_execution_time', 1200);
        $validationRule = [];
        $errorMessages = [];
        $validationRule = array_merge($validationRule, ['title' => ['required', 'string']]);
        $errorMessages = array_merge($errorMessages, ['title' . '.required' => 'Title is required']);
        $validationRule = array_merge($validationRule, ['description' => ['required', 'string']]);
        $errorMessages = array_merge($errorMessages, ['description' . '.required' => 'Description is required']);
        $validationRule = array_merge($validationRule, ['start_date' => ['required', 'string']]);
        $errorMessages = array_merge($errorMessages, ['start_date' . '.required' => 'Start date is required']);
        $validationRule = array_merge($validationRule, ['timezone' => ['required', 'string']]);
        $errorMessages = array_merge($errorMessages, ['timezone' . '.required' => 'TimeZone is required']);
        $validationRule = array_merge($validationRule, ['image' => ['required', 'string']]);
        $errorMessages = array_merge($errorMessages, ['image' . '.required' => 'Image is required.']);
        $validationRule = array_merge($validationRule, ['everyone_can_speak' => ['required', 'string']]);
        $errorMessages = array_merge($errorMessages, ['everyone_can_speak' . '.required' => 'Everyone can speak field is required']);
        $validationRule = array_merge($validationRule, ['detailed_registration_page_enabled' => ['required', 'string']]);
        $errorMessages = array_merge($errorMessages, ['detailed_registration_page_enabled' . '.required' => 'Enable registration page field is required.']);
        $validationRule = array_merge($validationRule, ['light_registration_page_enabled' => ['required', 'string']]);
        $errorMessages = array_merge($errorMessages, ['light_registration_page_enabled' . '.required' => 'Light registration page field is required']);
        $validationRule = array_merge($validationRule, ['recording_enabled' => ['required', 'string']]);
        $errorMessages = array_merge($errorMessages, ['recording_enabled' . '.required' => 'Recording enabled is required.']);
        $validationRule = array_merge($validationRule, ['chat_enabled' => ['required', 'string']]);
        $errorMessages = array_merge($errorMessages, ['chat_enabled' . '.required' => 'Chat enabled is required.']);
        $validationRule = array_merge($validationRule, ['questions_enabled' => ['required', 'string']]);
        $errorMessages = array_merge($errorMessages, ['questions_enabled' . '.required' => 'Questions enabled is required.']);
        $validationRule = array_merge($validationRule, ['polls_enabled' => ['required', 'string']]);
        $errorMessages = array_merge($errorMessages, ['polls_enabled' . '.required' => 'Polls enabled is required.']);

        $this->validate($request, $validationRule, $errorMessages);
        $ambassador = auth()
            ->guard('school_ambassadors')
            ->user();
        if (isset($ambassador->customer_id)) {
            $customer = Customer::where('id', $ambassador->customer_id)->first();
            if ($customer->user_type == 'school') {
                $count = Webinar::where('school_ambassador_id', $ambassador->id)->count();
                if ($customer->registrationPackage->webinars <= $count) {
                    return $this->errorResponse('Form submission limit exceeded. Please try again later.');
                }
            }
        }

        $carbonDateTime = Carbon::parse($request->start_date);
        $formattedDateTime = $carbonDateTime->format('M d, Y h:i A');

        $liveStromeService = new LiveStromService();
        $dataToSend = [
            'title' => $request->title,
            'description' => '<p>' . $request->description . '</p>',
            'start_date' => $formattedDateTime,
            'timezone' => $request->timezone,
            'everyone_can_speak' => $request->everyone_can_speak,
            'detailed_registration_page_enabled' => $request->detailed_registration_page_enabled,
            'light_registration_page_enabled' => $request->light_registration_page_enabled,
            'recording_enabled' => $request->recording_enabled,
            'chat_enabled' => $request->chat_enabled,
            'questions_enabled' => $request->questions_enabled,
            'polls_enabled' => $request->polls_enabled,
            'ownerId' => $ambassador->live_strom_user_id,
            'slug' => Str::slug($request->title),
        ];
        // if (empty($ambassador->live_strom_user_id)) {
        //     $liveStromService = new LiveStromService();
        //     // $liveStromService->createLiveStromUser($ambassador->email);
        //     // $dataToSend['ownerId'] = SchoolAmbassador::where('id', Auth::guard('school_ambassadors')->user()->id)->value('live_strom_user_id');
        // }
        $liveStrome = $liveStromeService->createLiveStromEvent($dataToSend);
        $Webinar = Webinar::create([
            'title' => $request->title,
            'start_date' => $formattedDateTime,
            'timezone' => $request->timezone,
            'school_ambassador_id' => $ambassador->id,
            'live_strom_webinar' => json_encode($liveStrome),
            'image' => $request->image,
        ]);

        if ($Webinar) {
            return $this->apiSuccessResponse(new WebinarResource($Webinar), 'Your changes have been done successfully');
        }
        return $this->errorResponse();
    }

    public function update(Request $request, Webinar $Webinar)
    {
        ini_set('max_execution_time', 1200);
        $validationRule = [];
        $errorMessages = [];
        $validationRule = array_merge($validationRule, ['title' => ['required', 'string']]);
        $errorMessages = array_merge($errorMessages, ['title' . '.required' => 'Title is required']);
        $validationRule = array_merge($validationRule, ['description' => ['required', 'string']]);
        $errorMessages = array_merge($errorMessages, ['description' . '.required' => 'Description is required']);
        $validationRule = array_merge($validationRule, ['start_date' => ['required', 'string']]);
        $errorMessages = array_merge($errorMessages, ['start_date' . '.required' => 'Start date is required']);
        $validationRule = array_merge($validationRule, ['timezone' => ['required', 'string']]);
        $errorMessages = array_merge($errorMessages, ['timezone' . '.required' => 'TimeZone is required']);
        $validationRule = array_merge($validationRule, ['image' => ['required', 'string']]);
        $errorMessages = array_merge($errorMessages, ['image' . '.required' => 'Image is required']);
        $validationRule = array_merge($validationRule, ['everyone_can_speak' => ['required']]);
        $errorMessages = array_merge($errorMessages, ['everyone_can_speak' . '.required' => 'Everyone can speak is required']);
        $validationRule = array_merge($validationRule, ['detailed_registration_page_enabled' => ['required']]);
        $errorMessages = array_merge($errorMessages, ['detailed_registration_page_enabled' . '.required' => 'Detailed registration page enabled is required']);
        $validationRule = array_merge($validationRule, ['light_registration_page_enabled' => ['required']]);
        $errorMessages = array_merge($errorMessages, ['light_registration_page_enabled' . '.required' => 'Light registration page enabled is required']);
        $validationRule = array_merge($validationRule, ['recording_enabled' => ['required']]);
        $errorMessages = array_merge($errorMessages, ['recording_enabled' . '.required' => 'Recording enabled is required']);
        $validationRule = array_merge($validationRule, ['chat_enabled' => ['required']]);
        $errorMessages = array_merge($errorMessages, ['chat_enabled' . '.required' => 'Chat enabled is required']);
        $validationRule = array_merge($validationRule, ['questions_enabled' => ['required']]);
        $errorMessages = array_merge($errorMessages, ['questions_enabled' . '.required' => 'Questions enabled is required']);
        $validationRule = array_merge($validationRule, ['polls_enabled' => ['required']]);
        $errorMessages = array_merge($errorMessages, ['polls_enabled' . '.required' => 'Polls enabled is required']);

        $this->validate($request, $validationRule, $errorMessages);
        $ambassador = auth()
            ->guard('school_ambassadors')
            ->user();
        $carbonDateTime = Carbon::parse($request->start_date);
        $formattedDateTime = $carbonDateTime->format('M d, Y h:i A');

        $liveStromeService = new LiveStromService();

        $liveStromeWebinar = json_decode($Webinar->live_strom_webinar);
        if (isset($liveStromeWebinar->data->id)) {
            $liveStromeService = new LiveStromService();
            $liveStromeService->deleteLiveStromEvent($liveStromeWebinar->data->id);
        }
        $dataToSend = [
            'title' => $request->title,
            'description' => '<p>' . $request->description . '</p>',
            'start_date' => $formattedDateTime,
            'timezone' => $request->timezone,
            'everyone_can_speak' => $request->everyone_can_speak,
            'detailed_registration_page_enabled' => $request->detailed_registration_page_enabled,
            'light_registration_page_enabled' => $request->light_registration_page_enabled,
            'recording_enabled' => $request->recording_enabled,
            'chat_enabled' => $request->chat_enabled,
            'questions_enabled' => $request->questions_enabled,
            'polls_enabled' => $request->polls_enabled,
            'ownerId' => $ambassador->live_strom_user_id,
            'slug' => Str::slug($request->title),
        ];
        $liveStrome = $liveStromeService->createLiveStromEvent($dataToSend);

        $Webinar->update([
            'title' => $request->title,
            'start_date' => $formattedDateTime,
            'timezone' => $request->timezone,
            'school_ambassador_id' => $ambassador->id,
            'live_strom_webinar' => json_encode($liveStrome),
            'image' => $request->image,
        ]);
        if ($Webinar) {
            return $this->apiSuccessResponse(new WebinarResource($Webinar), 'Your changes have been done successfully');
        }
        return $this->errorResponse();
    }

    public function destroy(Webinar $Webinar)
    {
        $liveStromeWebinar = json_decode($Webinar->live_strom_webinar);
        if (isset($liveStromeWebinar->data->id)) {
            $liveStromeService = new LiveStromService();
            $liveStromeService->deleteLiveStromEvent($liveStromeWebinar->data->id);
        }
        if ($Webinar->delete()) {
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
