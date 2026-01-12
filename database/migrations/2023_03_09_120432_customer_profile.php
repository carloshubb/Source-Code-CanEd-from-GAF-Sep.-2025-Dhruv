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
        Schema::create('customer_profile', function (Blueprint $table) {
            $table->id();
            $table->text('company_name');
            $table->text('company_email');
            $table->longText('short_description')->nullable();
            $table->longText('description')->nullable();
            $table->text('phone', 20)->nullable();
            $table->text('website', 500)->nullable();
            $table->json('keywords')->nullable();
            $table->text('address', 500)->nullable();
            $table->foreignId('customer_id')->nullable()->constrained('customers')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customer_profile');
    }
};
