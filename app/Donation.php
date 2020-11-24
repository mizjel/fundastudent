<?php

namespace App;

use App\Services\AmountServiceTrait;
use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{

    protected $fillable = [
        'payment_id', 'academic_year_id', 'name', 'email', 'amount', 'message', 'paid', 'aborted', 'token'
    ];

    protected $hidden = [];


    public function academic_year(){
        return $this->belongsTo('App\AcademicYear');
    }

    public function getName(){
        return $this->name != null ? $this->name : 'Anoniem';
    }

    public function getStatus(){
        if($this->paid){
            return 'Betaald';
        }else if($this->aborted){
            return 'Donatie mislukt';
        }

        return 'De donatie wordt verwerkt';
    }
}
