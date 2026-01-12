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
        Schema::dropIfExists('events');
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->text('start_date')->nullable();
            $table->text('end_date');
            $table->text('event_website')->nullable();
            $table->text('exibiters_url')->nullable();
            $table->text('visitor_url')->nullable();
            $table->text('press_url')->nullable();
            $table->text('video_url')->nullable();
            $table->text('contact_name')->nullable();
            $table->text('contact_email')->nullable();
            $table->text('contact_phone')->nullable();
            $table->text('contact_designation')->nullable();
            $table->text('facebook_url')->nullable();
            $table->text('instagram_url')->nullable();
            $table->text('linkedin_url')->nullable();
            $table->text('youtube_url')->nullable();
            $table->text('pintrest_url')->nullable();
            $table->text('snapchat_url')->nullable();
            $table->text('twitter_url')->nullable();
            $table->text('featured_image')->nullable();
            $table->boolean('status')->default(0);
            $table
            ->foreignId('customer_id')
            ->nullable()
            ->constrained('customers')
            ->onUpdate('cascade')
            ->onDelete('cascade');
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
        Schema::dropIfExists('events');
    }
};
