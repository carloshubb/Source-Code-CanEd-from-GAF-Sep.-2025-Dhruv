<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolOverview extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function schoolOverviewDetail()
    {
        return $this->hasMany(SchoolOverviewDetail::class);
    }

    public function overviewPrograms()
    {
        return $this->hasMany(OverviewProgram::class,'school_overviews_id','id')->with('overviewProgramDetail');
    }
}
