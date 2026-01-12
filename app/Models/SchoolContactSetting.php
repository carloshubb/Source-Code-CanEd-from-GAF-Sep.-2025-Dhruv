<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolContactSetting extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function schoolContactSettingDetail()
    {
        return $this->hasMany(SchoolContactSettingDetail::class);
    }
}
