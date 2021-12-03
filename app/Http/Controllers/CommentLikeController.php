<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\CommentLike;
use Illuminate\Http\Request;

class CommentLikeController extends Controller
{
    public function ChangeStatus(Request $request)
    {
        $aranan = CommentLike::where('comment_id', '=', $request->comment_id)->Where('user_id', '=', $request->user_id);
        if ($aranan->exists()) {

            if ($aranan->first()->status == $request->status) {
                $aranan->delete();
                return $this->GetLikes($request->comment_id);
            } else {
                $aranan->first()->update(['status' => $request->status]);

                return $this->GetLikes($request->comment_id);
            }

        } else {
            CommentLike::create([
                'comment_id' => $request->comment_id,
                'user_id' => auth()->user()->id,
                'status' => $request->status
            ]);
            return $this->GetLikes($request->comment_id);
        }

        return 'success';
    }


    public function GetLikes($id)
    {
        $likes = Comment::find($id)->likes;

        return $likes;

    }
}
