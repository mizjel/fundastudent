<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AcademicYearUpdate extends Model
{
    protected $fillable = [
        'academic_year_id', 'title', 'update'
    ];

    protected $hidden = [];

    public function academic_year(){
        return $this->belongsTo('App\AcademicYear');
    }
}
