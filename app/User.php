<?php

namespace App;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Mail\ResetPasswordMail;
use Illuminate\Support\Facades\Mail;


class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'prefix',
        'last_name',
        'email',
        'password',
        'description',
        'iban',
        'date_of_birth',
        'residence',
        'zip_code',
        'avatar_url',
        'phone',
        'verified',
        'email_token',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $email = new ResetPasswordMail($token);
        Mail::to($this->email)->send($email);
    }

    public function getFullName(){
        return $this->first_name . ' ' . $this->last_name;
    }

    public function bank_account(){
        return $this->hasOne('App\BankAccount');
    }

    public function academic_years(){
        return $this->hasMany('App\AcademicYear');
    }

    public function isAdmin(){
        return $this->hasOne('App\Admin', 'user_id')->count();
    }
}
