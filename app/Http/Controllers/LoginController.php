<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Auth;

use Illuminate\Support\Facades\Password;

use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use App\Models\User;

use DB;

use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function index()
    {
        return view('login',['msg' => ""]);
    }

    public function checklogin(Request $request)
    {

            $this->validate($request,[
            'username' => 'required',
            'password' => 'required|min:5'
        ]);

        $userdata = array(
            'username' => $request->get('username'),
            'password' => $request->get('password')
        );

        if(auth()->attempt($userdata)){
            //$request->session()->regenerate();
            return redirect ('login/successlogin');
        }
        else{
            return back()->with('error' , 'yanlış login');
        }
    }

    public function successlogin()
    {
       // return view ('successlogin');
        return redirect ('post');
    }

        public function logout()
        {
            Auth::logout();
            return redirect('login');
        }



    public function passforgot() {
        return view('auth.forgot-password');
    }


    public function passforgotwithrequest(Request $request) {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with(['status' => __($status)])
            : back()->withErrors(['email' => __($status)]);
    }


    public function passresetwithtoken($token,Request $request) {
        return view('auth.reset-password', ['token' => $token,'email'=>$request->email]);
    }

    public function passreset(Request $request) {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:5',
        ]);

        $user = User::where('email',$request->email)->first();
        //$user = User::find();


        if($user->checklastpass($request->password)){
            throw ValidationException::withMessages(['lastthirdpass' => 'Son 3den birisi yeni şifreniz olamaz']);
        }

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) use ($request) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );
        if($status == Password::PASSWORD_RESET){
            \DB::table('sessions')
                ->where('user_id', $user->id)
                ->where('id', '!=', \Session::getId())->delete();
            return redirect()->route('login')->with('status', __($status));

        }else{
            return  back()->withErrors(['email' => [__($status)]]);
        }

    }
    /*
        public function login(Request $request)
        {
            /*
            dd($request);

            if(isset($_GET['username'])&&isset($_GET['pass'])){
                $username = $_GET['username'];
                $pass = $_GET['pass'];
                $msg="";
                $checker = DB::select('select password from users where name = ?', [$username]);
                if($checker[0]->password == $pass) {
                    $msg = "giriş başarılı ";
                }else{
                    $msg = "giriş başarısız ";
                }
                return view('login', ['msg' => $msg]);
            }
            else{
                return view('login',['msg' => ""]);
            }


        }*/
}
