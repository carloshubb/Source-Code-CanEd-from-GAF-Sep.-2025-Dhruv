public function processRegistrationPayment(Request $request)
    {
        if ($request->payment_method == 'stripe') {
            $errorMessages = [];
            $validationRule = [
                'card_holder_name' => ['required'],
                'card_no' => ['required', new CardNumber()],
                'expiry_month' => ['required', 'min:01', 'max:12'],
                'expiry_year' => ['required', 'digits:4'],
                'cvc' => ['required', 'min:3', 'max:4'],
            ];
            $validationRule = array_merge($validationRule, ['payment_method' => ['required', 'in:stripe,paypal']]);
            $errorMessages = array_merge($errorMessages, ['card_holder_name' . '.required' => 'Card holder name field is required']);
            $errorMessages = array_merge($errorMessages, ['card_no' . '.required' => 'Card no field is required']);
            $errorMessages = array_merge($errorMessages, ['expiry_month' . '.required' => 'Expiry month field is required']);
            $errorMessages = array_merge($errorMessages, ['expiry_year' . '.required' => 'Expiry year field is required']);
            $errorMessages = array_merge($errorMessages, ['cvc' . '.required' => 'Cvc field is required']);

            $this->validate($request, $validationRule, $errorMessages);
        }

        if (isset($request->paymentType) && $request->paymentType == 'proxima') {
            $ProximaRequest = ProximaRequest::where('id', $request->proxima_id)->first();
            if ($request->payment_method == 'stripe') {
                try {
                    $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
                    if (
                        $stripe->charges->create([
                            'amount' => $ProximaRequest->quotation_amount * 100,
                            'currency' => 'usd',
                            'source' => 'tok_mastercard',
                            'description' => $ProximaRequest->quotation_detail,
                            'capture' => true,
                        ])
                    ) {
                        $ProximaRequest->status = 'paid';
                        $ProximaRequest->save();
                        return $this->successResponse([], 'Payment has been charged successfully');
                    }
                } catch (\Exception $e) {
                    return $this->errorResponse($e->getMessage());
                }
            }
            if ($request->payment_method == 'paypal') {
                try {
                    $paypalService = new PaypalService();
                    // Create the payment
                    $response = Http::withHeaders([
                        'Authorization' => 'Bearer ' . $paypalService->paypalToken(),
                        'Content-Type' => 'application/json',
                    ])->post('https://api.sandbox.paypal.com/v2/checkout/orders', [
                        'intent' => 'CAPTURE',
                        'purchase_units' => [
                            [
                                'amount' => [
                                    'currency_code' => 'USD',
                                    'value' => $ProximaRequest->quotation_amount,
                                ],
                            ],
                        ],
                        'application_context' => [
                            'return_url' => env('APP_URL') . '/proxima-payment/success', // Replace with your success URL
                            'cancel_url' => env('APP_URL') . '/proxima-payment/cancel', // Replace with your cancel URL
                        ],
                    ]);

                    $payment = $response->json();

                    // You can now redirect the user to the approval URL to complete the payment.
                    $approvalUrl = collect($payment['links'])->firstWhere('rel', 'approve');
                    return $this->successResponse(
                        [
                            'type' => 'paypal',
                            'redirect_url' => $approvalUrl['href'],
                        ],
                        'You are about to redirect to payment processing.',
                    );
                } catch (\Exception $e) {
                    return $this->errorResponse($e->getMessage());
                }
            }
        }
        $user = auth()
            ->guard('customers')
            ->user();

        $package = getRegistrationPackage($user->registration_package_id);
        try {
            $subscription_status = null;
            $paypal_subscription_id = null;
            if ($request->payment_method == 'stripe') {
                $stripeService = new StripeService();
                $stripeResponse = $stripeService->registrationPayment($package, $user, $request, false);
                $subscription_id = $stripeResponse['subscription_id'];
                $stripe_item_id = $stripeResponse['stripe_item_id'];
                if ($user->is_auto_renew == '1') {
                    $subscription_status = 'ok';
                }
                Customer::whereId($user->id)->update([
                    'package_price' => isset($package->discount_price) ? $package->discount_price : $package->price,
                    'free_subscription_days' => $package->free_subscription_days,
                    'package_subscribed_date' => date('Y-m-d'),
                    'package_expiry_date' => date('Y-m-d', strtotime('+' . (isset($package) ? $package->package_validity_months : 0) . ' months')),
                    'is_package_amount_paid' => 1,
                    // 'subscription_status' => $subscription_status,
                    'subscription_id' => $request->payment_method == 'stripe' ? $subscription_id : null,
                    'payment_method' => $request->payment_method,
                    'stripe_item_id' => isset($stripe_item_id) ? $stripe_item_id : null,
                ]);

                Order::create([
                    'registration_package_id' => $package->id,
                    'customer_id' => $user->id,
                    'type' => 'profile',
                    'payment_method' => $request->payment_method,
                    'transaction_id' => isset($subscription_id) ? $subscription_id : null,
                    'stripe_item_id' => isset($stripe_item_id) ? $stripe_item_id : null,
                    'amount' => isset($package->discount_price) && $package->discount_price > 0 ? $package->discount_price : $package->price,
                ]);

                return $this->successResponse([], 'Registration package has been subscribed successfully.');
            }
            if ($request->payment_method == 'paypal') {
                $paypalService = new PaypalService();
                $paypalService = $paypalService->createSubscription($request, $user, $package);
                Customer::whereId($user->id)->update([
                    'temp_registration_package_id' => $package->id,
                ]);
                return $this->successResponse(
                    [
                        'type' => 'paypal',
                        'redirect_url' => $paypalService,
                    ],
                    'Registration package has been subscribed successfully.',
                );
            }
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function processUpgradeAccount(Request $request)
    {
        $package = getRegistrationPackage($request->registration_package_id);
        if ($request->payment_method != 'paypal' && $package->package_type != 'free') {
            $errorMessages = [];
            $validationRule = [
                'registration_package_id' => ['required', 'exists:App\Models\RegistrationPackage,id'],
                'customer_payment_method_id' => ['required'],
                'card_holder_name' => ['required'],
                'card_no' => ['required', new CardNumber()],
                'expiry_month' => ['required', 'min:01', 'max:12'],
                'expiry_year' => ['required', 'digits:4'],
                'cvc' => ['required', 'min:3', 'max:4'],
                'payment_method' => ['required', 'in:stripe'],
            ];

            $validationRule = array_merge($validationRule, ['payment_method' => ['required', 'in:stripe,paypal']]);

            $errorMessages = array_merge($errorMessages, ['card_holder_name' . '.required' => 'Card holder name field is required']);
            $errorMessages = array_merge($errorMessages, ['card_no' . '.required' => 'Card no field is required']);
            $errorMessages = array_merge($errorMessages, ['expiry_month' . '.required' => 'Expiry month field is required']);
            $errorMessages = array_merge($errorMessages, ['expiry_year' . '.required' => 'Expiry year field is required']);
            $errorMessages = array_merge($errorMessages, ['cvc' . '.required' => 'cvc field is required']);

            $this->validate($request, $validationRule, $errorMessages);
        }

        $user = auth()
            ->guard('customers')
            ->user();
        if ($user->registration_package_id == $request->registration_package_id) {
            return $this->errorResponse('You already selected this package.');
        }
        if ($request->payment_method == 'stripe') {
            if ($package->package_type == 'free') {
                if ($user->payment_method == 'paypal') {
                    $paypalService = new PaypalService();
                    $client = new Client();
                    $client->post(env('PAYPAL_BASE_URL') . '/billing/subscriptions/' . $user->paypal_subscription_id . '/cancel', [
                        'headers' => [
                            'Content-Type' => 'application/json',
                            'Authorization' => 'Bearer ' . $paypalService->paypalToken(),
                        ],
                    ]);
                }
                if ($user->payment_method == 'stripe') {
                    $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
                    $stripe->subscriptions->cancel($user->subscription_id);
                }
                Customer::whereId($user->id)->update([
                    'registration_package_id' => $request->registration_package_id,
                    'subscription_status' => 'cancel',
                    'payment_method' => null,
                    'subscription_id' => null,
                    'paypal_subscription_id' => null,
                    'stripe_customer_id' => null,
                ]);
            } else {
                if ($user->payment_method == 'paypal') {
                    $paypalService = new PaypalService();
                    $client = new Client();
                    $client->post(env('PAYPAL_BASE_URL') . '/billing/subscriptions/' . $user->paypal_subscription_id . '/cancel', [
                        'headers' => [
                            'Content-Type' => 'application/json',
                            'Authorization' => 'Bearer ' . $paypalService->paypalToken(),
                        ],
                    ]);
                    try {
                        $stripeService = new StripeService();
                        $stripeResponse = $stripeService->registrationPayment($package, $user, $request, true);
                        $subscription_id = $stripeResponse['subscription_id'];
                        $stripe_item_id = $stripeResponse['stripe_item_id'];
                        Customer::whereId($user->id)->update([
                            'package_price' => isset($package->discount_price) ? $package->discount_price : $package->price,
                            'free_subscription_days' => $package->free_subscription_days,
                            'package_subscribed_date' => date('Y-m-d'),
                            'package_expiry_date' => date('Y-m-d', strtotime('+' . (isset($package) ? $package->package_validity_months : 0) . ' months')),
                            'is_package_amount_paid' => 1,
                            'subscription_status' => 'ok',
                            'registration_package_id' => $package->id,
                            'subscription_id' => $request->payment_method == 'stripe' ? $subscription_id : null,
                            'payment_method' => $request->payment_method,
                            'stripe_item_id' => isset($stripe_item_id) ? $stripe_item_id : null,
                        ]);

                        Order::create([
                            'registration_package_id' => $package->id,
                            'customer_id' => $user->id,
                            'type' => 'profile',
                            'payment_method' => $request->payment_method,
                            'transaction_id' => isset($subscription_id) ? $subscription_id : null,
                            'stripe_item_id' => isset($stripe_item_id) ? $stripe_item_id : null,
                            'amount' => isset($package->discount_price) && $package->discount_price > 0 ? $package->discount_price : $package->price,
                        ]);
                    } catch (\Exception $e) {
                        return $this->errorResponse($e->getMessage());
                    }
                } else {
                    try {
                        $stripeService = new StripeService();
                        $stripeService->upgradeUserAccount($request, $user, $package);
                    } catch (\Exception $e) {
                        return $this->errorResponse($e->getMessage());
                    }
                }
            }

            return $this->successResponse(new RegistrationPackageResource($package), 'Subscription package has been updated.');
        }
        $res = [];
        if ($request->payment_method == 'paypal') {
            $paypalService = new PaypalService();
            if ($package->package_type == 'free') {
                if ($user->payment_method == 'stripe') {
                    $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
                    $stripe->subscriptions->cancel($user->subscription_id);
                }
                if ($user->payment_method == 'paypal') {
                    $client = new Client();
                    $client->post(env('PAYPAL_BASE_URL') . '/billing/subscriptions/' . $user->paypal_subscription_id . '/cancel', [
                        'headers' => [
                            'Content-Type' => 'application/json',
                            'Authorization' => 'Bearer ' . $paypalService->paypalToken(),
                        ],
                    ]);
                }
                Customer::whereId($user->id)->update([
                    'registration_package_id' => $request->registration_package_id,
                    'subscription_status' => 'cancel',
                    'payment_method' => null,
                    'subscription_id' => null,
                    'paypal_subscription_id' => null,
                    'stripe_customer_id' => null,
                ]);
            } else {
                if ($user->registrationPackage->package_type == 'free') {
                    $res = $paypalService->createSubscription($request, $user, $package);
                    Customer::whereId($user->id)->update([
                        'temp_registration_package_id' => $package->id,
                    ]);
                } else {
                    if ($user->payment_method == 'stripe') {
                        $res = $paypalService->createSubscription($request, $user, $package);
                        Customer::whereId($user->id)->update([
                            'temp_registration_package_id' => $package->id,
                        ]);
                    } else {
                        $res = $paypalService->updateSubscriptionPlan($request, $user, $package);
                        Customer::whereId($user->id)->update([
                            'temp_registration_package_id' => $package->id,
                        ]);
                    }
                }

                return $this->successResponse(
                    [
                        'type' => 'paypal',
                        'redirect_url' => $res,
                    ],
                    'Subscription package has been updated.',
                );
            }

            return $this->successResponse(new RegistrationPackageResource($package), 'Your changes have been done successfully');
        }
        return $this->errorResponse();
    }