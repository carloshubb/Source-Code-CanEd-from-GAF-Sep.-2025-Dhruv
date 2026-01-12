<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::transaction(function () {
           

                DB::table('static_translation')
                    ->where('type',  "forget_password")
                    ->update([
                        'display_text' =>'Forgot / Reset password'
                    ]);

             
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::transaction(function () {
            DB::table('static_translation')
                ->where('type', 'forget_password')
                ->update([
                    'display_text' => 'Advance Search Static Translations' // Replace with the original value
                ]);
        });
    }
};
