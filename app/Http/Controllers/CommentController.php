<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function create(Request $request,$post){

        $validated = $request->validate([
            'content' => 'required',
        ]);

        $comment = Comment::create([
            'user_id' => auth()->user()->id,
            'post_id' => $post,
            'content' => $request['content']
        ]);

        return redirect()->route('post.show',$post);
    }

    public function createanswer(Request $request,$comment_id){


        $comment = Comment::create([
            'user_id' => auth()->user()->id,
            'post_id' => $request->post,
            'content' => $request['content'],
            'ifanswer_id' => $comment_id
        ]);

        return redirect()->route('post.show',$request->post);
    }
}
