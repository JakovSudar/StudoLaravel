<?php

namespace App;

use Illuminate\Support\Str;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    const STUDENT = "student";
    const EMPLOYER = "employer";

    const VERIFIED = 1;
    const UNVERIFIED = 0;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'type',
        'verified',
        'verification_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token','verification_token'
    ];

    public function jobs(){
        return $this->hasMany(Job::class);
    }
    public function applications(){
        return $this->hasMany(JobApplication::class);
    }
    public static function generateVerificationToken()
    {
        return Str::random(40);
    }


}
