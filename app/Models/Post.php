<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'content', 'user_id'];

    protected $appends = ['likes'];

    public function getLikesAttribute(){
        return [
            'likes'=> $this->likes()->count() ,
            'dislikes'=> $this->dislikes()->count()
        ];

    }

    public function likes(){
        return $this->hasMany('App\Models\PostLike')->where('status', '=',  'like');
    }
    public function dislikes(){
        return $this->hasMany('App\Models\PostLike')->where('status', '=',  'dislike');
    }

    // $post->user => User Model
    public function User()
    {// 'App\Models\User'
        return $this->belongsTo(User::class);// git push test
    }
    // $post->user => Comment Model
    public function comment(){
        return $this->hasMany(Comment::class)->where('ifanswer_id', '=', null);
    }

}
