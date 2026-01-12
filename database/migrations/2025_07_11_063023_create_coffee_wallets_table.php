<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coffee_wallets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->boolean('anonymous')->default(false);
            $table->string('designation')->nullable();
            $table->foreignId('package_id')->nullable()->constrained()->nullOnDelete();
            $table->string('frequency')->nullable();
            $table->decimal('dr_amount', 10, 2)->default(0);
            $table->string('paypal_id')->nullable();
            $table->string('stripe_id')->nullable();
            $table->string('subscription_id')->nullable();
            $table->enum('payment_method', ['stripe', 'paypal'])->nullable();
            $table->string('status')->default('completed');
            $table->string('random_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('coffee_wallets');
    }
};
