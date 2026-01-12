<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoffeeWallet extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'user_id',
        'name',
        'email',
        'phone',
        'anonymous',
        'designation',
        'package_id',
        'frequency',
        'dr_amount',
        'paypal_id',
        'stripe_id',
        'subscription_id',
        'payment_method',
        'status',
        'random_id',
    ];

    /**
     * Type casting for booleans, decimals etc.
     */
    protected $casts = [
        'anonymous' => 'boolean',
        'dr_amount' => 'float',
    ];

    /**
     * Relationships
     */
    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    /**
     * Link to user (if donated while logged in).
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
