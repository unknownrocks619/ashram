<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class userDetail extends Model
{
    use HasFactory, Notifiable;

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'pet_name',
        'date_of_birth_nepali',
        'date_of_birth_eng',
        'gender',
        'phone_number',
        'country',
        'city',
        'user_type',
        'user_room_allotment',
        'education_level',
        'profession',
        'skills',
        'marritial_status',
        'married_to_id',
        'profile_id'
    ];

    
    public function full_name() {

        $full_name = $this->first_name;
        if ($this->middle_name) {
            $full_name .= " ";
            $full_name .= $this->middle_name;
        }
        $full_name .= " ";
        $full_name .= $this->last_name;
        return $full_name;
    }

    public function address()
    {
        return $this->country . ", " . $this->city;
    }

}
