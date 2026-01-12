<?php

namespace App\Services;

use App\Models\Customer;
use App\Models\CustomerPaymentMethod;
use App\Models\Order;
use App\Models\RegistrationPackage;
use DateTime;
use Illuminate\Support\Facades\Auth;

class StripeService
{
    public function createPrices($request, $packageName, $registrationPackage, $source = 'store')
    {
        if ($request->package_type == 'free') {
            $setting = getSignleGeneralSettingByKey(['stripe_free_product']);
            $productId = $setting['stripe_free_product'];
        } else if ($request->package_type == 'featured') {
            $setting = getSignleGeneralSettingByKey(['stripe_featured_product']);
            $productId = $setting['stripe_featured_product'];
        } else if ($request->package_type == 'premium') {
            $setting = getSignleGeneralSettingByKey(['stripe_premium_product']);
            $productId = $setting['stripe_premium_product'];
        } else if ($request->package_type == 'pay_to_go') {
            $setting = getSignleGeneralSettingByKey(['stripe_pay_to_go_product']);
            $productId = $setting['stripe_pay_to_go_product'];
        }
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
        $price = [];
        $price['nickname'] = $packageName . ' for monthly';
        $price['unit_amount'] = ($request->monthly_price) * 100;
        $price['currency'] = 'usd';
        $price['recurring'] = ['interval' => 'month', "interval_count" => 1];
        $price['product'] = $productId;
        $prices = $stripe->prices->create($price);

        $registrationPackage->update(['stripe_monthly_id' => $prices->id]);


        $price['nickname'] = $packageName . ' for quarterly';
        $price['unit_amount'] = ($request->quarterly_price * 3) * 100;
        $price['currency'] = 'usd';
        $price['recurring'] = ['interval' => 'month', "interval_count" => 3];
        $price['product'] = $productId;
        $prices = $stripe->prices->create($price);

        $registrationPackage->update(['stripe_quarterly_id' => $prices->id]);


        $price['nickname'] = $packageName . ' for semi annually';
        $price['unit_amount'] = ($request->semi_annually_price * 6) * 100;
        $price['currency'] = 'usd';
        $price['recurring'] = ['interval' => 'month', "interval_count" => 6];
        $price['product'] = $productId;
        $prices = $stripe->prices->create($price);

        $registrationPackage->update(['stripe_semi_annually_id' => $prices->id]);


        $price['nickname'] = $packageName . ' for annually';
        $price['unit_amount'] = ($request->annually_price * 12) * 100;
        $price['currency'] = 'usd';
        $price['recurring'] = ['interval' => 'month', "interval_count" => 12];
        $price['product'] = $productId;
        $prices = $stripe->prices->create($price);

        $registrationPackage->update(['stripe_annually_id' => $prices->id]);
    }

    public function createMonthlyStripePrices($request, $packageName, $registrationPackage)
    {
        if ($request->package_type == 'free') {
            $setting = getSignleGeneralSettingByKey(['stripe_free_product']);
            $productId = $setting['stripe_free_product'];
        } else if ($request->package_type == 'featured') {
            $setting = getSignleGeneralSettingByKey(['stripe_featured_product']);
            $productId = $setting['stripe_featured_product'];
        } else if ($request->package_type == 'premium') {
            $setting = getSignleGeneralSettingByKey(['stripe_premium_product']);
            $productId = $setting['stripe_premium_product'];
        } else if ($request->package_type == 'pay_to_go') {
            $setting = getSignleGeneralSettingByKey(['stripe_pay_to_go_product']);
            $productId = $setting['stripe_pay_to_go_product'];
        }
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
        $price = [];
        $price['nickname'] = $packageName . ' for monthly';
        $price['unit_amount'] = ($request->monthly_price) * 100;
        $price['currency'] = 'usd';
        $price['recurring'] = ['interval' => 'month', "interval_count" => 1];
        $price['product'] = $productId;
        $prices = $stripe->prices->create($price);

        $registrationPackage->update(['stripe_monthly_id' => $prices->id]);
    }

