<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SugPageSetting extends Model
{
    use HasFactory;

    protected $table = 'sug_page_setting';


    public function sugPageSettingDetail()
    {
        return $this->hasMany(SugPageSettingDetail::class, "sug_page_setting_id", "id");
    }
}
