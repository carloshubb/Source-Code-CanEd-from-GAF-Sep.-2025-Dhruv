<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramSettingDetail extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $guarded = [];

    public function programSetting()
    {
        return $this->belongsTo(ProgramSetting::class);
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }


}