    public function createQuarterlyStripePrices($request, $packageName, $registrationPackage)
    {
        if ($request->package_type == 'free') {
            $setting = getSignleGeneralSettingByKey(['stripe_free_product']);
            $productId = $setting['stripe_free_product'];
        } else if ($request->package_type == 'featured') {
            $setting = getSignleGeneralSettingByKey(['stripe_featured_product']);
            $productId = $setting['stripe_featured_product'];
        } else if ($request->package_type == 'premium') {
            $setting = getSignleGeneralSettingByKey(['stripe_premium_product']);
            $productId = $setting['stripe_premium_product'];
        }
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
        $price = [];
        $price['nickname'] = $packageName . ' for quarterly';
        $price['unit_amount'] = ($request->quarterly_price * 3) * 100;
        $price['currency'] = 'usd';
        $price['recurring'] = ['interval' => 'month', "interval_count" => 3];
        $price['product'] = $productId;
        $prices = $stripe->prices->create($price);

        $registrationPackage->update(['stripe_quarterly_id' => $prices->id]);
    }

    public function createSemiAnnuallyStripePrices($request, $packageName, $registrationPackage)
    {
        if ($request->package_type == 'free') {
            $setting = getSignleGeneralSettingByKey(['stripe_free_product']);
            $productId = $setting['stripe_free_product'];
        } else if ($request->package_type == 'featured') {
            $setting = getSignleGeneralSettingByKey(['stripe_featured_product']);
            $productId = $setting['stripe_featured_product'];
        } else if ($request->package_type == 'premium') {
            $setting = getSignleGeneralSettingByKey(['stripe_premium_product']);
            $productId = $setting['stripe_premium_product'];
        }
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
        $price = [];
        $price['nickname'] = $packageName . ' for semi annually';
        $price['unit_amount'] = ($request->semi_annually_price * 6) * 100;
        $price['currency'] = 'usd';
        $price['recurring'] = ['interval' => 'month', "interval_count" => 6];
        $price['product'] = $productId;
        $prices = $stripe->prices->create($price);

        $registrationPackage->update(['stripe_semi_annually_id' => $prices->id]);
    }

    public function createAnnuallyStripePrices($request, $packageName, $registrationPackage)
    {
        if ($request->package_type == 'free') {
            $setting = getSignleGeneralSettingByKey(['stripe_free_product']);
            $productId = $setting['stripe_free_product'];
        } else if ($request->package_type == 'featured') {
            $setting = getSignleGeneralSettingByKey(['stripe_featured_product']);
            $productId = $setting['stripe_featured_product'];
        } else if ($request->package_type == 'premium') {
            $setting = getSignleGeneralSettingByKey(['stripe_premium_product']);
            $productId = $setting['stripe_premium_product'];
        }
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
        $price = [];
        $price['nickname'] = $packageName . ' for annually';
        $price['unit_amount'] = ($request->annually_price * 12) * 100;
        $price['currency'] = 'usd';
        $price['recurring'] = ['interval' => 'month', "interval_count" => 12];
        $price['product'] = $productId;
        $prices = $stripe->prices->create($price);

        $registrationPackage->update(['stripe_annually_id' => $prices->id]);
    }


