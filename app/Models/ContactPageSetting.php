<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactPageSetting extends Model
{
    use HasFactory;

    public function contactPageSettingDetail()
    {
        return $this->hasMany(ContactPageSettingDetail::class, "contact_page_setting_id", "id");
    }
}
