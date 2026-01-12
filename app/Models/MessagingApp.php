<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MessagingApp extends Model
{
    use HasFactory;

    public function messagingAppDetail()
    {
        return $this->hasMany(MessagingAppDetail::class, "messaging_app_id", "id");
    }
}
