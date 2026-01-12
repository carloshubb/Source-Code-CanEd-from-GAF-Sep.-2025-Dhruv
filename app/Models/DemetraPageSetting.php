<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DemetraPageSetting extends Model
{
    use HasFactory;

    protected $table = 'demetra_page_setting';


    public function demetraPageSettingDetail()
    {
        return $this->hasMany(DemetraPageSettingDetail::class, "demetra_page_setting_id", "id");
    }
}
