<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AcademicYearPeriod extends Model
{
    protected $fillable = ['period', 'begin_date', 'end_date'];
}
