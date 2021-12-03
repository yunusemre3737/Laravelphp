<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use DB;
use App\Models\Post;
use http\Client\Curl\User;
use Illuminate\Http\Request;

class PostController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth')->only(['show']);
    }

    public function index()
    {
        $posts = Post::orderByDesc('updated_at')->paginate(5);

        //$posts = DB::table('posts');

        return view('post.index', compact('posts'));
    }

    public function create()
    {
        return view('post.edit');
    }

    public function store(Request $request)
    {
        //header -> ozellik => auth bilgisi
        //body -> data -> user=1

        $this->validate($request, [
            'title' => 'required',
            'content' => 'required'
        ]);


        $post = Post::create([
            'title' => $request->title,
            'content' => $request['content'],
            'user_id' => auth()->user()->id
        ]);

        return redirect()->route('post.index');

    }

    public function edit(Post $post)
    {

        return view('post.edit', ['post' => $post]);
    }

    public function update(Request $request, $id)
    {
        return $request->post();
        Post::find($id)->update($request->post());
        return redirect()->route('post.index');
    }

    public function destroy(Post $post)
    {
        $post->delete();

        return redirect()->route('post.index');
    }

    public function show(Post $post)
    {

        $post = Post::with('user')->with('comment.user')->find($post->id);

        $answercomment = Comment::getAllSortedByMake($post->id);

        //$answercomment = $post->comment->where('ifanswer_id', '!=', null);
        //<return $post;


        return view('post.show', compact('post', 'answercomment'));
    }

}
