<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    protected $fillable = [
        'school_level_id', 'name','address','phone','residence', 'zip_code'
    ];

    public function mailExtensions(){
        return $this->hasMany('App\SchoolMailExtension');
    }

    public function schoolType(){
        return $this->hasOne('App\SchoolLevel', 'id', 'school_level_id');
    }
}
