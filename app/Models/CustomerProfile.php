<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerProfile extends Model
{
    use HasFactory;

    protected $table = 'customer_profile';

    public $timestamps = false;

    protected $fillable = ['company_name', 'company_email', 'short_description', 'description', 'phone', 'website', 'keywords', 'address', 'customer_id'];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
