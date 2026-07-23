<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'member_id',
        'membership_id',
        'amount',
        'payment_method',
        'status',
        'payment_date',
    ];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function membership()
    {
        return $this->belongsTo(Membership::class);
    }
}