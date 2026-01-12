<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomePageSettingDetail extends Model
{
    use HasFactory;
    protected $table = 'home_page_setting_details';
    public $timestamps = false;
    protected $guarded = [];
}
