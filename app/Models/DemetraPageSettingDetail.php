<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DemetraPageSettingDetail extends Model
{
    use HasFactory;

    protected $table = 'demetra_page_setting_detail';

    protected $guarded = [];

    public $timestamps = false;

    public function demetraPageSetting()
    {
        return $this->belongsTo(DemetraPageSetting::class);
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }
}
