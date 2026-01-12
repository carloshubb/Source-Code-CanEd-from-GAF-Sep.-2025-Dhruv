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
            $static = DB::table('static_translation')->where('type', "program")->first();

            if ($static) {
                $updates = [
                    ['key' => 'modal_title', 'display_text' => 'Program suggestion Modal title', 'new_key' => 'program_suggestion_modal_title'],
                    ['key' => 'close_modal_button_text', 'display_text' => 'Program suggestion Close modal button text', 'new_key' => 'program_suggestion_close_modal_button_text'],
                    ['key' => 'description_input_placeholder', 'display_text' => 'Program suggestion description input placeholder', 'new_key' => 'program_suggestion_description_input_placeholder'],
                    ['key' => 'degree_input_placeholder', 'display_text' => 'Program suggestion degree input placeholder', 'new_key' => 'program_suggestion_degree_input_placeholder'],
                    ['key' => 'name_input_placeholder', 'display_text' => 'Program suggestion name input placeholder', 'new_key' => 'program_suggestion_name_input_placeholder'],
                    ['key' => 'submit_button_text', 'display_text' => 'Program suggestion submit button text', 'new_key' => 'program_suggestion_submit_button_text'],
                    ['key' => 'name_input_label', 'display_text' => 'Program suggestion name input label', 'new_key' => 'program_suggestion_name_input_label'],
                    ['key' => 'description_input_label', 'display_text' => 'Program suggestion description input label', 'new_key' => 'program_suggestion_description_input_label'],
                    ['key' => 'degree_input_label', 'display_text' => 'Program suggestion degree input label', 'new_key' => 'program_suggestion_degree_input_label'],
                ];

                foreach ($updates as $update) {
                    DB::table('static_translation_detail')
                        ->where('static_translation_id', $static->id)
                        ->where('key', $update['key'])
                        ->update([
                            'display_text' => $update['display_text'],
                            'key' => $update['new_key'],
                        ]);
                }
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
            $static = DB::table('static_translation')->where('type', "program")->first();
    
            if ($static) {
                $reverts = [
                    ['new_key' => 'program_suggestion_modal_title', 'key' => 'modal_title', 'display_text' => ' modal title'],
                    ['new_key' => 'program_suggestion_close_modal_button_text', 'key' => 'close_modal_button_text', 'display_text' => ' close modal button text'],
                    ['new_key' => 'program_suggestion_description_input_placeholder', 'key' => 'description_input_placeholder', 'display_text' => ' description input placeholder'],
                    ['new_key' => 'program_suggestion_degree_input_placeholder', 'key' => 'degree_input_placeholder', 'display_text' => ' degree input placeholder'],
                    ['new_key' => 'program_suggestion_name_input_placeholder', 'key' => 'name_input_placeholder', 'display_text' => ' name input placeholder'],
                    ['new_key' => 'program_suggestion_submit_button_text', 'key' => 'submit_button_text', 'display_text' => ' submit button text'],
                    ['new_key' => 'program_suggestion_name_input_label', 'key' => 'name_input_label', 'display_text' => ' name input label'],
                    ['new_key' => 'program_suggestion_description_input_label', 'key' => 'description_input_label', 'display_text' => ' description input label'],
                    ['new_key' => 'program_suggestion_degree_input_label', 'key' => 'degree_input_label', 'display_text' => ' degree input label'],
                ];
    
                foreach ($reverts as $revert) {
                    DB::table('static_translation_detail')
                        ->where('static_translation_id', $static->id)
                        ->where('key', $revert['new_key'])
                        ->update([
                            'display_text' => $revert['display_text'],
                            'key' => $revert['key'],
                        ]);
                }
            }
        });
    }
    
};
