<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProximaMessage extends Model
{
    use HasFactory;

    protected $guarded = [];
    public function conversation(){
        return $this->belongsTo(ProximaConversation::class,'conversation_id','id');
    }
}
