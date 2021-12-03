@extends('layouts')


@section('content')
    <div>

        <div class="panel-body">
            <form class="form-horizontal" role="form" method="POST" action="{{route('post.store') }}">
                @csrf

                <div>
                    <label for="username" class="col-md-4 control-label" name="username">Hello
                        asdasd, {{Auth::user()->username}}</label>
                </div>

                <div>
                    <label class="col-md-4 control-label">Please feel free to give your opinion about us here</label>
                </div>
                <div>
                    <label class=" control-label">Title : </label>
                    <input name="title" class="input">
                </div>
                <div>
                    <textarea name="content" cols="50" rows="20"></textarea>
                </div>

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
    </div>
    </div>
    </div>
@endsection
