<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdmissionSetting extends Model
{
    use HasFactory;
    protected $fillable = [
        'customer_id',
        'school_id',
        'admission_apply_button_title',
        'admission_apply_button_link',
        'admission_blue_bar_button_title',
        'admission_blue_bar_button_link',
        'admission_red_bar_button_title',
        'admission_red_bar_button_link',
    ];
    public function admissionSettingDetail()
    {
        return $this->hasMany(AdmissionSettingDetail::class, "admission_setting_id", "id");
    }
}
