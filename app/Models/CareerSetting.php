<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CareerSetting extends Model
{
    use HasFactory;

    public function careerSettingDetail()
    {
        return $this->hasMany(CareerSettingDetail::class);
    }
}
