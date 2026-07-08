<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Membership extends Model
{
    protected $fillable = [
    'member_id',
    'trainer_id',
    'schedule_time',
    'plan_name',
    'price',
    'start_date',
    'end_date',
    'status',
];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function trainer()
    {
        return $this->belongsTo(Trainer::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}