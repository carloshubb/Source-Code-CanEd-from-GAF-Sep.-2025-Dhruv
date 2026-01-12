<?php

namespace App\Http\Controllers\Api\Web;

use App\Http\Controllers\Controller;
use App\Models\Conversation;
use App\Models\Customer;
use App\Models\SchoolAmbassador;
use App\Models\Webinar;
use App\Services\LiveStromService;
use Illuminate\Http\Request;

class AmbassadorController extends Controller
{
    public function index()
    {
        $conversations = Conversation::with('customer_last_messages')
            ->with('customer', 'school_ambassador', 'unAmbassadorSeenmessages', 'school_ambassador.schoolAmbassadorDetail', 'school_ambassador.school')
            ->where('school_ambassador_id', \Auth::guard('school_ambassadors')->user()->id)
            ->get();    
        $school = \Auth::guard('school_ambassadors')->user()->school->id;
        $school_slug = isset(\Auth::guard('school_ambassadors')->user()->school->schoolDetail[0]->school_name) ? \Auth::guard('school_ambassadors')->user()->school->schoolDetail[0]->school_name : '';
        $school_slug = createSlug($school_slug);
        return view('front.ambassador-chat.index', compact('conversations', 'school', 'school_slug'));
    }

    public function StudentChat($lang,$customer_id)
    {
        // dd($customer_id);
        $school = \Auth::guard('school_ambassadors')->user()->school->id;
        // dd($school);
        // dd(\Auth::guard('school_ambassadors')->user());

        $school_slug = isset(\Auth::guard('school_ambassadors')->user()->school->schoolDetail[0]->school_name) ? \Auth::guard('school_ambassadors')->user()->school->schoolDetail[0]->school_name : '';
        $school_slug = createSlug($school_slug);
        $ambassador = \Auth::guard('school_ambassadors')->user()->id;
        $ambassadorObject = SchoolAmbassador::with('schoolAmbassadorDetail')
            ->whereId($ambassador)
            ->first();
        $customerObject = Customer::whereId($customer_id)->first();
        // dd($customerObject);
        return view('front.ambassador-chat.student-chat', compact('customer_id', 'school', 'school_slug', 'ambassadorObject', 'ambassador', 'customerObject'));
    }
    public function webinar()
    {
        $ambassador = auth()
            ->guard('school_ambassadors')
            ->user();
        $webinars = Webinar::where('school_ambassador_id', $ambassador->id)->paginate(5);
        $school = \Auth::guard('school_ambassadors')->user()->school->id;
        $school_slug = isset(\Auth::guard('school_ambassadors')->user()->school->schoolDetail[0]->school_name) ? \Auth::guard('school_ambassadors')->user()->school->schoolDetail[0]->school_name : '';
        $school_slug = createSlug($school_slug);
        return view('front.account.webinar.index', compact('webinars', 'school', 'school_slug'));
    }

    public function webinarCreate()
    {
        $ambassador = \Auth::guard('school_ambassadors')->user()->id;
        $clientid = \Auth::guard('school_ambassadors')->user()->zoho_client_id;
        $school = \Auth::guard('school_ambassadors')->user()->school->id;
        $school_slug = isset(\Auth::guard('school_ambassadors')->user()->school->schoolDetail[0]->school_name) ? \Auth::guard('school_ambassadors')->user()->school->schoolDetail[0]->school_name : '';
        $school_slug = createSlug($school_slug);
        return view('front.account.webinar.create', compact('ambassador', 'clientid', 'school', 'school_slug'));
    }

    public function webinarEdit($lang, $webinar)
    {
        $ambassador = \Auth::guard('school_ambassadors')->user()->id;
        $clientid = \Auth::guard('school_ambassadors')->user()->zoho_client_id;
        $school = \Auth::guard('school_ambassadors')->user()->school->id;
        $school_slug = isset(\Auth::guard('school_ambassadors')->user()->school->schoolDetail[0]->school_name) ? \Auth::guard('school_ambassadors')->user()->school->schoolDetail[0]->school_name : '';
        $school_slug = createSlug($school_slug);
        return view('front.account.webinar.edit', compact('webinar', 'ambassador', 'clientid', 'school', 'school_slug'));
    }
    public function webinarSetting()
    {
        $school = \Auth::guard('school_ambassadors')->user()->school->id;
        $ambassador = \Auth::guard('school_ambassadors')->user()->id;
        $client_id = \Auth::guard('school_ambassadors')->user()->zoho_client_id;
        $client_secret = \Auth::guard('school_ambassadors')->user()->zoho_client_secret;
        $redirectUrl = env('APP_URL') . '/zoho/integration';
        $homeUrl = env('APP_URL');
        $school_slug = isset(\Auth::guard('school_ambassadors')->user()->school->schoolDetail[0]->school_name) ? \Auth::guard('school_ambassadors')->user()->school->schoolDetail[0]->school_name : '';
        $school_slug = createSlug($school_slug);
        return view('front.ambassador-chat.webinar-setting', compact('homeUrl', 'redirectUrl', 'school_slug', 'school', 'ambassador', 'client_id', 'client_secret'));
    }

    public function updateLiveStromToken(Request $request)
    {
        $ambassador = \Auth::guard('school_ambassadors')->user();
        $ambassador->update(['live_strom_token' => $request->token]);
        // if (empty($ambassador->live_strom_user_id)) {
        //     $liveStromService = new LiveStromService();
        //     // $liveStromService->createLiveStromUser($ambassador->email);
        //     return redirect()
        //         ->back()
        //         ->with('success', 'Your token is saved successfully! please make sure you recieve an email from livestrom accept the invitaion other wise you won"t be able to create webinars');
        // }
        return redirect()
            ->back()
            ->with('success', 'Your token is saved successfully!');
    }
}
