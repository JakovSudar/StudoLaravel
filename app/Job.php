<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    protected $fillable = [
        'title',
        'description',
        'category',
        'city',
        'wage',
        'requirements',
        'user_id',
        'employer',
        'notes'
    ];

    public function applications(){
        return $this->hasMany(JobApplication::class);
    }
    public function users(){
        return $this->belongsTo(User::class);
    }

}
