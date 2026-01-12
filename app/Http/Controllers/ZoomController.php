<?php

namespace App\Http\Controllers;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Firebase\JWT\JWT;
use Illuminate\Support\Facades\Http;
use Google\Client as GoogleClient;
use Google\Service\Calendar;
class ZoomController extends Controller
{
    //zoom meeting
    //  public function createMeeting()
    //  {
    //     $zoomClientId = config('services.zoom.client_id');
    //     $zoomClientSecret = config('services.zoom.client_secret');
    //     $account_id = config('services.zoom.account_id');
    //     $encodedString = base64_encode($zoomClientId . ':' . $zoomClientSecret);
    //     $response = Http::withHeaders([
    //         'Authorization' => 'Basic ' . $encodedString,
    //         'Content-Type' => 'application/x-www-form-urlencode',
    //     ])
    //         ->asForm()
    //         ->post('https://zoom.us/oauth/token', [
    //             'grant_type' => 'account_credentials',
    //             'account_id' => 'fHb56f-LQcCCYPaX1n28bQ',
    //         ]);

    //     $tokenData = $response->json();
    //     $response = Http::withHeaders([
    //         'Authorization' => 'Bearer ' . $tokenData['access_token'],
    //         'Content-Type' => 'application/json',
    //     ])->post('https://api.zoom.us/v2/users/me/meetings', [
    //         'topic' => 'Example Meeting',
    //         'type' => 2, // Scheduled meeting
    //         'start_time' => '2023-07-05T09:00:00',
    //         'duration' => 60,
    //         'timezone' => 'America/New_York',
    //         'password' => '123456',
    //     ]);
    //     if ($response->failed()) {
    //         return response()->json(['error' => 'Failed to create meeting'], 500);
    //     }

    //     $meetingData = $response->json();

    //     return isset($meetingData['join_url']) ? $meetingData['join_url'] : '';
    //  }

    //google meeting
    public function createMeeting()
    {
        $client = new GoogleClient();
        $client->setAuthConfig(public_path('canedu-service-account.json'));
        $client->addScope(Calendar::CALENDAR_EVENTS);
        $client->setSubject('canedu@canedu-391912.iam.gserviceaccount.com');
        // Create a new Google Calendar service instance
        $calendarService = new Calendar($client);

        // Set the calendar ID for the desired calendar
        $calendarId = 'adeelxelent@gmail.com';

        // Set the event details
        $eventSummary = 'Meeting with Google Meet';
        $eventStartTime = '2023-07-07T10:00:00Z';
        $eventEndTime = '2023-07-07T11:00:00Z';

        // Create a new event with Google Meet conference data
        $event = new \Google_Service_Calendar_Event([
            'summary' => $eventSummary,
            'start' => ['dateTime' => $eventStartTime],
            'end' => ['dateTime' => $eventEndTime],
            'conferenceData' => [
                'createRequest' => [
                     'conferenceSolutionKey' => [
                        'type' => 'hangoutsMeet',
                     ],
                    'requestId' => uniqid(),
                ],
                
            ],
            'entryPoints' => [
                [
                    'entryPointType' => 'video',
                ],
            ],
        ]);

        // Insert the event into the calendar
        $event = $calendarService->events->insert($calendarId, $event, ['conferenceDataVersion' => '1']);
        $conferenceData = $event->getConferenceData();
        // $meetLink = $conferenceData->getEntryPoints()[0]->getUri();
        dd( $conferenceData);
    }
}
