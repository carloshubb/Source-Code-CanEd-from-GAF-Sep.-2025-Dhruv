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
            $replacements = [
                'lable' => 'label',
                'canada' => 'Canada',
                'register_success_message' => 'register_student_success_message',
                'Register success message' => 'Register student success message',
            ];

            foreach ($replacements as $old => $new) {
                DB::table('static_translation_detail')
                    ->where('display_text', 'like', "%$old%")
                    ->update([
                        'display_text' => DB::raw("REPLACE(`display_text`, '$old', '$new')")
                    ]);

                DB::table('static_translation_detail')
                    ->where('key', 'like', "%$old%")
                    ->update([
                        'key' => DB::raw("REPLACE(`key`, '$old', '$new')")
                    ]);
            }
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
            $replacements = [
                'label' => 'lable',
                'Canada' => 'canada',
                'register_student_success_message' => 'register_success_message',
                'Register student success message' => 'Register success message',
            ];

            foreach ($replacements as $new => $old) {
                DB::table('static_translation_detail')
                    ->where('display_text', 'like', "%$new%")
                    ->update([
                        'display_text' => DB::raw("REPLACE(`display_text`, '$new', '$old')")
                    ]);

                DB::table('static_translation_detail')
                    ->where('key', 'like', "%$new%")
                    ->update([
                        'key' => DB::raw("REPLACE(`key`, '$new', '$old')")
                    ]);
            }
        });
    }
};
