<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class AcademicYear extends Model
{
    protected $fillable = [
        'user_id',
        'school_id',
        'enrollment_id',
        'academic_year_period_id',
        'email',
        'email_token',
        'verified',
        'title',
        'slogan',
        'fund_motivation',
        'short_description',
        'full_description',
        'thumbnail_url'
    ];

    protected $hidden = [];

    public function getThumbnail(){
        return $this->thumbnail_url != null ? asset('storage/' . $this->thumbnail_url) : 'http://fakeimg.pl/200x85/';
    }

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function enrollment(){
        return $this->belongsTo('App\Enrollment');
    }

    public function academic_year_period(){
        return $this->belongsTo('App\AcademicYearPeriod');
    }

    public function payouts(){
        return $this->hasMany('App\Payout');
    }

    public function goals(){
        return $this->hasMany('App\AcademicYearGoal');
    }

    public function donations(){
        return $this->hasMany('App\Donation');
    }

    public function updates(){
        return $this->hasMany('App\AcademicYearUpdate');
    }
}
