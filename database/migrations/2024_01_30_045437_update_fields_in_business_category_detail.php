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
        Schema::table('business_category_detail', function (Blueprint $table) {
            $table->text('name')->nullable()->change();
            $table->text('slug')->nullable()->change();
        });

        Schema::table('business_categories', function (Blueprint $table) {
            $table->string('image')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('business_category_detail', function (Blueprint $table) {
            $table->text('name')->change();
            $table->text('slug')->change();
        });

        Schema::table('business_categories', function (Blueprint $table) {
            $table->string('image')->change();
        });
    }
};
