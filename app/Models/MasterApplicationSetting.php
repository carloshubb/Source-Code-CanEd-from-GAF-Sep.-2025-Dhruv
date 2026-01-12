<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterApplicationSetting extends Model
{
    use HasFactory;

    public function masterApplicationSettingDetail()
    {
        return $this->hasMany(MasterApplicationSettingDetail::class, "mas_app_stng_id", "id");
    }
}
