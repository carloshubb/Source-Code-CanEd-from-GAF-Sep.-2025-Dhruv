<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolRequestSettingDetail extends Model
{
    use HasFactory;

    protected $table = 'school_request_setting_details';

    protected $guarded = [];

    public $timestamps = false;

    public function schoolRequestSetting()
    {
        return $this->belongsTo(SchoolRequest::class);
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }
}
