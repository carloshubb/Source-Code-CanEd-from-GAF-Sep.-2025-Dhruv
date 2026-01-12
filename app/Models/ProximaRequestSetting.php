<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProximaRequestSetting extends Model
{
    use HasFactory;

    public function proximaRequestSettingDetail()
    {
        return $this->hasMany(ProximaRequestSettingDetail::class, "prox_req_set_id", "id");
    }
}
