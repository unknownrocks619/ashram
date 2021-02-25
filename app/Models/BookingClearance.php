<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingClearance extends Model
{
    use HasFactory;

    protected $fillable = [
        'bookings_id',
        'booking_code',
        'remarks',
        'created_by_user'
    ];

    public function entry_by(){

        return $this->belongsTo(userDetail::class,'created_by_user');
    }
}
