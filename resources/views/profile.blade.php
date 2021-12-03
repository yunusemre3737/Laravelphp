@extends('layouts')


@section('content')


    @forelse ($errors->all() as $error)
        <div class="alert alert-danger">
            <ul>
                <li>{{ $error }}</li>
            </ul>
        </div>
    @empty
    @endforelse



    <div class="jumbotron">

        <h5 class="display-5">Avatar İşlemleri</h5>

        <form action="{{route('profile.changeavatar')}}" method="POST" enctype="multipart/form-data">
            @csrf

            @if($user->avatar_adress!=null)
                <div class="mb-3">
                    <a href="http://127.0.0.1:8000/images/{{$user->avatar_adress}}">
                        <img src="http://127.0.0.1:8000/images/{{$user->avatar_adress}}" width="80" height="80">
                    </a>

                    <a href="{{route('profile.deleteavatar')}}" class="btn btn-danger">Foto Sil</a>
                </div>
            @endif
            <div class="custom-file mb-3">
                <input type="file" class="custom-file-input" id="input_img" name="input_img">
                <label class="custom-file-label" for="input_img">Dosya Seç (JPEG,PNG,JPG,GIF)</label>
            </div>
            @if(session()->has('success_avatar'))
                <div class="alert alert-success">
                    {{ session()->get('success_avatar') }}
                </div>
            @endif
            <div class="alert alert-danger" id="messagefilediv" style="visibility:hidden ">
                <span id='messagefile'></span>
            </div>

            <div class="mt-3">
                <button type="submit" id="submitfile" class="btn btn-primary btn-lg col-sm-2" disabled>Avatar Değiştir
                </button>
            </div>
        </form>

        <hr class="my-4">

        <h5 class="display-5">Şifre İşlemleri</h5>


        <form method="POST" action="{{route('profile.changepass')}}">
            <div class="row ">
                <div class="col-sm-2 lead">Şifre değişimi :</div>
                @csrf
                <div class="col-sm-8">
                    <label class="lead" for="current_password">Eski Şifre:</label>
                    <input type="password" class="form-control" id="current_password" name="current_password">

                    <label class="lead" for="password">Yeni Şifre:</label>
                    <input type="password" class="form-control" id="password" name="password" onkeyup='check();'>

                    <label class="lead" for="password_confirmation">Yeni Şifre Tekrar:</label>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation"
                           onkeyup='check();'>
                    <span id='messagepass'></span>
                </div>

                <div class="blockquote-footer m-3">
                    Last update
                    {{\Carbon\Carbon::parse($user->updated_at)->diffForHumans() }}

                </div>
                @if(session()->has('success_pass'))
                    <div class="alert alert-success">
                        {{ session()->get('success_pass') }}
                    </div>
                @endif

            </div>
            <div class="d-flex justify-content-between">
                <input class="btn btn-primary btn-lg col-sm-2" type="submit" id="submit" value="Şifre Güncelle">

            </div>
        </form>
        <hr class="my-4">
        <h5 class="display-5">Oturum İşlemleri</h5>
        <div class="float-right">
            <a href="{{ count($devices) > 1 ? '/logout/all' : '#' }}"
               class="btn btn-danger {{ count($devices) == 1 ? 'disabled' : '' }}">Remove All Devices</a>
        </div>
        <div class="row">

            <div class="col-sm-3 lead">Oturum İşlemleri :</div>
            <div class="col-sm-8">

                @foreach ($devices as $device)
                    <div class="card m-1" style="max-width: 540px;">
                        <div class="row no-gutters">
                            <div class="col-md-2">

                                    <span class="images_wrapper m-1">
                                    @if($result[$loop->index]->isDesktop())
                                            <i class="fa fa-desktop d-flex justify-content-center m-1"
                                               style="font-size:70px;"></i>
                                        @endif
                                        @if($result[$loop->index]->isTablet())
                                            <i class="fa fa-tablet-alt d-flex justify-content-center m-1"
                                               style="font-size:70px;"></i>
                                        @endif
                                        @if($result[$loop->index]->isMobile())
                                            <i class="fa fa-mobile-alt  d-flex justify-content-center m-1"
                                               style="font-size:70px;"></i>
                                        @endif

                                    <!-- image of dog -->
                                        @switch($result[$loop->index]->platformFamily())
                                            @case("Android")
                                            <i class="fab fa-android"></i>
                                            @break

                                            @case("iOS")
                                            <i class="fab fa-apple"></i>
                                            @break

                                            @default
                                                @switch($result[$loop->index]->browserFamily())
                                                    @case("Opera")
                                                    <i class="fab fa-opera"></i>
                                                    @break

                                                    @case("Chrome")
                                                    <i class="fab fa-chrome"></i>
                                                    @break

                                                    @case("Firefox")
                                                    <i class="fab fa-firefox"></i>
                                                    @break

                                                    @case("Safari")
                                                    <i class="fab fa-safari"></i>
                                                    @break

                                                    @case("Microsoft Edge")
                                                    <i class="fab fa-edge"></i>
                                                    @break

                                                    @case("Internet Explorer")
                                                    <i class="fab fa-internet-explorer"></i>
                                                    @break

                                                    @default
                                                    <i class="fab fa-question"></i>
                                                @endswitch


                                        @endswitch


                                    <!-- download icon -->
                                        @if ($current_session_id != $device->id)
                                            <a href="/logout/{{$device->id}}">
                                            <i class="fa fa-close"></i>

                                        </a>
                                        @endif
                                    </span>

                            </div>

                            <div class="col-md-8">
                                <div>
                                    <p>{{$result[$loop->index]->browserFamily()}}
                                        {{$result[$loop->index]->browserVersion()}}
                                        {{$result[$loop->index]->platformFamily()}}
                                        {{$result[$loop->index]->platformVersion()}}
                                        @if($result[$loop->index]->deviceModel()!=null)
                                            {{$result[$loop->index]->deviceModel()}}
                                        @endif<br>
                                        @if ($current_session_id == $device->id)
                                            <small class="text-muted">{{ $device->ip_address }} (This device)</small>
                                            <br>
                                        @else
                                            <small class="text-muted">{{ $device->ip_address }}</small><br>
                                        @endif

                                        <small
                                            class="text-muted">{{ Carbon\Carbon::parse($device->last_activity)->diffForHumans() }}</small>
                                    </p>

                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>

        <hr class="my-4">

    </div>
    <script>
        $('#input_img').bind('change', function () {
            if (this.files[0].size > 5368709) {
                document.getElementById("submitfile").disabled = true;
                document.getElementById('messagefile').innerHTML = 'Boyut bu işlem için çok büyük...';
                document.getElementById('messagefilediv').style.visibility = "visible";
            } else {
                document.getElementById("submitfile").disabled = false;
                document.getElementById('messagefile').innerHTML = '';
                document.getElementById('messagefilediv').style.visibility = "hidden";
            }
            var file = $(this).val().split('.').pop();
            var types = ["jpeg", "png", "jpg", "gif"];
            if (types.indexOf(file) != -1) {
                document.getElementById("submitfile").disabled = false;
                document.getElementById('messagefile').innerHTML = '';
                document.getElementById('messagefilediv').style.visibility = "hidden";

            } else {
                document.getElementById("submitfile").disabled = true;
                document.getElementById('messagefile').innerHTML = 'Dosya türü desteklenene formatlardan değil!';
                document.getElementById('messagefilediv').style.visibility = "visible";
            }

        });


    </script>
    <script>
        // Add the following code if you want the name of the file appear on select
        $(".custom-file-input").on("change", function () {
            var fileName = $(this).val().split("\\").pop();
            $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
        });


    </script>

    <script>

        var check = function () {
            if (document.getElementById('password').value ==
                document.getElementById('password_confirmation').value) {
                document.getElementById('messagepass').style.color = 'green';
                document.getElementById('messagepass').innerHTML = 'matching';
                document.getElementById("submit").disabled = false;
            } else {
                document.getElementById('messagepass').style.color = 'red';
                document.getElementById('messagepass').innerHTML = 'not matching';
                document.getElementById("submit").disabled = true;
            }
        }
    </script>
@endsection
