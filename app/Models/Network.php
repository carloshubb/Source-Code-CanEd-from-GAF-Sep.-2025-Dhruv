<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Network extends Model
{
    use HasFactory;

    protected $fillable = [
        'banner_location',
        'state_province',
        'phone_number',
        'email',
        'country',
        'image',
        'status',
        'customer_id'
        
    ];

    public function networkDetail()
    {
        return $this->hasMany(NetworkDetail::class, "network_id", "id");
    }
    public function networkImage()
    {
        return $this->hasOne(Media::class, 'id', 'image');
    }
}
