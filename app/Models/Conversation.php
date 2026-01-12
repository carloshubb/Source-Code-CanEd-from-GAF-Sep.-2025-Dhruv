<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    use HasFactory;
    protected $guarded = [];
    
    public function customer(){
        return $this->belongsTo(Customer::class,'customer_id','id');
    }

    public function school_ambassador(){
        return $this->belongsTo(SchoolAmbassador::class,'school_ambassador_id','id')->with('schoolAmbassadorDetail');
    }

    public function messages(){
        return $this->hasMany(Message::class);
    }

    public function unCustomerSeenmessages(){
        return $this->hasMany(Message::class)->where('message_by','ambassador')->where('seen',0);
    }

    public function unAmbassadorSeenmessages(){
        return $this->hasMany(Message::class)->where('message_by','customer')->where('seen',0);
    }

    public function last_messages(){
        return $this->hasMany(Message::class)->whereMessageBy('ambassador')->orderBy('id','desc');
    }

    public function customer_last_messages(){
        return $this->hasMany(Message::class)->whereMessageBy('customer')->orderBy('id','desc');
    }
}
