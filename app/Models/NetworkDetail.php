<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NetworkDetail extends Model
{
    use HasFactory;

    protected $fillable = ["network_id", "language_id","full_name",'description',"slug"];
    public $timestamps = false;


    public function network()
    {
        return $this->belongsTo(Network::class);
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }
}
