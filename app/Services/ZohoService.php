<?php

namespace App\Services;

use App\Http\Middleware\AmbassadorAuth;
use App\Models\Customer;
use App\Models\CustomerPaymentMethod;
use App\Models\RegistrationPackage;
use App\Models\SchoolAmbassador;
use App\Models\Webinar;
use DateTime;
use Exception;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;

class ZohoService
{
    public function refreshToken()
    {
        $accessToken = '';
        $tokenUrl = 'https://accounts.zoho.com/oauth/v2/token';
        $clientId = auth()
            ->guard('school_ambassadors')
            ->user()->zoho_client_id;
        $clientSecret = auth()
            ->guard('school_ambassadors')
            ->user()->zoho_client_secret;
        $redirectUri = env('APP_URL') . '/zoho/integration';
        $postData = [
            'refresh_token' => Auth::guard('school_ambassadors')->user()->zoho_refresh_token,
            'client_id' => $clientId,
            'client_secret' => $clientSecret,
            'redirect_uri' => $redirectUri,
            'grant_type' => 'refresh_token',
        ];
        $client = new Client();
        $response = $client->post($tokenUrl, [
            'form_params' => $postData,
        ]);
        if ($response->getStatusCode() === 200) {
            $responseData = json_decode($response->getBody(), true);
            $accessToken = isset($responseData['access_token']) ? $responseData['access_token'] : '';
        }
        return $accessToken;
    }

    public function exitingRefreshToken($refreshToke,$clientId,$clientSecret)
    {
        $accessToken = '';
        $tokenUrl = 'https://accounts.zoho.com/oauth/v2/token';
        $redirectUri = env('APP_URL') . '/zoho/integration';
        $postData = [
            'refresh_token' => $refreshToke,
            'client_id' => $clientId,
            'client_secret' => $clientSecret,
            'redirect_uri' => $redirectUri,
            'grant_type' => 'refresh_token',
        ];
        $client = new Client();
        $response = $client->post($tokenUrl, [
            'form_params' => $postData,
        ]);
        if ($response->getStatusCode() === 200) {
            $responseData = json_decode($response->getBody(), true);
            $accessToken = isset($responseData['access_token']) ? $responseData['access_token'] : '';
        }
        return $accessToken;
    }

    public function sycnhSingleWebinar()
    {
        if (!empty(Auth::guard('school_ambassadors')->user()->zoho_refresh_token)) {
            $amb = Auth::guard('school_ambassadors')->user();
            $accessToken = $this->exitingRefreshToken($amb->zoho_refresh_token,$amb->zoho_client_id,$amb->zoho_client_secret);
            $user = $this->fetchUser($accessToken);
            if (isset($user['zsoid']) && !empty($user['zsoid']) && !empty($accessToken)) {
                $webinars = Webinar::where('ambassador_id', Auth::guard('school_ambassadors')->user()->id)->get();
                foreach ($webinars as $webinar) {
                    if (!empty($webinar->zoho_webinar) && json_decode($webinar->zoho_webinar) != '') {
                        $zoho_webinar = json_decode($webinar->zoho_webinar);
                        if (isset($zoho_webinar->session->meetingKey)) {
                            // echo 'webinarKey ' . $zoho_webinar->session->meetingKey . '  user_id ' . $user['zsoid'] . '<br /><br />';
                            // echo '<br /><br /><br />';
                            if (isset($zoho_webinar->session->meetingKey)) {
                                $webinarKey = $zoho_webinar->session->meetingKey;
                                $zsoid = $user['zsoid'];
                                $url = "https://meeting.zoho.com/api/v2/{$zsoid}/webinar/{$webinarKey}.json";

                                $headers = [
                                    'Content-Type' => 'application/json;charset=UTF-8',
                                    'Authorization' => 'Zoho-oauthtoken ' . $accessToken,
                                ];
                                try {
                                    $client = new Client();
                                    $response = $client->get($url, [
                                        'headers' => $headers,
                                    ]);

                                    // You can access the response status code and body
                                    if ($response->getStatusCode() == 200) {
                                        $data = $response->getBody()->getContents();
                                        $data = json_decode($data);
                                        Webinar::where('id', $webinar->id)->update([
                                            'zoho_webinar' => json_encode($data),
                                        ]);
                                    }
                                } catch (Exception $e) {
                                    Webinar::where('id', $webinar->id)->delete();
                                    // echo $e->getMessage();
                                }
                            }
                        }
                    }
                }
            }
        }
    }

