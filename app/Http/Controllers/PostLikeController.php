<?php

namespace App\Http\Controllers;

use App\Models\PostLike;
use Illuminate\Http\Request;

use App\Models\Post;

class PostLikeController extends Controller
{

    public function ChangeStatus(Request $request){
       $aranan = PostLike::where('post_id', '=',  $request->post_id)->Where('user_id', '=', $request->user_id);
        if($aranan->exists()){

            if($aranan->first()->status==$request->status){
                $aranan->delete();
                return $this->GetLikes($request->post_id);
            }
            else{
                $aranan->first()->update(['status'=>$request->status]) ;

                return $this->GetLikes($request->post_id);
            }

        }
        else{
            PostLike::create([
                'post_id' => $request->post_id,
                'user_id'=> auth()->user()->id,
                'status' => $request->status
            ]);
            return $this->GetLikes($request->post_id);
        }

        return 'success';
    }

    public function GetLikes($id){
        $likes = Post::find($id)->likes;

        return $likes;


    }
}
