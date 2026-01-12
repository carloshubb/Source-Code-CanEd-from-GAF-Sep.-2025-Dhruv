<?php

namespace App\Http\Controllers\Api\Web;
use App\Events\MyEvent;
use App\Http\Controllers\Controller;
use App\Http\Resources\Web\MessageResource;
use App\Jobs\ChatEmailJob;
use App\Models\Conversation;
use App\Models\Message;
use App\Traits\StatusResponser;
use App\Traits\FileUploadTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
class MessageController extends Controller
{
    use StatusResponser;
    use FileUploadTrait;

    public function index(Request $request)
    {
        if (isset($request->customer_id) && !empty($request->customer_id)) {
            $conversation = Conversation::whereCustomerId($request->customer_id)
                ->whereSchoolAmbassadorId($request->ambassador_id)
                ->first();
        } else {
            $conversation = Conversation::whereCustomerId(Auth::guard('customers')->user()->id)
                ->whereSchoolAmbassadorId($request->ambassador_id)
                ->first();
        }

        if ($conversation && $conversation->exists()) {
            $messages = Message::with('conversation')
                ->whereConversationId($conversation->id)
                ->get();
               $messageIds =  $messages->pluck('id');
               $messageType = isset($request->customer_id) && !empty($request->customer_id) ? 'customer' : 'ambassador';
               Message::whereIn('id',$messageIds)->where('message_by',$messageType)->update([ 'seen' => 1]);
            return $this->apiSuccessResponse(MessageResource::collection($messages), 'Data Get Successfully!');
        }
        return $this->errorResponse();
    }
    public function store(Request $request)
    {
        $diffInMinutes = 0;
        if (isset($request->customer_id) && !empty($request->customer_id)) {
            $conversation = Conversation::whereCustomerId($request->customer_id)
                ->with('customer', 'school_ambassador', 'school_ambassador.schoolAmbassadorDetail')
                ->whereSchoolAmbassadorId($request->ambassador_id)
                ->first();
        } else {
            $conversation = Conversation::whereCustomerId(Auth::guard('customers')->user()->id)
                ->with('customer', 'school_ambassador', 'school_ambassador.schoolAmbassadorDetail')
                ->whereSchoolAmbassadorId($request->ambassador_id)
                ->first();
        }
        if (isset($conversation->id)) {
            $messageTime = Message::where('conversation_id', $conversation->id)
                ->orderBy('id', 'desc')
                ->limit(1)
                ->first();
            $timestamp = $messageTime->created_at;
            $currentTime = Carbon::now();
            $diffInMinutes = $timestamp->diffInMinutes($currentTime);
        }

        $messageToSend = $request->message;
        if (isset($request->app) && $request->app == 'zoom') {
            if (!empty($this->createMeeting())) {
                $messageToSend .= ' Your zoom meeting link is as follow ' . $this->createMeeting();
            }
        }

        if ($conversation && $conversation->exists()) {
            $message = Message::create([
                'conversation_id' => $conversation->id,
                'message_by' => $request->type,
                'content' => $messageToSend,
            ]);
            event(new MyEvent($message));
            if ($diffInMinutes == 0 || $diffInMinutes > 60) {
                $this->sendMessageEmail($request, $message, $conversation);
            } else {
                if (isset($request->app) && !empty($request->app)) {
                    $this->sendMessageEmail($request, $message, $conversation);
                }
            }
            $newMessage = Message::with('conversation')
            ->where('id',$message->id)
            ->first();

            return $this->apiSuccessResponse(new MessageResource($newMessage), 'message has been added successfully.');
        } else {
            $conversation = Conversation::create([
                'customer_id' => Auth::guard('customers')->user()->id,
                'school_ambassador_id' => $request->ambassador_id,
            ]);
            if ($conversation) {
                $message = Message::create([
                    'conversation_id' => $conversation->id,
                    'message_by' => $request->type,
                    'content' => $messageToSend,
                ]);
                event(new MyEvent($message));
                if ($diffInMinutes == 0 || $diffInMinutes > 60) {
                    $this->sendMessageEmail($request, $message, $conversation);
                } else {
                    if (isset($request->app) && !empty($request->app)) {
                        $this->sendMessageEmail($request, $message, $conversation);
                    }
                }
                return $this->apiSuccessResponse(new MessageResource($message), 'Your changes have been done successfully');
            }
        }

        return $this->errorResponse();
    }

    public function createMeeting()
    {
        $zoomClientId = config('services.zoom.client_id');
        $zoomClientSecret = config('services.zoom.client_secret');
        $account_id = config('services.zoom.account_id');
        $encodedString = base64_encode($zoomClientId . ':' . $zoomClientSecret);
        $response = Http::withHeaders([
            'Authorization' => 'Basic ' . $encodedString,
            'Content-Type' => 'application/x-www-form-urlencode',
        ])
            ->asForm()
            ->post('https://zoom.us/oauth/token', [
                'grant_type' => 'account_credentials',
                'account_id' => $account_id,
            ]);

        $tokenData = $response->json();
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $tokenData['access_token'],
            'Content-Type' => 'application/json',
        ])->post('https://api.zoom.us/v2/users/me/meetings', [
            'topic' => 'Example Meeting',
            'type' => 2, // Scheduled meeting
            'start_time' => '2023-07-05T09:00:00',
            'duration' => 60,
            'timezone' => 'America/New_York',
            'password' => '123456',
        ]);
        if ($response->failed()) {
            return response()->json(['error' => 'Failed to create meeting'], 500);
        }

        $meetingData = $response->json();

        // Return the created meeting data
        return isset($meetingData['join_url']) ? $meetingData['join_url'] : '';
    }

    public function sendMessageEmail($request, $message, $conversation)
    {
        $message = Message::with('conversation')->find($message->id);
        $email = $request->type == 'ambassador' ? $conversation->customer->email : $conversation->school_ambassador->email;
        $nameTo = $request->type == 'ambassador' ? $conversation->customer->first_name : $conversation->school_ambassador->schoolAmbassadorDetail[0]->name;
        $nameFrom = $request->type == 'ambassador' ? $conversation->school_ambassador->schoolAmbassadorDetail[0]->name : $conversation->customer->first_name;
        $emailData = ['email' => $email, 'name_to' => $nameTo, 'name_from' => $nameFrom, 'type' => $request->type, 'message' => $request->message];
        dispatch(new ChatEmailJob($emailData));
    }
}
