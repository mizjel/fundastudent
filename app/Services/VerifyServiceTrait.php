<?php

namespace App\Services;

use App\Mail\VerifyFunder;
use App\Mail\VerifyStudent;
use Illuminate\Support\Facades\Mail;

trait VerifyServiceTrait
{
    private function generateEmailToken(){
        return str_random(10);
    }
}