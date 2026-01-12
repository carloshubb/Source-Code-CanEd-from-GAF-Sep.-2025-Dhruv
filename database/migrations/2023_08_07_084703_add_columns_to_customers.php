<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->string('registration_package_id')->nullable();
            $table->string('package_price')->nullable();
            $table->string('free_subscription_days')->nullable();
            $table->string('package_subscribed_date')->nullable();
            $table->string('package_expiry_date')->nullable();
            $table->string('stripe_customer_id')->nullable();
            $table->string('payment_method_id')->nullable();
            $table->string('subscription_id')->nullable();
            $table->string('payment_method')->nullable();
            $table->string('stripe_item_id')->nullable();            
            $table->boolean('is_package_amount_paid')->default(0);
            $table->boolean('is_auto_renew')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customers', function (Blueprint $table) {
            //
        });
    }
};
