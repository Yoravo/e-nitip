<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Locker extends Model
{
    use HasFactory;

    protected $primaryKey = 'locker_id'; // Custom primary key
    protected $fillable = ['locker_code', 'is_available']; // Fields that are mass assignable
}
