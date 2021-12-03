@extends('layouts')


@section('content')



    <div>
        @foreach($posts as $post)
            <div class="card p-2 m-2">
                <div class="card-body p-2">
                    <div class="card-title  ">
                        <h5><a href="{{route('post.show',$post->id)}} ">{{ $post->title }}</a></h5>
                    </div>

                    <p class="card-text ">{!!   strlen($post->content)<100 ? $post->content : (substr($post->content, 0, 300)."...<a href =".route('post.show',$post->id)."> Devamını oku </a>") !!}</p>
                    <div class="w3-bar">
                        @auth
                            @if(Auth::user()->id == $post->user_id)
                                <form action="{{ route('post.edit',['post' => $post])  }}" style="display: inline;">
                                    @csrf
                                    @method('edit')
                                    <input type="submit" class="btn btn-success " value="Edit">
                                </form>
                                <form action="{{ route('post.destroy',['post' => $post]) }}" method="post"
                                      style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <input type="submit" class="btn btn-danger" value="Delete">
                                </form>
                            @endif
                        @endauth
                    </div>
                </div>
            </div>
        @endforeach

        {{$posts->links("pagination::bootstrap-4")}}
    </div>
@endsection
