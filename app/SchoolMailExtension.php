<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SchoolMailExtension extends Model
{
    public $primaryKey = 'school_id';

    protected $fillable = [
        'school_id','extension'
    ];
}
