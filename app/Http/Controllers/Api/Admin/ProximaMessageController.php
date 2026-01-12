<?php

namespace App\Http\Controllers\Api\Admin;
use App\Events\MyEvent;
use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\ProximaMessageResource;
use App\Jobs\ChatEmailJob;
use App\Models\ProximaConversation;
use App\Models\ProximaMessage;
use App\Traits\StatusResponser;
use App\Traits\FileUploadTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class ProximaMessageController extends Controller
{
    use StatusResponser;
    use FileUploadTrait;

    public function index(Request $request)
    {
        $conversation = ProximaConversation::whereCustomerId($request->customer_id)
            ->whereAdminId(1)
            ->first();
        if ($conversation && $conversation->exists()) {
            $messages = ProximaMessage::with('conversation')
                ->whereConversationId($conversation->id)
                ->get();
            $messageIds = $messages->pluck('id');
            $messageType = isset($request->customer_id) && !empty($request->customer_id) ? 'customer' : 'admin';
            ProximaMessage::whereIn('id', $messageIds)
                ->where('message_by', $messageType)
                ->update(['seen' => 1]);
            return $this->apiSuccessResponse(ProximaMessageResource::collection($messages), 'Data Get Successfully!');
        }
        return $this->errorResponse();
    }
    public function store(Request $request)
    {
        $diffInMinutes = 0;
        $conversation = ProximaConversation::whereCustomerId($request->customer_id)
            ->with('customer', 'admin')
            ->whereAdminId(1)
            ->first();

        if (isset($conversation->id)) {
            $messageTime = ProximaMessage::where('conversation_id', $conversation->id)
                ->orderBy('id', 'desc')
                ->limit(1)
                ->first();
            $timestamp = $messageTime->created_at;
            $currentTime = Carbon::now();
            $diffInMinutes = $timestamp->diffInMinutes($currentTime);
        }

        $messageToSend = $request->message;

        if ($conversation && $conversation->exists()) {
            $message = ProximaMessage::create([
                'conversation_id' => $conversation->id,
                'message_by' => $request->type,
                'content' => $messageToSend,
            ]);
            event(new MyEvent($message));
            if ($diffInMinutes == 0 || $diffInMinutes > 60) {
                $this->sendProximaMessageEmail($request, $message, $conversation);
            }
            $newProximaMessage = ProximaMessage::with('conversation')
                ->where('id', $message->id)
                ->first();

            return $this->apiSuccessResponse(new ProximaMessageResource($newProximaMessage), 'message has been added successfully.');
        } else {
            $conversation = ProximaConversation::create([
                'admin_id' => 1,
                'customer_id' => $request->customer_id,
            ]);
            if ($conversation) {
                $message = ProximaMessage::create([
                    'conversation_id' => $conversation->id,
                    'message_by' => $request->type,
                    'content' => $messageToSend,
                ]);
                event(new MyEvent($message));
                if ($diffInMinutes == 0 || $diffInMinutes > 60) {
                    $this->sendProximaMessageEmail($request, $message, $conversation);
                } else {
                    if (isset($request->app) && !empty($request->app)) {
                        $this->sendProximaMessageEmail($request, $message, $conversation);
                    }
                }
                return $this->apiSuccessResponse(new ProximaMessageResource($message), 'Your changes have been done successfully');
            }
        }
        return $this->errorResponse();
    }

    public function sendProximaMessageEmail($request, $message, $conversation)
    {
        $message = ProximaMessage::with('conversation')->find($message->id);
        $email = $request->type == 'admin' ? $conversation->customer->email : $conversation->admin->email;
        $nameTo = $request->type == 'admin' ? $conversation->customer->first_name : $conversation->admin->name;
        $nameFrom = $request->type == 'admin' ? $conversation->admin->name : $conversation->customer->first_name;
        $emailData = ['email' => $email, 'name_to' => $nameTo, 'name_from' => $nameFrom, 'type' => $request->type, 'message' => $request->message];
        dispatch(new ChatEmailJob($emailData));
    }
}
