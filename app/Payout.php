<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payout extends Model
{
    protected $fillable = ['academic_year_id', 'status_id', 'amount'];

    public function academic_year(){
        return $this->belongsTo('App\AcademicYear');
    }

    public function status(){
        return $this->belongsTo('App\Status');
    }
}
