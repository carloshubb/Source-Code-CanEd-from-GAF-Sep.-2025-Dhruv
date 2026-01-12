<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolAmbassadorSetting extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function schoolAmbassadorSettingDetail()
    {
        return $this->hasMany(SchoolAmbassadorSettingDetail::class, 'ambassador_setting_id');
    }
}
