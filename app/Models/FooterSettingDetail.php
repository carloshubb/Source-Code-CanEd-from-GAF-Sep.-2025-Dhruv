<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FooterSettingDetail extends Model
{
    use HasFactory;

    protected $guarded = [];

    public $timestamps = false;

    public function footerSetting()
    {
        return $this->belongsTo(FooterSetting::class);
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }
}
