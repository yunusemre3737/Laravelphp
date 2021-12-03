<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommentLike extends Model
{
    use HasFactory;

    protected $fillable = ['status', 'comment_id', 'user_id'];

    public function User()
    {// 'App\Models\User'
        return $this->belongsTo(User::class);// git push test
    }
}
