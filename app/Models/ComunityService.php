<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComunityService extends Model
{
    use HasFactory;
    protected $fillable = ['status'];

    public function comunityServiceDetail()
    {
        return $this->hasMany(ComunityServiceDetail::class, 'comunity_service_id', 'id');
    }
}
