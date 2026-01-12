<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quote extends Model
{
    use HasFactory;
    protected $fillable = ['user_id','name','location','status', 'image', 'school_id','customer_id'];

    public function quoteDetail()
    {
        return $this->hasMany(QuoteDetail::class, 'quote_id', 'id');
    }

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function quoteImage()
    {
        return $this->hasOne(Media::class, 'id', 'image');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
