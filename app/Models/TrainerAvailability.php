<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrainerAvailability extends Model
{
    protected $fillable = [
        'trainer_id',
        'day',
        'start_time',
        'end_time',
        'is_available',
    ];

    public function trainer()
    {
        return $this->belongsTo(Trainer::class);
    }
}