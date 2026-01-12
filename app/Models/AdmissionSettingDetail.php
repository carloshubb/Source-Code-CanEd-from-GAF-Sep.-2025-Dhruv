<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdmissionSettingDetail extends Model
{
    use HasFactory;

    protected $guarded = [];

    public $timestamps = false;

    public function admissionSetting()
    {
        return $this->belongsTo(AdmissionPageSetting::class);
    }
}
