<?php
namespace App\Services;
use App\Models\Customer;
use App\Models\SchoolAmbassador;
use DateTime;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Client;
class LiveStromService
{
    public function createLiveStromEvent($data)
    {
        // Replace with your Livestorm API token
        $livestormToken = env('LIVE_STORM_TOKEN');
        // Event data (adjust as needed)
        $eventData = [
            'data' => [
                'type' => 'events',
                'attributes' => [
                    'owner_id' => '2949dc9e-e075-4029-87a4-f72a52b6d49c',
                    'title' => $data['title'],
                    'copy_from_event_id' => '',
                    'status' => 'published',
                    'slug' => $data['slug'],
                    'detailed_registration_page_enabled' => $data['detailed_registration_page_enabled'] == 1 ? true : false,
                    'light_registration_page_enabled' => $data['light_registration_page_enabled'] == 1 ? true : false,
                    'description' => $data['description'],
                    'show_in_company_page' => false,
                    'everyone_can_speak' => $data['everyone_can_speak'] == 1 ? true : false,
                    'recording_enabled' => $data['recording_enabled'] == 1 ? true : false,
                    'recording_public' => $data['recording_enabled'] == 1 ? true : false,
                    'chat_enabled' => $data['chat_enabled'] == 1 ? true : false,
                    'questions_enabled' => $data['questions_enabled'] == 1 ? true : false,
                    'polls_enabled' => $data['polls_enabled'] == 1 ? true : false,
                ],
                'relationships' => [
                    'sessions' => [
                        [
                            'type' => 'sessions',
                            'attributes' => [
                                'estimated_started_at' => $data['start_date'],
                                'timezone' => $data['timezone'],
                            ],
                        ],
                    ],
                ],
            ],
        ];
        try {
            // Create a Guzzle HTTP client
            $client = new Client(['verify' => false]);
            // Make a POST request to create the event
            $response = $client->post('https://api.livestorm.co/v1/events', [
                'headers' => [
                    'Authorization' => $livestormToken,
                    'Content-Type' => 'application/json',
                ],
                'json' => $eventData,
            ]);
            // Handle the response (e.g., log or return success message)
            $responseData = json_decode($response->getBody(), true);
            if (isset($responseData)) {
                return $responseData;
            } else {
                return null;
            }
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            $errorEntity = 'server error';
            $response = $e->getResponse();
            $responseBodyAsString = $response->getBody()->getContents();
            $errorJson = json_decode($responseBodyAsString, true);
            if (isset($errorJson['errors'][0]['detail'])) {
                $errorEntity = $errorJson['errors'][0]['detail'];
            }
            return $errorEntity;
        }
    }
    public function deleteLiveStromEvent($event)
    {
        $livestormToken = env('LIVE_STORM_TOKEN');
        $client = new Client(['verify' => false]);
        $response = $client->delete('https://api.livestorm.co/v1/events/' . $event, [
            'headers' => [
                'Authorization' => $livestormToken,
                'Content-Type' => 'application/json',
            ],
        ]);
        $responseData = json_decode($response->getBody(), true);
    }
    public function createLiveStromUser($email)
    {
        // Replace with your Livestorm API token
        $livestormToken = env('LIVE_STORM_TOKEN');
        // Event data (adjust as needed)
        $eventData = [
            'data' => [
                'type' => 'users',
                'attributes' => [
                    'email' => Auth::guard('school_ambassadors')->user()->email,
                    'role' => 'moderator',
                ],
            ],
        ];
        try {
            // Create a Guzzle HTTP client
            $client = new Client(['verify' => false]);
            // Make a POST request to create the event
            $response = $client->post('https://api.livestorm.co/v1/users', [
                'headers' => [
                    'Authorization' => $livestormToken,
                    'Content-Type' => 'application/json',
                ],
                'json' => $eventData,
            ]);
            // Handle the response (e.g., log or return success message)
            $responseData = json_decode($response->getBody(), true);
            if (isset($responseData['data']['id'])) {
                SchoolAmbassador::where('id', Auth::guard('school_ambassadors')->user()->id)->update([
                    'live_strom_user_id' => $responseData['data']['id'],
                ]);
                return ['status' => 'success', 'message' => 'user created successfully'];
            } else {
                return ['status' => 'success', 'message' => 'user not found'];
            }
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            $errorEntity = 'server error';
            $response = $e->getResponse();
            $responseBodyAsString = $response->getBody()->getContents();
            $errorJson = json_decode($responseBodyAsString, true);
            if (isset($errorJson['errors'][0]['detail'])) {
                $errorEntity = $errorJson['errors'][0]['detail'];
            }
            return ['status' => 'error', 'message' => $errorEntity];
        }
    }
}
