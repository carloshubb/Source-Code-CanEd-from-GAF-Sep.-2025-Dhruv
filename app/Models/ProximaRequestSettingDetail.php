<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProximaRequestSettingDetail extends Model
{
    use HasFactory;

    protected $guarded = [];

    public $timestamps = false;

    public function proximaRequestSetting()
    {
        return $this->belongsTo(ProximaRequest::class);
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }
}
