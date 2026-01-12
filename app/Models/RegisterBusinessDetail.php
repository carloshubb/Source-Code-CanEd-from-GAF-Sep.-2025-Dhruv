<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegisterBusinessDetail extends Model
{
    use HasFactory;

    protected $table = 'register_business_details';

    protected $guarded = [];

    public $timestamps = false;

    public function registerBusinessSetting()
    {
        return $this->belongsTo(RegisterBusinessSetting::class);
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }
}
