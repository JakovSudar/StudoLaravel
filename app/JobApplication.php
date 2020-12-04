<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JobApplication extends Model
{
    protected $table = 'applications';
    protected $fillable = [
        'user_id',
        'job_id',
        'about_me',
        'email',
        'phone'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function job(){
        return $this->belongsTo(Job::class);
    }


}
