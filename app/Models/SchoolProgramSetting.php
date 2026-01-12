<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolProgramSetting extends Model
{
    use HasFactory;

    protected $guarded = [];
    public function schoolProgramSettingDetail()
    {
        return $this->hasMany(SchoolProgramSettingDetail::class);
    }
}
