<?php

namespace App\Models;

use App\Notifications\ResetPasswordNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Authenticatable
{
    use SoftDeletes;
    use HasApiTokens, HasFactory, Notifiable;
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }
    protected $fillable = ['payment_frequency', 'zoho_refresh_token', 'temp_plan_id', 'paypal_subscription_id', 'subscription_status', 'is_auto_renew', 'temp_registration_package_id', 'registration_package_id', 'package_price', 'free_subscription_days', 'package_subscribed_date', 'package_expiry_date', 'is_package_amount_paid', 'password', 'slug', 'first_name', 'last_name', 'email', 'display_name', 'image', 'user_type', 'dob', 'gender', 'martial_status', 'city', 'country', 'province', 'postal_code', 'home_phone', 'mobile_phone', 'deactive_account', 'whats_app_number', 'skype_id', 'we_chat_number', 'viber_number', 'imo_number','messagingAppDetail_id', 'email_verified_at'];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = ['email_verified_at' => 'datetime'];

    public function registrationPackage()
    {
        return $this->belongsTo(RegistrationPackage::class);
    }

    public function customerBusinessCategory()
    {
        return $this->hasMany(CustomerBusinessCategory::class, 'customer_id', 'id');
    }

    public function customerMedia()
    {
        return $this->hasOne(CustomerMedia::class, 'customer_id', 'id');
    }

    public function customerProfile()
    {
        return $this->hasOne(CustomerProfile::class, 'customer_id', 'id');
    }

    public function customerSocialMedia()
    {
        return $this->hasOne(CustomerSocialMedia::class, 'customer_id', 'id');
    }

    public function customerLanguage()
    {
        return $this->hasMany(CustomerLanguage::class);
    }

    public function school()
    {
        return $this->hasOne(School::class, 'customer_id', 'id');
    }

    public function business()
    {
        return $this->hasOne(Business::class, 'customer_id', 'id');
    }

    public function degree()
    {
        return $this->belongsTo(Degree::class);
    }

    public function program()
    {
        return $this->belongsTo(Program::class);
    }
    public function messagingAppsDetail()
    {
        return $this->belongsTo(MessagingAppDetail::class);
    }
    public function events()
    {
        return $this->hasMany(Event::class, 'customer_id', 'id');
    } 
     public function articles()
    {
        return $this->hasMany(Article::class, 'customer_id', 'id');
    }
     public function ambassadors()
    {
        return $this->hasMany(SchoolAmbassador::class, 'customer_id', 'id');
    }
}
