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
        Schema::table('footer_settings', function (Blueprint $table) {
            $table->foreignId('menu1')->nullable()->constrained('menus')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('menu2')->nullable()->constrained('menus')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('menu3')->nullable()->constrained('menus')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('footer_settings', function (Blueprint $table) {
            //
        });
    }
};
