<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Auth;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{


    public function index()
    {
        return view('register',['msg' => ""]);
    }

    public function checkregister(Request $request)
    {
        $this->validate($request,[
            'username' => 'required|unique:users,username',
            'email'=> 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:5'
        ]);

        User::create([
            'username' => $request->username,
            'email'=> $request->email,
            'password' => Hash::make($request->password)
        ])->checklastpass($request->password);



        return redirect('login');
    }
}
