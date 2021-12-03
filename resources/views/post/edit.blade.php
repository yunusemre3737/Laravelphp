@extends('layouts')


@section('content')
    <div>

        <div class="panel-body">
            <form class="form-horizontal" role="form" method="POST"
                  action="{{ isset($post) ?  route('post.update',$post->id)  : route('post.store') }}">
                @csrf
                @if(isset($post))
                    @method('PUT')
                @endif
                <div>
                    <label for="username" class="col-md-4 control-label"
                           name="username">Hello, {{Auth::user()->username}}</label>
                </div>

                <div>
                    <label for="title">Title:</label>
                    <input type="text" class="form-control" id="title" placeholder="Enter title"
                           value="{{isset($post) ?  $post->title : ' '}}" name="title">
                </div>
                <br>
                <div>
                    <label for="content">Content :</label>
                    <textarea name="content" class="form-control "
                              id="content">{{isset($post) ?  $post->content : ' '}}</textarea>
                </div>
                <br>
                <div class="form-group">
                    <div class="col-md-6 col-md-offset-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-btn fa-sign-in"></i> Send
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script>
        $('textarea').autoResize();
    </script>
@endsection
