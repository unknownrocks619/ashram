<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_detail_id',
        'amount',
        'remark',
        'created_by_user'
    ];

    protected $hidden = [
        'created_by_user',
        'amount'
    ];

    public function userdetail(){
        return $this->belongsTo(userDetail::class,'user_detail_id');
    }
    

}
