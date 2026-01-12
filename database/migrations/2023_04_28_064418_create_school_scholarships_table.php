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
        Schema::create('school_scholarships', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->nullable()->constrained('customers')->onUpdate('cascade')->onDelete('cascade');
            $table->text('province')->nullable();
            $table->text('award')->nullable();
            $table->text('amount')->nullable();
            $table->text('action')->nullable();
            $table->text('date_posted')->nullable();
            $table->text('expiry_date')->nullable();
            $table->text('deadline_date')->nullable();
            $table->text('availability')->nullable();
            $table->text('study_level')->nullable();
            $table->text('duration')->nullable();
            $table->text('link')->nullable();
            $table->text('more_info_link')->nullable();
            $table->boolean('featured')->default(0);
            $table->text('image')->nullable();
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
        Schema::dropIfExists('school_scholarships');
    }
};
