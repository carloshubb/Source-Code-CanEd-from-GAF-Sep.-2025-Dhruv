<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScholarshipSetting extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function scholarshipSettingDetail()
    {
        return $this->hasMany(ScholarshipSettingDetail::class);
    }
}
