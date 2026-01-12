<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoginPageDetailSetting extends Model
{
    use HasFactory;

    protected $table = 'login_page_detail_settings';

    protected $guarded = [];

    public $timestamps = false;

    public function loginPageSetting()
    {
        return $this->belongsTo(LoginPageSetting::class);
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }
    
}
