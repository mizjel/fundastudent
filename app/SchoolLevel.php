<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SchoolLevel extends Model
{
    protected $fillable = ['level'];

    public function schools(){
        return $this->hasMany('App\School');
    }
    public function enrollments(){
        return $this->hasMany('App\Enrollment');
    }
}
