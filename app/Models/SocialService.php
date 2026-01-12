<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocialService extends Model
{
    use HasFactory;
    protected $fillable = ['status'];

    public function socialServiceDetail()
    {
        return $this->hasMany(SocialServiceDetail::class, 'social_service_id', 'id');
    }
}
