<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FooterSetting extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function footerSettingDetail()
    {
        return $this->hasMany(FooterSettingDetail::class, "footer_setting_id", "id");
    }

    public function menu_1()
    {
        return $this->belongsTo(Menu::class, 'menu1');
    }

    public function menu_2()
    {
        return $this->belongsTo(Menu::class, 'menu2');
    }


    public function menu_3()
    {
        return $this->belongsTo(Menu::class, 'menu3');
    }
}
