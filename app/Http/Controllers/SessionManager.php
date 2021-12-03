<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Browser;

class SessionManager extends Controller
{


    public function index()
    {

        Browser::detect();

        $devices = \DB::table('sessions')
            ->where('user_id', \Auth::user()->id)
            ->get();

        $result = [];
        foreach ($devices as $device){
            $result[] = Browser::parse($device->user_agent);
        }

        return $result;
        return view('logged-in-devices.list')
            ->with('devices', $devices)->with('devicesdetails',$result)
            ->with('current_session_id', \Session::getId());
    }


    /**
     * Logout a session based on session id.
     *
     * @return \Illuminate\Http\Response
     */
    public function logoutDevice(Request $request, $device_id)
    {

        \DB::table('sessions')
            ->where('id', $device_id)->delete();

        return redirect('/profile');
    }



    /**
     * Logouts a user from all other devices except the current one.
     *
     * @return \Illuminate\Http\Response
     */
    public function logoutAllDevices(Request $request)
    {
        \DB::table('sessions')
            ->where('user_id', \Auth::user()->id)
            ->where('id', '!=', \Session::getId())->delete();

        return redirect('/profile');
    }
}
