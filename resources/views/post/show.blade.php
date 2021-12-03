@extends('layouts')


@section('content')

    <div>
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <h2 class="card-title col-sm-8">{{$post->title}}</h2>
                    <div class="col-sm-4">
                        <button id="like" class="btn btn-success  m-2 like-but">
                            <i class="fas fa-thumbs-up"></i> Like (<b id="likevalue">{{$post->likes['likes'] }}</b>)
                        </button>
                        <button id="dislike" class="btn btn-danger m-2 like-but">
                            <i class="fas fa-thumbs-down"></i> Dislike (<b
                                id="dislikevalue">{{$post->likes['dislikes']}}</b>)
                        </button>
                    </div>
                </div>
                <p class="card-text">{{$post->content}}</p>

                <div class="card-footer">

                    <p>@if($post->user->avatar_adress!=null)
                            <img src="http://127.0.0.1:8000/images/{{$post->user->avatar_adress}}" width="35"
                                 height="35">
                        @endif Created By <strong> {{ $post->user->username }}</strong>
                        at {{ \Carbon\Carbon::parse($post->created_at)->diffForHumans()}}</p>
                </div>
            </div>
        </div>


        <div class="card my-4 ">
            @forelse ($errors->all() as $error)
                <div class="alert alert-danger">
                    <ul>
                        <li>{{ $error }}</li>
                    </ul>
                </div>
            @empty
            @endforelse
            <div class="card-body">
                <h5 class="card-header">Leave a Comment:</h5>
                <form lass="form-horizontal" role="form" method="POST" action="{{route('comment.create',$post->id)}}">
                    @csrf
                    <textarea class="form-control" name="content"></textarea>
                    <button class="btn btn-primary mt-3">Gönder</button>
                </form>
            </div>
        </div>


        <!---Custom command start ---->


        <div class="container bootstrap snippets bootdey">
            <div class="row">
                <div class="col-md-12">
                    <div class="blog-comment">
                        <h3 class="text-primary">Yorumlar ({{$post->comment->count()}} Yorum
                            ,{{$answercomment->count() }} Cevap)</h3>
                        <hr/>
                        <ul class="comments">
                            @foreach($post->comment->reverse() as $comment)
                                @if($comment->ifanswer_id==null)
                                    <li class="clearfix">
                                        @if($comment->user->avatar_adress!=null)
                                            <img class="avatar img-thumbnail"
                                                 src="http://127.0.0.1:8000/images/{{$comment->user->avatar_adress}}">
                                        @else
                                            <img class="avatar img-thumbnail"
                                                 src="http://127.0.0.1:8000/images/none.jpg">
                                        @endif
                                        <div class="post-comments">
                                            <p class="meta"> Answered by <a
                                                    href="#">{{$comment->user->username}} </a><small>at {{ \Carbon\Carbon::parse($comment->created_at)->diffForHumans()}} </small>
                                                <i class="pull-right">
                                                    <button class="btn btn-primary ml-2 btn-sm"
                                                            onclick="myFunction{{$loop->iteration}}()">Cevapla
                                                    </button>
                                                </i>

                                                <button id="dislike"
                                                        class="btn btn-danger btn-sm float-right ml-2 comment-like-but"
                                                        name="{{$comment->id}}">
                                                    <i class="fas fa-thumbs-down"></i> Dislike (<b
                                                        id="commentdislikevalue">{{$comment->likes['dislikes']}}</b>)
                                                </button>
                                                <button id="like"
                                                        class="btn btn-success btn-sm float-right ml-2 comment-like-but "
                                                        name="{{$comment->id}}">
                                                    <i class="fas fa-thumbs-up"></i> Like (<b
                                                        id="commentlikevalue">{{$comment->likes['likes']}}</b>)
                                                </button>
                                            </p>
                                            <p>
                                                {{$comment->content}}
                                            </p>
                                        </div>

                                        <ul class="comments">
                                            @foreach($answercomment as $answers)
                                                @if($answers->ifanswer_id == $comment->id)
                                                    <li class="clearfix">
                                                        @if($answers->user->avatar_adress!=null)
                                                            <img class="avatar img-thumbnail"
                                                                 src="http://127.0.0.1:8000/images/{{$answers->user->avatar_adress}}">
                                                        @else
                                                            <img class="avatar img-thumbnail"
                                                                 src="http://127.0.0.1:8000/images/none.jpg">
                                                        @endif
                                                        <div class="post-comments">
                                                            <p class="meta"> Answered by <a
                                                                    href="#">{{$answers->user->username}} </a><small>at {{ \Carbon\Carbon::parse($answers->created_at)->diffForHumans()}} </small>
                                                                <i class="pull-right"></i>

                                                                <button id="dislike"
                                                                        class="btn btn-danger float-right btn-sm ml-2 comment-like-but"
                                                                        name="{{$answers->id}}">
                                                                    <i class="fas fa-thumbs-down"></i> Dislike (<b
                                                                        id="commentdislikevalue">{{$answers->likes['dislikes']}}</b>)
                                                                </button>
                                                                <button id="like"
                                                                        class="btn btn-success float-right btn-sm ml-2 comment-like-but "
                                                                        name="{{$answers->id}}">
                                                                    <i class="fas fa-thumbs-up"></i> Like (<b
                                                                        id="commentlikevalue">{{$answers->likes['likes']}}</b>)
                                                                </button>
                                                            </p>
                                                            <p>
                                                                {{$answers->content}}
                                                            </p>
                                                        </div>
                                                    </li>
                                                @endif

                                            @endforeach
                                        </ul>
                                    </li>


                                    <div class="mt-3" id="{{$loop->iteration}}" style="display:none">
                                        <div class="card-header">Cevap:</div>

                                        <form lass="form-horizontal" role="form" method="POST"
                                              action="{{route('comment.createanswer',$comment)}}">
                                            @csrf
                                            <input value="{{$post->id}}" name="post" hidden>
                                            <textarea class="form-control" name="content"></textarea>
                                            <button class="btn btn-success m-3">Gönder</button>
                                        </form>
                                    </div>

                                    <script>
                                        function myFunction{{$loop->iteration}} () {
                                            var x = document.getElementById("{{$loop->iteration}}");
                                            if (x.style.display === "block") {
                                                x.style.display = "none";
                                            } else {
                                                x.style.display = "block";
                                            }
                                        }
                                    </script>
                                @endif

                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>


        <!---Custom command finish ---->
    <!---
            @foreach($post->comment->reverse() as $comment)
        @if($comment->ifanswer_id==null)
            <div class="card mt-3" >
            <div class="card-body">

                <p class="card-text">{{$comment->content}}</p>

                <div class="card-footer">

                @if($comment->user->avatar_adress!=null)
                <img src="http://127.0.0.1:8000/images/{{$comment->user->avatar_adress}}"  width="35" height="35">
                @endif
            {{$loop->iteration}} Answered by
                <strong class="card-title "> {{$comment->user->username}}</strong> at {{ \Carbon\Carbon::parse($comment->created_at)->diffForHumans()}}



                </div>
            </div>
                @foreach($answercomment as $answers)
                @if($answers->ifanswer_id == $comment->id)
                    <div class="card-body ml-5">{{$answers->content}}
                        <div class="card-footer">
