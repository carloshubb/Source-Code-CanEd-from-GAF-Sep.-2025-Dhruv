<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AmbssadorMessagingApp extends Model
{
    use HasFactory;
    protected $fillable = [
        'messaging_app_id',
        'username',
        'ambassadors_id'
    ];
    public function schoolAmbassador()
    {
        return $this->belongsTo(SchoolAmbassador::class,'ambassadors_id','id');
    } public function messagingApp()
    {
        return $this->belongsTo(MessagingApp::class);
    }
}
