<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    use HasFactory;

    protected $fillable = ['type','order','customer_id',"school_id"];

    public function FaqDetail()
    {
        return $this->hasMany(FaqDetail::class, "faq_id", "id");
    }
}
