<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterApplicationMessagingApp extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function MessagingApp()
    {
        return $this->belongsTo(MessagingApp::class);
    }
}
