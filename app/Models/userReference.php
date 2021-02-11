<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class userReference extends Model
{
    use HasFactory;

    protected $fillable = [
        'center_id',
        'user_detail_id',
        'name',
        'phone_number',
        'created_by_user',
        'user_referer_id'
    ];
}
