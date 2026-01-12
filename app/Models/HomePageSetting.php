<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomePageSetting extends Model
{
    use HasFactory;
    protected $table = 'home_page_settings';
    protected $guarded = [];
    
    public function homePageSettingDetail()
    {
        return $this->hasMany(HomePageSettingDetail::class, "home_page_setting_id", "id");
    }

    public function banner1()
    {
        return $this->hasOne(Banner::class, "id", "banner_1");
    }

    public function banner2()
    {
        return $this->hasOne(Banner::class, "id", "banner_2");
    }

    public function banner3()
    {
        return $this->hasOne(Banner::class, "id", "banner_3");
    }
}
