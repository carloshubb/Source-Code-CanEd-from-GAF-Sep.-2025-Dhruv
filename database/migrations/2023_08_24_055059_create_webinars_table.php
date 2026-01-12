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
        Schema::create('webinars', function (Blueprint $table) {
            $table->id();
            $table->string('start_date');
            $table->string('timezone');
            $table->string('type');
            $table->string('duration');
            $table->string('webinar_link')->nullable();
            $table->string('particepents')->nullable();
            $table->string('image')->nullable();
            $table->json('zoho_webinar')->nullable();
            $table
            ->foreignId('customer_id')
            ->nullable()
            ->constrained('customers')
            ->onUpdate('cascade')
            ->onDelete('cascade');
            $table
            ->foreignId('school_id')
            ->nullable()
            ->constrained('schools')
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
        Schema::dropIfExists('webinars');
    }
};
