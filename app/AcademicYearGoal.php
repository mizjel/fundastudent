<?php

namespace App;

use App\Services\AmountServiceTrait;
use Illuminate\Database\Eloquent\Model;

class AcademicYearGoal extends Model
{

    protected $fillable = [
        'academic_year_id', 'description', 'amount'
    ];

    protected $hidden = [];

    public function academic_year(){
        return $this->belongsTo('App\AcademicYear');
    }
}
