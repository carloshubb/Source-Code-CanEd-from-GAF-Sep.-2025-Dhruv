<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    use HasFactory;

    public function testDetail()
    {
        return $this->hasMany(TestDetail::class, "test_id", "id");
    }
}
