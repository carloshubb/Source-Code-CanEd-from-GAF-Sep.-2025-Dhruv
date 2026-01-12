<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolRequestSetting extends Model
{
    use HasFactory;

    protected $table = 'school_request_settings';


    public function schoolRequestSettingDetail()
    {
        return $this->hasMany(SchoolRequestSettingDetail::class, "school_request_setting_id", "id");
    }
}