@if($answers->user->avatar_adress!=null)
                        <img src="http://127.0.0.1:8000/images/{{$answers->user->avatar_adress}}"  width="35" height="35">
                                @endif
                        Answered by
                        <strong class="card-title ">{{$answers->user->username}}</strong> at {{ \Carbon\Carbon::parse($answers->created_at)->diffForHumans()}}
                        <button id="like" class="btn btn-success  m-2 comment-like-but " name="{{$answers->id}}" >
                                        <i class="fas fa-thumbs-up"></i> Like  (<b id="commentlikevalue">{{$answers->likes['likes']}}</b>) </button>
                                    <button id="dislike" class="btn btn-danger m-2 comment-like-but" name="{{$answers->id}}">
                                        <i class="fas fa-thumbs-down"></i> Dislike  (<b id="commentdislikevalue">{{$answers->likes['dislikes']}}</b>)  </button>
                            </div>
                        </div>
                    @endif

            @endforeach
                </div>


@endif
    @endforeach
        ---->

    </div>
    <script>
        $(".comment-like-but").click(function (event) {
            event.preventDefault();
            var value = this.name;
            $.ajax({
                url: "/ajax-request-forcommentlikes",
                type: "POST",
                data: {
                    status: this.id,
                    comment_id: this.name,
                    user_id:{{ Auth::user()->id }},
                    "_token": "{{ csrf_token() }}"
                },
                success: function (response) {
                    console.log(response);
                    $('button[name="' + value + '"]').children('b[id="commentlikevalue"]').text(response['likes']);
                    $('button[name="' + value + '"]').children('b[id="commentdislikevalue"]').text(response['dislikes']);
                },
            });
        });


        $(".like-but").click(function (event) {
            event.preventDefault();

            $.ajax({
                url: "/ajax-request",
                type: "POST",
                data: {
                    status: this.id,
                    post_id:{{$post->id}},
                    user_id:{{ Auth::user()->id }},
                    "_token": "{{ csrf_token() }}"
                },
                success: function (response) {

                    $("#likevalue").text(response['likes']);
                    $("#dislikevalue").text(response['dislikes']);
                },
            });
        });
    </script>
@endsection
