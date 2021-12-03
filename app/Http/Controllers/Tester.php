<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\PostLike;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Session;



class Tester extends Controller
{
    public function test(Request $request)
    {
        //return User::with('postlike')->find($request);
        //return Post::with('comment.user')->find($request);
       //return Comment::find(1)->get();
       // $post = Post::with('user')->with('comment.user')->find(9);
        //$answercommentnew = $post->comment->where('ifanswer_id', '!=', null);
        //$answercomment = Comment::getAllSortedByMake($post->id);

        //dd($request->session());
        return  [Session::getId(),$request->session()->all() ];
        //return Comment::getAllSortedByMake($request->test);


    }
}
