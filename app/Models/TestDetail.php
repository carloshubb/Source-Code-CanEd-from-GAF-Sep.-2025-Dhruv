<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestDetail extends Model
{
    use HasFactory;

    protected $fillable = ["test_id", "language_id", "name"];
    public $timestamps = false;


    public function test()
    {
        return $this->belongsTo(Test::class);
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }
}