    public function registrationPayment($package, $user, $request)
    {
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
        $cancel_at_period_end = true;
        if ($user->is_auto_renew == '1') {
            $cancel_at_period_end = false;
        }
        $stripeCustomer = $stripe->customers->create([
            'name' => $user->name,
            'email' => $user->email,
        ]);

        Customer::whereId($user->id)->update(['stripe_customer_id' => $stripeCustomer->id]);

        $customerPaymentMethod = CustomerPaymentMethod::whereCustomerId(Auth::guard('customers')->user()->id)->where('card_no', $request->card_no)->first();

        if ($customerPaymentMethod) {
            $paymentMethodId = $customerPaymentMethod->payment_method_id;
        } else {
            $paymentMethods = $stripe->paymentMethods->create([
                'type' => 'card',
                'card' => [
                    'number' => $request->card_no,
                    'exp_month' => $request->expiry_month,
                    'exp_year' => $request->expiry_year,
                    'cvc' => $request->cvc,
                ],
            ]);
            $paymentMethodId = $paymentMethods->id;
        }


        // Attach a payment method to the customer
        $paymentMethod = $stripe->paymentMethods->attach(
            $paymentMethodId,
            ['customer' => $stripeCustomer->id]
        );

        // Set the attached payment method as the default for the customer
        $stripe->customers->update(
            $stripeCustomer->id,
            ['invoice_settings' => ['default_payment_method' => $paymentMethod->id]]
        );

        if($user->payment_frequency == 'monthly'){
            $stripe_price_id = $package->stripe_monthly_id;
        }
        else if($user->payment_frequency == 'quarterly'){
            $stripe_price_id = $package->stripe_quarterly_id;
        }
        else if($user->payment_frequency == 'semi_annually'){
            $stripe_price_id = $package->stripe_semi_annually_id;
        }
        else if($user->payment_frequency == 'annually'){
            $stripe_price_id = $package->stripe_annually_id;
        }

        $subscription = $stripe->subscriptions->create([
            'customer' => $stripeCustomer->id,
            'items' => [
                ['price' => $stripe_price_id],
            ],
            'cancel_at_period_end' => $cancel_at_period_end
        ]);

        $customerPaymentMethod = CustomerPaymentMethod::create([
            'customer_id' => Auth::guard('customers')->user()->id,
            'payment_method' => 'stripe',
            'payment_method_id' => $paymentMethodId,
            'card_holder_name' => $request->card_holder_name,
            'card_no' => $request->card_no,
            'exp_month' => $request->expiry_month,
            'exp_year' => $request->expiry_year,
            'cvc' => $request->cvc,
            'is_default' => 1,
        ]);

        CustomerPaymentMethod::where('id', '!=', $customerPaymentMethod->id)->update([
            'is_default' => 0,
        ]);
        return ['subscription_id' => $subscription->id, 'stripe_item_id' => isset($subscription->items->data[0]) ? $subscription->items->data[0]->id : null];
    }

