<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $primaryKey = 'user_id';

    public $timestamps = false;

    protected $fillable = ['user_id'];

    public function user(){
        return $this->belongsTo('App\User');
    }
}
