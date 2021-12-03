<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = ['ifanswer_id', 'post_id', 'user_id','content'];

    protected $appends = ['likes'];

    public function getLikesAttribute(){
        return [
            'likes'=> $this->likes()->count() ,
            'dislikes'=> $this->dislikes()->count()
        ];

    }

    public function likes(){
        return $this->hasMany('App\Models\CommentLike')->where('status', '=',  'like');
    }
    public function dislikes(){
        return $this->hasMany('App\Models\CommentLike')->where('status', '=',  'dislike');
    }


    public function User()
    {// 'App\Models\User'
        return $this->belongsTo(User::class);// git push test
    }

    public function Post()
    {// 'App\Models\User'
        return $this->belongsTo(Post::class);// git push test
    }

    public static function getAllSortedByMake($post_id)
    {

        return Comment::where('ifanswer_id', '!=',  null)->where('post_id', '=', $post_id)->with('user')->get();
    }

}
