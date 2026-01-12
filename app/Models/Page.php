<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;
    protected $fillable = ['template','image','slug','set_as_home'];
    
    public function PageDetail()
    {
        return $this->hasMany(PageDetail::class, "page_id", "id");
    }
}
