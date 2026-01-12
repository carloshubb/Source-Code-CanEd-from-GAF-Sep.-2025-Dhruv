<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IsLoginModalSetting extends Model
{
    use HasFactory;
    protected $table = 'is_login_modal_settings';
    
    public function isLoginModalSettingDetail()
    {
        return $this->hasMany(IsLoginModalSettingDetail::class, "is_login_modal_setting_id", "id");
    }
}
