<?php

namespace Database\Seeders;

use App\Models\Setting;
use App\Services\PaypalService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Setting::truncate();
        Setting::create(['id' => 1, 'type' => 'general', 'key' => 'home_page_banner', 'value' => '']);
        Setting::create(['id' => 1, 'type' => 'general', 'key' => 'network_banner', 'value' => '']);
        Setting::create(['id' => 1, 'type' => 'general', 'key' => 'main_logo', 'value' => '']);
        Setting::create(['id' => 1, 'type' => 'general', 'key' => 'static_logo', 'value' => '']);
        Setting::create(['id' => 1, 'type' => 'general', 'key' => 'school_default_tab', 'value' => '']);
        Setting::create(['id' => 1, 'type' => 'general', 'key' => 'master_application_school_count', 'value' => '5']);
        Setting::create(['id' => 1, 'type' => 'general', 'key' => 'event_multiple_images_allowed', 'value' => '5']);

        Setting::create(['id' => 2, 'type' => 'admin_email', 'key' => 'admin_registration_email', 'value' => 'info@xlent.pk']);
        Setting::create([
            'key' => 'support_email',
            'type' => 'support_email',
            'value' => 'support@proximastudy.com',
        ]);

        Setting::create([
            'key' => 'free',
            'type' => 'package',
            'value' => 0,
        ]);
        Setting::create([
            'key' => 'featured',
            'type' => 'package',
            'value' => 10,
        ]);
        Setting::create([
            'key' => 'premium',
            'type' => 'package',
            'value' => 20,
        ]);

        Setting::create([
            'key' => 'stripe_featured_product',
            'type' => 'stripe_config',
            'value' => null,
        ]);
        Setting::create([
            'key' => 'stripe_premium_product',
            'type' => 'stripe_config',
            'value' => null,
        ]);

        Setting::create([
            'key' => 'paypal_featured_product',
            'type' => 'paypal_config',
            'value' => null,
        ]);
        Setting::create([
            'key' => 'paypal_premium_product',
            'type' => 'paypal_config',
            'value' => null,
        ]);

        // Setting::create([
        //     'key' => 'stripe_pay_to_go_product',
        //     'type' => 'stripe_config',
        //     'value' => null,
        // ]);

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
        $product = $stripe->products->create([
            'name' => 'Featured packages',
        ]);
        Setting::where('key', 'stripe_featured_product')
            ->where('type', 'stripe_config')
            ->update([
                'value' => $product->id,
            ]);

        $product = $stripe->products->create([
            'name' => 'Premium packages',
        ]);
        Setting::where('key', 'stripe_premium_product')
            ->where('type', 'stripe_config')
            ->update([
                'value' => $product->id,
            ]);
        Setting::create([
            'key' => 'general_form_submission_per_day',
            'type' => 'form_submission',
            'value' => 10,
        ]);
        $stripe->webhookEndpoints->create([
            'url' => route('stripe.webhook'),
            // 'url' => "https://xelenthost.com/stripe/webhook",
            'enabled_events' => ['customer.subscription.created', 'customer.subscription.deleted', 'customer.subscription.trial_will_end'],
        ]);
        $paypal = new PaypalService();

        Setting::where('key', 'paypal_featured_product')
            ->where('type', 'paypal_config')
            ->update([
                'value' => $paypal->createProduct([
                    'name' => 'Featured',
                    'type' => 'SERVICE', // or 'PHYSICAL', 'DIGITAL'
                    'description' => 'This is a Featured product.',
                    'category' => 'SOFTWARE', // Choose appropriate category
                ]),
            ]);

        Setting::where('key', 'paypal_premium_product')
            ->where('type', 'paypal_config')
            ->update([
                'value' => $paypal->createProduct([
                    'name' => 'Premium',
                    'type' => 'SERVICE', // or 'PHYSICAL', 'DIGITAL'
                    'description' => 'This is a Premium product.',
                    'category' => 'SOFTWARE', // Choose appropriate category
                ]),
            ]);

            $generalSetting = Setting::where('key', 'thumbnail_image_width')->where('type', 'media')->first();
        if (!$generalSetting) {
            Setting::create([
                'key' => 'thumbnail_image_width',
                'type' => 'media',
                'value' => null,
            ]);
        }
        $generalSetting = Setting::where('key', 'thumbnail_image_height')->where('type', 'media')->first();
        if (!$generalSetting) {
            Setting::create([
                'key' => 'thumbnail_image_height',
                'type' => 'media',
                'value' => null,
            ]);
        }
        $generalSetting = Setting::where('key', 'medium_image_width')->where('type', 'media')->first();
        if (!$generalSetting) {
            Setting::create([
                'key' => 'medium_image_width',
                'type' => 'media',
                'value' => null,
            ]);
        }
        $generalSetting = Setting::where('key', 'medium_image_height')->where('type', 'media')->first();
        if (!$generalSetting) {
            Setting::create([
                'key' => 'medium_image_height',
                'type' => 'media',
                'value' => null,
            ]);
        }
        $generalSetting = Setting::where('key', 'large_image_width')->where('type', 'media')->first();
        if (!$generalSetting) {
            Setting::create([
                'key' => 'large_image_width',
                'type' => 'media',
                'value' => null,
            ]);
        }
        $generalSetting = Setting::where('key', 'large_image_height')->where('type', 'media')->first();
        if (!$generalSetting) {
            Setting::create([
                'key' => 'large_image_height',
                'type' => 'media',
                'value' => null,
            ]);
        }
    }
}
