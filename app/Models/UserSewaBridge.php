<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSewaBridge extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'user_sewas_id',
        'user_involvement',
        'created_by_user'
    ];

    public function usersewa()
    {
        return $this->belongsTo(UserSewa::class);
    }
}
