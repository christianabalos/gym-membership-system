<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $fillable = [
        'user_id',
        'trainer_id',
        'full_name',
        'phone',
        'address',
        'birth_date',
        'gender',
        'email',
        'password',
    ];

    public function user() { return $this->belongsTo(User::class); }
    public function trainer() { return $this->belongsTo(Trainer::class); }
    public function memberships() { return $this->hasMany(Membership::class); }
    public function payments() { return $this->hasMany(Payment::class); }
    public function workouts() { return $this->hasMany(Workout::class); }
}