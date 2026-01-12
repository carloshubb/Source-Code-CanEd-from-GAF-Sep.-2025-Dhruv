<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MessagingAppDetail extends Model
{
    use HasFactory;
    protected $fillable = ["messaging_app_id", "language_id", "name"];
    public $timestamps = false;


    public function messagingApp()
    {
        return $this->belongsTo(MessagingApp::class);
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }
}
