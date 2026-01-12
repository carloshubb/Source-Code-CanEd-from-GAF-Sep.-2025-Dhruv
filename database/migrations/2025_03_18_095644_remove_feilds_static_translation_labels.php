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
           

                DB::table('static_translation_detail')
                    ->where('key',  "level_label_text")
                    ->delete();


                DB::table('static_translation_detail')
                    ->where('key',  "h_structure_label_text")
                    ->delete();


                DB::table('static_translation_detail')
                    ->where('key',  "code_label_text")
                    ->delete();

             
        });
    }

   
};
