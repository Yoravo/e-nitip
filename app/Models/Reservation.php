<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'item_name', 'phone_number', 'locker_codes', 'deposit_time', 'pickup_time'
    ];

    protected $casts = [
        'locker_codes' => 'array',
    ];
}
