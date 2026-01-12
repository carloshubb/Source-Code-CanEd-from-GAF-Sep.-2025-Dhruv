<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OverviewProgram extends Model
{
    use HasFactory;

    protected $fillable = ['length', 'tuition_inter_stu_fee', 'tuition_can_stu_fee', 'tuition_prov_stu_fee', 'school_overviews_id'];
    
    public function overviewProgramDetail()
    {
        return $this->hasMany(OverviewProgramDetail::class, 'overview_program_id', 'id');
    }
}