    public function upgradeUserAccount($request, $user, $package)
    {
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
        if ($request->customer_payment_method_id == 'add_new_card') {
            $paymentMethods = $stripe->paymentMethods->create([
                'type' => 'card',
                'card' => [
                    'number' => $request->card_no,
                    'exp_month' => $request->expiry_month,
                    'exp_year' => $request->expiry_year,
                    'cvc' => $request->cvc,
                ],
            ]);
            $paymentMethodId = $paymentMethods->id;
        } else {
            $customerPaymentMethod = CustomerPaymentMethod::whereId($request->customer_payment_method_id)->first();
            $paymentMethodId = $customerPaymentMethod->payment_method_id;
           
        }

        if ($user->stripe_customer_id != '' && $user->stripe_customer_id != null) {
            // Attach a payment method to the customer
            $stripe->paymentMethods->attach(
                $paymentMethodId,
                ['customer' => $user->stripe_customer_id]
            );
            $stripe_customer_id = $user->stripe_customer_id;
        } else {
            $stripeCustomer = $stripe->customers->create([
                'name' => $user->name,
                'email' => $user->email,
            ]);
            $stripe_customer_id = $stripeCustomer->id;

            Customer::whereId($user->id)->update([
                'stripe_customer_id' => $stripeCustomer->id
            ]);

            // Attach a payment method to the customer
            $paymentMethod = $stripe->paymentMethods->attach(
                $paymentMethodId,
                ['customer' => $stripeCustomer->id]
            );

            // Set the attached payment method as the default for the customer
            $stripe->customers->update(
                $stripeCustomer->id,
                ['invoice_settings' => ['default_payment_method' => $paymentMethod->id]]
            );
        }
        if($user->payment_frequency == 'monthly'){
            $stripe_price_id = $package->stripe_monthly_id;
        }
        else if($user->payment_frequency == 'quarterly'){
            $stripe_price_id = $package->stripe_quarterly_id;
        }
        else if($user->payment_frequency == 'semi_annually'){
            $stripe_price_id = $package->stripe_semi_annually_id;
        }
        else if($user->payment_frequency == 'annually'){
            $stripe_price_id = $package->stripe_annually_id;
        }
        if ($package->stripe_price_id) {
            $stripePrice = $stripe->prices->retrieve(
                $package->stripe_price_id,
                []
            );
            if ($stripePrice->active != true) {
                return [
                    'status' => 'error',
                    'message' => 'We are having trouble while process, contact with admin.',
                ];
            }
        }

        if ($user->subscription_id != '' && $user->subscription_id != null) {
            // Update the subscription with the new payment method
            $stripe->subscriptions->update(
                $user->subscription_id,
                ['default_payment_method' => $paymentMethodId]
            );

            $subscriptions = $stripe->subscriptions->update(
                $user->subscription_id,
                [
                    'items' => [
                        [
                            'id' => $user->stripe_item_id,
                            'deleted' => true,
                        ],
                        ['price' => $stripe_price_id],
                    ],
                ]
            );
        } else {
            $cancel_at_period_end = true;
            if ($user->is_auto_renew == '1') {
                $cancel_at_period_end = false;
            }

            $subscriptions = $stripe->subscriptions->create([
                'customer' => $stripe_customer_id,
                'items' => [
                    ['price' => $stripe_price_id],
                ],
                'trial_period_days' => $package->free_subscription_days,
                'cancel_at_period_end' => $cancel_at_period_end
            ]);
        }




        $currentDate = date('Y-m-d');
        $oldExpiryDate = $user->package_subscribed_date;

        // Convert the dates to DateTime objects
        $date1 = new DateTime($currentDate);
        $date2 = new DateTime($oldExpiryDate);

        // Calculate the difference between the two dates
        $interval = $date1->diff($date2);

        // Get the difference in days
        $packageUsed = $interval->days;

        $pkg = RegistrationPackage::whereId($request->registration_package_id)->first();
        if ($pkg) {
            $days = $pkg->package_validity_months * 30;
            $remainingDays = $days - $packageUsed;
            $expiryDate = date('Y-m-d', strtotime($remainingDays . ' days'));
        }


        Customer::whereId($user->id)->update([
            'payment_method' => 'stripe',
            'package_price' => isset($package->discount_price) && $package->discount_price > 0 ? $package->discount_price : $package->price,
            'package_expiry_date' => $expiryDate,
            'registration_package_id' => $request->registration_package_id,
            'subscription_id' => $subscriptions->id,
            'stripe_item_id' => isset($subscriptions->items->data[0]) ? $subscriptions->items->data[0]->id : null,
        ]);

        $customerPaymentMethod = CustomerPaymentMethod::where('payment_method_id', $paymentMethodId)->first();
        if (!$customerPaymentMethod) {
            $customerPaymentMethod = CustomerPaymentMethod::create([
                'customer_id' => Auth::guard('customers')->user()->id,
                'payment_method' => 'stripe',
                'payment_method_id' => $paymentMethodId,
                'card_holder_name' => $request->card_holder_name,
                'card_no' => $request->card_no,
                'exp_month' => $request->expiry_month,
                'exp_year' => $request->expiry_year,
                'cvc' => $request->cvc,
                'is_default' => 1,
            ]);

            CustomerPaymentMethod::where('id', '!=', $customerPaymentMethod->id)->update([
                'is_default' => 0,
            ]);
        }

        return [
            'status' => 'success',
            'message' => 'We are having trouble while process, contact with admin.',
        ];
    }
}
