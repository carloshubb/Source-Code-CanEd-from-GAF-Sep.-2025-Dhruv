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
        Schema::table('admission_settings', function (Blueprint $table) {
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
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('add_school_id_to_admission_settings');
    }
};
