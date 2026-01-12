<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProximaConversation extends Model
{
    use HasFactory;
    protected $guarded = [];
    
    public function customer(){
        return $this->belongsTo(Customer::class,'customer_id','id');
    }

    public function admin(){
        return $this->belongsTo(User::class,'admin_id','id');
    }

    public function messages(){
        return $this->hasMany(ProximaMessage::class);
    }

    public function unSeenCustomerMessages(){
        return $this->hasMany(ProximaMessage::class)->where('message_by','admin')->where('seen',0);
    }

    public function unSeenAdminMessages(){
        return $this->hasMany(ProximaMessage::class)->where('message_by','customer')->where('seen',0);
    }

    public function admin_last_messages(){
        return $this->hasMany(ProximaMessage::class)->whereMessageBy('admin')->orderBy('id','desc');
    }

    public function customer_last_messages(){
        return $this->hasMany(ProximaMessage::class)->whereMessageBy('customer')->orderBy('id','desc');
    }
}
