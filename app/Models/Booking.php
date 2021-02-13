<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_detail_id',
        'rooms_id',
        'check_in_date',
        'check_out_date',
        'is_occupied',
        'booking_code',
        'status',
        'is_reserved',
        'remarks',
        'total_duration',
        'created_by_user'
    ];

    
}
