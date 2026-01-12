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
                    ->where('type',  "toaster_messages")
                    ->update([
                        'display_text' =>'Success/Error messages'
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
                ->where('type', 'toaster_messages')
                ->update([
                    'display_text' => 'Toaster messages' // Replace with the original value
                ]);
        });
    }
};
