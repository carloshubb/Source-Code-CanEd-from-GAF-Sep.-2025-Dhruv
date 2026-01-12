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
        Schema::table('school_ambassadors', function (Blueprint $table) {
            $table->string('image')->nullable()->change();
            $table->string('region')->nullable()->change();
            $table->text('langs')->nullable()->change();
            $table->text('fav_module')->nullable()->change();
            $table->text('hobies_interests')->nullable()->change();
            $table->text('societies')->nullable()->change();
            $table->text('my_minor')->nullable()->change();
            $table->text('my_major')->nullable()->change();
            $table->text('degree_level')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('school_ambassadors', function (Blueprint $table) {
            $table->string('image')->nullable(false)->change();
            $table->string('region')->nullable(false)->change();
            $table->text('langs')->nullable(false)->change();
            $table->text('fav_module')->nullable(false)->change();
            $table->text('hobies_interests')->nullable(false)->change();
            $table->text('societies')->nullable(false)->change();
            $table->text('my_minor')->nullable(false)->change();
            $table->text('my_major')->nullable(false)->change();
            $table->text('degree_level')->nullable(false)->change();
        });
    }
};