    public function sycnhAllWebinars()
    {
        $SchoolAmbassador = SchoolAmbassador::all();
        foreach ($SchoolAmbassador as $amb) {
            if (!empty($amb->zoho_refresh_token)) {
                $accessToken = $this->exitingRefreshToken($amb->zoho_refresh_token,$amb->zoho_client_id,$amb->zoho_client_secret);
                $user = $this->fetchUser($accessToken);
                if (isset($user['zsoid']) && !empty($user['zsoid']) && !empty($accessToken)) {
                    $webinars = Webinar::where('ambassador_id', $amb->id)->get();
                    foreach ($webinars as $webinar) {
                        if (!empty($webinar->zoho_webinar) && json_decode($webinar->zoho_webinar) != '') {
                            $zoho_webinar = json_decode($webinar->zoho_webinar);
                            if (isset($zoho_webinar->session->meetingKey)) {
                                // echo 'webinarKey ' . $zoho_webinar->session->meetingKey . '  user_id ' . $user['zsoid'] . '<br /><br />';
                                // echo '<br /><br /><br />';
                                if (isset($zoho_webinar->session->meetingKey)) {
                                    $webinarKey = $zoho_webinar->session->meetingKey;
                                    $zsoid = $user['zsoid'];
                                    $url = "https://meeting.zoho.com/api/v2/{$zsoid}/webinar/{$webinarKey}.json";

                                    $headers = [
                                        'Content-Type' => 'application/json;charset=UTF-8',
                                        'Authorization' => 'Zoho-oauthtoken ' . $accessToken,
                                    ];
                                    try {
                                        $client = new Client();
                                        $response = $client->get($url, [
                                            'headers' => $headers,
                                        ]);

                                        // You can access the response status code and body
                                        if ($response->getStatusCode() == 200) {
                                            $data = $response->getBody()->getContents();
                                            $data = json_decode($data);
                                            Webinar::where('id', $webinar->id)->update([
                                                'zoho_webinar' => json_encode($data),
                                            ]);
                                        }
                                    } catch (Exception $e) {
                                        Webinar::where('id', $webinar->id)->delete();
                                        // echo $e->getMessage();
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
    public function fetchUser($accessToken)
    {
        $zsoid = '';
        $zuid = '';
        $url = 'https://meeting.zoho.com/api/v2/user.json';
        $headers = [
            'Authorization' => 'Zoho-oauthtoken ' . $accessToken,
        ];
        $response = Http::withHeaders($headers)->get($url);
        if ($response->successful()) {
            $responseData = $response->json();
            $zsoid = $responseData['userDetails']['zsoid'];
            $zuid = $responseData['userDetails']['zuid'];
        }
        return ['zsoid' => $zsoid, 'zuid' => $zuid];
    }
    public function createWebinar($data)
    {
        try {
            // Define the URL with placeholders
            $url = 'https://meeting.zoho.com/api/v2/{zsoid}/webinar.json';

            // Prepare the payload
            $payload = [
                'session' => [
                    'topic' => $data->topic,
                    'agenda' => $data->agenda,
                    'presenter' => $data->zuid,
                    'startTime' => $data->start_date,
                    'duration' => $data->duration,
                    'timezone' => 'Asia/Calcutta',
                    'participants' => [
                        [
                            'email' => 'adeelbajwa786@email.com',
                        ],
                    ],
                ],
            ];

            // Prepare headers with the access token
            $headers = [
                'Content-Type' => 'application/json;charset=UTF-8',
                'Authorization' => 'Zoho-oauthtoken ' . $data->accessToken,
            ];

            // Replace the {zsoid} placeholder with the actual value
            $url = str_replace('{zsoid}', $data->zsoid, $url);

            // Make the API request
            $response = Http::withHeaders($headers)->post($url, $payload);

            if ($response->successful()) {
                return $response->json();
            } else {
                // Handle API errors here
                $errorMessage = $response->json('message') ?? 'An error occurred while making the API request.';
                return response()->json(['error' => $errorMessage], $response->status());
            }
        } catch (\Exception $e) {
            // Handle exceptions here
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function updateWebinar($data)
    {
        // $zsoid, $zuid, $accessToken
        $url = 'https://meeting.zoho.com/api/v2/' . $data->zsoid . '/webinar/' . $data->webinarKey . '.json';
        $payload = [
            'session' => [
                'topic' => $data->topic,
                'agenda' => $data->agenda,
                'presenter' => $data->zuid,
                'startTime' => $data->start_date,
                'duration' => $data->duration,
                'timezone' => 'Asia/Calcutta',
                'participants' => [
                    [
                        'email' => 'adeelbajwa786@email.com',
                    ],
                ],
            ],
        ];
        $headers = [
            'Content-Type' => 'application/json;charset=UTF-8',
            'Authorization' => 'Zoho-oauthtoken ' . $data->accessToken,
        ];
        $response = Http::withHeaders($headers)->PUT($url, $payload);
        if ($response->successful()) {
            return $response->json();
        } else {
            return $response->getBody();
        }
    }

    public function deleteWebinar($data)
    {
        $client = new Client();
        $zsoid = $data->zsoid;
        $webinarKey = $data->webinarKey;
        $url = "https://meeting.zoho.com/api/v2/{$zsoid}/webinar/{$webinarKey}.json";

        $headers = [
            'Content-Type' => 'application/json;charset=UTF-8',
            'Authorization' => 'Zoho-oauthtoken ' . $data->accessToken,
        ];

        $response = $client->delete($url, [
            'headers' => $headers,
        ]);

        // You can access the response status code and body
        $status = $response->getStatusCode();
        $body = $response->getBody()->getContents();
        return ['status' => $status, 'body' => $body];
    }
}
