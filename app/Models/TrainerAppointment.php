<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrainerAppointment extends Model
{
    protected $fillable = [
        'member_id',
        'trainer_id',
        'trainer_availability_id',
        'day',
        'appointment_date',
        'start_time',
        'end_time',
        'status',
        'notes',
    ];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function trainer()
    {
        return $this->belongsTo(Trainer::class);
    }

    public function availability()
    {
        return $this->belongsTo(TrainerAvailability::class, 'trainer_availability_id');
    }
}