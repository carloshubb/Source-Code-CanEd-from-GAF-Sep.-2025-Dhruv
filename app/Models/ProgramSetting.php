<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramSetting extends Model
{
    use HasFactory;
    public function programSettingDetail()
    {
        return $this->hasMany(ProgramSettingDetail::class, "program_setting_id", "id");
    }
}
