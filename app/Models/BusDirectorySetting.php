<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusDirectorySetting extends Model
{
    use HasFactory;
    protected $table = 'bus_directory_settings';
    public function busDirectorySettingDetail()
    {
        return $this->hasMany(BusDirectorySettingDetail::class);
    }
}
