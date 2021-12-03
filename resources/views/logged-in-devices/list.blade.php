@extends('layouts')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between float-right">
            <a href="{{ count($devices) > 1 ? '/logout/all' : '#' }}"
               class="btn btn-danger {{ count($devices) == 1 ? 'disabled' : '' }}">Remove All Devices</a>
        </div>
        @foreach ($devices as $device)
            <div class="card m-1" style="max-width: 540px;">
                <div class="row no-gutters">
                    <div class="col-md-2">
                        <div class="img-download m-2">

                            <!-- image of dog -->
                            <i class="fa fa-desktop" style="font-size:70px"></i>

                            <!-- download icon -->
                            @if ($current_session_id != $device->id)
                                <a href="/logout/{{$device->id}}">
                                    <i class="fa fa-close" style="font-size:15px;color:red;"></i>
                                </a>
                            @endif


                        </div>
                    </div>
                    <div class="col-md-8">
                        <div>
                            <p>{{$devicesdetails[$loop->index]->browserFamily()}}
                                {{$devicesdetails[$loop->index]->browserVersion()}}
                                {{$devicesdetails[$loop->index]->platformFamily()}}
                                {{$devicesdetails[$loop->index]->platformVersion()}}

                                <br>
                                <small class="text-muted">{{ $device->ip_address }}</small><br>
                                <small
                                    class="text-muted">{{ Carbon\Carbon::parse($device->last_activity)->diffForHumans() }}</small>
                            </p>

                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
