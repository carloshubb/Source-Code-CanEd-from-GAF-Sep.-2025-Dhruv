<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->string('slug')->nullable()->after('last_name');
        });

        // Existing records ke liye slug generate karna
        DB::table('customers')->get()->each(function ($customer) {
            if ($customer->user_type === 'student') {
                // Student ke liye slug first_name + last_name
                $slug = Str::slug($customer->first_name . ' ' . $customer->last_name);
            } elseif ($customer->user_type === 'school') {
                // School ke liye slug school_name se banana
                $school = DB::table('schools')->where('customer_id', $customer->id)->first();
                
                if ($school) {
                    $schoolDetail = DB::table('school_details')->where('school_id', $school->id)->first();
                    
                    if ($schoolDetail) {
                        $slug = Str::slug($schoolDetail->school_name);
                    } else {
                        $slug = null;
                    }
                } else {
                    $slug = null;
                }
            } elseif ($customer->user_type === 'business') {
                // Business ke liye slug business_name se banana
                $business = DB::table('businesses')->where('customer_id', $customer->id)->first();
                
                if ($business) {
                    $businessDetail = DB::table('business_details')->where('business_id', $business->id)->first();
                    
                    if ($businessDetail) {
                        $slug = Str::slug($businessDetail->business_name);
                    } else {
                        $slug = null;
                    }
                } else {
                    $slug = null;
                }
            } else {
                $slug = null;
            }

            // Slug update karein
            DB::table('customers')
                ->where('id', $customer->id)
                ->update(['slug' => $slug]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->dropColumn('slug');
        });
    }
};
