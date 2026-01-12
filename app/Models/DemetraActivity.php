<?php

// DemetraActivity model (pivot table between demetra settings and activities)
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DemetraActivity extends Model
{
    use HasFactory;

    protected $table = 'demetra_activity';
    protected $fillable = ['school_demetra_setting_id', 'activity_id', 'type'];

    public function setting()
    {
        return $this->belongsTo(SchoolDemetraSetting::class, 'school_demetra_setting_id');
    }

    public function activity()
    {
        return $this->belongsTo(Activity::class);
    }
}