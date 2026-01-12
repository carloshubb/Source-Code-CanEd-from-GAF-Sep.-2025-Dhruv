<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SitemapSettingMenu extends Model
{
    use HasFactory;

    protected $fillable = ['section', 'menu_id'];
    
    public function menu()
    {
        return $this->belongsTo(Menu::class, 'menu_id');
    }
}
