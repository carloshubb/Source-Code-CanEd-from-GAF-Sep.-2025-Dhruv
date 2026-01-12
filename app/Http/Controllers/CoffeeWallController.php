<?php

namespace App\Http\Controllers;

use App\Models\CoffeeWallet;
use App\Models\Language;
use App\Models\Package;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Stripe\Price;
use Stripe\Product;
use Stripe\Stripe;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Stripe\Customer;
use Stripe\PaymentIntent;
use Stripe\PaymentMethod;
use Stripe\Subscription;
use Illuminate\Support\Str;
use Srmklive\PayPal\Facades\PayPal;
use Stripe\SetupIntent;
use Stripe\StripeClient;

class CoffeeWallController extends Controller
{
    //
    public function index()
    {
        $packages = Package::where('custom', 0)->get();
        Stripe::setApiKey(env('STRIPE_SECRET'));
        $intent = SetupIntent::create();
        return view('front.coffee-on-the-wall', [
            'packages' => $packages,
            'clientSecret' => $intent->client_secret,
            'defaultLang' => getDefaultLanguage(1),
        ]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'frequency' => 'required|in:one_time,weekly,monthly',
            'payment_method' => 'required|in:stripe,Stripe,paypal',
            'agree_terms' => 'accepted',
        ]);

        $defaultLang = Language::where('is_default', 1)->first();
        $userId = auth()->check() ? auth()->id() : null;

        $frequency = $request->frequency;
        $paymentMethod = strtolower($request->payment_method); // normalize
        $packageId = $request->package;
        $customAmount = $request->custom_amount;
        $stripeSubMethod = $request->sub_method;

        // Determine amount
        $amount = 0;
        $package = null;
        if ($packageId) {
            $package = Package::findOrFail($packageId);
            $amount = $package->price;
        } elseif ($customAmount && $customAmount > 0) {
            $amount = $customAmount;
        } else {
            return back()->withErrors(['custom_amount' => 'Please select or enter a valid amount.']);
        }

        // Create a unique ID for record tracing
        $randomId = strtoupper(Str::random(10));

        // Common DB record prep
        $walletData = [
            'user_id' => $userId,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'anonymous' => $request->anonymous ? 1 : 0,
            'designation' => $request->beneficiary,
            'package_id' => $packageId,
            'frequency' => $frequency,
            'dr_amount' => $amount,
            'payment_method' => $paymentMethod,
            'status' => 'pending',
            'random_id' => $randomId,
        ];

        // Handle Stripe
        if (in_array($paymentMethod, ['stripe', 'Stripe'])) {
            Stripe::setApiKey(env('STRIPE_SECRET'));
            $paymentMethodId = $request->payment_method_id;
            if ($stripeSubMethod === 'google_apple_pay') {
                // Google/Apple Pay (from PaymentRequest flow)
                $paymentIntent = PaymentIntent::create([
                    'amount' => round($amount * 100),
                    'currency' => 'usd',
                    'payment_method_types' => ['card'],
                    'description' => 'Google/Apple Pay Donation',
                ]);
                $clientSecret = $paymentIntent->client_secret;
                $packages = Package::where('custom', 0)->get();

                return view('front.coffee-on-the-wall', compact('packages', 'clientSecret', 'amount')); // adjust your Blade name accordingly

            } else {
                // Debit/Credit Card
                $customer = Customer::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'payment_method' => $paymentMethodId,

                ]);

