<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerMessagingAppDetail extends Model
{
    use HasFactory;
    protected $fillable = ['messaging_app_detail_id','customer_id'];
    public function messaging_app_detail()
    {
        return $this->belongsTo(MessagingAppDetail::class,'messaging_app_detail_id','id');
    }
}
