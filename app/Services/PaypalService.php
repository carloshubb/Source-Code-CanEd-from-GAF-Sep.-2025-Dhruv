<?php

namespace App\Services;

use GuzzleHttp\Client;

class PaypalService
{
    public function paypalToken()
    {
        $client = new Client();

        $response = $client->post(env('PAYPAL_BASE_URL') . '/oauth2/token', [
            'auth' => [env('PAYPAL_CLIENT_ID'), env('PAYPAL_SECRET')],
            'form_params' => [
                'grant_type' => 'client_credentials',
            ],
        ]);

        $tokenData = json_decode($response->getBody(), true);

        $accessToken = $tokenData['access_token'];
        return $accessToken;
    }

    public function createProduct($data)
    {
        $client = new Client();
        $response = $client->post(env('PAYPAL_BASE_URL') . '/catalogs/products', [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->paypalToken(),
                'Content-Type' => 'application/json',
            ],
            'json' => $data,
        ]);
        $product = json_decode($response->getBody(), true);
        return $product['id'];
    }

    public function createPlan($request, $packageName, $registrationPackage = null)
    {
        if ($request->monthly_price > 0) {
            $this->createPayPalMonthly($request, $packageName, $registrationPackage);
        } else {
            $registrationPackage->update(['paypal_auto_renew_monthly_id' => null, 'paypal_non_auto_renew_monthly_id' => null]);
        }

        if ($request->quarterly_price > 0) {
            $this->createPayPalQuarterly($request, $packageName, $registrationPackage);
        } else {
            $registrationPackage->update(['paypal_auto_renew_quarterly_id' => null, 'paypal_non_auto_renew_quarterly_id' => null]);
        }

        if ($request->semi_annually_price > 0) {
            $this->createPayPalSemiAnnually($request, $packageName, $registrationPackage);
        } else {
            $registrationPackage->update(['paypal_auto_renew_semi_annually_id' => null, 'paypal_non_auto_renew_semi_annually_id' => null]);
        }

        if ($request->annually_price > 0) {
            $this->createPayPalAnnually($request, $packageName, $registrationPackage);
        } else {
            $registrationPackage->update(['paypal_auto_renew_annually_id' => null, 'paypal_non_auto_renew_annually_id' => null]);
        }
    }

    public function createPayPalMonthly($request, $packageName, $registrationPackage = null)
    {
        if ($request->package_type == 'featured') {
            $setting = getSignleGeneralSettingByKey(['paypal_featured_product']);
            $productId = $setting['paypal_featured_product'];
        } elseif ($request->package_type == 'premium') {
            $setting = getSignleGeneralSettingByKey(['paypal_premium_product']);
            $productId = $setting['paypal_premium_product'];
        } elseif ($request->package_type == 'free') {
            $setting = getSignleGeneralSettingByKey(['paypal_free_product']);
            $productId = $setting['paypal_free_product'];
        }

        $interval_count = 1;
        $price = $request->monthly_price;

        $billing_detail = [
            [
                'frequency' => [
                    'interval_unit' => 'MONTH',
                    'interval_count' => $interval_count, // Interval count
                ],
                'tenure_type' => 'REGULAR', // Tenure type
                'sequence' => 1, // Cycle sequence number
                'total_cycles' => 0, // Total cycles
                'pricing_scheme' => [
                    'fixed_price' => [
                        'value' => $price, // Price value
                        'currency_code' => 'USD',
                    ],
                ],
            ]
        ];

        $data = [
            'product_id' => $productId, // Replace with your product ID
            'name' => $packageName . ' for 1 month ', // Plan name
            'description' => $packageName . ' for 1 month plan is auto renewal', // Plan description
            'status' => 'ACTIVE', // Plan status
            'billing_cycles' => $billing_detail,
            'payment_preferences' => [
                'auto_bill_outstanding' => true,
                'auto_renewal' => true,
                'setup_fee' => [
                    'value' => '0',
                    'currency_code' => 'USD',
                ],
                'setup_fee_failure_action' => 'CONTINUE',
                'payment_failure_threshold' => 5,
            ],
        ];
        $client = new Client();
        $response = $client->post(env('PAYPAL_BASE_URL') . '/billing/plans', [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->paypalToken(),
                'Content-Type' => 'application/json',
            ],
            'json' => $data,
        ]);

        $plan = json_decode($response->getBody(), true);


        if (isset($billing_detail[1]['total_cycles'])) {
            $billing_detail[1]['total_cycles'] = 1;
        }
        if (isset($billing_detail[0]['total_cycles'])) {
            $billing_detail[0]['total_cycles'] = 1;
        }

        $data = [
            'product_id' => $productId, // Replace with your product ID
            'name' => $packageName . ' for 1 month ', // Plan name
            'description' => $packageName . ' for 1 month plan is non auto renewal', // Plan description
            'status' => 'ACTIVE', // Plan status
            'billing_cycles' => $billing_detail,
            'payment_preferences' => [
                'auto_bill_outstanding' => false,
                'auto_renewal' => false,
                'setup_fee' => [
                    'value' => '0',
                    'currency_code' => 'USD',
                ],
                'setup_fee_failure_action' => 'CONTINUE',
                'payment_failure_threshold' => 5,
            ],
        ];
        $response = $client->post(env('PAYPAL_BASE_URL') . '/billing/plans', [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->paypalToken(),
                'Content-Type' => 'application/json',
            ],
            'json' => $data,
        ]);

        $plan_non_auto = json_decode($response->getBody(), true);
        if ($registrationPackage == null) {
            return $plan['id'];
        } else {
            $registrationPackage->update(['paypal_auto_renew_monthly_id' => $plan['id'], 'paypal_non_auto_renew_monthly_id' => $plan_non_auto['id']]);
        }
    }

    public function createPayPalQuarterly($request, $packageName, $registrationPackage = null)
    {

        if ($request->package_type == 'featured') {
            $setting = getSignleGeneralSettingByKey(['paypal_featured_product']);
            $productId = $setting['paypal_featured_product'];
        } elseif ($request->package_type == 'premium') {
            $setting = getSignleGeneralSettingByKey(['paypal_premium_product']);
            $productId = $setting['paypal_premium_product'];
        } elseif ($request->package_type == 'free') {
            $setting = getSignleGeneralSettingByKey(['paypal_free_product']);
            $productId = $setting['paypal_free_product'];
        }

        $interval_count = 3;
        $price = $request->quarterly_price * 3;

        $billing_detail = [
            [
                'frequency' => [
                    'interval_unit' => 'MONTH',
                    'interval_count' => $interval_count, // Interval count
                ],
                'tenure_type' => 'REGULAR', // Tenure type
                'sequence' => 1, // Cycle sequence number
                'total_cycles' => 0, // Total cycles
                'pricing_scheme' => [
                    'fixed_price' => [
                        'value' => $price, // Price value
                        'currency_code' => 'USD',
                    ],
                ],
            ]
        ];

        $data = [
            'product_id' => $productId, // Replace with your product ID
            'name' => $packageName . ' for quarterly ', // Plan name
            'description' => $packageName . ' for quarterly plan is auto renewal', // Plan description
            'status' => 'ACTIVE', // Plan status
            'billing_cycles' => $billing_detail,
            'payment_preferences' => [
                'auto_bill_outstanding' => true,
                'auto_renewal' => true,
                'setup_fee' => [
                    'value' => '0',
                    'currency_code' => 'USD',
                ],
                'setup_fee_failure_action' => 'CONTINUE',
                'payment_failure_threshold' => 5,
            ],
        ];
        $client = new Client();
        $response = $client->post(env('PAYPAL_BASE_URL') . '/billing/plans', [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->paypalToken(),
                'Content-Type' => 'application/json',
            ],
            'json' => $data,
        ]);

        $plan = json_decode($response->getBody(), true);


        if (isset($billing_detail[1]['total_cycles'])) {
            $billing_detail[1]['total_cycles'] = 1;
        }
        if (isset($billing_detail[0]['total_cycles'])) {
            $billing_detail[0]['total_cycles'] = 1;
        }

        $data = [
            'product_id' => $productId, // Replace with your product ID
            'name' => $packageName . ' for quarterly ', // Plan name
            'description' => $packageName . ' for quarterly plan is non auto renewal', // Plan description
            'status' => 'ACTIVE', // Plan status
            'billing_cycles' => $billing_detail,
            'payment_preferences' => [
                'auto_bill_outstanding' => false,
                'auto_renewal' => false,
                'setup_fee' => [
                    'value' => '0',
                    'currency_code' => 'USD',
                ],
                'setup_fee_failure_action' => 'CONTINUE',
                'payment_failure_threshold' => 5,
            ],
        ];
        $response = $client->post(env('PAYPAL_BASE_URL') . '/billing/plans', [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->paypalToken(),
                'Content-Type' => 'application/json',
            ],
            'json' => $data,
        ]);

        $plan_non_auto = json_decode($response->getBody(), true);
        if ($registrationPackage == null) {
            return $plan['id'];
        } else {
            $registrationPackage->update(['paypal_auto_renew_quarterly_id' => $plan['id'], 'paypal_non_auto_renew_quarterly_id' => $plan_non_auto['id']]);
        }
    }

    public function createPayPalSemiAnnually($request, $packageName, $registrationPackage = null)
    {

        if ($request->package_type == 'featured') {
            $setting = getSignleGeneralSettingByKey(['paypal_featured_product']);
            $productId = $setting['paypal_featured_product'];
        } elseif ($request->package_type == 'premium') {
            $setting = getSignleGeneralSettingByKey(['paypal_premium_product']);
            $productId = $setting['paypal_premium_product'];
        } elseif ($request->package_type == 'free') {
            $setting = getSignleGeneralSettingByKey(['paypal_free_product']);
            $productId = $setting['paypal_free_product'];
        }


        $interval_count = 6;
        $price = $request->semi_annually_price * 6;

        $billing_detail = [
            [
                'frequency' => [
                    'interval_unit' => 'MONTH',
                    'interval_count' => $interval_count, // Interval count
                ],
                'tenure_type' => 'REGULAR', // Tenure type
                'sequence' => 1, // Cycle sequence number
                'total_cycles' => 0, // Total cycles
                'pricing_scheme' => [
                    'fixed_price' => [
                        'value' => $price, // Price value
                        'currency_code' => 'USD',
                    ],
                ],
            ]
        ];

        $data = [
            'product_id' => $productId, // Replace with your product ID
            'name' => $packageName . ' for semi annually ', // Plan name
            'description' => $packageName . ' for semi annually plan is auto renewal', // Plan description
            'status' => 'ACTIVE', // Plan status
            'billing_cycles' => $billing_detail,
            'payment_preferences' => [
                'auto_bill_outstanding' => true,
                'auto_renewal' => true,
                'setup_fee' => [
                    'value' => '0',
                    'currency_code' => 'USD',
                ],
                'setup_fee_failure_action' => 'CONTINUE',
                'payment_failure_threshold' => 5,
            ],
        ];
        $client = new Client();
        $response = $client->post(env('PAYPAL_BASE_URL') . '/billing/plans', [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->paypalToken(),
                'Content-Type' => 'application/json',
            ],
            'json' => $data,
        ]);

        $plan = json_decode($response->getBody(), true);


        if (isset($billing_detail[1]['total_cycles'])) {
            $billing_detail[1]['total_cycles'] = 1;
        }
        if (isset($billing_detail[0]['total_cycles'])) {
            $billing_detail[0]['total_cycles'] = 1;
        }

        $data = [
            'product_id' => $productId, // Replace with your product ID
            'name' => $packageName . ' for semi annually ', // Plan name
            'description' => $packageName . ' for semi annually plan is non auto renewal', // Plan description
            'status' => 'ACTIVE', // Plan status
            'billing_cycles' => $billing_detail,
            'payment_preferences' => [
                'auto_bill_outstanding' => false,
                'auto_renewal' => false,
                'setup_fee' => [
                    'value' => '0',
                    'currency_code' => 'USD',
                ],
                'setup_fee_failure_action' => 'CONTINUE',
                'payment_failure_threshold' => 5,
            ],
        ];
        $response = $client->post(env('PAYPAL_BASE_URL') . '/billing/plans', [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->paypalToken(),
                'Content-Type' => 'application/json',
            ],
            'json' => $data,
        ]);

        $plan_non_auto = json_decode($response->getBody(), true);
        if ($registrationPackage == null) {
            return $plan['id'];
        } else {
            $registrationPackage->update(['paypal_auto_renew_semi_annually_id' => $plan['id'], 'paypal_non_auto_renew_semi_annually_id' => $plan_non_auto['id']]);
        }
    }

    public function createPayPalAnnually($request, $packageName, $registrationPackage = null)
    {
        if ($request->package_type == 'featured') {
            $setting = getSignleGeneralSettingByKey(['paypal_featured_product']);
            $productId = $setting['paypal_featured_product'];
        } elseif ($request->package_type == 'premium') {
            $setting = getSignleGeneralSettingByKey(['paypal_premium_product']);
            $productId = $setting['paypal_premium_product'];
        } elseif ($request->package_type == 'free') {
            $setting = getSignleGeneralSettingByKey(['paypal_free_product']);
            $productId = $setting['paypal_free_product'];
        }

        $interval_count = 12;
        $price = $request->annually_price * 12;

        $billing_detail = [
            [
                'frequency' => [
                    'interval_unit' => 'MONTH',
                    'interval_count' => $interval_count, // Interval count
                ],
                'tenure_type' => 'REGULAR', // Tenure type
                'sequence' => 1, // Cycle sequence number
                'total_cycles' => 0, // Total cycles
                'pricing_scheme' => [
                    'fixed_price' => [
                        'value' => $price, // Price value
                        'currency_code' => 'USD',
                    ],
                ],
            ]
        ];

        $data = [
            'product_id' => $productId, // Replace with your product ID
            'name' => $packageName . ' for annually ', // Plan name
            'description' => $packageName . ' for annually plan is auto renewal', // Plan description
            'status' => 'ACTIVE', // Plan status
            'billing_cycles' => $billing_detail,
            'payment_preferences' => [
                'auto_bill_outstanding' => true,
                'auto_renewal' => true,
                'setup_fee' => [
                    'value' => '0',
                    'currency_code' => 'USD',
                ],
                'setup_fee_failure_action' => 'CONTINUE',
                'payment_failure_threshold' => 5,
            ],
        ];
        $client = new Client();
        $response = $client->post(env('PAYPAL_BASE_URL') . '/billing/plans', [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->paypalToken(),
                'Content-Type' => 'application/json',
            ],
            'json' => $data,
        ]);

        $plan = json_decode($response->getBody(), true);


        if (isset($billing_detail[1]['total_cycles'])) {
            $billing_detail[1]['total_cycles'] = 1;
        }
        if (isset($billing_detail[0]['total_cycles'])) {
            $billing_detail[0]['total_cycles'] = 1;
        }

        $data = [
            'product_id' => $productId, // Replace with your product ID
            'name' => $packageName . ' for annually ', // Plan name
            'description' => $packageName . ' for annually plan is non auto renewal', // Plan description
            'status' => 'ACTIVE', // Plan status
            'billing_cycles' => $billing_detail,
            'payment_preferences' => [
                'auto_bill_outstanding' => false,
                'auto_renewal' => false,
                'setup_fee' => [
                    'value' => '0',
                    'currency_code' => 'USD',
                ],
                'setup_fee_failure_action' => 'CONTINUE',
                'payment_failure_threshold' => 5,
            ],
        ];
        $response = $client->post(env('PAYPAL_BASE_URL') . '/billing/plans', [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->paypalToken(),
                'Content-Type' => 'application/json',
            ],
            'json' => $data,
        ]);

        $plan_non_auto = json_decode($response->getBody(), true);
        if ($registrationPackage == null) {
            return $plan['id'];
        } else {
            $registrationPackage->update(['paypal_auto_renew_annually_id' => $plan['id'], 'paypal_non_auto_renew_annually_id' => $plan_non_auto['id']]);
        }
    }

    public function deavtivePlan($planId)
    {
        $client = new Client();
        $client->post(env('PAYPAL_BASE_URL') . '/billing/plans/' . $planId . '/deactivate', [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->paypalToken(),
                'Content-Type' => 'application/json',
            ]
        ]);
    }

    public function createSubscription($request, $user, $packag, $type = 'customer_signup')
    {
        $client = new Client();
        if($user->payment_frequency == 'monthly'){
            $planId = $packag->paypal_auto_renew_monthly_id;
            if ($user->is_auto_renew == '1') {
                $planId = $packag->paypal_non_auto_renew_monthly_id;
            }
        }
        else if($user->payment_frequency == 'quarterly'){
            $planId = $packag->paypal_auto_renew_quarterly_id;
            if ($user->is_auto_renew == '1') {
                $planId = $packag->paypal_non_auto_renew_quarterly_id;
            }
        }
        else if($user->payment_frequency == 'semi_annually'){
            $planId = $packag->paypal_auto_renew_semi_annually_id;
            if ($user->is_auto_renew == '1') {
                $planId = $packag->paypal_non_auto_renew_semi_annually_id;
            }
        }
        else if($user->payment_frequency == 'annually'){
            $planId = $packag->paypal_auto_renew_annually_id;
            if ($user->is_auto_renew == '1') {
                $planId = $packag->paypal_non_auto_renew_annually_id;
            }
        }
        

        $response = $client->post(env('PAYPAL_BASE_URL') . '/billing/subscriptions', [
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $this->paypalToken(), // Replace with your actual access token
            ],
            'json' => [
                'plan_id' => $planId, // Replace with your actual plan ID
                'subscriber' => [
                    'name' => [
                        'given_name' => $user->name,
                        'surname' => '',
                    ],
                    'email_address' => $user->email,
                ],
                'application_context' => [
                    // 'return_url' => env('APP_URL') . '/subscription/success', // Replace with your success URL
                    // 'cancel_url' => env('APP_URL') . '/subscription/cancel', // Replace with your cancel URL
                    'return_url' => route('paypal.subscription.success', ['user_id' => $user->id, 'type' => $type, 'package_id' => $packag->id]),
                    'cancel_url' => route('paypal.subscription.cancel', ['user_id' => $user->id, 'type' => $type, 'package_id' => $packag->id])
                ],
            ],
        ]);

        $responseData = json_decode($response->getBody(), true);
        if (isset($responseData['links'][0]['href'])) {
            return [
                'status' => 'Success',
                'redirect_url' => $responseData['links'][0]['href']
            ];
        } else {
            if (isset($responseData->details)) {
                $errorMessage = $responseData->details[0]->issue;
            } else {
                $errorMessage = "An unknown error occurred.";
            }

            return [
                'status' => 'Error',
                'message' => "Subscription creation failed. Error: $errorMessage"
            ];
        }
    }

    public function updateSubscriptionPlan($request, $user, $packag)
    {
        $client = new Client();
        $response = $client->get(env('PAYPAL_BASE_URL') . '/billing/subscriptions/' . $user->paypal_subscription_id, [
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $this->paypalToken(),
            ],
        ]);
        $existingSubscription = json_decode($response->getBody(), true);
        if($request->payment_frequency == 'monthly'){
            $planId = $packag->paypal_auto_renew_monthly_id;
            if ($user->is_auto_renew == '1') {
                $planId = $packag->paypal_non_auto_renew_monthly_id;
            }
        }
        else if($request->payment_frequency == 'quarterly'){
            $planId = $packag->paypal_auto_renew_quarterly_id;
            if ($user->is_auto_renew == '1') {
                $planId = $packag->paypal_non_auto_renew_quarterly_id;
            }
        }
        else if($request->payment_frequency == 'semi_annually'){
            $planId = $packag->paypal_auto_renew_semi_annually_id;
            if ($user->is_auto_renew == '1') {
                $planId = $packag->paypal_non_auto_renew_semi_annually_id;
            }
        }
        else if($request->payment_frequency == 'annually'){
            $planId = $packag->paypal_auto_renew_annually_id;
            if ($user->is_auto_renew == '1') {
                $planId = $packag->paypal_non_auto_renew_annually_id;
            }
        }
        // Step 3: Create a new subscription with the updated plan
        $response = $client->post(env('PAYPAL_BASE_URL') . '/billing/subscriptions', [
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $this->paypalToken(),
            ],
            'json' => [
                'plan_id' => $planId, // Replace with the new plan ID
                'subscriber' => [
                    'name' => $existingSubscription['subscriber']['name'],
                    'email_address' => $existingSubscription['subscriber']['email_address'],
                ],
                'application_context' => [
                    'return_url' => env('APP_URL') . '/subscription/success', // Replace with your success URL
                    'cancel_url' => env('APP_URL') . '/subscription/cancel', // Replace with your cancel URL
                ],
            ],
        ]);

        $newSubscription = json_decode($response->getBody(), true);
        return [
            'status' => 'Success',
            'redirect_url' => $newSubscription['links'][0]['href']
        ];
    }

    public function cancelSubscriptionPlan($user)
    {
        $client = new Client();
        $response = $client->post(env('PAYPAL_BASE_URL') . '/billing/subscriptions/' . $user->paypal_subscription_id . '/suspend', [
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $this->paypalToken(),
            ],
        ]);
        $user->update([
            'subscription_status' => 'cancel'
        ]);
    }

    public function activateSubscriptionPlan($user)
    {
        $client = new Client();
        $response = $client->post(env('PAYPAL_BASE_URL') . '/billing/subscriptions/' . $user->paypal_subscription_id . '/activate', [
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $this->paypalToken(),
            ],
        ]);
        $user->update([
            'subscription_status' => 'ok'
        ]);
    }

}
