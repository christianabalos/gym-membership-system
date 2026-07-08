<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trainer extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'email',
        'phone',
        'specialization',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function memberships() 
    {
        return $this->hasMany(Membership::class);
    }

    public function members()
    {
        return $this->hasManyThrough(
            Member::class,
            Membership::class,
            'trainer_id',
            'id',
            'id',
            'member_id'
        );
    }

    public function workouts()
{
    return $this->hasMany(\App\Models\Workout::class);
}

    public function availabilities()
    {
        return $this->hasMany(TrainerAvailability::class);
    }

    public function appointments()
{
    return $this->hasMany(TrainerAppointment::class);
}
}