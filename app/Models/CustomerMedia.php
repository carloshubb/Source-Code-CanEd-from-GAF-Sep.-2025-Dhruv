<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerMedia extends Model
{
    use HasFactory;

    protected $table = 'customer_media';

    public $timestamps = false;

    protected $fillable = ['customer_id', 'logo', 'image_1', 'image_2', 'image_3', 'image_4', 'video'];

    public function customerLogo()
    {
        return $this->belongsTo(Media::class, 'logo', 'id');
    }

    public function customerImage1()
    {
        return $this->belongsTo(Media::class, 'image_1', 'id');
    }

    public function customerImage2()
    {
        return $this->belongsTo(Media::class, 'image_2', 'id');
    }

    public function customerImage3()
    {
        return $this->belongsTo(Media::class, 'image_3', 'id');
    }

    public function customerImage4()
    {
        return $this->belongsTo(Media::class, 'image_4', 'id');
    }
}
