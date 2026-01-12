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
        Schema::create('overview_programs', function (Blueprint $table) {
            $table->id();
            $table->string('length');
            $table->string('tuition_inter_stu_fee');
            $table->string('tuition_can_stu_fee');
            $table->string('tuition_prov_stu_fee');
            $table
                ->foreignId('school_overviews_id')
                ->nullable()
                ->constrained('school_overviews')
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
        Schema::dropIfExists('overview_programs');
    }
};
