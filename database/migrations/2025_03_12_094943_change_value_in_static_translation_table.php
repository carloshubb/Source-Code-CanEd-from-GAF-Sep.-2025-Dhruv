<?php

use App\Models\StaticTranslation;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        StaticTranslation::where('type', 'event')
            ->update(['type' => 'events']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Revert the update using Eloquent
        StaticTranslation::where('type', 'events')
            ->update(['type' => 'event']);
    }
};
