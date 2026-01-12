<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SugPageSettingDetail extends Model
{
    use HasFactory;

    protected $table = 'sug_page_setting_detail';

    protected $guarded = [];

    public $timestamps = false;

    public function sugPageSetting()
    {
        return $this->belongsTo(SugPageSetting::class);
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }
}
