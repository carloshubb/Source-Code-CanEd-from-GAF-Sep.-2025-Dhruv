<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusDirectorySettingDetail extends Model
{
    use HasFactory;

    protected $guarded = [];

    public $timestamps = false;
    protected $table = 'bus_directory_setting_details';
    public function busDirectorySetting()
    {
        return $this->belongsTo(BusinessDirectorySetting::class);
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }
}
