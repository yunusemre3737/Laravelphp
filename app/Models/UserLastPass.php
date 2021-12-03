<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserLastPass extends Model
{
    use HasFactory;

    protected $table = 'lastpass';

    protected $fillable = [
        'user_id',
        'password'
    ];

    // $userlastpass->user => User Model
    public function User()
    {// 'App\Models\User'
        return $this->belongsTo(User::class);
    }
}
