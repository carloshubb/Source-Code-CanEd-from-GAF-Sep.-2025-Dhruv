<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IsLoginModalSettingDetail extends Model
{
    use HasFactory;
    protected $table = 'is_login_modal_setting_details';
    public $timestamps = false;
    protected $guarded = [];

    public function isLoginModalSetting()
    {
        return $this->belongsTo(IsLoginModalRequest::class);
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }
}
