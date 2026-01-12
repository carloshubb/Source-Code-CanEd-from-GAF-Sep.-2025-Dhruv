<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProximaRequest extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'phone', 'email', 'inquiry', 'quotation_amount', 'quotation_detail', 'status'];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