                if ($frequency === 'one_time') {
                    $paymentIntent = PaymentIntent::create([
                        'amount' => round($amount * 100),
                        'currency' => 'usd',
                        'customer' => $customer->id,
                        'payment_method' => $paymentMethodId,
                        'off_session' => true,
                        'confirm' => true,
                        'description' => 'One-time donation for Coffee on the Wall',
                    ]);

                    $walletData['stripe_id'] = $paymentIntent->id;
                    $walletData['status'] = 'completed';
                } else {
                    $interval = $frequency === 'weekly' ? 'week' : 'month';
                    // Recurring with subscription
                    if (!$package || !$package->stripe_price_id) {
                        $product = Product::create([
                            'name' => 'Coffee Donation - ' . ucfirst($interval),
                        ]);
                        $price = Price::create([
                            'unit_amount' => round($amount * 100),
                            'currency' => 'usd',
                            'recurring' => ['interval' => $interval],
                            'product' => $product->id,
                        ]);
                        $package = new Package();
                        $package->frequency = $frequency;
                        $package->price = $amount;
                        $package->custom = 1;
                        $package->stripe_product_id = $product->id;
                        $package->stripe_price_id = $price->id;
                        $package->save();
                    }
                    $stripe = new StripeClient(env('STRIPE_SECRET'));
                    $stripe->paymentMethods->attach($paymentMethodId, [
                        'customer' => $customer->id,
                    ]);
                    $stripe->customers->update($customer->id, [
                        'invoice_settings' => [
                            'default_payment_method' => $paymentMethodId,
                        ],
                    ]);
                    $subscription = $stripe->subscriptions->create([
                        'customer' => $customer->id,
                        'items' => [['price' => $package->stripe_price_id]],
                        'default_payment_method' => $paymentMethodId,
                        'payment_behavior' => 'allow_incomplete', // ✅ allow Stripe to auto-confirm
                        'expand' => ['latest_invoice.payment_intent'],
                        'collection_method' => 'charge_automatically',

                    ]);
                    $walletData['stripe_id'] = $subscription->latest_invoice->id ?? null;
                    $walletData['subscription_id'] = $subscription->id ?? null;
                    $walletData['status'] = $subscription->latest_invoice->status ?? 'unpaid'; // default to 'unpaid'
                }
            }
        }

        // Handle PayPal (Only record for now)
        if ($paymentMethod === 'paypal') {
            $provider = PayPal::setProvider();
            $provider->setApiCredentials(config('paypal'));
            $provider->getAccessToken();
            $returnUrl = route('paypal.success', ['random_id' => $randomId]);
            $cancelUrl = route('paypal.cancel');
            if ($frequency === 'one_time') {
                $response = $provider->createOrder([
                    "intent" => "CAPTURE",
                    "application_context" => [
                        "return_url" => $returnUrl,
                        "cancel_url" => $cancelUrl,
                    ],
                    "purchase_units" => [[
                        "amount" => [
                            "currency_code" => "USD",
                            "value" => $amount,
                        ],
                        "description" => "One-time Coffee Donation"
                    ]]
                ]);
                if (isset($response['id']) && $response['status'] == 'CREATED') {
                    $walletData['paypal_id'] = $response['id'];
                    $walletData['status'] = 'pending';
                    CoffeeWallet::create($walletData);
                    return redirect()->away(collect($response['links'])->firstWhere('rel', 'approve')['href']);
                } else {
                    return back()->withErrors(['paypal' => 'PayPal order creation failed.']);
                }
            }
            // Recurring with PayPal: Create product & plan
            $intervalUnit = $frequency === 'weekly' ? 'WEEK' : 'MONTH';
            $intervalCount = 1;

            // Create Product (one-time per system ideally, here for demo)
            $product = $provider->createProduct([
                'name' => 'Coffee Subscription',
                'type' => 'SERVICE',
            ]);

            $plan = $provider->createPlan([
                "product_id" => $product['id'],
                "name" => "Recurring Coffee Donation",
                "billing_cycles" => [[
                    "frequency" => [
                        "interval_unit" => $intervalUnit,
                        "interval_count" => $intervalCount
                    ],
                    "tenure_type" => "REGULAR",
                    "sequence" => 1,
                    "total_cycles" => 0,
                    "pricing_scheme" => [
                        "fixed_price" => [
                            "value" => $amount,
                            "currency_code" => "USD"
                        ]
                    ]
                ]],
                "payment_preferences" => [
                    "auto_bill_outstanding" => true,
                    "setup_fee_failure_action" => "CONTINUE",
                    "payment_failure_threshold" => 3
                ]
            ]);

            $subscription = $provider->createSubscription([
                "plan_id" => $plan['id'],
                "application_context" => [
                    "brand_name" => "Coffee Wall",
                    "locale" => "en-US",
                    "shipping_preference" => "NO_SHIPPING",
                    "user_action" => "SUBSCRIBE_NOW",
                    "return_url" => $returnUrl,
                    "cancel_url" => $cancelUrl
                ]
            ]);

            if (isset($subscription['id'])) {
                $walletData['paypal_id'] = $subscription['id'];
                $walletData['status'] = 'pending';
                CoffeeWallet::create($walletData);
                return redirect()->away(collect($subscription['links'])->firstWhere('rel', 'approve')['href']);
            } else {
                return back()->withErrors(['paypal' => 'PayPal subscription creation failed.']);
            }
        }
        // Save the donation
        CoffeeWallet::create($walletData);

        return redirect()->route('web.coffee.index', ['lang' => getDefaultLanguage(1)])
            ->with('success', 'Thank you for your contribution!');
    }
    public function createSubscription(Request $request)
    {
        if ($request->package_id) {
            $package = Package::whereId($request->package_id)->first();
        } else {
            $package = Package::where('price', $request->custom_amount)->first();
            if (!$package) {
                DB::beginTransaction();
                $package = Package::create([
                    'price' => $request->custom_amount ?? 0,
                    'custom' => 1,
                ]);

                $packageName = $request->name ?? env('APP_NAME');
                $packageDescription = 'custom' ?? env('APP_NAME');

                Stripe::setApiKey(env('STRIPE_SECRET'));

                if ($package->stripe_product_id) {
                    $product = Product::retrieve($package->stripe_product_id);
                    $product->name = $packageName;
                    $product->save();
                } else {
                    $product = Product::create([
                        'name' => $packageName,
                        'type' => 'service',
                    ]);
                    $package->update(['stripe_product_id' => $product->id]);
                }

                if ($package->price) {
                    $priceData = [
                        'product' => $product->id,
                        'unit_amount' => $package->price * 100,
                        'currency' => 'usd',
                        'recurring' => ['interval' => 'month', 'interval_count' => 1],
                    ];

                    $price = Price::create($priceData);
                }

                $package->update(['stripe_price_id' => $price->id ?? null]);

                $paypal_plan_id = null;

                $paypal = new PayPalClient;
                $paypal->setApiCredentials(config('paypal'));
                $token = $paypal->getAccessToken();
                $paypal->setAccessToken($token);

                if ($package->paypal_product_id) {
                    $product = $paypal->showProductDetails($package->paypal_product_id);
                    $paypal_plan_id = $product['id'] ?? null;
                }
                if (!$paypal_plan_id) {
                    $data = [
                        'name' => $packageName,
                        'type' => 'SERVICE',
                        'description' => $packageDescription,
                        'category' => 'SOFTWARE',
                    ];
                    $product = $paypal->createProduct($data);
                    $paypal_plan_id = $product['id'] ?? null;

                    $package->update(['paypal_product_id' => $paypal_plan_id]);
                }
                if ($paypal_plan_id && $package) {
                    if ($package->price > 0) {
                        $productId = $package->paypal_product_id;

                        $interval_count = 1;
                        $price = $package->price;

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

                        $plan = $paypal->createPlan($data);

                        if ($package == null) {
                            $plan['id'] = null;
                        } else {
                            $package->update(['paypal_price_id' => $plan['id']]);
                        }
                    } else {
                        $package->update(['paypal_price_id' => null]);
                    }
                }

                DB::commit();
            }
        }

        Stripe::setApiKey(env('STRIPE_SECRET'));

        $customer = Customer::create([
            'email' => $request->email ?? null,
            'payment_method' => $request->payment_method,
            'invoice_settings' => [
                'default_payment_method' => $request->payment_method,
            ],
        ]);

        $subscription = Subscription::create([
            'customer' => $customer->id,
            'items' => [[
                'price' => $package->stripe_price_id, // The recurring price ID from Stripe dashboard
            ]],
            'expand' => ['latest_invoice.payment_intent'],
        ]);

        return response()->json([
            'clientSecret' => $subscription->latest_invoice->payment_intent->client_secret,
            'subscriptionId' => $subscription->id
        ]);
    }

    public function paypalCancel()
    {
        return redirect()->route('web.coffee.index')->withErrors(['message' => 'Payment was cancelled by the user.']);
    }

    public function paypalSuccess(Request $request)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $paypalToken = $request->get('token');

        if (!$paypalToken) {
            return redirect()->route('web.coffee.index', ['lang' => getDefaultLanguage(1)])->withErrors(['message' => 'Missing PayPal token.']);
        }

        // Capture PayPal order
        $response = $provider->capturePaymentOrder($paypalToken);

        if (isset($response['status']) && $response['status'] === 'COMPLETED') {
            // Find wallet by PayPal token or set up token tracking during initial setup
            $wallet = CoffeeWallet::where('paypal_id', $paypalToken)->first();

            if ($wallet) {
                $wallet->status = 'completed';
                $wallet->paypal_id = $response['id'];
                $wallet->save();
            }

            return redirect()->route('web.coffee.index', ['lang' => getDefaultLanguage(1)])->with('success', 'Payment completed successfully via PayPal.');
        }

        return redirect()->route('web.coffee.index', ['lang' => getDefaultLanguage(1)])->withErrors(['message' => 'PayPal payment could not be completed.']);
    }
}
