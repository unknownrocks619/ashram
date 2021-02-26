<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;
<<<<<<< HEAD
=======

    protected $fillable = [
        'room_number',
        'room_name',
        'room_type',
        'room_description',
        'room_capacity',
        'room_location',
        'room_category',
        'room_owner_id',
        'created_by_user'
    ];

    public function userdetail(){
        return $this->belongsTo(userDetail::class,'room_owner_id');
    }

    public function occupied_room(){
        return $this->hasMany(Booking::class,'rooms_id')
                    ->where('is_occupied',true)
                    ->orWhere('is_reserved',true);
    }

    public function is_reserved(){
        return $this->hasMany(Booking::class,'rooms_id')
                    ->where('is_reserved',true);
    }
>>>>>>> 24c669455b6c4bffe3898ef7b003cf09c45fedcd
}
