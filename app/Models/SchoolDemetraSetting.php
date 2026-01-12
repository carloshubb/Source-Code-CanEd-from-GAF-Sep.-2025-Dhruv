<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolDemetraSetting extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function sports(){
        return $this->hasMany(DemetraSport::class,'school_demetra_setting_id','id');
    }
    public function communityServices(){
        return $this->hasMany(DemetraCommunityService::class,'school_demetra_setting_id','id');
    }
    public function curricularActivities(){
        return $this->hasMany(DemetraCurricularActivity::class,'school_demetra_setting_id','id');
    }
    public function activities()
    {
        return $this->hasMany(DemetraActivity::class, 'school_demetra_setting_id','id');
    }
}
