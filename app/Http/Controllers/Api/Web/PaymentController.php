<?php

namespace App\Http\Controllers\Api\Web;

use App\Http\Controllers\Controller;
use App\Http\Resources\Web\RegistrationPackageResource;
use App\Jobs\RegistrationEmailJob;
use App\Mail\InquiryMail;
use App\Mail\RegistrationInvoiceToCustomerMail;
use App\Models\Business;
use App\Models\Customer;
use App\Models\CustomerInquiry;
use App\Models\I2b;
use App\Models\Order;
use App\Models\ProximaRequest;
use App\Models\RegistrationPackage;
use App\Services\PaypalService;
use App\Services\PDFService;
use App\Services\StripeService;
use Stripe\PaymentIntent;
use Illuminate\Http\Request;
use App\Traits\StatusResponser;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use LVR\CreditCard\CardNumber;
use Stripe\Stripe;

class PaymentController extends Controller
{
    use StatusResponser;

    public function index()
    {
        return view('front.signup-payment');
    }

    public function updatePlan()
    {
        return view('front.update-plan');
    }

    public function processRegistrationPayment(Request $request)
    {
        $errorMessages = [];
        $validationRule = [];
        if ($request->payment_method == 'stripe') {
            $validationRule = [
                'card_holder_name' => ['required'],
                'card_no' => ['required', new CardNumber()],
                'expiry_month' => ['required', 'min:01', 'max:12'],
                'expiry_year' => ['required', 'digits:4'],
                'cvc' => ['required', 'min:3', 'max:4'],
            ];
        }

        $validationRule = array_merge($validationRule, ['payment_method' => ['required', 'in:stripe,paypal']]);
        $this->validate($request, $validationRule, $errorMessages, []);
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
                    return $this->successResponse(
                        [
                            'type' => 'paypal',
                            'redirect_url' => $paypalService,
                        ],
                        'You are about to redirect to payment processing.',
                    );
                } catch (\Exception $e) {
                    return $this->errorResponse($e->getMessage());
                }
            }
        }
        if ($request->payment_method == 'stripe') {
            Stripe::setApiKey(env('STRIPE_SECRET'));
        }
        $user = auth()
            ->guard('customers')
            ->user();
        $package = getRegistrationPackage($user->registration_package_id);
        try {
            $subscription_status = null;
            if ($request->payment_method == 'stripe') {
                $stripeService = new StripeService();
                $stripeResponse = $stripeService->registrationPayment($package, $user, $request);
                $subscription_id = $stripeResponse['subscription_id'];
                $stripe_item_id = $stripeResponse['stripe_item_id'];
                if ($user->is_auto_renew == '1') {
                    $subscription_status = 'ok';
                }
            } elseif ($request->payment_method == 'paypal') {
                $paypalService = new PaypalService();
                $paypalResponse = $paypalService->createSubscription($request, $user, $package);
                Customer::whereId($user->id)->update([
                    'temp_registration_package_id' => $package->id,
                ]);

                if ($paypalResponse['status'] == 'Error') {
                    return $this->errorResponse($paypalResponse['message']);
                } elseif ($paypalResponse['status'] == 'Success') {
                    return $this->successResponse(
                        [
                            'type' => 'paypal',
                            'redirect_url' => $paypalResponse['redirect_url'],
                        ],
                        'Payment has be done successfully',
                    );
                }
                return $this->errorResponse();
            }
            $package_expiry_date = date('Y-m-d');
            if ($user->payment_frequency == 'monthly') {
                $package_price = $user->package_price;
                $package_expiry_date = date('Y-m-d', strtotime('+1 months'));
                $packageValidity = '1 month';
            } elseif ($user->payment_frequency == 'quarterly') {
                $package_price = $user->package_price * 3;
                $package_expiry_date = date('Y-m-d', strtotime('+3 months'));
                $packageValidity = '3 months';
            } elseif ($user->payment_frequency == 'semi_annually') {
                $package_price = $user->package_price * 6;
                $package_expiry_date = date('Y-m-d', strtotime('+6 months'));
                $packageValidity = '6 months';
            } elseif ($user->payment_frequency == 'annually') {
                $package_price = $user->package_price * 12;
                $package_expiry_date = date('Y-m-d', strtotime('+12 months'));
                $packageValidity = '12 months';
            }

            Customer::whereId($user->id)->update([
                'package_price' => $user->package_price,
                'package_subscribed_date' => date('Y-m-d'),
                'package_expiry_date' => $package_expiry_date,
                // 'deactive_account' => 1,
                'is_package_amount_paid' => 1,
                'subscription_status' => $subscription_status,
                'subscription_id' => $request->payment_method == 'stripe' ? $subscription_id : null,
                'payment_method' => $request->payment_method,
                'stripe_item_id' => isset($stripe_item_id) ? $stripe_item_id : null,
            ]);

            $order = Order::create([
                'registration_package_id' => $package->id,
                'customer_id' => $user->id,
                'type' => 'profile',
                'payment_method' => $request->payment_method,
                'transaction_id' => isset($subscription_id) ? $subscription_id : null,
                'stripe_item_id' => isset($stripe_item_id) ? $stripe_item_id : null,
                'amount' => $package_price,
            ]);

            $invoiceNo = 'CE' . str_pad((int) $order->id + 1, 4, '0', STR_PAD_LEFT);
            $order->update([
                'invoice_no' => $invoiceNo,
            ]);

            if ($user->user_type == 'business') {
                $business = Business::where('customer_id', $user->id)->first();
                if ($business) {
                    $emailData = ['id' => $business->id, 'email' => $business->email, 'type' => 'register_business'];
                    dispatch(new RegistrationEmailJob($emailData));
                }
            } else {
                $emailData = ['id' => $user->id, 'first_name' => $user->first_name, 'last_name' => $user->last_name, 'email' => $user->email, 'password' => $user->password, 'type' => 'email_verified', 'token' => ''];
                dispatch(new RegistrationEmailJob($emailData));
            }

            $data = ['package_name' => isset($package->registrationPackageDetail[0]) ? $package->registrationPackageDetail[0]->name : '', 'package_price' => $user->package_price, 'payment_frequency' => $user->payment_frequency, 'package_validity' => $packageValidity, 'customer' => $user, 'order' => $order, 'package_expiry_date' => $package_expiry_date];

            $PDFService = new PDFService();

            $PDFService->createRegistrationInvoicePDF(null, $data);

            Mail::to($user->email)->send(new RegistrationInvoiceToCustomerMail($data));

            $verificationSuccessMessage = getGeneralTranslation()['verification_email_message_text'] ? getGeneralTranslation()['verification_email_message_text'] : 'Thank you. Your registration is now complete';
            $defaultLang = getDefaultLanguage(1);

            // Auth::guard('customers')->logout();
            return $this->successResponse([
                'type' => auth()->guard('customers')->user()->user_type,
                'redirect_url' => route('web.account.school.information', ['lang' => $defaultLang['abbreviation'], 'slug' => auth()->guard('customers')->user()->slug]),
            ], $verificationSuccessMessage);
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
        if ($user->payment_frequency == 'monthly') {
            $package_price = $user->package_price;
            $package_expiry_date = date('Y-m-d', strtotime('+1 months'));
        } elseif ($user->payment_frequency == 'quarterly') {
            $package_price = $user->package_price * 3;
            $package_expiry_date = date('Y-m-d', strtotime('+3 months'));
        } elseif ($user->payment_frequency == 'semi_annually') {
            $package_price = $user->package_price * 6;
            $package_expiry_date = date('Y-m-d', strtotime('+6 months'));
        } elseif ($user->payment_frequency == 'annually') {
            $package_price = $user->package_price * 12;
            $package_expiry_date = date('Y-m-d', strtotime('+12 months'));
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
                    $paypalService->cancelSubscriptionPlan($user);
                    try {
                        $stripeService = new StripeService();
                        $stripeResponse = $stripeService->registrationPayment($package, $user, $request, true);
                        $subscription_id = $stripeResponse['subscription_id'];
                        $stripe_item_id = $stripeResponse['stripe_item_id'];
                        Customer::whereId($user->id)->update([
                            'package_price' => $package_price,
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
                            'amount' => $package_price,
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
                        'redirect_url' => $res['redirect_url'],
                    ],
                    'Subscription package has been updated.',
                );
            }
            
            return $this->successResponse(new RegistrationPackageResource($package), 'Your changes have been done successfully');
        }
        return $this->errorResponse();
    }

    public function cancelSubscription()
    {
        $user = auth()
            ->guard('customers')
            ->user();
        if ($user->payment_method == 'stripe') {
            $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
            $stripe->subscriptions->update($user->subscription_id, ['cancel_at_period_end' => true]);
            Customer::whereId($user->id)->update([
                'subscription_status' => 'cancel',
            ]);

            return $this->successResponse([], 'Subscription has been canceled.');
        }
        if ($user->payment_method == 'paypal') {
            $packageName = $user->registrationPackage->registrationPackageDetail[0]->name;
            $request = [
                'package_type' => $user->registrationPackage->package_type,
                'package_validity' => $user->registrationPackage->package_validity,
                'price' => $user->registrationPackage->price,
                'auto_renewal' => false, // Enable auto-renewal for the subscription
                'auto_bill_outstanding' => false, // Enable auto-bill for outstanding amounts
            ];
            $paypalService = new PaypalService();
            $planId = $paypalService->createPlan((object) $request, $packageName);

            Customer::where('id', $user->id)->update([
                'temp_plan_id' => $planId,
            ]);
            $paypalService = new PaypalService();
            $res = $paypalService->createSubscription([], $user, (object) ['paypal_plan_id' => $planId]);
            return $this->successResponse(
                [
                    'type' => 'paypal',
                    'redirect_url' => $res,
                ],
                'Your changes have been done successfully',
            );
        }
        return $this->errorResponse();
    }

    public function resumeSubscription()
    {
        $user = auth()
            ->guard('customers')
            ->user();

        if ($user->payment_method == 'stripe') {
            $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
            $stripe->subscriptions->update($user->subscription_id, ['cancel_at_period_end' => false]);
            Customer::whereId($user->id)->update([
                'subscription_status' => 'ok',
            ]);

            return $this->successResponse([], 'Subscription has been resumed.');
        }
        if ($user->payment_method == 'paypal') {
            $packageName = $user->registrationPackage->registrationPackageDetail[0]->name;
            $request = [
                'package_type' => $user->registrationPackage->package_type,
                'package_validity' => $user->registrationPackage->package_validity,
                'price' => $user->registrationPackage->price,
                'auto_renewal' => true, // Enable auto-renewal for the subscription
                'auto_bill_outstanding' => true, // Enable auto-bill for outstanding amounts
            ];
            $paypalService = new PaypalService();
            $planId = $paypalService->createPlan((object) $request, $packageName);

            Customer::where('id', $user->id)->update([
                'temp_plan_id' => $planId,
            ]);
            $paypalService = new PaypalService();
            $res = $paypalService->createSubscription([], $user, (object) ['paypal_plan_id' => $planId]);
            return $this->successResponse(
                [
                    'type' => 'paypal',
                    'redirect_url' => $res,
                ],
                'Your changes have been done successfully',
            );
        }
        return $this->errorResponse();
    }

    public function paypalSuccessResponse(Request $request)
    {
        $user = null;
        $package = null;
        if (!isset($request->subscription_id)) {
            return false;
        }
        if (auth()->guard('customers')->check()) {
            $user = auth()->guard('customers')->user();
        }
        if (isset($_GET['package_id']) && $_GET['package_id'] != '') {
            $package = getRegistrationPackage($_GET['package_id']);
        }

        $defaultLang = getDefaultLanguage(1);
        // if (isset($user->subscription_id) && !empty($user->subscription_id)) {
        //     $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
        //     $getSubscription = $stripe->subscriptions->retrieve($user->subscription_id, []);
        //     if (isset($getSubscription->status) && ($getSubscription->status == 'active' || $getSubscription->status == 'trialing')) {
        //         $stripe->subscriptions->cancel($user->subscription_id);
        //     }
        // }

        // if (isset($user->paypal_subscription_id) && !empty($user->paypal_subscription_id)) {
        //     $paypalService = new PaypalService();
        //     $client = new Client();
        //     $response = $client->get(env('PAYPAL_BASE_URL') . '/billing/subscriptions/' . $user->paypal_subscription_id, [
        //         'headers' => [
        //             'Content-Type' => 'application/json',
        //             'Authorization' => 'Bearer ' . $paypalService->paypalToken(),
        //         ],
        //     ]);
        //     if ($response->getStatusCode() === 200) {
        //         $body = $response->getBody();
        //         $data = json_decode($body, true);
        //         if (isset($data['status']) && $data['status'] == 'ACTIVE') {
        //             $client = new Client();
        //             $client->post(env('PAYPAL_BASE_URL') . '/billing/subscriptions/' . $user->paypal_subscription_id . '/cancel', [
        //                 'headers' => [
        //                     'Content-Type' => 'application/json',
        //                     'Authorization' => 'Bearer ' . $paypalService->paypalToken(),
        //                 ],
        //             ]);
        //         }
        //     }
        // }

        // if ($package) {
        //     Customer::whereId($user->id)->update([
        //         'package_price' => ((($user->payment_frequency == 'monthly' ? $package->monthly_price : $user->payment_frequency == 'annually') ? $package->annually_price : $user->payment_frequency == 'quarterly') ? $package->quarterly_price : $user->payment_frequency == 'semi_annually') ? $package->semi_annually_price : 0,
        //         'free_subscription_days' => $package->free_subscription_days,
        //         'package_subscribed_date' => date('Y-m-d'),
        //         'package_expiry_date' => date('Y-m-d', strtotime('+' . (isset($package) ? $package->package_validity_months : 0) . ' months')),
        //         'is_package_amount_paid' => 1,
        //         'paypal_subscription_id' => $request->subscription_id,
        //         'subscription_id' => null,
        //         'registration_package_id' => $user->temp_registration_package_id,
        //         'payment_method' => 'paypal',
        //         'deactive_account' => 1,
        //         'subscription_status' => $user->subscription_status == 'ok' ? 'cancel' : 'ok',
        //     ]);

        //     Order::create([
        //         'registration_package_id' => $package->id,
        //         'customer_id' => $user->id,
        //         'type' => 'profile',
        //         'payment_method' => 'paypal',
        //         'transaction_id' => isset($subscription_id) ? $subscription_id : null,
        //         'stripe_item_id' => isset($stripe_item_id) ? $stripe_item_id : null,
        //         'amount' => ((($user->payment_frequency == 'monthly' ? $package->monthly_price : $user->payment_frequency == 'annually') ? $package->annually_price : $user->payment_frequency == 'quarterly') ? $package->quarterly_price : $user->payment_frequency == 'semi_annually') ? $package->semi_annually_price : 0,
        //     ]);
        // }

        if (isset($_GET['type']) && $_GET['type'] == 'customer_signup') {
            $user = Customer::whereId($_GET['user_id'])->firstOrFail();
            $package_price = 0;
            $orderAmount = 0;
            $package_expiry_date = date('Y-m-d');
            if ($user->payment_frequency == 'monthly') {
                $package_price = $package->monthly_price;
                $orderAmount = $package->monthly_price;
                $packageValidity = '1 month';
                $package_expiry_date = date('Y-m-d', strtotime('+1 months'));
            } else if ($user->payment_frequency == 'quarterly') {
                $package_price = $package->quarterly_price;
                $orderAmount = $package->quarterly_price * 3;
                $packageValidity = '3 months';
                $package_expiry_date = date('Y-m-d', strtotime('+3 months'));
            } else if ($user->payment_frequency == 'semi_annually') {
                $package_price = $package->semi_annually_price;
                $orderAmount = $package->semi_annually_price * 6;
                $packageValidity = '6 months';
                $package_expiry_date = date('Y-m-d', strtotime('+6 months'));
            } else if ($user->payment_frequency == 'annually') {
                $package_price = $package->annually_price;
                $orderAmount = $package->annually_price * 12;
                $packageValidity = '12 months';
                $package_expiry_date = date('Y-m-d', strtotime('+12 months'));
            }
            if ($package && $user) {
                Customer::whereId($user->id)->update([
                    'package_price' => $package_price,
                    'package_subscribed_date' => date('Y-m-d'),
                    'package_expiry_date' => $package_expiry_date,
                    'is_package_amount_paid' => 1,
                    'paypal_subscription_id' => $request->subscription_id,
                    'subscription_id' => null,
                    'registration_package_id' => $user->registration_package_id,
                    'payment_frequency' => $user->payment_frequency,
                    'is_auto_renew' => $user->is_auto_renew,
                    'payment_method' => 'paypal',
                    'subscription_status' => 'ok'
                ]);

                $order = Order::create([
                    'registration_package_id' => $package->id,
                    'customer_id' => $user->id,
                    'type' => 'profile',
                    'payment_method' => 'paypal',
                    'transaction_id' => $request->subscription_id,
                    'stripe_item_id' => null,
                    'amount' => $orderAmount,
                ]);

                $invoiceNo = 'CE' . (str_pad((int)$order->id + 1, 4, '0', STR_PAD_LEFT));
                $order->update([
                    'invoice_no' => $invoiceNo
                ]);



                $customer = Customer::with(['registrationPackage.registrationPackageDetail' => function ($q) use ($defaultLang) {
                    $q->where('language_id', $defaultLang->id);
                }])->with('customerProfile')->where('id', $user->id)->first();


                $packageName = (isset($customer->registrationPackage->registrationPackageDetail[0]) ? $customer->registrationPackage->registrationPackageDetail[0]->name : '');

                // $activeEmailUrl = Hash::make($request->email);
                // Customer::whereId($customer->id)->update([
                //     'active_email_url' => $activeEmailUrl,
                // ]);
                // $data = [
                //     'user_id' => $activeEmailUrl,
                //     'email' => $customer->email,
                // ];

                // Mail::to($customer->email)->send(new CustomerVerifyEmailMail($data));

                if ($user->user_type == 'business') {
                    $business = Business::where('customer_id', $user->id)->first();
                    if ($business) {
                        $emailData = ['id' => $business->id, 'email' => $business->email, 'type' => 'register_business'];
                        dispatch(new RegistrationEmailJob($emailData));
                    }
                } else {
                    $emailData = ['id' => $user->id, 'first_name' => $user->first_name, 'last_name' => $user->last_name, 'email' => $user->email, 'password' => $user->password, 'type' => 'email_verified', 'token' => ''];
                    dispatch(new RegistrationEmailJob($emailData));
                }

                $data = ['package_name' => $packageName, 'package_price' => $package_price, 'package_validity' => $packageValidity, 'payment_frequency' => $user->payment_frequency, 'customer' => $customer, 'order' => $order, 'package_expiry_date' => $package_expiry_date];

                $PDFService = new PDFService();

                $PDFService->createRegistrationInvoicePDF(null, $data);

                Mail::to($customer->email)->send(new RegistrationInvoiceToCustomerMail($data));

                // $general_messages = getStaticTranslationByKey((isset($defaultLang) ? $defaultLang : null), 'general_messages', ['message_38']);
                // $message_38 = isset($general_messages['message_38']) ? $general_messages['message_38'] : '';

                Session::flash('status', 'success');

                $verificationSuccessMessage = getGeneralTranslation()['verification_email_message_text'] ? getGeneralTranslation()['verification_email_message_text'] : 'Thank you. Your registration is now complete';
                Session::flash('message', $verificationSuccessMessage);
                
                if ($customer->user_type == 'school') {
                    $url = route('web.account.school.information', ['lang' => $defaultLang['abbreviation'], 'slug' => auth()->guard('customers')->user()->slug]);
                } else {
                    $url = langBasedURL($defaultLang, route('front.page', $defaultLang->abbreviation));
                }
                
                // Auth::guard('customers')->logout();
                return Redirect::to($url);
            } else {
                Session::flash('status', 'error');
                // $general_messages = getStaticTranslationByKey($defaultLang, 'general_messages', ['message_1']);
                // $message_1 = isset($general_messages['message_1']) ? $general_messages['message_1'] : '';
                Session::flash('message', 'Something went wrong');
                $url = route('web.payment.index', [$defaultLang->abbreviation]);
                return Redirect::to($url);
            }
        }
        Auth::guard('customers')->logout();
        return redirect('/');
    }

    public function paypalCancelResponse(Request $request)
    {
        return redirect('/');
    }

    public function proximaSuccessResponse(Request $request)
    {
        return redirect('/');
    }

    public function proximaCancelResponse(Request $request)
    {
        return redirect('/');
    }
}
