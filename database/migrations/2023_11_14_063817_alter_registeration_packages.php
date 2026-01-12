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
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('registration_packages');
        Schema::dropIfExists('registration_package_detail');
        Schema::dropIfExists('registration_package_features');
        Schema::enableForeignKeyConstraints();
        
        Schema::create('registration_packages', function(Blueprint $table){
            $table->id();
            $table->string('sorting_order')->nullable();
            $table->enum('package_type', ['free', 'featured', 'premium'])->nullable();
            $table->enum('type', ['school', 'business', 'student'])->nullable();
            $table->boolean('is_default')->default(0);
            $table->string('images')->default(0);
            $table->string('ambassadors')->default(0);
            $table->string('webinars')->default(0);
            $table->string('articles')->default(0);
            $table->string('events')->default(0);
            $table->float('monthly_price', 11, 2)->default(0);
            $table->float('quarterly_price', 11, 2)->default(0);
            $table->float('semi_annually_price', 11, 2)->default(0);
            $table->float('annually_price', 11, 2)->default(0);
            $table->string('stripe_monthly_id')->nullable();
            $table->string('stripe_quarterly_id')->nullable();
            $table->string('stripe_semi_annually_id')->nullable();
            $table->string('stripe_annually_id')->nullable();
            $table->string('paypal_auto_renew_monthly_id')->nullable();
            $table->string('paypal_auto_renew_quarterly_id')->nullable();
            $table->string('paypal_auto_renew_semi_annually_id')->nullable();
            $table->string('paypal_auto_renew_annually_id')->nullable();
            $table->string('paypal_non_auto_renew_monthly_id')->nullable();
            $table->string('paypal_non_auto_renew_quarterly_id')->nullable();
            $table->string('paypal_non_auto_renew_semi_annually_id')->nullable();
            $table->string('paypal_non_auto_renew_annually_id')->nullable();
            $table->timestamps();
        });
        
        Schema::create('registration_package_detail', function(Blueprint $table){
            $table->id();
            $table->foreignId('registration_package_id')->nullable()->constrained('registration_packages')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('language_id')->nullable()->constrained('languages')->onUpdate('cascade')->onDelete('cascade');
            $table->string('name');
            $table->text('short_description', 500)->nullable();
        });

        Schema::create('registration_package_features', function (Blueprint $table) {
            $table->id();
            $table->foreignId('registration_package_id')->nullable()->constrained('registration_packages')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('language_id')->nullable()->constrained('languages')->onUpdate('cascade')->onDelete('cascade');
            $table->string('name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('registration_packages');
        Schema::dropIfExists('registration_package_detail');
        Schema::dropIfExists('registration_package_features');
        Schema::enableForeignKeyConstraints();
    }
};
