<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     * Ensures mass assignment is secure.
     */
    protected $fillable = [
        'frequency',
        'price',
        'custom',
        'is_default',
        'stripe_product_id',
        'stripe_price_id',
        'paypal_product_id',
        'paypal_price_id',
    ];

    /**
     * The attributes that should be cast to native types.
     * Adjusted to your schema: price stored as string, custom & is_default as boolean-like.
     */
    protected $casts = [
        'price' => 'string',
        'custom' => 'boolean',
        'is_default' => 'boolean',
    ];
    /**
     * Relationships
     * A package can be tied to many coffee donations.
     */
    public function coffeeWallets()
    {
        return $this->hasMany(CoffeeWallet::class);
    }
}
