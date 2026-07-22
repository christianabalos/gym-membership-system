<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Workout extends Model
{
    protected $fillable = [
        'membership_id',
        'member_id',
        'trainer_id',
        'day',
        'workout_type',
        'workout_name',
        'description',
        'workout_date',
        'workout_time',
        'status',
    ];

    public function membership()
    {
        return $this->belongsTo(Membership::class);
    }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function trainer()
    {
        return $this->belongsTo(Trainer::class);
    }
}
